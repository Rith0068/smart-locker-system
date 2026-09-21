@extends('sidbar.layout.staff')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Locker</h1>

    <form action="{{ route('locker.update', $locker->id) }}"
          method="POST" class="bg-white p-6 rounded-xl shadow space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Locker Title</label>
                <input type="text" name="locker_title" value="{{ old('locker_title', $locker->locker_title) }}"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('locker_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">User</label>
                <select name="user_id" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id', $locker->user_id) == $user->id)>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('user_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                <select name="locations_id" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" @selected(old('location_id', $locker->location_id) == $location->id)>{{ $location->name_location }}</option>
                    @endforeach
                </select>
                @error('location_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Start</label>
                <input type="text" name="start" value="{{ old('start', $locker->start) }}"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('start') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Releave</label>
                <input type="text" name="releave" value="{{ old('releave', $locker->releave) }}"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('releave') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('locker.index') }}" class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">Cancel</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium">Update</button>
        </div>
    </form>
</div>
@endsection