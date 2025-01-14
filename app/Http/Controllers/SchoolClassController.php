<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClassRequest;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Auth;

class SchoolClassController extends Controller
{
    public function createClass(CreateClassRequest $request)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $class = SchoolClass::create($request->validated());

            return response()->json([
                'message' => 'Class created successfully',
                'class' => $class,
            ]);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }

    public function getAllClasses()
    {
        $classes = SchoolClass::all();

        return response()->json($classes);
    }
}
