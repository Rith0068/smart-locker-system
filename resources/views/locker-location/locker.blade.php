@extends('layout.user')

@section('content')
<div class="flex flex-col pt-5 w-full sm:px-6 lg:px-8">
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

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
    </div>

    @php
        $myInUse = $locker->lockers->firstWhere(function ($item) {
            return $item->status === 'in_use' && $item->user_id === auth()->id();
        });
    @endphp

    <div class="mt-5 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($locker->lockers as $lockers)
            @php
                $isAvailable = $lockers->status === 'available';
                $isMine = $lockers->user_id === auth()->id() && $lockers->status === 'in_use';
            @endphp
            <div class="border border-gray-100 rounded-xl p-3 shadow-sm bg-white">
                <h6 class="font-bold text-base mb-2">{{ $lockers->locker_title }}</h6>

                <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full mb-2
                    {{ $isAvailable ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ $isAvailable ? 'AVAILABLE' : 'IN USE' }}
                </span>

                <p class="text-sm text-gray-600 mb-3 {{ $isAvailable ? 'text-green-600' : '' }}">
                    {{ $isMine ? 'You are using this locker.' : ($isAvailable ? 'Ready to use' : 'Used by someone else') }}
                </p>

                @if ($isMine)
                    <form action="{{ route('release-locker', $lockers->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-red-500 text-white text-sm font-semibold rounded-md py-2 hover:bg-red-600 transition-colors">
                            Release
                        </button>
                    </form>
                @elseif ($isAvailable)
                    @if ($myInUse)
                        <button disabled class="w-full bg-gray-200 text-gray-500 text-sm font-semibold rounded-md py-2 cursor-not-allowed">
                            Already using {{ $myInUse->locker_title }}
                        </button>
                    @else
                        <form action="{{ route('use-locker', $lockers->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 text-white text-sm font-semibold rounded-md py-2 hover:bg-blue-700 transition-colors">
                                Use
                            </button>
                        </form>
                    @endif
                @else
                    <button disabled class="w-full bg-gray-200 text-gray-500 text-sm font-semibold rounded-md py-2 cursor-not-allowed">
                        In use
                    </button>
                @endif
            </div>
        @empty
            <p class="text-gray-500 col-span-full">No lockers at this location yet.</p>
        @endforelse
    </div>
</div>
@endsection