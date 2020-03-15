<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Uer;
use App\Model\Register;

class CourseApplyController extends Controller
{
    public function show(Request $request)
    {
        //課程資訊
        $id = $request->get('id');
        $course = EventsCourse::rightjoin('course', 'course.id', '=', 'events_course.id_course')
                            ->join('users', 'users.id', '=', 'course.id_teacher')
                            ->select('course.name as course', 'course.type as type', 'users.name as teacher', 'events_course.*')
                            ->Where('events_course.id', $id)
                            ->first();
        
        $weekarray = array("日","一","二","三","四","五","六");
        $week = $weekarray[date('w', strtotime($course->course_start_at))];


        //未過場次 狀態預設改為已報名
        if(strtotime(date('Y-m-d', strtotime($course->course_start_at))) > strtotime(date("Y-m-d"))){
            if($course->type == 1){
                SalesRegistration::Where('id_events', $id)
                                ->where(function($q) { 
                                    $q->orWhere('id_status', 3)
                                    ->orWhere('id_status', 4);
                                })
                                ->update(['id_status' => 1]);
            }elseif($course->type == 2 || $course->type == 3){
                Register::Where('id_events', $id)
                        ->where(function($q) { 
                            $q->orWhere('id_status', 3)
                            ->orWhere('id_status', 4);
                        })
                        ->update(['id_status' => 1]);
            }
        }else{
            //已過場次 狀態預設已報到改為未到
            if($course->type == 1){
                SalesRegistration::Where('id_events', $id)
                                ->Where('id_status', 1)
                                ->update(['id_status' => 3]);
            }elseif($course->type == 2 || $course->type == 3){
                Register::Where('id_events', $id)
                        ->Where('id_status', 1)
                        ->update(['id_status' => 3]);
            }
        }
        
        //判斷是銷講or正課
        // $type = "";

        if($course->type == 1){
            // $type = "sales_registration";
            
            if(strtotime(date('Y-m-d', strtotime($course->course_start_at))) > strtotime(date("Y-m-d"))){
                //未過場次 狀態預設改為已報名
                SalesRegistration::Where('id_events', $id)
                                ->where(function($q) { 
                                    $q->orWhere('id_status', 3)
                                    ->orWhere('id_status', 4);
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
                                            ->select('student.name as name', 'student.phone as phone', 'student.email as email', 'student.profession as profession', 'sales_registration.*', 'isms_status.name as status_name')
                                            ->Where('sales_registration.id_events', $id)
                                            ->Where('sales_registration.id_status', '<>', 2)
                                            ->get();
                                            
            //報名筆數
            $count_apply = count($courseapplys);

            //報名筆數
            $count_check = count(SalesRegistration::Where('id_events', $id)
                                                ->Where('id_status', 4)
                                                ->get());

            //取消筆數
            $count_cancel = count(SalesRegistration::Where('id_events', $id)
                                                ->Where('id_status', 5)
                                                ->get());

        }elseif($course->type == 2 || $course->type == 3){

            if(strtotime(date('Y-m-d', strtotime($course->course_start_at))) > strtotime(date("Y-m-d"))){
                //未過場次 狀態預設改為已報名
                Register::Where('id_events', $id)
                        ->where(function($q) { 
                            $q->orWhere('id_status', 3)
                            ->orWhere('id_status', 4);
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
            $courseapplys = Register::join('isms_status', 'isms_status.id', 'register.id_status')
                                    ->join('student', 'student.id', 'register.id_student')
                                    ->select('student.name as name', 'student.phone as phone', 'student.email as email', 'student.profession as profession', 'register.*', 'isms_status.name as status_name')
                                    ->Where('register.id_events', $id)
                                    ->Where('register.id_status', '<>', 2)
                                    ->get();
            
                                    
            //報名筆數
            $count_apply = count($courseapplys);

            //報名筆數
            $count_check = count(Register::Where('id_events', $id)
                                         ->Where('id_status', 4)
                                         ->get());

            //取消筆數
            $count_cancel = count(Register::Where('id_events', $id)
                                          ->Where('id_status', 5)
                                          ->get());
        }
        // //報名資訊
        // $courseapplys = $db_type->select('student.name as name', 'student.phone as phone', 'student.email as email', 'student.profession as profession', $type.'.*', 'isms_status.name as status_name')
        //                         // ->select('student.*', 'sales_registration.submissiondate as apply_submissiondate', 'sales_registration.id as apply_id', 'sales_registration.id_status as apply_status_val', 'isms_status.name as status_name')
        //                         ->Where('register.id_events', $id)
        //                         ->Where('id_status', '<>', 2)
        //                         // ->where(function($q) { 
        //                         //     $q->where('id_status', 1)
        //                         //         ->orWhere('id_status', 5);
        //                         // })
        //                         // ->orderByRaw('FIELD(id_status, "4", "3", "5")')
        //                         // ->orderBy('created_at', 'DESC')
        //                         ->get();
            

        return view('frontend.course_apply', compact('courseapplys', 'course', 'week', 'count_apply', 'count_check', 'count_cancel'));
    }
}
