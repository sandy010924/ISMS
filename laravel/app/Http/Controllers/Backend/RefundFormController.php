<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Refund;
use App\Model\Registration;
use App\Model\Student;

class RefundFormController extends Controller
{
    //新增退費
    public function insert(Request $request)
    {
        // try{
            //讀取data
            $id = $request->get('id');                   // 課程id
            $date = date('Y-m-d H:i:s');                 // 退費日期
            $name = $request->get('name');       // 姓名
            $phone = $request->get('phone');             // 連絡電話
            $email = $request->get('email');             // 電子郵件
            
            $reason = $request->get('reason');              // 退費原因
            $reason_other = $request->get('reason_other');  // 退費原因:其他
            
            if( $reason == "其他"){
                $reason = $reason_other;
            }
            
            $student = Student::where('phone', $phone)->first();

            if( empty($student) ){
                return 'nostudent';
            }else{
                $id_student = $student->id;

                $registration = Registration::select('id')
                                        ->where('id_student', $id_student)
                                        // ->where('id_group', $id_group)
                                        ->where('id_course', $id)
                                        ->orderBy('created_at', 'desc')
                                        ->first();
                     
                if( empty($registration) ){
                    //無報名資料
                    return 'nodata';
                }else{

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
                                // 'refund_date' => $date,
                                'name_student' => $name,
                                'phone' => $phone,
                                'email' => $email,
                                'refund_reason' => $reason,
                            ]);

                    } else{
                        $refund = new Refund;

                        // 新增退費資料
                        $refund->id_registration = $registration->id;   // 正課報名ID
                        $refund->id_student      = $id_student;         // 學員ID
                        $refund->refund_date     = $date;               // 申請退費日期
                        $refund->name_student    = $name;       // 學員姓名
                        $refund->phone           = $phone;           // 電話
                        $refund->email           = $email;           // 信箱
                        $refund->refund_reason   = $reason;          // 退費原因

                        $refund->save();
                        $id_refund = $refund->id;
                    }

                    if ($id_refund != "") {
                        // //更新付款狀態為退費
                        // Registration::where('id', $registration->id)->update(['status_payment' => 9]);

                        return 'success';
                    } else {
                        return 'error';
                    }
                }
            }
        // } catch (\Exception $e) {
        //     return 'error';
        // }

    }

    
}
