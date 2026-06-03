<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AngsuranController;
use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\SimpananController;
use Illuminate\Support\Facades\Route;

Route::get('login', fn () => redirect()->route('masuk'))->name('login');
Route::get('masuk', [AutentikasiController::class, 'formulirMasuk'])->name('masuk');
Route::post('masuk', [AutentikasiController::class, 'masuk'])->name('masuk.proses');
Route::get('daftar', [AutentikasiController::class, 'formulirDaftar'])->name('daftar');
Route::post('daftar', [AutentikasiController::class, 'daftar'])->name('daftar.proses');
Route::post('keluar', [AutentikasiController::class, 'keluar'])->name('keluar');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [BerandaController::class, 'tampil'])->name('beranda');

    Route::middleware('peran:admin,manajer,kasir')->group(function () {
        Route::get('anggota', [AnggotaController::class, 'daftar'])->name('anggota.daftar');
        Route::get('anggota/tambah', [AnggotaController::class, 'tambah'])->name('anggota.tambah');
        Route::post('anggota', [AnggotaController::class, 'simpan'])->name('anggota.simpan');
        Route::get('anggota/{id}', [AnggotaController::class, 'detail'])->name('anggota.detail');
        Route::get('anggota/{id}/ubah', [AnggotaController::class, 'ubah'])->name('anggota.ubah');
        Route::put('anggota/{id}', [AnggotaController::class, 'perbarui'])->name('anggota.perbarui');
        Route::delete('anggota/{id}', [AnggotaController::class, 'hapus'])->name('anggota.hapus');
        Route::post('anggota/{id}/buat-akun', [AnggotaController::class, 'buatAkun'])->name('anggota.buat_akun');

        Route::put('simpanan/{id}/setujui', [SimpananController::class, 'setujui'])->name('simpanan.setujui');
        Route::put('simpanan/{id}/tolak', [SimpananController::class, 'tolak'])->name('simpanan.tolak');
        Route::delete('simpanan/{id}', [SimpananController::class, 'hapus'])->name('simpanan.hapus');

        Route::post('pinjaman/pengaturan/bunga', [PinjamanController::class, 'perbaruiBunga'])->name('pinjaman.pengaturan.bunga');
        Route::get('pinjaman/{id}/ubah', [PinjamanController::class, 'ubah'])->name('pinjaman.ubah');
        Route::put('pinjaman/{id}', [PinjamanController::class, 'perbarui'])->name('pinjaman.perbarui');
        Route::put('pinjaman/{id}/setujui', [PinjamanController::class, 'setujui'])->name('pinjaman.setujui');
        Route::put('pinjaman/{id}/tolak', [PinjamanController::class, 'tolak'])->name('pinjaman.tolak');
        Route::delete('pinjaman/{id}', [PinjamanController::class, 'hapus'])->name('pinjaman.hapus');

        Route::put('angsuran/{id}/setujui', [AngsuranController::class, 'setujui'])->name('angsuran.setujui');
        Route::put('angsuran/{id}/tolak', [AngsuranController::class, 'tolak'])->name('angsuran.tolak');
        Route::delete('angsuran/{id}', [AngsuranController::class, 'hapus'])->name('angsuran.hapus');

        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [LaporanController::class, 'daftar'])->name('daftar');
            Route::get('/anggota', [LaporanController::class, 'anggota'])->name('anggota');
            Route::get('/simpanan', [LaporanController::class, 'simpanan'])->name('simpanan');
            Route::get('/pinjaman', [LaporanController::class, 'pinjaman'])->name('pinjaman');
            Route::get('/angsuran', [LaporanController::class, 'angsuran'])->name('angsuran');
            Route::get('/keuangan', [LaporanController::class, 'keuangan'])->name('keuangan');
        });
    });

    Route::get('simpanan', [SimpananController::class, 'daftar'])->name('simpanan.daftar');
    Route::get('simpanan/tambah', [SimpananController::class, 'tambah'])->name('simpanan.tambah');
    Route::post('simpanan', [SimpananController::class, 'simpan'])->name('simpanan.simpan');
    Route::get('simpanan/{id}', [SimpananController::class, 'detail'])->name('simpanan.detail');

    Route::get('pinjaman', [PinjamanController::class, 'daftar'])->name('pinjaman.daftar');
    Route::get('pinjaman/tambah', [PinjamanController::class, 'tambah'])->name('pinjaman.tambah');
    Route::post('pinjaman', [PinjamanController::class, 'simpan'])->name('pinjaman.simpan');
    Route::get('pinjaman/{id}', [PinjamanController::class, 'detail'])->name('pinjaman.detail');

    Route::get('angsuran', [AngsuranController::class, 'daftar'])->name('angsuran.daftar');
    Route::get('angsuran/tambah', [AngsuranController::class, 'tambah'])->name('angsuran.tambah');
    Route::post('angsuran', [AngsuranController::class, 'simpan'])->name('angsuran.simpan');
    Route::get('angsuran/{id}', [AngsuranController::class, 'detail'])->name('angsuran.detail');

    Route::middleware('peran:admin')->group(function () {
        Route::get('pengguna', [PenggunaController::class, 'daftar'])->name('pengguna.daftar');
        Route::get('pengguna/tambah', [PenggunaController::class, 'tambah'])->name('pengguna.tambah');
        Route::post('pengguna', [PenggunaController::class, 'simpan'])->name('pengguna.simpan');
        Route::get('pengguna/{id}/ubah', [PenggunaController::class, 'ubah'])->name('pengguna.ubah');
        Route::put('pengguna/{id}', [PenggunaController::class, 'perbarui'])->name('pengguna.perbarui');
        Route::delete('pengguna/{id}', [PenggunaController::class, 'hapus'])->name('pengguna.hapus');
    });
});
