<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Model\Course;
// use App\Model\EventsCourse;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Register;
use App\Model\Debt;
use App\Model\Refund;
use App\Model\Payment;

class CourseListApplyController extends Controller
{
     // 刪除 Sandy (2020/03/12)
     public function delete(Request $request)
     {
         $status = "";
         $type = $request->get('type');
         $id_apply = $request->get('id_apply');
            
        if($type == 1){
            //銷講
            $sale = SalesRegistration::where('id', $id_apply)
                                      ->get();

            if( count($sale) != 0 ){
                //刪除報名表
                SalesRegistration::where('id', $id_apply)->delete();
            }

            $status = "ok";
            
        }elseif( $type == 2 || $type == 3) {
            //正課
            $formal = Registration::where('id', $id_apply)
                                  ->get();

            if( count($formal) != 0 ){
                //刪除報到表
                Register::where('id_registration', $id_apply)->delete();
                //刪除付款表
                Debt::where('id_registration', $id_apply)->delete();   
                //刪除追單表
                Payment::where('id_registration', $id_apply)->delete();
                //刪除退費
                Refund::where('id_registration', $id_apply)->delete();   
                //刪除報名表
                Registration::where('id', $id_apply)->delete();
            }

            $status = "ok";

        }else {
            $status = "error";
        }
        
         return json_encode(array('data' => $status));
     }
}
