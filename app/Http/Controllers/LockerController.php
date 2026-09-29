<?php

namespace App\Http\Controllers;

use App\Models\Locker;
use App\Models\LockerLocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LockerController extends Controller
{
    public function index(Request $request)
    {
        $allowedStatuses = [
            Locker::STATUS_AVAILABLE,
            Locker::STATUS_IN_USE,
            Locker::STATUS_IN_MAINTENANCE,
        ];

        $lockers = Locker::query()
            ->with(['user', 'location', 'maintenances'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->search);

                $query->where(function ($q) use ($search) {
                    $q->where('locker_title', 'like', "%{$search}%")
                        ->orWhereHas('location', function ($q2) use ($search) {
                            $q2->where('name_location', 'like', "%{$search}%");
                        });
                });
            })
            // Only filter by status when the value is one of the known statuses
            ->when(
                $request->filled('status') && in_array($request->status, $allowedStatuses),
                fn ($query) => $query->where('status', $request->status)
            )
            ->when($request->filled('location'), function ($query) use ($request) {
                $query->where('locations_id', $request->location);
            })
            ->latest()
            ->get();

        $locations = LockerLocation::orderBy('name_location')->get();

        return view('Locker.index', compact('lockers', 'locations'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get(['id', 'name']);
        $locations = LockerLocation::orderBy('name_location')->get();

        return view('Locker.create', compact('users', 'locations'));
    }

    public function store(Request $request)
    {
        Locker::create($this->validatedData($request));

        return redirect()->route('locker.index')
            ->with('success', 'Locker created successfully.');
    }

    public function show($id)
    {
        $locker = Locker::with(['user', 'location', 'maintenances'])->findOrFail($id);

        return view('Locker.show', compact('locker'));
    }

    public function edit($id)
    {
        $locker = Locker::findOrFail($id);
        $users = User::orderBy('name')->get(['id', 'name']);
        $locations = LockerLocation::orderBy('name_location')->get();

        return view('Locker.edit', compact('locker', 'users', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $locker = Locker::findOrFail($id);

        $locker->update($this->validatedData($request));

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

    /**
     * Shared validation for store() and update().
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'locker_title' => ['required', 'string', 'max:255'],
            'size'         => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:1000'],
            'user_id'      => ['nullable', 'exists:users,id'],
            'locations_id' => ['required', Rule::exists((new LockerLocation)->getTable(), 'id')],
            'start'        => ['nullable', 'string', 'max:255'],
            'releave'      => ['nullable', 'string', 'max:255'],
        ]);
    }
}