<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\Payment;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MakePaymentRequest;

class PaymentController extends Controller
{
    public function makePayment(MakePaymentRequest $request)
    {
     
        $student = Student::findOrFail($request->student_id);
        $term = Term::findOrFail($request->term_id);

        // Calculate the new balance
        $totalPaid = Payment::where('term_id', $term->id)->sum('amount') + $request->amount;
        $balanceDue = max(0, $term->fee_amount - $totalPaid);

        $payment = Payment::create([
            'student_id' => $student->id,
            'term_id' => $term->id,
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_date' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Payment recorded successfully',
            'payment' => [
                'id' => $payment->id,
                'student_id' => $student->id,
                'term_id' => $term->id,
                'amount' => $payment->amount,
                'balance_due' => $balanceDue,
            ],
        ], 201);
    }

    /**
     * Get payment history for a specific student.
     */
    public function getPaymentHistory($student_id)
    {
        $student = Student::findOrFail($student_id);

        $payments = Payment::where('student_id', $student->id)
            ->join('terms', 'payments.term_id', '=', 'terms.id')
            ->select('payments.id', 'terms.name as term_name', 'payments.amount', 'payments.created_at as payment_date')
            ->get();

        return response()->json($payments);
    }
}
