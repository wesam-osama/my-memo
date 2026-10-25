@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Change password')

@section('content')
    @include('frontend.partials.change-password-form', ['action' => 'frontend.candidate.change-password.submit', 'cancel' => 'frontend.candidate.profile'])
@endsection
