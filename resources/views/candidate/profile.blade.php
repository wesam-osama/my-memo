@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Profile & resume')

@section('page_header')
    <h1 class="text-2xl font-bold text-hb-navy">Profile &amp; resume</h1>
    <p class="mt-1 text-sm text-hb-muted">This is what companies see when you apply.</p>
@endsection

@section('page_actions')
    <x-button :href="route('frontend.candidate.profile.update')">Edit profile</x-button>
@endsection

@section('content')
    @php
        $skills = collect(data_get($profile, 'skills', []));
        $experience = collect(data_get($profile, 'experience', []));
        $education = collect(data_get($profile, 'education', []));
        $cvs = collect(data_get($profile, 'cvs', []));
    @endphp

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <x-card>
                <x-slot:header><h2 class="text-base font-semibold text-hb-navy">About</h2></x-slot:header>
                <p class="text-lg font-semibold text-hb-navy">{{ data_get($profile, 'name', auth()->user()?->name) }}</p>
                @if (data_get($profile, 'headline'))
                    <p class="text-sm text-hb-text">{{ data_get($profile, 'headline') }}</p>
                @endif
                <dl class="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                    <div><dt class="text-hb-muted">Email</dt><dd class="font-medium">{{ data_get($profile, 'email', auth()->user()?->email) }}</dd></div>
                    <div><dt class="text-hb-muted">Phone</dt><dd class="font-medium">{{ data_get($profile, 'phone') ?: '—' }}</dd></div>
                    <div><dt class="text-hb-muted">Location</dt><dd class="font-medium">{{ data_get($profile, 'location') ?: '—' }}</dd></div>
                    <div><dt class="text-hb-muted">Experience</dt><dd class="font-medium">
                        {{ data_get($profile, 'has_no_experience') ? 'No professional experience yet' : (data_get($profile, 'years_experience') !== null ? data_get($profile, 'years_experience').' years' : '—') }}
                    </dd></div>
                </dl>
                @if (data_get($profile, 'bio'))
                    <p class="mt-4 whitespace-pre-line text-sm leading-relaxed text-hb-text">{{ data_get($profile, 'bio') }}</p>
                @endif
            </x-card>

            <x-card>
                <x-slot:header>
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="text-base font-semibold text-hb-navy">Experience</h2>
                        <x-button size="sm" variant="light" :href="route('frontend.candidate.experience.add')">Add</x-button>
                    </div>
                </x-slot:header>
                @forelse ($experience as $item)
                    <div class="border-b border-hb-border py-3 last:border-0">
                        <p class="font-semibold text-hb-navy">{{ data_get($item, 'job_title') }} <span class="font-normal text-hb-muted">· {{ data_get($item, 'company_name') }}</span></p>
                        <p class="text-xs text-hb-muted">
                            {{ data_get($item, 'start_date') }} – {{ data_get($item, 'is_current') ? 'Present' : data_get($item, 'end_date') }}
                            @if (data_get($item, 'place')) · {{ data_get($item, 'place') }} @endif
                        </p>
                        @if (data_get($item, 'description'))
                            <p class="mt-1 text-sm text-hb-text">{{ data_get($item, 'description') }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-hb-muted">No experience added yet.</p>
                @endforelse
            </x-card>

            <x-card>
                <x-slot:header>
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="text-base font-semibold text-hb-navy">Education</h2>
                        <x-button size="sm" variant="light" :href="route('frontend.candidate.education.add')">Add</x-button>
                    </div>
                </x-slot:header>
                @forelse ($education as $item)
                    <div class="border-b border-hb-border py-3 last:border-0">
                        <p class="font-semibold text-hb-navy">{{ data_get($item, 'degree') }} · {{ data_get($item, 'field_of_study') }}</p>
                        <p class="text-xs text-hb-muted">{{ data_get($item, 'institution') }} · {{ data_get($item, 'graduation_year') }}@if (data_get($item, 'place')) · {{ data_get($item, 'place') }}@endif</p>
                    </div>
                @empty
                    <p class="text-sm text-hb-muted">No education added yet.</p>
                @endforelse
            </x-card>
        </div>

        <div class="space-y-6">
            <x-card>
                <x-slot:header>
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="text-base font-semibold text-hb-navy">Resumes</h2>
                        <x-button size="sm" variant="light" :href="route('frontend.candidate.resume.upload')">Upload</x-button>
                    </div>
                </x-slot:header>
                @forelse ($cvs as $cv)
                    @php $cvId = data_get($cv, 'id'); @endphp
                    <div class="flex items-center justify-between gap-2 border-b border-hb-border py-2.5 text-sm last:border-0">
                        <div class="min-w-0">
                            <p class="truncate font-medium text-hb-navy">{{ data_get($cv, 'original_filename', 'Resume') }}</p>
                            <p class="text-xs text-hb-muted">
                                v{{ data_get($cv, 'version', 1) }}
                                @if (data_get($cv, 'is_active')) · <span class="text-hb-success">Active</span> @endif
                            </p>
                        </div>
                        <div class="flex shrink-0 items-center gap-2">
                            <a href="{{ route('frontend.candidate.resume.download', ['resumeId' => $cvId]) }}" class="text-xs font-semibold text-hb-blue hover:underline">Download</a>
                            <form method="POST" action="{{ route('frontend.candidate.resume.delete', ['resumeId' => $cvId]) }}" onsubmit="return confirm('Delete this resume?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-hb-error hover:underline">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-hb-muted">Upload a resume to be able to apply for jobs.</p>
                @endforelse
            </x-card>

            <x-card>
                <x-slot:header>
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="text-base font-semibold text-hb-navy">Skills</h2>
                        <x-button size="sm" variant="light" :href="route('frontend.candidate.skills.add')">Add</x-button>
                    </div>
                </x-slot:header>
                <div class="flex flex-wrap gap-2">
                    @forelse ($skills as $skill)
                        <x-badge variant="info">{{ data_get($skill, 'name') }}@if (data_get($skill, 'level')) · {{ data_get($skill, 'level') }}@endif</x-badge>
                    @empty
                        <p class="text-sm text-hb-muted">No skills added yet.</p>
                    @endforelse
                </div>
            </x-card>
        </div>
    </div>
@endsection
