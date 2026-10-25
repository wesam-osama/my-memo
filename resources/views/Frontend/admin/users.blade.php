@extends('frontend.layouts.app')

@section('title', __('Users'))

@section('page_header')
    <h1 class="text-2xl font-semibold tracking-tight text-hb-navy">{{ __('Users') }}</h1>
@endsection

@section('content')
@php $items = \App\Support\Rows::from($users ?? []); $meta = \App\Support\Rows::meta($users ?? null); @endphp
<form method="GET" action="{{ route('frontend.admin.users.index') }}" class="mb-4 flex flex-wrap items-end gap-3">
    <x-form.select name="status" :label="__('Status')" class="max-w-xs"><option value="">{{ __('All') }}</option>@foreach (['pending','approved','rejected','active','suspended','banned'] as $st)<option value="{{ $st }}" @selected(request('status') === $st)>{{ $st }}</option>@endforeach</x-form.select>
    <x-button type="submit" variant="light">{{ __('Filter') }}</x-button>
</form>
<x-table>
    <x-slot:head>
        <th class="px-4 py-3 text-start">{{ __('Name') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Email') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Type') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Status') }}</th>
        <th class="px-4 py-3 text-end">{{ __('Actions') }}</th>
    </x-slot:head>

    @forelse ($items as $row)
        <tr>
            <td class="px-4 py-3">{{ data_get($row, 'name', '—') }}</td>
            <td class="px-4 py-3">{{ data_get($row, 'email', '—') }}</td>
            <td class="px-4 py-3">{{ data_get($row, 'account_type', '—') }}</td>
            <td class="px-4 py-3"><x-badge :variant="\App\Support\Rows::badgeVariant(data_get($row, 'account_status'))" :dot="true">{{ data_get($row, 'account_status', '—') }}</x-badge></td>
            <td class="px-4 py-3"><div class="flex flex-wrap justify-end gap-2">
                <x-button variant="light" size="sm" :href="route('frontend.admin.users.status', ['userId' => data_get($row, 'id')])">{{ __('Change status') }}</x-button>
            </div></td>
        </tr>
    @empty
        <tr><td colspan="5" class="px-4 py-10 text-center text-hb-muted">{{ __('Nothing to show yet.') }}</td></tr>
    @endforelse
</x-table>
@include('frontend.partials.pagination', ['meta' => $meta])
@endsection
