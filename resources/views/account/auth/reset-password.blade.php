@extends('frontend.layouts.auth')

@section('title', 'Reset password')

@section('content')
    <h1 class="text-3xl font-black tracking-tight">Choose a new password</h1>

    <p class="mt-2 text-sm text-slate-500">Enter and confirm your new password to finish resetting it.</p>

    <form method="POST" action="{{ route('frontend.account.reset-password.submit', ['token' => $token]) }}" class="mt-8 space-y-5">
        @csrf

        <x-auth-field name="new_password" label="New password" type="password" icon="lock" placeholder="Min. 6 characters" autocomplete="new-password" required autofocus />
        <x-auth-field name="new_password_confirmation" label="Confirm new password" type="password" icon="lock" placeholder="Repeat password" autocomplete="new-password" required />

        <button type="submit"
            class="w-full rounded-full bg-sky-500 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-sky-500/25 transition hover:-translate-y-0.5 hover:bg-sky-600 focus:outline-none focus-visible:ring-4 focus-visible:ring-sky-500/30">
            Reset password
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-500">
        <a href="{{ route('frontend.account.login') }}" class="font-bold text-sky-600 hover:underline">Back to log in</a>
    </p>
@endsection
