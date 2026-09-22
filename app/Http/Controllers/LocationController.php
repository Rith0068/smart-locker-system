<?php

namespace App\Http\Controllers;

use App\Models\Locker;
use App\Models\LockerLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(Request $request): View
    {
        $locations = LockerLocation::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name_location', 'like', "%{$search}%")
                    ->orWhere('adress', 'like', "%{$search}%");
            })
            ->get();

        $view = $request->routeIs('location.index') ? 'location.index' : 'locker-location.index';

        return view($view, compact('locations'));
    }

    public function create(): View
    {
        return view('location.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name_location' => 'required|string|max:255',
            'adress'        => 'required|string|max:255',
            'img'           => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('locations', 'public');
        }

        LockerLocation::create($validated);

        return redirect()->route('location.index')
            ->with('success', 'Location created successfully.');
    }

    public function edit(int $id): View
    {
        $location = LockerLocation::findOrFail($id);

        return view('location.edit', compact('location'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $location = LockerLocation::findOrFail($id);

        $validated = $request->validate([
            'name_location' => 'required|string|max:255',
            'adress'        => 'required|string|max:255',
            'img'           => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('locations', 'public');
        }

        $location->update($validated);

        return redirect()->route('location.index')
            ->with('success', 'Location updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $location = LockerLocation::findOrFail($id);
        $location->delete();

        return redirect()->route('location.index')
            ->with('success', 'Location deleted successfully.');
    }

    public function viewLocker(int $id): View
    {
        $locker = LockerLocation::with('lockers')->findOrFail($id);

        return view('locker-location.locker', compact('locker'));
    }

    public function useLocker(int $id): RedirectResponse
    {
        $locker = Locker::findOrFail($id);

        abort_unless($locker->status === 'available', 403, 'This locker is already in use.');

        $alreadyUsed = Locker::where('locations_id', $locker->locations_id)
            ->where('user_id', auth()->id())
            ->where('status', 'in_use')
            ->exists();

        abort_if($alreadyUsed, 403, 'You can only use one locker at this location.');

        $locker->update([
            'user_id' => auth()->id(),
            'status' => 'in_use',
        ]);

        return back()->with('success', 'You are now using '.$locker->locker_title.'.');
    }

    public function releaseLocker(int $id): RedirectResponse
    {
        $locker = Locker::findOrFail($id);

        abort_if($locker->user_id !== auth()->id(), 403, 'This locker is not yours to release.');

        $locker->update([
            'user_id' => null,
            'status' => 'available',
        ]);

        return back()->with('success', $locker->locker_title.' is now available.');
    }
}