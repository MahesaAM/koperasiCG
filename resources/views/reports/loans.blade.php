@extends('layouts.app')

@section('header')
<h1 class="text-3xl font-bold text-gray-900 leading-tight no-print">Laporan Pinjaman</h1>
@endsection

@section('content')
<div class="px-4 sm:px-0">
    <!-- Filter Form -->
    <div class="bg-white p-4 rounded-lg shadow mb-6 no-print">
        <form action="{{ route('reports.loans') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
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
        <h3 class="text-xl">Laporan Pinjaman</h3>
        <p>Periode: {{ $startDate ?? 'Semua Waktu' }} - {{ $endDate ?? 'Sekarang' }}</p>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anggota</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($loans as $loan)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loan->application_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loan->anggota->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                         @php
                            $statusLabels = [
                                'pending' => 'Menunggu',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                'paid' => 'Lunas',
                            ];
                        @endphp
                         <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $loan->status === 'approved' ? 'bg-green-100 text-green-800' : ($loan->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $statusLabels[$loan->status] ?? ucfirst($loan->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
