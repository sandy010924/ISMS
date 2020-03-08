<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Student;
use App\Model\Payment;

class CourseReturnController extends Controller
{
    //view
    public function show(Request $request)
    {
         //課程資訊
        $id = $request->get('id');
        $course = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                                ->select('events_course.*', 'course.id as id_course', 'course.name as course')
                                ->Where('events_course.id', $id)
                                ->first();

        $weekarray = array("日","一","二","三","四","五","六");
        $week = $weekarray[date('w', strtotime($course['course_start_at']))]; 

        $next_course = Course::join('users', 'users.id', '=', 'course.id_teacher')
                        ->select('course.id as id_course', 'course.name as course', 'users.name as teacher')
                        ->Where('course.id_type', $course->id_course)
                        ->first();
        //填單名單
        $fill = Registration::join('student', 'student.id', '=', 'registration.id_student')
                            ->join('events_course', 'events_course.id', '=', 'registration.id_events')
                            ->join('payment', 'payment.id', '=', 'registration.id_payment')
                            ->select('student.name as name', 'student.phone as phone','payment.*')
                            ->Where('registration.id_course', $next_course->id_course)
                            ->Where('registration.created_at', 'like', '%'. date('Y-m-d', strtotime($course->course_start_at)). '%' )
                            ->get();

        // dd($fill_all);

        return view('frontend.course_return', compact('course', 'week', 'fill'));    
    }

}
