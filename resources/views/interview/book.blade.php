@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Book interview')

@section('page_header')
    @include('frontend.partials.page-back', ['route' => 'frontend.candidate.interviews.index', 'label' => 'Interviews'])
    <h1 class="mt-2 text-2xl font-bold text-hb-navy">Book interview</h1>
@endsection

@section('content')
    <x-card class="max-w-xl">
        <p class="text-sm text-hb-text">Choose your interview and a free slot from the list of available times.</p>
        <div class="mt-4"><x-button :href="route('frontend.candidate.interviews.index')">Go to my interviews</x-button></div>
    </x-card>
@endsection
