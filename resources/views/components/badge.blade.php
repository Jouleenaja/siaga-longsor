@props(['level' => 'normal'])
@php
    $cls = [
        'normal'  => 'min-w-[56px] bg-[#2cf2a6] text-neutral-900',
        'waspada' => 'min-w-[65px] bg-[#fde8ab] text-[#eeb100]',
        'awas'    => 'min-w-[68px] bg-[#fadadf] text-[#d3101f]',
    ][$level] ?? 'min-w-[56px] bg-[#2cf2a6] text-neutral-900';
@endphp
<span {{ $attributes->merge(['class' => "inline-block shrink-0 rounded-full px-2.5 text-center text-[13px] leading-4 $cls"]) }}>{{ $slot }}</span>
