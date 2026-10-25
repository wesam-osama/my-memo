@extends('frontend.layouts.public')

@section('title', data_get($job, 'title', 'Job details'))

@section('content')
    @php
        $min = data_get($job, 'salary_min'); $max = data_get($job, 'salary_max');
        $skills = collect(data_get($job, 'skills', []));
        $required = $skills->filter(fn ($s) => data_get($s, 'is_required', data_get($s, 'pivot.is_required', true)));
        $optional = $skills->reject(fn ($s) => data_get($s, 'is_required', data_get($s, 'pivot.is_required', true)));
        $id = data_get($job, 'id');
    @endphp

    <section class="bg-hb-page">
        <div class="hb-container py-10 lg:py-14">
            @include('frontend.partials.page-back', ['route' => 'frontend.jobs.index', 'label' => 'All jobs'])

            <div class="mt-4 grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
                <div class="space-y-6">
                    <div>
                        <h1 class="text-3xl font-semibold text-hb-navy sm:text-4xl">{{ data_get($job, 'title') }}</h1>
                        <p class="mt-2 text-sm text-hb-muted">
                            {{ data_get($job, 'company.name', data_get($job, 'company_name')) }}
                            @if (data_get($job, 'location')) · {{ data_get($job, 'location') }} @endif
                        </p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @if (data_get($job, 'work_mode')) <x-badge variant="info">{{ \Illuminate\Support\Str::headline(data_get($job, 'work_mode')) }}</x-badge> @endif
                            @if (data_get($job, 'employment_type')) <x-badge variant="neutral">{{ \Illuminate\Support\Str::headline(data_get($job, 'employment_type')) }}</x-badge> @endif
                            @if (data_get($job, 'department')) <x-badge variant="neutral">{{ data_get($job, 'department') }}</x-badge> @endif
                        </div>
                    </div>

                    <x-card>
                        <x-slot:header><h2 class="text-base font-semibold text-hb-navy">About the role</h2></x-slot:header>
                        <div class="whitespace-pre-line text-sm leading-relaxed text-hb-text">{{ data_get($job, 'description') }}</div>
                    </x-card>

                    @if ($skills->isNotEmpty())
                        <x-card>
                            <x-slot:header><h2 class="text-base font-semibold text-hb-navy">Skills</h2></x-slot:header>
                            @if ($required->isNotEmpty())
                                <p class="text-xs font-semibold uppercase tracking-wide text-hb-muted">Required</p>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach ($required as $s) <x-badge variant="info">{{ data_get($s, 'name') }}</x-badge> @endforeach
                                </div>
                            @endif
                            @if ($optional->isNotEmpty())
                                <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-hb-muted">Nice to have</p>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach ($optional as $s) <x-badge variant="neutral">{{ data_get($s, 'name') }}</x-badge> @endforeach
                                </div>
                            @endif
                        </x-card>
                    @endif
                </div>

                <aside class="space-y-4">
                    <x-card>
                        @if ($min || $max)
                            <p class="text-xs font-semibold uppercase tracking-wide text-hb-muted">Salary</p>
                            <p class="mt-1 text-lg font-semibold text-hb-navy">
                                {{ number_format((float) $min) }}@if ($max) – {{ number_format((float) $max) }}@endif
                                <span class="text-sm font-normal text-hb-muted">{{ data_get($job, 'currency') }}@if (data_get($job, 'salary_period')) / {{ data_get($job, 'salary_period') }}@endif</span>
                            </p>
                        @endif
                        <dl class="mt-4 space-y-3 text-sm">
                            @if (data_get($job, 'experience_years') !== null)
                                <div><dt class="text-hb-muted">Experience</dt><dd class="font-medium">{{ data_get($job, 'experience_years') }}+ years</dd></div>
                            @endif
                            @if (data_get($job, 'openings_count'))
                                <div><dt class="text-hb-muted">Openings</dt><dd class="font-medium">{{ data_get($job, 'openings_count') }}</dd></div>
                            @endif
                            @if (data_get($job, 'deadline'))
                                <div><dt class="text-hb-muted">Apply by</dt><dd class="font-medium">{{ \Illuminate\Support\Str::before((string) data_get($job, 'deadline'), 'T') }}</dd></div>
                            @endif
                        </dl>
                        <div class="mt-5">
                            @include('frontend.partials.job-apply-button', ['jobId' => $id])
                            @auth
                                @if (auth()->user()?->account_type === 'company')
                                    <p class="text-xs text-hb-muted">Company accounts can't apply for jobs.</p>
                                @endif
                            @endauth
                        </div>
                    </x-card>
                </aside>
            </div>
        </div>
    </section>
@endsection
