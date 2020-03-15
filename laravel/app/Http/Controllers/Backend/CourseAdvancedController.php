<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Student;
use App\Model\Registration;
// use App\Model\EventsCourse;
use App\Model\Register;
use App\Model\Debt;
use App\Model\Refund;
use App\Model\Payment;

class CourseAdvancedController extends Controller
{
     // 刪除 Sandy (2020/03/12)
     public function delete(Request $request)
     {
         $status = "";
         $id_registration = $request->get('id_registration');

        // 查詢是否有該筆資料
        // $formal = Registration::join('events_course', 'events_course.id', '=', 'registration.id_events')
        //                       ->select('events_course.id_group as id_group', 'registration.id_student as id_student', 'registration.id_payment as id_payment')
        //                       ->where('registration.id', $id_registration)
        //                       ->first();
        $formal = Registration::where('id', $id_registration)
                              ->first();
            
        if(!empty($formal)){
            
            // $group = Registration::where('id_student', $formal->id_student)
            //                      ->where('id_group', $formal->id_group)
            //                      ->get();
                                 
            // foreach( $group as $data ){
            //     //刪除追單表
            //     Debt::where('id_registration', $data['id'])->delete();   
            //     //刪除報名表
            //     Registration::where('id', $data['id'])->delete();
            // }
            // //刪除付款細項
            // Payment::where('id', $formal->id_payment)->delete();

            // foreach( $apply_table as $data ){
                //刪除報到
                Register::where('id_registration', $id_registration)->delete();

                //刪除追單
                Debt::where('id_registration', $id_registration)->delete();   
                
                //刪除退費
                Refund::where('id_registration', $id_registration)->delete();   

                //刪除付款
                Payment::where('id_registration', $id_registration)->delete();
            // }

            //刪除報名表
            Registration::where('id', $id_registration)->delete();




            $status = "ok";
            
        } else {
            $status = "error";
        }
        
         return json_encode(array('data' => $status));
     }

}
