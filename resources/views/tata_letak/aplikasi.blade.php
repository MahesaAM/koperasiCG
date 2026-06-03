<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Koperasi') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-latar">
    @php
        $menu = [
            ['label' => 'Beranda', 'rute' => 'beranda', 'pola' => 'beranda'],
        ];

        if (auth()->check() && auth()->user()->peran !== 'anggota') {
            $menu[] = ['label' => 'Anggota', 'rute' => 'anggota.daftar', 'pola' => 'anggota.*'];
        }

        $menu[] = ['label' => 'Simpanan', 'rute' => 'simpanan.daftar', 'pola' => 'simpanan.*'];
        $menu[] = ['label' => 'Pinjaman', 'rute' => 'pinjaman.daftar', 'pola' => 'pinjaman.*'];
        $menu[] = ['label' => 'Angsuran', 'rute' => 'angsuran.daftar', 'pola' => 'angsuran.*'];

        if (auth()->check() && auth()->user()->peran !== 'anggota') {
            $menu[] = ['label' => 'Laporan', 'rute' => 'laporan.daftar', 'pola' => 'laporan.*'];
        }

        if (auth()->check() && auth()->user()->peran === 'admin') {
            $menu[] = ['label' => 'Pengguna', 'rute' => 'pengguna.daftar', 'pola' => 'pengguna.*'];
        }
    @endphp

    <div class="app-bingkai">
        @auth
            <aside class="bilah-samping">
                <div class="merek-aplikasi">
                    <a href="{{ route('beranda') }}" aria-label="Beranda">
                        <img src="{{ asset('logokcg.png') }}" alt="Logo Koperasi Cahaya Gemilang" style="height: 2.5rem; width: auto; object-fit: contain;">
                    </a>
                    <div>
                        <div class="text-sm font-bold text-zinc-950">{{ config('app.name') }}</div>
                        <div class="text-xs font-medium text-zinc-500">Panel operasional</div>
                    </div>
                </div>

                <nav class="menu-samping" aria-label="Navigasi utama">
                    @foreach($menu as $itemMenu)
                        <a href="{{ route($itemMenu['rute']) }}" class="item-menu {{ request()->routeIs($itemMenu['pola']) ? 'item-menu-aktif' : '' }}">
                            <span class="h-2 w-2 rounded-full {{ request()->routeIs($itemMenu['pola']) ? 'bg-red-600' : 'bg-zinc-300' }}"></span>
                            {{ $itemMenu['label'] }}
                        </a>
                    @endforeach
                </nav>
            </aside>
        @endauth

        <div class="area-utama">
            @auth
                <header class="bilah-atas">
                    <div class="konten-atas">
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-normal text-zinc-500">Masuk sebagai</div>
                            <div class="text-sm font-bold text-zinc-950">{{ auth()->user()->nama }}</div>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="badge badge-aktif">{{ auth()->user()->peran }}</span>
                            <form action="{{ route('keluar') }}" method="POST">
                                @csrf
                                <button class="tombol tombol-netral">Keluar</button>
                            </form>
                        </div>
                    </div>
                </header>
            @endauth

            <main class="wadah-konten">
                @if(session('success'))
                    <div class="notifikasi-sukses">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="notifikasi-galat">{{ session('error') }}</div>
                @endif

                @if($errors->any())
                    <div class="notifikasi-galat">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $pesanGalat)
                                <li>{{ $pesanGalat }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('konten')
            </main>
        </div>
    </div>
</body>
</html>
