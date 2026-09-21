<?php

namespace App\Http\Controllers\Admin;

use App\Models\Locker;
use App\Models\Maintenance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('locker')->latest()->paginate(10);

        return view('maintenance.index', compact('maintenances'));
    }

    public function create()
    {
        $lockers = Locker::all();

        return view('maintenance.create', compact('lockers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'lockers_id' => 'required|exists:lockers,id',
            'status' => 'required|in:1,2,3',
        ]);

        Maintenance::create($validated);

        return redirect()->route('maintenance.index')->with('status', 'Maintenance record added.');
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'status' => 'required|in:1,2,3',
        ]);

        $maintenance->update($validated);

        return back()->with('status', 'Maintenance record updated.');
    }

    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();

        return back()->with('status', 'Maintenance record deleted.');
    }
}