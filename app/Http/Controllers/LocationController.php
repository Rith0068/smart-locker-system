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

        return view('locker-location.index', compact('locations'));
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
