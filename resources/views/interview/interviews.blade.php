@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Interviews')

@section('page_header')
    <h1 class="text-2xl font-bold text-hb-navy">Interviews</h1>
    <p class="mt-1 text-sm text-hb-muted">Book a time, or change it up to 24 hours before the interview.</p>
@endsection

@section('content')
    @php $items = collect(data_get($interviews, 'data', $interviews)); @endphp

    @if ($items->isEmpty())
        <x-card><x-empty-state title="No interviews yet">When a company invites you to an interview round it will appear here.</x-empty-state></x-card>
    @else
        <div class="space-y-4">
            @foreach ($items as $iv)
                @php
                    $id = data_get($iv, 'id');
                    $start = data_get($iv, 'booking.start_at', data_get($iv, 'start_at'));
                    $status = strtolower((string) data_get($iv, 'status'));
                    $booked = ! empty($start);
                    $closed = in_array($status, ['cancelled', 'canceled', 'completed', 'rejected'], true);
                @endphp
                <x-card>
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h2 class="text-base font-semibold text-hb-navy">
                                {{ data_get($iv, 'application.job.title', data_get($iv, 'job_title', 'Interview')) }}
                                <span class="font-normal text-hb-muted">· Round {{ data_get($iv, 'round_no', 1) }}</span>
                            </h2>
                            <p class="text-sm text-hb-muted">
                                {{ \Illuminate\Support\Str::headline((string) data_get($iv, 'interview_type', '')) }}
                                @if (data_get($iv, 'location')) · {{ data_get($iv, 'location') }} @endif
                            </p>
                        </div>
                        @include('frontend.partials.status-badge', ['status' => $status])
                    </div>

                    <p class="mt-3 text-sm text-hb-text">
                        @if ($booked) <span class="font-medium">When:</span> <span dir="ltr">{{ str_replace('T', ' ', \Illuminate\Support\Str::before((string) $start, '.')) }}</span>
                        @else No time booked yet. @endif
                    </p>
                    @if (data_get($iv, 'meeting_link'))
                        <p class="mt-1 text-sm"><a href="{{ data_get($iv, 'meeting_link') }}" target="_blank" rel="noopener" class="font-semibold text-hb-blue hover:underline">Join meeting</a></p>
                    @endif

                    @unless ($closed)
                        <div class="mt-4 flex flex-wrap items-center gap-2">
                            @if (! $booked)
                                <x-button size="sm" :href="route('frontend.candidate.interviews.slots', ['interview_id' => $id])">Book a slot</x-button>
                            @else
                                <x-button size="sm" variant="light" :href="route('frontend.candidate.interviews.slots', ['reschedule' => $id])">Reschedule</x-button>
                                <form method="POST" action="{{ route('frontend.candidate.interviews.cancel', ['interviewId' => $id]) }}" onsubmit="return confirm('Cancel this interview? This is only allowed at least 24 hours before it starts.')">
                                    @csrf
                                    <x-button size="sm" type="submit" variant="destructive">Cancel</x-button>
                                </form>
                            @endif
                        </div>
                    @endunless
                </x-card>
            @endforeach
        </div>
    @endif
@endsection
