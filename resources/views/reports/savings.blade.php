@extends('layouts.app')

@section('header')
<h1 class="text-3xl font-bold text-gray-900 leading-tight no-print">Laporan Simpanan</h1>
@endsection

@section('content')
<div class="px-4 sm:px-0">
    <!-- Filter Form -->
    <div class="bg-white p-4 rounded-lg shadow mb-6 no-print">
        <form action="{{ route('reports.savings') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Filter
            </button>
            <button type="button" onclick="window.print()" class="ml-auto inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                Cetak Laporan
            </button>
        </form>
    </div>

    <!-- Report Header (Print Only) -->
    <div class="hidden print:block mb-8 text-center">
        <h2 class="text-2xl font-bold">Koperasi Cahaya Gemilang</h2>
        <p class="text-sm text-gray-600 mt-1">Perum Yuliani Gg. Cemara No. 6–7, Karang Tengah, Kecamatan-Kaliwungu, Kabupaten-Kendal, Jawa-Tengah.</p>
        <h3 class="text-xl">Laporan Simpanan</h3>
        <p>Periode: {{ $startDate ?? 'Semua Waktu' }} - {{ $endDate ?? 'Sekarang' }}</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-6">
        <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Penyetoran</dt>
                <dd class="mt-1 text-2xl font-semibold text-green-600">Rp {{ number_format($totalDeposit, 0, ',', '.') }}</dd>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Penarikan</dt>
                <dd class="mt-1 text-2xl font-semibold text-red-600">Rp {{ number_format($totalWithdrawal, 0, ',', '.') }}</dd>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Saldo Bersih (Periode)</dt>
                <dd class="mt-1 text-2xl font-semibold text-indigo-600">Rp {{ number_format($totalDeposit - $totalWithdrawal, 0, ',', '.') }}</dd>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anggota</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaksi</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($savings as $saving)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $saving->transaction_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $saving->anggota->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($saving->type) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                         <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $saving->transaction_type === 'deposit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $saving->transaction_type == 'deposit' ? 'Setoran' : 'Penarikan' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rp {{ number_format($saving->amount, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
