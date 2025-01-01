<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;

class BalanceController extends Controller
{
    public function getAllBalances()
    {
        $balances = Student::with('class.terms')->get()->map(function ($student) {
            return $student->class->terms->map(function ($term) use ($student) {
                $totalPaid = Payment::where('student_id', $student->id)
                    ->where('term_id', $term->id)
                    ->sum('amount');
                $balanceDue = max(0, $term->fee_amount - $totalPaid);

                return [
                    'student_name' => $student->name,
                    'term_name' => $term->name,
                    'total_due' => $term->fee_amount,
                    'total_paid' => $totalPaid,
                    'balance_due' => $balanceDue,
                ];
            });
        })->flatten(1);

        return response()->json($balances);
    }

    /**
     * Get balances for a specific student.
     */
    public function getStudentBalances($student_id)
    {
        $student = Student::findOrFail($student_id);

        $balances = $student->class->terms->map(function ($term) use ($student) {
            $totalPaid = Payment::where('student_id', $student->id)
                ->where('term_id', $term->id)
                ->sum('amount');
            $balanceDue = max(0, $term->fee_amount - $totalPaid);

            return [
                'term_name' => $term->name,
                'total_due' => $term->fee_amount,
                'total_paid' => $totalPaid,
                'balance_due' => $balanceDue,
            ];
        });

        return response()->json($balances);
    }
}
