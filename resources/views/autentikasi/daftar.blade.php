<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-50 text-zinc-900">
    <main class="mx-auto flex min-h-screen max-w-5xl items-center px-4 py-10">
        <div class="w-full">
            <div class="judul-halaman">
                <div>
                    <img src="{{ asset('logokcg.png') }}" class="mb-4" style="height: 4rem; width: auto; object-fit: contain;" alt="Logo KCG">
                    <h1>Pendaftaran Anggota</h1>
                    <p>Data pendaftaran akan masuk sebagai anggota tidak aktif sampai diverifikasi oleh admin.</p>
                </div>
                <a href="{{ route('masuk') }}" class="tombol tombol-netral">Masuk</a>
            </div>

            @if($errors->any())
                <div class="notifikasi-galat">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $pesanGalat)
                            <li>{{ $pesanGalat }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('daftar.proses') }}" method="POST" class="form-grid">
                @csrf
                <div>
                    <label for="nama" class="form-label">Nama</label>
                    <input id="nama" name="nama" value="{{ old('nama') }}" required class="form-input">
                </div>
                <div>
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required class="form-input">
                </div>
                <div>
                    <label for="nik" class="form-label">NIK</label>
                    <input id="nik" name="nik" value="{{ old('nik') }}" required class="form-input">
                </div>
                <div>
                    <label for="telepon" class="form-label">Telepon</label>
                    <input id="telepon" name="telepon" value="{{ old('telepon') }}" required class="form-input">
                </div>
                <div class="md:col-span-2">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" required class="form-input">{{ old('alamat') }}</textarea>
                </div>
                <div>
                    <label for="kata_sandi" class="form-label">Kata Sandi</label>
                    <input id="kata_sandi" name="kata_sandi" type="password" required class="form-input">
                </div>
                <div>
                    <label for="kata_sandi_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                    <input id="kata_sandi_confirmation" name="kata_sandi_confirmation" type="password" required class="form-input">
                </div>
                <div class="md:col-span-2 flex flex-col gap-3 sm:flex-row">
                    <button class="tombol tombol-primer">Daftar</button>
                    <a href="{{ route('masuk') }}" class="tombol tombol-netral">Batal</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
