<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'System Admin',
                'email' => 'admin@cristalgrade.test',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Faculty 1',
                'email' => 'fac1@test.com',
                'password' => Hash::make('password123'),
                'role' => 'faculty',
            ],
            [
                'name' => 'Faculty 2',
                'email' => 'fac2@test.com',
                'password' => Hash::make('password123'),
                'role' => 'faculty',
            ],
            [
                'name' => 'Student 1',
                'email' => 'stu1@test.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Student 2',
                'email' => 'stu2@test.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Andrew Gyundre',
                'email' => 'gyundre.andrew@test.com',
                'password' => Hash::make('password123'),
                'role' => 'faculty',
            ],
            [
                'name' => 'Jessica Fistroson',
                'email' => 'fistroson.jessica@test.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Henry Clifer',
                'email' => 'clifer.henry@test.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Selena Rankus',
                'email' => 'rankus.selena@test.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Ben Nishimura',
                'email' => 'nishimura.ben@test.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Sarah Friseber',
                'email' => 'friseber.sarah@test.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
        ];

        foreach ($users as $data) {
            User::firstOrCreate(
                ['email' => $data['email']], // check by unique column
                $data // attributes to fill if not found
            );
        }
    }
}
