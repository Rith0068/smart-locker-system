@extends('layout.user')

@section('content')

 <!-- locker's cart  -->
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
        <img src="{{ $locker->img ? Storage::url($locker->img) : asset('images/camera.png') }}" class="w-full h-60 rounded-xl" alt="">
    </div>
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <h6 class="text-lg sm:text-xl font-bold">Locker locations</h6>
            <p class="text-sm text-gray-500">Choose a location to see live locker availability.</p>
        </div>
    </div>

    @php
        $myInUse = $locker->lockers->first(fn ($item) => $item->isUsedBy(auth()->id()));
    @endphp

    <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($locker->lockers as $item)
            @php
                $isAvailable = $item->isAvailable();
                $isMine = $item->isUsedBy(auth()->id());
                $statusClass = $isAvailable
                    ? 'bg-green-100 text-green-700'
                    : ($item->isInMaintenance()
                        ? 'bg-red-100 text-red-700'
                        : 'bg-blue-100 text-blue-700');
            @endphp
            <div class="border border-gray-100 rounded-xl p-3 shadow-sm bg-white">
                <h6 class="font-bold text-base mb-2">{{ $item->locker_title }}</h6>
                

                <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full mb-2 {{ $statusClass }}">
                    {{ strtoupper($item->statusLabel()) }}
                </span>
                @if ($item->size)
                    <p class="text-xs text-gray-500 mb-1">Size: {{ $item->size }}</p>
                @endif

                @if ($item->description)
                    <p class="text-xs text-gray-500 mb-2 line-clamp-2">{{ $item->description }}</p>
                @endif

                @if ($isMine)
                    <form action="{{ route('release-locker', $item->id) }}" method="POST">
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
                        <form action="{{ route('use-locker', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 text-white text-sm font-semibold rounded-md py-2 hover:bg-blue-700 transition-colors">
                                Use
                            </button>
                        </form>
                    @endif
                @else
                    <button disabled class="w-full bg-gray-200 text-gray-500 text-sm font-semibold rounded-md py-2 cursor-not-allowed">
                        {{ $item->isInMaintenance() ? 'In maintenance' : 'In use' }}
                    </button>
                @endif
            </div>
        @empty
            <p class="text-gray-500 col-span-full">No lockers at this location yet.</p>
        @endforelse
    </div>
</div>
@endsection