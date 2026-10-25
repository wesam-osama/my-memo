<?php

namespace App\Exceptions;

use App\Http\Responses\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (Throwable $e, Request $request) {
            if (!$request->is('api/*') && !$request->expectsJson()) {
                return null;
            }

            return match (true) {
                $e instanceof ValidationException => ApiResponse::validationError(
                    $e->errors(),
                    $e->getMessage()
                ),
                $e instanceof AuthenticationException => ApiResponse::unauthorized(
                    $e->getMessage() ?: 'Unauthenticated'
                ),
                $e instanceof AuthorizationException => ApiResponse::forbidden(
                    $e->getMessage() ?: 'Forbidden'
                ),
                $e instanceof ModelNotFoundException,
                $e instanceof NotFoundHttpException => ApiResponse::notFound(
                    'Resource not found'
                ),
                $e instanceof HttpExceptionInterface => ApiResponse::error(
                    $e->getMessage() ?: 'HTTP error',
                    $e->getStatusCode()
                ),
                default => ApiResponse::serverError(
                    config('app.debug') ? $e->getMessage() : 'Internal server error',
                    config('app.debug') ? [
                        'exception' => get_class($e),
                        'file'      => $e->getFile(),
                        'line'      => $e->getLine(),
                        'trace'     => collect($e->getTrace())->take(10),
                    ] : null
                ),
            };
        });
    }
}