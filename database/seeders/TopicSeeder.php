<?php

namespace Database\Seeders;

use App\Models\Materi;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Topic::create([
            "guid" => "141d420c-d536-411f-b0c5-49bd18a78cc0",
            "name" => "Pendahuluan",
            "description" => "Pengenalan",
            "course_code" => "IN212"
        ]);
    }
}
