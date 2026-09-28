<?php

namespace Database\Seeders;

use App\Models\Locker;
use App\Models\Maintenance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaintenanceData extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            ['description' => 'Hinge replaced, door closes properly again.', 'status' => Maintenance::STATUS_AVAILABLE],
            ['description' => 'Lock is sticking, needs a service visit.', 'status' => Maintenance::STATUS_MAINTENANCE],
            ['description' => 'Damaged panel reported by a student.', 'status' => Maintenance::STATUS_MAINTENANCE],
            ['description' => 'Keypad firmware updated and tested.', 'status' => Maintenance::STATUS_IN_USE],
        ];

        $lockers = Locker::orderBy('id')->get();

        foreach ($lockers as $index => $locker) {
            $record = $records[$index % count($records)];

            Maintenance::updateOrCreate(
                [
                    'lockers_id' => $locker->id,
                    'description' => $record['description'],
                ],
                ['status' => $record['status']]
            );
        }
    }
}
