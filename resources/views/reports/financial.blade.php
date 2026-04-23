@extends('layouts.app')

@section('header')
<h1 class="text-3xl font-bold text-gray-900 leading-tight no-print">Laporan Keuangan</h1>
@endsection

@section('content')
<div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
    <div class="mb-6 flex justify-between items-center no-print">
        <p class="text-gray-600">Ringkasan kesehatan finansial koperasi sampai saat ini.</p>
        <button type="button" onclick="window.print()" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Cetak Laporan</button>
    </div>

    <!-- Report Header (Print Only) -->
    <div class="hidden print:block mb-8 text-center">
        <h2 class="text-2xl font-bold">Koperasi Cahaya Gemilang</h2>
        <p class="text-sm text-gray-600 mt-1">Perum Yuliani Gg. Cemara No. 6–7, Karang Tengah, Kecamatan-Kaliwungu, Kabupaten-Kendal, Jawa-Tengah.</p>
        <h3 class="text-xl">Laporan Keuangan</h3>
        <p>Ringkasan kesehatan finansial koperasi sampai saat ini.</p>
    </div>

    <!-- Financial Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Assets Section -->
        <div class="border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Aset & Piutang</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Simpanan Anggota (Dana Pihak Ketiga)</span>
                    <span class="font-semibold text-gray-900">Rp {{ number_format($totalSavings, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Piutang (Pinjaman Beredar)</span>
                    <span class="font-semibold text-blue-600">Rp {{ number_format($outstandingLoans, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Revenue Section -->
        <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Pendapatan</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Pendapatan Bunga (Akumulatif)</span>
                    <span class="font-bold text-green-600 text-xl">Rp {{ number_format($totalRevenueInterest, 0, ',', '.') }}</span>
                </div>
                <p class="text-xs text-gray-500 mt-2">* Pendapatan bunga dihitung dari total bunga yang telah dibayarkan melalui angsuran.</p>
            </div>
        </div>
    </div>

    <div class="mt-8">
         <h4 class="text-md font-semibold text-gray-800 mb-2">Statistik Kunci</h4>
         <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
             <div class="bg-white border rounded p-4 text-center">
                 <span class="block text-gray-500 text-sm">Total Pinjaman Disalurkan</span>
                 <span class="block text-xl font-bold text-gray-900">Rp {{ number_format($totalLoansDisbursed, 0, ',', '.') }}</span>
             </div>
             <!-- Add more stats if needed -->
         </div>
    </div>
</div>
@endsection
