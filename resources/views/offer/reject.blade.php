@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Decline offer')

@section('page_header')
    @include('frontend.partials.page-back', ['route' => 'frontend.candidate.offers.index', 'label' => 'All offers'])
    <h1 class="mt-2 text-2xl font-bold text-hb-navy">Decline offer</h1>
    <p class="mt-1 text-sm text-hb-muted">This cannot be undone. A short reason helps the company (optional).</p>
@endsection

@section('content')
    <x-card class="max-w-xl">
        <form method="POST" action="{{ route('frontend.candidate.offers.reject.submit', ['offerId' => $offerId]) }}" class="space-y-5">
            @csrf
            <x-form.textarea name="reason" label="Reason" :rows="4" :error="$errors->first('reason')">{{ old('reason') }}</x-form.textarea>
            <div class="flex flex-wrap items-center gap-3">
                <x-button type="submit" variant="destructive">Decline offer</x-button>
                <x-button variant="light" :href="route('frontend.candidate.offers.show', ['offerId' => $offerId])">Back</x-button>
            </div>
        </form>
    </x-card>
@endsection
