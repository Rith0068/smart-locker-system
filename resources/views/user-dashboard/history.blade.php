@extends('layout.user')

@section('content')

<div class="flex flex-col pt-5 w-full sm:px-6 lg:px-8 space-y-6">

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div>
        <h6 class="text-2xl sm:text-3xl font-bold">History</h6>
        <p class="text-base sm:text-lg text-gray-600">Your locker activity</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-700">Locker history</h2>
            @if($histories->isNotEmpty())
                <span class="text-xs text-gray-400">{{ $histories->count() }} record{{ $histories->count() === 1 ? '' : 's' }}</span>
            @endif
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-gray-400 text-xs uppercase tracking-wide border-b border-gray-100">
                        <th class="px-5 py-3 font-medium">Action</th>
                        <th class="px-5 py-3 font-medium">Locker</th>
                        <th class="px-5 py-3 font-medium">Location</th>
                        <th class="px-5 py-3 font-medium">Date</th>
                        <th class="px-5 py-3 font-medium text-right">Delete</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($histories as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $item->action === 'use' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $item->action === 'use' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ ucfirst($item->action) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 font-medium text-gray-800">
                                {{ $item->locker->locker_title ?? '—' }}
                            </td>
                            <td class="px-5 py-3 text-gray-600 max-w-xs truncate">
                                {{ $item->locker->location->name_location ?? '—' }}
                            </td>
                            <td class="px-5 py-3 text-gray-600">
                                {{ $item->created_at }}
                            </td>
                            <td class="px-5 py-3 text-right">
                                <form action="{{ route('user.history.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('Delete this history record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-gray-400 text-center">
                                No activity yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection