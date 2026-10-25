@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'My applications')

@section('page_header')
    <h1 class="text-2xl font-bold text-hb-navy">My applications</h1>
    <p class="mt-1 text-sm text-hb-muted">Every job you applied to and where it stands.</p>
@endsection

@section('content')
    @php $items = collect(data_get($applications, 'data', $applications)); @endphp

    @if ($items->isEmpty())
        <x-card><x-empty-state title="No applications yet" action-label="Discover jobs" :action-href="route('frontend.candidate.vacancies.index')">
            When you apply for a job it will appear here.
        </x-empty-state></x-card>
    @else
        <x-table>
            <x-slot:head>
                <th class="px-4 py-3">Job</th>
                <th class="px-4 py-3">Company</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Applied</th>
                <th class="px-4 py-3"><span class="sr-only">Actions</span></th>
            </x-slot:head>
            @foreach ($items as $app)
                <tr>
                    <td class="px-4 py-3 font-medium text-hb-navy">{{ data_get($app, 'job.title', data_get($app, 'job_title')) }}</td>
                    <td class="px-4 py-3">{{ data_get($app, 'job.company.name', data_get($app, 'company_name')) }}</td>
                    <td class="px-4 py-3">@include('frontend.partials.status-badge', ['status' => data_get($app, 'status')])</td>
                    <td class="px-4 py-3 text-hb-muted">{{ \Illuminate\Support\Str::before((string) data_get($app, 'applied_at'), 'T') }}</td>
                    <td class="px-4 py-3 text-end">
                        <a href="{{ route('frontend.candidate.applications.show', ['applicationId' => data_get($app, 'id')]) }}" class="font-semibold text-hb-blue hover:underline">View</a>
                    </td>
                </tr>
            @endforeach
        </x-table>
    @endif
@endsection
