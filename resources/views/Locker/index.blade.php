@extends('layout.staff')

@section('content')
<div class="w-full px-6 py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Lockers</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $lockers->count() }} locker{{ $lockers->count() === 1 ? '' : 's' }} total</p>
        </div>
        <a href="{{ route('locker.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-sm transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add Locker
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="mb-8">
        <div class="relative w-full md:w-96">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or location..."
                   class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2.5 text-sm bg-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none">
        </div>
    </form>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-gray-400 text-xs uppercase tracking-wide border-b border-gray-100">
                        <th class="px-5 py-3 font-medium">Title</th>
                        <th class="px-5 py-3 font-medium">User</th>
                        <th class="px-5 py-3 font-medium">Location</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($lockers as $locker)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $locker->locker_title }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $locker->user->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $locker->location->name_location ?? '—' }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $locker->status === 'available' ? 'bg-green-100 text-green-700' : ($locker->status === 'in_use' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700') }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ ucfirst(str_replace('_', ' ', $locker->status)) }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex justify-end items-center gap-4">
                                    <a href="{{ route('locker.show', $locker->id) }}"
                                       class="text-sm font-medium text-blue-600 hover:text-blue-700">View</a>
                                    <a href="{{ route('locker.edit', $locker->id) }}"
                                       class="text-sm font-medium text-yellow-600 hover:text-yellow-700">Edit</a>
                                    <form action="{{ route('locker.destroy', $locker->id) }}" method="POST"
                                          onsubmit="return confirm('Delete this locker?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-gray-400 text-center">
                                No lockers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection