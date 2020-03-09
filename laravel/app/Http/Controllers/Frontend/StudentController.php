<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Student;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Refund;
use App\Model\Debt;
use Symfony\Component\HttpFoundation\Request;

class StudentController extends Controller
{
    // 顯示資料
    public function show()
    {
        $students = Student::leftjoin('sales_registration', 'student.id', '=', 'sales_registration.id_student')
                    ->select('student.*', 'sales_registration.datasource')
                    ->groupBy('id')
                    ->get();
        
        return view('frontend.student', compact('students'));
    }


    // 已填表單
    public function viewform(Request $request)
    {
        $id_student = $request -> get('id_student');
   
        // 銷售講座
        $datas = SalesRegistration::leftjoin('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
                            ->leftjoin('course', 'course.id', '=', 'sales_registration.id_course')
                            ->select('sales_registration.*', 'isms_status.name as status', 'course.name as course')
                            ->where('sales_registration.id_student', $id_student)
                            ->get();
        // 正課
        $data_registration = Registration::leftjoin('isms_status', 'isms_status.id', '=', 'registration.id_status')
            ->leftjoin('course', 'course.id', '=', 'registration.id_course')
            ->select('registration.*', 'isms_status.name as status', 'course.name as course')
            ->where('registration.id_student', $id_student)
            ->get();

        $result = array_merge(json_decode($datas), json_decode($data_registration));
        return $result;
    }

    // 已填表單 - 詳細資料
    public function formdetail(Request $request)
    {
        $type = $request -> get('type');
        $id = $request -> get('id');
        if ($type == "0") {
            // 銷售講座
            $datas = SalesRegistration::leftjoin('course', 'course.id', '=', 'sales_registration.id_course')
                                        ->leftjoin('student', 'student.id', '=', 'sales_registration.id_student')
                                        ->select('sales_registration.*', 'student.*', 'course.name as course')
                                        ->where('sales_registration.id', $id)
                                        ->get();
        } elseif ($type == "1") {
            // 正課
            $datas = Registration::leftjoin('course', 'course.id', '=', 'registration.id_course')
                                    ->leftjoin('student', 'student.id', '=', 'registration.id_student')
                                    ->leftjoin('payment', 'payment.id', '=', 'registration.id_payment')
                                    ->select('registration.*', 'student.*', 'payment.*', 'course.name as course')
                                    ->where('registration.id', $id)
                                    ->get();
        }

        return $datas;
    }


    // 基本資料
    public function coursedata(Request $request)
    {
        $id_student = $request -> get('id_student');
        
        // 學員資料

        $datas_student = Student::leftjoin('sales_registration', 'sales_registration.id_student', '=', 'student.id')
                                    ->select('student.*', 'sales_registration.datasource as datasource_old')
                                    ->groupBy('student.id')
                                    ->orderBy('sales_registration.created_at', 'ASC')
                                    ->where('student.id', $id_student)
                                    ->get();
        // 銷售講座
        $datas = SalesRegistration::leftjoin('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
                            ->leftjoin('course', 'course.id', '=', 'sales_registration.id_course')
                            ->leftjoin('events_course', 'events_course.id', '=', 'sales_registration.id_events')
                            ->select('sales_registration.id as sales_registration_id', 'sales_registration.*', 'isms_status.name as status_sales', 'course.name as course_sales', 'events_course.name as  course_sales_events')
                            // ->selectRaw('sales_registration.*, COUNT(sales_registration.id) as count_sales')
                            ->selectRaw('(SELECT COUNT(b.id) FROM sales_registration b where b.id_student = '.$id_student. ' ) as count_sales')
                            ->selectRaw("(SELECT SUM(CASE WHEN c.id_status = '4' and c.id_student = " .$id_student. " THEN 1 ELSE 0 END)  FROM sales_registration c) as count_sales_ok")
                            ->selectRaw(" (SELECT SUM(CASE WHEN b.id_status = '5' and b.id_student = " .$id_student. " THEN 1 ELSE 0 END)  FROM sales_registration b) as count_sales_no")
                            // ->selectRaw("SUM(CASE WHEN sales_registration.id_status = '4' THEN 1 ELSE 0 END) AS count_sales_ok")
                            // ->selectRaw("SUM(CASE WHEN sales_registration.id_status = '5' THEN 1 ELSE 0 END) AS count_sales_no")
                            ->where('sales_registration.id_student', $id_student)
                            ->groupBy('sales_registration.id_student', 'course.id')
                            ->orderBy('sales_registration.created_at', 'desc')
                            ->first();

        // 正課
        $data_registration = Registration::leftjoin('isms_status', 'isms_status.id', '=', 'registration.id_status')
                            ->leftjoin('course', 'course.id', '=', 'registration.id_course')
                            ->leftjoin('events_course', 'events_course.id', '=', 'registration.id_events')
                            ->leftjoin('isms_status as t1', 't1.id', '=', 'registration.status_payment')
                            ->select('registration.*', 't1.name as status_payment', 'isms_status.name as status_registration', 'course.name as course_registration', 'events_course.name as course_events')
                            ->where('registration.id_student', $id_student)
                            ->orderBy('registration.created_at', 'desc')
                            ->first();
        // 退費                    
        $data_refund = Refund::where('refund.id_student', $id_student)
                                ->leftjoin('registration as r1', 'r1.id', '=', 'refund.id_registration')
                                ->leftjoin('events_course as r2', 'r2.id', '=', 'r1.id_events')
                                ->leftjoin('course as r3', 'r3.id', '=', 'r1.id_course')
                                ->select('refund.refund_reason')
                                ->selectraw('CONCAT(r3.name,"-",r2.name) as refund_course')
                                ->orderBy('refund.created_at', 'desc')
                                ->first();

        $datas = $datas->toArray();
        $datas_student = $datas_student->toArray();
        
        if ($data_registration != "") {
            $data_registration = $data_registration->toArray();
            $result = array_merge($datas_student, $datas, $data_registration);
            if ($data_refund != "") {
                $data_refund = $data_refund->toArray();
                $result = array_merge($result, $data_refund);
            }
        } else {
            $result = array_merge($datas_student, $datas);
        }
        
       
        return $result;
    }
    

    // 聯絡狀況
    public function contactdata(Request $request)
    {
        $id_student = $request -> get('id_student');

        $datas = Debt::select('debt.*')
                        ->where('debt.id_student', $id_student)
                        ->get();
                            // ->leftjoin('course', 'course.id', '=', 'sales_registration.id_course')
                            
        

        $result = $datas;
        
        return $result;
    }


    // 歷史互動
    public function historydata(Request $request)
    {
        $id_student = $request -> get('id_student');

        // 銷講資料
        $datas_SalesRegistration = SalesRegistration::leftjoin('isms_status as a', 'a.id', '=', 'sales_registration.id_status')
                    ->leftjoin('course as b', 'b.id', '=', 'sales_registration.id_course')
                    ->leftjoin('events_course as c', 'c.id', '=', 'sales_registration.id_events')
                    ->select('sales_registration.created_at', 'sales_registration.id_student')
                    ->selectRaw(' CASE
                                        WHEN sales_registration.id_status = 1 THEN "銷講已報名"
                                        WHEN sales_registration.id_status = 2 THEN "我很遺憾"
                                        WHEN sales_registration.id_status = 3 THEN "銷講未到"
                                        WHEN sales_registration.id_status = 4 THEN "銷講報到"
                                        WHEN sales_registration.id_status = 5 THEN "銷講取消"
                                    END as status_sales')
                    ->selectRaw("CONCAT(b.name,c.name,date_format(c.course_start_at, '%Y/%m/%d %H:%i'),' ',date_format(c.course_end_at, '%Y/%m/%d %H:%i'),c.location) AS course_sales ")
                    ->where('sales_registration.id_student', $id_student)
                    ->orderBy('sales_registration.created_at', 'desc')
                    ->get();

        // 正課資料
        $datas_registration = Registration::leftjoin('isms_status as a', 'a.id', '=', 'registration.id_status')
                    ->leftjoin('course as b', 'b.id', '=', 'registration.id_course')
                    ->leftjoin('events_course as c', 'c.id', '=', 'registration.id_events')
                    ->select('registration.created_at', 'registration.id_student')
                    ->selectRaw(' CASE
                                        WHEN registration.id_status = 1 THEN "正課已報名"
                                        WHEN registration.id_status = 3 THEN "正課未到"
                                        WHEN registration.id_status = 4 THEN "正課報到"
                                        WHEN registration.id_status = 5 THEN "正課取消"
                                    END as status_sales')
                    ->selectRaw("CONCAT(b.name,c.name,date_format(c.course_start_at, '%Y/%m/%d %H:%i'),' ',date_format(c.course_end_at, '%Y/%m/%d %H:%i'),c.location) AS course_sales ")
                    ->where('registration.id_student', $id_student)
                    ->orderBy('registration.created_at', 'desc')
                    ->get();
        // 活動資料            
        if ($datas_registration != "") {
            $datas_registration = $datas_registration->toArray();
            $datas_SalesRegistration = $datas_SalesRegistration->toArray();
            $result = array_merge($datas_SalesRegistration, $datas_registration);
            usort($result, array($this, "dateSort"));
        } else {
            $result = $datas_SalesRegistration;
        }
        // $result = $datas_SalesRegistration;
        return $result;
    }

    //日期排序
    private static function dateSort(
        $a,
        $b
    ) {
        if ($a["created_at"] > $b["created_at"]) {
            return -1;
        }
        elseif ($a["created_at"] < $b["created_at"]) {
            return 1;
        }
        return 0;
    }
    // 搜尋
    public function search(Request $request)
    {
        $pagesize = 15;
        $search_data = $request->get('search_data');

        if (!empty($search_data)) {
            $students = Student::Where('email', 'like', '%' .$search_data. '%')
            ->orWhere('phone', 'like', '%' .$search_data. '%')
            ->paginate($pagesize);
        } else {
            $students = Student::paginate($pagesize);
        }
        

        // $returnHTML = view('frontend.student')->with('students', $students)->renderSections()['content'];
        $returnHTML = view('frontend.student')->with('students', $students)->render();
        return $returnHTML;
    }
}
