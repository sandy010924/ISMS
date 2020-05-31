<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\Student;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Register;
use Illuminate\Support\Facades\Auth;

class CourseTodayController extends Controller
{
    // View Sandy (2020/01/14)
    public function show()
    {
        $events = array();
        $count_apply = array();
        $count_cancel = array();
        $count_check = array();

        // 講師ID Rocky(2020/05/11)
        $id_teacher = Auth::user()->id_teacher;

        if (isset(Auth::user()->role) == '') {
            return view('frontend.error_authority');
        } elseif (isset(Auth::user()->role) != '' && Auth::user()->role == "teacher") {
            $events = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                ->select('events_course.*', 'course.name as course', 'course.type as type')
                ->Where('course_start_at', 'like', '%' . date("Y-m-d") . '%')
                ->where('course.id_teacher', $id_teacher)
                ->get();
        } else {
            $events = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                ->select('events_course.*', 'course.name as course', 'course.type as type')
                ->Where('course_start_at', 'like', '%' . date("Y-m-d") . '%')
                ->get();
        }


        foreach ($events as $key => $data) {
            $type = "";

            //判斷是銷講or正課
            if ($data['type'] == 1) {
                $type = "sales_registration";
            } else {
                $type = "register";
            }

            $data_apply = count(EventsCourse::join($type, $type . '.id_events', '=', 'events_course.id')
                ->Where('events_course.id', $data['id'])
                ->Where('id_status', '<>', 2)
                ->get());

            $data_cancel = count(EventsCourse::join($type, $type . '.id_events', '=', 'events_course.id')
                ->Where('events_course.id', $data['id'])
                ->Where('id_status', 5)
                ->get());

            $data_check = count(EventsCourse::join($type, $type . '.id_events', '=', 'events_course.id')
                ->Where('events_course.id', $data['id'])
                ->Where('id_status', 4)
                ->get());

            array_push($count_apply, $data_apply);
            array_push($count_cancel, $data_cancel);
            array_push($count_check, $data_check);
        }

        return view('frontend.course_today', compact('events', 'count_apply', 'count_cancel', 'count_check'));
    }
}
