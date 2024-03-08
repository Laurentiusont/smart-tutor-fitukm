<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => '2172000',
            'username' => 'adm',
            'name' => 'Admin',
            'email' => '2172000@maranatha.ac.id',
            'password' => Hash::make('asd123'),
            'role_guid' => "120014de-1d48-4947-b801-afe701bb19b8",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::create([
            'id' => '2172100',
            'username' => 'lect',
            'name' => 'Lecturer',
            'email' => '2172100@maranatha.ac.id',
            'password' => Hash::make('asd123'),
            'role_guid' => "c6a51300-8153-4f31-933c-dc7cd0fb7d6f",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::create([
            'id' => '2172028',
            'username' => 'ontpy',
            'name' => 'Laurentius Gusti Ontoseno Panata Yudha',
            'email' => '2172028@maranatha.ac.id',
            'password' => Hash::make('asd123'),
            'role_guid' => "dc6c6789-122f-40be-9751-f5be0a051b0e",
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
