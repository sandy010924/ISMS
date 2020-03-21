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
use App\Model\Refund;
use App\Model\Payment;

class CourseListRefundController extends Controller
{
    //view
    public function show(Request $request)
    {
        $course = array();
        $events = array();
        $refund = array();
        
        //課程資訊
        $id = $request->get('id');
        $course = Course::join('users', 'users.id', '=', 'course.id_teacher')
                        ->select('course.*', 'users.name as teacher')
                        ->Where('course.id', $id)
                        ->first();
        

        //場次資訊
        $events_table = EventsCourse::Where('id_course', $id)
                                    ->get();

        $id_group = ''; 
        $id_student= '';   

        foreach( $events_table as $key => $data ){
            if ($id_group == $data['id_group']){ 
                continue;
            }

            $events_group = EventsCourse::Where('id_group', $data['id_group'])
                                        ->get();
                                            
            
            $numItems = count($events_group);
            $i = 0;
            $events_list = '';

            foreach( $events_group as $key_group => $data_group ){
                //日期
                $date = date('Y-m-d', strtotime($data['course_start_at']));
                //星期
                $weekarray = array("日","一","二","三","四","五","六");
                $week = $weekarray[date('w', strtotime($data['course_start_at']))];
                
                if( ++$i === $numItems){
                    $events_list .= $date . '(' . $week . ')';
                }else {
                    $events_list .= $date . '(' . $week . ')' . '、';
                }
            }

            $id_group = $data['id_group']; 


            $events[$key] = array(
                'id_group' => $data['id_group'],
                'events' => $events_list . '　' . $data['name'],
            );
        }




        //判斷是銷講or正課
        if( $course->type == 2 || $course->type == 3) {
            //正課
            // $refund_table = Registration::join('events_course', 'events_course.id', '=', 'registration.id_events')
            //                      ->join('student', 'student.id', '=', 'registration.id_student')
            //                      ->select('student.phone as phone', 'student.email as email', 'student.profession as profession', 'registration.*', 'events_course.name as event', 'events_course.id_group as id_group')
            //                      ->Where('registration.id_course', $id)
            //                      ->get();
            
            $refund_table = Refund::join('registration', 'registration.id', '=', 'refund.id_registration')
                                 ->join('events_course', 'events_course.id', '=', 'registration.id_events')
                                 ->join('student', 'student.id', '=', 'refund.id_student')
                                 ->select('student.name as name', 
                                          'student.phone as phone', 
                                          'student.email as email',  
                                          'registration.id as id_registration', 
                                          'registration.created_at as date', 
                                          'refund.id as id', 
                                          'refund.refund_date as refund_date', 
                                          'refund.refund_reason as refund_reason', 
                                          'events_course.name as event', 
                                          'events_course.id_group as id_group')
                                 ->Where('registration.id_course', $id)
                                 ->get();
 
                                 
            foreach( $refund_table as $key => $data ){

                //場次群組
                $events_group = EventsCourse::Where('id_group', $data['id_group'])
                                            ->get();

                $numItems = count($events_group);
                $i = 0;

                $event = '';

                foreach( $events_group as $key_group => $data_group ){
                    //日期
                    $date = date('Y-m-d', strtotime($data_group['course_start_at']));
                    //星期
                    $weekarray = array("日","一","二","三","四","五","六");
                    $week = $weekarray[date('w', strtotime($data_group['course_start_at']))];
                    
                    if( ++$i === $numItems){
                        $event .= $date . '(' . $week . ')';
                    }else {
                        $event .= $date . '(' . $week . ')' . '、';
                    }
                }


                //付款方式細項
                $payment_table = Payment::Where('id_registration', $data['id_registration'])
                                            ->get();

                $numItems_payment = count($payment_table);
                $i_payment = 0;

                $pay_model = '';
                $number = '';
                foreach( $payment_table as $key_payment => $data_payment ){
                    if( ++$i_payment === $numItems_payment){
                        $pay_model .= $data_payment['pay_model'];
                        $number .= $data_payment['number'];
                    }else {
                        $pay_model .= $data_payment['pay_model'] . '、';
                        $number .= $data_payment['number'] . '、';
                    }
                }


                //refund
                $refund[$key] = array(
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'date' => date('Y-m-d', strtotime($data['date'])),
                    'number' => $number,
                    'refund_date' => date('Y-m-d', strtotime($data['refund_date'])),
                    'pay_model' => $pay_model,
                    'refund_reason' => $data['refund_reason'],
                    'event' => $event,
                );

            }

            $start = '';
            $end = '';

            //開始時間
            $start = Refund::join('registration', 'registration.id', '=', 'refund.id_registration')
                            ->select('registration.created_at as date', 
                                    'refund.id as id')
                            ->orderBy('date','asc')
                            ->get('date')
                            ->unique('id');

            //結束時間
            $end = Refund::join('registration', 'registration.id', '=', 'refund.id_registration')
                            ->select('registration.created_at as date', 
                                    'refund.id as id')
                            ->orderBy('date','desc')
                            ->get('date')
                            ->unique('id');
        }



        return view('frontend.course_list_refund', compact('course', 'events', 'refund', 'start', 'end'));    
    }

    //新增退費form選取場次後搜尋該場次所報名之學員
    public function form(Request $request)
    {
        $id_group = $request->get('id_group');
        
        $student = Registration::join('student', 'student.id', '=', 'registration.id_student')
                                ->select('student.name as name', 'registration.id_student as id_student')  
                                ->Where('id_group', $id_group)
                                ->get();

        return Response($student);

    }
}
