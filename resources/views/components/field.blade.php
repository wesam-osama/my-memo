@props(['name', 'label', 'type' => 'text'])
<div class="space-y-1">
  <label for="{{ $name }}" class="text-sm font-semibold">{{ $label }}</label>
  <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
         value="{{ $type === 'password' ? '' : old($name) }}"
         {{ $attributes->merge(['class' => 'w-full rounded-lg border border-line bg-white px-3 py-2.5 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30']) }}>
  @error($name)<p class="text-sm text-red-600">{{ $message }}</p>@enderror
</div>