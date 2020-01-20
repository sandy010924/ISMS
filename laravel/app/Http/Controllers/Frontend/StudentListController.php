<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Student;

class StudentListController extends Controller
{
    public function show()
    {
        $students = Student::paginate();
        return view('frontend.student_list', compact('students'));
    }
}
