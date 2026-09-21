<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserData extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Test User', 'email' => 'test@example.com', 'role' => 1],
            ['name' => 'Staff Member', 'email' => 'staff@example.com', 'role' => 2],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                ['name' => $user['name'], 'role' => $user['role'], 'password' => '123']
            );
        }
    }
}
