<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'guid' => "4eab4f52-e377-4032-8ff3-bd8d58fe5aa0",
            "role_name" => "asisten"
        ]);
        Role::create([
            'guid' => "120014de-1d48-4947-b801-afe701bb19b8",
            "role_name" => "admin"
        ]);
        Role::create([
            'guid' => "c6a51300-8153-4f31-933c-dc7cd0fb7d6f",
            "role_name" => "dosen"
        ]);
        Role::create([
            'guid' => "dc6c6789-122f-40be-9751-f5be0a051b0e",
            "role_name" => "mahasiswa"
        ]);
    }
}
