<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Registration;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Uer;
use App\Model\Student;

class CourseAdvancedController extends Controller
{
    public function show(Request $request)
    {
        //課程資訊
        $id = $request->get('id');
        $course = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                        ->join('users', 'users.id', '=', 'course.id_teacher')
                        ->select('events_course.*', 'course.id as id_course', 'course.name as course', 'users.name as teacher')
                        ->Where('events_course.id', $id)
                        ->first();
                        
        $next_course = Course::join('users', 'users.id', '=', 'course.id_teacher')
                        ->select('course.id as id_course', 'course.name as course', 'users.name as teacher')
                        ->Where('course.id_type', $course->id_course)
                        ->first();
                        
        $weekarray = array("日","一","二","三","四","五","六");
        $week = $weekarray[date('w', strtotime($course->course_start_at))];


        //填單名單
        $fill_all = Registration::join('student', 'student.id', '=', 'registration.id_student')
                            ->join('events_course', 'events_course.id', '=', 'registration.id_events')
                            ->select('student.name as student','student.phone as phone', 'student.email as email', 'student.profession as profession', 'registration.*', 'events_course.name as event', 'events_course.id_group as id_group')
                            ->Where('registration.source_events', $id )
                            // ->Where('registration.id_course', $next_course->id_course)
                            // ->Where('registration.created_at', 'like', '%'. date('Y-m-d', strtotime($course->course_start_at)). '%' )
                            ->get();
  
        $id_group='';       
        $fill = array();
                     
        foreach( $fill_all as $key => $data ){

            // if ($id_group == $data['id_group']){ 
            //     continue;
            // }

            $course_group = EventsCourse::Where('id_group', $data['id_group'])
                                        ->get();

            $numItems = count($course_group);
            $i = 0;

            $events_date = '';

            foreach( $course_group as $key_group => $data_group ){
                //日期
                $date = date('Y-m-d', strtotime($data_group['course_start_at']));
                //星期
                $weekarray = array("日","一","二","三","四","五","六");
                $week = $weekarray[date('w', strtotime($data_group['course_start_at']))];
                
                if( ++$i === $numItems){
                    $events_date .= $date . '(' . $week . ')';
                }else {
                    $events_date .= $date . '(' . $week . ')' . '、';
                }
            }

            $join = ''; 
            if( $data['registration_join'] == 0){
                $join = '現場最優惠價格';
            }elseif( $data['join'] == 1){
                $join = '五日內優惠價格';
            }

            $fill[$key] = array(
                'id' => $data['id'],
                'submission' => date('Y-m-d', strtotime($data['created_at'])),
                'date' => $events_date,
                'name' => $data['student'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'join' => $join,
                'event' => $data['event'],
            );

            // $id_group = $data['id_group'];
        }              
                                        
        return view('frontend.course_advanced', compact('course', 'next_course', 'week', 'fill'));
    }
}
