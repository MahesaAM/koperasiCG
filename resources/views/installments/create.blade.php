@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Record Installment Payment</h1>
            <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Back</a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('installments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label for="loan_id" class="block text-sm font-medium text-gray-700">Select Loan</label>
                            <select name="loan_id" id="loan_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required {{ $loan ? 'readonly' : '' }}>
                                <option value="">Select Approved Loan</option>
                                @foreach ($loans as $l)
                                    <option value="{{ $l->id }}" {{ ($loan && $loan->id == $l->id) ? 'selected' : '' }}>
                                        Loan #{{ $l->id }} - {{ $l->anggota->name }} (Total: Rp {{ number_format($l->amount, 0) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                            <input type="date" name="payment_date" id="payment_date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label for="amount_paid" class="block text-sm font-medium text-gray-700">Amount Paid (Rp)</label>
                            <input type="number" name="amount_paid" id="amount_paid" min="0" step="1000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div class="col-span-2">
                            <label for="note" class="block text-sm font-medium text-gray-700">Note (Optional)</label>
                            <input type="text" name="note" id="note" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        
                         <div class="col-span-2">
                            <label for="proof_file" class="block text-sm font-medium text-gray-700">Bukti Transfer</label>
                            <input type="file" name="proof_file" id="proof_file" class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                              " required>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Record Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
