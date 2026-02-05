@extends('layouts.app')

@section('header')
<h1 class="text-3xl font-bold text-gray-900 leading-tight">Pusat Laporan</h1>
@endsection

@section('content')
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
    <!-- Members Report -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900">Laporan Anggota</h3>
            <p class="mt-2 text-sm text-gray-600">Lihat dan cetak daftar lengkap anggota terdaftar, termasuk status mereka.</p>
            <div class="mt-4">
               <a href="{{ route('reports.members') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Lihat Laporan &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Savings Report -->
     <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900">Laporan Simpanan</h3>
            <p class="mt-2 text-sm text-gray-600">Rincian setoran dan penarikan yang difilter berdasarkan tanggal.</p>
            <div class="mt-4">
               <a href="{{ route('reports.savings') }}" class="text-green-600 hover:text-green-800 font-medium">Lihat Laporan &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Loans Report -->
     <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900">Laporan Pinjaman</h3>
            <p class="mt-2 text-sm text-gray-600">Status semua aplikasi pinjaman, termasuk yang tertunda dan disetujui.</p>
            <div class="mt-4">
               <a href="{{ route('reports.loans') }}" class="text-red-600 hover:text-red-800 font-medium">Lihat Laporan &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Installments Report -->
     <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900">Laporan Angsuran</h3>
            <p class="mt-2 text-sm text-gray-600">Rekapitulasi pembayaran angsuran modal dan bunga.</p>
            <div class="mt-4">
               <a href="{{ route('reports.installments') }}" class="text-orange-600 hover:text-orange-800 font-medium">Lihat Laporan &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Financial Report -->
     <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900">Laporan Keuangan</h3>
            <p class="mt-2 text-sm text-gray-600">Gambaran umum aset, piutang, dan pendapatan bunga koperasi.</p>
            <div class="mt-4">
               <a href="{{ route('reports.financial') }}" class="text-purple-600 hover:text-purple-800 font-medium">Lihat Laporan &rarr;</a>
            </div>
        </div>
    </div>
</div>
@endsection
