@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Discover jobs')

@section('page_header')
    <h1 class="text-2xl font-bold text-hb-navy">Discover jobs</h1>
    <p class="mt-1 text-sm text-hb-muted">Open vacancies you can apply for.</p>
@endsection

@section('content')
    @php $items = collect(data_get($vacancies, 'data', $vacancies)); @endphp

    @if ($items->isEmpty())
        <x-card><x-empty-state title="No vacancies right now">New jobs will show up here as companies publish them.</x-empty-state></x-card>
    @else
        <div class="grid gap-4 lg:grid-cols-2">
            @foreach ($items as $job)
                @php
                    $id = data_get($job, 'id');
                    $min = data_get($job, 'salary_min'); $max = data_get($job, 'salary_max');
                @endphp
                <x-card>
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h2 class="truncate text-base font-semibold text-hb-navy">{{ data_get($job, 'title') }}</h2>
                            <p class="text-sm text-hb-muted">{{ data_get($job, 'company.name', data_get($job, 'company_name')) }}</p>
                        </div>
                        @if (data_get($job, 'work_mode'))
                            <x-badge variant="info">{{ \Illuminate\Support\Str::headline(data_get($job, 'work_mode')) }}</x-badge>
                        @endif
                    </div>
                    <p class="mt-3 text-sm text-hb-text">
                        @if (data_get($job, 'location')) {{ data_get($job, 'location') }} @endif
                        @if (data_get($job, 'employment_type')) · {{ \Illuminate\Support\Str::headline(data_get($job, 'employment_type')) }} @endif
                    </p>
                    @if ($min || $max)
                        <p class="mt-1 text-sm font-medium text-hb-navy">
                            {{ number_format((float) $min) }}@if ($max) – {{ number_format((float) $max) }}@endif
                            {{ data_get($job, 'currency') }} @if (data_get($job, 'salary_period')) / {{ data_get($job, 'salary_period') }} @endif
                        </p>
                    @endif
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <span class="text-xs text-hb-muted">
                            @if (data_get($job, 'deadline')) Apply by {{ \Illuminate\Support\Str::before((string) data_get($job, 'deadline'), 'T') }} @endif
                        </span>
                        <x-button size="sm" :href="route('frontend.candidate.vacancies.apply', ['vacancyId' => $id])">Apply</x-button>
                    </div>
                </x-card>
            @endforeach
        </div>
    @endif
@endsection
