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
        $pagesize = 15;

    // $students = Student::paginate($pagesize);
        
    //SELECT a.*,g.name as course_sales,h.name as course_registration,b.datasource,d.name as status_sales,e.name as status_registration FROM student a 
    //     LEFT JOIN sales_registration b on a.id = b.id_student
    //     LEFT JOIN registration c on a.id = c.id_student
    //     LEFT JOIN isms_status d on b.id_status = d.id
    //     LEFT JOIN isms_status e on c.id_status = e.id
    //     left join course g on g.id = b.id_course
    //     left join course h on h.id = c.id_course
    // ORDER BY a.created_at desc

        // $students = Student::leftjoin('sales_registration', 'student.id', '=', 'sales_registration.id_student')
        //                     ->leftjoin('registration', 'student.id', '=', 'registration.id_student')
        //                     ->leftjoin('isms_status as p1', 'p1.id', '=', 'sales_registration.id_status')
        //                     ->leftjoin('isms_status as p2', 'p2.id', '=', 'registration.id_status')
        //                     ->select('student.*', 'sales_registration.*', 'p1.name as status_name')
        //                     ->get();



        $students = Student::get();

        foreach ($students as $key => $data) {
            $students[$key] = [
                'id' => $data['id'],
                'name' => $data['name'],
                'sex' => $data['sex'],
                'id_identity' => $data['id_identity'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'birthday' => $data['birthday'],
                'company' => $data['company'],
                'profession' => $data['profession'],
                'address' => $data['address']
            ];
        }
        // echo "<pre>";
        // print_r($students);
        // die();
        
        return view('frontend.student', compact('students'));

        // dd($students);
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
                            ->select('registration.*', 'course.name as course')
                            ->where('registration.id', $id)
                            ->get();
        }

        return $datas;
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
