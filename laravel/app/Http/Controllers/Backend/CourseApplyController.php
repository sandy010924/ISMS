<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SalesRegistration;
use App\Model\Student;
use App\Model\ISMSStatus;
use App\Model\Course;

class CourseApplyController extends Controller
{
    public function update(Request $request)
    {
        //取回data
        $apply_id = $request->input('apply_id');
        $apply_status = $request->input('apply_status');
        try{
            if( $apply_status == 1){
                SalesRegistration::where('id', '=', $apply_id)
                                ->update(['id_status' => 5]);
            }
            else{
                SalesRegistration::where('id', '=', $apply_id)
                                ->update(['id_status' => 1]);
            }
            
            $new_apply = SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
                                        ->join('student', 'student.id', '=', 'sales_registration.id_student')
                                        ->select('sales_registration.id as apply_id', 'student.name as apply_name', 'sales_registration.id_status as apply_status_val', 'isms_status.name as apply_status_name')
                                        ->Where('sales_registration.id','=', $apply_id)
                                        ->get();
        
            return $new_apply;

        }catch (Exception $e) {
            return json_encode(array(
                'errorMsg' => '報名狀態修改失敗'
            ));
        }

    }

}
