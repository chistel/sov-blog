<?php
// Here we get the name of your alpine variable and the
// value for the toggle
$alpineVar = $attributes->whereStartsWith('x-model')->first();
$value = $attributes->whereStartsWith('value')->first();

// Here we build the javascript expression used to check
// our permissions array for the toggle value
$expression = "$alpineVar.includes('$value')";
?>
<div class="flex justify-center items-center">
    <div
        {{ $attributes->whereStartsWith('class')->merge(['class' => 'relative rounded-full transition duration-200 ease-linear' ]) }}
        :class="[
        {{ $expression }} ? 'bg-green-400' : 'bg-gray-400'
    ]">
        <label
            for="toggle{{ $id }}"
            class="absolute left-0 bg-white border-2 mb-2 w-1/2 h-full rounded-full transition transform duration-100 ease-linear cursor-pointer"
            :class="[
            {{ $expression }} ? 'translate-x-full border-green-400' : 'translate-x-0 border-gray-400'
        ]"></label>
        <input id="toggle{{ $id }}" type="checkbox" class="appearance-none w-full h-full active:outline-none focus:outline-none" {{ $attributes }} />
    </div>
</div>
