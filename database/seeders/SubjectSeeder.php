<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        // Delete related records first
        DB::table('subject_user')->delete();
        Subject::query()->delete();

        // Insert new subjects
        Subject::insert([
            ['name' => 'Mathematics', 'code' => 'MATH101'],
            ['name' => 'Computer Science', 'code' => 'CS101'],
            ['name' => 'Physics', 'code' => 'PHY101'],
            ['name' => 'Web Tech II', 'code' => 'WEB202'],
            ['name' => 'Data Structures', 'code' => 'DS103'],
        ]);
    }
}
