<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\Student;

class CourseTodayController extends Controller
{
    // View Sandy (2020/01/14)
    public function show()
    {
        $courses = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                                ->select('events_course.*', 'course.name as course')
                                ->Where('course_start_at', 'like', '%'.date("Y-m-d").'%')    
                                ->get();

        $courses_apply = array();
        $courses_cancel = array();
        $courses_check = array();

        foreach ($courses as $key => $data) {
            $data_apply = count(EventsCourse::join('sales_registration', 'sales_registration.id_events', '=', 'events_course.id')
                        ->Where('events_course.id', $data['id'])      
                        ->Where('id_status', '<>', 2)    
                        ->get());

            $data_cancel = count(EventsCourse::join('sales_registration', 'sales_registration.id_events', '=', 'events_course.id')
                        ->Where('events_course.id', $data['id'])            
                        ->Where('id_status', 5)
                        ->get());

            $data_check = count(EventsCourse::join('sales_registration', 'sales_registration.id_events', '=', 'events_course.id')
                        ->Where('events_course.id', $data['id'])          
                        ->Where('id_status', 4)
                        ->get());

            array_push($courses_apply, $data_apply);
            array_push($courses_cancel, $data_cancel);
            array_push($courses_check, $data_check);
        }

        return view('frontend.course_today', compact('courses','courses_apply','courses_cancel','courses_check'));
    }
}
