@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Offer')

@section('page_header')
    @include('frontend.partials.page-back', ['route' => 'frontend.candidate.offers.index', 'label' => 'All offers'])
    <h1 class="mt-2 text-2xl font-bold text-hb-navy">{{ data_get($offer, 'application.job.title', data_get($offer, 'job_title', 'Job offer')) }}</h1>
    <p class="mt-1 text-sm text-hb-muted">{{ data_get($offer, 'application.job.company.name', data_get($offer, 'company_name')) }}</p>
@endsection

@section('content')
    @php
        $status = strtolower((string) data_get($offer, 'status'));
        $id = data_get($offer, 'id');
        $open = in_array($status, ['sent', 'pending'], true);
    @endphp

    <div class="grid max-w-4xl gap-6 lg:grid-cols-3">
        <x-card class="lg:col-span-2">
            <dl class="grid gap-4 text-sm sm:grid-cols-2">
                <div><dt class="text-hb-muted">Salary</dt><dd class="text-lg font-semibold text-hb-navy">{{ number_format((float) data_get($offer, 'salary_amount')) }} {{ data_get($offer, 'currency') }} <span class="text-sm font-normal text-hb-muted">/ {{ data_get($offer, 'salary_period') }}</span></dd></div>
                <div><dt class="text-hb-muted">Start date</dt><dd class="font-medium">{{ \Illuminate\Support\Str::before((string) data_get($offer, 'start_date'), 'T') ?: '—' }}</dd></div>
                <div><dt class="text-hb-muted">Sent</dt><dd class="font-medium">{{ \Illuminate\Support\Str::before((string) data_get($offer, 'sent_at'), 'T') ?: '—' }}</dd></div>
                <div><dt class="text-hb-muted">Expires</dt><dd class="font-medium">{{ \Illuminate\Support\Str::before((string) data_get($offer, 'expires_at'), 'T') ?: '—' }}</dd></div>
            </dl>
        </x-card>

        <x-card>
            <p class="text-xs font-semibold uppercase tracking-wide text-hb-muted">Status</p>
            <div class="mt-2">@include('frontend.partials.status-badge', ['status' => $status])</div>

            @if ($open)
                <div class="mt-5 flex flex-col gap-2">
                    <form method="POST" action="{{ route('frontend.candidate.offers.accept', ['offerId' => $id]) }}" onsubmit="return confirm('Accept this offer?')">
                        @csrf
                        <x-button type="submit" class="w-full">Accept offer</x-button>
                    </form>
                    <x-button variant="light" :href="route('frontend.candidate.offers.reject', ['offerId' => $id])">Decline offer</x-button>
                </div>
            @endif
        </x-card>
    </div>
@endsection
