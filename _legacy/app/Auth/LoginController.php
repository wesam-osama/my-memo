<?php

namespace App\Http\Controllers\Auth;

use App\Frontend\Api\BaseApi;
use App\Frontend\Api\CandidateAPI;
use App\Frontend\Auth\ApiSession;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create(Request $request)
    {
        return view('auth.login', ['accountType' => $this->accountType($request)]);
    }

    public function store(Request $request, CandidateAPI $candidateApi)
    {
        $accountType = $this->accountType($request);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // only the candidate API exists so far; company / interviewer / admin get their own class later
        if ($accountType !== 'candidate') {
            throw ValidationException::withMessages(['email' => 'The company portal is not connected to the server yet.']);
        }

        $res = $candidateApi->login($credentials);

        if (! $res['ok']) {
            throw ValidationException::withMessages(BaseApi::errorMessages($res, 'email'));
        }

        // The backend's login response shape (adjust here if yours differs):
        //   data: { token: "...", user: { id, name, email, account_type, account_status } }
        $data = (array) $res['data'];
        $token = Arr::get($data, 'token') ?? Arr::get($data, 'access_token') ?? Arr::get($data, 'plain_text_token');
        $user = (array) (Arr::get($data, 'user') ?? Arr::get($data, 'candidate') ?? []);

        if (! $token) {
            throw ValidationException::withMessages(['email' => 'The server did not return an access token.']);
        }
        if (($user['account_status'] ?? 'active') !== 'active') {
            throw ValidationException::withMessages(['email' => 'Your account is not active.']);
        }

        $request->session()->regenerate();
        ApiSession::store($token, $user + ['account_type' => $accountType]);

        return redirect()->intended(route('hall.lobby'));
    }

    public function destroy(Request $request, CandidateAPI $candidateApi)
    {
        if (ApiSession::token()) {
            $candidateApi->logout();   // best effort: even if the server is down we still log out locally
        }

        ApiSession::forget();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('hall.exterior');
    }

    private function accountType(Request $request): string
    {
        return str_contains((string) $request->route()->getPrefix(), 'company') ? 'company' : 'candidate';
    }
}
