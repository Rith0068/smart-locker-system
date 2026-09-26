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
        $totalUsers = User::all()->count();

        $availableLockers = Locker::where(['status' => 'available'])->count();
        $inUseLockers = Locker::where(['status' => 'in_use'])->count();
        $maintenanceLockers = Locker::where(['status' => 'in_maintenance'])->count();

        $allLocker = Locker::all();
        return view('admin.index', compact(
            'totalUsers',
            'availableLockers',
            'inUseLockers',
            'maintenanceLockers',
            'allLocker'
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
            ->latest()
            ->get();

        $sessionCount = $this->buildSessions($histories->sortBy('created_at'))->count();

        return view('user-dashboard.history', compact('histories', 'sessionCount'));
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
                    'start' => $entry->created_at,
                    'end' => null,
                ];
            } elseif ($entry->action === 'release') {
                for ($i = count($sessions) - 1; $i >= 0; $i--) {
                    if ($sessions[$i]['locker_id'] === $entry->locker_id && $sessions[$i]['end'] === null) {
                        $sessions[$i]['end'] = $entry->created_at;
                        break;
                    }
                }
            }
        }

        return collect($sessions)->sortByDesc('start')->values();
    }


}