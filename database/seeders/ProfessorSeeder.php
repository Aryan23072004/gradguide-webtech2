<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Professor;

class ProfessorSeeder extends Seeder
{
    public function run(): void
    {
        \DB::table('professors')->delete(); // safer than truncate

        Professor::insert([
            ['name' => 'Dr. Sarah Johnson', 'department' => 'Computer Science'],
            ['name' => 'Prof. Michael Chen', 'department' => 'Computer Science'],
            ['name' => 'Dr. Emily Rodriguez', 'department' => 'Computer Science'],
            ['name' => 'Prof. David Thompson', 'department' => 'Computer Science'],
            ['name' => 'Dr. Lisa Wang', 'department' => 'Computer Science'],
            ['name' => 'Prof. James Wilson', 'department' => 'Information Systems'],
            ['name' => 'Dr. Maria Garcia', 'department' => 'Information Systems'],
            ['name' => 'Prof. Robert Brown', 'department' => 'Information Systems'],
            ['name' => 'Dr. Jennifer Lee', 'department' => 'Information Systems'],
            ['name' => 'Prof. Christopher Davis', 'department' => 'Information Systems'],
            ['name' => 'Dr. Amanda Taylor', 'department' => 'Engineering'],
            ['name' => 'Prof. Daniel Martinez', 'department' => 'Engineering'],
            ['name' => 'Dr. Rachel Green', 'department' => 'Engineering'],
            ['name' => 'Prof. Kevin Anderson', 'department' => 'Engineering'],
            ['name' => 'Dr. Nicole White', 'department' => 'Engineering'],
            ['name' => 'Prof. Steven Clark', 'department' => 'Mathematics'],
            ['name' => 'Dr. Jessica Hall', 'department' => 'Mathematics'],
            ['name' => 'Prof. Andrew Lewis', 'department' => 'Mathematics'],
            ['name' => 'Dr. Samantha Turner', 'department' => 'Physics'],
            ['name' => 'Prof. Matthew Scott', 'department' => 'Physics'],
            ['name' => 'Dr. Ashley King', 'department' => 'Chemistry'],
            ['name' => 'Prof. Ryan Wright', 'department' => 'Chemistry'],
            ['name' => 'Dr. Danielle Lopez', 'department' => 'Biology'],
            ['name' => 'Prof. Brandon Hill', 'department' => 'Biology'],
        ]);
    }
}
