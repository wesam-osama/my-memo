@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Overview')

@section('page_header')
    <h1 class="text-2xl font-bold text-hb-navy">Welcome, {{ auth()->user()?->name ?? 'there' }}</h1>
    <p class="mt-1 text-sm text-hb-muted">Pick up where you left off.</p>
@endsection

@section('content')
    @php
        $tiles = [
            ['Discover jobs', 'Browse open vacancies and apply.', 'frontend.candidate.vacancies.index'],
            ['My applications', 'Track every application and its status.', 'frontend.candidate.applications.index'],
            ['Assessments', 'Take your timed exams.', 'frontend.candidate.exams.index'],
            ['Interviews', 'See and manage your interviews.', 'frontend.candidate.interviews.index'],
            ['Offers', 'Review and answer job offers.', 'frontend.candidate.offers.index'],
            ['Profile & resume', 'Keep your profile and CV up to date.', 'frontend.candidate.profile'],
        ];
    @endphp
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($tiles as [$title, $text, $route])
            <a href="{{ route($route) }}" class="hb-surface block p-5 transition hover:border-hb-blue/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-hb-blue/40">
                <h2 class="text-base font-semibold text-hb-navy">{{ $title }}</h2>
                <p class="mt-1 text-sm text-hb-muted">{{ $text }}</p>
            </a>
        @endforeach
    </div>
@endsection
