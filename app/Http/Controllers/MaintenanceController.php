<?php

namespace App\Http\Controllers;

use App\Models\Locker;
use App\Models\LockerLocation;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('locker.location')
            ->where('status', Maintenance::STATUS_MAINTENANCE)
            ->latest('updated_at')
            ->paginate(10);

        return view('maintenance.index', compact('maintenances'));
    }

    public function create()
    {
        $lockers = Locker::with('location')->get();
        $locations = LockerLocation::all();

        return view('maintenance.create', compact('lockers', 'locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'lockers_id'  => 'required|exists:lockers,id',
            'status'      => 'required|in:1,2,3',
        ]);

        DB::transaction(function () use ($validated) {
            Maintenance::create($validated);

            Locker::whereKey($validated['lockers_id'])
                ->update(['status' => Locker::STATUS_IN_MAINTENANCE]);
        });

        return redirect()->route('maintenance.index')
            ->with('status', 'Maintenance record added.');
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'status'      => 'required|in:1,2,3',
        ]);

        $maintenance->update($validated);

        return back()->with('status', 'Maintenance record updated.');
    }

    public function destroy(Maintenance $maintenance)
    {
        DB::transaction(function () use ($maintenance) {
            $locker = $maintenance->locker;

            $maintenance->delete();

            if ($locker && ! $locker->maintenances()->exists()) {
                $locker->update([
                    'status' => $locker->user_id
                        ? Locker::STATUS_IN_USE
                        : Locker::STATUS_AVAILABLE,
                ]);
            }
        });

        return back()->with('status', 'Maintenance record deleted.');
    }
}