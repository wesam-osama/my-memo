@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Add experience')

@section('page_header')
    <h1 class="text-2xl font-bold text-hb-navy">Add experience</h1>
    <p class="mt-1 text-sm text-hb-muted">Tell us about a role you held.</p>
@endsection

@section('content')
    <x-card class="max-w-2xl">
        <form method="POST" action="{{ route('frontend.candidate.experience.add.submit') }}" class="space-y-5">
            @csrf

            <div class="grid gap-5 sm:grid-cols-2">
                <x-form.input name="job_title" label="Job title" required :value="old('job_title')" :error="$errors->first('job_title')" />
                <x-form.input name="company_name" label="Company" required :value="old('company_name')" :error="$errors->first('company_name')" />
            </div>
            <x-form.input name="place" label="Place" :value="old('place')" :error="$errors->first('place')" />
            <div class="grid gap-5 sm:grid-cols-2">
                <x-form.input name="start_date" label="Start date" type="date" required :value="old('start_date')" :error="$errors->first('start_date')" />
                <x-form.input name="end_date" id="end_date" label="End date" type="date" :value="old('end_date')" :error="$errors->first('end_date')" />
            </div>
            <div>
                <input type="hidden" name="is_current" value="0">
                <x-form.checkbox name="is_current" id="is_current" label="I currently work here" :checked="old('is_current')" />
            </div>
            <x-form.textarea name="description" label="Description" :rows="4" :error="$errors->first('description')">{{ old('description') }}</x-form.textarea>

            <div class="flex flex-wrap items-center gap-3 pt-1">
                <x-button type="submit">Save</x-button>
                <x-button variant="light" :href="route('frontend.candidate.profile')">Cancel</x-button>
            </div>
        </form>
    </x-card>
@endsection

@push('scripts')
<script>
    const cur = document.getElementById('is_current'), end = document.getElementById('end_date');
    if (cur && end) {
        const sync = () => { end.disabled = cur.checked; if (cur.checked) end.value = ''; };
        cur.addEventListener('change', sync); sync();
    }
</script>
@endpush
