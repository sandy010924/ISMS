<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;
use App\Student;
use App\SalesRegistration;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    public function uploadPage()
    {
        return view('frontend.course');
    }

    // Rocky (2019/12/29)
    public function upload(Request $request)
    {
        // 前端資料
        $path = $request->file('import_flie');
        $id_teacher = $request->get('import_teacher');

        //如果檔案是空的 -> rturn
        if ($path == "" || $id_teacher == "") {
            return redirect('course')->with('status', '請選檔案/填講師姓名');
        }

        $excel_data = Excel::toCollection(null, $path);
        $excel_data =  $excel_data[0];

        //第一列title不列入
        unset($excel_data[0]);

        $id_course = "";
        $id_student = "";
        $id_SalesRegistration = "";

        foreach ($excel_data as $key => $data) {
            $course = new Course;
            $student = new Student;
            $SalesRegistration = new SalesRegistration;
            $check_student = $student::where('phone', $data[3])->get();
        
                     
            // 從日期+時間+場次+地點欄位切割
            $str_sec = explode(" ", $data[6]);
    
            // 切割日期
            $str_date = explode("（", $str_sec[0]);

            //切割時間(開始時間、結束時間)
            $str_time = explode("）", $str_sec[0]);
            
            // $time[0] -> 開始時間,$time[1] -> 結束時間
            $time = explode("-", $str_time[1]);
            $time_start = date('Y-m-d H:i:s', strtotime($str_date[0].$time[0])).PHP_EOL;
            $time_end = date('Y-m-d H:i:s', strtotime($str_date[0].$time[1])).PHP_EOL;



            // 新增課程資料(只新增一筆資料)
            if ($key == "1") {
                $course->id_teacher       = $id_teacher;     // 講師ID
                $course->name             = '';             // 課程名稱
                $course->location         = $str_sec[3];    // 課程地點
                $course->events           = $str_sec[2];    // 課程場次
                $course->course_start_at  = $time_start;    // 課程開始時間
                $course->course_end_at    = $time_end;      // 課程結束時間
                $course->memo             = '';             // 課程備註
                $course->type             = '0';            // 課程類型:0->銷講,1->正課
                $course->save();
                $id_course = $course->id;
            }
            
            // 檢查學生資料
            if (count($check_student) != 0) {
                foreach ($check_student as $data_student) {
                    $id_student = $data_student ->id;
                }
            } else {
                // 新增學員資料
                $student->name          = $data[2];     // 學員姓名
                $student->sex           = '';           // 性別
                $student->id_identity   = '';           // 身分證
                $student->phone         = $data[3];     // 電話
                $student->email         = $data[4];     // email
                $student->birthday      = '';           // 生日
                $student->company       = '';           // 公司
                $student->profession    = $data[7];     // 職業
                $student->address       = $data[5];     // 居住地
                $student->save();
                $id_student = $student->id;
            }

            // 新增銷售講座報名資料
            if ($id_course != "" && $id_student != "") {
                $SalesRegistration->id_student      = $id_student;  // 學員ID
                $SalesRegistration->id_course       = $id_course;   // 課程ID
                $SalesRegistration->id_status       = 1;            // 報名狀態ID
                $SalesRegistration->pay_model       = $data[8];     // 付款方式
                $SalesRegistration->account         = $data[9];     // 帳號/卡號後四碼
                $SalesRegistration->course_content  = $data[10];    // 想聽到的課程有哪些
                $SalesRegistration->save();
                $id_SalesRegistration = $SalesRegistration->id;
            }
        }

        if ($id_student != "" && $id_course != "" && $id_SalesRegistration != "") {
            return redirect('course')->with('status', '匯入成功');
        } else {
            return redirect('course')->with('status', '匯入失敗');
        }
    }
}
