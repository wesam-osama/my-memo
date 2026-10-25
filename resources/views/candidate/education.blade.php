@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Add education')

@section('page_header')
    <h1 class="text-2xl font-bold text-hb-navy">Add education</h1>
    <p class="mt-1 text-sm text-hb-muted">Where did you study?</p>
@endsection

@section('content')
    <x-card class="max-w-2xl">
        <form method="POST" action="{{ route('frontend.candidate.education.add.submit') }}" class="space-y-5">
            @csrf

            <x-form.input name="institution" label="Institution" required :value="old('institution')" :error="$errors->first('institution')" />
            <div class="grid gap-5 sm:grid-cols-2">
                <x-form.input name="degree" label="Degree" required placeholder="e.g. Bachelor" :value="old('degree')" :error="$errors->first('degree')" />
                <x-form.input name="field_of_study" label="Field of study" required :value="old('field_of_study')" :error="$errors->first('field_of_study')" />
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <x-form.input name="graduation_year" label="Graduation year" type="number" min="1950" max="2100" required :value="old('graduation_year')" :error="$errors->first('graduation_year')" />
                <x-form.input name="place" label="Place" :value="old('place')" :error="$errors->first('place')" />
            </div>

            <div class="flex flex-wrap items-center gap-3 pt-1">
                <x-button type="submit">Save</x-button>
                <x-button variant="light" :href="route('frontend.candidate.profile')">Cancel</x-button>
            </div>
        </form>
    </x-card>
@endsection
