@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Pick a time')

@section('page_header')
    @include('frontend.partials.page-back', ['route' => 'frontend.candidate.interviews.index', 'label' => 'Interviews'])
    <h1 class="mt-2 text-2xl font-bold text-hb-navy">{{ request('reschedule') ? 'Pick a new time' : 'Pick a time' }}</h1>
    <p class="mt-1 text-sm text-hb-muted">Choose a free slot. Once booked, it is locked for you.</p>
@endsection

@section('content')
    @php
        $items = collect(data_get($slots, 'data', $slots));
        $rescheduleId = request('reschedule');
        $interviewId = request('interview_id');
        $formRoute = $rescheduleId
            ? route('frontend.candidate.interviews.reschedule.submit', ['interviewId' => $rescheduleId])
            : route('frontend.candidate.interviews.book.submit');
    @endphp

    <form method="GET" class="mb-5 flex max-w-md items-end gap-3">
        @if ($rescheduleId) <input type="hidden" name="reschedule" value="{{ $rescheduleId }}"> @endif
        @if ($interviewId) <input type="hidden" name="interview_id" value="{{ $interviewId }}"> @endif
        <x-form.input name="date" label="Date" type="date" :value="request('date')" />
        <x-button type="submit" variant="light">Filter</x-button>
    </form>

    @if (! $rescheduleId && ! $interviewId)
        <x-alert variant="warning" class="mb-4">Open this page from your <a href="{{ route('frontend.candidate.interviews.index') }}" class="font-semibold underline">interviews list</a> so we know which interview you are booking.</x-alert>
    @endif

    @if ($items->isEmpty())
        <x-card><x-empty-state title="No free slots">There are no available times for this selection. Try another date.</x-empty-state></x-card>
    @else
        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($items as $slot)
                <x-card>
                    <p class="text-sm font-semibold text-hb-navy" dir="ltr">{{ str_replace('T', ' ', \Illuminate\Support\Str::before((string) data_get($slot, 'start_at'), '.')) }}</p>
                    <p class="text-xs text-hb-muted" dir="ltr">until {{ str_replace('T', ' ', \Illuminate\Support\Str::before((string) data_get($slot, 'end_at'), '.')) }}</p>
                    @if (data_get($slot, 'interviewer.name'))
                        <p class="mt-1 text-xs text-hb-muted">With {{ data_get($slot, 'interviewer.name') }}</p>
                    @endif
                    @if ($rescheduleId || $interviewId)
                        <form method="POST" action="{{ $formRoute }}" class="mt-3">
                            @csrf
                            @if ($interviewId && ! $rescheduleId) <input type="hidden" name="interview_id" value="{{ $interviewId }}"> @endif
                            <input type="hidden" name="availability_id" value="{{ data_get($slot, 'id') }}">
                            <x-button size="sm" type="submit">{{ $rescheduleId ? 'Move here' : 'Book this slot' }}</x-button>
                        </form>
                    @endif
                </x-card>
            @endforeach
        </div>
    @endif
@endsection
