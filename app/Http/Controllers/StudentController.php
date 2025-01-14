<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddStudentRequest;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function addStudent(AddStudentRequest $request)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $student = Student::create($request->validated());

            return response()->json([
                'message' => 'Student added to class successfully',
                'student' => $student,
            ]);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }

    public function getAllStudents()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $students = Student::with('class', 'parent')->get();

            return response()->json($students->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'class_name' => $student->class->name,
                    'parent_name' => $student->parent->name,
                ];
            }));
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }

    public function getStudentsByClass($class_id)
    {
        $user = Auth::user();
        if ($user->hasRole('admin') || $user->hasRole('parent')) {
            $students = Student::with('class', 'parent')->where('class_id', $class_id)->get();

            return response()->json($students->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'class_name' => $student->class->name,
                    'parent_name' => $student->parent->name,
                ];
            }));
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }
}
