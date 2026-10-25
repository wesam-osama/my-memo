@extends('frontend.layouts.app')

@section('title', __('Offers'))

@section('page_header')
    <h1 class="text-2xl font-semibold tracking-tight text-hb-navy">{{ __('Offers') }}</h1>
@endsection

@section('content')
@php $items = \App\Support\Rows::from($offers ?? []); $meta = \App\Support\Rows::meta($offers ?? null); @endphp

<x-table>
    <x-slot:head>
        <th class="px-4 py-3 text-start">{{ __('Job') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Salary') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Status') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Expires') }}</th>
        <th class="px-4 py-3 text-end">{{ __('Actions') }}</th>
    </x-slot:head>

    @forelse ($items as $row)
        <tr>
            <td class="px-4 py-3">{{ data_get($row, 'application.job.title') ?? data_get($row, 'job_title') ?? '—' }}</td>
            <td class="px-4 py-3">{{ \App\Support\Rows::money(data_get($row, 'salary_amount'), data_get($row, 'currency'), data_get($row, 'salary_period')) }}</td>
            <td class="px-4 py-3"><x-badge :variant="\App\Support\Rows::badgeVariant(data_get($row, 'status'))" :dot="true">{{ data_get($row, 'status', '—') }}</x-badge></td>
            <td class="px-4 py-3">{{ \App\Support\Rows::date(data_get($row, 'expires_at'), 'Y-m-d') }}</td>
            <td class="px-4 py-3"><div class="flex flex-wrap justify-end gap-2">
                <x-button variant="light" size="sm" :href="route('frontend.candidate.offers.show', ['offerId' => data_get($row, 'id')])">{{ __('View') }}</x-button>
            </div></td>
        </tr>
    @empty
        <tr><td colspan="5" class="px-4 py-10 text-center text-hb-muted">{{ __('Nothing to show yet.') }}</td></tr>
    @endforelse
</x-table>
@include('frontend.partials.pagination', ['meta' => $meta])
@endsection
