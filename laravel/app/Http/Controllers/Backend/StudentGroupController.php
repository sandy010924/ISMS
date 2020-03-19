<?php

namespace App\Http\Controllers\Backend;

use App\Model\StudentGroup;
use App\Model\StudentGroupdetail;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class StudentGroupController extends Controller
{
    // 刪除學員資料 Rocky (2020/02/23)
    // public function delete(Request $request)
    // {
    //     $status = "";
    //     $id_student = $request->get('id_student');

    //     // 查詢是否有該筆資料
    //     $student = Student::where('id', $id_student)->get();
    //     $registration = Registration::where('id_student', $id_student)->get();
    //     $sales_registration = SalesRegistration::where('id_student', $id_student)->get();
    //     $payment = Payment::where('id_student', $id_student)->get();
        
        
    //      // 刪除資料
        
    //     if (!empty($student) || !empty($sales_registration) || !empty($payment) || !empty($registration)) {
    //         $sales_registration = SalesRegistration::where('id_student', $id_student)->delete();
    //         $registration= Registration::where('id_student', $id_student)->delete();
    //         $payment= Payment::where('id_student', $id_student)->delete();
    //         $student = Student::where('id', $id_student)->delete();
            
    //         $status = "ok";
    //     } else {
    //         $status = "error";
    //     }
    //     return json_encode(array('data' => $status));
    // }


    // 標記儲存 (2020/03/10)
    public function save(Request $request)
    {
        $title = $request->get('title');
        $array_studentid = $request->get('array_studentid');

        // echo $array_studentid;
        // return $array_studentid;
        

        $StudentGroup = new StudentGroup;
        $StudentGroupdetail = new StudentGroupdetail;
        

        // 新增細分組資料
        $StudentGroup->name       = $title;         // 細分組名稱
                
        $StudentGroup->save();
        $id_StudentGroup = $StudentGroup->id;

        if (!empty($id_StudentGroup)) {
            foreach ($array_studentid as $key => $data) {
                // 新增細分組詳細資料
                $StudentGroupdetail->id_student     = $data['id'];           // 學生ID
                $StudentGroupdetail->id_group       = $id_StudentGroup;      // 細分組ID

                $StudentGroupdetail->save();
            }
            
            $id_StudentGroupdetail = $StudentGroupdetail->id;
        }

        if (!empty($id_StudentGroupdetail)) {
            return '儲存成功';
        } else {
            return '更新失敗';
        }
    }
}
