@extends('frontend.layouts.app')

@section('title', 'Change password')

@section('content')
    @include('frontend.partials.change-password-form', ['action' => 'frontend.account.change-password.submit', 'cancel' => 'frontend.account.profile'])
@endsection
