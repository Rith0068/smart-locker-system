<?php

namespace Database\Seeders;

use App\Models\LockerLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LockerLocationData extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['name_location' => 'PSE-OBK', 'adress' => 'songkat stueg mean chey khan mean chey', 'img' => 'library.jpg'],
            ['name_location' => 'PSE-RUPP', 'adress' => 'songkat toek laak 1 khan tuol kork', 'img' => 'logo.png'],
            ['name_location' => 'PSE-IC', 'adress' => 'songkat stueg thmey khan sensok', 'img' => 'library.jpg'],
        ];

        foreach ($locations as $location) {
            LockerLocation::firstOrCreate(
                ['name_location' => $location['name_location']],
                [
                    'adress' => $location['adress'],
                    'img' => $location['img'],
                ]
            );
        }
    }
}