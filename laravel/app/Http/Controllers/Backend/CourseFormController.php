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

class CourseFormController extends Controller
{
    // Sandy (2020/02/28)
    public function insert(Request $request)
    {
        //讀取data
        // $date = $request->get('idate');
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
        $id_group =  $request->get('id_group');
        
        $source_events =  $request->get('source_events');
        


        /*學員報名資料 - S*/

        //判斷系統是否已有該學員資料
        $check_student = Student::where('phone', $phone)->get();

        // 檢查學生資料
        if (count($check_student) != 0) {
            foreach ($check_student as $data_student) {
                $id_student = $data_student ->id;
            }
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
            if ($address != "") {
                $student->address       = $address;  // 居住地
            }
            
            $student->save();
            $id_student = $student->id;
        }
        /*學員報名資料 - E*/



        /*正課報名資料 - S*/

        // $events_group = EventsCourse::where('id_group', $id_group)->get();

        $success = 0;

        foreach ($id_group as $data_group) {
            // 檢查是否報名過
            $check_registration = Registration::where('id_student', $id_student)
                                            ->where('id_group', $data_group)
                                            ->get();

            if (count($check_registration) == 0 && $id_student != "") {

                $events_group = EventsCourse::where('id_group', $data_group)->orderBy('id', 'desc')->first();

                // foreach( $events_group as $data_group){
                    // 新增正課報名資料
                    $registration = new Registration;
                    // $date = date('Y-m-d H:i:s');

                    $registration->id_student        = $id_student;                   // 學員ID
                    $registration->id_course         = $events_group->id_course;      // 課程ID
                    // $registration->id_status         = 1;                             // 報名狀態ID
                    // $registration->id_payment        = $id_payment;                   // 繳款明細ID
                    $registration->amount_payable    = '';                            // 應付金額
                    #// $registration->amount_paid       = '';                            // 已付金額
                    // $registration->memo              = '';                            // 備註
                    $registration->sign              = '';                            // 簽名檔案
                    $registration->status_payment    = 6;                             // 付款狀態
                    $registration->id_events         = $events_group->id;             // 場次ID
                    $registration->registration_join = $join;                         // 我想參加課程
                    $registration->id_group          = $data_group;                     // 群組ID
                    $registration->pay_date          = null;                            // 付款日期
                    $registration->pay_memo          = '';                            // 付款備註
                    $registration->person            = '';                            // 服務人員
                    $registration->type_invoice      = $type_invoice;                 // 統一發票
                    $registration->number_taxid      = $number_taxid;                 // 統編
                    $registration->companytitle      = $companytitle;                 // 抬頭
                    $registration->source_events     = $source_events;                           // 來源場次ID
                    
                    $registration->save();
                    $id_registration = $registration->id;
                // }
                    
            } else {
                foreach ($check_registration as $data) {
                    $id_registration = $data ->id;
                }
            }
        


        
            /*正課報名資料 - E*/




            /*報到資料 - S*/

            // 檢查是否報名過
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


            /*繳款資料 - S*/

            // 檢查是否報名過
            $check_payment = Payment::where('id_registration', $id_registration)
                                    ->get();

            if ( count($check_payment) == 0 && $id_student != "" && $id_registration != "" && $id_registration != 0) {
                // 新增繳款資料
                $payment = new Payment;

                $payment->id_student     = $id_student;      // 學員ID
                if($cash == ""){
                    $payment->cash       = '';            // 付款金額
                }else {
                    $payment->cash           = $cash;            // 付款金額
                }
                $payment->pay_model      = $pay_model;       // 付款方式
                if($number == ""){
                    $payment->number         = $number;          // 卡號後四碼
                }else {
                    $payment->number         = $number;          // 卡號後四碼
                }
                $payment->id_registration     = $id_registration;      // 報名ID
                
                
                $payment->save();
                $id_payment = $payment->id;
            }else{
                foreach ($check_payment as $data) {
                    $id_payment = $data ->id;
                }
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


            if ($id_student != "" && $id_registration != "" && $id_register != "" && $id_payment != "" && $id_debt != "") {
                // return redirect()->route('course_form', ['id' => $id_course])->with('status', '報名成功');
                $success++;
            } 

        }
        /*追單資料 - E*/

        if ($success == count($id_group)) {
            // return redirect()->route('course_form', ['id' => $id_course])->with('status', '報名成功');
            return 'success';
        } else {
            // return redirect()->route('course_form', ['id' => $id_course])->with('status', '報名失敗');
            return 'error';
        }
    }

     // joanna 下載電子簽章圖片
     public function signature(Request $request) {
        $base64Str = str_replace('data:image/png;base64,', '', $request['imgBase64']);
        $image = base64_decode($base64Str);
        $saveName = "signature-".time().".".'png';
        $success = file_put_contents(public_path().'/sign/'.$saveName, $image) ? 'success save' : 'fail save';

        return $success ;
     }
}
