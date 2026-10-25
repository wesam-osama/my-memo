@extends('frontend.layouts.app')

@section('title', __('My applications'))

@section('page_header')
    <h1 class="text-2xl font-semibold tracking-tight text-hb-navy">{{ __('My applications') }}</h1>
@endsection

@section('content')
@php $items = \App\Support\Rows::from($applications ?? []); $meta = \App\Support\Rows::meta($applications ?? null); @endphp

<x-table>
    <x-slot:head>
        <th class="px-4 py-3 text-start">{{ __('Job') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Status') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Applied') }}</th>
        <th class="px-4 py-3 text-end">{{ __('Actions') }}</th>
    </x-slot:head>

    @forelse ($items as $row)
        <tr>
            <td class="px-4 py-3">{{ data_get($row, 'job.title') ?? data_get($row, 'job_title') ?? data_get($row, 'title') ?? '—' }}</td>
            <td class="px-4 py-3"><x-badge :variant="\App\Support\Rows::badgeVariant(data_get($row, 'status'))" :dot="true">{{ data_get($row, 'status', '—') }}</x-badge></td>
            <td class="px-4 py-3">{{ \App\Support\Rows::date(data_get($row, 'applied_at')) }}</td>
            <td class="px-4 py-3"><div class="flex flex-wrap justify-end gap-2">
                <x-button variant="light" size="sm" :href="route('frontend.candidate.applications.show', ['applicationId' => data_get($row, 'id')])">{{ __('View') }}</x-button>
                @if (! in_array(data_get($row, 'status'), ['withdrawn', 'rejected', 'hired'], true))
                <form method="POST" action="{{ route('frontend.candidate.applications.withdraw', ['applicationId' => data_get($row, 'id')]) }}" class="inline" onsubmit="return confirm('{{ __('Withdraw this application?') }}')">@csrf <x-button type="submit" size="sm" variant="destructive">{{ __('Withdraw') }}</x-button></form>
                @endif
            </div></td>
        </tr>
    @empty
        <tr><td colspan="4" class="px-4 py-10 text-center text-hb-muted">{{ __('Nothing to show yet.') }}</td></tr>
    @endforelse
</x-table>
@include('frontend.partials.pagination', ['meta' => $meta])
@endsection
