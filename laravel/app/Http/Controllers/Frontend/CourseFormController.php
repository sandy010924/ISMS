<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Student;
use App\Model\Teacher;
use App\Model\SalesRegistration;

class CourseFormController extends Controller
{
    // Sandy (2020/02/28)
    // public function show()
    // {
    //     $courses = Course::orderBy('course_start_at', 'desc')
    //                      ->get();

    //     $teachers = Teacher::all();

    //     foreach ($courses as $key => $data) {
    //         $count_apply = count(Course::join('sales_registration', 'sales_registration.id_course', '=', 'course.id')
    //                     ->Where('course.id', $data['id'])       
    //                     ->Where('id_status', '<>', 2)   
    //                     ->get());

    //         $count_cancel = count(Course::join('sales_registration', 'sales_registration.id_course', '=', 'course.id')
    //                     ->Where('course.id', $data['id'])       
    //                     ->Where('id_status', 5)
    //                     ->get());

    //         $count_check = count(Course::join('sales_registration', 'sales_registration.id_course', '=', 'course.id')
    //                     ->Where('course.id', $data['id'])       
    //                     ->Where('id_status', 4)
    //                     ->get());
            
    //         $courses[$key] = [
    //             'date' => date('Y-m-d', strtotime($data['course_start_at'])),
    //             'name' => $data['name'],
    //             'event' => $data['Events'],
    //             'count_apply' => $count_apply,
    //             'count_cancel' =>$count_cancel,
    //             'count_check' =>$count_check,
    //             'href_check' => route('course_check',["id"=> $data['id'] ]),
    //             'href_list' => route('course_apply',["id"=> $data['id'] ]),
    //             'href_adv' => route('course_advanced',["id"=> $data['id'] ]),
    //             'href_return' => route('course_return',["id"=> $data['id'] ]),
    //             'href_form' => route('course_form',["id"=> $data['id'] ]),
    //             'course_id' => $data['id']
    //         ];
    //     }
        
    //     return view('frontend.course', compact('courses','teachers'));
    // }

}
