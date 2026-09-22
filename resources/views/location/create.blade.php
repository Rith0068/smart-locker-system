@extends('layout.staff')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Add Location</h1>

    <form action="{{ route('location.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-6 rounded-xl shadow space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name_location" value="{{ old('name_location') }}"
                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            @error('name_location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
            <input type="text" name="adress" value="{{ old('adress') }}"
                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            @error('adress') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
            <input type="file" name="img" accept="image/*"
                   class="w-full border rounded-lg px-3 py-2 text-sm">
            @error('img') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('location.index') }}" class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">Cancel</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium">Save</button>
        </div>
    </form>
</div>
@endsection