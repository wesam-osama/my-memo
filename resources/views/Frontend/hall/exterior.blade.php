@extends('layouts.hall')
@section('title', 'TalentBridge | Connecting Talent')

@section('content')
    <x-hall-scene :scene="config('hall.exterior')">

        {{-- Background overlay --}}
        <div
            class="pointer-events-none absolute inset-0 z-[1] bg-gradient-to-b from-slate-950/60 via-slate-950/10 to-slate-950/45">
        </div>

        {{-- Header --}}
        <header class="absolute inset-x-0 top-0 z-30 flex items-center justify-between px-[5%] py-[2%]">
            <a href="{{ route('hall.exterior') }}" class="flex items-center gap-3 text-white no-underline">

                {{-- Temporary logo mark --}}
                <span
                    class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-sky-400 to-teal-400 text-xl font-black text-slate-950 shadow-lg">
                    T
                </span>

                <span class="font-extrabold tracking-tight drop-shadow" style="font-size: clamp(18px, 2cqw, 30px)">
                    Talent<span class="text-teal-300">Bridge</span>
                </span>
            </a>

            <div class="flex items-center gap-2">
                @guest
                    <x-button variant="ghost" href="{{ route('candidate.login') }}">Log in</x-button>
                    <x-button variant="cta" href="{{ route('candidate.register') }}">Sign up</x-button>
                @endguest

                @auth
                    <x-button variant="cta" href="{{ route('hall.lobby') }}">
                        Enter the Hall
                    </x-button>
                @endauth
            </div>
        </header>

        {{-- Main welcome message --}}
        <div class="pointer-events-none absolute inset-x-0 top-[13%] z-10 flex justify-center px-[4%]">
            <div class="w-[76%] max-w-4xl rounded-2xl border border-white/15 bg-slate-950/65 text-center text-white shadow-2xl backdrop-blur-md"
                style="padding: clamp(12px, 1.7cqw, 26px)">

                <p class="font-bold uppercase tracking-[0.25em] text-teal-300" style="font-size: clamp(9px, 0.9cqw, 14px)">
                    Welcome to TalentBridge
                </p>

                <h1 class="mt-2 font-extrabold leading-tight" style="font-size: clamp(22px, 3cqw, 46px)">
                    Where Talent Meets Opportunity
                </h1>

                <p class="mt-2 text-white/90" style="font-size: clamp(12px, 1.3cqw, 19px)">
                    Connecting talented people with companies that help them grow.
                </p>
            </div>
        </div>

        {{-- Candidate and company information --}}
        <div class="absolute inset-x-0 top-[44%] z-10 flex justify-center px-[3%]">
            <div class="grid w-full max-w-5xl grid-cols-2 gap-3 md:gap-8">

                {{-- Candidates --}}
                <div
                    class="rounded-2xl border border-sky-300/30 bg-slate-950/65 p-3 text-center text-white shadow-xl backdrop-blur-md md:p-5">
                    <div
                        class="mx-auto mb-2 grid h-10 w-10 place-items-center rounded-xl bg-sky-400/15 text-sky-300 md:h-14 md:w-14">
                        <svg viewBox="0 0 24 24" class="h-6 w-6 md:h-8 md:w-8" fill="none" stroke="currentColor"
                            stroke-width="1.8" aria-hidden="true">
                            <circle cx="10" cy="8" r="4" />
                            <path d="M3 21v-2a7 7 0 0 1 14 0v2" />
                            <circle cx="18" cy="9" r="2.5" />
                            <path d="M19 15a5 5 0 0 1 3 4v2" />
                        </svg>
                    </div>

                    <h2 class="font-bold text-sky-300" style="font-size: clamp(13px, 1.5cqw, 22px)">
                        For Candidates
                    </h2>

                    <p class="mt-1 text-white/90" style="font-size: clamp(10px, 1cqw, 15px)">
                        Discover job opportunities
                    </p>

                    <p class="mt-1 text-white/70" style="font-size: clamp(9px, 0.85cqw, 13px)">
                        Explore careers and connect with employers.
                    </p>
                </div>

                {{-- Companies --}}
                <div
                    class="rounded-2xl border border-teal-300/30 bg-slate-950/65 p-3 text-center text-white shadow-xl backdrop-blur-md md:p-5">
                    <div
                        class="mx-auto mb-2 grid h-10 w-10 place-items-center rounded-xl bg-teal-400/15 text-teal-300 md:h-14 md:w-14">
                        <svg viewBox="0 0 24 24" class="h-6 w-6 md:h-8 md:w-8" fill="none" stroke="currentColor"
                            stroke-width="1.8" aria-hidden="true">
                            <rect x="3" y="7" width="18" height="14" rx="2" />
                            <path d="M8 7V4h8v3M3 12h18M10 12v3h4v-3" />
                        </svg>
                    </div>

                    <h2 class="font-bold text-teal-300" style="font-size: clamp(13px, 1.5cqw, 22px)">
                        For Companies
                    </h2>

                    <p class="mt-1 text-white/90" style="font-size: clamp(10px, 1cqw, 15px)">
                        Find the right talent
                    </p>

                    <p class="mt-1 text-white/70" style="font-size: clamp(9px, 0.85cqw, 13px)">
                        Reach candidates and manage applications.
                    </p>
                </div>

            </div>
        </div>

        {{-- Entrance instruction --}}
        <div class="pointer-events-none absolute inset-x-0 bottom-[5%] z-10 flex justify-center px-4">
            <p class="rounded-full border border-white/20 bg-slate-950/70 px-5 py-2 text-center font-semibold text-white shadow-lg backdrop-blur-md"
                style="font-size: clamp(11px, 1.1cqw, 16px)">
                @guest Log in or sign up, then click the entrance to explore ↓ @endguest
                @auth Click the entrance below to explore TalentBridge ↓ @endauth
            </p>
        </div>

    </x-hall-scene>
@endsection
