<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Student;

class StudentController extends Controller
{
    public function show()
    {
        $students = Student::paginate();
        return view('frontend.student', compact('students'));
    }
}