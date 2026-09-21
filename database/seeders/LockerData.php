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
        $user = User::where('email', 'test@example.com')->firstOrFail();
        $locations = LockerLocation::all();

        foreach ($locations as $location) {
            $existing = Locker::where('locations_id', $location->id)->count();

            for ($i = $existing + 1; $i <= $existing + 5; $i++) {
                Locker::firstOrCreate(
                    ['locker_title' => "Pending Locker {$i}"],
                    [
                        'user_id' => $user->id,
                        'locations_id' => $location->id,
                        'start' => '08:00',
                        'releave' => '17:00',
                    ]
                );
            }
        }
    }
}