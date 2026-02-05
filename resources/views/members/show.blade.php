@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Member Details</h1>
             <a href="{{ route('members.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Back</a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-8">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">NIK</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $member->nik }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $member->name }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $member->address }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $member->phone }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Join Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $member->join_date }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">User Account</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($member->user)
                                Linked to: {{ $member->user->email }}
                            @else
                                <span class="text-gray-500 italic">Not linked</span>
                                <form action="{{ route('members.create_user', $member->id) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    <button type="submit" class="text-xs bg-indigo-600 text-white px-2 py-1 rounded hover:bg-indigo-700">Create Account</button>
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
