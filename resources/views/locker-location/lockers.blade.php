@extends('layout.user')

@section('content')
<div class="flex flex-col pt-5 w-full sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h6 class="text-2xl sm:text-3xl font-bold">
                Find Lockers
            </h6>
            <p class="text-base sm:text-lg text-gray-600">
                Click a status to filter lockers by their current state.
            </p>
        </div>
    </div>

    <div class="mt-5 flex flex-wrap gap-2">
        <a href="{{ route('user.lockers.index') }}"
           class="px-4 py-2 text-sm font-semibold rounded-full transition-colors
           {{ is_null($status) ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            All
        </a>
        <a href="{{ route('user.lockers.index', ['status' => 'available']) }}"
           class="px-4 py-2 text-sm font-semibold rounded-full transition-colors
           {{ $status === 'available' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
            Available
        </a>
        <a href="{{ route('user.lockers.index', ['status' => 'in_use']) }}"
           class="px-4 py-2 text-sm font-semibold rounded-full transition-colors
           {{ $status === 'in_use' ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-700 hover:bg-blue-200' }}">
            In use
        </a>
        <a href="{{ route('user.lockers.index', ['status' => 'in_maintenance']) }}"
           class="px-4 py-2 text-sm font-semibold rounded-full transition-colors
           {{ $status === 'in_maintenance' ? 'bg-red-600 text-white' : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
            In maintenance
        </a>
    </div>

    <p class="mt-4 text-sm text-gray-500">
        {{ $lockers->count() }} locker{{ $lockers->count() === 1 ? '' : 's' }} found
    </p>

    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse($lockers as $locker)
            @php
                $isAvailable = $locker->status === 'available';
                $isMine = $locker->user_id === auth()->id() && $locker->status === 'in_use';
            @endphp
            <div class="border border-gray-100 rounded-xl p-3 shadow-sm bg-white">
                <h6 class="font-bold text-base mb-2">{{ $locker->locker_title }}</h6>

                <p class="text-sm text-gray-600 truncate" title="{{ $locker->location->name_location ?? '' }}">
                    {{ $locker->location->name_location ?? '—' }}
                </p>

                <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full my-2
                    {{ $isAvailable ? 'bg-green-100 text-green-700' : ($locker->status === 'in_maintenance' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
                    {{ ucwords(str_replace('_', ' ', $locker->status)) }}
                </span>

                @if($isMine)
                    <form action="{{ route('release-locker', $locker->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-red-500 text-white text-sm font-semibold rounded-md py-2 hover:bg-red-600 transition-colors">
                            Release
                        </button>
                    </form>
                @elseif($isAvailable)
                    <a href="{{ route('view-locker', $locker->locations_id) }}"
                       class="block w-full text-center bg-blue-600 text-white text-sm font-semibold rounded-md py-2 hover:bg-blue-700 transition-colors">
                        Use this locker
                    </a>
                @else
                    <button disabled class="w-full bg-gray-200 text-gray-500 text-sm font-semibold rounded-md py-2 cursor-not-allowed">
                        {{ $locker->status === 'in_maintenance' ? 'In maintenance' : 'In use' }}
                    </button>
                @endif
            </div>
        @empty
            <p class="col-span-full text-gray-500">No lockers match this status.</p>
        @endforelse
    </div>
</div>
@endsection