<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Term;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $terms = [
            ['name' => 'Term 1', 'start_date' => '2025-01-01', 'end_date' => '2025-01-01', 'class_id' => SchoolClass::inRandomOrder()->first()->id],
            ['name' => 'Term 2', 'start_date' => '2025-04-01', 'end_date' => '2025-01-01', 'class_id' => SchoolClass::inRandomOrder()->first()->id],
            ['name' => 'Term 3', 'start_date' => '2025-07-01', 'end_date' => '2025-01-01', 'class_id' => SchoolClass::inRandomOrder()->first()->id],
        ];

        foreach ($terms as $term) {
            Term::create($term);
        }
    }
}
