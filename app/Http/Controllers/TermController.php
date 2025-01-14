<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTermRequest;
use App\Models\Term;
use Illuminate\Support\Facades\Auth;

class TermController extends Controller
{
    public function addTermToClass(AddTermRequest $request, $class_id)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $term = Term::create([
                'class_id' => $class_id,
                'name' => $request->validated()['name'],
                'fee_amount' => $request->validated()['fee_amount'],
                'start_date' => $request->validated()['start_date'],
                'end_date' => $request->validated()['end_date'],
            ]);

            return response()->json([
                'message' => 'Term added to class successfully',
                'term' => $term,
            ]);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }

    public function getTermsForClass($class_id)
    {
        $terms = Term::where('class_id', $class_id)->get();

        return response()->json($terms);
    }
}
