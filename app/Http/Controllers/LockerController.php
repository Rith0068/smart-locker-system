<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Locker;
use App\Models\User;
use App\Models\LockerLocation;
use Illuminate\Http\Request;

class LockerController extends Controller
{
    public function index(Request $request)
    {
        $lockers = Locker::query()
        ->with(['user', 'location'])
        ->when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('locker_title', 'like', "%{$search}%")
                    ->orWhereHas('location', function ($q2) use ($search) {
                        $q2->where('name_location', 'like', "%{$search}%");
                    });
            });
        })
        ->when($request->status, function ($query, $status) {
            $query->where('status', $status);
        })
        ->get();

    return view('Locker.index', compact('lockers'));
    }

    public function create()
    {
        $users = User::all();
        $locations = LockerLocation::all();

        return view('Locker.create', compact('users', 'locations'));
    }

    public function store(Request $request)
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

    public function show($id)
    {
        $locker = Locker::with(['user', 'location'])->findOrFail($id);

        return view('Locker.show', compact('locker'));
    }

    public function edit($id)
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
}