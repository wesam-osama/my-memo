@extends('frontend.layouts.app')

@section('title', __('My account'))

@section('page_header')
    <h1 class="text-2xl font-semibold tracking-tight text-hb-navy">{{ __('My account') }}</h1>
@endsection

@section('page_actions')
    <x-button variant="primary" size="md" :href="route('frontend.account.profile.update')">{{ __('Edit') }}</x-button>
    <x-button variant="light" size="md" :href="route('frontend.account.change-password')">{{ __('Change password') }}</x-button>
@endsection

@section('content')
<x-card class="max-w-2xl">@include('frontend.partials.record', ['record' => $profile ?? []])</x-card>
@endsection
