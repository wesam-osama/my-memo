@extends('frontend.layouts.app')

@section('title', __('Upload resume'))

@section('page_header')
    <h1 class="text-2xl font-semibold tracking-tight text-hb-navy">{{ __('Upload resume') }}</h1>
@endsection

@section('content')
<x-card class="max-w-2xl">
    <x-slot:header>
        <h2 class="text-lg font-bold text-hb-navy">{{ __('Upload resume') }}</h2>
    </x-slot:header>

    
    <form method="POST" action="{{ route('frontend.candidate.resume.upload.submit') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <x-form.file-upload name="resume" :label="__('Resume (PDF, DOC, DOCX — max 2 MB)')" :required="true" :error="$errors->first('resume')" />
        <div class="flex flex-wrap items-center gap-3 pt-1">
            <x-button type="submit">{{ __('Upload') }}</x-button>
            <x-button variant="light" :href="route('frontend.candidate.profile')">{{ __('Cancel') }}</x-button>
        </div>
    </form>
    
</x-card>
@endsection
