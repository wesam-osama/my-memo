<?php

namespace App\Frontend\Api;

use InvalidArgumentException;
use JsonException;

/**
 * CurlClient — a cURL-flavoured global API request class.
 * Always returns an ApiResponse (or throws ApiError on failure).
 *
 * Usage:
 *   $res = $api->reset()
 *       ->method('POST')
 *       ->url('/users')
 *       ->bearer($token)
 *       ->data(['name' => 'John'])
 *       ->send();
 *
 *   if ($res->ok()) {
 *       echo $res->data['id'];
 *   }
 */
class CurlClient
{
    private string $baseUrl;
    private string $tokenKey = 'auth_token';

    // Per-request state
    private string $url = '';
    private string $method = 'GET';
    private array  $headers = [];
    private array  $query = [];
    private mixed  $body = null;
    private ?array $form = null;
    private int    $timeout = 30;
    private int    $retries = 0;
    private int    $retryDelay = 500;
    private bool   $verifySsl = true;
    private ?string $token = null;
    private ?array $basicAuth = null;
    private array  $cookies = [];
    private ?string $cookieFile = null;

    public function __construct(string $baseUrl = '', array $defaults = [])
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->headers = array_merge([
            'Accept'           => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ], $defaults['headers'] ?? []);

        if (isset($defaults['token_key'])) {
            $this->tokenKey = $defaults['token_key'];
        }
    }

    // ─────────────────────────────────────────────
    //  Token management
    // ─────────────────────────────────────────────
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function token(): ?string
    {
        return $this->token;
    }

    public function clearToken(): self
    {
        $this->token = null;
        return $this;
    }

    // ─────────────────────────────────────────────
    //  Fluent configuration
    // ─────────────────────────────────────────────
    public function reset(): self
    {
        $this->url        = '';
        $this->method     = 'GET';
        $this->query      = [];
        $this->body       = null;
        $this->form       = null;
        $this->timeout    = 30;
        $this->retries    = 0;
        $this->retryDelay = 500;
        $this->basicAuth  = null;
        // Preserve headers set at construction, but clear per-request ones
        $this->headers = array_filter(
            $this->headers,
            fn ($k) => !in_array($k, ['Content-Type', 'Authorization'], true),
            ARRAY_FILTER_USE_KEY
        );
        return $this;
    }

    /** -X */
    public function method(string $m): self
    {
        $this->method = strtoupper($m);
        return $this;
    }

    /** URL (relative or absolute) */
    public function url(string $u): self
    {
        $this->url = $u;
        return $this;
    }

    /** -H */
    public function header(string $k, string $v): self
    {
        $this->headers[$k] = $v;
        return $this;
    }

    public function headers(array $h): self
    {
        $this->headers = array_merge($this->headers, $h);
        return $this;
    }

    /** Bearer token */
    public function bearer(?string $token = null): self
    {
        $this->headers['Authorization'] = 'Bearer ' . ($token ?? $this->token ?? '');
        return $this;
    }

    /** -u Basic auth */
    public function basic(string $username, string $password): self
    {
        $this->basicAuth = [$username, $password];
        return $this;
    }

    /** -G --data-urlencode */
    public function query(array $params): self
    {
        $this->query = array_merge($this->query, $params);
        return $this;
    }

    /** -d JSON body */
    public function data(mixed $payload): self
    {
        $this->body = $payload;
        if (!isset($this->headers['Content-Type'])) {
            $this->headers['Content-Type'] = 'application/json';
        }
        return $this;
    }

    /** -F multipart */
    public function form(array $fields): self
    {
        $this->form = $fields;
        unset($this->headers['Content-Type']); // cURL sets boundary
        return $this;
    }

    /** --max-time */
    public function timeout(int $seconds): self
    {
        $this->timeout = $seconds;
        return $this;
    }

    /** --retry */
    public function retries(int $count, int $delayMs = 500): self
    {
        $this->retries = $count;
        $this->retryDelay = $delayMs;
        return $this;
    }

    /** -k / --insecure */
    public function insecure(): self
    {
        $this->verifySsl = false;
        return $this;
    }

    /** -b / --cookie */
    public function cookie(string $name, string $value): self
    {
        $this->cookies[$name] = $value;
        return $this;
    }

    /** Cookie jar file */
    public function cookieFile(string $path): self
    {
        $this->cookieFile = $path;
        return $this;
    }

    // ─────────────────────────────────────────────
    //  Verb shortcuts — all return ApiResponse
    // ─────────────────────────────────────────────
    public function get(string $url, array $query = []): ApiResponse
    {
        return $this->reset()->method('GET')->url($url)->query($query)->send();
    }

    public function post(string $url, mixed $data = null): ApiResponse
    {
        return $this->reset()->method('POST')->url($url)->data($data)->send();
    }

    public function put(string $url, mixed $data = null): ApiResponse
    {
        return $this->reset()->method('PUT')->url($url)->data($data)->send();
    }

    public function patch(string $url, mixed $data = null): ApiResponse
    {
        return $this->reset()->method('PATCH')->url($url)->data($data)->send();
    }

    public function delete(string $url, array $query = []): ApiResponse
    {
        return $this->reset()->method('DELETE')->url($url)->query($query)->send();
    }

    public function upload(string $url, array $files): ApiResponse
    {
        return $this->reset()->method('POST')->url($url)->form($files)->send();
    }

    // ─────────────────────────────────────────────
    //  Core execution
    // ─────────────────────────────────────────────
    public function send(): ApiResponse
    {
        $attempt = 0;
        while (true) {
            try {
                return $this->executeOnce();
            } catch (ApiError $e) {
                if ($attempt < $this->retries && $e->isServerError()) {
                    $attempt++;
                    usleep($this->retryDelay * 1000 * $attempt);
                    continue;
                }
                throw $e;
            }
        }
    }

    private function executeOnce(): ApiResponse
    {
        $ch = curl_init();

        $fullUrl = $this->buildUrl();

        // --- Headers ---
        $headerLines = [];
        foreach ($this->headers as $k => $v) {
            $headerLines[] = "{$k}: {$v}";
        }
        if ($this->cookies) {
            $headerLines[] = 'Cookie: ' . http_build_query($this->cookies, '', '; ');
        }
        if ($this->basicAuth) {
            // Handle Basic separately via CURLOPT_USERPWD for correctness
            curl_setopt($ch, CURLOPT_USERPWD, "{$this->basicAuth[0]}:{$this->basicAuth[1]}");
        }

        // --- Options ---
        curl_setopt_array($ch, [
            CURLOPT_URL            => $fullUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => true,          // we parse status
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_SSL_VERIFYPEER => $this->verifySsl,
            CURLOPT_SSL_VERIFYHOST => $this->verifySsl ? 2 : 0,
            CURLOPT_HTTPHEADER     => $headerLines,
            CURLOPT_CUSTOMREQUEST  => $this->method,
            CURLOPT_ENCODING       => '',            // accept gzip/deflate
        ]);

        // Cookie jar
        if ($this->cookieFile) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
        }

        // --- Body ---
        if ($this->form !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->prepareForm($this->form));
        } elseif ($this->body !== null) {
            try {
                $payload = is_string($this->body)
                    ? $this->body
                    : json_encode($this->body, JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                throw new ApiError('Failed to encode JSON body: ' . $e->getMessage(), 0, null, $e);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }

        // --- Execute ---
        $raw = curl_exec($ch);

        if ($raw === false) {
            $errno  = curl_errno($ch);
            $errmsg = curl_error($ch);
            curl_close($ch);
            $status = $errno === 28 ? 408 : 0;
            throw new ApiError("cURL error [{$errno}]: {$errmsg}", $status);
        }

        $statusCode  = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $headerSize  = (int) curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);

        $body = substr($raw, $headerSize);

        // --- 204 No Content ---
        if ($statusCode === 204) {
            return new ApiResponse(true, 'No content', null, null, null, null, 204);
        }

        // --- Parse JSON ---
        $json = null;
        if ($body !== '' && $body !== false) {
            try {
                $json = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException) {
                $json = null; // fall back to plain text
            }
        }

        // If backend didn't return envelope (raw payload), wrap it
        if (!is_array($json) || !array_key_exists('success', $json)) {
            $json = [
                'success' => $statusCode >= 200 && $statusCode < 300,
                'message' => $statusCode >= 400 ? "HTTP {$statusCode}" : 'OK',
                'data'    => $json ?? $body,
            ];
        }

        $envelope = ApiResponse::fromJson($json, $statusCode);

        if ($statusCode >= 400) {
            throw new ApiError(
                $envelope->message ?: "HTTP {$statusCode}",
                $statusCode,
                $envelope
            );
        }

        return $envelope;
    }

    // ─────────────────────────────────────────────
    //  Internals
    // ─────────────────────────────────────────────
    private function buildUrl(): string
    {
        if ($this->url === '') {
            throw new InvalidArgumentException('URL is required');
        }

        $isAbsolute = (bool) preg_match('#^https?://#i', $this->url);
        $base = $isAbsolute ? $this->url : $this->baseUrl . $this->url;

        if (!$this->query) {
            return $base;
        }

        // Flatten arrays → key[]=a&key[]=b
        $pairs = [];
        foreach ($this->query as $k => $v) {
            if ($v === null) continue;
            if (is_array($v)) {
                foreach ($v as $item) {
                    $pairs[] = rawurlencode("{$k}[]") . '=' . rawurlencode((string) $item);
                }
            } else {
                $pairs[] = rawurlencode($k) . '=' . rawurlencode((string) $v);
            }
        }
        $sep = str_contains($base, '?') ? '&' : '?';
        return $base . $sep . implode('&', $pairs);
    }

    /**
     * Prepare multipart form fields for cURL.
     * Accepts file paths, CURLFile objects, or scalars.
     */
    private function prepareForm(array $fields): array
    {
        $out = [];
        foreach ($fields as $k => $v) {
            if ($v instanceof \CURLFile) {
                $out[$k] = $v;
            } elseif (is_array($v) && isset($v['path'])) {
                // ['path' => '/file', 'mime' => 'image/png', 'name' => 'x.png']
                $out[$k] = new \CURLFile(
                    $v['path'],
                    $v['mime'] ?? 'application/octet-stream',
                    $v['name'] ?? basename($v['path'])
                );
            } else {
                $out[$k] = is_scalar($v) ? (string) $v : json_encode($v);
            }
        }
        return $out;
    }
}