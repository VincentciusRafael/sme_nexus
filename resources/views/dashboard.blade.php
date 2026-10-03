@php
    $hour      = now()->hour;
    $salam     = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 18 ? 'Selamat sore' : 'Selamat malam'));
    $firstName = explode(' ', trim(Auth::user()->name))[0];

    // Sparkline: titik data -> path SVG yang dihaluskan
    $spark = function (array $v, $w = 100, $h = 32) {
        $min = min($v); $max = max($v); $n = count($v); $pts = [];
        foreach ($v as $i => $val) {
            $pts[] = [$i * $w / ($n - 1), $h - 3 - (($val - $min) / max($max - $min, 1)) * ($h - 8)];
        }
        $d = sprintf('M%.1f,%.1f', $pts[0][0], $pts[0][1]);
        for ($i = 1; $i < $n; $i++) {
            $cx = ($pts[$i - 1][0] + $pts[$i][0]) / 2;
            $d .= sprintf(' C%.1f,%.1f %.1f,%.1f %.1f,%.1f', $cx, $pts[$i - 1][1], $cx, $pts[$i][1], $pts[$i][0], $pts[$i][1]);
        }
        return ['line' => $d, 'area' => $d . " L$w,$h L0,$h Z"];
    };

    // Antrean kerja: hal yang perlu ditindaklanjuti hari ini
    $queue = [
        ['count' => 3, 'label' => 'Menunggu pembayaran', 'hint' => 'Pesanan #1284 dan 2 lainnya',      'action' => 'Kirim pengingat', 'tone' => '#C8372D'],
        ['count' => 4, 'label' => 'Perlu dikemas',       'hint' => 'Pembayaran sudah diterima',          'action' => 'Kemas pesanan',   'tone' => '#FFB36B'],
        ['count' => 2, 'label' => 'Stok hampir habis',   'hint' => 'Kopi Arabika Premium dan 1 lainnya', 'action' => 'Tambah stok',     'tone' => '#4B4FE0'],
    ];

    $stats = [
        ['label' => 'Total pendapatan', 'value' => 'Rp 45,2 jt', 'delta' => '12,5%', 'data' => [3, 5, 4, 7, 6, 9, 8, 11], 'color' => '#4B4FE0'],
        ['label' => 'Total pesanan',    'value' => '1.284',      'delta' => '8,2%',  'data' => [6, 5, 7, 6, 8, 7, 10, 9], 'color' => '#6A5CFF'],
        ['label' => 'Total produk',     'value' => '856',        'delta' => '3,1%',  'data' => [5, 6, 5, 6, 7, 6, 7, 8], 'color' => '#4FE3C1'],
        ['label' => 'Total pelanggan',  'value' => '3.429',      'delta' => '5,7%',  'data' => [4, 5, 5, 6, 6, 8, 8, 9], 'color' => '#FFB36B'],
    ];

    // Warna kategori mengikuti bahan aslinya: kopi, daun teh, madu, cabai
    $products = [
        ['name' => 'Kopi Arabika Premium', 'cat' => 'Kopi',   'emoji' => '☕',  'sold' => 245, 'hex' => '#4B4FE0'],
        ['name' => 'Teh Melati Organik',   'cat' => 'Teh',    'emoji' => '🍵', 'sold' => 198, 'hex' => '#4FE3C1'],
        ['name' => 'Madu Hutan Asli',      'cat' => 'Madu',   'emoji' => '🍯', 'sold' => 156, 'hex' => '#FFB36B'],
        ['name' => 'Rempah Pilihan',       'cat' => 'Rempah', 'emoji' => '🌶️', 'sold' => 112, 'hex' => '#7C8CFF'],
    ];

    $totalSold = array_sum(array_column($products, 'sold'));
    $maxSold   = max(array_column($products, 'sold'));

    $statusDot = [
        'Selesai'        => '#0B7A62',
        'Dikirim'        => '#4B4FE0',
        'Diproses'       => '#FFB36B',
        'Menunggu bayar' => '#C8372D',
    ];

    $orders = [
        ['id' => '#1284', 'name' => 'Budi Santoso',   'product' => 'Kopi Arabika Premium', 'total' => 'Rp 185.000', 'status' => 'Menunggu bayar'],
        ['id' => '#1283', 'name' => 'Siti Rahma',     'product' => 'Teh Melati Organik',   'total' => 'Rp 92.000',  'status' => 'Diproses'],
        ['id' => '#1282', 'name' => 'Agus Pratama',   'product' => 'Madu Hutan Asli',      'total' => 'Rp 240.000', 'status' => 'Dikirim'],
        ['id' => '#1281', 'name' => 'Dewi Lestari',   'product' => 'Rempah Pilihan',       'total' => 'Rp 128.000', 'status' => 'Selesai'],
        ['id' => '#1280', 'name' => 'Rizky Ramadhan', 'product' => 'Kopi Arabika Premium', 'total' => 'Rp 370.000', 'status' => 'Selesai'],
    ];

    $activities = [
        ['title' => 'Pesanan baru #1284',               'detail' => 'Menunggu pembayaran',           'time' => '2 menit lalu',  'tone' => '#C8372D'],
        ['title' => 'Pelanggan baru terdaftar',         'detail' => 'Dari halaman pendaftaran',      'time' => '15 menit lalu', 'tone' => '#0B7A62'],
        ['title' => 'Produk "Kopi Arabika" diperbarui', 'detail' => 'Harga dan stok diubah',         'time' => '1 jam lalu',    'tone' => '#4B4FE0'],
        ['title' => 'Pembayaran diterima',              'detail' => 'Pesanan #1281 lunas',           'time' => '2 jam lalu',    'tone' => '#FFB36B'],
        ['title' => 'Ulasan baru diterima',             'detail' => 'Teh Melati Organik, 5 bintang', 'time' => '3 jam lalu',    'tone' => '#0B7A62'],
    ];
