@php
    $jobId = $jobId ?? null;
    $type = auth()->user()?->account_type;
@endphp
@guest
    <x-button :href="route('frontend.account.login')">Sign in to apply</x-button>
@endguest
@auth
    @if ($type === 'candidate')
        <x-button :href="route('frontend.candidate.vacancies.apply', ['vacancyId' => $jobId])">Apply now</x-button>
    @endif
@endauth
