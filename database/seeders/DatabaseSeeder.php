<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            UserData::class,
            LockerLocationData::class,
            LockerData::class,
            MaintenanceData::class,
            HistoryData::class,
        ]);
    }
}
