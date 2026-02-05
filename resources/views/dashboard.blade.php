@extends('layouts.app')

@section('header')
<h1 class="text-3xl font-bold text-gray-900 leading-tight">Ringkasan Dashboard</h1>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    @if(auth()->check() && auth()->user()->role == 'member' && isset($warning))
        <div class="rounded-md bg-yellow-50 p-4 mb-6 border-l-4 border-yellow-400">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-yellow-700">{{ $warning }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'manager', 'kasir']))
        <!-- Total Members Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100 transform transition hover:scale-105">
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Anggota</dt>
                            <dd class="text-3xl font-bold text-gray-900">{{ $totalMembers ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-3">
                <div class="text-sm">
                    <a href="{{ route('members.index') }}" class="font-medium text-blue-600 hover:text-blue-500">Lihat semua anggota <span aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
        </div>
        @endif

        <!-- Total Savings Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100 transform transition hover:scale-105">
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Simpanan</dt>
                            <dd class="text-3xl font-bold text-gray-900">Rp {{ number_format($totalSavings ?? 0, 0, ',', '.') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-3">
                <div class="text-sm">
                    <a href="{{ route('savings.index') }}" class="font-medium text-green-600 hover:text-green-500">Lihat transaksi <span aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
        </div>

        <!-- Active Loans Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100 transform transition hover:scale-105">
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
                         <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pinjaman Aktif</dt>
                            <dd class="text-3xl font-bold text-gray-900">{{ $activeLoans ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-3">
                <div class="text-sm">
                    <a href="{{ route('loans.index') }}" class="font-medium text-red-600 hover:text-red-500">Kelola Pinjaman <span aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'manager', 'kasir']))
    <div class="mt-8">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
             <a href="{{ route('members.create') }}" class="relative block rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-5 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-indigo-50 flex items-center justify-center">
                        <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <p class="text-sm font-medium text-gray-900">Tambah Anggota</p>
                    <p class="text-sm text-gray-500 truncate">Daftarkan anggota baru</p>
                </div>
            </a>

            <a href="{{ route('savings.create') }}" class="relative block rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-5 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-green-50 flex items-center justify-center">
                         <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <p class="text-sm font-medium text-gray-900">Transaksi Baru</p>
                    <p class="text-sm text-gray-500 truncate">Setor atau tarik simpanan</p>
                </div>
            </a>

            <a href="{{ route('loans.create') }}" class="relative block rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-5 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-red-50 flex items-center justify-center">
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <p class="text-sm font-medium text-gray-900">Ajukan Pinjaman</p>
                    <p class="text-sm text-gray-500 truncate">Buat aplikasi pinjaman baru</p>
                </div>
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
