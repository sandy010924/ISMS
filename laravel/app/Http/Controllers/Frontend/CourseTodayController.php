<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Student;
use App\Model\SalesRegistration;

class CourseTodayController extends Controller
{
    // Sandy (2020/01/14)
    public function show()
    {
        $courses = Course::Where('course.course_start_at', 'like', '%'.date("Y-m-d").'%')    
                         ->get();
        $courses_apply = array();
        $courses_cancel = array();
        $courses_check = array();

        foreach ($courses as $key => $data) {
            $data_apply = count(Course::join('sales_registration', 'sales_registration.id_course', '=', 'course.id')
                        ->Where('course.id', $data['id'])    
                        ->get());

            $data_cancel = count(Course::join('sales_registration', 'sales_registration.id_course', '=', 'course.id')
                        ->Where('course.id', $data['id'])       
                        ->Where('id_status', 5)
                        ->get());

            $data_check = count(Course::join('sales_registration', 'sales_registration.id_course', '=', 'course.id')
                        ->Where('course.id', $data['id'])       
                        ->Where('id_status', 4)
                        ->get());

            array_push($courses_apply, $data_apply);
            array_push($courses_cancel, $data_cancel);
            array_push($courses_check, $data_check);
        }

        return view('frontend.course_today', compact('courses','courses_apply','courses_cancel','courses_check'));
    }

}
