@extends('layouts.hall')

@section('title', 'TalentBridge | Connect Talent with Opportunity')
@section('no-nav', true)

@section('content')
@php
    $services = [
        ['label' => 'Job Opportunities', 'description' => 'Discover roles that match your skills', 'icon' => 'briefcase', 'target' => 'route:jobs.index'],
        ['label' => 'Company Recruitment', 'description' => 'Find and hire the right people', 'icon' => 'building', 'target' => 'route:workspace'],
        ['label' => 'Virtual Career Hall', 'description' => 'Explore interactive career spaces', 'icon' => 'users', 'target' => 'scene:lobby'],
        ['label' => 'Meetings & Connections', 'description' => 'Meet recruiters and professionals', 'icon' => 'calendar', 'target' => 'route:candidate.interviews.index'],
        ['label' => 'Career Lounge', 'description' => 'Chat, share, and grow together', 'icon' => 'chat', 'target' => 'route:lounge'],
        ['label' => 'Platform Assistant', 'description' => 'Get quick help along the way', 'icon' => 'bot', 'target' => 'route:assistant'],
    ];
@endphp

<style>
    /* arrival after the entrance zoom: fade in from the white flash */
    @keyframes landing-arrive { from { opacity: 0; transform: scale(1.03); } to { opacity: 1; transform: scale(1); } }
    .landing-arrive { animation: landing-arrive 1s cubic-bezier(.22, 1, .36, 1) both; }
    @media (prefers-reduced-motion: reduce) { .landing-arrive { animation: none; } }
