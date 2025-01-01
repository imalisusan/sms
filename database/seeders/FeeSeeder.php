<?php

namespace Database\Seeders;

use App\Models\Fee;
use App\Models\SchoolClass;
use App\Models\Term;
use Illuminate\Database\Seeder;

class FeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $fees = [
            ['class_id' => SchoolClass::inRandomOrder()->first()->id, 'term_id' => Term::inRandomOrder()->first()->id, 'amount' => 15000],
            ['class_id' => SchoolClass::inRandomOrder()->first()->id, 'term_id' => Term::inRandomOrder()->first()->id, 'amount' => 16000],
            ['class_id' => SchoolClass::inRandomOrder()->first()->id, 'term_id' => Term::inRandomOrder()->first()->id, 'amount' => 17000],
            ['class_id' => SchoolClass::inRandomOrder()->first()->id, 'term_id' => Term::inRandomOrder()->first()->id, 'amount' => 20000],
        ];

        foreach ($fees as $fee) {
            Fee::create($fee);
        }
    }
}
