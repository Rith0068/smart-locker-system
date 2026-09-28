<?php

namespace Database\Seeders;

use App\Models\Locker;
use App\Models\LockerLocation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LockerData extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = User::where('role', 1)->orderBy('id')->first();

        $sizes = ['Small', 'Medium', 'Large'];

        $descriptions = [
            'Ground floor, next to the entrance.',
            'Second floor, beside the stairwell.',
            'Near the main reading area.',
            'Corner unit, best for large bags.',
            'Under the staircase.',
            'Top row, close to the ventilation.',
        ];

        foreach (LockerLocation::all() as $location) {
            for ($i = 1; $i <= 6; $i++) {
                $status = match (true) {
                    $i === 3 => Locker::STATUS_IN_USE,
                    $i === 5 => Locker::STATUS_IN_MAINTENANCE,
                    default => Locker::STATUS_AVAILABLE,
                };

                Locker::updateOrCreate(
                    [
                        'locations_id' => $location->id,
                        'locker_title' => "Locker {$i}",
                    ],
                    [
                        'size' => $sizes[($i - 1) % count($sizes)],
                        'description' => $descriptions[$i - 1],
                        'start' => '08:00',
                        'releave' => '17:00',
                        'status' => $status,
                        // An in-use locker must have an owner and a passcode, the
                        // same pair the useLocker action writes.
                        'user_id' => $status === Locker::STATUS_IN_USE ? $owner?->id : null,
                        'password' => $status === Locker::STATUS_IN_USE
                            ? strtoupper(substr(md5("{$location->id}-{$i}"), 0, 6))
                            : null,
                    ]
                );
            }
        }
    }
}
