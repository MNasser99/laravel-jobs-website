{{-- This component adds the card effect(some border styles) to the things it surrounds. --}}
<div {{ $attributes->merge(["class" => "bg-gray-50 border border-gray-200 rounded p-6"]) }}> {{-- This allows us to add extra classes when using the <x-card></x-card> tags --}}
    {{ $slot }} {{-- This will allow us to add content in here when using this component's tags --}}
</div>