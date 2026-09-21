@extends('layout.user')

@section('content')
<div class="flex flex-col pt-5 w-full sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h6 class="text-2xl sm:text-3xl font-bold">
                Locker Locations
            </h6>
            <p class="text-base sm:text-lg text-gray-600">
                Choose a location to see live locker availability.
            </p>
        </div>
    </div>

    <form action="{{ route('location-user') }}" method="get" class="border border-gray-200 my-5 py-2 px-3 w-full sm:w-96">
        <input type="search" name="search" value="{{ request('search') }}" class="w-full outline-none" placeholder="Search by name or address...">
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach($locations as $location)
            <form action="{{ route('view-locker', ['id' => $location->id]) }}" method="GET">
                <button type="submit" class="w-full text-left">
                    <div class="flex flex-col w-60 border border-gray-100 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <!-- <img src="{{ $location->img ?? asset('images/library.jpg') }}" -->
                        <img src="{{  asset('images/camera.png') }}"
                        class="w-full h-30 sm:h-40 object-cover" alt="{{ $location->name_location }}">
                        <div class="py-3 px-3">
                            <h6 class="font-bold text-base sm:text-lg">
                                {{ $location->name_location }}
                            </h6>
                            <p class="text-sm sm:text-md text-gray-500 line-clamp-2">
                                {{ $location->adress }}
                            </p>
                        </div>
                    </div>
                </button>
            </form>
        @endforeach
    </div>
</div>
@endsection