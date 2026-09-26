@extends('layout.user')

@section('content')

<div class="flex flex-col pt-5 w-full sm:px-6 lg:px-8 space-y-10">

    <div>
        <h6 class="text-2xl sm:text-3xl font-bold">Dashboard</h6>
        <p class="text-base sm:text-lg text-gray-600">Overview of users and locker status</p>
    </div>

    <x-user-dashboard.total-locker-dashboard :lockerInUes="$lockerInUes" :availableLockers="$availableLockers" :availableLocations="$availableLocations"/>

    <x-user-dashboard.locker-password :lockers="$myLockers"/>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-700">My History</h2>
            @if($sessions->isNotEmpty())
                <span class="text-xs text-gray-400">{{ $sessions->count() }} session{{ $sessions->count() === 1 ? '' : 's' }}</span>
            @endif
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-gray-400 text-xs uppercase tracking-wide border-b border-gray-100">
                        <th class="px-5 py-3 font-medium">Locker</th>
                        <th class="px-5 py-3 font-medium">Location</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Start</th>
                        <th class="px-5 py-3 font-medium">Release</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($sessions as $session)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3 font-medium text-gray-800">
                                {{ $session['locker']->locker_title ?? '—' }}
                            </td>
                            <td class="px-5 py-3 text-gray-600 max-w-xs truncate" title="{{ $session['locker']->location->name_location ?? '' }}">
                                {{ $session['locker']->location->name_location ?? '—' }}
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $session['end'] ? 'bg-gray-100 text-gray-600' : 'bg-green-100 text-green-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $session['end'] ? 'bg-gray-400' : 'bg-green-500' }}"></span>
                                    {{ $session['end'] ? 'Released' : 'In use' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-gray-600">
                                {{ $session['start'] ? $session['start']->format('d M Y, H:i') : '—' }}
                            </td>
                            <td class="px-5 py-3 text-gray-600">
                                {{ $session['end'] ? $session['end']->format('d M Y, H:i') : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-gray-400 text-center">
                                No history yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($sessions->isNotEmpty())
            <div class="px-5 py-3 border-t border-gray-100 text-right">
                <a href="{{ route('location-user') }}" class="text-blue-600 text-sm font-medium hover:underline">
                    Find a locker
                </a>
            </div>
        @endif
    </div>

</div>

@endsection