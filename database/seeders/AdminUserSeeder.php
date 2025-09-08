<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@cristalgrade.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Faculty 1',
            'email' => 'fac1@test.com',
            'password' => Hash::make('password123'),
            'role' => 'faculty',
        ]);
        User::create([
            'name' => 'Faculty 2',
            'email' => 'fac2@test.com',
            'password' => Hash::make('password123'),
            'role' => 'faculty',
        ]);
        User::create([
            'name' => 'Student 1',
            'email' => 'stu1@test.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);
        User::create([
            'name' => 'Student2',
            'email' => 'stu2@test.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);
    }
}
