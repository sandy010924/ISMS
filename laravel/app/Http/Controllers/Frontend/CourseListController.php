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
use App\Model\Refund;
use Illuminate\Support\Facades\Auth;
// use App\User;
use App\Model\Register;
use App\Model\Activity;

class CourseListController extends Controller
{
    //View
    public function show()
    {
        $course = array();
        $course_list = array();
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


        //課程、老師快速查詢輸入
        $course_list = Course::all();
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
           
                // $count_list = count(SalesRegistration::join('events_course', 'events_course.id', '=', 'sales_registration.id_events')
                //     ->Where('sales_registration.id_course', $data['id_course'])
                //     // ->Where('sales_registration.id_status','<>', 2)
                //     ->groupby('events_course.id_group', 'sales_registration.id_student')
                //     ->get());
                
                //累計名單 
                $count_list = count(SalesRegistration::join('student', 'student.id', '=', 'sales_registration.id_student')
                                                    ->join('events_course', 'events_course.id', '=', 'sales_registration.id_events')
                                                    ->select('student.id')
                                                    ->Where('sales_registration.id_course', $data['id_course'])
                                                    ->Where('student.check_blacklist', 0 )
                                                    ->distinct()
                                                    ->get());

            } else if($data['type'] == 2 || $data['type'] == 3) {
                //正課
                       
                // $count_list = count(Registration::join('events_course', 'events_course.id', '=', 'registration.id_events')
                //                                 ->Where('registration.id_course', $data['id_course'])
                //                                 // ->Where('registration.id_status','<>', 2)
                //                                 ->groupby('events_course.id_group', 'registration.id_student')
                //                                 ->get());

                //累計名單     
                $count_list = count(Registration::join('student', 'student.id', '=', 'registration.id_student')
                                            ->join('events_course', 'events_course.id_group', '=', 'registration.id_group')
                                            ->select('student.id')   
                                            ->Where('registration.id_course', $data['id_course'])
                                            ->where(function($q) { 
                                                $q ->orWhere('registration.status_payment', 7)
                                                    ->orWhere('registration.status_payment', 9);
                                            })
                                            ->Where('student.check_blacklist', 0 )
                                            ->whereNotExists(function($query){
                                                $query->from('refund')
                                                    ->whereRaw('registration.id = refund.id_registration')
                                                    ->where('refund.review' , 1);
                                            })
                                            ->distinct()
                                            ->get());

                // $count_list = count(Registration::Where('id_course', $data['id_course'])
                //     // ->Where('id_status','<>', 2)
                //     // ->groupby('id_group', 'id_student')
                //     ->get());
            }else if ($data['type'] == 4) {
                //活動
                
                //累計名單 
                $count_list = count(Activity::join('student', 'student.id', '=', 'activity.id_student')
                                            ->join('events_course', 'events_course.id', '=', 'activity.id_events')
                                            ->select('student.id')   
                                            ->Where('activity.id_course', $data['id_course'])
                                            ->Where('student.check_blacklist', 0 )
                                            ->distinct()
                                            ->get());

            } 

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
                    //三階課程
                    $type = '三階課程';
                    break;
                case 4:
                    //活動
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

        return view('frontend.course_list', compact('course', 'course_list', 'teachers'));
    }
}
