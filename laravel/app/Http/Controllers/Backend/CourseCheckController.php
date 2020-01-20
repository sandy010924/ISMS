<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SalesRegistration;
use App\Model\Student;
use App\Model\ISMSStatus;
use App\Model\Course;

class CourseCheckController extends Controller
{
    public function update(Request $request)
    {
        //取回data
        $check_id = $request->input('check_id');
        $check_status = $request->input('check_status');
        try{
            if( $check_status == 4){
                SalesRegistration::where('id', '=', $check_id)
                                ->update(['id_status' => 3]);
            }
            else{
                SalesRegistration::where('id', '=', $check_id)
                                ->update(['id_status' => 4]);
            }
            
            $new_check = SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
                                        ->join('student', 'student.id', '=', 'sales_registration.id_student')
                                        ->select('sales_registration.id_course as ','sales_registration.id as check_id', 'student.name as check_name', 'sales_registration.id_status as check_status_val', 'isms_status.name as check_status_name')
                                        ->Where('sales_registration.id','=', $check_id)
                                        ->get();

            // $id_course = SalesRegistration::select('sales_registration.id_course')
            //         ->Where('sales_registration.id','=', $check_id)
            //         ->get();  

            // //報名資訊
            // $coursechecks = SalesRegistration::Where('id_course','=', $id_course[0])
            //                                 ->where(function($q) { 
            //                                     $q->where('id_status', 3)
            //                                         ->orWhere('id_status', 4)
            //                                         ->orWhere('id_status', 5);
            //                                 })
            //                                 ->get();
            // //報名比數
            // $count_apply = count($coursechecks);
            // //報到比數
            // $count_check = count(SalesRegistration::Where('id_course','=', $new_check[0].id_course)
            //     ->Where('id_status','=', 4)
            //     ->get());
                
            return $new_check;


        }catch (Exception $e) {
            return json_encode(array(
                'errorMsg' => '報到狀態修改失敗'
            ));
        }

    }

    public function update_check(Request $request)
    {
        //取回data
        $check_id = $request->input('check_id');
        try{
            SalesRegistration::where('id', '=', $check_id)
                            ->update(['id_status' => 4]);
            
            $new_check = SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
                                        ->join('student', 'student.id', '=', 'sales_registration.id_student')
                                        ->select('sales_registration.id as check_id', 'student.name as check_name', 'sales_registration.id_status as check_status_val', 'isms_status.name as check_status_name')
                                        ->Where('sales_registration.id','=', $check_id)
                                        ->get();
        
            return $new_check;

        }catch (Exception $e) {
            return json_encode(array(
                'errorMsg' => '報到狀態修改失敗'
            ));
        }
    }

    public function update_absent(Request $request)
    {
        //取回data
        $check_id = $request->input('check_id');
        try{
            SalesRegistration::where('id', '=', $check_id)
                            ->update(['id_status' => 3]);
            
            $new_check = SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
                                        ->join('student', 'student.id', '=', 'sales_registration.id_student')
                                        ->select('sales_registration.id as check_id', 'student.name as check_name', 'sales_registration.id_status as check_status_val', 'isms_status.name as check_status_name')
                                        ->Where('sales_registration.id','=', $check_id)
                                        ->get();
        
            return $new_check;

        }catch (Exception $e) {
            return json_encode(array(
                'errorMsg' => '報到狀態修改失敗'
            ));
        }
    }

    public function update_cancel(Request $request)
    {
        //取回data
        $check_id = $request->input('check_id');
        try{
            SalesRegistration::where('id', '=', $check_id)
                            ->update(['id_status' => 5]);
            
            $new_check = SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
                                        ->join('student', 'student.id', '=', 'sales_registration.id_student')
                                        ->select('sales_registration.id as check_id', 'student.name as check_name', 'sales_registration.id_status as check_status_val', 'isms_status.name as check_status_name')
                                        ->Where('sales_registration.id','=', $check_id)
                                        ->get();
        
            //報名資訊
            // $coursechecks = SalesRegistration::Where('id_course','=', $new_check[0].id_course)
            //                                 ->where(function($q) { 
            //                                     $q->where('id_status', 3)
            //                                         ->orWhere('id_status', 4)
            //                                         ->orWhere('id_status', 5);
            //                                 })
            //                                 ->get();
            // //報名比數
            // $count_apply = count($coursechecks);
            // //報到比數
            // $count_check = count(SalesRegistration::Where('id_course','=', $new_check[0].id_course)
            //     ->Where('id_status','=', 4)
            //     ->get());
                
            // $new_check = array_push($new_check, ["count_apply"=>$count_apply, "count_check"=>$count_check]);
            //     dd($new_check);
            return $new_check;

        }catch (Exception $e) {
            return json_encode(array(
                'errorMsg' => '報到狀態修改失敗'
            ));
        }
    }
}
