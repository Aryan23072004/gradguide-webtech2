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
            ['name' => 'Darija', 'department' => 'Computer Science'],
            ['name' => 'Roberts', 'department' => 'Information Systems'],
            ['name' => 'Ilze', 'department' => 'Engineering'],
        ]);
    }
}
