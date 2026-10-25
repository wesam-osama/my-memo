
@extends('layouts.public')

@section('title', 'Home | Recruitment Platform')

@section('content')
    <section class="hero">
        <h1>Find Your Next Opportunity</h1>

        <p>
            Discover jobs that match your skills
            and take the next step in your career.
        </p>

        <a href="{{ route('jobs.index') }}">
            Explore Jobs
        </a>

        <a href="{{route('candidate.register') }}">
            Create Account
        </a>
    </section>
@endsection
