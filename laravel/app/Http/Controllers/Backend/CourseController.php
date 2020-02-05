<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Student;
use App\Model\SalesRegistration;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class CourseController extends Controller
{
    // Rocky (2019/12/29)
    public function upload(Request $request)
    {
        try {
            // 宣告欄位順序變數 Rocky(2020/02/05)
            $int_submissiondate = 0;    // Submission Date
            $int_form = 0;              // 表單來源
            $int_name = 0;              // 姓名
            $int_phone = 0;             // 聯絡電話
            $int_email = 0;             // 電子郵件
            $int_address = 0;           // 居住區域
            $int_coursedata = 0;        // 課程
            $int_job = 0;               // 職業
            $int_pay = 0;               // 付款方式
            $int_account = 0;           // 卡號
            $int_text = 0;              // 想聽到...內容
            
            // 前端資料
            $path = $request->file('import_flie');
            $name = $request->get('import_name');
            $id_teacher = $request->get('import_teacher');

            //如果檔案是空的 -> rturn
            if ($path == "" || $id_teacher == "" || $name == "") {
                return redirect('course')->with('status', '請選檔案/填、課程講師姓名');
            }

            $excel_data = Excel::toCollection(null, $path);
            $excel_data =  $excel_data[0];

            //第一列title不列入
            unset($excel_data[0]);

            /* 依照Excel欄位標題新增資料 Rocky (2020/02/05) - S */

            // 取得標題
            $headings = (new HeadingRowImport)->toArray($path);
            
            // 抓取欄位順序
            for ($i = 0; $i < count($headings[0][0]); $i++) {
                $value = $headings[0][0][$i];
                switch ($value) {
                    case "Submission Date":
                        $int_submissiondate = $i;
                        break;
                    case ($value == "表單來源" || $value == "名單來源"):
                        $int_form = $i;
                        break;
                    case "姓名":
                        $int_name = $i;
                        break;
                    case "聯絡電話":
                        $int_phone = $i;
                        break;
                    case "電子郵件":
                        $int_email = $i;
                        break;
                    case "居住區域":
                        $int_address = $i;
                        break;
                    case ($value == "課程名稱報名時間地點" || $value == "場次報名時間地點"):
                        $int_coursedata = $i;
                        break;
                    case "目前職業":
                        $int_job = $i;
                        break;
                    case "付款方式":
                        $int_pay = $i;
                        break;
                    case "帳號/卡號後五碼":
                        $int_account = $i;
                        break;
                    case "我想在講座中瞭解到的內容？":
                        $int_text = $i;
                        break;
                }
            }

           
            /* 依照Excel欄位標題新增資料 Rocky (2020/02/05) - E */

            $id_course = "";
            $id_student = "";
            $id_SalesRegistration = "";
            $events = "";

            foreach ($excel_data as $key => $data) {
                $submissiondate = intval(($data[$int_submissiondate] - 25569) * 3600 * 24);     // Submission Date
               
                $course = new Course;
                $student = new Student;
                $SalesRegistration = new SalesRegistration;
                $check_student = $student::where('phone', $data[$int_phone])->get();
               
      
                
                // 從日期+時間+場次+地點欄位切割
                $str_sec = explode(" ", $data[$int_coursedata]);
            
                if (count($str_sec) == 4) {
                    // 切割日期
                    $str_date = explode("（", $str_sec[0]);
                    
                    //切割時間(開始時間、結束時間)
                    $str_time = explode("）", $str_sec[0]);
                    
                    //場次
                    $events = $str_sec[2];
                    // $time[0] -> 開始時間,$time[1] -> 結束時間
                    $time = explode("-", $str_time[1]);
                    $time_start = date('Y-m-d H:i:s', strtotime($str_date[0].$time[0])).PHP_EOL;
                    $time_end = date('Y-m-d H:i:s', strtotime($str_date[0].$time[1])).PHP_EOL;
                } else {
                    switch (count($str_sec)) {
                        case 1:
                            $events = '';
                            break;
                        case 2:
                            $events = $str_sec[1];
                            break;
                        case 3:
                            $events = $str_sec[2];
                            break;
                    }
                }

                /*課程資料 - S*/

                // 新增課程資料(只新增一筆資料)
                if ($key == "1") {
                    $course->id_teacher       = $id_teacher;    // 講師ID
                    $course->name             = $name;          // 課程名稱
                    $course->location         = $str_sec[3];    // 課程地點
                    $course->events           = $events;        // 課程場次
                    $course->course_start_at  = $time_start;    // 課程開始時間
                    $course->course_end_at    = $time_end;      // 課程結束時間
                    $course->memo             = '';             // 課程備註
                    $course->type             = '1';            // 課程類型:(1:銷講,2:2階正課,3:3階正課)
                    $course->save();
                    $id_course = $course->id;
                }
                /*課程資料 - E*/


                /*學員報名資料 - S*/
                
                // 檢查學生資料
                if (count($check_student) != 0 ) {
                    foreach ($check_student as $data_student) {
                        $id_student = $data_student ->id;
                    }
                } elseif ($data[$int_phone] != "") {
                    // 新增學員資料
                    $student->name          = $data[$int_name];     // 學員姓名
                    $student->sex           = '';                   // 性別
                    $student->id_identity   = '';                   // 身分證
                    $student->phone         = $data[$int_phone];    // 電話
                    $student->email         = $data[$int_email];    // email
                    $student->birthday      = '';                   // 生日
                    $student->company       = '';                   // 公司
                    $student->profession    = $data[$int_job];      // 職業
                    $student->address       = $data[$int_address];  // 居住地
                    $student->save();
                    $id_student = $student->id;
                }
                /*學員報名資料 - E*/

                /*銷售講座報名資料 - S*/

                $check_SalesRegistration = $SalesRegistration::where('id_student', $id_student)->get();
         
                // 檢查是否報名過
                if (count($check_SalesRegistration) == 0 && $id_student != "") {
                    // 新增銷售講座報名資料
                    if ($id_course != "" && $id_student != "") {
                        $date = gmdate('Y-m-d H:i:s', $submissiondate);
                        $SalesRegistration->submissiondate   = $date;                           // Submission Date
                        $SalesRegistration->datasource       = $data[$int_form];                // 表單來源
                        $SalesRegistration->id_student      = $id_student;                      // 學員ID
                        $SalesRegistration->id_course       = $id_course;                       // 課程ID
                        if (count($str_sec) != 4) {
                            $SalesRegistration->id_status       = 2;                            // 報名狀態ID
                        } elseif (count($str_sec) == 4) {
                            $SalesRegistration->id_status       = 1;                            // 報名狀態ID
                        }
                        $SalesRegistration->pay_model       = $data[$int_pay];                  // 付款方式
                        $SalesRegistration->account         = $data[$int_account];              // 帳號/卡號後五碼
                        $SalesRegistration->course_content  = $data[$int_text];                 // 想聽到的課程有哪些
                        
                        $SalesRegistration->save();
                        $id_SalesRegistration = $SalesRegistration->id;
                    }
                } else {
                    foreach ($check_SalesRegistration as $data_SalesRegistration) {
                        $id_SalesRegistration = $data_SalesRegistration ->id;
                    }
                }
                /*銷售講座報名資料 - E*/
            }

            if ($id_student != "" && $id_course != "" && $id_SalesRegistration != "") {
                return redirect('course')->with('status', '匯入成功');
            } else {
                return redirect('course')->with('status', '匯入失敗');
            }
        } catch (\Exception $e) {
            return redirect('course')->with('status', '匯入失敗');
        }
    }
}
