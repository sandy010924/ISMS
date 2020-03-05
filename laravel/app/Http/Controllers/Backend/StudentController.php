<?php

namespace App\Http\Controllers\Backend;

use App\Model\Student;
use App\Model\Blacklist;
use App\Model\SalesRegistration;
use App\Model\Payment;
use App\Model\Registration;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class StudentController extends Controller
{
    // 刪除 Rocky (2020/02/23)
    public function delete(Request $request)
    {
        $status = "";
        $id_student = $request->get('id_student');

        // 查詢是否有該筆資料
        $student = Student::where('id', $id_student)->get();
        $registration = Registration::where('id_student', $id_student)->get();
        $sales_registration = SalesRegistration::where('id_student', $id_student)->get();
        $payment = Payment::where('id_student', $id_student)->get();
        
        
         // 刪除資料
        
        if (!empty($student) || !empty($sales_registration) || !empty($payment) || !empty($registration)) {
            $sales_registration = SalesRegistration::where('id_student', $id_student)->delete();
            $registration= Registration::where('id_student', $id_student)->delete();
            $payment= Payment::where('id_student', $id_student)->delete();
            $student = Student::where('id', $id_student)->delete();
            
            $status = "ok";
        } else {
            $status = "error";
        }
        return json_encode(array('data' => $status));
    }

    // 加入黑名單 Rocky (2020/02/23)
    public function blacklist(Request $request)
    {
        $status = "";
        $id_blacklist = "";
        $id_student = $request->get('id_student');
        $blacklist = new Blacklist;
        
        // 更新資料 -> 學員資料
        $student = Student::where('id', $id_student)
                    ->update(['check_blacklist' => '1']);

        // 新增資料 -> 黑名單資料表
        if ($student != 0) {
            // 新增學員資料
            $blacklist->id_student       = $id_student;         // 學員ID
            $blacklist->reason           = '';                  // 原因
           
            $blacklist->save();
            $id_blacklist = $blacklist->id;
        }
        
        if (!empty($id_blacklist)) {
            $status = "ok";
        } else {
            $status = "error";
        }
        return json_encode(array('data' => $status));
    }
}
