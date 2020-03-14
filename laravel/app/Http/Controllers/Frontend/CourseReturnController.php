<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Student;
use App\Model\Payment;
use App\Model\ISMSStatus;

class CourseReturnController extends Controller
{
    //view
    public function show(Request $request)
    {
         //課程資訊
        $id = $request->get('id');
        $course = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                                ->select('events_course.*', 'course.id as id_course', 'course.name as course')
                                ->Where('events_course.id', $id)
                                ->first();

        $weekarray = array("日","一","二","三","四","五","六");
        $week = $weekarray[date('w', strtotime($course['course_start_at']))]; 


        // 進階填單課程
        $next_course = Course::join('users', 'users.id', '=', 'course.id_teacher')
                        ->select('course.id as id_course', 'course.name as course', 'users.name as teacher')
                        ->Where('course.id_type', $course->id_course)
                        ->first();


        /* 填單名單 S */
        $fill_table = Registration::join('student', 'student.id', '=', 'registration.id_student')
                            ->join('isms_status', 'isms_status.id', '=', 'registration.status_payment')
                            // ->join('events_course', 'events_course.id', '=', 'registration.id_events')
                            ->join('payment', 'payment.id', '=', 'registration.id_payment')
                            ->select('student.name as name', 'student.phone as phone', 'registration.*', 'isms_status.name as status_payment_name', 'payment.person as person')
                            // ->selectraw('sum(cash) as cash')
                            ->Where('registration.id_course', $next_course->id_course)
                            ->Where('registration.created_at', 'like', '%'. date('Y-m-d', strtotime($course->course_start_at)). '%' )
                            ->groupby('registration.id_student')
                            ->get();

        $fill =array();

        foreach( $fill_table as $key => $data){            
            // $over = Registration::where('status_payment', 7)

            $fill[$key] = [
                'name' => $data['name'],
                'phone' => $data['phone'],
                'status_payment' => $data['status_payment'],
                'status_payment_name' => $data['status_payment_name'],
                'amount_payable' => $data['amount_payable'],
                'amount_paid' => $data['amount_paid'],
                // 'pay_date' => $data['pay_date'],  //付款日期
                'person' => $data['person'],
                // 'memo' => $data['memo_payment'],  //付款備註
                'id_payment' => $data['id_payment'],
                'id' => $data['id']
            ];
        }
        /* 填單名單 E */


        /* 付款細項 S */
        $paylist = Registration::join('payment', 'payment.id', '=', 'registration.id_payment')
                            ->select('payment.*')
                            // ->selectraw('sum(cash) as cash')
                            ->Where('registration.id_course', $next_course->id_course)
                            ->Where('registration.created_at', 'like', '%'. date('Y-m-d', strtotime($course->course_start_at)). '%' )
                            ->groupby('registration.id_payment')
                            ->get();

        /* 填單名單 E */

        //該場總金額
        $cash = $paylist->sum('cash');

        // dd($fill);

        return view('frontend.course_return', compact('course', 'week', 'fill', 'cash', 'paylist'));    
    }

}
