@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Exam')

@section('page_header')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-hb-navy">{{ data_get($exam, 'exam.title', data_get($exam, 'title', 'Exam')) }}</h1>
            <p class="mt-1 text-sm text-hb-muted">Attempt {{ data_get($exam, 'attempt_no', data_get($exam, 'attempt.attempt_no', 1)) }}</p>
        </div>
        <div class="rounded-lg border border-hb-border bg-hb-surface px-4 py-2 text-center" role="timer" aria-live="off">
            <p class="text-xs text-hb-muted">Time left</p>
            <p id="exam-timer" class="text-xl font-bold tabular-nums text-hb-navy" dir="ltr">--:--</p>
        </div>
    </div>
@endsection

@section('content')
    @php
        $questions = collect(data_get($exam, 'questions', data_get($exam, 'exam.questions', [])));
        $minutes = (int) data_get($exam, 'time_limit_min', data_get($exam, 'exam.time_limit_min', 0));
    @endphp

    <form id="exam-form" method="POST" action="{{ route('frontend.candidate.exams.submit.submit', ['examId' => $examId]) }}" class="space-y-5">
        @csrf
        @forelse ($questions as $i => $q)
            @php $qid = data_get($q, 'id'); $type = data_get($q, 'question_type', 'written'); @endphp
            <x-card>
                <div class="flex items-start justify-between gap-3">
                    <h2 class="text-sm font-semibold text-hb-navy">Question {{ $i + 1 }}</h2>
                    <span class="text-xs text-hb-muted">{{ data_get($q, 'points') }} pts</span>
                </div>
                <p class="mt-2 whitespace-pre-line text-sm text-hb-text">{{ data_get($q, 'content') }}</p>

                <div class="mt-4">
                    @if ($type === 'mcq')
                        <div class="space-y-2">
                            @foreach (data_get($q, 'options', []) as $opt)
                                <label class="flex cursor-pointer items-start gap-2 rounded-md border border-hb-border p-3 text-sm has-[:checked]:border-hb-blue has-[:checked]:bg-hb-info-soft">
                                    <input type="radio" name="answers[{{ $qid }}]" value="{{ data_get($opt, 'id') }}" class="mt-0.5">
                                    <span>{{ data_get($opt, 'option_text') }}</span>
                                </label>
                            @endforeach
                        </div>
                    @elseif ($type === 'coding')
                        <textarea name="answers[{{ $qid }}]" rows="10" spellcheck="false" class="hb-input font-mono text-xs" dir="ltr" placeholder="Write your code here"></textarea>
                    @else
                        @if ($type === 'voice')
                            <p class="mb-2 text-xs text-hb-pending">Voice answers are not recorded in this version. Type your answer instead.</p>
                        @endif
                        <textarea name="answers[{{ $qid }}]" rows="5" class="hb-input" placeholder="Type your answer"></textarea>
                    @endif
                </div>
            </x-card>
        @empty
            <x-card><x-empty-state title="No questions found">This exam has no questions yet. Please contact the company.</x-empty-state></x-card>
        @endforelse

        @if ($questions->isNotEmpty())
            <div class="flex items-center gap-3">
                <x-button type="submit" onclick="return confirm('Submit your answers now?')">Submit exam</x-button>
            </div>
        @endif
    </form>
@endsection

@push('scripts')
<script>
    (() => {
        const minutes = {{ $minutes }};
        const el = document.getElementById('exam-timer');
        const form = document.getElementById('exam-form');
        if (!minutes || !el || !form) { if (el) el.textContent = '—'; return; }
        const key = 'exam-end-{{ $examId }}';
        let end = Number(sessionStorage.getItem(key));
        if (!end || end < Date.now() - 6 * 3600 * 1000) {
            end = Date.now() + minutes * 60000;
            sessionStorage.setItem(key, end);
        }
        const tick = () => {
            const left = Math.max(0, Math.round((end - Date.now()) / 1000));
            el.textContent = String(Math.floor(left / 60)).padStart(2, '0') + ':' + String(left % 60).padStart(2, '0');
            if (left <= 0) { clearInterval(t); sessionStorage.removeItem(key); form.submit(); }
        };
        const t = setInterval(tick, 1000); tick();
        form.addEventListener('submit', () => sessionStorage.removeItem(key));
    })();
</script>
@endpush
