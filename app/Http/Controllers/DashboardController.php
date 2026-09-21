<?php

namespace App\Http\Controllers;

use App\Models\LockerLocation;
use App\Models\Locker;
use App\Models\Maintenance;
use App\Models\User;

class DashboardController extends Controller
{
    public function adminDashborad()
    {
        $totalUsers = User::count();

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


}