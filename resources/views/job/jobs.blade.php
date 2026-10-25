@extends('frontend.layouts.public')

@section('title', 'Find a job')

@section('content')
    @php
        $items = collect(data_get($jobs, 'data', $jobs));
        $page = (int) data_get($jobs, 'current_page', 1);
        $last = (int) data_get($jobs, 'last_page', 1);
        $workModes = ['onsite' => 'On-site', 'remote' => 'Remote', 'hybrid' => 'Hybrid'];
        $types = ['full_time' => 'Full-time', 'part_time' => 'Part-time', 'contract' => 'Contract', 'internship' => 'Internship'];
    @endphp

    <section class="bg-hb-page">
        <div class="hb-container py-10 lg:py-14">
            <p class="text-xs font-semibold tracking-[0.12em] text-hb-muted uppercase">Open roles</p>
            <h1 class="mt-3 text-3xl font-semibold text-hb-navy sm:text-4xl">Find your next job</h1>
            <p class="mt-2 max-w-2xl text-sm text-hb-muted">Browse public vacancies from verified companies. Create a free account to apply.</p>

            <div class="mt-8 grid gap-8 lg:grid-cols-[280px_minmax(0,1fr)]">
                <aside class="hb-surface h-fit p-5" aria-label="Refine results">
                    <form method="GET" action="{{ route('frontend.jobs.index') }}" class="space-y-5">
                        <x-form.input name="q" label="Keyword" type="search" placeholder="Product designer" :value="request('q')" />
                        <x-form.input name="location" label="Location" placeholder="Cairo" :value="request('location')" />
                        <x-form.select name="work_mode" label="Work mode">
                            <option value="">Any</option>
                            @foreach ($workModes as $v => $l)
                                <option value="{{ $v }}" @selected(request('work_mode') === $v)>{{ $l }}</option>
                            @endforeach
                        </x-form.select>
                        <x-form.select name="employment_type" label="Employment type">
                            <option value="">Any</option>
                            @foreach ($types as $v => $l)
                                <option value="{{ $v }}" @selected(request('employment_type') === $v)>{{ $l }}</option>
                            @endforeach
                        </x-form.select>
                        <div class="flex gap-2">
                            <x-button type="submit" class="flex-1">Search</x-button>
                            @if (request()->query())
                                <x-button variant="light" :href="route('frontend.jobs.index')">Reset</x-button>
                            @endif
                        </div>
                    </form>
                </aside>

                <div>
                    <p class="mb-4 text-sm text-hb-muted" aria-live="polite">
                        {{ $items->count() }} {{ \Illuminate\Support\Str::plural('role', $items->count()) }}@if (data_get($jobs, 'total')) of {{ data_get($jobs, 'total') }}@endif
                    </p>

                    @if ($items->isEmpty())
                        <x-card><x-empty-state title="No roles match" action-label="Clear filters" :action-href="route('frontend.jobs.index')">Try a different keyword or remove some filters.</x-empty-state></x-card>
                    @else
                        <div class="space-y-4">
                            @foreach ($items as $job)
                                @php
                                    $id = data_get($job, 'id');
                                    $min = data_get($job, 'salary_min'); $max = data_get($job, 'salary_max');
                                @endphp
                                <article class="hb-surface flex flex-col p-5">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <h2 class="text-base font-semibold text-hb-navy">
                                                <a href="{{ route('frontend.jobs.show', ['jobId' => $id]) }}" class="hover:text-hb-blue">{{ data_get($job, 'title') }}</a>
                                            </h2>
                                            <p class="mt-1 text-sm text-hb-muted">{{ data_get($job, 'company.name', data_get($job, 'company_name')) }}</p>
                                            <p class="mt-2 text-sm text-hb-text">
                                                {{ $workModes[data_get($job, 'work_mode')] ?? \Illuminate\Support\Str::headline((string) data_get($job, 'work_mode')) }}
                                                @if (data_get($job, 'location')) · {{ data_get($job, 'location') }} @endif
                                                @if (data_get($job, 'employment_type')) · {{ $types[data_get($job, 'employment_type')] ?? \Illuminate\Support\Str::headline((string) data_get($job, 'employment_type')) }} @endif
                                            </p>
                                        </div>
                                        @if ($min || $max)
                                            <p class="shrink-0 text-end text-sm font-medium text-hb-navy">
                                                {{ number_format((float) $min) }}@if ($max) – {{ number_format((float) $max) }}@endif
                                                <span class="block text-xs font-normal text-hb-muted">{{ data_get($job, 'currency') }}@if (data_get($job, 'salary_period')) / {{ data_get($job, 'salary_period') }}@endif</span>
                                            </p>
                                        @endif
                                    </div>
                                    <div class="mt-4 flex items-center justify-between gap-3 text-sm">
                                        <p class="text-xs text-hb-muted">
                                            @if (data_get($job, 'published_at')) Posted {{ \Illuminate\Support\Str::before((string) data_get($job, 'published_at'), 'T') }} @endif
                                            @if (data_get($job, 'deadline')) · Apply by {{ \Illuminate\Support\Str::before((string) data_get($job, 'deadline'), 'T') }} @endif
                                        </p>
                                        <a href="{{ route('frontend.jobs.show', ['jobId' => $id]) }}" class="shrink-0 font-semibold text-hb-blue hover:underline">View role</a>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        @if ($last > 1)
                            <nav class="mt-6 flex items-center justify-between" aria-label="Pagination">
                                @if ($page > 1)
                                    <x-button variant="light" :href="request()->fullUrlWithQuery(['page' => $page - 1])">&larr; Previous</x-button>
                                @else <span></span> @endif
                                <span class="text-sm text-hb-muted">Page {{ $page }} of {{ $last }}</span>
                                @if ($page < $last)
                                    <x-button variant="light" :href="request()->fullUrlWithQuery(['page' => $page + 1])">Next &rarr;</x-button>
                                @else <span></span> @endif
                            </nav>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
