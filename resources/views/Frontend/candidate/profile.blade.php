@extends('frontend.layouts.app')

@section('title', __('Profile & resume'))

@section('page_header')
    <h1 class="text-2xl font-semibold tracking-tight text-hb-navy">{{ __('Profile & resume') }}</h1>
@endsection

@section('page_actions')
    <x-button variant="primary" size="md" :href="route('frontend.candidate.profile.update')">{{ __('Edit profile') }}</x-button>
    <x-button variant="light" size="md" :href="route('frontend.candidate.resume.upload')">{{ __('Upload resume') }}</x-button>
    <x-button variant="light" size="md" :href="route('frontend.candidate.education.add')">{{ __('Add education') }}</x-button>
    <x-button variant="light" size="md" :href="route('frontend.candidate.experience.add')">{{ __('Add experience') }}</x-button>
    <x-button variant="light" size="md" :href="route('frontend.candidate.skills.add')">{{ __('Add skill') }}</x-button>
    <x-button variant="light" size="md" :href="route('frontend.candidate.change-password')">{{ __('Change password') }}</x-button>
@endsection

@section('content')
<x-card>@include('frontend.partials.record', ['record' => $profile ?? []])</x-card>
<x-card class="mt-6">
    <x-slot:header><h2 class="text-lg font-bold text-hb-navy">{{ __('Resumes') }}</h2></x-slot:header>
    @php $cvs = \App\Support\Rows::from(data_get($profile, 'cvs', data_get($profile, 'candidate_cvs', []))); @endphp
    @forelse ($cvs as $row)
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-hb-border py-3 last:border-0">
            <div>
                <p class="text-sm font-medium text-hb-navy">{{ data_get($row, 'original_filename', 'CV') }}</p>
                <p class="text-xs text-hb-muted">{{ \App\Support\Rows::date(data_get($row, 'uploaded_at')) }}</p>
            </div>
            <div class="flex gap-2">
                <x-button variant="light" size="sm" :href="route('frontend.candidate.resume.download', ['resumeId' => data_get($row, 'id')])">{{ __('Download') }}</x-button>
                <form method="POST" action="{{ route('frontend.candidate.resume.delete', ['resumeId' => data_get($row, 'id')]) }}" onsubmit="return confirm('{{ __('Delete this resume?') }}')">@csrf @method('DELETE')<x-button type="submit" size="sm" variant="destructive">{{ __('Delete') }}</x-button></form>
            </div>
        </div>
    @empty
        <p class="text-sm text-hb-muted">{{ __('No resumes uploaded yet.') }}</p>
    @endforelse
</x-card>

<x-card class="mt-6">
    <h2 class="text-lg font-bold text-hb-navy">{{ __('Delete account') }}</h2>
    <p class="mt-1 text-sm text-hb-muted">{{ __('This permanently removes your account and data.') }}</p>
    <form method="POST" action="{{ route('frontend.candidate.delete-account') }}" class="mt-4" onsubmit="return confirm('{{ __('Delete your account permanently?') }}')">@csrf @method('DELETE')<x-button type="submit" variant="destructive">{{ __('Delete account') }}</x-button></form>
</x-card>
@endsection
