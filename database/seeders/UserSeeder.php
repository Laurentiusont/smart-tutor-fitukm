<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            'id' => '2172028',
            'username' => 'ontpy',
            'name' => 'Laurentius Gusti Ontoseno Panata Yudha',
            'role_guid' => '2c2ce088-92f3-4ffa-b81d-9a1dd17a9076',
            'email' => '2172028@maranatha.ac.id',
            'password' => Hash::make('asd123'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
