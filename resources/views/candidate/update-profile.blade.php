@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Edit profile')

@section('page_header')
    <h1 class="text-2xl font-bold text-hb-navy">Edit profile</h1>
    <p class="mt-1 text-sm text-hb-muted">Keep your details current.</p>
@endsection

@section('content')
    <x-card class="max-w-2xl">
        <form method="POST" action="{{ route('frontend.candidate.profile.update.submit') }}" class="space-y-5">
            @csrf

            <div class="grid gap-5 sm:grid-cols-2">
                <x-form.input name="phone" label="Phone" type="tel" :value="old('phone', data_get($profile ?? [], 'phone'))" :error="$errors->first('phone')" />
                <x-form.input name="location" label="Location" :value="old('location', data_get($profile ?? [], 'location'))" :error="$errors->first('location')" />
            </div>
            <x-form.input name="headline" label="Headline" placeholder="e.g. Backend developer" :value="old('headline', data_get($profile ?? [], 'headline'))" :error="$errors->first('headline')" />
            <x-form.textarea name="bio" label="Bio" :rows="5" :error="$errors->first('bio')">{{ old('bio', data_get($profile ?? [], 'bio')) }}</x-form.textarea>
            <div class="grid items-end gap-5 sm:grid-cols-2">
                <x-form.input name="years_experience" label="Years of experience" type="number" min="0" :value="old('years_experience', data_get($profile ?? [], 'years_experience'))" :error="$errors->first('years_experience')" />
                <div>
                    <input type="hidden" name="has_no_experience" value="0">
                    <x-form.checkbox name="has_no_experience" label="I have no professional experience yet" :checked="old('has_no_experience', data_get($profile ?? [], 'has_no_experience'))" />
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 pt-1">
                <x-button type="submit">Save</x-button>
                <x-button variant="light" :href="route('frontend.candidate.profile')">Cancel</x-button>
            </div>
        </form>
    </x-card>
@endsection
