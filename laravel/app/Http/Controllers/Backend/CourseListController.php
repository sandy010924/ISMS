<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Student;
use App\Model\SalesRegistration;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class CourseListController extends Controller
{
     // 刪除 Sandy (2020/02/25)
     public function delete(Request $request)
     {
         $status = "";
         $id_course = $request->get('id_course');
         
         foreach ($id_course as $key => $data) {
            // 查詢是否有該筆資料
            $course = Course::where('id', $data['id'])->get();
    
            $sales_registration = SalesRegistration::where('id_course', $data['id'])->get();
    
            // 刪除資料
            if(!empty($course) && !empty($sales_registration)){
                $sales_registration = SalesRegistration::where('id_course', $data['id'])->delete();
                $course = Course::where('id', $data['id'])->delete();            
                $status = "ok";
            } else {
                $status = "error";
            }
         }
         return json_encode(array('data' => $status));
     }
}
