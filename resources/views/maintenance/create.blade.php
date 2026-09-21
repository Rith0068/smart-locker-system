@extends('layout.staff')

@section('content')
<div class="p-6 w-full space-y-6 pt-15">

    {{-- Page header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-[30px] font-bold text-gray-800">Add Maintenance Record</h1>
            <p class="text-sm text-gray-500">Log a new maintenance entry for a locker</p>
        </div>
        <a href="{{ route('maintenance.index') }}"
           class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 448 512" fill="currentColor">
                <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 288H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H109.3L214.6 105.4c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
            </svg>
            Back to list
        </a>
    </div>

    @if ($errors->any())
        <div class="p-3.5 bg-red-50 text-red-700 border border-red-100 rounded-lg text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Full-width form card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form method="POST" action="{{ route('maintenance.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Locker</label>
                    <select name="lockers_id"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        <option value="">Select a locker</option>
                        @foreach ($lockers as $locker)
                            <option value="{{ $locker->id }}" {{ old('lockers_id') == $locker->id ? 'selected' : '' }}>
                                {{ $locker->locker_title ?? 'Locker #' . $locker->id }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                    <select name="status"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Available</option>
                        <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Maintenance</option>
                        <option value="3" {{ old('status') == 3 ? 'selected' : '' }}>In Use</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                <textarea name="description" rows="5"
                          placeholder="What happened, or what needs to be done..."
                          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                          required>{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-gray-100 mt-2">
                <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium shadow-sm mt-4">
                    Save Record
                </button>
                <a href="{{ route('maintenance.index') }}"
                   class="text-gray-500 text-sm hover:text-gray-700 mt-4">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</div>
@endsection