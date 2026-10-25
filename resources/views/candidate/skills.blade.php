@extends('frontend.layouts.app')
@php $uiRole = 'candidate'; @endphp

@section('title', 'Add skill')

@section('page_header')
    <h1 class="text-2xl font-bold text-hb-navy">Add skill</h1>
    <p class="mt-1 text-sm text-hb-muted">Choose a skill and how well you know it.</p>
@endsection

@section('content')
    <x-card class="max-w-2xl">
        <form method="POST" action="{{ route('frontend.candidate.skills.add.submit') }}" class="space-y-5">
            @csrf

            <x-form.select name="skill_id" id="skill_id" label="Skill" required :error="$errors->first('skill_id')">
                <option value="">Loading skills…</option>
            </x-form.select>
            <x-form.select name="level" label="Level" :error="$errors->first('level')">
                <option value="">Not specified</option>
                @foreach (['Beginner', 'Intermediate', 'Advanced', 'Expert'] as $lvl)
                    <option value="{{ $lvl }}" @selected(old('level') === $lvl)>{{ $lvl }}</option>
                @endforeach
            </x-form.select>

            <div class="flex flex-wrap items-center gap-3 pt-1">
                <x-button type="submit">Save</x-button>
                <x-button variant="light" :href="route('frontend.candidate.profile')">Cancel</x-button>
            </div>
        </form>
    </x-card>
@endsection

@push('scripts')
<script>
    (async () => {
        const select = document.getElementById('skill_id');
        const keep = @json(old('skill_id'));
        try {
            const res = await fetch(@json(route('frontend.lookup.skills')), { headers: { Accept: 'application/json' } });
            const body = await res.json();
            const list = body.skills?.data ?? body.skills ?? [];
            select.innerHTML = '<option value="">Select a skill</option>';
            list.forEach((s) => {
                const o = document.createElement('option');
                o.value = s.id; o.textContent = s.name + (s.type ? ' (' + s.type + ')' : '');
                if (String(s.id) === String(keep)) o.selected = true;
                select.appendChild(o);
            });
        } catch (e) {
            select.innerHTML = '<option value="">Could not load skills</option>';
        }
    })();
</script>
@endpush
