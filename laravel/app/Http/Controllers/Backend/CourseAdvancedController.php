<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Student;
use App\Model\Registration;
use App\Model\EventsCourse;
use App\Model\Payment;
use App\Model\Debt;

class CourseAdvancedController extends Controller
{
     // 刪除 Sandy (2020/03/12)
     public function delete(Request $request)
     {
         $status = "";
         $id_fill = $request->get('id_fill');

        // 查詢是否有該筆資料
        $formal = Registration::join('events_course', 'events_course.id', '=', 'registration.id_events')
                              ->select('events_course.id_group as id_group', 'registration.id_student as id_student', 'registration.id_payment as id_payment')
                              ->where('registration.id', $id_fill)
                              ->first();
            
        if(!empty($formal)){
            
            $group = Registration::join('events_course', 'events_course.id', '=', 'registration.id_events')
                                 ->select('registration.*')
                                 ->where('registration.id_student', $formal->id_student)
                                 ->where('events_course.id_group', $formal->id_group)
                                 ->get();
                                 
            foreach( $group as $data ){
                //刪除追單表
                Debt::where('id_registration', $data['id'])->delete();   
                //刪除報名表
                Registration::where('id', $data['id'])->delete();
            }
            //刪除付款細項
            Payment::where('id', $formal->id_payment)->delete();

            $status = "ok";
            
        } else {
            $status = "error";
        }
        
         return json_encode(array('data' => $status));
     }

}
