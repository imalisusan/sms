<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddStudentRequest;
use App\Models\Student;

class StudentController extends Controller
{
    public function addStudent(AddStudentRequest $request)
    {
        $student = Student::create($request->validated());

        return response()->json([
            'message' => 'Student added to class successfully',
            'student' => $student,
        ]);
    }

    public function getAllStudents()
    {
        $students = Student::with('class', 'parent')->get();

        return response()->json($students->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'class_name' => $student->class->name,
                'parent_name' => $student->parent->name,
            ];
        }));
    }

    public function getStudentsByClass($class_id)
    {
        $students = Student::with('class', 'parent')->where('class_id', $class_id)->get();

        return response()->json($students->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'class_name' => $student->class->name,
                'parent_name' => $student->parent->name,
            ];
        }));
    }
}
