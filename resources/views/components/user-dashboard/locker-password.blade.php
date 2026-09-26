<div class="rounded-xl space-y-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Current Locker</h2>

    @forelse($lockers as $locker)
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between gap-4">
            <div class="space-y-3">
                <h3 class="text-xl font-extrabold text-gray-900">{{ $locker->locker_title }}</h3>
                <p class="text-gray-600 text-sm">{{ $locker->location->name_location ?? 'Your current locker and recent activity.' }}</p>

                <div class="inline-flex items-center gap-2 bg-green-50 rounded-full pl-3 pr-1 py-1">
                    <span class="text-xs font-medium text-gray-500 uppercase">Key</span>
                    <span class="text-lg font-bold text-gray-900">{{ $locker->password ?? '—' }}</span>
                    @if($locker->password)
                        <button
                            type="button"
                            onclick="navigator.clipboard.writeText('{{ $locker->password }}')"
                            class="bg-green-300 hover:bg-green-400 text-gray-800 text-xs font-semibold px-3 py-1 rounded-full transition"
                        >
                            Copy
                        </button>
                    @endif
                </div>
            </div>

            <form action="{{ route('release-locker', $locker->id) }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="bg-green-100 hover:bg-green-200 text-gray-800 font-medium px-5 py-2.5 rounded-lg transition"
                >
                    Release Locker
                </button>
            </form>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-xl font-extrabold text-gray-900">No locker yet</h3>
                <p class="text-gray-600 text-sm mt-1">You don't have any lockers assigned right now.</p>
            </div>
            <form method="get" action="{{ route('location-user') }}">
                <button 
                type="submit"
                class="inline-block bg-green-100 font-bold hover:bg-green-200 text-gray-800 font-medium px-5 py-2.5 rounded-lg transition text-center">
                Find locker
                </button>
            </form>
        </div>
    @endforelse
</div>
