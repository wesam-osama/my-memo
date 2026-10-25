@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Assessments')

@section('page_header')
    <h1 class="text-2xl font-bold text-hb-navy">Assessments</h1>
    <p class="mt-1 text-sm text-hb-muted">Timed, camera-monitored exams for your applications. You have up to 3 attempts per exam.</p>
@endsection

@section('content')
    @php $items = collect(data_get($exams, 'data', $exams)); @endphp

    @if ($items->isEmpty())
        <x-card><x-empty-state title="No assessments assigned">When a company opens an exam stage for your application it will appear here.</x-empty-state></x-card>
    @else
        <div class="grid gap-4 lg:grid-cols-2">
            @foreach ($items as $exam)
                @php $id = data_get($exam, 'id', data_get($exam, 'exam_id')); @endphp
                <x-card>
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h2 class="truncate text-base font-semibold text-hb-navy">{{ data_get($exam, 'title') }}</h2>
                            <p class="text-sm text-hb-muted">{{ data_get($exam, 'job.title', data_get($exam, 'job_title')) }}</p>
                        </div>
                        @include('frontend.partials.status-badge', ['status' => data_get($exam, 'status')])
                    </div>
                    <dl class="mt-3 grid grid-cols-3 gap-2 text-sm">
                        <div><dt class="text-xs text-hb-muted">Time</dt><dd class="font-medium">{{ data_get($exam, 'time_limit_min', '—') }} min</dd></div>
                        <div><dt class="text-xs text-hb-muted">Pass score</dt><dd class="font-medium">{{ data_get($exam, 'passing_score', '—') }}</dd></div>
                        <div><dt class="text-xs text-hb-muted">Attempts</dt><dd class="font-medium">{{ data_get($exam, 'attempts_used', 0) }}/{{ data_get($exam, 'attempt_limit', 3) }}</dd></div>
                    </dl>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <x-button size="sm" :href="route('frontend.candidate.exams.start', ['examId' => $id])">Start</x-button>
                        <x-button size="sm" variant="light" :href="route('frontend.candidate.exams.result', ['examId' => $id])">Result</x-button>
                    </div>
                </x-card>
            @endforeach
        </div>
    @endif
@endsection
