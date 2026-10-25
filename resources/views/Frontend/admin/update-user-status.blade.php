@extends('frontend.layouts.app')

@section('title', __('Change user status'))

@section('page_header')
    <h1 class="text-2xl font-semibold tracking-tight text-hb-navy">{{ __('Change user status') }}</h1>
@endsection

@section('content')
<x-card class="max-w-2xl">
    <x-slot:header>
        <h2 class="text-lg font-bold text-hb-navy">{{ __('Change user status') }}</h2>
    </x-slot:header>

    
    <form method="POST" action="{{ route('frontend.admin.users.status.submit', ['userId' => $userId]) }}" class="space-y-5">
        @csrf
        <x-form.select name="account_status" :label="__('Status')" :required="true" :error="$errors->first('account_status')">
        <option value="">{{ __('Select…') }}</option>
        <option value="active" @selected((string) old('account_status', data_get([], 'account_status', '')) === 'active')>{{ __('Active') }}</option>
        <option value="suspended" @selected((string) old('account_status', data_get([], 'account_status', '')) === 'suspended')>{{ __('Suspended') }}</option>
        <option value="banned" @selected((string) old('account_status', data_get([], 'account_status', '')) === 'banned')>{{ __('Banned') }}</option>
    </x-form.select>
        <div class="flex flex-wrap items-center gap-3 pt-1">
            <x-button type="submit">{{ __('Save') }}</x-button>
            <x-button variant="light" :href="route('frontend.admin.users.index')">{{ __('Cancel') }}</x-button>
        </div>
    </form>
    
</x-card>
@endsection
