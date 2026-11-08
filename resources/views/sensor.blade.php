@extends('layouts.app')
@section('title', 'Siaga Longsor - Detail Sensor')

@php
    $s = $status['sensors'];
    $rows = [
        ['Kemiringan',       'triangle',    $s['kemiringan']],
        ['Getaran',          'activity',    $s['getaran']],
        ['Kelembapan Tanah', 'droplet',     $s['kelembapan_tanah']],
        ['Suhu',             'thermometer', $s['suhu']],
        ['Kelembapan Udara', 'droplet',     $s['kelembapan_udara']],
    ];
@endphp

@section('content')
    <header class="relative flex h-[90px] items-center justify-center pb-2">
        <a href="{{ route('beranda') }}" class="absolute left-[22px]" aria-label="Kembali">
            <x-icon name="arrow-left" class="h-[22px] w-[22px]" stroke="2.8" />
        </a>
        <h1 class="text-[23px] font-medium">Detail Sensor</h1>
    </header>

    <main class="flex flex-col gap-[25px] px-[25px]">
        @foreach ($rows as [$nama, $icon, $d])
            <div class="card-shadow flex h-20 items-center gap-4 rounded-[14px] bg-[#f4f7fb] px-3">
                <span class="flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-full bg-[#e3eeeb]"><x-icon :name="$icon" class="h-[22px] w-[22px]" /></span>
                <div class="min-w-0 flex-1">
                    <p class="text-xl font-medium leading-6">{{ $nama }}</p>
                    <p class="text-[14px] leading-[18px]">{{ $d['value'] }}</p>
                </div>
                <x-badge :level="$d['level']">{{ $d['badge'] }}</x-badge>
            </div>
        @endforeach
    </main>
@endsection
