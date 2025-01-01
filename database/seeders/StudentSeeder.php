<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $students = [
            ['name' => 'Alice', 'class_id' => SchoolClass::inRandomOrder()->first()->id, 'parent_id' => User::inRandomOrder()->first()->id],
            ['name' => 'Bob', 'class_id' => SchoolClass::inRandomOrder()->first()->id, 'parent_id' => User::inRandomOrder()->first()->id],
            ['name' => 'Charlie', 'class_id' => SchoolClass::inRandomOrder()->first()->id, 'parent_id' => User::inRandomOrder()->first()->id],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
