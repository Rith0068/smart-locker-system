@extends('layout.staff')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <a href="{{ route('locker.index') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to lockers
            </a>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $locker->locker_title }}</h1>
            <p class="text-sm text-gray-500 mt-1">Locker #{{ $locker->id }}</p>
        </div>

        @php
            if ($locker->isAvailable()) {
                $statusClass = 'bg-green-100 text-green-700 ring-green-600/20';
                $dotClass = 'bg-green-500';
            } elseif ($locker->isInUse()) {
                $statusClass = 'bg-blue-100 text-blue-700 ring-blue-600/20';
                $dotClass = 'bg-blue-500';
            } elseif ($locker->isInMaintenance()) {
                $statusClass = 'bg-red-100 text-red-700 ring-red-600/20';
                $dotClass = 'bg-red-500';
            } else {
                $statusClass = 'bg-gray-100 text-gray-700 ring-gray-500/20';
                $dotClass = 'bg-gray-400';
            }
        @endphp
        <span class="self-start sm:self-auto px-3 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wide ring-1 ring-inset inline-flex items-center gap-1.5 {{ $statusClass }}">
            <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
            {{ $locker->statusLabel() }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main details -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Locker Information</h2>
            </div>

            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">

                {{-- Location --}}
                <div class="flex gap-3">
                    <div class="w-9 h-9 rounded-lg bg-purple-50 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-400">Location</p>
                        <p class="font-medium text-gray-800">{{ $locker->location->name_location ?? '—' }}</p>
                        @if($locker->location?->adress)
                            <p class="text-sm text-gray-500">{{ $locker->location->adress }}</p>
                        @endif
                    </div>
                </div>

                {{-- Size --}}
                <div class="flex gap-3">
                    <div class="w-9 h-9 rounded-lg bg-purple-50 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V6a2 2 0 012-2h12a2 2 0 012 2v2m0 0H4m0 0h16v10a2 2 0 01-2 2H6a2 2 0 01-2-2V8zm4 4h.01M12 12h.01M16 12h.01M8 16h.01M12 16h.01" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-400">Size</p>
                        <p class="font-medium text-gray-800">{{ $locker->size ?? '—' }}</p>
                    </div>
                </div>

                {{-- Description --}}
                <div class="flex gap-3 sm:col-span-2">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-400">Description</p>
                        <p class="font-medium text-gray-800 whitespace-pre-line">{{ $locker->description ?: '—' }}</p>
                    </div>
                </div>

            </div>

            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 text-xs text-gray-400 flex justify-between">
                <span>Created {{ $locker->created_at?->diffForHumans() ?? '—' }}</span>
                <span>Updated {{ $locker->updated_at?->diffForHumans() ?? '—' }}</span>
            </div>
        </div>

        <!-- Actions sidebar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-fit space-y-3">
            <h2 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">Actions</h2>

            <a href="{{ route('locker.edit', $locker->id) }}"
               class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Locker
            </a>

            <form action="{{ route('locker.destroy', $locker->id) }}" method="POST"
                  onsubmit="return confirm('Delete this locker? This cannot be undone.');" class="w-full">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Locker
                </button>
            </form>

            <a href="{{ route('locker.index') }}"
               class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Back to List
            </a>
        </div>
    </div>
</div>
@endsection