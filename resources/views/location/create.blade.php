{{-- resources/views/staff/locations/create.blade.php --}}
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
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Add Location</h1>
        <p class="text-sm text-gray-500 mt-1">Create a new location record</p>
    </div>

    <form action="{{ route('location.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @csrf

        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Location Information</h2>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="text-sm font-medium text-gray-700 mb-1 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V6a2 2 0 012-2h14a2 2 0 012 2v10.5M3 16.5l4-4a2 2 0 012.8 0l1.2 1.2a2 2 0 002.8 0L18 9.5l3 3M3 16.5V18a2 2 0 002 2h14a2 2 0 002-2v-1.5" />
                    </svg>
                    Location Image
                </label>

                <div class="rounded-lg overflow-hidden border border-gray-200 bg-gray-50 h-44">
                    <div id="image-preview-placeholder" class="w-full h-44 flex items-center justify-center text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V6a2 2 0 012-2h14a2 2 0 012 2v10.5M3 16.5l4-4a2 2 0 012.8 0l1.2 1.2a2 2 0 002.8 0L18 9.5l3 3M3 16.5V18a2 2 0 002 2h14a2 2 0 002-2v-1.5" />
                        </svg>
                    </div>
                    <img id="image-preview" src="" alt="" class="w-full h-44 object-cover hidden">
                </div>

                <label class="mt-3 flex items-center justify-center gap-2 border border-dashed border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-500 hover:border-blue-400 hover:text-blue-600 cursor-pointer transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Choose image
                    <input type="file" name="img" accept="image/*" class="hidden" onchange="previewImage(event)">
                </label>
                @error('img') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-5">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 flex items-center gap-1.5">Name</label>
                    <input type="text" name="name_location" value="{{ old('name_location') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none">
                    @error('name_location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 flex items-center gap-1.5">Address</label>
                    <input type="text" name="adress" value="{{ old('adress') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none">
                    @error('adress') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('location.index') }}" class="px-4 py-2.5 rounded-lg border border-gray-200 text-sm text-gray-600 hover:bg-gray-100 transition-colors">Cancel</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors">Save Location</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('image-preview-placeholder');

    preview.src = URL.createObjectURL(file);
    preview.classList.remove('hidden');
    if (placeholder) placeholder.classList.add('hidden');
}
</script>
@endpush
@endsection