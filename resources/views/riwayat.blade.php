@extends('layouts.app')
@section('title', 'Siaga Longsor - Riwayat')

@php
    $iconMap = [
        'awas'    => ['bg-[#f96b6b]', 'triangle',       2],
        'normal'  => ['bg-[#2cf2a6]', 'circle-check',   2.2],
        'waspada' => ['bg-[#fdc84f]', 'alert-triangle', 2.4],
    ];
    $badgeText = ['awas' => 'Awas', 'normal' => 'Normal', 'waspada' => 'Waspada'];
@endphp

@section('content')
    <header class="flex h-[90px] items-center gap-[23px] pb-2 pl-[21px]">
        <a href="{{ route('beranda') }}" aria-label="Kembali">
            <x-icon name="arrow-left" class="h-[22px] w-[22px]" stroke="2.8" />
        </a>
        <h1 class="text-2xl font-medium">Riwayat</h1>
    </header>

    <main class="flex flex-col gap-[25px] px-[25px]">
        @forelse ($riwayats as $r)
            <div class="card-shadow flex h-20 items-center gap-[17px] rounded-[14px] bg-[#f4f7fb] px-3">
                <span class="flex h-[43px] w-[43px] shrink-0 items-center justify-center rounded-full {{ $iconMap[$r->level][0] }}">
                    <x-icon :name="$iconMap[$r->level][1]" class="h-6 w-6" :stroke="$iconMap[$r->level][2]" />
                </span>
                <div class="min-w-0 flex-1 text-[13px] leading-[18px]">
                    <p>{{ $r->waktu }}</p>
                    <p>{{ $r->judul }}</p>
                </div>
                <x-badge :level="$r->level">{{ $badgeText[$r->level] }}</x-badge>
            </div>
        @empty
            <p class="pt-10 text-center text-neutral-500">Belum ada riwayat kejadian.</p>
        @endforelse
    </main>
@endsection
