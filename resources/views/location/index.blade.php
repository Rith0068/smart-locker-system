@extends('layout.staff')

@section('content')
<div class="w-full px-6 py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Locations</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $locations->count() }} location{{ $locations->count() === 1 ? '' : 's' }} total</p>
        </div>
        <a href="{{ route('location.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-sm transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add Location
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="mb-8">
        <div class="relative w-full md:w-96">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or address..."
                   class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2.5 text-sm bg-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none">
        </div>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($locations as $location)
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition overflow-hidden group">
                <div class="relative">
                    @if ($location->img)
                        <img src="{{ Storage::url($location->img) }}" alt="{{ $location->name_location }}"
                             class="w-full h-44 object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <div class="w-full h-44 bg-gray-50 flex items-center justify-center text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V6a2 2 0 012-2h14a2 2 0 012 2v10.5M3 16.5l4-4a2 2 0 012.8 0l1.2 1.2a2 2 0 002.8 0L18 9.5l3 3M3 16.5V18a2 2 0 002 2h14a2 2 0 002-2v-1.5" />
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="p-4">
                    <h2 class="font-semibold text-gray-800 text-base truncate">{{ $location->name_location }}</h2>
                    <p class="text-sm text-gray-500 mt-1 line-clamp-1">{{ $location->adress }}</p>

                    <div class="flex justify-end items-center mt-4 pt-3 border-t border-gray-100 gap-4">
                        <a href="{{ route('location.edit', $location->id) }}"
                           class="text-sm font-medium text-yellow-600 hover:text-yellow-700">Edit</a>
                        <form action="{{ route('location.destroy', $location->id) }}" method="POST"
                              onsubmit="return confirm('Delete this location?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <p class="text-gray-400">No locations found.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection