@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Upload resume')

@section('page_header')
    <h1 class="text-2xl font-bold text-hb-navy">Upload resume</h1>
    <p class="mt-1 text-sm text-hb-muted">PDF, DOC or DOCX, up to 2 MB. Your newest upload becomes the active version.</p>
@endsection

@section('content')
    <x-card class="max-w-2xl">
        <form method="POST" action="{{ route('frontend.candidate.resume.upload.submit') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <x-form.file-upload name="resume" label="Resume file" accept=".pdf,.doc,.docx" required :error="$errors->first('resume')" hint="PDF, DOC or DOCX · max 2 MB" />

            <div class="flex flex-wrap items-center gap-3 pt-1">
                <x-button type="submit">Upload</x-button>
                <x-button variant="light" :href="route('frontend.candidate.profile')">Cancel</x-button>
            </div>
        </form>
    </x-card>
@endsection
