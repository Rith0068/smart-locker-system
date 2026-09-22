@extends('layout.staff')

@section('content')
<div class="max-w-xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Locker Details</h1>

    <div class="bg-white p-6 rounded-xl shadow space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs uppercase text-gray-400">Title</p>
                <p class="font-medium text-gray-800">{{ $locker->locker_title }}</p>
            </div>
            <div>
                <p class="text-xs uppercase text-gray-400">User</p>
                <p class="font-medium text-gray-800">{{ $locker->user->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase text-gray-400">Location</p>
                <p class="font-medium text-gray-800">{{ $locker->location->name_location ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase text-gray-400">Start</p>
                <p class="font-medium text-gray-800">{{ $locker->start }}</p>
            </div>
            <div>
                <p class="text-xs uppercase text-gray-400">Releave</p>
                <p class="font-medium text-gray-800">{{ $locker->releave }}</p>
            </div>
        </div>

        <div class="pt-4 flex gap-3">
            <a href="{{ route('locker.edit', $locker->id) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">Edit</a>
            <a href="{{ route('locker.index') }}"
               class="border px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Back</a>
        </div>
    </div>
</div>
@endsection