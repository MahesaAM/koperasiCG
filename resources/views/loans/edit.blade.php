@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Edit Loan Application</h1>
            <a href="{{ route('loans.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Back</a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('loans.update', $loan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                             <label class="block text-sm font-medium text-gray-700">Member</label>
                             <div class="mt-1 p-2 bg-gray-100 rounded-md">{{ $loan->member->name }}</div>
                             <input type="hidden" name="member_id" value="{{ $loan->member_id }}">
                        </div>
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount (Rp)</label>
                            <input type="number" name="amount" id="amount" value="{{ $loan->amount }}" min="0" step="1000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label for="interest_rate" class="block text-sm font-medium text-gray-700">Interest Rate (%)</label>
                            <input type="number" name="interest_rate" id="interest_rate" value="{{ $loan->interest_rate }}" min="0" step="0.1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700">Duration (Months)</label>
                            <input type="number" name="duration" id="duration" value="{{ $loan->duration }}" min="1" step="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label for="application_date" class="block text-sm font-medium text-gray-700">Application Date</label>
                            <input type="date" name="application_date" id="application_date" value="{{ $loan->application_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
