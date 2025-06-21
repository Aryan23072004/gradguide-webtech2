<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        Subject::create([
            'name' => 'Mathematics',
            'code' => 'MATH101',
        ]);

        Subject::create([
            'name' => 'Computer Science',
            'code' => 'CS102',
        ]);

        Subject::create([
            'name' => 'Physics',
            'code' => 'PHY103',
        ]);
    }
}
