@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Company membership')

@section('page_header')
    <h1 class="text-2xl font-bold text-hb-navy">Company membership</h1>
    <p class="mt-1 text-sm text-hb-muted">Work at a company on TalentBridge? Ask to join it to see its private jobs. One company per person; the company admin approves your request.</p>
@endsection

@section('content')
    <x-card class="max-w-2xl">
        <form method="POST" action="{{ route('frontend.candidate.join-company.submit') }}" class="space-y-5">
            @csrf
            <x-form.input name="company_id" label="Company ID" type="number" min="1" required :value="old('company_id')" :error="$errors->first('company_id')" hint="Ask your company admin for the company ID." />
            <div class="grid gap-5 sm:grid-cols-2">
                <x-form.input name="requested_job_title" label="Your job title" required :value="old('requested_job_title')" :error="$errors->first('requested_job_title')" />
                <x-form.input name="requested_department" label="Department" required :value="old('requested_department')" :error="$errors->first('requested_department')" />
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <x-button type="submit">Send request</x-button>
                <x-button variant="light" :href="route('frontend.candidate.dashboard')">Cancel</x-button>
            </div>
        </form>
    </x-card>
@endsection
