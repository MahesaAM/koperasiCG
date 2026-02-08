@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Print Header -->
        <div class="hidden print:block mb-8 text-center">
            <h2 class="text-2xl font-bold">Koperasi Cahaya Gemilang</h2>
            <h3 class="text-xl">Bukti Transaksi Simpanan</h3>
        </div>

        <div class="flex justify-between items-center mb-6 no-print">
            <h1 class="text-2xl font-semibold text-gray-900">Transaction Details</h1>
            <a href="{{ route('savings.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Back</a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-8">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Transaction Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $saving->transaction_date }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Transaction ID</dt>
                        <dd class="mt-1 text-sm text-gray-900">#{{ $saving->id }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Member</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $saving->member->name }} ({{ $saving->member->nik }})</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Savings Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($saving->type) }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Transaction Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $saving->transaction_type === 'deposit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($saving->transaction_type) }}
                            </span>
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Amount</dt>
                        <dd class="mt-1 text-sm text-gray-900 text-lg font-bold">Rp {{ number_format($saving->amount, 0, ',', '.') }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $saving->description ?? '-' }}</dd>
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
