@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Loan Details</h1>
            <a href="{{ route('loans.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Back</a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-8">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Member</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $loan->member->name }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                             <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $loan->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $loan->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $loan->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $loan->status === 'paid' ? 'bg-blue-100 text-blue-800' : '' }}">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Amount</dt>
                        <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($loan->amount, 0, ',', '.') }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Total Interest (Est.)</dt>
                        <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($loan->amount * ($loan->interest_rate / 100), 0, ',', '.') }}</dd>
                    </div>
                     <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Duration</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $loan->duration }} Months</dd>
                    </div>
                    @if($loan->approved_by)
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Approved By</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $loan->approver->name }} on {{ $loan->approval_date }}</dd>
                    </div>
                    @endif

                </dl>
                
                <div class="mt-8 border-t pt-4 no-print">
                    <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Print Loan Agreement</button>
                    @if($loan->status === 'approved')
                        <a href="{{ route('installments.create', ['loan_id' => $loan->id]) }}" class="ml-3 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Pay Installment</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Installments Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
             <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Installments History</h3>
            </div>
             <div class="p-6">
                 @if($loan->installments->isEmpty())
                    <p class="text-gray-500">No installments recorded yet.</p>
                 @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase">Amount Paid</th>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase">Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loan->installments as $installment)
                            <tr>
                                <td class="py-2">{{ $installment->payment_date }}</td>
                                <td class="py-2">Rp {{ number_format($installment->amount_paid, 0, ',', '.') }}</td>
                                <td class="py-2">{{ $installment->note }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                 @endif
                 
                 <!-- Simple link to add installment if approved -->
                 @if($loan->status === 'approved')
                    <div class="mt-4">
                        <a href="{{ route('installments.create', ['loan_id' => $loan->id]) }}" class="text-indigo-600 hover:text-indigo-900">Record Installment Payment</a>
                    </div>
                 @endif
             </div>
        </div>
    </div>
</div>
@endsection
