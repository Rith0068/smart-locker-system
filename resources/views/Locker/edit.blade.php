@extends('layout.staff')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-6">
        <a href="{{ route('locker.index') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to lockers
        </a>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Edit Locker</h1>
        <p class="text-sm text-gray-500 mt-1">Locker #{{ $locker->id }}</p>
    </div>

    <form action="{{ route('locker.update', $locker->id) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @csrf
        @method('PUT')

        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Locker Information</h2>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Locker Title --}}
            <div>
                <label for="locker_title" class="text-sm font-medium text-gray-700 mb-1 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Locker Title
                </label>
                <input type="text" id="locker_title" name="locker_title" value="{{ old('locker_title', $locker->locker_title) }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none">
                @error('locker_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Location --}}
            <div>
                <label for="locations_id" class="text-sm font-medium text-gray-700 mb-1 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Location
                </label>
                <select id="locations_id" name="locations_id"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none">
                    <option value="">Select location</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" @selected((string) old('locations_id', $locker->locations_id) === (string) $location->id)>{{ $location->name_location }}</option>
                    @endforeach
                </select>
                @error('locations_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Size --}}
            <div>
                <label for="size" class="text-sm font-medium text-gray-700 mb-1 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V6a2 2 0 012-2h12a2 2 0 012 2v2m0 0H4m0 0h16v10a2 2 0 01-2 2H6a2 2 0 01-2-2V8zm4 4h.01M12 12h.01M16 12h.01M8 16h.01M12 16h.01" />
                    </svg>
                    Size
                </label>
                <input type="text" id="size" name="size" value="{{ old('size', $locker->size) }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none">
                @error('size') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div class="md:col-span-2">
                <label for="description" class="text-sm font-medium text-gray-700 mb-1 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Description
                </label>
                <textarea id="description" name="description" rows="3"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none">{{ old('description', $locker->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('locker.index') }}" class="px-4 py-2.5 rounded-lg border border-gray-200 text-sm text-gray-600 hover:bg-gray-100 transition-colors">Cancel</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors">Update Locker</button>
        </div>
    </form>
</div>
@endsection