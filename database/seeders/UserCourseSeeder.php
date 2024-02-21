<?php

namespace Database\Seeders;

use App\Models\UserCourse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserCourse::create([
            "guid" => "d4cb653d-cff6-11ee-ad2a-509a4cce9dc0",
            "course_code" => "IN212",
            "user_id" => "2172028",
        ]);
    }
}
