<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Student;

class StudentListController extends Controller
{
    public function show()
    {
        $students = Student::paginate();
        return view('frontend.student_list', compact('students'));
    }
}
