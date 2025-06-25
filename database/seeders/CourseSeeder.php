<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        \DB::table('courses')->delete(); // safer than truncate

        Course::insert([
            ['name' => 'Web Tech II', 'code' => 'WEB202', 'department' => 'Computer Science'],
            ['name' => 'Data Structures', 'code' => 'DS103', 'department' => 'Computer Science'],
            ['name' => 'Algorithms', 'code' => 'ALG104', 'department' => 'Computer Science'],
            ['name' => 'Operating Systems', 'code' => 'OS105', 'department' => 'Computer Science'],
        ]);
    }
}
