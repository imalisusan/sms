<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Student;
use App\Models\Term;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $payments = [
            ['student_id' => Student::inRandomOrder()->first()->id, 'term_id' => Term::inRandomOrder()->first()->id, 'amount' => 15000, 'payment_date' => now(), 'user_id' => User::inRandomOrder()->first()->id],
            ['student_id' => Student::inRandomOrder()->first()->id, 'term_id' => Term::inRandomOrder()->first()->id, 'amount' => 10000, 'payment_date' => now(), 'user_id' => User::inRandomOrder()->first()->id],
            ['student_id' => Student::inRandomOrder()->first()->id, 'term_id' => Term::inRandomOrder()->first()->id, 'amount' => 20000, 'payment_date' => now(), 'user_id' => User::inRandomOrder()->first()->id],
        ];

        foreach ($payments as $payment) {
            Payment::create($payment);
        }
    }
}
