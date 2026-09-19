<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\LockerLocation;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $locations = LockerLocation::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name_location', 'like', "%{$search}%")
                    ->orWhere('adress', 'like', "%{$search}%");
            })
            ->get();

        return view('locker-location.index', compact('locations'));
    }

    public function viewLocker($id)
    {
        $locker = LockerLocation::findOrFail($id);;
        return view('locker-location.locker', compact('locker'));
    }
}