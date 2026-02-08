@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Detail Anggota</h1>
             <a href="{{ route('anggota.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Kembali</a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-8">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">NIK (Nomor Induk Kependudukan)</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $anggota->nik }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $anggota->name }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $anggota->address }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $anggota->phone }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Tanggal Bergabung</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $anggota->join_date }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Akun Pengguna</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($anggota->user)
                                Terhubung dengan: {{ $anggota->user->email }}
                            @else
                                <span class="text-gray-500 italic">Belum terhubung</span>
                                <form action="{{ route('anggota.create_user', $anggota->id) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    <button type="submit" class="text-xs bg-indigo-600 text-white px-2 py-1 rounded hover:bg-indigo-700">Buat Akun</button>
                                </form>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
