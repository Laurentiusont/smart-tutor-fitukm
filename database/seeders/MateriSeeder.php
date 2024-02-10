<?php

namespace Database\Seeders;

use App\Models\Materi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Materi::create([
            "guid" => "141d420c-d536-411f-b0c5-49bd18a78cc0",
            "nama" => "Pendahuluan",
            "deskripsi" => "Pengenalan",
            "mata_kuliah_kode" => "IN212"
        ]);
    }
}
