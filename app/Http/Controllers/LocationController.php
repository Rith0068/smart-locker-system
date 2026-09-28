<?php

namespace App\Http\Controllers;

use App\Models\Locker;
use App\Models\LockerLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(Request $request): View
    {
        $locations = LockerLocation::search($request->search)->get();

        return view('location.index', compact('locations'));
    }

    public function create(): View
    {
        return view('location.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name_location' => 'required|string|max:255',
            'adress' => 'required|string|max:255',
            'img' => 'nullable|image|max:2048',
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
            'adress' => 'required|string|max:255',
            'img' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('img')) {
            // delete old image before saving the new one
            if ($location->img) {
                Storage::disk('public')->delete($location->img);
            }
            $validated['img'] = $request->file('img')->store('locations', 'public');
        }

        $location->update($validated);

        return redirect()->route('location.index')
            ->with('success', 'Location updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $location = LockerLocation::findOrFail($id);

        // delete the image file along with the record
        if ($location->img) {
            Storage::disk('public')->delete($location->img);
        }

        $location->delete();

        return redirect()->route('location.index')
            ->with('success', 'Location deleted successfully.');
    }

    public function viewLocation(Request $request): View
    {
        $locations = LockerLocation::search($request->search)->get();

        return view('locker-location.index', compact('locations'));
    }

    public function viewLocker(int $id): View
    {
        $locker = LockerLocation::with('lockers')->findOrFail($id);

        return view('locker-location.locker', compact('locker'));
    }

    public function lockers(Request $request): View
    {
        $status = $request->query('status');
        $statuses = Locker::statuses();

        $lockers = Locker::with('location')
            ->when(in_array($status, $statuses, true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('locations_id')
            ->orderBy('locker_title')
            ->get();

        return view('locker-location.lockers', compact('lockers', 'status', 'statuses'));
    }

    public function useLocker(int $id): RedirectResponse
    {
        $locker = Locker::findOrFail($id);

        abort_unless($locker->isAvailable(), 403, 'This locker is not available.');

        $alreadyUsed = Locker::where('locations_id', $locker->locations_id)
            ->where('user_id', auth()->id())
            ->where('status', Locker::STATUS_IN_USE)
            ->exists();

        abort_if($alreadyUsed, 403, 'You can only use one locker at this location.');

        $locker->update([
            'user_id' => auth()->id(),
            'status' => Locker::STATUS_IN_USE,
            'password' => strtoupper(Str::random(6)),
        ]);

        return back()->with('success', 'You are now using '.$locker->locker_title.'.');
    }

    public function releaseLocker(int $id): RedirectResponse
    {
        $locker = Locker::findOrFail($id);

        abort_if($locker->user_id !== auth()->id(), 403, 'This locker is not yours to release.');

        $locker->update([
            'user_id' => null,
            'status' => Locker::STATUS_AVAILABLE,
            'password' => null,
        ]);

        return back()->with('success', $locker->locker_title.' is now available.');
    }

    public function show(int $id): View
    {
        $location = LockerLocation::findOrFail($id);

        return view('location.show', compact('location'));
    }
}
