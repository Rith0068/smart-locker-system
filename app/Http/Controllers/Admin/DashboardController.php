<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Locker;
use App\Models\Maintenance;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();

        $availableLockers = Locker::whereHas('currentMaintenance', function ($q) {
            $q->where('status', Maintenance::STATUS_AVAILABLE);
        })->count();

        $inUseLockers = Locker::whereHas('currentMaintenance', function ($q) {
            $q->where('status', Maintenance::STATUS_IN_USE);
        })->count();

        $maintenanceLockers = Locker::whereHas('currentMaintenance', function ($q) {
            $q->where('status', Maintenance::STATUS_MAINTENANCE);
        })->count();

        $maintenanceIssues = Maintenance::with('locker')
            ->where('status', Maintenance::STATUS_MAINTENANCE)
            ->latest('updated_at')
            ->take(10)
            ->get();

        return view('admin.index', compact(
            'totalUsers',
            'availableLockers',
            'inUseLockers',
            'maintenanceLockers',
            'maintenanceIssues'
        ));
    }


}