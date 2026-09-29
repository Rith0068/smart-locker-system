@extends('layout.staff')

@section('content')
<div class="p-6 w-full space-y-6 pt-15">

    {{-- Page header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-[30px] font-bold text-gray-800">Maintenance Records</h1>
            <p class="text-sm text-gray-500">All lockers currently under maintenance</p>
        </div>
        <a href="{{ route('maintenance.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 448 512" fill="currentColor">
                <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
            </svg>
            Add Maintenance
        </a>
    </div>

    {{-- Status message --}}
    @if(session('status'))
        <div class="flex items-center gap-2 p-3.5 bg-green-50 text-green-800 border border-green-100 rounded-lg text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" viewBox="0 0 512 512" fill="currentColor">
                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
            </svg>
            {{ session('status') }}
        </div>
    @endif

    {{-- Table card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm min-w-[860px]">
                <thead>
                    <tr class="text-gray-400 text-xs uppercase tracking-wide border-b border-gray-100 bg-gray-50/50">
                        <th class="px-5 py-3.5 font-medium">Locker</th>
                        <th class="px-5 py-3.5 font-medium">Location</th>
                        <th class="px-5 py-3.5 font-medium">Size</th>
                        <th class="px-5 py-3.5 font-medium">Description</th>
                        <th class="px-5 py-3.5 font-medium">Status</th>
                        <th class="px-5 py-3.5 font-medium">Updated</th>
                        <th class="px-5 py-3.5 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($maintenances as $maintenance)
                        <tr class="hover:bg-gray-50/70 transition-colors">
                            <td class="px-5 py-4 font-medium text-gray-800 whitespace-nowrap">
                                {{ $maintenance->locker->locker_title ?? '—' }}
                            </td>
                            <td class="px-5 py-4 text-gray-600 whitespace-nowrap">
                                {{ $maintenance->locker->location->name_location ?? '—' }}
                            </td>
                            <td class="px-5 py-4 text-gray-600 whitespace-nowrap">
                                {{ $maintenance->locker->size ?? '—' }}
                            </td>
                            <td class="px-5 py-4 text-gray-600 max-w-xs truncate" title="{{ $maintenance->description }}">
                                {{ $maintenance->description }}
                            </td>
                            <td class="px-5 py-4">
                                <span @class([
                                    'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium',
                                    'bg-green-100 text-green-700' => $maintenance->status == 1,
                                    'bg-red-100 text-red-700' => $maintenance->status == 2,
                                    'bg-blue-100 text-blue-700' => $maintenance->status == 3,
                                ])>
                                    <span @class([
                                        'w-1.5 h-1.5 rounded-full',
                                        'bg-green-500' => $maintenance->status == 1,
                                        'bg-red-500' => $maintenance->status == 2,
                                        'bg-blue-500' => $maintenance->status == 3,
                                    ])></span>
                                    {{ $maintenance->statusLabel() }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-gray-500 whitespace-nowrap">
                                {{ $maintenance->updated_at->format('M d · h:i A') }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    <form action="{{ route('maintenance.destroy', $maintenance) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this maintenance record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 text-red-500 hover:text-red-700 text-sm font-medium transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 448 512" fill="currentColor">
                                                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64s14.3 32 32 32H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16">
                                <div class="flex flex-col items-center justify-center text-center gap-2">
                                    <p class="text-gray-400 text-sm">No maintenance records yet</p>
                                    <a href="{{ route('maintenance.create') }}" class="text-blue-600 text-sm font-medium hover:underline">
                                        Add your first record
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if ($maintenances->hasPages())
        <div class="flex justify-center">
            {{ $maintenances->links() }}
        </div>
    @endif

</div>
@endsection