</style>
<div id="landingRoot" class="min-h-screen overflow-hidden bg-white text-slate-900">
   

    <main>
        {{-- Hero Slider (ITIDA style) --}}
        @php
            $slides = [
                [
                    'image' => 'images/halls/talentbridge-hero.webp',
                    'title' => 'Your next opportunity starts here',
                    'text'  => 'Discover roles that match your skills and apply in minutes.',
                    'cta'   => ['label' => 'Explore Jobs', 'href' => \App\Support\Hall::url('route:jobs.index') !== '#' ? \App\Support\Hall::url('route:jobs.index') : route('frontend.account.register', ['type' => 'candidate'])],
                ],
                [
                    'image' => 'images/halls/companies.webp',
                    'title' => 'Build your team with confidence',
                    'text'  => 'Post jobs, run proctored exams and schedule interviews in one place.',
                    'cta'   => ['label' => 'For Companies', 'href' => '#companies'],
                ],
                [
                    'image' => 'images/halls/candidates.webp',
                    'title' => 'AI-powered CV matching',
                    'text'  => 'Smart screening helps recruiters focus on the best-fit candidates.',
                    'cta'   => ['label' => 'Get Started', 'href' => route('frontend.account.register', ['type' => 'candidate'])],
                ],
                [
                    'image' => 'images/halls/exterior.webp',
                    'title' => 'Meet recruiters, book interviews',
                    'text'  => 'Pick a free slot, get notified, and sync with Google or Outlook calendar.',
                    'cta'   => ['label' => 'Learn More', 'href' => '#services'],
                ],
            ];
        @endphp

        <style>
    
            @keyframes hero-zoom { from { transform: scale(1); } to { transform: scale(1.12); } }
            .hero-slide .hero-img { transform: scale(1); }
            .hero-slide.is-active .hero-img { animation: hero-zoom 8s ease-out forwards; }

           
            .hero-slide .hero-caption { opacity: 0; transform: translateX(-32px); transition: opacity .7s ease .3s, transform .7s ease .3s; }
            .hero-slide.is-active .hero-caption { opacity: 1; transform: translateX(0); }

            @media (prefers-reduced-motion: reduce) {
                .hero-slide.is-active .hero-img { animation: none; }
                .hero-slide, .hero-slide .hero-caption { transition: none !important; }
            }
        </style>

        <section id="home" class="relative isolate overflow-hidden bg-slate-900" aria-roledescription="carousel" aria-label="Featured highlights">
            <div id="heroSlider" class="relative h-[420px] sm:h-[480px] lg:h-[520px]">

                @foreach ($slides as $i => $slide)
                    <div class="hero-slide absolute inset-0 transition-opacity duration-1000 {{ $i === 0 ? 'is-active opacity-100 z-10' : 'opacity-0 z-0' }}"
                         data-slide aria-hidden="{{ $i === 0 ? 'false' : 'true' }}">

                     
                        <div class="absolute inset-0 overflow-hidden bg-gradient-to-br from-sky-700 via-sky-500 to-slate-800">
                            <img src="{{ asset($slide['image']) }}" alt="" class="hero-img h-full w-full object-cover object-center"
                                 onerror="this.style.display='none'" {{ $i > 0 ? 'loading=lazy' : '' }}>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/60 via-slate-900/20 to-transparent"></div>

                      
                        <div class="relative mx-auto flex h-full max-w-7xl items-center px-5 lg:px-8">
                            <div class="hero-caption max-w-2xl pb-16">
                                <h2 class="inline-block bg-white px-4 py-2 text-2xl font-light text-sky-600 sm:text-3xl lg:text-4xl">
                                    {{ $slide['title'] }}
                                </h2>
                                <p class="mt-3 block max-w-xl bg-sky-600 px-4 py-3 text-sm font-medium leading-6 text-white sm:text-base lg:text-lg">
                                    {{ $slide['text'] }}
                                </p>
                                <a href="{{ $slide['cta']['href'] }}"
                                   class="mt-6 inline-flex items-center gap-2 rounded-full bg-white px-7 py-3 text-sm font-bold text-slate-800 shadow-lg transition hover:bg-sky-50 hover:text-sky-600">
                                    {{ $slide['cta']['label'] }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            
                <button type="button" data-prev aria-label="Previous slide"
                        class="absolute left-3 top-1/2 z-20 -translate-y-1/2 rounded-full p-2 text-white/90 transition hover:bg-white/20 hover:text-white sm:left-8">
                    <svg class="h-9 w-9 sm:h-11 sm:w-11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="m15 5-7 7 7 7"/></svg>
                </button>
                <button type="button" data-next aria-label="Next slide"
                        class="absolute right-3 top-1/2 z-20 -translate-y-1/2 rounded-full p-2 text-white/90 transition hover:bg-white/20 hover:text-white sm:right-8">
                    <svg class="h-9 w-9 sm:h-11 sm:w-11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="m9 5 7 7-7 7"/></svg>
                </button>

              
                <div class="absolute bottom-20 left-1/2 z-20 flex -translate-x-1/2 gap-2.5 sm:bottom-24">
                    @foreach ($slides as $i => $slide)
                        <button type="button" data-dot="{{ $i }}" aria-label="Go to slide {{ $i + 1 }}"
                                class="h-3 w-3 rounded-full border border-white/70 transition {{ $i === 0 ? 'bg-sky-500 border-sky-500' : 'bg-white/60' }}"></button>
                    @endforeach
                </div>
            </div>
        </section>

        <script>
        (function () {
            const root = document.getElementById('heroSlider');
            if (!root) return;

            const slides = [...root.querySelectorAll('[data-slide]')];
            const dots   = [...root.querySelectorAll('[data-dot]')];
            const INTERVAL = 6000;
            let current = 0, timer = null;

            function show(index) {
                current = (index + slides.length) % slides.length;
                slides.forEach((s, i) => {
                    const active = i === current;
                    s.classList.toggle('is-active', active);
                    s.classList.toggle('opacity-100', active);
                    s.classList.toggle('z-10', active);
                    s.classList.toggle('opacity-0', !active);
                    s.classList.toggle('z-0', !active);
                    s.setAttribute('aria-hidden', active ? 'false' : 'true');
                });
                dots.forEach((d, i) => {
                    const active = i === current;
                    d.classList.toggle('bg-sky-500', active);
                    d.classList.toggle('border-sky-500', active);
                    d.classList.toggle('bg-white/60', !active);
                });
            }

            const next = () => show(current + 1);
            const prev = () => show(current - 1);

            function start() { stop(); timer = setInterval(next, INTERVAL); }
            function stop()  { if (timer) clearInterval(timer); timer = null; }

            root.querySelector('[data-next]').addEventListener('click', () => { next(); start(); });
            root.querySelector('[data-prev]').addEventListener('click', () => { prev(); start(); });
            dots.forEach(d => d.addEventListener('click', () => { show(+d.dataset.dot); start(); }));

           
            root.addEventListener('mouseenter', stop);
            root.addEventListener('mouseleave', start);

           
            let startX = null;
            root.addEventListener('touchstart', e => { startX = e.touches[0].clientX; stop(); }, { passive: true });
            root.addEventListener('touchend', e => {
                if (startX === null) return;
                const dx = e.changedTouches[0].clientX - startX;
                if (Math.abs(dx) > 50) dx < 0 ? next() : prev();
                startX = null; start();
            });

        
            document.addEventListener('visibilitychange', () => document.hidden ? stop() : start());

            start();
        })();
        </script>

        {{-- Icon-led services, inspired by the reference layout --}}
        <section id="services" class="relative z-20 -mt-14 bg-transparent px-5 pb-12 pt-0 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="grid grid-cols-2 gap-x-4 gap-y-7 sm:grid-cols-3 lg:grid-cols-6">
                    @foreach ($services as $service)
                            @php
                                $serviceUrl = \App\Support\Hall::url($service['target']);
                                $isSoon = !\App\Support\Hall::ready($service['target']);
                                $requiresLogin = in_array($service['target'], [
                                    'route:workspace', 'scene:lobby', 'route:candidate.interviews.index',
                                    'route:lounge', 'route:assistant',
                                ], true);
                                if ($requiresLogin && !auth()->check()) {
                                    // companies start by registering, everything else by logging in
                                    $serviceUrl = $service['target'] === 'route:workspace'
                                        ? route('frontend.account.register', ['type' => 'company'])
                                        : route('frontend.account.login');
                                    $isSoon = false;
                                }
                            @endphp
                            <a href="{{ $serviceUrl }}" class="group relative flex flex-col items-center text-center">
                                <span class="absolute left-0 right-0 top-[45px] -z-10 hidden h-1.5 bg-sky-600 sm:block"></span>
                                <span class="-mt-1 mb-4 grid h-24 w-24 place-items-center rounded-full bg-sky-500 text-white shadow-sm ring-8 ring-white transition duration-300 group-hover:-translate-y-1 group-hover:bg-sky-600 group-hover:shadow-lg group-hover:shadow-sky-500/20 sm:h-27 sm:w-27">
                                    @switch($service['icon'])
                                        @case('briefcase')
                                            <svg class="h-11 w-11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18M10 12v2h4v-2"/></svg>
                                            @break
                                        @case('building')
                                            <svg class="h-11 w-11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M9 7h2m2 0h2M9 11h2m2 0h2M9 15h2m2 0h2M10 21v-3h4v3"/></svg>
                                            @break
                                        @case('users')
                                            <svg class="h-11 w-11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                            @break
                                        @case('calendar')
                                            <svg class="h-11 w-11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18m-12 5 2 2 4-4"/></svg>
                                            @break
                                        @case('chat')
                                            <svg class="h-11 w-11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M21 11.5a7.5 7.5 0 0 1-7.5 7.5H6l-3 2v-6.5A7.5 7.5 0 1 1 21 11.5Z"/><path d="M8 11h8m-8 3h5"/></svg>
                                            @break
                                        @case('bot')
                                            <svg class="h-11 w-11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="4" y="8" width="16" height="12" rx="3"/><path d="M12 4v4m-3 5h.01M15 13h.01M9 17h6"/><circle cx="12" cy="3" r="1"/></svg>
                                            @break
                                    @endswitch
                                </span>
                                <span class="text-sm font-bold leading-5 text-slate-800 transition group-hover:text-sky-600">{{ $service['label'] }}@if ($isSoon) <span class="ml-1 rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold text-slate-500 align-middle">Soon</span>@endif</span>
                                <span class="mt-1 max-w-[170px] text-xs leading-5 text-slate-500">{{ $service['description'] }}</span>
                            </a>
                                            @endforeach
                </div>
            </div>
        </section>

        {{-- Candidate and company pathways (ITIDA-style cards) --}}
        <section class="bg-white px-5 pb-14 pt-10 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="mx-auto mb-20 max-w-2xl text-center">
                    <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-sky-600">One Platform, Two Journeys</p>
                    <h2 class="mt-3 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">Where do you want to go next?</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-500">Whether you're building your career or growing a team, TalentBridge helps you take the next step.</p>
                </div>

                <div class="mx-auto grid max-w-4xl gap-x-8 gap-y-24 md:grid-cols-2">
                    {{-- Candidates --}}
                    <article id="candidates" class="group relative flex flex-col bg-slate-100 px-7 pb-6 pt-24 text-center">
                        <span class="absolute -top-20 left-1/2 h-40 w-40 -translate-x-1/2 overflow-hidden rounded-full border-4 border-sky-600 bg-white shadow-sm">
                            <img src="{{ asset('images/halls/candidates.webp') }}" alt="Candidate exploring career opportunities" loading="lazy"
                                 class="h-full w-full object-cover object-center transition duration-700 group-hover:scale-110" onerror="this.style.display='none'">
                        </span>
                        <a href="{{ route('frontend.account.register', ['type' => 'candidate']) }}" class="text-lg font-medium leading-7 text-sky-600 hover:underline">Your Next Opportunity Starts Here</a>
                        <p class="mt-4 text-base leading-8 text-slate-800">
                            Discover roles that match your skills, take timed exams, book interviews, and move your career forward.
                        </p>
                        <div class="mt-auto flex justify-end pt-6">
                            <a href="{{ route('frontend.account.register', ['type' => 'candidate']) }}" class="inline-flex items-center gap-2 text-lg font-medium text-slate-900 transition hover:text-sky-600">
                                Join as a Candidate
                                <span class="grid h-7 w-7 place-items-center rounded-full border border-slate-500 transition group-hover:border-sky-600">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14m-5-5 5 5-5 5"/></svg>
                                </span>
                            </a>
                        </div>
                    </article>

                    {{-- Companies --}}
                    <article id="companies" class="group relative flex flex-col bg-slate-100 px-7 pb-6 pt-24 text-center">
                        <span class="absolute -top-20 left-1/2 h-40 w-40 -translate-x-1/2 overflow-hidden rounded-full border-4 border-sky-600 bg-white shadow-sm">
                            <img src="{{ asset('images/halls/companies.webp') }}" alt="Company professionals building a team" loading="lazy"
                                 class="h-full w-full object-cover object-center transition duration-700 group-hover:scale-110" onerror="this.style.display='none'">
                        </span>
                        @php
                            $companyUrl = auth()->check()
                                ? route('frontend.workspace')
                                : route('frontend.account.register', ['type' => 'company']);
                        @endphp
                        <a href="{{ $companyUrl }}" class="text-lg font-medium leading-7 text-sky-600 hover:underline">Build Your Team with Talent</a>
                        <p class="mt-4 text-base leading-8 text-slate-800">
                            Post public or private jobs, screen CVs with AI, run proctored exams, and hire the right people faster.
                        </p>
                        <div class="mt-auto flex justify-end pt-6">
                            <a href="{{ $companyUrl }}" class="inline-flex items-center gap-2 text-lg font-medium text-slate-900 transition hover:text-sky-600">
                                {{ auth()->check() ? 'Open my workspace' : 'Continue as a Company' }}
                                <span class="grid h-7 w-7 place-items-center rounded-full border border-slate-500 transition group-hover:border-sky-600">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14m-5-5 5 5-5 5"/></svg>
                                </span>
                            </a>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        {{-- Why TalentBridge --}}
        @php
            $benefits = [
                ['title' => 'For Candidates', 'text' => 'Build your profile, upload your CV, and apply to public jobs in minutes.', 'icon' => 'M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M10 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm10 10v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75'],
                ['title' => 'For Companies', 'text' => 'Post public or private jobs and manage your hiring team in one workspace.', 'icon' => 'M5 3h14a1 1 0 0 1 1 1v17H4V4a1 1 0 0 1 1-1Zm4 4h2m2 0h2M9 11h2m2 0h2M9 15h2m2 0h2'],
                ['title' => 'Smart Screening', 'text' => 'AI CV matching, timed proctored exams, and structured interview rounds.', 'icon' => 'M12 3 4 6v6c0 4.5 3.2 8 8 9 4.8-1 8-4.5 8-9V6l-8-3Zm-3 9 2 2 4-4'],
                ['title' => 'Easy Scheduling', 'text' => 'Pick a free slot, get notified, and sync interviews with your calendar.', 'icon' => 'M4 6h16v14H4V6Zm12-3v4M8 3v4M4 11h16m-11 4 2 2 4-4'],
            ];
        @endphp
        <section class="bg-sky-600 px-5 py-14 text-white lg:px-8" aria-labelledby="why-title">
            <div class="mx-auto max-w-7xl">
                <div class="mx-auto mb-10 max-w-2xl text-center">
                    <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-sky-100">Why TalentBridge</p>
                    <h2 id="why-title" class="mt-3 text-2xl font-extrabold tracking-tight sm:text-3xl">One platform for the whole hiring journey</h2>
                </div>
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4 lg:gap-0">
                    @foreach ($benefits as $b)
                        <div class="flex flex-col items-center px-6 text-center {{ !$loop->last ? 'lg:border-r lg:border-white/20' : '' }}">
                            <span class="grid h-16 w-16 place-items-center rounded-full bg-white/15 ring-4 ring-white/10">
                                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $b['icon'] }}"/></svg>
                            </span>
                            <h3 class="mt-5 text-base font-bold">{{ $b['title'] }}</h3>
                            <p class="mt-2 max-w-[240px] text-sm leading-6 text-sky-50/90">{{ $b['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>


  
</div>
<script>
    try {
        if (sessionStorage.getItem('hallEntered')) {
            document.getElementById('landingRoot')?.classList.add('landing-arrive');
            sessionStorage.removeItem('hallEntered');
        }
    } catch (e) {}
</script>
@endsection
