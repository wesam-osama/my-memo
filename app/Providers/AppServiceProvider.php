<?php

namespace App\Providers;

use App\Frontend\Auth\ApiSession;
use Illuminate\Auth\GenericUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // "Who is logged in?" comes from the token + user stored in the session by the API login,
        // NOT from the database. This keeps auth()->user(), @auth, @guest and the `auth` middleware working.
        Auth::viaRequest('api-session', function (Request $request) {
            if (! ApiSession::check()) {
                return null;
            }

            return new GenericUser(ApiSession::user());
        });
    }
}
