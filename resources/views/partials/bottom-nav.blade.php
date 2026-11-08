@php
    $items = [
        ['route' => 'beranda', 'label' => 'Beranda', 'icon' => 'home'],
        ['route' => 'sensor',  'label' => 'Sensor',  'icon' => 'target'],
        ['route' => 'riwayat', 'label' => 'Riwayat', 'icon' => 'clock'],
    ];
@endphp
<nav class="fixed bottom-0 left-1/2 z-30 flex h-[66px] w-full max-w-[430px] -translate-x-1/2 justify-around bg-[#f4f7fb] px-[5%] pt-[15px]">
    @foreach ($items as $item)
        <a href="{{ route($item['route']) }}"
           class="flex flex-col items-center gap-px text-[13px] leading-4 {{ request()->routeIs($item['route']) ? 'underline underline-offset-2' : '' }}">
            <x-icon :name="$item['icon']" class="h-[22px] w-[22px]" stroke="2.2" />
            {{ $item['label'] }}
        </a>
    @endforeach
</nav>
