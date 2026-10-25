@extends('frontend.layouts.app')

@section('title', __('Audit logs'))

@section('page_header')
    <h1 class="text-2xl font-semibold tracking-tight text-hb-navy">{{ __('Audit logs') }}</h1>
@endsection

@section('content')
@php $items = \App\Support\Rows::from($logs ?? []); $meta = \App\Support\Rows::meta($logs ?? null); @endphp

<x-table>
    <x-slot:head>
        <th class="px-4 py-3 text-start">{{ __('When') }}</th>
        <th class="px-4 py-3 text-start">{{ __('User') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Action') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Entity') }}</th>
    </x-slot:head>

    @forelse ($items as $row)
        <tr>
            <td class="px-4 py-3">{{ \App\Support\Rows::date(data_get($row, 'created_at')) }}</td>
            <td class="px-4 py-3">{{ data_get($row, 'user.name') ?? data_get($row, 'user_id') ?? '—' }}</td>
            <td class="px-4 py-3">{{ data_get($row, 'action') ?? data_get($row, 'event') ?? '—' }}</td>
            <td class="px-4 py-3">{{ data_get($row, 'entity_type') ?? data_get($row, 'auditable_type') ?? '—' }}</td>
        </tr>
    @empty
        <tr><td colspan="4" class="px-4 py-10 text-center text-hb-muted">{{ __('Nothing to show yet.') }}</td></tr>
    @endforelse
</x-table>
@include('frontend.partials.pagination', ['meta' => $meta])
@endsection
