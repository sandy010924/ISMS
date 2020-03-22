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

        $fill = array();
        $cash = 0;

        $fill_table = Registration::join('student', 'student.id', '=', 'registration.id_student')
                            ->join('isms_status', 'isms_status.id', '=', 'registration.status_payment')
                            // ->join('payment', 'payment.id_registration', '=', 'registration.id')
                            ->select('student.name as name', 'student.phone as phone', 'registration.*','isms_status.name as status_payment_name')
                            ->Where('registration.source_events', $id )
                            // ->groupby('registration.id_student')
                            ->get();

        foreach( $fill_table as $key => $data){    
            
            $payment_table = Payment::Where('id_registration', $data['id'] )
                                    ->select('payment.*')
                                    ->get();

            $payment = array();

            foreach ($payment_table as $key_payment => $data_payment) {
                switch ($data_payment['pay_model']) {
                    case 0:
                        $pay_model = '現金';
                        break;
                    case 1:
                        $pay_model = '匯款';
                        break;
                    case 2:
                        $pay_model = '刷卡：輕鬆付';
                        break;
                    case 3:
                        $pay_model = '刷卡：一次付';
                        break;
                    default:
                        $pay_model = '現金';
                        break;
                }

                $payment[$key_payment] = [ 
                    'id_payment' => $data_payment['id'],
                    'cash' => $data_payment['cash'],
                    'pay_model' => $pay_model,
                    'number' => $data_payment['number'],
                ];
            }

            //該場總金額
            $cash += $payment_table->sum('cash');
            $pay_date = '';

            if(!empty($data['pay_date'])){
                $pay_date = date('Y-m-d', strtotime($data['pay_date']));
            }else {
                $pay_date = '';
            }

            $fill[$key] = [ 
                'id' => $data['id'],
                'name' => $data['name'],
                'phone' => $data['phone'],
                'status_payment_name' => $data['status_payment_name'],
                'status_payment' => $data['status_payment'],
                'amount_payable' => $data['amount_payable'],
                'amount_paid' => $payment_table->sum('cash'),
                'pay_date' => $pay_date,
                'person' => $data['person'],
                'pay_memo' => $data['pay_memo'],
                'payment' => $payment
            ];
        }

        $count_settle = 0;
        $count_deposit = 0;
        $count_order = 0;

        //完款
        $count_settle = count(Registration::Where('source_events', $id )
                                          ->Where('status_payment', 7 )
                                          ->get());

        //付訂
        $count_deposit = count(Registration::Where('source_events', $id )
                                          ->Where('status_payment', 8 )
                                          ->get());

        //留單
        $count_order = count(Registration::Where('source_events', $id )
                                          ->Where('status_payment', 6 )
                                          ->get());

        return view('frontend.course_return', compact('course', 'week', 'fill', 'cash', 'count_settle', 'count_deposit', 'count_order'));    
    }

}
