<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Uer;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Student;
use App\Model\Teacher;
use App\Model\Refund;

class CourseListApplyController extends Controller
{
    //view
    public function show(Request $request)
    {
        $course = array();
        $apply = array();
        $start = '';
        $end = '';
        $start_array = array();
        $end_array = array();
        
         //課程資訊
        $id = $request->get('id');
        $course = Course::join('teacher', 'teacher.id', '=', 'course.id_teacher')
                        ->select('course.*', 'teacher.name as teacher')
                        ->Where('course.id', $id)
                        ->first();
        
        //判斷是銷講or正課
        if( $course->type == 1){
            //銷講
            $apply_table = SalesRegistration::join('events_course', 'events_course.id', '=', 'sales_registration.id_events')
                                      ->join('student', 'student.id', '=', 'sales_registration.id_student')
                                      ->select('student.name as name', 
                                                'student.phone as phone', 
                                                'student.email as email', 
                                                'student.profession as profession', 
                                                'sales_registration.*', 
                                                'events_course.name as event', 
                                                'events_course.course_start_at as course_start_at')
                                      ->Where('sales_registration.id_course', $id)
                                      ->get();
                                      
            foreach( $apply_table as $key => $data ){

                
                //檢查學員是否退費成功
                $refund = Refund::where('id_registration', $data['id'])
                                ->where('review', 1)
                                ->get();
                if( count($refund) != 0){
                    continue;
                }

                //檢查學員是否申請退費
                $refund = Refund::where('id_registration', $data['id'])
                                ->where('review', 0)
                                ->get();
                if( count($refund) != 0){
                    $refund_status = 1;  //有
                }else{
                    $refund_status = 0;  //沒有
                }
                


                $weekarray = array("日","一","二","三","四","五","六");
                $week = $weekarray[date('w', strtotime($data['course_start_at']))];

                $event = date('Y-m-d', strtotime($data['course_start_at'])) . '(' . $week . ')' . $data['event'];

                $apply[$key] = array(
                    'id' => $data['id'],
                    'date' => $data['submissiondate'],
                    'source' => $data['datasource'],
                    'event' => $event,
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'profession' => $data['profession'],
                    'content' => $data['course_content'],
                    'refund_status' => $refund_status,
                );
            }

            
            //開始時間
            $start_array = SalesRegistration::select('submissiondate as date')
                            ->where('id_course', $id)
                            ->orderBy('date','asc')
                            ->first();
                            // ->get('date')
                            // ->unique('id');

            //結束時間
            $end_array = SalesRegistration::select('submissiondate as date')
                            ->where('id_course',$id)
                            ->orderBy('date','desc')
                            ->first();
                            // ->get('date')
                            // ->unique('id');

        }elseif( $course->type == 2 || $course->type == 3) {
            //正課
            // $apply_table = Registration::join('events_course', 'events_course.id', '=', 'registration.id_events')
            //                      ->join('student', 'student.id', '=', 'registration.id_student')
            //                      ->select('student.phone as phone', 'student.email as email', 'student.profession as profession', 'registration.*', 'events_course.name as event', 'events_course.id_group as id_group')
            //                      ->Where('registration.id_course', $id)
            //                      ->get();
            $apply_table = Registration::join('student', 'student.id', '=', 'registration.id_student')
                                        ->select('student.name as name','student.phone as phone', 'student.email as email', 'student.profession as profession', 'registration.*')
                                        ->Where('registration.id_course', $id)
                                        // ->Where('registration.status_payment', 7)
                                        ->where(function($q) { 
                                            $q->orWhere('registration.status_payment', 7)
                                              ->orWhere('registration.status_payment', 9);
                                        })
                                        ->get();

            $id_group='';      
            $id_student='';         
                                 
            foreach( $apply_table as $key => $data ){

                //檢查學員是否退費成功
                $refund = Refund::where('id_registration', $data['id'])
                                ->where('review', 1)
                                ->get();
                if( count($refund) != 0){
                    continue;
                }

                //檢查學員是否申請退費
                $refund = Refund::where('id_registration', $data['id'])
                                ->where('review', 0)
                                ->get();
                if( count($refund) != 0){
                    $refund_status = 1;  //有
                }else{
                    $refund_status = 0;  //沒有
                }
                

                // if ($id_student == $data['id_student'] && $id_group == $data['id_group']){ 
                //     continue;
                // }

                if($data['id_group'] != null){
                    $course_group = EventsCourse::Where('id_group', $data['id_group'])
                                            ->get();

                    $numItems = count($course_group);
                    $i = 0;

                    $events = '';

                    foreach( $course_group as $key_group => $data_group ){
                        //日期
                        $date = date('Y-m-d', strtotime($data_group['course_start_at']));
                        //星期
                        $weekarray = array("日","一","二","三","四","五","六");
                        $week = $weekarray[date('w', strtotime($data_group['course_start_at']))];
                        
                        if( ++$i === $numItems){
                            $events .= $date . '(' . $week . ')　'. $data_group['name'];
                        }else {
                            $events .= $date . '(' . $week . ')' . '、';
                        }
                    }
                }else{
                    $events = '尚未選擇場次';
                }
                
                $apply[$key] = array(
                    'id' => $data['id'],
                    'date' => date('Y-m-d', strtotime($data['submissiondate'])),
                    'event' => $events,
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'profession' => $data['profession'],
                    'content' => $data['course_content'],
                    'refund_status' => $refund_status,
                );


                // $id_group = $data['id_group']; 
                // $id_student= $data['id_student'];     
                
            }

            //開始時間
            $start_array = Registration::select('submissiondate as date')
                            ->where('id_course', $id)
                            ->orderBy('date','asc')
                            ->first();

            //結束時間
            $end_array = Registration::select('submissiondate as date')
                            ->where('id_course', $id)
                            ->orderBy('date','desc')
                            ->first();
            
        }
        
        if( $start_array!="" && $end_array!="" ){
            $start = date('Y-m-d', strtotime($start_array->date));
            $end = date('Y-m-d', strtotime($end_array->date));
        }

        return view('frontend.course_list_apply', compact('course', 'apply', 'start', 'end'));    
    }

}
