<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Siaga Longsor')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Tailwind via CDN supaya langsung jalan tanpa npm. Untuk produksi, pindahkan ke build Vite/Tailwind. --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: { sans: ['Comfortaa', 'system-ui', 'sans-serif'] },
                colors: { brand: { DEFAULT: '#125c52', soft: '#e3f5ee' } },
            } },
        };
    </script>
    <style>
        .card-shadow { box-shadow: 0 3px 4px rgba(0, 0, 0, .25); }
    </style>
</head>
<body class="bg-slate-200 font-sans text-neutral-900">
    <div class="relative mx-auto min-h-screen w-full max-w-[430px] overflow-x-hidden bg-white pb-[90px]">
        @yield('content')
        @include('partials.bottom-nav')
    </div>

    {{-- Popup peringatan --}}
    <div id="alert-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-[27px]"
         role="alertdialog" aria-modal="true" aria-labelledby="alert-title">
        <div class="w-full max-w-[332px] rounded-[26px] bg-white px-[23px] pb-[22px] pt-[35px] text-center shadow-2xl">
            <div class="mx-auto flex h-[66px] w-[66px] items-center justify-center rounded-full bg-[#ff6b6b]">
                <x-icon name="alert-triangle" class="h-[30px] w-[30px]" stroke="2.4" />
            </div>
            <h2 id="alert-title" class="mt-[11px] text-[28px] font-bold leading-9 text-[#e30613]">Peringatan!</h2>
            <p id="alert-text" class="mt-2 whitespace-pre-line text-[13px] leading-4"></p>
            <button id="alert-ok" type="button"
                    class="mt-[52px] h-[50px] w-full rounded-full bg-[#ff6b6b] text-2xl text-white shadow-md active:scale-[.98]">
                OK
            </button>
        </div>
    </div>

    <script>
        (function () {
            const POLL_MS = 5000;
            const modal = document.getElementById('alert-modal');
            const text  = document.getElementById('alert-text');
            const ok    = document.getElementById('alert-ok');
            let baseline = null;
            let shownEvent = null;

            const store = {
                get() { try { return localStorage.getItem('siaga_ack'); } catch (e) { return null; } },
                set(v) { try { localStorage.setItem('siaga_ack', v); } catch (e) {} },
            };

            function openModal(msg, eventId) {
                shownEvent = String(eventId);
                text.textContent = msg;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            function closeModal() {
                if (shownEvent !== null) store.set(shownEvent);
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
            ok.addEventListener('click', closeModal);

            async function poll() {
                try {
                    const res = await fetch('/api/sensor/latest', { headers: { Accept: 'application/json' } });
                    const d = await res.json();

                    // Ada data baru -> muat ulang halaman agar angka ikut berubah.
                    if (baseline === null) baseline = d.reading_id;
                    else if (d.reading_id !== baseline && modal.classList.contains('hidden')) {
                        location.reload();
                        return;
                    }

                    if (d.level === 'awas' && d.event_id !== null && store.get() !== String(d.event_id)
                        && modal.classList.contains('hidden')) {
                        openModal(d.popup_text, d.event_id);
                    }
                } catch (e) { /* abaikan gangguan jaringan sesaat */ }
            }

            poll();
            setInterval(poll, POLL_MS);
        })();
    </script>
</body>
</html>
