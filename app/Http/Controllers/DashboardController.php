<?php

namespace App\Http\Controllers;

use App\Models\Locker;
use App\Models\LockerLocation;
use App\Models\Maintenance;
use App\Models\User;

class DashboardController extends Controller
{
    public function adminIndex()
    {
        $totalUsers = User::count();

        $availableLockers = Locker::where('status', 'available')->count();
        $inUseLockers = Locker::where('status', 'in_use')->count();
        $maintenanceLockers = Maintenance::where('status', Maintenance::STATUS_MAINTENANCE)->count('lockers_id');

        $allLocker = Maintenance::with('locker.location')->latest()->get();

        $lockers = Locker::with(['user', 'location'])->latest()->take(5)->get();
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
        return view('user-dashboard.index');
    }
}