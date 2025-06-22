<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subject;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create an admin
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gradguide.com',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        // Create a student
        $student = User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@gradguide.com',
            'role' => 'student',
            'password' => bcrypt('student123'),
        ]);

        // Create a mentor
        $mentor = User::factory()->create([
            'name' => 'Mentor User',
            'email' => 'mentor@gradguide.com',
            'role' => 'mentor',
            'password' => bcrypt('mentor123'),
        ]);

        // Seed subjects, courses, and professors
        $this->call([
            SubjectSeeder::class,
            CourseSeeder::class,
            ProfessorSeeder::class,
        ]);

        // Attach all subjects to student and mentor
        $subjects = Subject::all();
        $student->subjects()->attach($subjects->pluck('id'));
        $mentor->subjects()->attach($subjects->pluck('id'));
    }
}
