@extends('frontend.layouts.app')

@section('title', __('Assessments'))

@section('page_header')
    <h1 class="text-2xl font-semibold tracking-tight text-hb-navy">{{ __('Assessments') }}</h1>
@endsection

@section('content')
@php $items = \App\Support\Rows::from($exams ?? []); $meta = \App\Support\Rows::meta($exams ?? null); @endphp

<x-table>
    <x-slot:head>
        <th class="px-4 py-3 text-start">{{ __('Exam') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Status') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Time limit (min)') }}</th>
        <th class="px-4 py-3 text-start">{{ __('Passing score') }}</th>
        <th class="px-4 py-3 text-end">{{ __('Actions') }}</th>
    </x-slot:head>

    @forelse ($items as $row)
        <tr>
            <td class="px-4 py-3">{{ data_get($row, 'exam.title') ?? data_get($row, 'title') ?? '—' }}</td>
            <td class="px-4 py-3"><x-badge :variant="\App\Support\Rows::badgeVariant(data_get($row, 'status'))" :dot="true">{{ data_get($row, 'status', '—') }}</x-badge></td>
            <td class="px-4 py-3">{{ data_get($row, 'exam.time_limit_min') ?? data_get($row, 'time_limit_min') ?? '—' }}</td>
            <td class="px-4 py-3">{{ data_get($row, 'exam.passing_score') ?? data_get($row, 'passing_score') ?? '—' }}</td>
            <td class="px-4 py-3"><div class="flex flex-wrap justify-end gap-2">
                @if (! in_array(data_get($row, 'status'), ['submitted', 'graded', 'passed', 'failed'], true))
                <x-button variant="primary" size="sm" :href="route('frontend.candidate.exams.start', ['examId' => data_get($row, 'exam_id'), 'application_id' => data_get($row, 'application_id')])">{{ __('Start') }}</x-button>
                @endif
                <x-button variant="light" size="sm" :href="route('frontend.candidate.exams.result', ['attemptId' => data_get($row, 'attempt_id', data_get($row, 'id'))])">{{ __('Result') }}</x-button>
            </div></td>
        </tr>
    @empty
        <tr><td colspan="5" class="px-4 py-10 text-center text-hb-muted">{{ __('Nothing to show yet.') }}</td></tr>
    @endforelse
</x-table>
@include('frontend.partials.pagination', ['meta' => $meta])
@endsection
