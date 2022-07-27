@props(["tagsCsv"])

@php
    $tags = explode(",", $tagsCsv); // This will split $tagsCsv into an array seperating its values at each comma ",".
@endphp

<ul class="flex">
    @foreach ($tags as $tag)
        <li {{ $attributes }}> {{-- This will apply the attributes <x-listing-tags/> has to this <li></li> tag --}}
            <a href="/?tag={{ $tag }}">{{ $tag }}</a> {{-- The href is a link to the tag filter --}}
        </li>
    @endforeach
</ul>