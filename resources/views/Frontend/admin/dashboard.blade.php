@extends('frontend.layouts.app')

@section('title', __('Overview'))

@section('page_header')
    <h1 class="text-2xl font-semibold tracking-tight text-hb-navy">{{ __('Overview') }}</h1>
@endsection

@section('content')
<x-welcome-banner :subtitle="__('Review companies, manage users and keep an eye on activity.')" />
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
    <x-stat-card :label="__('Companies')" value="→" :meta="__('Review company registrations')" :href="route('frontend.admin.companies.index')" />
    <x-stat-card :label="__('Users')" value="→" :meta="__('Manage user accounts')" :href="route('frontend.admin.users.index')" />
    <x-stat-card :label="__('Audit logs')" value="→" :meta="__('See what happened and when')" :href="route('frontend.admin.audit-logs.index')" />
</div>
@endsection
