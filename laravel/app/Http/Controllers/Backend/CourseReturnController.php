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
use App\Model\Refund;
use App\Model\Debt;
// use Mail;
// use App\Model\Message;
// use App\Model\Receiver;

class CourseReturnController extends Controller
{
    
    // Sandy (2020/03/22)
    public function insert_data(Request $request)
    {
        
        $id_group = array();

        //讀取data
        $submissiondate = date('Y-m-d H:i:s',strtotime($request->get('idate')));
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
        $istatus = $request->get('istatus');

        $amount_payable = $request->get('ipayable');
        $pay_date = $request->get('ipaydate');
        $person = $request->get('iperson');
        $pay_memo = $request->get('ipaymemo');

        $events_len =  $request->get('events_len');
        for($i = 0 ; $i < $events_len ; $i++){
            if(!empty($request->get('ievent'.$i))){
                $event =$request->get('ievent'.$i);
                array_push($id_group, $event);
            }
        }
        
        $id_events =  $request->get('form_event_id');
        
        $source_events =  $request->get('form_event_id');
        
        
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

            /*學員報名資料 - S*/

            //判斷系統是否已有該學員資料
            $check_student = Student::where('name', $name)
                                    ->where('phone', $phone)
                                    ->where('email', $email)
                                    ->get();

            // 檢查學員資料
            if (count($check_student) != 0) {
                foreach ($check_student as $data_student) {
                    $id_student = $data_student ->id;
                }
                //更新學員資料
                Student::where('id', $id_student)
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

        
            if(!empty($id_group)){
                
                $success = 0;

                foreach ($id_group as $key => $array_group) {

                    $data_group ='';

                    if(strpos($array_group, 'other') !== false){
                        /* 選擇其他場次 */

                        $data_group = $request->get($array_group);

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
                            $registration->amount_payable    = $amount_payable;                            // 應付金額
                            #// $registration->amount_paid       = '';                            // 已付金額
                            // $registration->memo              = '';                            // 備註
                            $registration->sign              = '';                             // 簽名檔案
                            $registration->status_payment    = $istatus;                       // 付款狀態
                            $registration->status_payment_original    = $istatus;              //原始付款狀態 

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

                            $registration->pay_date          = $pay_date;                            // 付款日期
                            $registration->pay_memo          = $pay_memo;                            // 付款備註
                            $registration->person            = $person;                            // 服務人員
                            $registration->type_invoice      = $type_invoice;                 // 統一發票
                            $registration->number_taxid      = $number_taxid;                 // 統編
                            $registration->companytitle      = $companytitle;                 // 抬頭
                            $registration->source_events     = $source_events;          
                            $registration->submissiondate    = $submissiondate;                    
                        
                            
                            $registration->save();
                            $id_registration = $registration->id;
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
                                            'amount_payable' => $amount_payable,
                                            'pay_date' => $pay_date,
                                            'person' => $person,
                                            'pay_memo' => $pay_memo,
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
                                            'amount_payable' => $amount_payable,
                                            'pay_date' => $pay_date,
                                            'person' => $person,
                                            'pay_memo' => $pay_memo,
                                        ]);
                        }
                    }
                


                
                    /*正課報名資料 - E*/




                    if(strpos($array_group, 'other') !== false){
                        /* 選擇其他場次 */

                        // $id_register = 0;
                        // $id_payment = 0;
                        // $id_debt = 0;


                        /*繳款資料 - S*/

                        if( $cash != 0 ){
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
                        }else{
                            $id_payment = 0;
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
                            // $debt->id_events        = $id_registration;     // 場次ID
                            
                            // 付款狀態名稱
                            switch ($istatus) {
                                case 6:
                                    $debt->status_payment_name  = '留單'; 
                                    break;
                                case 7:
                                    $debt->status_payment_name  = '完款'; 
                                    break;
                                case 8:
                                    $debt->status_payment_name  = '付訂'; 
                                    break;
                                case 9:
                                    $debt->status_payment_name  = '退款'; 
                                    break;
                                default:
                                    break;
                            }
                            
                            $debt->save();
                            $id_debt = $debt->id;
                        }else{
                            foreach ($check_debt as $data) {
                                $id_debt = $data ->id;
                            }
                        }
                        /*追單資料 - E*/
                        
                    }else{
                        /* 有選擇場次 */


                        //如果付款狀態為完款則新增報到資料
                        if( $istatus == 7 ){
                            /*報到資料 - S*/
                            //檢查是否報名過
                            $check_register = Register::where('id_registration', $id_registration)
                                                    ->get();
                                                    
                            if (count($check_register) == 0 && $id_student != "" && $id_registration != "" && $id_registration != 0) {

                                $events_group = EventsCourse::where('id_group', $data_group)->get();
                                
                                foreach( $events_group as $data_group){
                                    // 報到資料
                                    $register = new Register;
                                    // $date = date('Y-m-d H:i:s');

                                    $register->id_registration   = $id_registration;      // 報名ID
                                    $register->id_student        = $id_student;           // 學員ID
                                    $register->id_status         = 1;                     // 報名狀態ID
                                    $register->id_events         = $data_group['id'];     // 場次ID               
                                    $register->memo              = '';                    // 備註
                                
                                    $register->save();
                                    $id_register = $register->id;
                                }
                                    
                            }else{
                                foreach ($check_register as $data) {
                                    $id_register = $data ->id;
                                }
                            }

                            /*報到資料 - E*/
                        }
                        

                        /*繳款資料 - S*/

                        if( $cash != 0 ){
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
                        }else{
                            $id_payment = 0;
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
                            // $debt->id_events        = $id_registration;     // 場次ID
                            
                            // 付款狀態名稱
                            switch ($istatus) {
                                case 6:
                                    $debt->status_payment_name  = '留單'; 
                                    break;
                                case 7:
                                    $debt->status_payment_name  = '完款'; 
                                    break;
                                case 8:
                                    $debt->status_payment_name  = '付訂'; 
                                    break;
                                case 9:
                                    $debt->status_payment_name  = '退款'; 
                                    break;
                                default:
                                    break;
                            }
                            
                            $debt->save();
                            $id_debt = $debt->id;
                        }else{
                            foreach ($check_debt as $data) {
                                $id_debt = $data ->id;
                            }
                        }
                        /*追單資料 - E*/
                    }

                    if ($id_student != "" && $id_registration != "" && $id_payment != "" && $id_debt != "") {
                        $success++;
                    } 

                }
                
