@extends('frontend.layouts.app')

@section('title', __('Edit account'))

@section('page_header')
    <h1 class="text-2xl font-semibold tracking-tight text-hb-navy">{{ __('Edit account') }}</h1>
@endsection

@section('content')
<x-card class="max-w-2xl">
    <x-slot:header>
        <h2 class="text-lg font-bold text-hb-navy">{{ __('Edit account') }}</h2>
    </x-slot:header>

    
    <form method="POST" action="{{ route('frontend.account.profile.update.submit') }}" class="space-y-5">
        @csrf
        <x-form.input name="name" :label="__('Name')" type="text" :required="true" :error="$errors->first('name')" value="{{ old('name', data_get(($prefill ?? []), 'name', '')) }}" />
        <x-form.input name="email" :label="__('Email')" type="email" :required="true" :error="$errors->first('email')" value="{{ old('email', data_get(($prefill ?? []), 'email', '')) }}" />
        <x-form.select name="locale" :label="__('Language')" :error="$errors->first('locale')">
        <option value="">{{ __('Select…') }}</option>
        <option value="ar" @selected((string) old('locale', data_get(($prefill ?? []), 'locale', '')) === 'ar')>{{ __('العربية') }}</option>
        <option value="en" @selected((string) old('locale', data_get(($prefill ?? []), 'locale', '')) === 'en')>{{ __('English') }}</option>
    </x-form.select>
        <x-form.select name="theme" :label="__('Theme')" :error="$errors->first('theme')">
        <option value="">{{ __('Select…') }}</option>
        <option value="system" @selected((string) old('theme', data_get(($prefill ?? []), 'theme', '')) === 'system')>{{ __('System') }}</option>
        <option value="light" @selected((string) old('theme', data_get(($prefill ?? []), 'theme', '')) === 'light')>{{ __('Light') }}</option>
        <option value="dark" @selected((string) old('theme', data_get(($prefill ?? []), 'theme', '')) === 'dark')>{{ __('Dark') }}</option>
    </x-form.select>
        <div class="flex flex-wrap items-center gap-3 pt-1">
            <x-button type="submit">{{ __('Save') }}</x-button>
            <x-button variant="light" :href="route('frontend.account.profile')">{{ __('Cancel') }}</x-button>
        </div>
    </form>
    
</x-card>
@endsection
