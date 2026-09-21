<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Locker;
use App\Models\User;
use App\Models\LockerLocation;
use Illuminate\Http\Request;

class LockerController extends Controller
{
    public function manageLocker(Request $request)
    {
        $locations = LockerLocation::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name_location', 'like', "%{$search}%")
                    ->orWhere('adress', 'like', "%{$search}%");
            })
            ->get();

        return view('Locker.index', compact('locations'));
    }

    public function manageLockerCreate()
    {
        $users = User::all();
        $locations = LockerLocation::all();

        return view('Locker.create', compact('users', 'locations'));
    }

    public function manageLockerStore(Request $request)
    {
        $validated = $request->validate([
            'locker_title'  => 'required|string|max:255',
            'user_id'       => 'required|exists:users,id',
            'locations_id'  => 'required|exists:locations,id',
            'start'         => 'required|string|max:255',
            'releave'       => 'required|string|max:255',
        ]);

        Locker::create($validated);

        return redirect()->route('locker.index')
            ->with('success', 'Locker created successfully.');
    }

    public function manageLockerShow($id)
    {
        $locker = Locker::with(['user', 'location'])->findOrFail($id);

        return view('Locker.show', compact('locker'));
    }

    public function manageLockerEdit($id)
    {
        $locker = Locker::findOrFail($id);
        $users = User::all();
        $locations = LockerLocation::all();

        return view('Locker.edit', compact('locker', 'users', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $locker = Locker::findOrFail($id);

        $validated = $request->validate([
            'locker_title'  => 'required|string|max:255',
            'user_id'       => 'required|exists:users,id',
            'locations_id'  => 'required|exists:locations,id',
            'start'         => 'required|string|max:255',
            'releave'       => 'required|string|max:255',
        ]);

        $locker->update($validated);

        return redirect()->route('locker.index')
            ->with('success', 'Locker updated successfully.');
    }

    public function destroy($id)
    {
        $locker = Locker::findOrFail($id);
        $locker->delete();

        return redirect()->route('locker.index')
            ->with('success', 'Locker deleted successfully.');
    }
      public function index(Request $request)
    {
        $locations = LockerLocation::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name_location', 'like', "%{$search}%")
                    ->orWhere('adress', 'like', "%{$search}%");
            })
            ->get();

        return view('location.index', compact('locations'));
    }

    public function viewLocker($id)
    {
        $locker = LockerLocation::findOrFail($id);;
        return view('locker-location.locker', compact('locker'));
    }
}