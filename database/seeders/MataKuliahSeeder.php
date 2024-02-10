<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MataKuliah::create([
            "kode" => "IN212",
            "nama" => "Kecerdasan Mesin",
            "deskripsi" => "Belajar Anaconda",
            "kelas" => "A"
        ]);
    }
}