@endphp

<x-app-layout>
    <style>
        @import url('https://fonts.bunny.net/css?family=bricolage-grotesque:500,600,700,800&display=swap');

        .dash { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; color: var(--ink); }
        .dash-display { font-family: 'Bricolage Grotesque', 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; letter-spacing: -.02em; }
        .tnum { font-variant-numeric: tabular-nums; }
        [x-cloak] { display: none !important; }

        /* Token warna (nilai diatur di wrapper .dash agar mengikuti mode terang/gelap) */
        .d-panel  { background: var(--surface); border: 1px solid var(--line); }
        .d-deep   { background: var(--deep); color: #F1F7F5; }
        .d-ink    { color: var(--ink); }
        .d-muted  { color: var(--muted); }
        .d-soft   { background: var(--soft); }
        .d-divide > * + * { border-top: 1px solid var(--line); }

        .d-btn {
            display: inline-flex; align-items: center; gap: .5rem;
            border-radius: .5rem; border: 1px solid var(--line); background: var(--surface);
            padding: .6rem .95rem; font-size: .875rem; font-weight: 600; color: var(--ink);
            transition: background-color .15s, border-color .15s;
        }
        .d-btn:hover { background: var(--soft); border-color: var(--muted); }
        .d-btn-primary {
            display: inline-flex; align-items: center; gap: .5rem;
            border-radius: .5rem; background: var(--accent);
            padding: .65rem 1.1rem; font-size: .875rem; font-weight: 700; color: #0E3B36;
            transition: filter .15s;
        }
        .d-btn-primary:hover { filter: brightness(1.07); }

        .dash :focus-visible { outline: 2px solid var(--focus); outline-offset: 2px; }
        .dash .d-deep :focus-visible { outline-color: #fff; }

        /* Batang grafik di panel gelap */
        .d-bar    { background: rgba(255,255,255,.22); }
        .d-bar:hover { background: rgba(255,255,255,.38); }
        .d-bar-hi { background: var(--accent); }

        @media (prefers-reduced-motion: reduce) {
            .dash *, .dash *::before, .dash *::after { transition-duration: .01ms !important; transition-delay: 0s !important; }
        }
    </style>

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold leading-tight text-gray-900 dark:text-white">{{ __('Dashboard') }}</h2>
                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <button type="button" aria-label="Notifikasi"
                    class="relative grid h-11 w-11 place-items-center rounded-lg bg-white text-gray-600 ring-1 ring-gray-200 transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 dark:bg-gray-800 dark:text-gray-300 dark:ring-white/10 dark:hover:bg-gray-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute right-2.5 top-2.5 h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white dark:ring-gray-800"></span>
            </button>
        </div>
    </x-slot>

    <div class="dash py-8
        [--ink:#171A44] [--muted:#666B92] [--line:#DADDF4] [--surface:#FFFFFF] [--soft:#F6F7FF]
        [--deep:#2A2EB5] [--accent:#4B4FE0] [--alert:#C8372D] [--ok:#0B7A62] [--info:#4B4FE0] [--focus:#4B4FE0]
        dark:[--ink:#EEF0FF] dark:[--muted:#9BA1CF] dark:[--line:#2A2E5A] dark:[--surface:#14173D] dark:[--soft:#1A1E4A]
        dark:[--deep:#1B1E63] dark:[--accent:#7C8CFF] dark:[--alert:#FF8A7A] dark:[--ok:#5BE9C8] dark:[--info:#AEB6FF] dark:[--focus:#7C8CFF]">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            <section class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h1 class="dash-display text-4xl font-extrabold leading-[1.05] sm:text-5xl">{{ $salam }}, {{ $firstName }}.</h1>
                    <p class="d-muted mt-3 max-w-xl text-base sm:text-lg">
                        Ada <strong class="d-ink font-bold">12 pesanan baru</strong> hari ini, 3 di antaranya belum dibayar.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <button type="button" class="d-btn-primary">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M12 6v12M6 12h12"/></svg>
                        Buat pesanan
                    </button>
                    <button type="button" class="d-btn">Tambah produk</button>
                    <button type="button" class="d-btn">Tambah pelanggan</button>
                    <button type="button" class="d-btn">Lihat laporan</button>
                </div>
            </section>

            <section class="grid grid-cols-1 gap-5 lg:grid-cols-12">

                <div class="d-panel rounded-2xl p-6 sm:p-7 lg:col-span-5">
                    <h3 class="dash-display text-xl font-bold">Perlu ditindaklanjuti</h3>
                    <p class="d-muted mt-0.5 text-sm">Urutkan dari yang paling mendesak</p>

                    <ul class="d-divide mt-4">
                        @foreach ($queue as $q)
                            <li class="flex items-center gap-4 py-4">
                                <span class="dash-display tnum w-10 shrink-0 text-4xl font-bold leading-none">{{ $q['count'] }}</span>
                                <div class="min-w-0 flex-1">
                                    <p class="flex items-center gap-2 font-semibold">
                                        <span class="h-2 w-2 shrink-0 rounded-full" style="background: {{ $q['tone'] }}" aria-hidden="true"></span>
                                        {{ $q['label'] }}
                                    </p>
                                    <p class="d-muted mt-0.5 truncate text-sm">{{ $q['hint'] }}</p>
                                </div>
                                <button type="button" class="d-btn shrink-0 !px-3 !py-2">{{ $q['action'] }}</button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="grid grid-cols-2 gap-px self-start overflow-hidden rounded-2xl lg:col-span-7"
                     style="background: var(--line); border: 1px solid var(--line);">
                    @foreach ($stats as $s)
                        @php $sp = $spark($s['data']); @endphp
                        <div class="p-5 sm:p-6" style="background: var(--surface)">
                            <p class="d-muted text-sm font-medium">{{ $s['label'] }}</p>
                            <p class="dash-display tnum mt-1 text-2xl font-bold sm:text-3xl">{{ $s['value'] }}</p>
                            <p class="mt-1 flex items-center gap-1 text-sm font-semibold" style="color: var(--ok)">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"/></svg>
                                <span class="tnum">{{ $s['delta'] }}</span>
                                <span class="d-muted font-medium">dari periode lalu</span>
                            </p>
                            <svg class="mt-3 h-10 w-full" style="color: {{ $s['color'] }}" viewBox="0 0 100 32" preserveAspectRatio="none" aria-hidden="true">
                                <path d="{{ $sp['area'] }}" fill="currentColor" fill-opacity=".10" />
                                <path d="{{ $sp['line'] }}" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" />
                            </svg>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="grid grid-cols-1 gap-5 lg:grid-cols-12">

                <div x-data="barChart()" class="d-deep rounded-2xl p-6 sm:p-8 lg:col-span-8" style="background: linear-gradient(160deg, #2A2EB5 0%, #1B1E63 55%, #171A44 100%);">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h3 class="dash-display text-xl font-bold">Grafik penjualan</h3>
                            <p class="mt-0.5 text-sm text-white/70">Performa <span x-text="set.title"></span></p>
                        </div>
                        <div class="inline-flex rounded-lg bg-white/10 p-1" role="group" aria-label="Rentang waktu">
                            <button type="button" @click="choose('week')" :aria-pressed="range === 'week'"
                                    :class="range === 'week' ? 'bg-white text-[#0E3B36]' : 'text-white/75 hover:text-white'"
                                    class="rounded-md px-4 py-1.5 text-sm font-semibold transition">7 hari</button>
                            <button type="button" @click="choose('month')" :aria-pressed="range === 'month'"
                                    :class="range === 'month' ? 'bg-white text-[#0E3B36]' : 'text-white/75 hover:text-white'"
                                    class="rounded-md px-4 py-1.5 text-sm font-semibold transition">30 hari</button>
                        </div>
                    </div>

                    <dl class="mt-6 flex flex-wrap items-end gap-x-10 gap-y-4">
                        <div>
                            <dt class="text-sm text-white/70">Total</dt>
                            <dd class="dash-display tnum text-4xl font-bold sm:text-5xl">Rp <span x-text="fmt(total)"></span> jt</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-white/70">Rata-rata per hari</dt>
                            <dd class="dash-display tnum text-xl font-bold sm:text-2xl">Rp <span x-text="fmt(avg)"></span> jt</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-white/70">Tertinggi</dt>
                            <dd class="dash-display tnum text-xl font-bold sm:text-2xl">Rp <span x-text="fmt(max)"></span> jt</dd>
                        </div>
                    </dl>

                    <div class="mt-8">
                        <div class="relative h-60">
                            <div class="pointer-events-none absolute inset-0 flex flex-col justify-between" aria-hidden="true">
                                <div class="border-t border-dashed border-white/15"></div>
                                <div class="border-t border-dashed border-white/15"></div>
                                <div class="border-t border-dashed border-white/15"></div>
                                <div class="border-t border-dashed border-white/15"></div>
                                <div class="border-t border-white/25"></div>
                            </div>

                            <div class="relative flex h-full items-end" :class="range === 'week' ? 'gap-3' : 'gap-1'">
                                <template x-for="(v, i) in set.values" :key="range + i">
                                    <div class="relative flex h-full flex-1 flex-col justify-end"
                                         @mouseenter="hover = i" @mouseleave="hover = null">
                                        <div x-show="hover === i" x-cloak
                                             class="pointer-events-none absolute left-1/2 z-10 -translate-x-1/2 whitespace-nowrap rounded-md bg-white px-3 py-2 text-xs text-[#0E3B36] shadow-lg"
                                             :style="`bottom: calc(${v / max * 92}% + 10px)`">
                                            <p class="font-bold" x-text="'Rp ' + fmt(v) + ' jt'"></p>
                                            <p class="opacity-70" x-text="set.full[i]"></p>
                                        </div>
                                        <button type="button"
                                                @focus="hover = i" @blur="hover = null"
                                                :aria-label="set.full[i] + ': Rp ' + fmt(v) + ' juta'"
                                                class="w-full rounded-t-md transition-[height] duration-700 ease-out"
                                                :class="(i === hover || (i === bestIndex && hover === null)) ? 'd-bar-hi' : 'd-bar'"
                                                :style="`height: ${ready ? v / max * 92 : 0}%; transition-delay: ${i * 30}ms`"></button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="mt-3 flex text-xs font-medium text-white/70" :class="range === 'week' ? 'gap-3' : 'gap-1'">
                            <template x-for="(l, i) in set.labels" :key="range + i">
                                <span class="flex-1 whitespace-nowrap text-center" :class="i === hover ? 'font-bold text-white' : ''"
                                      x-text="showLabel(i) ? l : ''"></span>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="d-panel rounded-2xl p-6 sm:p-7 lg:col-span-4">
                    <h3 class="dash-display text-xl font-bold">Penjualan per kategori</h3>
                    <p class="d-muted mt-0.5 text-sm">Berdasarkan jumlah terjual</p>

                    <p class="dash-display tnum mt-6 text-4xl font-bold leading-none">
                        {{ number_format($totalSold, 0, ',', '.') }}
                        <span class="d-muted text-base font-medium">produk terjual</span>
                    </p>

                    <div class="mt-5 flex h-3 gap-1 overflow-hidden rounded-full" role="img"
                         aria-label="Porsi penjualan: @foreach ($products as $p){{ $p['cat'] }} {{ round($p['sold'] / $totalSold * 100) }} persen{{ $loop->last ? '' : ', ' }}@endforeach">
                        @foreach ($products as $p)
                            <div style="width: {{ $p['sold'] / $totalSold * 100 }}%; background: {{ $p['hex'] }}"></div>
                        @endforeach
                    </div>

                    <ul class="d-divide mt-5">
                        @foreach ($products as $p)
                            <li class="flex items-center justify-between py-3 text-sm">
                                <span class="flex items-center gap-2.5 font-medium">
                                    <span class="h-3 w-3 rounded-sm" style="background: {{ $p['hex'] }}" aria-hidden="true"></span>
                                    {{ $p['cat'] }}
                                </span>
                                <span class="tnum d-muted">
                                    {{ $p['sold'] }}
                                    <span class="d-ink ml-2 inline-block w-10 text-right font-bold">{{ round($p['sold'] / $totalSold * 100) }}%</span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>

            <section class="grid grid-cols-1 gap-5 lg:grid-cols-12">

                <div class="d-panel rounded-2xl p-6 sm:p-7 lg:col-span-8">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="dash-display text-xl font-bold">Pesanan terbaru</h3>
                            <p class="d-muted mt-0.5 text-sm">5 pesanan terakhir yang masuk</p>
                        </div>
                        <button type="button" class="d-btn !px-3 !py-2">Lihat semua pesanan</button>
                    </div>

                    <div class="-mx-2 mt-5 overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="d-muted text-left text-xs font-semibold">
                                    <th class="px-2 pb-3">Pelanggan</th>
                                    <th class="hidden px-2 pb-3 md:table-cell">Produk</th>
                                    <th class="px-2 pb-3 text-right">Total</th>
                                    <th class="px-2 pb-3 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="d-divide">
                                @foreach ($orders as $o)
                                    <tr>
                                        <td class="px-2 py-3.5">
                                            <div class="flex items-center gap-3">
                                                <span class="d-soft d-ink grid h-10 w-10 shrink-0 place-items-center rounded-full text-sm font-bold">{{ strtoupper(substr($o['name'], 0, 1)) }}</span>
                                                <div class="min-w-0">
                                                    <p class="truncate font-semibold">{{ $o['name'] }}</p>
                                                    <p class="d-muted text-xs">{{ $o['id'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-muted hidden px-2 py-3.5 md:table-cell">{{ $o['product'] }}</td>
                                        <td class="tnum whitespace-nowrap px-2 py-3.5 text-right font-bold">{{ $o['total'] }}</td>
                                        <td class="px-2 py-3.5 text-right">
                                            <span class="d-soft inline-flex items-center gap-2 whitespace-nowrap rounded-full px-3 py-1 text-xs font-semibold">
                                                <span class="h-2 w-2 rounded-full" style="background: {{ $statusDot[$o['status']] }}" aria-hidden="true"></span>
                                                {{ $o['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-panel rounded-2xl p-6 sm:p-7 lg:col-span-4">
                    <div class="flex items-start justify-between gap-4">
                        <h3 class="dash-display text-xl font-bold">Aktivitas terbaru</h3>
                        <button type="button" class="d-btn !px-3 !py-1.5">Lihat semua</button>
                    </div>

                    <ul class="d-divide mt-4">
                        @foreach ($activities as $a)
                            <li class="flex gap-3 py-3.5">
                                <span class="mt-1.5 h-2.5 w-2.5 shrink-0 rounded-full" style="background: {{ $a['tone'] }}" aria-hidden="true"></span>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-semibold">{{ $a['title'] }}</p>
                                    <p class="d-muted mt-0.5 truncate text-sm">{{ $a['detail'] }}</p>
                                </div>
                                <p class="d-muted shrink-0 text-xs">{{ $a['time'] }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>

            <section class="d-panel rounded-2xl p-6 sm:p-7">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="dash-display text-xl font-bold">Produk terlaris</h3>
                        <p class="d-muted mt-0.5 text-sm">Paling banyak dibeli pelanggan</p>
                    </div>
                    <button type="button" class="d-btn !px-3 !py-2">Lihat semua produk</button>
                </div>

                <ol class="d-divide mt-4">
                    @foreach ($products as $p)
                        <li class="flex items-center gap-4 py-4">
                            <span class="d-muted tnum w-5 shrink-0 text-sm font-bold">{{ $loop->iteration }}</span>
                            <span class="grid h-12 w-12 shrink-0 place-items-center rounded-lg text-2xl"
                                  style="background: color-mix(in srgb, {{ $p['hex'] }} 22%, transparent)" aria-hidden="true">{{ $p['emoji'] }}</span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate font-bold">{{ $p['name'] }}</p>
                                <p class="d-muted text-xs">{{ $p['cat'] }}</p>
                            </div>
                            <div class="d-soft hidden h-2 w-40 shrink-0 overflow-hidden rounded-full sm:block md:w-72"
                                 role="img" aria-label="{{ round($p['sold'] / $maxSold * 100) }} persen dari produk terlaris">
                                <div class="h-full rounded-full" style="width: {{ $p['sold'] / $maxSold * 100 }}%; background: {{ $p['hex'] }}"></div>
                            </div>
                            <p class="tnum w-24 shrink-0 text-right">
                                <span class="dash-display text-2xl font-bold">{{ $p['sold'] }}</span>
                                <span class="d-muted text-xs">terjual</span>
                            </p>
                        </li>
                    @endforeach
                </ol>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('barChart', () => ({
                range: 'week',
                hover: null,
                ready: false,
                sets: {
                    week: {
                        title: '7 hari terakhir',
                        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                        full: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                        values: [4.2, 6.1, 5.3, 7.8, 6.9, 9.4, 5.5]
                    },
                    month: {
                        title: '30 hari terakhir',
                        labels: Array.from({ length: 30 }, (_, i) => String(i + 1)),
                        full: Array.from({ length: 30 }, (_, i) => 'Hari ke-' + (i + 1)),
                        values: [3.8, 4.5, 5.1, 4.2, 5.9, 6.4, 5.2, 4.8, 5.5, 6.1, 5.7, 7.2, 6.6, 5.3, 5.0,
                                 5.8, 6.9, 7.4, 6.2, 5.6, 6.0, 6.8, 7.9, 8.4, 7.1, 6.3, 6.7, 7.5, 8.9, 7.8]
                    }
                },

                init() { setTimeout(() => this.ready = true, 150); },

                get set()       { return this.sets[this.range]; },
                get max()       { return Math.max(...this.set.values); },
                get total()     { return this.set.values.reduce((a, b) => a + b, 0); },
                get avg()       { return this.total / this.set.values.length; },
                get bestIndex() { return this.set.values.indexOf(this.max); },

                fmt(v) { return v.toFixed(1).replace('.', ','); },
                showLabel(i) { return this.range === 'week' || i % 5 === 0 || i === this.set.values.length - 1; },

                choose(r) {
                    if (r === this.range) return;
                    this.ready = false;
                    this.hover = null;
                    this.range = r;
                    setTimeout(() => this.ready = true, 40);
                }
            }));
        });
    </script>
</x-app-layout>
