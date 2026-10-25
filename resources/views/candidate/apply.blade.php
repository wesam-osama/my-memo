@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Apply')

@section('page_header')
    @include('frontend.partials.page-back', ['route' => 'frontend.candidate.vacancies.index', 'label' => 'Back to jobs'])
    <h1 class="mt-2 text-2xl font-bold text-hb-navy">Apply for this job</h1>
    <p class="mt-1 text-sm text-hb-muted">Your resume is required. The AI matches it against the job requirements and a recruiter reviews the result.</p>
@endsection

@section('content')
    @php $cvList = collect($cvs ?? []); @endphp
    <x-card class="max-w-2xl">
        @if ($cvList->isEmpty())
            <x-empty-state title="Upload a resume first" action-label="Upload resume" :action-href="route('frontend.candidate.resume.upload')">
                You need at least one resume on your profile to apply.
            </x-empty-state>
        @else
            <form method="POST" action="{{ route('frontend.candidate.vacancies.apply.submit', ['vacancyId' => $vacancyId]) }}" class="space-y-5">
                @csrf
                <x-form.select name="cv_id" label="Resume" required :error="$errors->first('cv_id')">
                    @foreach ($cvList as $cv)
                        <option value="{{ data_get($cv, 'id') }}" @selected(old('cv_id', $cvList->firstWhere('is_active', true) ? data_get($cvList->firstWhere('is_active', true), 'id') : null) == data_get($cv, 'id'))>
                            {{ data_get($cv, 'original_filename', 'Resume') }} (v{{ data_get($cv, 'version', 1) }}){{ data_get($cv, 'is_active') ? ' — active' : '' }}
                        </option>
                    @endforeach
                </x-form.select>
                <x-form.textarea name="cover_note" label="Cover note (optional)" :rows="5" :error="$errors->first('cover_note')">{{ old('cover_note') }}</x-form.textarea>
                <div>
                    <x-form.checkbox name="consent" required>I agree that my resume is analysed by AI to help screen this application.</x-form.checkbox>
                    @error('consent') <p class="hb-field-error" role="alert">{{ $message }}</p> @enderror
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <x-button type="submit">Submit application</x-button>
                    <x-button variant="light" :href="route('frontend.candidate.vacancies.index')">Cancel</x-button>
                </div>
            </form>
        @endif
    </x-card>
@endsection
