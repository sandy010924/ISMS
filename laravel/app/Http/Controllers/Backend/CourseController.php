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
            
            // 宣告變數
            $id_course = "";            // 課程ID
            $id_student = "";           // 學員ID
            $id_SalesRegistration = ""; // 銷講ID
            $events = "";               // 場次
            $location = "";             // 場次+地址
            $address = "";              // 地址
            $time_start = "";           // 課程開始
            $time_end = "";           // 課程結束
            // 宣告縣市變數
            $city = array(
                '0' => '基隆',
                '1' => '台北',
                '2' => '新北',
                '3' => '宜蘭',
                '4' => '桃園',
                '5' => '新竹',
                '6' => '新竹',
                '7' => '苗栗',
                '8' => '台中',
                '9' => '彰化',
                '10' => '南投',
                '11' => '雲林',
                '12' => '嘉義',
                '13' => '嘉義',
                '14' => '台南',
                '15' => '高雄',
                '16' => '屏東',
                '17' => '花蓮',
                '18' => '台東',
                '19' => '澎湖',
                '20' => '金門',
                '21' => '馬祖',
                '22' => '離島地區',
                '23' => '臺北',
                );

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
                    case ($value == "課程名稱報名時間地點" || $value == "場次報名時間地點" || $value == "百萬狙擊操盤手報名時間地點" || $value == "黑心外匯交易員的告白場次報名時間"):
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


            foreach ($excel_data as $key => $data) {
                $submissiondate = intval(($data[$int_submissiondate] - 25569) * 3600 * 24);     // Submission Date
               
                $course = new Course;
                $student = new Student;
                $SalesRegistration = new SalesRegistration;
                $check_student = $student::where('phone', $data[$int_phone])->get();
                $location = "";

                $str_sec = explode(" ", $data[$int_coursedata]);

                if (strpos(mb_convert_encoding($data[$int_coursedata], 'utf-8'), '好遺憾') !== false || count($str_sec) == "1") {
                    // 好遺憾系列、空值
                    // switch (count($str_sec)) {
                    //     case 1:
                        // $events='';
                    //         break;
                    //     case 2:
                    //         $events =  mb_substr($str_sec[1], 0, -1, 'utf8');
                    //         break;
                    //     case 3:
                    //         $events = mb_substr($str_sec[2], 0, -1, 'utf8');
                    //         break;
                    // }
                } else {
                    /*有報名課程*/

                    // 課程場次 + 地點
                    for ($i = 0; $i < count($city); $i++) {
                        if ($location == "") {
                            $location = strchr($data[$int_coursedata], $city[$i]);
                        }
                        if ($location != "") {
                            break;
                        }
                    }
                    // 場次
                    $events = mb_substr($location, 0, 5, 'utf8');
                    // 地址
                    $address = mb_substr($location, 5, strlen($location), 'utf8');

                    $stime = str_replace(" ", "", explode("-", $data[$int_coursedata]));
                    $etime = strchr($data[$int_coursedata], "-");
                    
                    // 課程日期
                    $date = mb_substr($stime[0], 0, 10, 'utf8');
                    
                    // 判斷課程日期要抓到哪個位置
                    if (strpos($date, '（') != false || strpos($date, '(') != false) {
                        // 包含(
                        $date = mb_substr($stime[0], 0, 9, 'utf8');
                    }
                    
                    // 課程開始時間
                    $time_start = date('Y-m-d H:i:s', strtotime($date.mb_substr($stime[0], -4, 4, 'utf8'))).PHP_EOL;

                     // 課程結束時間
                     $str_time_end = $date.mb_substr($etime, 1, 5, 'utf8');
                     $time_end = date('Y-m-d H:i:s', strtotime($str_time_end)).PHP_EOL;
                    

                    if (strpos($str_time_end, '（') != false || strpos($str_time_end, '(') != false) {
                        // 包含(
                        $time_end = date('Y-m-d H:i:s', strtotime($date.mb_substr($etime, 1, 4, 'utf8'))).PHP_EOL;
                    }
                }

                /*課程資料 - S*/

                // 新增課程資料(只新增一筆資料)
                $check_course = $course::where('name', $name)
                                    ->where('location', $address)
                                    ->where('events', $events)
                                    ->where('course_start_at', $time_start)
                                    ->get();
               
                if (count($check_course) != 0) {
                    foreach ($check_course as $data_course) {
                        $id_course = $data_course ->id;
                    }
                } else {
                    $course->id_teacher       = $id_teacher;    // 講師ID
                    $course->name             = $name;          // 課程名稱
                    $course->location         = $address;       // 課程地點
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
                if (count($check_student) != 0) {
                    foreach ($check_student as $data_student) {
                        $id_student = $data_student ->id;
                    }
                } elseif ($data[$int_phone] != "") {
                    // 新增學員資料
                    $student->name          = $data[$int_name];         // 學員姓名
                    $student->sex           = '';                       // 性別
                    $student->id_identity   = '';                       // 身分證
                    $student->phone         = $data[$int_phone];        // 電話
                    $student->email         = $data[$int_email];        // email
                    $student->birthday      = '';                       // 生日
                    $student->company       = '';                       // 公司
                    $student->profession    = $data[$int_job];          // 職業
                    if ($int_address != "0") {
                        $student->address       = $data[$int_address];  // 居住地
                    }
                    
                    $student->save();
                    $id_student = $student->id;
                }
                /*學員報名資料 - E*/

                /*銷售講座報名資料 - S*/

                $check_SalesRegistration = $SalesRegistration::where('id_student', $id_student)
                                                                -> where('id_course', $id_course)
                                                                ->get();
         
                // 檢查是否報名過
                if (count($check_SalesRegistration) == 0 && $id_student != "") {
                    // 新增銷售講座報名資料
                    if ($id_course != "" && $id_student != "") {
                        $date = gmdate('Y-m-d H:i:s', $submissiondate);
                        $SalesRegistration->submissiondate   = $date;                           // Submission Date
                        $SalesRegistration->datasource       = $data[$int_form];                // 表單來源
                        $SalesRegistration->id_student      = $id_student;                      // 學員ID
                        $SalesRegistration->id_course       = $id_course;                       // 課程ID
                        if (strpos(mb_convert_encoding($data[$int_coursedata], 'utf-8'), '好遺憾') !== false || count($str_sec) == "1") {
                            // 我很遺憾
                            $SalesRegistration->id_status       = 2;                            // 報名狀態ID
                        } else {
                            // 報名成功
                            $SalesRegistration->id_status       = 1;                            // 報名狀態ID
                        }

                        if ($int_pay != 0) {
                            $SalesRegistration->pay_model       = $data[$int_pay];                  // 付款方式
                        }
                        if ($int_account != 0) {
                            $SalesRegistration->account         = $data[$int_account];              // 帳號/卡號後五碼
                        }
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
