<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\Student;
use App\Model\Teacher;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Register;
use App\Model\Debt;
use App\Model\Refund;
use App\Model\Payment;
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
            $id_events = "";            // 場次ID
            $id_student = "";           // 學員ID
            $id_SalesRegistration = ""; // 銷講ID
            $events = "";               // 場次
            $location = "";             // 場次+地址
            $address = "";              // 地址
            $time_start = "";           // 課程開始
            $time_end = "";             // 課程結束
            $check_excel_status = "0";  // 檢查是不是第一次執行function
            $check_course = "";         // 檢查是否有重複課程
            $check_events = "";         // 檢查是否有重複場次
            // 宣告縣市變數
            $city = array(
                '0' => '假日',
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
                '13' => '台南',
                '14' => '高雄',
                '15' => '屏東',
                '16' => '花蓮',
                '17' => '台東',
                '18' => '澎湖',
                '19' => '金門',
                '20' => '馬祖',
                '21' => '離島地區',
                '22' => '臺北',
                '23' => '竹北市',
                '24' => '基隆',

            );

            // 前端資料
            $path = $request->file('import_flie');
            $name = $request->get('import_name');

            $teacher_name = $request->get('import_teacher');

            $check_teacher = Teacher::where('name', $teacher_name)->first();

            if ($check_teacher != '') {
                $id_teacher = $check_teacher->id;
            } else {
                $teacher = new Teacher;

                $teacher->name             = $teacher_name;  // 講師名稱
                $teacher->phone             = '';            // 講師電話
                $teacher->save();
                $id_teacher = $teacher->id;
            }



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
                if ($value != '') {
                    switch ($value) {
                        case "Submission Date":
                            $int_submissiondate = $i;
                            break;
                        case "表單來源":
                            $int_form = $i;
                            break;
                        case "名單來源":
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
                        case ((strchr($value, "報名")) != ""):
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
            }
            /* 依照Excel欄位標題新增資料 Rocky (2020/02/05) - E */


            foreach ($excel_data as $key => $data) {
                // 空行不新增 Rocky (2020/03/31)
                if ($excel_data[$key]->filter()->isNotEmpty()) {
                    // 宣告變數
                    $address_strchr = "";
                    $address_city = "";
                    $or_address = "";
                    $address_strchr_finish = array();
                    $location = "";

                    $check = 0;

                    // 宣告Model
                    $events_course = new EventsCourse;
                    $course = new Course;
                    $student = new Student;
                    $SalesRegistration = new SalesRegistration;

                    // 切割空白
                    $str_sec = explode(" ", $data[$int_coursedata]);

                    // 預設資料 Rocky (2020/06/27)
                    $sphone = "Excel無資料";
                    $semail = "Excel無資料";
                    $sname = "Excel無資料";
                    $ssubmissiondate = 25569;

                    if ($int_name != 0 && $data[$int_name] != "") {
                        $sname = $data[$int_name];
                    }
                    if ($int_phone != 0 && $data[$int_phone] != "") {
                        $sphone = $data[$int_phone];
                    }
                    if ($int_email != 0 && $data[$int_email] != "") {
                        $semail = $data[$int_email];
                    }

                    if ($data[$int_submissiondate] != "") {
                        $ssubmissiondate = $data[$int_submissiondate];
                    }



                    $submissiondate = intval(($ssubmissiondate - 25569) * 3600 * 24);     // Submission Date

                    $check_student = $student::where('phone', $sphone)
                        ->where('name', $sname)
                        ->where('email', $semail)
                        ->get();

                    if (strpos(mb_convert_encoding($data[$int_coursedata], 'utf-8'), '好遺憾') !== false || strpos(mb_convert_encoding($data[$int_coursedata], 'utf-8'), '有興趣') !== false || $data[$int_coursedata] == "" || strlen($data[$int_coursedata]) < 5) {
                        // 好遺憾系列、空值
                        $check = 1;
                        switch (count($str_sec)) {
                            case 1:
                                $events = '';
                                break;
                            case 2:
                                if (strlen($str_sec[1]) == 15) {
                                    $events =  mb_substr($str_sec[1], 0, -1, 'utf8');
                                } else {
                                    $events =  $str_sec[1];
                                }
                                break;
                            case 3:
                                if (strlen($str_sec[1]) == 15) {
                                    $events = mb_substr($str_sec[2], 0, -1, 'utf8');
                                } else {
                                    $events =  $str_sec[2];
                                }
                                break;
                        }
                    } else {
                        /*有報名課程*/
                        // 課程場次 + 地點
                        // echo $data[$int_coursedata];
                      
                        for ($array_city_number = 0; $array_city_number < count($city); $array_city_number++) {
                            if ($location == "") {
                                $location = strchr($data[$int_coursedata], $city[$array_city_number]);
                                // $location = strchr("假日晚上場(高雄市中山區松江路131號7樓)", $city[$array_city_number]);
                            }
                            if ($location != "") {
                                break;
                            }
                        }
                        // 場次
                        if ($location != "") {
                            $events = mb_substr($location, 0, 5, 'utf8');
                        }

                        // 地址 - 新版 Rocky (2020/06/26)

                        if ($location != "") {
                            $or_address = mb_substr($location, 5, strlen($location), 'utf8');
                        }


                        if ($or_address != "") {
                            // 由縣市名稱 -> 擷取正確地址資料
                            for ($i = 0; $i < count($city); $i++) {
                                if ($address_city == "") {
                                    $address_city = strchr($or_address, $city[$i]);
                                }
                                if ($address_city != "") {
                                    break;
                                }
                            }


                            if ($address_city != "") {
                                // 排除不必要的符號
                                $address_strchr = str_replace(array('(', '（'), '', $address_city);

                                // 切割 ') and ）' 不必要的符號
                                if (strpos($address_strchr, ')') != false) {
                                    $address_strchr_finish = explode(")", $address_strchr);
                                } elseif (strpos($address_strchr, '）') != false) {
                                    $address_strchr_finish = explode("）", $address_strchr);
                                }

                                // 將切割完的字串 -> 轉為UTF8格式
                                if (count($address_strchr_finish) > 0) {
                                    $address = mb_substr($address_strchr_finish[0], 0, strlen($address_strchr_finish[0]), 'utf8');
                                } else {
                                    $address = $address_strchr;
                                }


                                // 排除不必要的符號
                                $address = str_replace(array(')', '）'), '', $address);
                            } else {
                                $address = "";
                            }
                        }

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
                        $time_start = date('Y-m-d H:i:s', strtotime($date . mb_substr($stime[0], -4, 4, 'utf8'))) . PHP_EOL;

                        // 課程結束時間
                        $str_time_end = $date . mb_substr($etime, 1, 5, 'utf8');
                        $time_end = date('Y-m-d H:i:s', strtotime($str_time_end)) . PHP_EOL;


                        if (strpos($str_time_end, '（') != false || strpos($str_time_end, '(') != false) {
                            // 包含(
                            $time_end = date('Y-m-d H:i:s', strtotime($date . mb_substr($etime, 1, 4, 'utf8'))) . PHP_EOL;
                        }
                    }

                    /*課程資料 - S*/

                    // 新增課程資料(只新增一筆資料) 2020/03/05
                    if ($check_excel_status == "0") {
                        $check_course = $course::where('name', $name)
                            // ->where('location', $address)
                            // ->where('events', $events)
                            // ->where('course_start_at', $time_start)
                            ->get();

                        // 如果有此課程就新增一筆資料
                        if (count($check_course) != 0) {
                            foreach ($check_course as $data_course) {
                                $id_course = $data_course->id;
                            }
                        } else {
                            $course->id_teacher       = $id_teacher;    // 講師ID
                            $course->name             = $name;          // 課程名稱
                            $course->type             = '1';            // 課程類型:(1:銷講,2:2階正課,3:3階正課)
                            $course->save();
                            $id_course = $course->id;
                        }
                        $check_excel_status++;
                    }
                    /*課程資料 - E*/

                    /* 場次資料 (2020/03/05) - S*/
                    $check_events = $events_course::where('name', $events)
                        ->where('id_course', $id_course)
                        ->where('location', $address)
                        ->where('course_start_at', $time_start)
                        ->where('course_end_at', $time_end)
                        ->get();
                    if (count($check_events) != 0) {
                        $id_events = $check_events[0]["id"];
                    } elseif (!empty($id_course) && $check != 1) {
                        $events_course->id_course        = $id_course;           // 課程ID
                        $events_course->name             = $events;              // 場次名稱
                        $events_course->location         = $address;             // 課程地點
                        $events_course->course_start_at  = $time_start;          // 課程開始時間
                        $events_course->course_end_at    = $time_end;            // 課程結束時間
                        $events_course->memo             = '';                   // 課程備註
                        $events_course->id_group         = strtotime($time_start) . $id_course;     // 群組ID
                        $events_course->unpublish        = 0;                    // 不公開
                        $events_course->save();
                        $id_events = $events_course->id;
                    }
                    /* 場次資料 - E*/

                    /*學員報名資料 - S*/

                    // 檢查學生資料

                    if (count($check_student) != 0) {
                        $id_student = $check_student[0]["id"];
                    } else {
                        $sphone = "Excel無資料";
                        $semail = "Excel無資料";
                        $sname = "Excel無資料";
                        $sprofession = "Excel無資料";
                        $saddress = "Excel無資料";

                        if ($int_name != 0 && $data[$int_name] != "") {
                            $sname = $data[$int_name];
                        }
                        if ($int_phone != 0 && $data[$int_phone] != "") {
                            $sphone = $data[$int_phone];
                        }
                        if ($int_email != 0 && $data[$int_email] != "") {
                            $semail = $data[$int_email];
                        }
                        if ($int_job != 0 && $data[$int_job] != "") {
                            $sprofession = $data[$int_job];
                        }
                        if ($int_address != 0 && $data[$int_address] != "") {
                            $saddress = $data[$int_address];
                        }

                        // 新增學員資料
                        $student->name          = $sname;                   // 學員姓名
                        $student->sex           = '';                       // 性別
                        $student->id_identity   = '';                       // 身分證
                        $student->phone         = $sphone;                  // 電話
                        $student->email         = $semail;                  // email
                        $student->birthday      = '';                       // 生日
                        $student->company       = '';                       // 公司
                        $student->profession    = $sprofession;             // 職業
                        $student->address       = $saddress;                // 居住地

                        $student->save();
                        $id_student = $student->id;
                    }
                    /*學員報名資料 - E*/

                    /*銷售講座報名資料 - S*/

                    $check_SalesRegistration = $SalesRegistration::where('id_student', $id_student)
                        ->where('id_events', $id_events)
                        ->get();
                    // 檢查是否報名過
                    if (count($check_SalesRegistration) == 0 && $id_student != "") {
                        // 新增銷售講座報名資料
                        if ($id_course != "" && $id_student != "") {
                            $date = gmdate('Y-m-d H:i:s', $submissiondate);
                            $SalesRegistration->submissiondate   = $date;                           // Submission Date
                            $SalesRegistration->datasource       = $data[$int_form];                // 表單來源
                            $SalesRegistration->id_student       = $id_student;                     // 學員ID
                            if ($check == 1) {
                                // 我很遺憾
                                $SalesRegistration->id_events    = -99;                             // 場次ID
                                $SalesRegistration->id_course    = $id_course;                      // 課程ID
                                $SalesRegistration->id_status    = 2;                               // 報名狀態ID
                                $SalesRegistration->events       = $events;                         // 追蹤場次
                            } else {
                                // 報名成功
                                $SalesRegistration->id_events        = $id_events;                   // 場次ID
                                $SalesRegistration->id_course       = $id_course;                   // 課程ID
                                $SalesRegistration->id_status       = 1;                            // 報名狀態ID
                            }
                            if ($int_pay != 0) {
                                $SalesRegistration->pay_model       = $data[$int_pay];              // 付款方式
                            }
                            if ($int_account != 0) {
                                $SalesRegistration->account         = $data[$int_account];          // 帳號/卡號後五碼
                            }
                            $SalesRegistration->course_content  = $data[$int_text];                 // 想聽到的課程有哪些

                            $SalesRegistration->save();
                            $id_SalesRegistration = $SalesRegistration->id;
                        }
                        $check = 0;
                    } else {
                        foreach ($check_SalesRegistration as $data_SalesRegistration) {
                            $id_SalesRegistration = $data_SalesRegistration->id;
                        }
                    }
                    /*銷售講座報名資料 - E*/
                }
            }

            if (($id_student != "" || $id_course != "") && $id_SalesRegistration != "") {
                return redirect('course')->with('status', '匯入成功');
            } else {
                return redirect('course')->with('status', '匯入失敗');
            }
        } catch (\Exception $e) {
            return redirect('course')->with('status', '匯入失敗');
        }
    }

    // Rocky (2020/02/11)
    public function delete(Request $request)
    {
        $status = "";
        $id_events = $request->get('id_events');
        $id_group = $request->get('id_group');

        // 查詢是否有該筆資料
        // $course = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
        //                       ->select('course.type as type', 'events_course.*')
        //                       ->where('events_course.id', $id_events)
        //                       ->first();

        $events = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
            ->select('course.type as type', 'events_course.*')
            ->where('events_course.id_group', $id_group)
            ->get();

        // 刪除資料
        if (!empty($events)) {
            if ($events[0]->type == 1) {
                //銷講
                foreach ($events as $data) {
                    //刪除報名表
                    SalesRegistration::where('id_events', $data->id)->delete();

                    // $apply_table = SalesRegistration::where('id_events', $events->id)
                    //                                 ->get();
                }
            } elseif ($events[0]->type == 2 || $events[0]->type == 3) {
                //正課
                // foreach( $events as $data){

                $apply_table = Registration::where('id_group', $id_group)
                    ->get();

                foreach ($apply_table as $data_apply) {
                    //刪除報到
                    Register::where('id_registration', $data_apply['id'])->delete();

                    //刪除追單
                    Debt::where('id_registration', $data_apply['id'])->delete();

                    //刪除退費
                    Refund::where('id_registration', $data_apply['id'])->delete();

                    //刪除付款
                    Payment::where('id_registration', $data_apply['id'])->delete();
                }

                //刪除報名表
                Registration::where('id_group', $id_group)->delete();
                // }
            }

            //刪除場次
            EventsCourse::where('id_group', $id_group)->delete();

            $status = "ok";
        } else {
            $status = "error";
        }
        return json_encode(array('data' => $status));
    }
}
