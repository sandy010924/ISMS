<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Student;
use App\Model\ISMSStatus;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\Register;
use App\Model\Payment;

class CourseReturnController extends Controller
{
    // //現場報名(只限銷講)
    // public function insert(Request $request)
    // {
    //     try{
    //         //讀取data
    //         $id_events = $request->get('form_event_id');
    //         $new_name = $request->get('new_name');
    //         $new_phone = $request->get('new_phone');
    //         $new_email = $request->get('new_email');
    //         $new_address = $request->get('new_address');
    //         $new_profession = $request->get('new_profession');
    //         $new_pay = $request->get('new_paymodel');
    //         $new_account = $request->get('new_account');

    //         // $course = new Course;
    //         $student = new Student;
    //         $SalesRegistration = new SalesRegistration;

    //         //取得課程資訊
    //         $item_event = EventsCourse::select('id_course')
    //                             ->where('id', $id_events)->get();
    //         $id_course = $item_event[0]['id_course'];

    //         //判斷系統是否已有該學員資料
    //         $check_student = $student::where('phone', $new_phone)->get();


    //         /*學員報名資料 - S*/

    //         // 檢查學生資料
    //         if (count($check_student) != 0) {
    //             foreach ($check_student as $data_student) {
    //                 $id_student = $data_student ->id;
    //             }
    //         } else{
    //             // 新增學員資料
    //             $student->name          = $new_name;         // 學員姓名
    //             $student->sex           = '';                // 性別
    //             $student->id_identity   = '';                // 身分證
    //             $student->phone         = $new_phone;        // 電話
    //             $student->email         = $new_email;        // email
    //             $student->birthday      = '';                // 生日
    //             $student->company       = '';                // 公司
    //             $student->profession    = $new_profession;   // 職業
    //             if ($new_address != "") {
    //                 $student->address       = $new_address;  // 居住地
    //             }
                
    //             $student->save();
    //             $id_student = $student->id;
    //         }
    //         /*學員報名資料 - E*/


    //         /*銷售講座報名資料 - S*/

    //         $check_SalesRegistration = $SalesRegistration::where('id_student', $id_student)
    //                                                         ->where('id_events', $id_events)
    //                                                         ->get();
        
    //         // 檢查是否報名過
    //         if (count($check_SalesRegistration) == 0 && $id_student != "") {
    //             // 新增銷售講座報名資料
    //             if ($id_events != "" && $id_student != "") {                           
    //                 // Submission Date
    //                 $date = date('Y-m-d H:i:s');
    //                 $SalesRegistration->submissiondate   = $date;                         
    //                 // 表單來源
    //                 $SalesRegistration->datasource       = '現場';                   
    //                 // 學員ID
    //                 $SalesRegistration->id_student      = $id_student;                      
    //                 // 課程ID 
    //                 $SalesRegistration->id_course       = $id_course;  
    //                 // 場次ID 
    //                 $SalesRegistration->id_events       = $id_events;   
    //                 // 報名狀態ID
    //                 $SalesRegistration->id_status       = 4;                                
                    
    //                 if ($new_pay != '') {
    //                     $SalesRegistration->pay_model       = $new_pay;              // 付款方式
    //                 }
    //                 if ($new_account != '') {
    //                     $SalesRegistration->account         = $new_account;          // 帳號/卡號後五碼
    //                 }
    //                 $SalesRegistration->course_content  = '';                 // 想聽到的課程有哪些
    //                 $SalesRegistration->memo  = '現場報名';                 // 報名備註
                    
    //                 $SalesRegistration->save();
    //                 $id_SalesRegistration = $SalesRegistration->id;
    //             }
    //         } else {
    //             foreach ($check_SalesRegistration as $data_SalesRegistration) {
    //                 $id_SalesRegistration = $data_SalesRegistration ->id;
    //             }
    //         }
            
    //         /*銷售講座報名資料 - E*/
    //         if ($id_student != "" && $id_events != "" && $id_SalesRegistration != "") {
    //             return redirect()->route('course_check', ['id' => $id_events])->with('status', '報名成功');
    //         } else {
    //             return redirect()->route('course_check', ['id' => $id_events])->with('status', '報名失敗');
    //         }
    //     } catch (\Exception $e) {
    //         return redirect()->route('course_check', ['id' => $id_events])->with('status', '報名失敗');
    //         // return json_encode(array(
    //         //     'errorMsg' => '儲存失敗'
    //         // ));
    //     }

    // }

