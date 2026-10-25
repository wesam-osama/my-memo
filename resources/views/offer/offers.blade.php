@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Offers')

@section('page_header')
    <h1 class="text-2xl font-bold text-hb-navy">Offers</h1>
    <p class="mt-1 text-sm text-hb-muted">Job offers from companies. Answer before they expire.</p>
@endsection

@section('content')
    @php $items = collect(data_get($offers, 'data', $offers)); @endphp

    @if ($items->isEmpty())
        <x-card><x-empty-state title="No offers yet">If a company selects you, the offer will show up here.</x-empty-state></x-card>
    @else
        <x-table>
            <x-slot:head>
                <th class="px-4 py-3">Job</th>
                <th class="px-4 py-3">Salary</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Expires</th>
                <th class="px-4 py-3"><span class="sr-only">Actions</span></th>
            </x-slot:head>
            @foreach ($items as $offer)
                <tr>
                    <td class="px-4 py-3 font-medium text-hb-navy">{{ data_get($offer, 'application.job.title', data_get($offer, 'job_title', 'Offer')) }}</td>
                    <td class="px-4 py-3">{{ number_format((float) data_get($offer, 'salary_amount')) }} {{ data_get($offer, 'currency') }} / {{ data_get($offer, 'salary_period') }}</td>
                    <td class="px-4 py-3">@include('frontend.partials.status-badge', ['status' => data_get($offer, 'status')])</td>
                    <td class="px-4 py-3 text-hb-muted">{{ \Illuminate\Support\Str::before((string) data_get($offer, 'expires_at'), 'T') }}</td>
                    <td class="px-4 py-3 text-end"><a href="{{ route('frontend.candidate.offers.show', ['offerId' => data_get($offer, 'id')]) }}" class="font-semibold text-hb-blue hover:underline">View</a></td>
                </tr>
            @endforeach
        </x-table>
    @endif
@endsection
