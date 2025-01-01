<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClassRequest;
use App\Models\SchoolClass;

class SchoolClassController extends Controller
{
    public function createClass(CreateClassRequest $request)
    {
        $class = SchoolClass::create($request->validated());

        return response()->json([
            'message' => 'Class created successfully',
            'class' => $class,
        ]);
    }

    public function getAllClasses()
    {
        $classes = SchoolClass::all();

        return response()->json($classes);
    }
}
