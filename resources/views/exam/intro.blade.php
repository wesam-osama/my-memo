@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Before you start')

@section('page_header')
    @include('frontend.partials.page-back', ['route' => 'frontend.candidate.exams.index', 'label' => 'Assessments'])
    <h1 class="mt-2 text-2xl font-bold text-hb-navy">Before you start</h1>
@endsection

@section('content')
    <x-card class="max-w-2xl">
        <ul class="list-disc space-y-2 ps-5 text-sm text-hb-text">
            <li>The exam is timed. Your answers are submitted automatically when time ends.</li>
            <li>Stay on this page. Switching tabs or leaving the window is recorded.</li>
            <li>Your camera is used to check your identity and watch for multiple people or looking away. Flags never fail you automatically: a human reviewer decides.</li>
            <li>You may have up to 3 attempts. Each start uses one attempt.</li>
        </ul>

        <form method="POST" action="{{ route('frontend.candidate.exams.start.submit', ['examId' => $examId]) }}" class="mt-6 space-y-5">
            @csrf
            <div>
                <x-form.checkbox name="camera_consent" required>I consent to camera monitoring during this exam and understand how it is used.</x-form.checkbox>
                @error('camera_consent') <p class="hb-field-error" role="alert">{{ $message }}</p> @enderror
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <x-button type="submit">Start exam</x-button>
                <x-button variant="light" :href="route('frontend.candidate.exams.index')">Not now</x-button>
            </div>
        </form>
    </x-card>
@endsection
