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
            ['name_location' => 'PSE-OBK', 'adress' => 'songkat stueg mean chey khan mean chey'],
            ['name_location' => 'PSE-RUPP', 'adress' => 'songkat toek laak 1 khan tuol kork'],
            ['name_location' => 'PSE-IC', 'adress' => 'songkat stueg thmey khan sensok'],
        ];

        foreach ($locations as $location) {
            LockerLocation::updateOrCreate(
                ['name_location' => $location['name_location']],
                [
                    'adress' => $location['adress'],
                    // Left null on purpose: the column stores a path on the
                    // "public" disk (locations/xxx.jpg), and the views fall back
                    // to public/images/camera.png when there is no upload.
                    'img' => null,
                ]
            );
        }
    }
}
