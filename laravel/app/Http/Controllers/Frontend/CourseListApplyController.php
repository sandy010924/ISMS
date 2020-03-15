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

class CourseListApplyController extends Controller
{
    //view
    public function show(Request $request)
    {
        $course = array();
        $apply = array();
        
         //課程資訊
        $id = $request->get('id');
        $course = Course::join('users', 'users.id', '=', 'course.id_teacher')
                        ->select('course.*', 'users.name as teacher')
                        ->Where('course.id', $id)
                        ->first();
        
        //判斷是銷講or正課
        if( $course->type == 1){
            //銷講
            $apply_table = SalesRegistration::join('events_course', 'events_course.id', '=', 'sales_registration.id_events')
                                      ->join('student', 'student.id', '=', 'sales_registration.id_student')
                                      ->select('student.phone as phone', 'student.email as email', 'student.profession as profession', 'sales_registration.*', 'events_course.name as event', 'events_course.course_start_at as course_start_at')
                                      ->Where('sales_registration.id_course', $id)
                                      ->get();
                                      
            foreach( $apply_table as $key => $data ){
                $weekarray = array("日","一","二","三","四","五","六");
                $week = $weekarray[date('w', strtotime($data['course_start_at']))];

                $event = date('Y-m-d', strtotime($data['course_start_at'])) . '(' . $week . ')' . $data['event'];

                $apply[$key] = array(
                    'id' => $data['id'],
                    'date' => $data['submissiondate'],
                    'source' => $data['datasource'],
                    'event' => $event,
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'profession' => $data['profession'],
                    'content' => $data['course_content'],
                );
            }
        }elseif( $course->type == 2 || $course->type == 3) {
            //正課
            $apply_table = Registration::join('events_course', 'events_course.id', '=', 'registration.id_events')
                                 ->join('student', 'student.id', '=', 'registration.id_student')
                                 ->select('student.phone as phone', 'student.email as email', 'student.profession as profession', 'registration.*', 'events_course.name as event', 'events_course.id_group as id_group')
                                 ->Where('registration.id_course', $id)
                                 ->get();

            $id_group='';      
            $id_student='';         
                                 
            foreach( $apply_table as $key => $data ){

                // if ($id_student == $data['id_student'] && $id_group == $data['id_group']){ 
                //     continue;
                // }

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
                        $events .= $date . '(' . $week . ')';
                    }else {
                        $events .= $date . '(' . $week . ')' . '、';
                    }
                }

                $apply[$key] = array(
                    'id' => $data['id'],
                    'date' => date('Y-m-d', strtotime($data['created_at'])),
                    'event' => $events . ' ' . $data['event'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'profession' => $data['profession'],
                    'content' => $data['course_content'],
                );


                // $id_group = $data['id_group']; 
                // $id_student= $data['id_student'];     
            }
        }

        return view('frontend.course_list_apply', compact('course', 'apply'));    
    }

}
