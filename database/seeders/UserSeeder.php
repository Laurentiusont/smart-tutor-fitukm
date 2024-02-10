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
            'id' => '2172028',
            'username' => 'ontpy',
            'name' => 'Laurentius Gusti Ontoseno Panata Yudha',
            'email' => '2172028@maranatha.ac.id',
            'password' => Hash::make('asd123'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
