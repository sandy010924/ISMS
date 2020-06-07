<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Student;
use App\Model\Teacher;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\EventsCourse;
use Illuminate\Support\Facades\Auth;
// use App\User;
use App\Model\Register;

class CourseListController extends Controller
{
    //View
    public function show()
    {
        $course = array();
        $teachers = array();

        if (isset(Auth::user()->role) == '') {
            return view('frontend.error_authority');
        } elseif (isset(Auth::user()->role) != '' &&  Auth::user()->role == "teacher") {
            // 講師ID Rocky(2020/05/11)
            $id_teacher = Auth::user()->id_teacher;
            $course_table = Course::join('teacher', 'teacher.id', '=', 'course.id_teacher')
                ->select('course.id as id_course', 'course.name as course', 'course.type as type', 'teacher.id as id_teacher', 'teacher.name as teacher')
                ->where('course.id_teacher', $id_teacher)
                ->orderBy('id_teacher', 'desc')
                ->distinct()
                ->get();
        } else {
            $course_table = Course::join('teacher', 'teacher.id', '=', 'course.id_teacher')
                ->select('course.id as id_course', 'course.name as course', 'course.type as type', 'teacher.id as id_teacher', 'teacher.name as teacher')
                ->orderBy('id_teacher', 'desc')
                ->distinct()
                ->get();
        }



        $teachers = Teacher::all();


        foreach ($course_table as $key => $data) {
            //表單上場次
            $count_form = count(EventsCourse::Where('unpublish', 0)
                // ->Where('course_start_at', '>=', date('Y-m-d H:i:s')) 
                ->Where('id_course', $data['id_course'])
                ->select('id_group')
                ->distinct()
                ->get());


            //總場次
            $count_events = count(EventsCourse::Where('id_course', $data['id_course'])
                ->select('id_group')
                ->distinct()
                ->get());

            //判斷是銷講or正課
            if ($data['type'] == 1) {
                //銷講
                //累計名單            
                $count_list = count(SalesRegistration::join('events_course', 'events_course.id', '=', 'sales_registration.id_events')
                    ->Where('sales_registration.id_course', $data['id_course'])
                    // ->Where('sales_registration.id_status','<>', 2)
                    ->groupby('events_course.id_group', 'sales_registration.id_student')
                    ->get());
            } else {
                //正課
                //累計名單            
                // $count_list = count(Registration::join('events_course', 'events_course.id', '=', 'registration.id_events')
                //                                 ->Where('registration.id_course', $data['id_course'])
                //                                 // ->Where('registration.id_status','<>', 2)
                //                                 ->groupby('events_course.id_group', 'registration.id_student')
                //                                 ->get());
                $count_list = count(Registration::Where('id_course', $data['id_course'])
                    // ->Where('registration.id_status','<>', 2)
                    ->groupby('id_group', 'id_student')
                    ->get());
            }


            // $all_events = EventsCourse::select('id')
            //                           ->Where('id_course', $data['id_course'])
            //                           ->get();
            // $count_list = 0;

            // foreach ($all_courses as $key_course => $data_course) {
            //     $count = count(SalesRegistration::Where('id_course', $data_course['id'])
            //                                     ->Where('id_status','<>', 2)            
            //                                     ->get());
            //     $count_list += $count;
            // }


            switch ($data['type']) {
                case 1:
                    //銷講
                    $type = '銷講';
                    break;
                case 2:
                    //二階課程
                    $type = '二階課程';
                    break;
                case 3:
                    //三階課程A
                    $type = '三階課程';
                    break;
                case 4:
                    //三階課程B
                    $type = '活動';
                    break;
                default:
                    return 'error';
                    break;
            }

            $course[$key] = [
                'teacher' => $data['teacher'],
                'type' => $type,
                'course' => $data['course'],
                'count_form' => $count_form,
                'count_events' => $count_events,
                'count_list' => $count_list,
                'href_apply' => route('course_list_apply', ["id" => $data['id_course']]),
                'href_refund' => route('course_list_refund', ["id" => $data['id_course']]),
                'href_data' => route('course_list_data', ["id" => $data['id_course']]),
                'id' => $data['id_course']
            ];
        }

        return view('frontend.course_list', compact('course', 'teachers'));
    }
}
