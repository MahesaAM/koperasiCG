@extends('layouts.app')

@section('header')
<h1 class="text-3xl font-bold text-gray-900 leading-tight">Catat Transaksi Simpanan</h1>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Detail Transaksi</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Catat setoran atau penarikan untuk anggota.
                </p>
                <div class="mt-4 p-4 bg-blue-50 rounded-md border-l-4 border-blue-400">
                    <p class="text-sm text-blue-700">
                        <strong>Catatan:</strong> Penarikan akan divalidasi terhadap saldo anggota saat ini.
                    </p>
                </div>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
                    <div class="flex">
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada input Anda</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('savings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <label for="member_id" class="block text-sm font-medium text-gray-700">Anggota</label>
                                @if(auth()->user()->role === 'member' && auth()->user()->anggota)
                                    <select disabled class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-100 rounded-md shadow-sm focus:outline-none sm:text-sm">
                                        <option value="{{ auth()->user()->anggota->id }}">{{ auth()->user()->anggota->name }} - {{ auth()->user()->anggota->nik }}</option>
                                    </select>
                                    <input type="hidden" name="member_id" value="{{ auth()->user()->anggota->id }}">
                                @else
                                    <select id="member_id" name="member_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @foreach($daftarAnggota as $anggota)
                                            <option value="{{ $anggota->id }}">{{ $anggota->name }} - {{ $anggota->nik }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="transaction_type" class="block text-sm font-medium text-gray-700">Jenis Transaksi</label>
                                <select id="transaction_type" name="transaction_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="deposit">Setoran (Deposit)</option>
                                    <option value="withdrawal">Penarikan (Withdrawal)</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="type" class="block text-sm font-medium text-gray-700">Jenis Simpanan</label>
                                <select id="type" name="type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="pokok">Simpanan Pokok</option>
                                    <option value="wajib">Simpanan Wajib</option>
                                    <option value="sukarela">Simpanan Sukarela</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah (Rp)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00" required>
                                </div>
                            </div>
                            
                             <div class="col-span-6 sm:col-span-3">
                                <label for="transaction_date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                                <input type="date" name="transaction_date" id="transaction_date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ date('Y-m-d') }}" required>
                            </div>

                             <div class="col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">Keterangan (Opsional)</label>
                                <input type="text" name="description" id="description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                             <div class="col-span-6" id="proof-container">
                                <label for="proof_file" class="block text-sm font-medium text-gray-700">Bukti Transfer {{ auth()->user()->role === 'member' ? '(Wajib untuk Setoran)' : '(Opsional)' }}</label>
                                <input type="file" name="proof_file" id="proof_file" class="mt-1 block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100">
                            </div>

                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <a href="{{ route('savings.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">Batal</a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Proses Transaksi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if(document.getElementById('member_id')) {
            new TomSelect("#member_id", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: 'Cari Anggota (Nama atau NIK)...'
            });
        }

        const typeSelect = document.getElementById('transaction_type');
        const proofInput = document.getElementById('proof_file');
        const isMember = {{ auth()->user()->role === 'member' ? 'true' : 'false' }};

        if (typeSelect && proofInput && isMember) {
            function updateProofRequirement() {
                if (typeSelect.value === 'deposit') {
                    proofInput.setAttribute('required', 'required');
                } else {
                    proofInput.removeAttribute('required');
                }
            }
            typeSelect.addEventListener('change', updateProofRequirement);
            updateProofRequirement(); // Init check
        }
    });
</script>
@endpush
