@extends('frontend.layouts.app')

@section('title', __('Apply for this job'))

@section('page_header')
    <h1 class="text-2xl font-semibold tracking-tight text-hb-navy">{{ __('Apply for this job') }}</h1>
@endsection

@section('content')
<x-card class="max-w-2xl">
    <x-slot:header>
        <h2 class="text-lg font-bold text-hb-navy">{{ __('Apply for this job') }}</h2>
    </x-slot:header>

    
    <form method="POST" action="{{ route('frontend.candidate.vacancies.apply.submit', ['vacancyId' => $vacancyId]) }}" class="space-y-5">
        @csrf
        <x-form.select name="cv_id" :label="__('Resume')" :required="true" :error="$errors->first('cv_id')">
        <option value="">{{ __('Select…') }}</option>
        @foreach (\App\Support\Rows::from($cvs ?? []) as $opt)
            <option value="{{ data_get($opt, 'id') }}" @selected((string) old('cv_id', data_get([], 'cv_id', '')) === (string) data_get($opt, 'id'))>{{ data_get($opt, 'original_filename') }}</option>
        @endforeach
    </x-form.select>
        <x-form.textarea name="cover_note" :label="__('Cover note')" rows="5" :error="$errors->first('cover_note')">{{ old('cover_note', data_get([], 'cover_note', '')) }}</x-form.textarea>
        <x-form.checkbox name="consent" :label="__('I consent to sharing my profile and resume with this company')" value="1" @checked(old('consent', data_get([], 'consent')))/>
    @error('consent')<p class="hb-field-error" role="alert">{{ $message }}</p>@enderror
        <div class="flex flex-wrap items-center gap-3 pt-1">
            <x-button type="submit">{{ __('Submit application') }}</x-button>
            <x-button variant="light" :href="route('frontend.candidate.vacancies.index')">{{ __('Cancel') }}</x-button>
        </div>
    </form>
    @if (empty($cvs ?? []))<p class="mt-4 text-sm text-hb-muted">{{ __('You have no resume yet.') }} <a class="font-semibold text-hb-blue hover:underline" href="{{ route('frontend.candidate.resume.upload') }}">{{ __('Upload resume') }}</a></p>@endif
</x-card>
@endsection
