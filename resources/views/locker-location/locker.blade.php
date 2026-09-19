@extends('layout.user')

@section('content')
<div class="flex flex-col pt-5 w-full sm:px-6 lg:px-8">
    <form action="{{ route('location-user') }}" method="get">
        <button type="submit" class="group">
            <p class="flex items-center gap-2">
                <i class="fa-solid fa-arrow-left-long transition-transform duration-300 group-hover:-translate-x-2" style="color: rgb(0, 0, 0);"></i>
                Back to all location
            </p>
        </button>
    </form>

    <h6 class="text-2xl sm:text-3xl font-bold">
        {{ $locker->name_location }}
    </h6>
    <p class="text-base sm:text-lg text-gray-600">
        {{ $locker->adress }}
    </p>

    <div class="mt-4">
        <img src="{{ asset('images/camera.png') }}" class="w-full h-60 rounded-xl" alt="">
    </div>

    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <h6 class="text-lg sm:text-xl font-bold">Locker locations</h6>
            <p class="text-sm text-gray-500">Choose a location to see live locker availability.</p>
        </div>

        <select class="border border-gray-200 rounded-md px-3 py-2 text-sm font-medium">
            <option>Available</option>
            <option>Occupied</option>
        </select>
    </div>

    <div class="mt-5 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($locker->lockers as $lockers)
            @php
                $isAvailable = $lockers->status === 'available'; // adjust to your actual status field/value
            @endphp
            <div class="border border-gray-100 rounded-xl p-3 shadow-sm bg-white">
                <h6 class="font-bold text-base mb-2">{{ $lockers->locker_title }}</h6>

                <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full mb-2
                    {{ $isAvailable ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ $isAvailable ? 'AVAILABLE' : 'OCCUPIED' }}
                </span>

                <div class="bg-gray-100 rounded-md px-3 py-2 text-sm text-gray-600">
                    {{ $isAvailable ? 'Already have one here' : 'In use' }}
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-full">No lockers at this location yet.</p>
        @endforelse
    </div>
</div>
@endsection