@extends('frontend.layouts.public')

@section('title', __('Job details'))

@section('content')
<div class="hb-container max-w-3xl py-12 lg:py-16">
    <a href="{{ route('frontend.jobs.index') }}" class="text-sm font-semibold text-hb-blue hover:underline">&larr; {{ __('All jobs') }}</a>
    <h1 class="mt-4 text-4xl font-semibold tracking-tight text-hb-navy">{{ data_get($job ?? [], 'title') }}</h1>
    <p class="mt-1 text-hb-muted">{{ data_get($job ?? [], 'company.name', data_get($job ?? [], 'company_name', '')) }} · {{ data_get($job ?? [], 'location', '') }}</p>
    <div class="mt-4 flex flex-wrap gap-2">
        <x-badge variant="info">{{ data_get($job ?? [], 'work_mode', '—') }}</x-badge>
        <x-badge>{{ data_get($job ?? [], 'employment_type', '—') }}</x-badge>
        {{-- backend sends salary: {min, max, currency, period} --}}
        @php
            $salMin = data_get($job ?? [], 'salary.min', data_get($job ?? [], 'salary_min'));
            $salMax = data_get($job ?? [], 'salary.max', data_get($job ?? [], 'salary_max'));
            $salCur = data_get($job ?? [], 'salary.currency', data_get($job ?? [], 'currency'));
            $salPer = data_get($job ?? [], 'salary.period', data_get($job ?? [], 'salary_period'));
        @endphp
        @if ($salMin || $salMax)
            <x-badge variant="success">{{ \App\Support\Rows::money($salMin) }} – {{ \App\Support\Rows::money($salMax, $salCur, $salPer) }}</x-badge>
        @endif
    </div>
    <div class="hb-surface mt-8 whitespace-pre-line p-6 text-sm leading-7 text-hb-text lg:p-8">{{ data_get($job ?? [], 'description') }}</div>
    <div class="mt-8">
        @auth
            @if (auth()->user()->account_type === 'candidate')
                <x-button size="lg" :href="route('frontend.candidate.vacancies.apply', ['vacancyId' => data_get($job, 'id')])">{{ __('Apply now') }}</x-button>
            @endif
        @else
            <x-button size="lg" :href="route('frontend.account.login')">{{ __('Sign in to apply') }}</x-button>
        @endauth
    </div>
</div>
@endsection
