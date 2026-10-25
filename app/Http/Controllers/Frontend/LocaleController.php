<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\SetFrontendLocale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


class LocaleController extends Controller
{
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        if (! in_array($locale, SetFrontendLocale::SUPPORTED, true)) {
            $locale = config('app.fallback_locale', 'en');
        }

        $redirectTo = url()->previous() !== url()->current()
            ? url()->previous()
            : route('frontend.home');

        return redirect()
            ->to($redirectTo)
            ->withCookie(
                Cookie::make(
                    SetFrontendLocale::COOKIE,
                    $locale,
                    60 * 24 * 365,
                    '/',
                    null,
                    $request->isSecure(),
                    false,
                    false,
                    'lax',
                )
            );
    }
}
