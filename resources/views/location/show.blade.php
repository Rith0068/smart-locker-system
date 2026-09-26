{{-- resources/views/location/show.blade.php --}}
@extends('layout.staff')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-6">
        <a href="{{ route('location.index') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to locations
        </a>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $location->name_location }}</h1>
                <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $location->adress }}
                </p>
            </div>

            <div class="flex gap-2 shrink-0">
                <a href="{{ route('location.edit', $location->id) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg border border-yellow-200 text-yellow-600 text-sm font-medium hover:bg-yellow-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <form action="{{ route('location.destroy', $location->id) }}" method="POST"
                      onsubmit="return confirm('Delete this location?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg border border-red-200 text-red-600 text-sm font-medium hover:bg-red-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <!-- Hero image -->
        <div class="relative">
            @if ($location->img)
                <img src="{{ Storage::url($location->img) }}"
                     alt="{{ $location->name_location }}"
                     class="w-full h-80 sm:h-[28rem] object-cover">
            @else
                <div class="w-full h-80 sm:h-[28rem] bg-gray-50 flex items-center justify-center text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V6a2 2 0 012-2h14a2 2 0 012 2v10.5M3 16.5l4-4a2 2 0 012.8 0l1.2 1.2a2 2 0 002.8 0L18 9.5l3 3M3 16.5V18a2 2 0 002 2h14a2 2 0 002-2v-1.5" />
                    </svg>
                </div>
            @endif

            <span class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1.5 rounded-full text-xs font-semibold text-gray-700 shadow-sm">
                {{ $location->lockers_count ?? $location->lockers->count() ?? 0 }} locker{{ ($location->lockers_count ?? $location->lockers->count() ?? 0) === 1 ? '' : 's' }}
            </span>
        </div>

        <!-- Info grid -->
        <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="flex items-start gap-3 rounded-lg border border-gray-100 bg-gray-50 px-4 py-3.5">
                <div class="shrink-0 h-9 w-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21h2m0 0h10" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Name</p>
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $location->name_location }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3 rounded-lg border border-gray-100 bg-gray-50 px-4 py-3.5">
                <div class="shrink-0 h-9 w-9 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Address</p>
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $location->adress }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3 rounded-lg border border-gray-100 bg-gray-50 px-4 py-3.5">
                <div class="shrink-0 h-9 w-9 rounded-lg bg-green-100 text-green-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Added on</p>
                    <p class="text-sm font-medium text-gray-800">{{ $location->created_at->format('M d, Y') }}</p>
                    <p class="text-xs text-gray-400">{{ $location->created_at->format('h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Footer actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <a href="{{ route('locker.index', ['search' => $location->name_location]) }}"
               class="inline-flex items-center gap-1.5 text-sm text-blue-600 font-medium hover:underline">
                View lockers at this location
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
            <a href="{{ route('location.index') }}"
               class="px-4 py-2.5 rounded-lg border border-gray-200 text-sm text-gray-600 hover:bg-gray-100 transition-colors">
                Back to list
            </a>
        </div>
    </div>
</div>
@endsection