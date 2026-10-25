@extends('frontend.layouts.app')

@section('title', __('Companies'))

@section('page_header')
    <h1 class="text-2xl font-semibold tracking-tight text-hb-navy">{{ __('Companies') }}</h1>
@endsection

@section('content')
@php $items = \App\Support\Rows::from($companies ?? []); $meta = \App\Support\Rows::meta($companies ?? null); @endphp
<form method="GET" action="{{ route('frontend.admin.companies.index') }}" class="mb-4 flex flex-wrap items-end gap-3">
    <x-form.select name="status" :label="__('Status')" class="max-w-xs"><option value="">{{ __('All') }}</option>@foreach (['pending','approved','rejected','active','suspended','banned'] as $st)<option value="{{ $st }}" @selected(request('status') === $st)>{{ $st }}</option>@endforeach</x-form.select>
    <x-button type="submit" variant="light">{{ __('Filter') }}</x-button>
</form>
<x-table>
    <x-slot:head>
        <th class="px-4 py-3 text-start">{{ __('Name') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Industry') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Contact') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Status') }}</th>
        <th class="px-4 py-3 text-end">{{ __('Actions') }}</th>
    </x-slot:head>

    @forelse ($items as $row)
        <tr>
            <td class="px-4 py-3">{{ data_get($row, 'name', '—') }}</td>
            <td class="px-4 py-3">{{ data_get($row, 'industry', '—') }}</td>
            <td class="px-4 py-3">{{ data_get($row, 'contact_email', '—') }}</td>
            <td class="px-4 py-3"><x-badge :variant="\App\Support\Rows::badgeVariant(data_get($row, 'status'))" :dot="true">{{ data_get($row, 'status', '—') }}</x-badge></td>
            <td class="px-4 py-3"><div class="flex flex-wrap justify-end gap-2">
                @if (data_get($row, 'status') === 'pending')
                <form method="POST" action="{{ route('frontend.admin.companies.approve', ['companyId' => data_get($row, 'id')]) }}" class="inline">@csrf <x-button type="submit" size="sm" variant="primary">{{ __('Approve') }}</x-button></form>
                @endif
                @if (data_get($row, 'status') === 'pending')
                <x-button variant="destructive" size="sm" :href="route('frontend.admin.companies.reject', ['companyId' => data_get($row, 'id')])">{{ __('Reject') }}</x-button>
                @endif
            </div></td>
        </tr>
    @empty
        <tr><td colspan="5" class="px-4 py-10 text-center text-hb-muted">{{ __('Nothing to show yet.') }}</td></tr>
    @endforelse
</x-table>
@include('frontend.partials.pagination', ['meta' => $meta])
@endsection
