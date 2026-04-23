@extends('layouts.app')

@section('header')
<h1 class="text-3xl font-bold text-gray-900 leading-tight">Ajukan Pinjaman</h1>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Detail Pinjaman</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Isi detail pengajuan pinjaman. Status aplikasi akan 'Menunggu' sampai disetujui oleh Admin atau Manajer.
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="{{ route('loans.store') }}" method="POST">
                @csrf
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                             <div class="col-span-6">
                                <label for="member_id" class="block text-sm font-medium text-gray-700">Anggota</label>
                                @if(auth()->user()->role === 'member')
                                    @if(auth()->user()->anggota && auth()->user()->anggota->status === 'active')
                                        <select disabled class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-100 rounded-md shadow-sm focus:outline-none sm:text-sm">
                                            <option value="{{ auth()->user()->anggota->id }}">{{ auth()->user()->anggota->name }}</option>
                                        </select>
                                        <input type="hidden" name="member_id" value="{{ auth()->user()->anggota->id }}">
                                    @else
                                        <div class="mt-1 block w-full py-2 px-3 border border-red-300 bg-red-50 text-red-700 rounded-md shadow-sm sm:text-sm">
                                            Profil Anggota belum tersedia atau belum diaktifkan. Anda tidak dapat mengajukan pinjaman.
                                        </div>
                                    @endif
                                @else
                                    <select id="member_id" name="member_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @foreach($daftarAnggota as $anggota)
                                            <option value="{{ $anggota->id }}">{{ $anggota->name }} - {{ $anggota->nik }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah Pinjaman (Rp)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00" required>
                                </div>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-3">
                                <label for="interest_rate" class="block text-sm font-medium text-gray-700">Bunga (%)</label>
                                @if(auth()->user()->role === 'member')
                                    <input type="number" step="0.01" class="mt-1 block w-full bg-gray-100 shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-500" value="{{ $defaultInterestRate }}" disabled>
                                    <input type="hidden" name="interest_rate" id="interest_rate" value="{{ $defaultInterestRate }}">
                                    <p class="mt-1 text-xs text-gray-500">Bunga telah ditetapkan oleh Admin koperasi.</p>
                                @else
                                    <input type="number" step="0.01" name="interest_rate" id="interest_rate" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $defaultInterestRate }}" required>
                                @endif
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="duration" class="block text-sm font-medium text-gray-700">Durasi (Bulan)</label>
                                <input type="number" name="duration" id="duration" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="12" required>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="application_date" class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                                <input type="date" name="application_date" id="application_date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ date('Y-m-d') }}" required>
                            </div>
                             
                             <div class="col-span-6">
                                <label for="status" class="block text-sm font-medium text-gray-700">Status Awal</label>
                                <input type="text" disabled class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 bg-gray-100 rounded-md text-gray-500" value="Pending">
                                <input type="hidden" name="status" value="pending">
                            </div>

                            <!-- Estimasi Pembayaran UI -->
                            <div class="col-span-6 bg-indigo-50 border border-indigo-200 rounded-md p-4 mt-2">
                                <h4 class="text-sm font-medium text-indigo-800 mb-2">Estimasi Pembayaran</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-indigo-600">Total Pembayaran (Pokok + Bunga)</p>
                                        <p class="text-lg font-bold text-indigo-900" id="calc_total_payment">Rp 0</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-indigo-600">Cicilan per Bulan</p>
                                        <p class="text-lg font-bold text-indigo-900" id="calc_monthly_installment">Rp 0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <a href="{{ route('loans.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">Batal</a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Ajukan Pinjaman
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<style>
    /* Custom style to match Tailwind form inputs */
    .ts-control {
        border-radius: 0.375rem; /* rounded-md */
        padding: 0.5rem 0.75rem; /* py-2 px-3 */
        border-color: #d1d5db; /* border-gray-300 */
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
    }
    .ts-control:focus {
        border-color: #6366f1; /* border-indigo-500 */
        box-shadow: 0 0 0 1px #6366f1; /* ring-indigo-500 */
    }
    .ts-wrapper.single .ts-control {
        background-image: none;
    }
</style>
@endpush

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
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const amountInput = document.getElementById('amount');
        const interestRateInput = document.getElementById('interest_rate');
        const durationInput = document.getElementById('duration');
        
        const totalPaymentText = document.getElementById('calc_total_payment');
        const monthlyInstallmentText = document.getElementById('calc_monthly_installment');
        
        const formatCurrency = (number) => {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(number);
        };

        const calculateInstallment = () => {
            const amount = parseFloat(amountInput.value) || 0;
            const interestRate = parseFloat(interestRateInput.value) || 0;
            const duration = parseInt(durationInput.value) || 0;

            if (amount > 0 && duration > 0) {
                const totalInterest = amount * (interestRate / 100);
                const totalPayment = amount + totalInterest;
                const monthlyInstallment = totalPayment / duration;

                totalPaymentText.innerText = formatCurrency(totalPayment);
                monthlyInstallmentText.innerText = formatCurrency(monthlyInstallment);
            } else {
                totalPaymentText.innerText = 'Rp 0';
                monthlyInstallmentText.innerText = 'Rp 0';
            }
        };

        amountInput.addEventListener('input', calculateInstallment);
        interestRateInput.addEventListener('input', calculateInstallment);
        durationInput.addEventListener('input', calculateInstallment);
        
        calculateInstallment();
    });
</script>
@endpush
