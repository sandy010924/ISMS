<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Student;
use App\Model\ISMSStatus;
use App\Model\Course;
use App\Model\EventsCourse;

class CourseApplyController extends Controller
{
    public function update(Request $request)
    {
        //取回data
        $course_id = $request->input('course_id');
        $course_type = $request->input('course_type');
        $apply_id = $request->input('apply_id');
        $apply_status = $request->input('apply_status');
        $new_apply = "";
        $count_check = 0;
        $count_cancel = 0;


        try{
            //判斷是銷講or正課
            if($course_type == 1){
                //銷講
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
                                            // ->select('sales_registration.id as apply_id', 'student.name as apply_name', 'sales_registration.id_status as apply_status_val', 'isms_status.name as apply_status_name')
                                            ->select('student.name as name', 'sales_registration.id as id', 'sales_registration.id_status as id_status', 'isms_status.name as status_name')
                                            ->Where('sales_registration.id','=', $apply_id)
                                            ->get();
            
                //報到筆數
                $count_check = count(SalesRegistration::Where('id_events', $list->id_events)
                    ->Where('id_status','=', 4)
                    ->get());
                //取消筆數
                $count_cancel = count(SalesRegistration::Where('id_events', $list->id_events)
                    ->Where('id_status','=', 5)
                    ->get());
            }else{
                //正課
                if( $apply_status == 1){
                    Registration::where('id', '=', $apply_id)
                                    ->update(['id_status' => 5]);
                }
                else{
                    Registration::where('id', '=', $apply_id)
                                    ->update(['id_status' => 1]);
                }
                
                $new_apply = Registration::join('isms_status', 'isms_status.id', '=', 'registration.id_status')
                                            ->join('student', 'student.id', '=', 'registration.id_student')
                                            // ->select('registration.id as apply_id', 'student.name as apply_name', 'registration.id_status as apply_status_val', 'isms_status.name as apply_status_name')
                                            ->select('student.name as name', 'registration.id as id', 'registration.id_status as id_status', 'isms_status.name as status_name')
                                            ->Where('registration.id','=', $apply_id)
                                            ->first();
            
                //報到筆數
                $count_check = count(Registration::Where('id_events', $course_id)
                    ->Where('id_status','=', 4)
                    ->get());
                //取消筆數
                $count_cancel = count(Registration::Where('id_events', $course_id)
                    ->Where('id_status','=', 5)
                    ->get());
            }

            // return $new_apply;
            return Response(array('list'=>$new_apply, 'count_check'=>$count_check, 'count_cancel'=>$count_cancel));

        }catch (Exception $e) {
            return json_encode(array(
                'errorMsg' => '報名狀態修改失敗'
            ));
        }

    }

}
