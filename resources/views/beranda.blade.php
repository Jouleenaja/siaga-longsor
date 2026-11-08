@extends('layouts.app')
@section('title', 'Siaga Longsor - Beranda')

@php
    $theme = [
        'normal'  => ['bg' => 'bg-brand-soft', 'text' => 'text-[#125c52]'],
        'waspada' => ['bg' => 'bg-[#fff3cf]',  'text' => 'text-[#8a6100]'],
        'awas'    => ['bg' => 'bg-[#ffe1e1]',  'text' => 'text-[#b00020]'],
    ][$status['level']];
    $s = $status['sensors'];
@endphp

@section('content')
    <header class="h-[193px] bg-brand pl-[104px] pt-[27px] text-white">
        <h1 class="text-[30px] font-medium leading-9">Siaga Longsor</h1>
        <p class="text-[14px] leading-5">Monitoring Lereng</p>
    </header>

    <main class="-mt-[59px] px-[17px]">
        {{-- Status lereng --}}
        <section class="card-shadow flex h-[140px] items-center gap-[10px] rounded-[28px] {{ $theme['bg'] }} pl-[29px] pr-4">
            <x-icon name="shield" class="h-[62px] w-[62px] shrink-0 text-neutral-900" stroke="1.5" />
            <div class="{{ $theme['text'] }}">
                <p class="text-base leading-5 underline underline-offset-2">Status Lereng</p>
                <p class="text-[40px] font-medium leading-[44px]">{{ $status['label'] }}</p>
                <p class="text-[13px] leading-[18px]">{{ $status['message'] }}</p>
            </div>
        </section>

        {{-- Kartu sensor --}}
        <section class="mt-[23px] grid grid-cols-2 gap-x-4 gap-y-6 px-[2px]">
            <div class="card-shadow h-[145px] rounded-3xl bg-[#f4f7fb] px-[11px] pt-3">
                <span class="flex h-[38px] w-[38px] items-center justify-center rounded-full bg-[#e3eeeb]"><x-icon name="triangle" class="h-5 w-5" /></span>
                <p class="mt-[5px] text-[14px] leading-[18px]">Kemiringan</p>
                <p class="text-xl font-medium leading-[26px]">{{ $s['kemiringan']['text'] }}</p>
                <p class="mt-1 text-[14px] leading-[18px]">({{ $s['kemiringan']['value'] }})</p>
            </div>

            <div class="card-shadow h-[145px] rounded-3xl bg-[#f4f7fb] px-[11px] pt-3">
                <span class="flex h-[38px] w-[38px] items-center justify-center rounded-full bg-[#e3eeeb]"><x-icon name="activity" class="h-5 w-5" /></span>
                <p class="mt-[5px] text-[14px] leading-[18px]">Getaran</p>
                <p class="text-xl font-medium leading-[26px]">{{ $s['getaran']['text'] }}</p>
                <p class="mt-1 text-[14px] leading-[18px]">({{ $s['getaran']['value'] }})</p>
            </div>

            <div class="card-shadow h-[145px] rounded-3xl bg-[#f4f7fb] px-[11px] pt-3">
                <span class="flex h-[38px] w-[38px] items-center justify-center rounded-full bg-[#e3eeeb]"><x-icon name="droplet" class="h-5 w-5" /></span>
                <p class="mt-[5px] text-[14px] leading-[18px]">Kelembapan Tanah</p>
                <p class="text-xl font-medium leading-[26px]">{{ $s['kelembapan_tanah']['value'] }}</p>
                <p class="mt-1 text-[14px] leading-[18px]">({{ $s['kelembapan_tanah']['text'] }})</p>
            </div>

            <div class="card-shadow h-[145px] rounded-3xl bg-[#f4f7fb] px-[11px] pt-3">
                <span class="flex h-[38px] w-[38px] items-center justify-center rounded-full bg-[#e3eeeb]"><x-icon name="thermometer" class="h-5 w-5" /></span>
                <p class="mt-[5px] text-[14px] leading-[18px]">Suhu dan Kelembapan Udara</p>
                <p class="text-xl font-medium leading-[26px]">{{ $s['suhu']['value'] }} | {{ $s['kelembapan_udara']['value'] }}</p>
                <p class="mt-1 text-[14px] leading-[18px]">(DHT11)</p>
            </div>
        </section>
    </main>
@endsection
