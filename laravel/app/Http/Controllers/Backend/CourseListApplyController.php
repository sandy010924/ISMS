<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Uer;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Student;

class CourseListApplyController extends Controller
{
     // 刪除 Sandy (2020/03/08)
     public function delete(Request $request)
     {
        $type = $request->get('type');
        $id_apply = $request->get('id_apply');

        //判斷是銷講or正課
        if( $type == 1 ){
            // 銷講
            // 查詢是否有該筆資料
            $apply = SalesRegistration::where('id', $id_apply)->first();
        }else {
            // 正課
            // 查詢是否有該筆資料
            $apply = Registration::where('id', $id_apply)->first();
        }
        
        

        if(!empty($apply)){
            //刪除報名表
            $apply->delete();     

            $status = "ok";
        } else {
            $status = "error";
        }
        //  }
         return json_encode(array('data' => $status));
     }
}
