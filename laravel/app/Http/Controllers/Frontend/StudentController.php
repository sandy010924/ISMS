<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Student;
use App\Model\SalesRegistration;
use App\Model\Registration;
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

   
    public function getcourse($id_student, $type)
    {
        if ($type == "sales_registration") {
            // 銷售講座
            $datas = SalesRegistration::leftjoin('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
                                ->leftjoin('course', 'course.id', '=', 'sales_registration.id_course')
                                ->select('sales_registration.*', 'isms_status.name as status', 'course.name as course')
                                ->where('sales_registration.id_student', $id_student)
                                ->get();
        } elseif ($type == "registration") {
            // 正課
        }

        return $datas;
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
   
        // 銷售講座
        $datas = SalesRegistration::leftjoin('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
                            ->leftjoin('course', 'course.id', '=', 'sales_registration.id_course')
                            ->select('sales_registration.*', 'isms_status.name as status', 'course.name as course', 'course.Events as  course_sales_events')
                            ->selectRaw('sales_registration.*, COUNT(sales_registration.id) as count_sales')
                            ->selectRaw("SUM(CASE WHEN sales_registration.id_status = '4' THEN 1 ELSE 0 END) AS count_sales_ok")
                            ->selectRaw("SUM(CASE WHEN sales_registration.id_status = '5' THEN 1 ELSE 0 END) AS count_sales_no")
                            ->where('sales_registration.id_student', $id_student)
                            ->orderBy('sales_registration.created_at', 'desc')
                            ->first();

        // 正課
        $data_registration = Registration::leftjoin('isms_status', 'isms_status.id', '=', 'registration.id_status')
                            ->leftjoin('course', 'course.id', '=', 'registration.id_course')
                            ->select('registration.*', 'isms_status.name as status', 'course.name as course', 'course.Events as course_events')
                            ->where('registration.id_student', $id_student)
                            ->orderBy('registration.created_at', 'desc')
                            ->first();

        $datas = $datas->toArray();

        if ($data_registration != "") {
            $data_registration = $data_registration->toArray();
            $result = array_merge($datas, $data_registration);
        } else {
            $result = $datas;
        }
        

        // $result = array_merge($datas, $data_registration);
       
        return $result;
    }
    

    // 聯絡狀況
    public function contactdata(Request $request)
    {
        $id_student = $request -> get('id_student');
    
        // 銷售講座
        $datas = SalesRegistration::leftjoin('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
                            ->leftjoin('course', 'course.id', '=', 'sales_registration.id_course')
                            ->select('sales_registration.*', 'isms_status.name as status', 'course.name as course', 'course.Events as  course_sales_events')
                            ->selectRaw('sales_registration.*, COUNT(sales_registration.id) as count_sales')
                            ->selectRaw("SUM(CASE WHEN sales_registration.id_status = '4' THEN 1 ELSE 0 END) AS count_sales_ok")
                            ->selectRaw("SUM(CASE WHEN sales_registration.id_status = '5' THEN 1 ELSE 0 END) AS count_sales_no")
                            ->where('sales_registration.id_student', $id_student)
                            ->orderBy('sales_registration.created_at', 'desc')
                            ->first();

        // 正課
        $data_registration = Registration::leftjoin('isms_status', 'isms_status.id', '=', 'registration.id_status')
                            ->leftjoin('course', 'course.id', '=', 'registration.id_course')
                            ->select('registration.*', 'isms_status.name as status', 'course.name as course', 'course.Events as course_events')
                            ->where('registration.id_student', $id_student)
                            ->orderBy('registration.created_at', 'desc')
                            ->first();

        $datas = $datas->toArray();

        if ($data_registration != "") {
            $data_registration = $data_registration->toArray();
            $result = array_merge($datas, $data_registration);
        } else {
            $result = $datas;
        }
        

        // $result = array_merge($datas, $data_registration);
        
        return $result;
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
