<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\LockerLocation;
use App\Models\Locker;
use App\Models\Maintenance;
use App\Models\User;

class DashboardController extends Controller
{
    public function adminIndex()
{
    $totalUsers = User::count();

    $availableLockers = Locker::where('status', 'available')->count();
    $inUseLockers     = Locker::where('status', 'in_use')->count();

    // Count lockers that are in maintenance status,
    // or that have an active maintenance record
    $maintenanceLockers = Locker::where('status', 'maintenance')
        ->orWhereHas('maintenances', function ($maintenance) {
            $maintenance->where('status', Maintenance::STATUS_MAINTENANCE);
        })
        ->count();

    // Open issues, paginated
    $allLocker = Maintenance::with('locker.location')
        ->where('status', Maintenance::STATUS_MAINTENANCE)
        ->latest()
        ->paginate(10);

    $lockers   = Locker::with(['user', 'location'])->latest()->take(5)->get();
    $locations = LockerLocation::withCount('lockers')->get();

    return view('admin.index', compact(
        'totalUsers',
        'availableLockers',
        'inUseLockers',
        'maintenanceLockers',
        'allLocker',
        'lockers',
        'locations'
    ));
}

    public function userIndex()
    {
        $myLockers = Locker::with('location')->where('user_id', auth()->id())->get();
        $lockerInUes = $myLockers->where('status', 'in_use')->count();

        $availableLockers = Locker::where('status', 'available')->count();
        $availableLocations = LockerLocation::whereHas('lockers', fn ($query) => $query->where('status', 'available'))->count();

        $sessions = $this->buildSessions(History::with('locker', 'locker.location')
            ->where('user_id', auth()->id())
            ->orderBy('created_at')
            ->get());

        return view('user-dashboard.index', compact(
            'myLockers',
            'lockerInUes',
            'availableLockers',
            'availableLocations',
            'sessions',
        ));
    }

    public function userHistory()
    {
        $histories = History::with('locker', 'locker.location')
            ->where('user_id', auth()->id())
            ->orderBy('created_at')
            ->get();

        $sessions = $this->buildSessions($histories);

        return view('user-dashboard.history', compact('sessions'));
    }

    public function destroyHistory(History $history)
    {
        abort_unless($history->user_id === auth()->id(), 403);

        $history->delete();

        return back()->with('success', 'History record deleted.');
    }

    private function buildSessions($histories)
    {
        $sessions = [];

        foreach ($histories as $entry) {
            if ($entry->action === 'use') {
                $sessions[] = [
                    'locker_id' => $entry->locker_id,
                    'locker' => $entry->locker,
                    'use_id' => $entry->id,
                    'release_id' => null,
                    'start' => $entry->created_at,
                    'end' => null,
                ];
            } elseif ($entry->action === 'release') {
                for ($i = count($sessions) - 1; $i >= 0; $i--) {
                    if ($sessions[$i]['locker_id'] === $entry->locker_id && $sessions[$i]['end'] === null) {
                        $sessions[$i]['end'] = $entry->created_at;
                        $sessions[$i]['release_id'] = $entry->id;
                        break;
                    }
                }
            }
        }

        return collect($sessions)->sortByDesc('start')->values();
    }
}