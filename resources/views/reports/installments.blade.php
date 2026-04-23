@extends('layouts.app')

@section('header')
<h1 class="text-3xl font-bold text-gray-900 leading-tight no-print">Laporan Angsuran</h1>
@endsection

@section('content')
<div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
    <div class="mb-6 no-print">
        <form method="GET" action="{{ route('reports.installments') }}" class="flex flex-col sm:flex-row gap-4 items-end">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Filter</button>
            <button type="button" onclick="window.print()" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 ml-auto">Cetak Laporan</button>
        </form>
    </div>

    <!-- Report Header (Print Only) -->
    <div class="hidden print:block mb-8 text-center">
        <h2 class="text-2xl font-bold">Koperasi Cahaya Gemilang</h2>
        <p class="text-sm text-gray-600 mt-1">Perum Yuliani Gg. Cemara No. 6–7, Karang Tengah, Kecamatan-Kaliwungu, Kabupaten-Kendal, Jawa-Tengah.</p>
        <h3 class="text-xl">Laporan Angsuran</h3>
        <p>Periode: {{ $startDate ?? 'Semua Waktu' }} - {{ $endDate ?? 'Sekarang' }}</p>
    </div>


    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg">
            <h4 class="text-sm font-medium text-blue-800">Total Pembayaran (Periode)</h4>
            <p class="text-2xl font-bold text-blue-900">Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <h4 class="text-sm font-medium text-green-800">Pendapatan Bunga (Periode)</h4>
            <p class="text-2xl font-bold text-green-900">Rp {{ number_format($totalInterest, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anggota</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ref. Pinjaman</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Bayar</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pokok / Bunga</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($installments as $inst)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $inst->payment_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $inst->loan->anggota->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $inst->loan_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Rp {{ number_format($inst->amount_paid, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        P: {{ number_format($inst->principal_paid, 0, ',', '.') }} <br>
                        B: {{ number_format($inst->interest_paid, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada data angsuran pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
