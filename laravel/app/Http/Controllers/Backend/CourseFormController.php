<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Student;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\Payment;
use App\Model\Registration;
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
        $id_group = explode(",", $request->get('id_group'));
        


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


        /*繳款資料 - S*/

        if ( $id_student != '') {
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
            $payment->person         = '';               // 服務人員
            $payment->type_invoice   = $type_invoice;    // 統一發票
            $payment->number_taxid   = $number_taxid;    // 統編
            $payment->companytitle   = $companytitle;    // 抬頭
            
            $payment->save();
            $id_payment = $payment->id;
        }
        
        
        /*繳款資料 - E*/


        /*正課報名資料 - S*/

        $events_group = EventsCourse::where('id_group', $id_group)->get();

        foreach( $events_group as $data_group){
            
            // 檢查是否報名過
            $check_registration = Registration::where('id_student', $id_student)
                                                ->where('id_events', $data_group['id'])
                                                ->get();

            if (count($check_registration) == 0 && $id_student != "" && $id_payment != "") {
                // 新增正課報名資料
                $registration = new Registration;
                // $date = date('Y-m-d H:i:s');

                $registration->id_student      = $id_student;          // 學員ID
                $registration->id_course       = $data_group['id_course'];           // 課程ID
                $registration->id_status       = 1;                    // 報名狀態ID
                $registration->id_payment      = $id_payment;          // 繳款明細ID
                $registration->amount_payable       = '';              // 應付金額
                $registration->amount_paid          = '';              // 已付金額
                $registration->memo  = '';                             // 備註
                $registration->sign  = '';                             // 簽名檔案
                $registration->status_payment  = 6;                             // 付款狀態
                $registration->id_events       = $data_group['id'];           // 場次ID
                $registration->registration_join       = $join;           // 我想參加課程
                
                $registration->save();
                $id_registration = $registration->id;
                
            } else {
                // foreach ($check_registration as $data_registration) {
                //     $id_registration = $data_registration ->id;
                // }
                $id_registration = 0;
            }
    
        }

    
        /*正課報名資料 - E*/

        /*追單資料 - S*/
        if ($id_student != "" && $id_payment != "" && $id_registration != "" && $id_registration != 0) {
            // 新增追單資料
            $debt = new Debt;

            $debt->id_student       = $id_student;          // 學員ID
            $debt->id_status        = 1;                    // 最新狀態ID
            $debt->name_course      = '60天財富計畫';        // 追款課程
            $debt->status_payment   = '';                   // 付款狀態/日期
            $debt->contact          = '';                   // 聯絡內容
            $debt->person           = '';                   // 追單人員
            $debt->remind_at        = '';                   // 提醒
            $debt->id_registration  = $id_registration;     // 報名表ID
            
            $debt->save();
            $id_debt = $debt->id;
        }elseif($id_registration == 0){
            $id_debt = 0;
        }
        /*追單資料 - E*/

        if ($id_student != "" && $id_payment && $id_registration != "" && $id_debt != "") {
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
