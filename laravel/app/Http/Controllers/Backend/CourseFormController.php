<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Student;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\Payment;
use App\Model\Registration;
use App\Model\Register;
use App\Model\Debt;
use DB;

class CourseFormController extends Controller
{
    // Sandy (2020/02/28)
    public function insert(Request $request)
    {
        $id_group = array();

        //讀取data
        $submissiondate = date('Y-m-d H:i:s', strtotime($request->get('idate')));
        $name = $request->get('iname');
        $sex = $request->get('isex');
        $id_identity = $request->get('iid');
        $phone = $request->get('iphone');
        $email = $request->get('iemail');
        $birthday = $request->get('ibirthday');
        $company = $request->get('icompany');
        $profession = $request->get('iprofession');
        $address = $request->get('iaddress');
        $join = $request->get('ijoin');
        $pay_model = $request->get('ipay_model');
        $cash = $request->get('icash');
        $number = $request->get('inumber');
        $type_invoice = $request->get('iinvoice');
        $number_taxid = $request->get('inum');
        $companytitle = $request->get('icompanytitle');

        $id_group = $request->get('id_group');

        $source_events =  $request->get('source_events');
        // $datasource =  $request->get('datasource');
        
        
        /* 防錯 */
        if($cash == ""){
            $cash = 0; 
        }
        if($address == ""){
            $address = ""; 
        }
        if($pay_model == ""){
            $pay_model = ""; 
        }
        if($number == ""){
            $number = ""; 
        }



        
        try{


            /*電子簽章 - S*/

            $sign = '';
            $submit = $request['submit'];

            if( $submit != 'submit_fast'){
                $base64Str = str_replace('data:image/png;base64,', '', $request['imgBase64']);
                $image = base64_decode($base64Str);
                $saveName = "signature-".time().".".'png';
                $success = file_put_contents(public_path().'/sign/'.$saveName, $image) ? 'success save' : 'fail save';
                
                if( $success == 'success save'){
                    $sign = $saveName;
                }else{
                    return array('status' => 'error : sign');
                }
            }

            /*電子簽章 - E*/


            /*學員報名資料 - S*/

            //判斷系統是否已有該學員資料
            $check_student = Student::where('phone', $phone)->get();

            // 檢查學員資料
            if (count($check_student) != 0) {
                foreach ($check_student as $data_student) {
                    $id_student = $data_student ->id;
                }
                //更新學員資料
                Student::where('phone', $phone)
                    ->update([
                        'name' => $name,
                        'sex' => $sex,
                        'id_identity' => $id_identity,
                        'email' => $email,
                        'birthday' => $birthday,
                        'company' => $company,
                        'profession' => $profession,
                        'address' => $address,
                    ]);
            } else{
                // 新增學員資料
                $student = new Student;

                $student->name          = $name;         // 學員姓名
                $student->sex           = $sex;          // 性別
                $student->id_identity   = $id_identity;  // 身分證
                $student->phone         = $phone;        // 電話
                $student->email         = $email;        // email
                $student->birthday      = $birthday;     // 生日
                $student->company       = $company;      // 公司
                $student->profession    = $profession;   // 職業
                // if ($address != "") {
                    $student->address       = $address;  // 居住地
                // }
                
                $student->save();
                $id_student = $student->id;
            }
            /*學員報名資料 - E*/



            /*正課報名資料 - S*/

            // $events_group = EventsCourse::where('id_group', $id_group)->get();

            $course = [];
        
            if(!empty($id_group)){
                
                $success = 0;

                foreach ($id_group as $key => $array_group) {

                    $data_group ='';

                    if(strpos($array_group, 'other') !== false){
                        /* 選擇其他場次 */

                        $data_group = $request->get('array_course')[$key];

                        // 檢查是否報名過
                        $check_registration = Registration::where('id_student', $id_student)
                                                        ->where('id_course', $data_group)
                                                        ->where('id_events', -99)
                                                        ->get();

                    }else{
                        $data_group = $array_group;

                        // 檢查是否報名過
                        $check_registration = Registration::where('id_student', $id_student)
                                                        ->where('id_group', $data_group)
                                                        ->get();

                    }

                    if (count($check_registration) == 0 && $id_student != "") {

                        $events_group = array();

                        if(strpos($array_group, 'other')!== false){
                            /* 選擇其他場次 */
                            $events_group = EventsCourse::where('id_course', $data_group)->orderBy('id', 'desc')->first();
                        }else{
                            $events_group = EventsCourse::where('id_group', $data_group)->orderBy('id', 'desc')->first();
                        }

                        // foreach( $events_group as $data_group){
                            // 新增正課報名資料
                            $registration = new Registration;
                            // $date = date('Y-m-d H:i:s');

                            $registration->id_student        = $id_student;                   // 學員ID
                            
                            if(strpos($array_group, 'other') !== false){
                                /* 選擇其他場次 */
                                $registration->id_course         = $data_group;      // 課程ID
                            }else{
                                $registration->id_course         = $events_group->id_course;      // 課程ID
                            }
                            // $registration->id_status         = 1;                             // 報名狀態ID
                            // $registration->id_payment        = $id_payment;                   // 繳款明細ID
                            $registration->amount_payable    = '';                            // 應付金額
                            #// $registration->amount_paid       = '';                            // 已付金額
                            // $registration->memo              = '';                            // 備註
                            $registration->sign              = $sign;                            // 簽名檔案
                            $registration->status_payment    = 6;                             // 付款狀態
                            $registration->status_payment_original    = 6;                             // 原始付款狀態

                            if(strpos($array_group, 'other') !== false){
                                /* 選擇其他場次 */
                                $registration->id_events         = -99;             // 場次ID
                            }else{
                                $registration->id_events         = $events_group->id;             // 場次ID
                            }   

                            $registration->registration_join = $join;                         // 我想參加課程
                            
                            if(strpos($array_group, 'other') === false){
                                $registration->id_group          = $data_group;                     // 群組ID
                            }   

                            $registration->pay_date          = null;                            // 付款日期
                            $registration->pay_memo          = '';                            // 付款備註
                            $registration->person            = '';                            // 服務人員
                            $registration->type_invoice      = $type_invoice;                 // 統一發票
                            $registration->number_taxid      = $number_taxid;                 // 統編
                            $registration->companytitle      = $companytitle;                 // 抬頭
                            $registration->source_events     = $source_events;          
                            // $registration->datasource        = $datasource;          
                            $registration->submissiondate    = $submissiondate;                                    // 來源場次ID
                            
                            $registration->save();
                            $id_registration = $registration->id;
                        // }

                            // //更新場次訊息成本
                            // if( $datasource == 'SMS'){
                            //     EventsCourse::where('id_group', $id_group)
                            //                 ->update([
                            //                     'cost_message' => DB::raw('cost_message+1'),
                            //                 ]);
                            // }
                    } else {
                        foreach ($check_registration as $data) {
                            $id_registration = $data ->id;
                        }

                        if(strpos($array_group, 'other') !== false){
                            /* 選擇其他場次 */
                            
                            //更新報名資料
                            Registration::where('id_student', $id_student)
                                        ->where('id_course', $data_group)
                                        ->where('id_events', -99)
                                        ->update([
                                            'submissiondate' => $submissiondate,
                                            'type_invoice' => $type_invoice,
                                            'number_taxid' => $number_taxid,
                                            'companytitle' => $companytitle,
                                            'registration_join' => $join,
                                        ]);

                        }else{
                            //更新報名資料
                            Registration::where('id_student', $id_student)
                                        ->where('id_group', $data_group)
                                        ->update([
                                            'submissiondate' => $submissiondate,
                                            'type_invoice' => $type_invoice,
                                            'number_taxid' => $number_taxid,
                                            'companytitle' => $companytitle,
                                            'registration_join' => $join,
                                        ]);
                        }
                    }
                


                
                    /*正課報名資料 - E*/




                    if(strpos($array_group, 'other') === false){
                        // /*報到資料 - S*/
                        // // 檢查是否報名過
                        // $check_register = Register::where('id_registration', $id_registration)
                        //                         ->get();
                                                
                        // if (count($check_register) == 0 && $id_student != "" && $id_registration != "" && $id_registration != 0) {

                        //     $events_group = EventsCourse::where('id_group', $data_group)->get();
                            
                        //     foreach( $events_group as $data_group){
                        //         // 報到資料
                        //         $register = new Register;
                        //         // $date = date('Y-m-d H:i:s');

                        //         $register->id_registration   = $id_registration;      // 報名ID
                        //         $register->id_student        = $id_student;           // 學員ID
                        //         $register->id_status         = 1;                     // 報名狀態ID
                        //         $register->id_events         = $data_group['id'];     // 場次ID               
                        //         $register->memo              = '';                    // 備註
                            
                        //         $register->save();
                        //         $id_register = $register->id;
                        //     }
                                
                        // }else{
                        //     foreach ($check_register as $data) {
                        //         $id_register = $data ->id;
                        //     }
                        // }

                        // /*報到資料 - E*/


                        /*繳款資料 - S*/

                        // 檢查是否報名過
                        $check_payment = Payment::where('id_registration', $id_registration)
                                                ->get();

                        if ( count($check_payment) == 0 && $id_student != "" && $id_registration != "" && $id_registration != 0) {
                            // 新增繳款資料
                            $payment = new Payment;

                            $payment->id_student     = $id_student;      // 學員ID
                            $payment->cash           = $cash;            // 付款金額
                            $payment->pay_model      = $pay_model;       // 付款方式
                            $payment->number         = $number;          // 卡號後四碼
                            $payment->id_registration     = $id_registration;      // 報名ID
                            
                            
                            $payment->save();
                            $id_payment = $payment->id;
                        }else{
                            foreach ($check_payment as $data) {
                                $id_payment = $data ->id;
                            }

                            // //更新付款資料
                            // Payment::where('id_registration', $id_registration)
                            //         ->update([
                            //             'cash' => $cash,
                            //             'pay_model' => $pay_model,
                            //             'number' => $number,
                            //         ]);
                        }
                        
                        
                        /*繳款資料 - E*/


                        /*追單資料 - S*/
                        
                        //檢查是否報名過
                        $check_debt = Debt::where('id_registration', $id_registration)
                                        ->get();

                        if ( count($check_debt) == 0 && $id_student != "" && $id_registration != "" && $id_registration != 0) {
                            // 新增追單資料
                            $debt = new Debt;

                            $name_course = Registration::join('course', 'course.id', '=', 'registration.id_course')
                                                    ->select('course.name as name')
                                                    ->where('registration.id', $id_registration)
                                                    ->first();

                            $debt->id_student       = $id_student;          // 學員ID
                            $debt->id_status        = 1;                   // 最新狀態ID
                            $debt->name_course      = $name_course->name;   // 追款課程
                            $debt->status_payment   = '';                   // 付款狀態/日期
                            $debt->contact          = '';                   // 聯絡內容
                            $debt->person           = '';                   // 追單人員
                            $debt->remind_at        = '';                   // 提醒
                            $debt->id_registration  = $id_registration;     // 報名表ID

                            $debt->save();
                            $id_debt = $debt->id;
                        }else{
                            foreach ($check_debt as $data) {
                                $id_debt = $data ->id;
                            }
                        }
                    }else{
                        // $id_register = 0;
                        $id_payment = 0;
                        $id_debt = 0;
                    }
                    /*追單資料 - E*/

                    if ($id_student != "" && $id_registration != "" && $id_payment != "" && $id_debt != "") {
                        $success++;
                    } 

                    
                    $id_course = Registration::where('id', $id_registration)->first()->id_course;
                    if( $id_course != -99 ){
                        $course_name = Course::where('id', $id_course)->first()->name;
                        array_push($course, $course_name);
                    }
                }
                
                // return array('status'=>'success', 'course' => implode(" 及 ",$course));
                
                // return 'success';
            }else{
                /*正課報名資料 - S*/
                // 檢查是否報名過
                $check_registration = Registration::where('id_student', $id_student)
                                                ->where('source_events', $source_events)
                                                ->get();

                if (count($check_registration) == 0 && $id_student != "") {

                        // 新增正課報名資料
                        $registration = new Registration;

                        $registration->id_student        = $id_student;                   // 學員ID
                        $registration->id_course         = -99;                           // 課程ID
                        // $registration->id_status         = 1;                             // 報名狀態ID
                        // $registration->id_payment        = $id_payment;                   // 繳款明細ID
                        $registration->amount_payable    = '';                            // 應付金額
                        #// $registration->amount_paid       = '';                            // 已付金額
                        // $registration->memo              = '';                            // 備註
                        $registration->sign              = $sign;                            // 簽名檔案
                        $registration->status_payment    = 6;                             // 付款狀態
                        $registration->status_payment_original    = 6;                             // 原始付款狀態
                        $registration->id_events         = -99;                           // 場次ID
                        $registration->registration_join = $join;                         // 我想參加課程
                        $registration->id_group          = null;                            // 群組ID
                        $registration->pay_date          = null;                          // 付款日期
                        $registration->pay_memo          = '';                            // 付款備註
                        $registration->person            = '';                            // 服務人員
                        $registration->type_invoice      = $type_invoice;                 // 統一發票
                        $registration->number_taxid      = $number_taxid;                 // 統編
                        $registration->companytitle      = $companytitle;                 // 抬頭
                        $registration->source_events     = $source_events;                 // 來源場次
                        // $registration->datasource        = $datasource;                    // 表單來源
                        $registration->submissiondate    = $submissiondate;                // 報名日期
                        
                        $registration->save();
                        $id_registration = $registration->id;
                    // }
                        
                } else {
                    foreach ($check_registration as $data) {
                        $id_registration = $data ->id;
                    }

                    //更新報名資料
                    Registration::where('id_student', $id_student)
                                ->where('source_events', $source_events)
                                ->update([
                                    'submissiondate' => $submissiondate,
                                    'type_invoice' => $type_invoice,
                                    'number_taxid' => $number_taxid,
                                    'companytitle' => $companytitle,
                                    'registration_join' => $join,
                                ]);
                }
                /*正課報名資料 - E*/

                /*繳款資料 - S*/

                // 檢查是否報名過
                $check_payment = Payment::where('id_registration', $id_registration)
                                        ->get();

                if ( count($check_payment) == 0 && $id_student != "" && $id_registration != "" && $id_registration != 0) {
                    // 新增繳款資料
                    $payment = new Payment;

                    $payment->id_student     = $id_student;      // 學員ID
                    $payment->cash           = $cash;            // 付款金額
                    $payment->pay_model      = $pay_model;       // 付款方式
                    $payment->number         = $number;          // 卡號後四碼
                    $payment->id_registration     = $id_registration;      // 報名ID
                    
                    
                    $payment->save();
                    $id_payment = $payment->id;
                }else{
                    foreach ($check_payment as $data) {
                        $id_payment = $data ->id;
                    }

                    // //更新付款資料
                    // Payment::where('id_registration', $id_registration)
                    //         ->update([
                    //             'cash' => $cash,
                    //             'pay_model' => $pay_model,
                    //             'number' => $number,
                    //         ]);
                }
                
                
                /*繳款資料 - E*/


                /*追單資料 - S*/
                
                //檢查是否報名過
                $check_debt = Debt::where('id_registration', $id_registration)
                                ->get();

                if ( count($check_debt) == 0 && $id_student != "" && $id_registration != "" && $id_registration != 0) {
                    // 新增追單資料
                    $debt = new Debt;

                    $name_course = Registration::join('course', 'course.id', '=', 'registration.id_course')
                                            ->select('course.name as name')
                                            ->where('registration.id', $id_registration)
                                            ->first();

                    $debt->id_student       = $id_student;          // 學員ID
                    $debt->id_status        = 1;                   // 最新狀態ID
                    $debt->name_course      = '';   // 追款課程
                    $debt->status_payment   = '';                   // 付款狀態/日期
                    $debt->contact          = '';                   // 聯絡內容
                    $debt->person           = '';                   // 追單人員
                    $debt->remind_at        = '';                   // 提醒
                    $debt->id_registration  = $id_registration;     // 報名表ID
                    
                    $debt->save();
                    $id_debt = $debt->id;
                }else{
                    foreach ($check_debt as $data) {
                        $id_debt = $data ->id;
                    }
                }

                /*追單資料 - E*/


                $id_course = Registration::where('id', $id_registration)->first()->id_course;
                if( $id_course != -99 ){
                    $course_name = Course::where('id', $id_course)->first()->name;
                    array_push($course, $course_name);
                }
                // return 'success';
            }
                
            return array('status'=>'success', 'course' => implode(" 及 ",$course));
        
        }catch (Exception $e) {
            return array('status'=>'error');
            // return 'error';
            // return json_encode(array(
            //     'errorMsg' => '儲存失敗'
            // ));
        }
        
    }

    //  // joanna 下載電子簽章圖片
    //  public function signature(Request $request) {
    //     $base64Str = str_replace('data:image/png;base64,', '', $request['imgBase64']);
    //     $image = base64_decode($base64Str);
    //     $saveName = "signature-".time().".".'png';
    //     $success = file_put_contents(public_path().'/sign/'.$saveName, $image) ? 'success save' : 'fail save';

    //     return $success ;
    //  }
}
