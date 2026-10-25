@extends('frontend.layouts.app')
@php $uiRole = 'company'; @endphp

@section('title', 'Change password')

@section('content')
    @include('frontend.partials.change-password-form', ['action' => 'frontend.company.change-password.submit', 'cancel' => 'frontend.company.profile'])
@endsection
