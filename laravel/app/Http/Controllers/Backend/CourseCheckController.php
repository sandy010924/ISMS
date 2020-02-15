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
    public function update_status(Request $request)
    {
        //取回data
        $check_id = $request->input('check_id');
        $check_value = $request->input('check_value');
        $update_status = $request->input('update_status');
        try{
            switch($update_status){
                case 'check_btn':
                    //報到/未到
                    if( $check_value == 4){
                        SalesRegistration::where('id', '=', $check_id)
                                        ->update(['id_status' => 3]);
                    }
                    else{
                        SalesRegistration::where('id', '=', $check_id)
                                        ->update(['id_status' => 4]);
                    }
                    break;
                case 'dropdown_check':
                    //報到
                    SalesRegistration::where('id', '=', $check_id)
                                    ->update(['id_status' => 4]);
                    break;
                case 'dropdown_absent':
                    //未到
                    SalesRegistration::where('id', '=', $check_id)
                                    ->update(['id_status' => 3]);
                    break;
                case 'dropdown_cancel':
                    //取消
                    SalesRegistration::where('id', '=', $check_id)
                                    ->update(['id_status' => 5]);
                    break;
                default:
                    //報到
                    SalesRegistration::where('id', '=', $check_id)
                                    ->update(['id_status' => 4]);
                    break;
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

    public function update_data(Request $request)
    {
        //取回data
        $course_id = $request->input('course_id');
        $data_type = $request->input('data_type');
        $data_val = $request->input('data_val');

        try{
            switch($data_type){
                case 'host':
                    //主持開場
                    Course::where('id', $course_id)
                          ->update(['host' => $data_val]);
                    break;
                case 'closeOrder':
                    //結束收單
                    Course::where('id', $course_id)
                          ->update(['closeOrder' => $data_val]);
                    break;
                case 'weather':
                    //天氣
                    Course::where('id', $course_id)
                          ->update(['weather' => $data_val]);
                    break;
                case 'staff':
                    //工作人員
                    Course::where('id', $course_id)
                          ->update(['staff' => $data_val]);
                    break;
                case 'checkNote':
                    //報到備註
                    $data_id = $request->input('data_id');
                    
                    SalesRegistration::where('id', $data_id)
                                     ->update(['memo' => $data_val]);
                    break;
                default:
                    return 'error';
                    break;

            }
        
            return 'success';

        }catch (Exception $e) {
            return 'error';
            // return json_encode(array(
            //     'errorMsg' => '儲存失敗'
            // ));
        }

    }


    // public function update(Request $request)
    // {
    //     //取回data
    //     $check_id = $request->input('check_id');
    //     $check_status = $request->input('check_status');
    //     try{
    //         if( $check_status == 4){
    //             SalesRegistration::where('id', '=', $check_id)
    //                             ->update(['id_status' => 3]);
    //         }
    //         else{
    //             SalesRegistration::where('id', '=', $check_id)
    //                             ->update(['id_status' => 4]);
    //         }
            
    //         $new_check = SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
    //                                     ->join('student', 'student.id', '=', 'sales_registration.id_student')
    //                                     ->select('sales_registration.id_course as ','sales_registration.id as check_id', 'student.name as check_name', 'sales_registration.id_status as check_status_val', 'isms_status.name as check_status_name')
    //                                     ->Where('sales_registration.id','=', $check_id)
    //                                     ->get();

    //         // $id_course = SalesRegistration::select('sales_registration.id_course')
    //         //         ->Where('sales_registration.id','=', $check_id)
    //         //         ->get();  

    //         // //報名資訊
    //         // $coursechecks = SalesRegistration::Where('id_course','=', $id_course[0])
    //         //                                 ->where(function($q) { 
    //         //                                     $q->where('id_status', 3)
    //         //                                         ->orWhere('id_status', 4)
    //         //                                         ->orWhere('id_status', 5);
    //         //                                 })
    //         //                                 ->get();
    //         // //報名比數
    //         // $count_apply = count($coursechecks);
    //         // //報到比數
    //         // $count_check = count(SalesRegistration::Where('id_course','=', $new_check[0].id_course)
    //         //     ->Where('id_status','=', 4)
    //         //     ->get());
                
    //         return $new_check;


    //     }catch (Exception $e) {
    //         return json_encode(array(
    //             'errorMsg' => '報到狀態修改失敗'
    //         ));
    //     }

    // }

}
