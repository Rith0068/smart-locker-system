@extends('layout.staff')

@section('content')

<div class="p-6 w-full space-y-6 pt-15">

    {{-- Page header --}}
    <div>
        <h1 class="text-[30px] font-bold text-gray-800">Dashboard</h1>
        <p class="text-sm text-gray-500">Overview of users and locker status</p>
    </div>

    {{-- Stats cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
                    <p class="text-gray-500 text-sm mt-1">Total users</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 640 640" fill="currentColor"><path d="M463 448.2C440.9 409.8 399.4 384 352 384L288 384C240.6 384 199.1 409.8 177 448.2C212.2 487.4 263.2 512 320 512C376.8 512 427.8 487.3 463 448.2zM64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320zM320 336C359.8 336 392 303.8 392 264C392 224.2 359.8 192 320 192C280.2 192 248 224.2 248 264C248 303.8 280.2 336 320 336z"/></svg>
                </div>
            </div>
        </div>

        {{-- Available = green --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold text-green-600">{{ $availableLockers }}</p>
                    <p class="text-gray-500 text-sm mt-1 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        Available lockers
                    </p>
                </div>
                <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 640 640" fill="currentColor"><path d="M256 160L256 224L384 224L384 160C384 124.7 355.3 96 320 96C284.7 96 256 124.7 256 160zM192 224L192 160C192 89.3 249.3 32 320 32C390.7 32 448 89.3 448 160L448 224C483.3 224 512 252.7 512 288L512 512C512 547.3 483.3 576 448 576L192 576C156.7 576 128 547.3 128 512L128 288C128 252.7 156.7 224 192 224z"/></svg>
                </div>
            </div>
        </div>

        {{-- In use = blue --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold text-blue-600">{{ $inUseLockers }}</p>
                    <p class="text-gray-500 text-sm mt-1 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        In use lockers
                    </p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 640 640" fill="currentColor"><path d="M256 160C256 124.7 284.7 96 320 96C351.7 96 378 119 383.1 149.3C386 166.7 402.5 178.5 420 175.6C437.5 172.7 449.2 156.2 446.3 138.7C436.1 78.1 383.5 32 320 32C249.3 32 192 89.3 192 160L192 224C156.7 224 128 252.7 128 288L128 512C128 547.3 156.7 576 192 576L448 576C483.3 576 512 547.3 512 512L512 288C512 252.7 483.3 224 448 224L256 224L256 160z"/></svg>
                </div>
            </div>
        </div>

        {{-- Maintenance = red --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold text-red-600">{{ $maintenanceLockers }}</p>
                    <p class="text-gray-500 text-sm mt-1 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                        In maintenance
                    </p>
                </div>
                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 640 640" fill="currentColor"><path d="M102.8 57.3C108.2 51.9 116.6 51.1 123 55.3L241.9 134.5C250.8 140.4 256.1 150.4 256.1 161.1L256.1 210.7L346.9 301.5C380.2 286.5 420.8 292.6 448.1 320L574.2 446.1C592.9 464.8 592.9 495.2 574.2 514L514.1 574.1C495.4 592.8 465 592.8 446.2 574.1L320.1 448C292.7 420.6 286.6 380.1 301.6 346.8L210.8 256L161.2 256C150.5 256 140.5 250.7 134.6 241.8L55.4 122.9C51.2 116.6 52 108.1 57.4 102.7L102.8 57.3zM247.8 360.8C241.5 397.7 250.1 436.7 274 468L179.1 563C151 591.1 105.4 591.1 77.3 563C49.2 534.9 49.2 489.3 77.3 461.2L212.7 325.7L247.9 360.8zM416.1 64C436.2 64 455.5 67.7 473.2 74.5C483.2 78.3 485 91 477.5 98.6L420.8 155.3C417.8 158.3 416.1 162.4 416.1 166.6L416.1 208C416.1 216.8 423.3 224 432.1 224L473.5 224C477.7 224 481.8 222.3 484.8 219.3L541.5 162.6C549.1 155.1 561.8 156.9 565.6 166.9C572.4 184.6 576.1 203.9 576.1 224C576.1 267.2 558.9 306.3 531.1 335.1L482 286C448.9 253 403.5 240.3 360.9 247.6L304.1 190.8L304.1 161.1L303.9 156.1C303.1 143.7 299.5 131.8 293.4 121.2C322.8 86.2 366.8 64 416.1 63.9z"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Lockers + Locations tables side by side --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Recent Lockers table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-700">Recent Lockers</h2>
                <a href="{{ route('locker.index') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-gray-400 text-xs uppercase tracking-wide border-b border-gray-100">
                            <th class="px-5 py-3 font-medium">Title</th>
                            <th class="px-5 py-3 font-medium">User</th>
                            <th class="px-5 py-3 font-medium">Location</th>
                            <th class="px-5 py-3 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($lockers as $locker)
                            @php
                                $statusClass = $locker->status === 'available'
                                    ? 'bg-green-100 text-green-700'
                                    : ($locker->status === 'in_use'
                                        ? 'bg-blue-100 text-blue-700'
                                        : 'bg-red-100 text-red-700');
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 font-medium text-gray-800">{{ $locker->locker_title }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ $locker->user->name ?? '—' }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ $locker->location->name_location ?? '—' }}</td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        {{ ucfirst(str_replace('_', ' ', $locker->status)) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-gray-400 text-center">
                                    No lockers found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Locations table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-700">Locations</h2>
                <span class="text-xs text-gray-400">{{ $locations->count() }} total</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-gray-400 text-xs uppercase tracking-wide border-b border-gray-100">
                            <th class="px-5 py-3 font-medium">Name</th>
                            <th class="px-5 py-3 font-medium text-right">Lockers</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($locations as $location)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 font-medium text-gray-800">{{ $location->name_location }}</td>
                                <td class="px-5 py-3 text-gray-600 text-right">{{ $location->lockers_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-5 py-10 text-gray-400 text-center">
                                    No locations found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Open maintenance issues --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-700">Open Maintenance Issues</h2>
            @if($allLocker->isNotEmpty())
                <span class="text-xs text-gray-400">{{ $allLocker->count() }} record{{ $allLocker->count() === 1 ? '' : 's' }}</span>
            @endif
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-gray-400 text-xs uppercase tracking-wide border-b border-gray-100">
                        <th class="px-5 py-3 font-medium">Locker</th>
                        <th class="px-5 py-3 font-medium">Location</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($allLocker as $item)
                        @php
                            $statusColors = [
                                \App\Models\Maintenance::STATUS_AVAILABLE   => 'bg-green-100 text-green-700',
                                \App\Models\Maintenance::STATUS_IN_USE      => 'bg-blue-100 text-blue-700',
                                \App\Models\Maintenance::STATUS_MAINTENANCE => 'bg-red-100 text-red-700',
                            ];
                            $statusClass = $statusColors[$item->status] ?? 'bg-red-100 text-red-700';
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3 font-medium text-gray-800">
                                {{ $item->locker->locker_title ?? '—' }}
                            </td>
                            <td class="px-5 py-3 text-gray-600 max-w-xs truncate" title="{{ $item->locker->location->name_location ?? '' }}">
                                {{ $item->locker->location->name_location ?? '—' }}
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ $item->statusLabel() }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-10 text-gray-400 text-center">
                                No open maintenance issues
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($allLocker->isNotEmpty())
            <div class="px-5 py-3 border-t border-gray-100 text-right">
                <a href="{{ route('maintenance.index') }}" class="text-blue-600  p-2 text-sm font-medium hover:text-blue-900">
                    View all maintenance records
                </a>
            </div>
        @endif
    </div>

</div>

@endsection