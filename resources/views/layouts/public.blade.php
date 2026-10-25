@php
    $locale = str_replace('_', '-', app()->getLocale());
    $isRtl = in_array(app()->getLocale(), ['ar'], true);
    $authUser = auth()->user();
    $dashboardRoute = match ($authUser?->account_type) {
        'company' => 'frontend.company.dashboard',
        'admin' => 'frontend.dashboard',
        default => 'frontend.candidate.dashboard',
    };
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TalentBridge') | TalentBridge</title>

    @include('partials.theme-boot')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.js-i18n')
    @stack('head')
</head>
<body class="min-h-screen bg-hb-surface text-hb-text">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:start-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-hb-blue focus:px-3 focus:py-2 focus:text-white">
        {{ __('common.skip_to_content') }}
    </a>

    <header class="sticky top-0 z-40 isolate border-b border-hb-border/80 bg-hb-surface/95 backdrop-blur">
        <div class="hb-container flex h-[88px] items-center justify-between gap-6">
            <a href="{{ route('frontend.home') }}" class="flex shrink-0 items-center gap-2.5" aria-label="TalentBridge home">
                @include('partials.brand-logo', ['onDark' => false])
            </a>

            <nav class="hidden items-center gap-8 md:flex" aria-label="{{ __('navigation.primary') }}">
                <a href="{{ route('frontend.jobs.index') }}" @class(['hb-nav-link', 'text-hb-blue' => request()->routeIs('frontend.jobs.*')])>{{ __('navigation.find_job') }}</a>
                <a href="{{ route('frontend.about') }}" @class(['hb-nav-link', 'text-hb-blue' => request()->routeIs('frontend.about')])>About</a>
                <a href="{{ route('frontend.contact') }}" @class(['hb-nav-link', 'text-hb-blue' => request()->routeIs('frontend.contact')])>{{ __('navigation.contact') }}</a>
            </nav>

            <div class="flex items-center gap-2 sm:gap-3">
                @include('partials.theme-switch')

                @guest
                    <a href="{{ route('frontend.account.login') }}" class="hb-btn-ghost hidden sm:inline-flex">Sign in</a>
                    <a href="{{ route('frontend.account.register') }}" class="hb-btn-primary">Get started</a>
                @endguest
                @auth
                    <a href="{{ route($dashboardRoute) }}" class="hb-btn-primary">My workspace</a>
                @endauth

                <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-hb-border md:hidden"
                        data-public-nav-toggle aria-expanded="false" aria-controls="public-mobile-nav" aria-label="{{ __('common.open_menu') }}">
                    <span class="block h-0.5 w-4 bg-hb-text"></span>
                </button>
            </div>
        </div>

        <nav id="public-mobile-nav" class="hidden border-t border-hb-border md:hidden" aria-label="{{ __('navigation.mobile') }}">
            <div class="hb-container flex flex-col gap-3 py-4">
                <a href="{{ route('frontend.jobs.index') }}" class="hb-nav-link py-1">{{ __('navigation.find_job') }}</a>
                <a href="{{ route('frontend.about') }}" class="hb-nav-link py-1">About</a>
                <a href="{{ route('frontend.contact') }}" class="hb-nav-link py-1">{{ __('navigation.contact') }}</a>
                @guest
                    <a href="{{ route('frontend.account.login') }}" class="hb-nav-link py-1 sm:hidden">Sign in</a>
                @endguest
            </div>
        </nav>
    </header>

    <main id="main-content">
        @yield('content')
    </main>

    <footer class="border-t border-hb-border bg-hb-page">
        <div class="hb-container flex flex-col gap-3 py-8 text-xs text-hb-muted sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} TalentBridge. All rights reserved.</p>
            <div class="flex gap-5">
                <a href="{{ route('frontend.jobs.index') }}" class="hover:text-hb-blue">{{ __('navigation.find_job') }}</a>
                <a href="{{ route('frontend.about') }}" class="hover:text-hb-blue">About</a>
                <a href="{{ route('frontend.contact') }}" class="hover:text-hb-blue">{{ __('navigation.contact') }}</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
