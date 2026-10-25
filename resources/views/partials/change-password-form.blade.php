@php
    // $action: form route name, $cancel: where "Cancel" goes
@endphp
<x-card class="max-w-xl">
    <x-slot:header>
        <h1 class="text-lg font-bold text-hb-navy">Change password</h1>
        <p class="mt-1 text-sm text-hb-muted">Use at least 6 characters. You will stay signed in on this device.</p>
    </x-slot:header>

    <form method="POST" action="{{ route($action) }}" class="space-y-5">
        @csrf

        @foreach ([
            ['current_password', 'Current password', 'current-password'],
            ['new_password', 'New password', 'new-password'],
            ['new_password_confirmation', 'Confirm new password', 'new-password'],
        ] as [$name, $label, $autocomplete])
            <div>
                <label for="{{ $name }}" class="mb-1.5 block text-sm font-semibold text-hb-text">{{ $label }}</label>
                <input
                    id="{{ $name }}"
                    name="{{ $name }}"
                    type="password"
                    autocomplete="{{ $autocomplete }}"
                    required
                    @error($name) aria-invalid="true" @enderror
                    class="min-h-11 w-full rounded-md border bg-hb-surface px-3 text-sm text-hb-text focus:border-hb-blue focus:outline-none focus:ring-2 focus:ring-hb-blue/30 {{ $errors->has($name) ? 'border-hb-error' : 'border-hb-border' }}"
                >
                @error($name)
                    <p class="mt-1.5 text-sm text-hb-error" role="alert">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        <div class="flex flex-wrap items-center gap-3 pt-1">
            <x-button type="submit">Update password</x-button>
            <x-button variant="light" :href="route($cancel)">Cancel</x-button>
        </div>
    </form>
</x-card>
