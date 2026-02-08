@extends('layouts.app')

@section('header')
<h1 class="text-3xl font-bold text-gray-900 leading-tight">Transaksi Simpanan</h1>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm text-gray-600">Riwayat semua transaksi setoran dan penarikan.</p>
        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'manager', 'kasir', 'member']))
        <a href="{{ route('savings.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            {{ auth()->user()->role === 'member' ? 'Catat Simpanan' : 'Transaksi Baru' }}
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Simpanan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaksi</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Aksi</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($savings as $saving)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $saving->transaction_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $saving->anggota->name }}</div>
                        <div class="text-xs text-gray-500">{{ $saving->anggota->nik }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($saving->type) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $saving->transaction_type === 'deposit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $saving->transaction_type == 'deposit' ? 'Setoran' : 'Penarikan' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Rp {{ number_format($saving->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                         @php
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                            ];
                            $statusClass = $statusClasses[$saving->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                            {{ ucfirst($saving->status) }}
                        </span>
                        @if($saving->proof_file)
                            <a href="{{ asset('storage/' . $saving->proof_file) }}" target="_blank" class="text-xs text-blue-600 hover:underline ml-1">(Bukti)</a>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('savings.show', $saving->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2 font-medium">Resi</a>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'manager']))
                            @if($saving->status === 'pending')
                                <form action="{{ route('savings.approve', $saving->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-2 text-xs font-bold uppercase">Terima</button>
                                </form>
                                <form action="{{ route('savings.reject', $saving->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tolak transaksi ini?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-red-600 hover:text-red-900 mr-2 text-xs font-bold uppercase">Tolak</button>
                                </form>
                            @else
                                <form action="{{ route('savings.destroy', $saving->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus transaksi #{{ $saving->id }}?')">
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
        @if($savings->isEmpty())
            <div class="px-6 py-10 text-center text-gray-500 bg-gray-50">
                Belum ada data transaksi simpanan.
            </div>
        @endif
        <div class="px-6 py-3 border-t border-gray-200">
            {{ $savings->links() }}
        </div>
    </div>
</div>
@endsection
