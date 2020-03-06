<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Student;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\Payment;
use App\Model\Registration;

class CourseFormController extends Controller
{
    // Sandy (2020/02/28)
    public function insert(Request $request)
    {
        //讀取data
        $date = $request->get('idate');
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

        $student = new Student;
        $course = new Course;
        $events = new EventsCourse;
        $payment = new Payment;
        $registration = new Registration;

        
        //判斷系統是否已有該學員資料
        $check_student = $student::where('phone', $phone)->get();


        /*學員報名資料 - S*/

        // 檢查學生資料
        if (count($check_student) != 0) {
            foreach ($check_student as $data_student) {
                $id_student = $data_student ->id;
            }
        } else{
            // 新增學員資料
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


        /*課程場次資料 - S*/

        // 新增課程資料(新增課程還沒好暫時用的)
        $check_course = $course::where('name', '60天財富計畫')
                            // ->where('location', '台北市中山區松江路131號7樓')
                            // ->where('events', '台北場')
                            // ->where('course_start_at', '2020-01-14 09:00:00')
                            ->get();
        
        if (count($check_course) == 0) {
            $course->id_teacher       = '1';                    // 講師ID
            $course->name             = '60天財富計畫';          // 課程名稱
            $course->type             = '2';                    // 課程類型:(1:銷講,2:2階正課,3:3階正課)
            $course->save();
            $id_course = $course->id;
        }else {
            foreach ($check_course as $data_course) {
                $id_course = $data_course ->id;
            }
        }

        // 新增場次資料(新增課程還沒好暫時用的)
        $check_events = $events::where('course_start_at', '2020-01-14 09:00:00')
                            // ->where('location', '台北市中山區松江路131號7樓')
                            // ->where('events', '台北場')
                            // ->where('course_start_at', '2020-01-14 09:00:00')
                            ->get();
        
        if (count($check_course) == 0) {
            $events->id_course           = $id_course;        // 課程場次
            $events->name             = '台北場';        // 課程場次
            $events->location         = '台北市中山區松江路131號7樓';       // 課程地點
            $events->money              = '';                // 現場完款
            $events->money_fivedays     = '';                // 五日內完款
            $events->money_installment  = '';                // 分期付款
            $events->memo               = '';                // 課程備註
            $events->host               = '';                // 主持開場
            $events->closeorder         = '';                // 結束收單
            $events->weather            = '';                // 天氣
            $events->staff              = '';                // 工作人員
            $events->course_start_at  = '2020-01-14 09:00:00';    // 課程開始時間
            $events->course_end_at    = '2020-01-14 12:00:00';      // 課程結束時間
            $events->memo             = '';             // 課程備註
            $events->save();
            $id_events = $events->id;
        }else {
            foreach ($check_events as $data_events) {
                $id_events = $data_events ->id;
            }
        }
        

        /*課程資料 - E*/



        /*繳款資料 - S*/

        // 新增繳款資料
        $payment->id_student     = $id_student;      // 學員ID
        $payment->cash           = $cash;            // 付款金額
        $payment->pay_model      = $pay_model;       // 付款方式
        $payment->number         = $number;          // 卡號後四碼
        $payment->person         = '';               // 服務人員
        $payment->type_invoice   = $type_invoice;    // 統一發票
        $payment->number_taxid   = $number_taxid;    // 統編
        $payment->companytitle   = $companytitle;    // 抬頭
        
        $payment->save();
        $id_payment = $payment->id;
        
        /*繳款資料 - E*/


        /*正課報名資料 - S*/

        $check_registration = $registration::where('id_student', $id_student)
                                            ->where('id_course', $id_course)
                                            ->get();
    
        // 檢查是否報名過
        if (count($check_registration) == 0 && $id_student != "") {
            // 新增正課報名資料
            if ($id_course != "" && $id_student != "") {
                $date = date('Y-m-d H:i:s');
                $registration->id_student      = $id_student;          // 學員ID
                $registration->id_course       = $id_course;           // 課程ID
                $registration->id_status       = 1;                    // 報名狀態ID
                $registration->id_payment      = $id_payment;          // 繳款明細ID
                
                $registration->amount_payable       = '';              // 應付金額
                $registration->amount_paid          = '';              // 已付金額
                $registration->memo  = '';                             // 備註
                $registration->sign  = '';                             // 簽名檔案
                $registration->status_payment  = 6;                             // 簽名檔案
                $registration->id_events       = $id_events;           // 場次ID
                
                $registration->save();
                $id_registration = $registration->id;
            }
        } else {
            foreach ($check_registration as $data_registration) {
                $id_registration = $data_registration ->id;
            }
        }
        
        /*正課報名資料 - E*/
        if ($id_student != "" && $id_course != " "&& $id_events != "" && $id_registration != "") {
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
