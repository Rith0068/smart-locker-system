<?php

namespace Database\Seeders;

use App\Models\Locker;
use App\Models\LockerLocation;
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
        $locations = LockerLocation::all();

        foreach ($locations as $location) {
            for ($i = 1; $i <= 6; $i++) {
                Locker::firstOrCreate(
                    [
                        'locations_id' => $location->id,
                        'locker_title' => "Locker {$i}",
                    ],
                    [
                        'start' => '08:00',
                        'releave' => '17:00',
                        'status' => $i % 3 === 0 ? 'in_use' : 'available',
                    ]
                );
            }
        }
    }
}