                return redirect()->route('course_return', ['id' => $id_events])->with('status', '報名成功');
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
                    $registration->amount_payable    = $amount_payable;                            // 應付金額
                    #// $registration->amount_paid       = '';                            // 已付金額
                    // $registration->memo              = '';                            // 備註
                    $registration->sign              = '';                            // 簽名檔案
                    $registration->status_payment             = $istatus;             // 付款狀態
                    $registration->status_payment_original    = $istatus;             //原始付款狀態 
                    $registration->id_events         = -99;                           // 場次ID
                    $registration->registration_join = $join;                         // 我想參加課程
                    $registration->id_group          = null;                          // 群組ID
                    $registration->pay_date          = $pay_date;                          // 付款日期
                    $registration->pay_memo          = $pay_memo;                            // 付款備註
                    $registration->person            = $person;                            // 服務人員
                    $registration->type_invoice      = $type_invoice;                 // 統一發票
                    $registration->number_taxid      = $number_taxid;                 // 統編
                    $registration->companytitle      = $companytitle;                 // 抬頭
                    $registration->source_events     = $source_events;                 // 抬頭
                    $registration->submissiondate    = $submissiondate;                // 報名日期
                    
                    $registration->save();
                    $id_registration = $registration->id;
                        
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
                                    'amount_payable' => $amount_payable,
                                    'pay_date' => $pay_date,
                                    'person' => $person,
                                    'pay_memo' => $pay_memo,
                                ]);
                }
                /*正課報名資料 - E*/



                /*繳款資料 - S*/

                if( $cash != 0 ){
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
                    }
                }else{
                    $id_payment = 0;
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
                    $debt->name_course      = '';                   // 追款課程
                    $debt->status_payment   = '';                   // 付款狀態/日期
                    $debt->contact          = '';                   // 聯絡內容
                    $debt->person           = '';                   // 追單人員
                    $debt->remind_at        = '';                   // 提醒
                    $debt->id_registration  = $id_registration;     // 報名表ID

                    // 付款狀態名稱
                    switch ($istatus) {
                        case 6:
                            $debt->status_payment_name  = '留單'; 
                            break;
                        case 7:
                            $debt->status_payment_name  = '完款'; 
                            break;
                        case 8:
                            $debt->status_payment_name  = '付訂'; 
                            break;
                        case 9:
                            $debt->status_payment_name  = '退款'; 
                            break;
                        default:
                            break;
                    }
                    
                    $debt->save();
                    $id_debt = $debt->id;
                }else{
                    foreach ($check_debt as $data) {
                        $id_debt = $data ->id;
                    }
                }

                /*追單資料 - E*/


                return redirect()->route('course_return', ['id' => $id_events])->with('status', '報名成功');
            }
        
        }catch (Exception $e) {
            return redirect()->route('course_return', ['id' => $id_events])->with('status', '報名失敗');
        }
    }

    // Sandy (2020/06/27)
    public function edit_data(Request $request)
    {
        //讀取data
        $id_events = $request->get('edit_idevents');
        $id = $request->get('edit_id');
        $submissiondate = $request->get('edit_date');
        $phone = $request->get('edit_phone');
        $name = $request->get('edit_name');
        $sex = $request->get('edit_sex');
        $id_identity = $request->get('edit_identity');
        $email = $request->get('edit_email');
        $birthday = $request->get('edit_birthday');
        $company = $request->get('edit_company');
        $profession = $request->get('edit_profession');
        $address = $request->get('edit_address');
        $join = $request->get('edit_join');
        // $pay_model = $request->get('ipay_model');
        // $cash = $request->get('icash');
        // $number = $request->get('inumber');
        $type_invoice = $request->get('edit_invoice');
        $number_taxid = $request->get('edit_num');
        $companytitle = $request->get('edit_companytitle');
        $status_payment_original = $request->get('edit_status');

        $events = $request->get('edit_events');
        $edit_collapse = $request->get('edit_collapse_val');
        
        /* 防錯 */
        if($address == ""){
            $address = ""; 
        }

        try{

            /*學員報名資料 - S*/

            //判斷系統是否已有該學員資料
            $check_student = Student::where('name', $name)
                                    ->where('phone', $phone)
                                    ->where('email', $email)
                                    ->get();

            $id_student = "";

            // 檢查學員資料
            if (count($check_student) != 0) {

                $id_student = Student::where('name', $name)
                                    ->where('phone', $phone)
                                    ->where('email', $email)
                                    ->first()->id;

                if($name == ""){
                    $name = Student::where('id', $id_student)->first()->name;
                }
                if($sex == ""){
                    $sex = Student::where('id', $id_student)->first()->sex;
                }
                if($id_identity == ""){
                    $id_identity = Student::where('id', $id_student)->first()->id_identity;
                }
                if($email == ""){
                    $email = Student::where('id', $id_student)->first()->email;
                }
                if($birthday == ""){
                    $birthday = Student::where('id', $id_student)->first()->birthday;
                }
                if($company == ""){
                    $company = Student::where('id', $id_student)->first()->company;
                }
                if($profession == ""){
                    $profession = Student::where('id', $id_student)->first()->profession;
                }
                if($address == ""){
                    $address = Student::where('id', $id_student)->first()->address;
                }

                //更新學員資料
                Student::where('id', $id_student)
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
            } 
            /*學員報名資料 - E*/


            /*正課報名資料 - S*/

            //判斷系統是否已有該正課報名資料
            $check_registration = Registration::where('id', $id)->get();

            // 檢查正課報名資料
            if (count($check_registration) != 0) {

                // if($submissiondate == ""){
                //     $submissiondate = Registration::where('id', $id)->first()->submissiondate;
                // }
                // if($type_invoice == ""){
                //     $type_invoice = Registration::where('id', $id)->first()->type_invoice;
                // }
                // if($number_taxid == ""){
                //     $number_taxid = Registration::where('id', $id)->first()->number_taxid;
                // }
                // if($companytitle == ""){
                //     $companytitle = Registration::where('id', $id)->first()->companytitle;
                // }
                // if($join == ""){
                //     $join = Registration::where('id', $id)->first()->join;
                // }


                $registration = Registration::where('id', $id)->first();

                //判斷是否有選擇場次
                if( $events != "" && $edit_collapse != 0){
                    if( strpos( $events ,'edit_events')  !== false ){
                        //選擇某場次

                        //判斷選擇場次是否跟報名表一致
                        if( substr($events, 11) != $registration['id_group']){
                            //不一致則更新
                            $update_group = substr($events, 11);
                            $events_group = EventsCourse::where('id_group', $update_group)->get();
                            
                            if( !empty($events_group) ){
                                $update_course = EventsCourse::where('id_group', $update_group)->orderby('course_start_at','desc')->first()->id_course;
                                
                                $update_events = EventsCourse::where('id_group', $update_group)->orderby('course_start_at','desc')->first()->id;
                                
                                Registration::where('id', $id)->update([
                                    'id_course' => $update_course,
                                    'id_group' => $update_group,
                                    'id_events' => $update_events,
                                ]);  

                                //刪除報到表
                                Register::where('id_registration', $id)->delete();

                                foreach( $events_group as $data_group){
                                    // 報到資料
                                    $register = new Register;
                                    // $date = date('Y-m-d H:i:s');

                                    $register->id_registration   = $id;      // 報名ID
                                    $register->id_student        = $id_student;           // 學員ID
                                    $register->id_status         = 1;                     // 報名狀態ID
                                    $register->id_events         = $data_group['id'];     // 場次ID               
                                    $register->memo              = '';                    // 備註
                                
                                    $register->save();
                                    $id_register = $register->id;
                                }
                            }
                            
                        }

                    }

                    if( strpos( $events ,'edit_other')  !== false ){
                        //選擇某課程的"我要選擇其他場次"

                        //判斷選擇課程是否跟報名表一致
                        if( substr($events, 10) != $registration['id_course']){
                            //不一致則更新
                                
                            $update_course = substr($events, 10);

                            Registration::where('id', $id)->update([
                                'id_course' => $update_course,
                                'id_group' => -99,
                                'id_events' => -99,
                            ]);  

                        }else{

                            Registration::where('id', $id)->update([
                                'id_group' => -99,
                                'id_events' => -99,
                            ]); 
                        }

                        //刪除報到表
                        Register::where('id_registration', $id)->delete();
                    }
                }

                Registration::where('id', $id)->update([
                    'submissiondate' => $submissiondate,
                    'type_invoice' => $type_invoice,
                    'number_taxid' => $number_taxid,
                    'companytitle' => $companytitle,
                    'registration_join' => $join,
                    'status_payment_original' => $status_payment_original,
                ]);                     
           }
        
            /*正課報名資料 - E*/
            
            
            return redirect()->route('course_return', ['id' => $id_events])->with('status', '修改成功');
        
        }catch (Exception $e) {
            return redirect()->route('course_return', ['id' => $id_events])->with('status', '修改失敗');
        }
    }

    /*** 新增付款資料 ***/
    public function insert_payment(Request $request)
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
                if($number != ""){
                    $payment->number            = $number;                              // 帳戶/卡號後四碼
                }
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
                    case 4:
                        $pay_model_data = '現金分期';
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
                    //付款狀態
                    $data_id = $request->input('data_id');
                    
                    Registration::where('id', $data_id)
                                ->update(['status_payment' => $data_val]);

                    if( $data_val == 7){
                        /* 完款新增報到資料 - S*/
                        // 檢查是否報名過
                        $check_register = Register::where('id_registration', $data_id)
                                                ->get();
                                                
                        if ( count($check_register) == 0 ) {

                            $registration = Registration::where('id', $data_id)->first();
                            $events_group = EventsCourse::where('id_group', $registration->id_group)->get();

                            foreach( $events_group as $data_group){
                                // 報到資料
                                $register = new Register;
                                // $date = date('Y-m-d H:i:s');

                                $register->id_registration   = $data_id;                     // 報名ID
                                $register->id_student        = $registration->id_student;    // 學員ID
                                $register->id_status         = 1;                            // 報名狀態ID
                                $register->id_events         = $data_group['id'];     // 場次ID               
                                $register->memo              = '';                           // 備註
                            
                                $register->save();
                                $id_register = $register->id;
                            }
                                
                        }

                        /*完款新增報到資料 - E*/
                    }else{
                        Register::where('id_registration', $data_id)->delete();
                    }


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

    // 刪除資料 Sandy (2020/06/26)
    public function delete_data(Request $request)
    {
        $status = "";
        $id_apply = $request->get('id_apply');
            
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
        
         return json_encode(array('data' => $status));
    }

    
    // 刪除付款 Sandy (2020/03/22)
    public function delete_payment(Request $request)
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

    // /**
    //  * 發送訊息
    //  */
    // public function sendmsg(Request $request)
    // {
    //     $id = $request->get('id');
    //     $course = "";
    //     $id_course = null;
    //     $id_teacher = null;

    //     /* 報名資訊 */
    //     $registration = Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
    //                                 ->where('registration.id', $id)
    //                                 ->first();
                        
   
    //     if( $registration->id_course != -99 && $registration->id_course != '' && $registration->id_course != null){
    //         //有選擇課程

    //         $id_course = $registration->id_course;
    //         $id_teacher = Course::where('id', $registration->id_course)
    //                         ->first()->id_teacher;
            
    //         $course = Course::where('id', $registration->id_course)
    //                         ->first()->name;
                            
    //         // if( $registration->id_group != null || $registration->id_group != ''){
    //         //     //有選擇場次

    //         //     $course = Course::leftjoin('events_course', 'events_course.id_course', '=', 'course.id')
    //         //                     ->where('course.id', $registration->id_course)
    //         //                     ->first();

    //             // $course_group = EventsCourse::Where('id_group', $registration->id_group)
    //             //                             ->get();
                                            
    //             // $numItems = count($course_group);
    //             // $i = 0;

    //             // $events = '';

    //             // foreach( $course_group as $key_group => $data_group ){
    //             //     //日期
    //             //     $date = date('Y-m-d', strtotime($data_group['course_start_at']));
    //             //     //星期
    //             //     $weekarray = array("日","一","二","三","四","五","六");
    //             //     $week = $weekarray[date('w', strtotime($data_group['course_start_at']))];
                    
    //             //     if( ++$i === $numItems){
    //             //         $events .= $date . '(' . $week . ')';
    //             //     }else {
    //             //         $events .= $date . '(' . $week . ')' . '、';
    //             //     }
    //             // }

                

    //         // }else{
    //         //     //無選擇場次

    //         // }
            
    //         $content =  "恭喜您成功報名 ". $course . "<br>" .
    //                     "請點選以下連結選擇報名課程及場次" . "<br>" .
    //                     "<a href='" . route('message_form', ['id' => $id]) . "'>" . route('message_form', ['id' => $id]) . "</a>";
    //                     // "歡迎揪您的親朋好友一起學習!<br>"+
    //                     // "[場地座位有限，若要來現場請先填好報名表保留座位!]<br>"+
    //                     // "請點以下連結加入Line@，掌握第一手課程資訊~!<br>"+
    //                     // "<a href='https://line.me/R/ti/p/%40hcw0100u'>https://line.me/R/ti/p/%40hcw0100u</a><br>"+
    //                     // "聯絡時間: 平日10:00 ~ 18:00<br>"+
    //                     // "上課前夕會以簡訊、E-mail做最後通知<br>"+
    //                     // "時間地點以最後通知為主哦<br>"+
    //                     // "提醒您，開課20分鐘後將無法進入教室。<br>"+
    //                     // "造成不便，敬請見諒!";
    //     }else{
    //         //無選擇課程
    //         // $id_course = $registration->id_course;
    //         // $id_teacher = Course::where('id', $registration->id_course)
    //         //                 ->first()->id_teacher;

    //         $content =  "恭喜您成功報名！" . "<br>" .
    //                     "請點選以下連結選擇報名課程及場次" . "<br>" .
    //                     "<a href='" . route('message_form', ['id' => $id]) . "'>" . route('message_form', ['id' => $id]) . "</a>";
                        
    //     }

    //     $student = Student::where('id', $registration->id_student)->first();


    //     if( !empty($student) ){
            
    //         //   contentStr : content,
    //         //   content : content.replace("\n", "<br>"),

    //         $send_at = date('YmdHis');
    //         $send_at_DB = date('Y-m-d H:i:s');
    //         $type = 0;
    //         $mailTitle = "";
    //         $msg_name = "自動訊息-成功報名" . $course ;

    //         //sms
    //         if( $student->phone != '' || $student->phone != null){
    //             $phoneNum = $student->phone;
    //             //單筆簡訊
    //             $sms = $this->messageApi($phoneNum, $content, $send_at);   
    //         }

    //         //email
    //         if( $student->email != '' || $student->email != null){
    //             $mailTitle = "恭喜您成功報名！";
    //             $mailAddr = $student->email;
    //             $email = $this->sendMail($mailAddr, $mailTitle, $content);
    //             $type = 2;
    //         }else{
    //             $email['status'] = "";
    //         }
            

                
    //         if( $sms['status'] != "error" && $email['status'] != "error"){
    //             //訊息儲存進資料庫
    //             $num = mb_strlen( strip_tags($content, "utf-8") );
    //             $sms_num = ceil($num/70);

    //             /* 新增訊息資料 */
    //             $message = new Message;

    //             // $message->id_student_group   = null;        // 細分組ID
    //             $message->type               = $type;                 // 類型
    //             $message->title              = $mailTitle;            // email標題
    //             $message->content            = $content;              // 內容               
    //             $message->send_at            = $send_at_DB;              // 寄送日期         
    //             $message->name               = $msg_name;                 // 訊息名稱          
    //             $message->id_teacher         = $id_teacher;           // 講師ID        
    //             $message->id_course          = $id_course;            // 課程ID    
    //             $message->id_status          = 19;            // 發送狀態      
    //             $message->sms_num            = $sms_num;                  // 簡訊封數   
            
    //             $message->save();
    //             $id_message = $message->id;
            
    //             if( $id_message != ""){
    //                 //收件人儲存進資料庫
                    
    //                 if( $type == 0){
    //                     //只有簡訊
    //                     /* 新增寄件資料 */
    //                     $receiver = new Receiver;

    //                     $receiver->id_message       = $id_message;     // 訊息ID
    //                     $receiver->id_student       = $registration->id_student;     // 學員ID               
    //                     $receiver->phone            = $phoneNum;       // 聯絡電話         
    //                     $receiver->email            = '';            // email         
    //                     $receiver->id_status        = 19;            // 發送狀態   
    //                     $receiver->memo             = '';                    // 備註
    //                     $receiver->msgid            = '';                // 簡訊序號       
                    
    //                     $receiver->save();

    //                 }else{
    //                     //簡訊&信箱
    //                     /* 新增寄件資料 */
    //                     $receiver = new Receiver;

    //                     $receiver->id_message       = $id_message;     // 訊息ID
    //                     $receiver->id_student       = $registration->id_student;     // 學員ID               
    //                     $receiver->phone            = $phoneNum;       // 聯絡電話         
    //                     $receiver->email            = $mailAddr;            // email         
    //                     $receiver->id_status        = 19;            // 發送狀態   
    //                     $receiver->memo             = '';                    // 備註
    //                     $receiver->msgid            = '';                // 簡訊序號       
                    
    //                     $receiver->save();
    //                 }
    //                 $id_receiver = $receiver->id;

    //                 if($id_receiver != "" ){
    //                     return 'success';
    //                 }
    //             }
    //         }
    //     }
    // }


    /**
     * 單筆簡訊發送
     */
    // public function messageApi($phoneNum, $sendContents, $dlvtime)
    // {
    //     $sendContents = str_replace("<br>", chr(6), $sendContents);

    //     try{

    //         $url = 'http://smsb2c.mitake.com.tw/b2c/mtk/SmSend?';
    //         $url .= '&username=0908916687';
    //         $url .= '&password=wjx2020';
    //         $url .= '&dstaddr='.$phoneNum;
    //         $url .= '&dlvtime='.$dlvtime;
    //         $url .= '&smbody='.urlencode(strip_tags($sendContents));
    //         // $url .= '&response='.route('');
    //         $url .= '&CharsetURL=UTF-8';
    //         $curl = curl_init();
    //         curl_setopt($curl, CURLOPT_URL, $url);
    //         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //         $output = curl_exec($curl);
    //         curl_close($curl);

    //         // $output = '[1]' . "\r\n";
    //         // $output .= 'msgid=0010698913' . "\r\n";
    //         // $output .= 'statuscode=1' . "\r\n";
    //         // // $output .= 'Error=v' . "\r\n";
    //         // $output .= 'AccountPoint=91666';
            
    //         // [1]
    //         // msgid=0010698913
    //         // statuscode=1
    //         // AccountPoint=91666

    //         // return $output;

    //     }catch(\Exception $e){
    //         return 'error: db insert.';
    //     }
         
        
    //     /* 切割簡訊Response */
    //     $output = preg_split("/[\s,]+/", $output);
    //     $array_output = [];

    //     /* 得到Response陣列 */
    //     foreach( $output as $data){
    //         $title = strstr($data, '=', true);
    //         if( strpos($data, '=') != false){
    //             $array_output += [
    //                 $title => substr($data, strlen($title)+1 )
    //             ];
    //         }
    //     }

    //     $msgid = '';
    //     //寄發簡訊成功
    //     if( !empty($array_output['msgid']) ){
    //         $msgid = $array_output['msgid'];
    //         $statuscode = $array_output['statuscode'];
            
    //         //驗證是否成功送達/預約簡訊
    //         $id_status = $this->verify($statuscode);

    //         switch ($id_status) {
    //             case 19:
    //                 //已傳送
    //                 return array(
    //                     'status'=>'success', 
    //                     'msg'=>'傳送成功', 
    //                     'phone'=> array($phoneNum), 
    //                     'AccountPoint'=>$array_output['AccountPoint'], 
    //                     'msgid'=> array($msgid)
    //                 );
    //                 break;
    //             case 21:
    //                 //已預約                    
    //                 return array('status'=>'success', 
    //                 'msg'=>'預約成功', 
    //                 'phone'=> array($phoneNum), 
    //                 'AccountPoint'=>$array_output['AccountPoint'], 
    //                 'msgid'=> array($msgid)
    //                 );
    //                 break;
    //             case 20:
    //                 //無法傳送
    //                 return array('status'=>'error', 'msg'=>'無法傳送');
    //                 break;
    //             default:
    //                 return array('status'=>'error', 'msg'=>'無法傳送');
    //                 break;
    //         }
    //     }else{
    //         return array('status'=>'error', 'msg'=>$array_output['Error']);
    //     }
    // }

    // /**
    //  * Mail
    //  */
    // public function sendMail($emailAddr, $mailTitle, $mailContents) 
    // {
    //     $mailContents = str_replace("\n", "<br>", $mailContents);
        
    //     Mail::send('frontend.testMail', ['content'=>$mailContents], function($message) use ($mailTitle, $emailAddr) {
    //         $message->subject($mailTitle);
    //         $message->to($emailAddr);
    //     });

    //     return array('status'=>'success', 'email'=> $emailAddr);

    // }
    
    // /**
    //  * 驗證寄送簡訊狀況
    //  */
    // public function verify($statuscode)
    // {
    //     $id_status = '';
    //     switch ($statuscode) {
    //         case '0':
    //             //預約傳送中
    //             $id_status = 21;
    //             break;
    //         case '1':
    //             //已送達業者
    //             $id_status = 19;
    //             break;
    //         case '2':
    //             //已送達業者
    //             $id_status = 19;
    //             break;
    //         case '4':
    //             //已送達手機
    //             $id_status = 19;
    //             break;
    //         case "v":
    //             //無效的手機號碼
    //             $id_status = 20;
    //             break;
    //         default:
    //             //傳送失敗
    //             $id_status = 20;
    //             break;
    //     }
    //     return $id_status;
    // }

}
