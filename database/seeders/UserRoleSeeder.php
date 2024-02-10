<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserRole::create([
            'users_id' => '2172028',
            'role_guid' => "120014de-1d48-4947-b801-afe701bb19b8",
        ]);
    }
}
