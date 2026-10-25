@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Exam result')

@section('page_header')
    @include('frontend.partials.page-back', ['route' => 'frontend.candidate.exams.index', 'label' => 'Assessments'])
    <h1 class="mt-2 text-2xl font-bold text-hb-navy">Exam result</h1>
@endsection

@section('content')
    @php
        $score = data_get($result, 'total_score');
        $pass = data_get($result, 'passing_score');
        $status = data_get($result, 'status');
    @endphp
    <div class="grid max-w-3xl gap-4 sm:grid-cols-3">
        <x-stat-card label="Your score" :value="$score ?? '—'" />
        <x-stat-card label="Passing score" :value="$pass ?? '—'" />
        <x-card><p class="text-xs font-semibold uppercase tracking-wide text-hb-muted">Status</p><div class="mt-3">@include('frontend.partials.status-badge', ['status' => $status])</div></x-card>
    </div>
    @if ($score !== null && $pass)
        <x-card class="mt-4 max-w-3xl"><x-progress :value="(int) $score" :max="100" label="Score" /></x-card>
    @endif
    @if (data_get($result, 'status') === 'pending_review' || data_get($result, 'grading_status') === 'pending')
        <x-alert variant="info" class="mt-4 max-w-3xl">Some answers are still being reviewed. Your final result will be updated.</x-alert>
    @endif
@endsection
