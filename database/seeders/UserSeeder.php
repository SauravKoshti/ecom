<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(['email' => $userData['email']], $userData);
        }

        $this->command->info('Users seeded successfully!');
    }
}
