<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\Student;
use App\Model\SalesRegistration;
use App\Model\Registration;
// use App\User;
use App\Model\Register;
use App\Model\Teacher;
use App\Model\Refund;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // Sandy (2020/01/14)
    public function show()
    {
        $events = array();
        $course = array();
        $teachers = array();

        if (isset(Auth::user()->role) == '') {
            return view('frontend.error_authority');
        } elseif (isset(Auth::user()->role) != '' && Auth::user()->role == "teacher") {
            // 講師ID Rocky(2020/05/11)
            $id_teacher = Auth::user()->id_teacher;
            $events = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                ->select('events_course.*', 'course.name as course', 'course.type as type')
                ->where('course.id_teacher', $id_teacher)
                ->orderBy('events_course.course_start_at', 'desc')
                ->get();
        } else {
            $events = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                ->select('events_course.*', 'course.name as course', 'course.type as type')
                ->orderBy('events_course.course_start_at', 'desc')
                ->get();
        }


        //課程、老師快速查詢輸入
        $course = Course::all();
        $teachers = Teacher::all();

        foreach ($events as $key => $data) {
            $type = "";

            //判斷是銷講or正課
            if ($data['type'] == 1) {
                //銷講

                //判斷是否有下一階
                $nextLevel = count(Course::where('id_type', $data['id_course'])
                    ->get());

                //報名筆數
                $count_apply = count(EventsCourse::join('sales_registration', 'sales_registration.id_events', '=', 'events_course.id')
                    ->Where('events_course.id', $data['id'])
                    ->Where('id_status', '<>', 2)
                    ->get());

                //取消筆數
                $count_cancel = count(EventsCourse::join(
                    'sales_registration',
                    'sales_registration.id_events',
                    '=',
                    'events_course.id'
                )
                    ->Where('events_course.id', $data['id'])
                    ->Where('id_status', 5)
                    ->get());

                //報到筆數
                $count_check = count(EventsCourse::join('sales_registration', 'sales_registration.id_events', '=', 'events_course.id')
                    ->Where('events_course.id', $data['id'])
                    ->Where('id_status', 4)
                    ->get());

                $events[$key] = [
                    'date' => date('Y-m-d', strtotime($data['course_start_at'])),
                    'name' => $data['course'],
                    'event' => $data['name'],
                    'count_apply' => $count_apply,
                    'count_cancel' => $count_cancel,
                    'count_check' => $count_check,
                    'href_check' => route('course_check', ["id" => $data['id']]),
                    'href_list' => route('course_apply', ["id" => $data['id']]),
                    'href_adv' => route('course_advanced', ["id" => $data['id']]),
                    'href_return' => route('course_return', ["id" => $data['id']]),
                    'href_form' => route('course_form', ["id" => $data['id']]),
                    'id' => $data['id'],
                    'id_group' => $data['id_group'],
                    'nextLevel' => $nextLevel
                ];
            }elseif( $data['type'] == 2 || $data['type'] == 3){
                //正課

                //判斷是否有下一階
                $nextLevel = count(Course::where('id_type', $data['id_course'])
                    ->get());

                // $count_apply = count(EventsCourse::join($type, $type.'.id_events', '=', 'events_course.id')
                //                                  ->Where('events_course.id', $data['id'])       
                //                                  ->Where('id_status', '<>', 2)   
                //                                  ->get());

                //抓出場次所有報名表
                $register = Register::join('events_course', 'events_course.id', '=', 'register.id_events')
                                    ->Where('events_course.id', $data['id'])
                                    ->get();

                //報名筆數
                // $count_apply = count(Register::join('events_course', 'events_course.id', '=', 'register.id_events')
                //     // ->join('register', 'register.id_registration', '=', 'registration.id')
                //     ->Where('events_course.id', $data['id'])
                //     ->Where('register.id_status', '<>', 2)
                //     ->get());
                $count_apply = 0;
                foreach( $register as $data_register ){
                    //檢查狀態不是我很遺憾
                    if( $data_register['id_status'] == 2){
                        continue;
                    }

                    //檢查是否通過退費
                    $check_refund = Refund::where('id_registration', $data_register['id_registration'])
                                    ->where('review', 1)                
                                    ->first();
                    if( !empty($check_refund) ){
                        continue;
                    }else{
                        $count_apply++;
                    }
                }
                

                //取消筆數
                // $count_cancel = count(Register::join('events_course', 'events_course.id', '=', 'register.id_events')
                //     // ->join('register', 'register.id_registration', '=', 'registration.id')
                //     ->Where('events_course.id', $data['id'])
                //     ->Where('register.id_status', 5)
                //     ->get());
                $count_cancel = 0;
                foreach( $register as $data_register ){
                    //檢查狀態為取消
                    if( $data_register['id_status'] != 5){
                        continue;
                    }

                    //檢查是否通過退費
                    $check_refund = Refund::where('id_registration', $data_register['id_registration'])
                                    ->where('review', 1)                
                                    ->first();
                    if( !empty($check_refund) ){
                        continue;
                    }else{
                        $count_cancel++;
                    }
                }

                //報到筆數
                // $count_check = count(Register::join('events_course', 'events_course.id', '=', 'register.id_events')
                //     // ->join('register', 'register.id_registration', '=', 'registration.id')
                //     ->Where('events_course.id', $data['id'])
                //     ->Where('register.id_status', 4)
                //     ->get());
                $count_check = 0;
                foreach( $register as $data_register ){
                    //檢查狀態為報到
                    if( $data_register['id_status'] != 4){
                        continue;
                    }

                    //檢查是否通過退費
                    $check_refund = Refund::where('id_registration', $data_register['id_registration'])
                                    ->where('review', 1)                
                                    ->first();
                    if( !empty($check_refund) ){
                        continue;
                    }else{
                        $count_check++;
                    }
                }


                $events[$key] = [
                    'date' => date('Y-m-d', strtotime($data['course_start_at'])),
                    'name' => $data['course'],
                    'event' => $data['name'],
                    'count_apply' => $count_apply,
                    'count_cancel' => $count_cancel,
                    'count_check' => $count_check,
                    'href_check' => route('course_check', ["id" => $data['id']]),
                    'href_list' => route('course_apply', ["id" => $data['id']]),
                    'href_adv' => route('course_advanced', ["id" => $data['id']]),
                    'href_return' => route('course_return', ["id" => $data['id']]),
                    'href_form' => route('course_form', ["id" => $data['id']]),
                    'id' => $data['id'],
                    'id_group' => $data['id_group'],
                    'nextLevel' => $nextLevel
                ];
            }
        }

        return view('frontend.course', compact('events', 'course', 'teachers'));
    }
}
