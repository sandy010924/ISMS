<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Student;
use App\Model\SalesRegistration;

class CourseController extends Controller
{
    // Sandy (2020/01/14)
    public function show()
    {
        $courses = Course::all();
        $courses_apply = array();
        $courses_cancel = array();

        foreach ($courses as $key => $data) {
            $data_apply = count(Course::join('sales_registration', 'sales_registration.id_course', '=', 'course.id')
                        ->Where('course.id', $data['id'])    
                        ->get());

            $data_cancel = count(Course::join('sales_registration', 'sales_registration.id_course', '=', 'course.id')
                        ->Where('course.id', $data['id'])       
                        ->Where('id_status', 5)
                        ->get());

            array_push($courses_apply, $data_apply);
            array_push($courses_cancel, $data_cancel);
        }

        return view('frontend.course', compact('courses','courses_apply','courses_cancel'));
    }

}
