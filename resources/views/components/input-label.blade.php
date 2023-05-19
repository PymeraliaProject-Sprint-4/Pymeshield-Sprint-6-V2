@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-label text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