    /*** 新增付款資料 ***/
    public function insert(Request $request)
    {
        //取回data
        $id_registration = $request->input('id_registration');
        $pay_model = $request->input('pay_model');
        $cash = $request->input('cash');
        $number = $request->input('number');
        
        $check_registration = Registration::where('id', $id_registration)->first();
        
        try{

            if( !empty($check_registration) ){
                $payment = new Payment;
                $payment->id_student        = $check_registration->id_student;      // 學員ID
                $payment->cash              = $cash;                                // 金額
                $payment->pay_model         = $pay_model;                           // 付款方式
                $payment->number            = $number;                              // 帳戶/卡號後四碼
                $payment->id_registration   = $id_registration;                     // 正課報名ID
                $payment->save();
                $id_payment = $payment->id;
            }

            if($id_payment != ""){

                $payment_table = Payment::where('id', $id_payment)
                                        ->first();

                switch ($payment_table->pay_model) {
                    case 0:
                        $pay_model_data = '現金';
                        break;
                    case 1:
                        $pay_model_data = '匯款';
                        break;
                    case 2:
                        $pay_model_data = '刷卡：輕鬆付';
                        break;
                    case 3:
                        $pay_model_data = '刷卡：一次付';
                        break;
                    default:
                        return 'error';
                        break;
                }

                $payment_data = array(
                    'id' => $payment_table->id,
                    'cash' => $payment_table->cash,
                    'pay_model' => $pay_model_data,
                    'number' => $payment_table->number,
                    'id_registration' => $payment_table->id_registration,
                );

                return $payment_data;
            }else{
                return 'error';
            }

        }catch (Exception $e) {
            return 'error';
            // return json_encode(array(
            //     'errorMsg' => '儲存失敗'
            // ));
        }
    }
    
    /*** 資料更新 ***/
    public function update(Request $request)
    {
        //取回data
        $id_events = $request->input('id_events');
        $data_type = $request->input('data_type');
        $data_val = $request->input('data_val');
        
        try{
            switch($data_type){
                case 'money':
                    //現場完款
                    EventsCourse::where('id', $id_events)
                                ->update(['money' => $data_val]);
                    break;
                case 'money_fivedays':
                    //五日內完款
                    EventsCourse::where('id', $id_events)
                                ->update(['money_fivedays' => $data_val]);
                    break;
                case 'money_installment':
                    //分期付款
                    EventsCourse::where('id', $id_events)
                                ->update(['money_installment' => $data_val]);
                    break;
                case 'memo':
                    //該場備註
                    EventsCourse::where('id', $id_events)
                                ->update(['memo' => $data_val]);
                    break;
                case 'status_payment':
                    //應付
                    $data_id = $request->input('data_id');
                    
                    Registration::where('id', $data_id)
                                ->update(['status_payment' => $data_val]);

                    break;
                case 'amount_payable':
                    //應付
                    $data_id = $request->input('data_id');
                    
                    Registration::where('id', $data_id)
                                ->update(['amount_payable' => $data_val]);

                    break;
                case 'pay_date':
                    //付款日期
                    $data_id = $request->input('data_id');
                    
                    Registration::where('id', $data_id)
                                ->update(['pay_date' => $data_val]);

                    break;
                case 'person':
                    //服務人員
                    $data_id = $request->input('data_id');
                    
                    Registration::where('id', $data_id)
                                ->update(['person' => $data_val]);

                    break;
                case 'pay_memo':
                    //備註
                    $data_id = $request->input('data_id');
                    
                    Registration::where('id', $data_id)
                                ->update(['pay_memo' => $data_val]);

                    break;
                case 'pay_model':
                    //付款資料 - 付款方式
                    $data_id = $request->input('data_id');
                    
                    Payment::where('id', $data_id)
                                ->update(['pay_model' => $data_val]);

                    break;
                case 'cash':
                    //付款資料 - 金額
                    $data_id = $request->input('data_id');
                    
                    Payment::where('id', $data_id)
                                ->update(['cash' => $data_val]);

                    break;
                case 'number':
                    //付款資料 - 帳戶/卡號後四碼
                    $data_id = $request->input('data_id');
                    
                    Payment::where('id', $data_id)
                                ->update(['number' => $data_val]);

                    break;
                default:
                    return 'error';
                    break;

            }
        
            return 'success';

        }catch (Exception $e) {
            return 'error';
            // return json_encode(array(
            //     'errorMsg' => '儲存失敗'
            // ));
        }
    }

    // 刪除 Sandy (2020/03/22)
    public function delete(Request $request)
    {
        $status = "";
        $id_payment = $request->get('id_payment');

        // 查詢是否有該筆資料
        $payment = Payment::where('id', $id_payment)->first();
            
        try{
            if(!empty($payment)){
                //刪除付款資料
                Payment::where('id', $id_payment)->delete();     
                
                $status = "ok";
            } else {
                $status = "error";
            }
        }catch (Exception $e) {
            $status = "error";
        }
        
        return json_encode(array('data' => $status));
    }
}
