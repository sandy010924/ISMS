<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Course;
use App\Model\EventsCourse;
// use App\Uer;
use App\Model\Register;
use App\Model\Teacher;
use App\Model\Refund;
use App\Model\Activity;

class CourseApplyController extends Controller
{
    public function show(Request $request)
    {
        //課程資訊
        $id = $request->get('id');
        $course = EventsCourse::rightjoin('course', 'course.id', '=', 'events_course.id_course')
                            ->join('teacher', 'teacher.id', '=', 'course.id_teacher')
                            ->select('course.name as course', 'course.type as type', 'teacher.name as teacher', 'events_course.*')
                            ->Where('events_course.id', $id)
                            ->first();
        
        $weekarray = array("日","一","二","三","四","五","六");
        $week = $weekarray[date('w', strtotime($course->course_start_at))];

        if($course->type == 1){
            //銷講
            // $type = "sales_registration";
            
            if(strtotime(date('Y-m-d', strtotime($course->course_start_at))) > strtotime(date("Y-m-d"))){
                //未過場次 狀態預設改為已報名
                SalesRegistration::Where('id_events', $id)
                                ->where(function($q) { 
                                    $q->orWhere('id_status', 3);
                                    // ->orWhere('id_status', 4);
                                })
                                ->update(['id_status' => 1]);
            }else{
                //已過場次 狀態預設已報到改為未到
                SalesRegistration::Where('id_events', $id)
                                ->Where('id_status', 1)
                                ->update(['id_status' => 3]);
            }

            //報名資訊
            $courseapplys = SalesRegistration::join('isms_status', 'isms_status.id', 'sales_registration.id_status')
                                            ->join('student', 'student.id', 'sales_registration.id_student')
                                            ->select('student.name as name', 
                                                    'student.phone as phone', 
                                                    'student.email as email', 
                                                    'student.profession as profession', 
                                                    'sales_registration.*', 
                                                    'isms_status.name as status_name')
                                            ->Where('sales_registration.id_events', $id)
                                            ->Where('sales_registration.id_status', '<>', 2)
                                            ->Where('student.check_blacklist', 0 ) 
                                            ->get();
                                            
            //報名筆數
            $count_apply = count($courseapplys);

            //報名筆數
            $count_check = count(SalesRegistration::join('student', 'student.id', 'sales_registration.id_student')
                                                ->Where('sales_registration.id_events', $id)
                                                ->Where('sales_registration.id_status', 4)
                                                ->Where('student.check_blacklist', 0 ) 
                                                ->get());

            //取消筆數
            $count_cancel = count(SalesRegistration::join('student', 'student.id', 'sales_registration.id_student')
                                                ->Where('sales_registration.id_events', $id)
                                                ->Where('sales_registration.id_status', 5)
                                                ->Where('student.check_blacklist', 0 ) 
                                                ->get());

        }else if($course->type == 2 || $course->type == 3){
            //正課

            if(strtotime(date('Y-m-d', strtotime($course->course_start_at))) > strtotime(date("Y-m-d"))){
                //未過場次 狀態預設改為已報名
                Register::Where('id_events', $id)
                        ->where(function($q) { 
                            $q->orWhere('id_status', 3);
                            // ->orWhere('id_status', 4);
                        })
                        ->update(['id_status' => 1]);
            }else{
                //已過場次 狀態預設已報到改為未到
                Register::Where('id_events', $id)
                        ->Where('id_status', 1)
                        ->update(['id_status' => 3]);
            }
            // $type = "registration";

                                
            //報名資訊
            $list = Register::leftjoin('isms_status', 'isms_status.id', 'register.id_status')
                            ->leftjoin('student', 'student.id', 'register.id_student')
                            ->leftjoin('registration', 'registration.id', '=', 'register.id_registration')
                            ->select('student.name as name', 
                                    'student.phone as phone', 
                                    'student.email as email', 
                                    'student.profession as profession', 
                                    'register.*', 
                                    'isms_status.name as status_name',
                                    'registration.submissiondate as submissiondate',
                                    'registration.id as id_registration')
                            ->Where('register.id_events', $id)
                            ->Where('register.id_status', '<>', 2)
                            ->where(function($q) { 
                                $q->orWhere('registration.status_payment', 7)
                                ->orWhere('registration.status_payment', 9);
                            })
                            ->Where('student.check_blacklist', 0 )
                            ->get();
                            
            $courseapplys = array();

            foreach ($list as $key => $data) {
                //檢查是否通過退費
                $check_refund = array();
                $check_refund = Refund::where('id_registration', $data['id_registration'])
                                      ->where('review', 1)
                                      ->first();
                if( !empty($check_refund) ){
                    continue;
                }

                $courseapplys[count($courseapplys)] = [
                    'id' => $data['id'],
                    'submissiondate' => $data['submissiondate'],
                    'datasource' => $data['datasource'],
                    // 'created_at' => $data['created_at'],
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'profession' => $data['profession'],
                    'course_content' => $data['course_content'],
                    'id_status' => $data['id_status'],
                    'status_name' => $data['status_name']
                ];
            }
            
                                    
            //報名筆數
            $count_apply = count($courseapplys);

            //報到筆數
            // $count_check = count(Register::Where('id_events', $id)
            //                              ->Where('id_status', 4)
            //                              ->get());
            $count_check = 0;
            foreach( $courseapplys as $data ){
                //檢查狀態為報到
                if( $data['id_status'] != 4){
                    continue;
                }else{
                    $count_check++;
                }
            }

            //取消筆數
            // $count_cancel = count(Register::Where('id_events', $id)
            //                               ->Where('id_status', 5)
            //                               ->get());
            $count_cancel = 0;
            foreach( $courseapplys as $data ){
                //檢查狀態為報到
                if( $data['id_status'] != 5){
                    continue;
                }else{
                    $count_cancel++;
                }
            }
        }else if($course->type == 4){
            //活動
            
            if(strtotime(date('Y-m-d', strtotime($course->course_start_at))) > strtotime(date("Y-m-d"))){
                //未過場次 狀態預設改為已報名
                Activity::Where('id_events', $id)
                                ->where(function($q) { 
                                    $q->orWhere('id_status', 3);
                                    // ->orWhere('id_status', 4);
                                })
                                ->update(['id_status' => 1]);
            }else{
                //已過場次 狀態預設已報到改為未到
                Activity::Where('id_events', $id)
                                ->Where('id_status', 1)
                                ->update(['id_status' => 3]);
            }

            //報名資訊
            $courseapplys = Activity::join('isms_status', 'isms_status.id', 'activity.id_status')
                                            ->join('student', 'student.id', 'activity.id_student')
                                            ->select('student.name as name', 
                                                    'student.phone as phone', 
                                                    'student.email as email', 
                                                    'student.profession as profession', 
                                                    'activity.*', 
                                                    'isms_status.name as status_name')
                                            ->Where('activity.id_events', $id)
                                            ->Where('activity.id_status', '<>', 2)
                                            ->Where('student.check_blacklist', 0 )
                                            ->get();
                                            
            //報名筆數
            $count_apply = count($courseapplys);

            //報名筆數
            $count_check = count(Activity::join('student', 'student.id', 'activity.id_student')
                                            ->Where('activity.id_events', $id)
                                            ->Where('activity.id_status', 4)
                                            ->Where('student.check_blacklist', 0 )
                                            ->get());

            //取消筆數
            $count_cancel = count(Activity::join('student', 'student.id', 'activity.id_student')
                                            ->Where('activity.id_events', $id)
                                            ->Where('activity.id_status', 5)
                                            ->Where('student.check_blacklist', 0 )
                                            ->get());

        }
            

        return view('frontend.course_apply', compact('courseapplys', 'course', 'week', 'count_apply', 'count_check', 'count_cancel'));
    }
}
