@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Ubah Pengajuan Pinjaman</h1>
            <a href="{{ route('loans.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Kembali</a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('loans.update', $loan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                             <label class="block text-sm font-medium text-gray-700">Anggota</label>
                             <div class="mt-1 p-2 bg-gray-100 rounded-md">{{ $loan->anggota->name }}</div>
                             <input type="hidden" name="member_id" value="{{ $loan->member_id }}">
                        </div>
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah Pinjaman (Rp)</label>
                            <input type="number" name="amount" id="amount" value="{{ $loan->amount }}" min="0" step="1000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label for="interest_rate" class="block text-sm font-medium text-gray-700">Bunga (%)</label>
                            @if(auth()->user()->role === 'member')
                                <input type="number" step="0.1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 text-gray-500" value="{{ $loan->interest_rate }}" disabled>
                                <input type="hidden" name="interest_rate" id="interest_rate" value="{{ $loan->interest_rate }}">
                            @else
                                <input type="number" name="interest_rate" id="interest_rate" value="{{ $loan->interest_rate }}" min="0" step="0.1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @endif
                        </div>
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700">Durasi (Bulan)</label>
                            <input type="number" name="duration" id="duration" value="{{ $loan->duration }}" min="1" step="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label for="application_date" class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                            <input type="date" name="application_date" id="application_date" value="{{ $loan->application_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        
                        <!-- Estimasi Pembayaran UI -->
                        <div class="col-span-2 bg-indigo-50 border border-indigo-200 rounded-md p-4 mt-2">
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
                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
