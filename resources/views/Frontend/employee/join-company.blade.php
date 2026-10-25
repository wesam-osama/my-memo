@extends('frontend.layouts.app')

@section('title', __('Join a company'))

@section('page_header')
    <h1 class="text-2xl font-semibold tracking-tight text-hb-navy">{{ __('Join a company') }}</h1>
@endsection

@section('content')
<x-card class="max-w-2xl">
    <x-slot:header>
        <h2 class="text-lg font-bold text-hb-navy">{{ __('Join a company') }}</h2>
        <p class="mt-1 text-sm text-hb-muted">{{ __('The company admin will review your request.') }}</p>
    </x-slot:header>

    
    <form method="POST" action="{{ route('frontend.candidate.join-company.submit') }}" class="space-y-5">
        @csrf
        <x-form.input name="company_id" :label="__('Company ID')" type="number" :required="true" :error="$errors->first('company_id')" value="{{ old('company_id', data_get([], 'company_id', '')) }}" min="1" />
        <x-form.input name="requested_job_title" :label="__('Your job title')" type="text" :required="true" :error="$errors->first('requested_job_title')" value="{{ old('requested_job_title', data_get([], 'requested_job_title', '')) }}" />
        <x-form.input name="requested_department" :label="__('Department')" type="text" :required="true" :error="$errors->first('requested_department')" value="{{ old('requested_department', data_get([], 'requested_department', '')) }}" />
        <div class="flex flex-wrap items-center gap-3 pt-1">
            <x-button type="submit">{{ __('Send request') }}</x-button>
            <x-button variant="light" :href="route('frontend.candidate.dashboard')">{{ __('Cancel') }}</x-button>
        </div>
    </form>
    
</x-card>
@endsection
