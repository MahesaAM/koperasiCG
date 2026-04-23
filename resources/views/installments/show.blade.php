@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Print Header -->
        <div class="hidden print:block mb-8 text-center">
            <h2 class="text-2xl font-bold">Koperasi Cahaya Gemilang</h2>
        <p class="text-sm text-gray-600 mt-1">Perum Yuliani Gg. Cemara No. 6–7, Karang Tengah, Kecamatan-Kaliwungu, Kabupaten-Kendal, Jawa-Tengah.</p>
            <h3 class="text-xl">Bukti Pembayaran Angsuran</h3>
        </div>

        <div class="flex justify-between items-center mb-6 no-print">
            <h1 class="text-2xl font-semibold text-gray-900">Payment Details</h1>
            <a href="{{ route('installments.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Back</a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-8">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Payment Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $installment->payment_date }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Payment ID</dt>
                        <dd class="mt-1 text-sm text-gray-900">#{{ $installment->id }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Loan Reference</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a href="{{ route('loans.show', $installment->loan_id) }}" class="text-blue-600 hover:underline">
                                Loan #{{ $installment->loan_id }}
                            </a>
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Member</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $installment->loan->anggota->name }}</dd>
                    </div>
                    
                    <div class="sm:col-span-1 bg-green-50 p-2 rounded">
                        <dt class="text-sm font-medium text-green-800">Total Paid</dt>
                        <dd class="mt-1 text-lg font-bold text-green-900">Rp {{ number_format($installment->amount_paid, 0, ',', '.') }}</dd>
                    </div>
                    <div class="sm:col-span-1 bg-gray-50 p-2 rounded">
                        <dt class="text-sm font-medium text-gray-500">Breakdown</dt>
                        <dd class="mt-1 text-sm text-gray-700">
                            Principal: Rp {{ number_format($installment->principal_paid, 0, ',', '.') }} <br>
                            Interest: Rp {{ number_format($installment->interest_paid, 0, ',', '.') }}
                        </dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Note</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $installment->note ?? '-' }}</dd>
                    </div>
                </dl>
                
                <div class="mt-8 border-t pt-4 no-print">
                    <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Print Receipt</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
