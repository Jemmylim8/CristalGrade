@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'mb-4 px-4 py-3 rounded bg-green-100 border border-green-400 text-green-800 font-semibold shadow']) }}>
        {{ $status }}
    </div>
@endif

