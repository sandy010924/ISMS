<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Refund;
use App\Model\Registration;
use App\Model\Payment;

class CourseListRefundController extends Controller
{
    //新增退費
    public function insert(Request $request)
    {
        try{
            //讀取data
            $id = $request->get('course_id');
            $date = $request->get('form_date');
            // $id_group = $request->get('form_events');
            $id_student = $request->get('form_student');
            $reason = $request->get('form_reason');
            $reason_other = $request->get('form_reason_other');
            
            if( $reason == "其他"){
                $reason = $reason_other;
            }

            $registration = Registration::select('id')
                                        ->where('id_student', $id_student)
                                        // ->where('id_group', $id_group)
                                        ->where('id_course', $id)
                                        ->orderBy('created_at', 'desc')
                                        ->first();
                                        
            //判斷退費是否已有該學員資料
            $check_refund = Refund::where('id_registration', $registration->id)
                                  ->get();

            if (count($check_refund) != 0) {
                foreach ($check_refund as $data_refund) {
                    $id_refund = $data_refund ->id;
                }
                
                //更新退費資料
                Refund::where('id_registration',  $registration->id)
                    ->update([
                        'refund_date' => $date,
                        'refund_reason' => $reason,
                    ]);

            } else{
                $refund = new Refund;

                // 新增退費資料
                $refund->id_registration = $registration->id;   // 正課報名ID
                $refund->id_student      = $id_student;         // 學員ID
                $refund->refund_date     = $date;               // 申請退費日期
                $refund->refund_reason   = $reason;          // 退費原因

                $refund->save();
                $id_refund = $refund->id;
            }


            if ($id_refund != "") {
                //更新付款狀態為退費
                Registration::where('id', $registration->id)->update(['status_payment' => 9]);

                return redirect()->route('course_list_refund', ['id' => $id])->with('status', '新增退費成功');
            } else {
                return redirect()->route('course_list_refund', ['id' => $id])->with('status', '新增退費失敗');
            }

        } catch (\Exception $e) {
            return redirect()->route('course_list_refund', ['id' => $id])->with('status', '新增退費失敗');
        }

    }

    
     // 刪除 Sandy (2020/03/20)
     public function delete(Request $request)
     {
        $status = "";
        $id_refund = $request->get('id_refund');

        // try{
            // 查詢是否有該筆資料
            $refund = Refund::where('id', $id_refund)->first();
            
            $registration = Registration::where('id', $refund->id_registration)->first();
                
            if(!empty($refund)){

                //更新付款狀態
                $payment = Payment::selectraw('sum(cash) as all_pay')
                                ->where('id_registration', $refund->id_registration)
                                ->groupBy('id_registration')
                                ->first();
                                
                if( $payment->all_pay == $registration->amount_paid){
                    //完款
                    Registration::where('id', $refund->id_registration)->update(['status_payment' => 7]);
                }else{
                    //付訂
                    Registration::where('id', $refund->id_registration)->update(['status_payment' => 8]);
                }

                //刪除退費
                Refund::where('id', $id_refund)->delete();

                $status = "ok";
            } else {
                $status = "error";
            }

            return json_encode(array('data' => $status));
         
        // } catch (\Exception $e) {
        //     return json_encode(array('data' => 'error'));
        // }
     }
}
