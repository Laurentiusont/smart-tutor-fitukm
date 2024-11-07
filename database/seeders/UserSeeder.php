<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Cari role lecturer dan student
        $lecturerRole = Role::where('name', 'lecturer')->first();
        $studentRole = Role::where('name', 'student')->first();

        // Buat user lecturer
        User::create([
            'name' => 'Lecturer User',
            'email' => 'lecturer@example.com',
            'password' => Hash::make('password'), // Ganti dengan password yang lebih kuat
            'role_id' => $lecturerRole->id,
        ]);

        // Buat user student
        User::create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => Hash::make('password'), // Ganti dengan password yang lebih kuat
            'role_id' => $studentRole->id,
        ]);
    }
}
