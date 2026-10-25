@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Reschedule interview')

@section('page_header')
    @include('frontend.partials.page-back', ['route' => 'frontend.candidate.interviews.index', 'label' => 'Interviews'])
    <h1 class="mt-2 text-2xl font-bold text-hb-navy">Reschedule interview</h1>
@endsection

@section('content')
    <x-card class="max-w-xl">
        <p class="text-sm text-hb-text">You can reschedule at least 24 hours before the interview starts. Pick a new free slot.</p>
        <div class="mt-4"><x-button :href="route('frontend.candidate.interviews.slots', ['reschedule' => $interviewId])">Choose a new time</x-button></div>
    </x-card>
@endsection
