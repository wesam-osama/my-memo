<?php

namespace App\Http\Controllers\Auth;

use App\Frontend\Api\BaseApi;
use App\Frontend\Api\CandidateAPI;
use App\Frontend\Auth\ApiSession;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function create(Request $request)
    {
        return view('auth.register', ['accountType' => $this->accountType($request)]);
    }

    public function store(Request $request, CandidateAPI $candidateApi)
    {
        $accountType = $this->accountType($request);

        // light checks only; the backend is the one that checks e-mail uniqueness, etc.
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        $data['password_confirmation'] = $request->input('password_confirmation');

        if ($accountType !== 'candidate') {
            throw ValidationException::withMessages(['email' => 'The company portal is not connected to the server yet.']);
        }

        $res = $candidateApi->register($data);

        if (! $res['ok']) {
            throw ValidationException::withMessages(BaseApi::errorMessages($res, 'email'));
        }

        // If the backend logs the user in on register it returns a token; otherwise send them to login.
        $payload = (array) $res['data'];
        $token   = Arr::get($payload, 'token') ?? Arr::get($payload, 'access_token');

        if ($token) {
            $request->session()->regenerate();
            ApiSession::store($token, (array) (Arr::get($payload, 'user') ?? Arr::get($payload, 'candidate') ?? []) + ['account_type' => $accountType]);

            return redirect()->route('hall.lobby');
        }

        return redirect()->route('candidate.login')->with('status', $res['message'] ?: 'Account created. Please log in.');
    }

    private function accountType(Request $request): string
    {
        return str_contains((string) $request->route()->getPrefix(), 'company') ? 'company' : 'candidate';
    }
}
