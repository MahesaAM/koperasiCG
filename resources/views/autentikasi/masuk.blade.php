<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-50 text-zinc-900">
    <main class="grid min-h-screen lg:grid-cols-[1fr_30rem]">
        <section class="hidden bg-blue-900 px-10 py-12 text-white lg:flex lg:flex-col lg:justify-between">
            <div>
                <img src="{{ asset('logokcg.png') }}" class="bg-white p-2 rounded-lg" style="height: 5rem; width: auto; object-fit: contain;" alt="Logo KCG">
                <h1 class="mt-8 max-w-lg text-4xl font-bold">Kelola koperasi dengan alur kerja yang lebih rapi.</h1>
                <p class="mt-4 max-w-md text-sm leading-6 text-blue-100">Pantau anggota, simpanan, pinjaman, angsuran, dan laporan dalam satu panel yang mudah dipindai.</p>
            </div>
            <div class="grid grid-cols-3 gap-3 text-sm">
                <div class="rounded-lg bg-white/10 p-4"><div class="font-bold">Anggota</div><div class="mt-1 text-blue-100">Data terpusat</div></div>
                <div class="rounded-lg bg-white/10 p-4"><div class="font-bold">Transaksi</div><div class="mt-1 text-blue-100">Mudah dicek</div></div>
                <div class="rounded-lg bg-white/10 p-4"><div class="font-bold">Laporan</div><div class="mt-1 text-blue-100">Siap cetak</div></div>
            </div>
        </section>

        <section class="flex items-center justify-center px-4 py-10">
            <div class="w-full max-w-md">
                <div class="mb-8 lg:hidden">
                    <img src="{{ asset('logokcg.png') }}" style="height: 4rem; width: auto; object-fit: contain;" alt="Logo KCG">
                </div>
                <div class="panel-isi">
                    <h1 class="text-2xl font-bold">Masuk</h1>
                    <p class="mt-1 text-sm text-zinc-600">Gunakan akun yang sudah terdaftar.</p>

                    @if($errors->any())
                        <div class="mt-6 notifikasi-galat">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('masuk.proses') }}" method="POST" class="mt-6 space-y-4">
                        @csrf
                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="form-input">
                        </div>
                        <div>
                            <label for="kata_sandi" class="form-label">Kata Sandi</label>
                            <input id="kata_sandi" name="kata_sandi" type="password" required class="form-input">
                        </div>
                        <button class="tombol tombol-primer w-full">Masuk</button>
                    </form>

                    <p class="mt-6 text-sm text-zinc-600">
                        Belum punya akun?
                        <a href="{{ route('daftar') }}" class="tautan-aksi">Daftar sebagai anggota</a>
                    </p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
