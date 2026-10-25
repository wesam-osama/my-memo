@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Application')

@section('page_header')
    @include('frontend.partials.page-back', ['route' => 'frontend.candidate.applications.index', 'label' => 'All applications'])
    <h1 class="mt-2 text-2xl font-bold text-hb-navy">{{ data_get($application, 'job.title', data_get($application, 'job_title', 'Application')) }}</h1>
    <p class="mt-1 text-sm text-hb-muted">{{ data_get($application, 'job.company.name', data_get($application, 'company_name')) }}</p>
@endsection

@section('content')
    @php
        $status = strtolower((string) data_get($application, 'status'));
        $history = collect(data_get($application, 'status_history', data_get($application, 'history', [])));
        $canWithdraw = in_array($status, ['applied', 'submitted', 'pending'], true);
    @endphp

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <x-card>
                <x-slot:header><h2 class="text-base font-semibold text-hb-navy">Progress</h2></x-slot:header>
                @forelse ($history as $row)
                    <div class="flex gap-3 border-b border-hb-border py-3 last:border-0">
                        <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-hb-blue" aria-hidden="true"></span>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-hb-navy">{{ \Illuminate\Support\Str::headline((string) data_get($row, 'to_status')) }}</p>
                            @if (data_get($row, 'reason')) <p class="text-sm text-hb-text">{{ data_get($row, 'reason') }}</p> @endif
                            <p class="text-xs text-hb-muted">{{ str_replace('T', ' ', \Illuminate\Support\Str::before((string) data_get($row, 'changed_at'), '.')) }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-hb-muted">No status changes yet.</p>
                @endforelse
            </x-card>

            @if (data_get($application, 'cover_note'))
                <x-card>
                    <x-slot:header><h2 class="text-base font-semibold text-hb-navy">Your cover note</h2></x-slot:header>
                    <p class="whitespace-pre-line text-sm text-hb-text">{{ data_get($application, 'cover_note') }}</p>
                </x-card>
            @endif
        </div>

        <div class="space-y-6">
            <x-card>
                <dl class="space-y-3 text-sm">
                    <div><dt class="text-hb-muted">Status</dt><dd class="mt-1">@include('frontend.partials.status-badge', ['status' => $status])</dd></div>
                    <div><dt class="text-hb-muted">Applied</dt><dd class="font-medium">{{ \Illuminate\Support\Str::before((string) data_get($application, 'applied_at'), 'T') ?: '—' }}</dd></div>
                    <div><dt class="text-hb-muted">Attempt</dt><dd class="font-medium">#{{ data_get($application, 'attempt_no', 1) }}</dd></div>
                </dl>
            </x-card>

            <x-card>
                <x-slot:header><h2 class="text-base font-semibold text-hb-navy">Next steps</h2></x-slot:header>
                <div class="flex flex-col gap-2">
                    <x-button variant="light" :href="route('frontend.candidate.exams.index')">Assessments</x-button>
                    <x-button variant="light" :href="route('frontend.candidate.interviews.index')">Interviews</x-button>
                    <x-button variant="light" :href="route('frontend.candidate.offers.index')">Offers</x-button>
                </div>
            </x-card>

            @if ($canWithdraw)
                <form method="POST" action="{{ route('frontend.candidate.applications.withdraw', ['applicationId' => data_get($application, 'id')]) }}" onsubmit="return confirm('Withdraw this application? You can only do this before it is reviewed.')">
                    @csrf
                    <x-button type="submit" variant="destructive" class="w-full">Withdraw application</x-button>
                </form>
            @endif
        </div>
    </div>
@endsection
