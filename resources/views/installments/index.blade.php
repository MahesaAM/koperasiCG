@extends('layouts.app')

@section('header')
<h1 class="text-3xl font-bold text-gray-900 leading-tight">Riwayat Angsuran</h1>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
         <p class="text-sm text-gray-600">Pantau riwayat pembayaran pinjaman.</p>
         @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'manager', 'kasir', 'member']))
        <a href="{{ route('installments.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ auth()->user()->role === 'member' ? 'Bayar Angsuran' : 'Catat Pembayaran' }}
        </a>
        @endif
    </div>

    @if (session('success'))
        <div class="rounded-md bg-green-50 p-4 mb-6 border-l-4 border-green-400">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anggota</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pinjaman</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Bayar</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Aksi</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($installments as $installment)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $installment->payment_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $installment->loan->anggota->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $installment->loan_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Rp {{ number_format($installment->amount_paid, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate max-w-xs">{{ $installment->note ?? '-' }}</td>
                     <td class="px-6 py-4 whitespace-nowrap">
                         @php
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                            ];
                            $statusClass = $statusClasses[$installment->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                            {{ ucfirst($installment->status) }}
                        </span>
                        @if($installment->proof_file)
                            <a href="{{ asset('storage/' . $installment->proof_file) }}" target="_blank" class="text-xs text-blue-600 hover:underline ml-1">(Bukti)</a>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('installments.show', $installment->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2 font-medium">Detail</a>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'manager']))
                             @if($installment->status === 'pending')
                                <form action="{{ route('installments.approve', $installment->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-2 text-xs font-bold uppercase">Terima</button>
                                </form>
                                <form action="{{ route('installments.reject', $installment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tolak pembayaran ini?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-red-600 hover:text-red-900 mr-2 text-xs font-bold uppercase">Tolak</button>
                                </form>
                             @else
                                <form action="{{ route('installments.destroy', $installment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus pembayaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 text-xs uppercase tracking-wider">Hapus</button>
                                </form>
                             @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
         @if($installments->isEmpty())
            <div class="px-6 py-10 text-center text-gray-500 bg-gray-50">
                Belum ada data angsuran.
            </div>
        @endif
        <div class="px-6 py-3 border-t border-gray-200">
            {{ $installments->links() }}
        </div>
    </div>
</div>
@endsection
