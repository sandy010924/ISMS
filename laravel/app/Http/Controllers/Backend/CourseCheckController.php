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
    /*** 現場報名 ***/
    public function apply(Request $request)
    {
        try{
            //讀取data
            $id_course = $request->get('form_course_id');
            $new_name = $request->get('new_name');
            $new_phone = $request->get('new_phone');
            $new_email = $request->get('new_email');
            $new_address = $request->get('new_address');
            $new_profession = $request->get('new_profession');
            $new_pay = $request->get('new_paymodel');
            $new_account = $request->get('new_account');

            $course = new Course;
            $student = new Student;
            $SalesRegistration = new SalesRegistration;

            //判斷系統是否已有該學員資料
            $check_student = $student::where('phone', $new_phone)->get();


            /*學員報名資料 - S*/

            // 檢查學生資料
            if (count($check_student) != 0) {
                foreach ($check_student as $data_student) {
                    $id_student = $data_student ->id;
                }
            } else{
                // 新增學員資料
                $student->name          = $new_name;         // 學員姓名
                $student->sex           = '';                // 性別
                $student->id_identity   = '';                // 身分證
                $student->phone         = $new_phone;        // 電話
                $student->email         = $new_email;        // email
                $student->birthday      = '';                // 生日
                $student->company       = '';                // 公司
                $student->profession    = $new_profession;   // 職業
                if ($new_address != "") {
                    $student->address       = $new_address;  // 居住地
                }
                
                $student->save();
                $id_student = $student->id;
            }
            /*學員報名資料 - E*/


            /*銷售講座報名資料 - S*/

            $check_SalesRegistration = $SalesRegistration::where('id_student', $id_student)
                                                            ->where('id_course', $id_course)
                                                            ->get();
        
            // 檢查是否報名過
            if (count($check_SalesRegistration) == 0 && $id_student != "") {
                // 新增銷售講座報名資料
                if ($id_course != "" && $id_student != "") {
                    $date = date('Y-m-d H:i:s');
                    $SalesRegistration->submissiondate   = $date;                           // Submission Date
                    $SalesRegistration->datasource       = 'site';                          // 表單來源
                    $SalesRegistration->id_student      = $id_student;                      // 學員ID
                    $SalesRegistration->id_course       = $id_course;                       // 課程ID
                    $SalesRegistration->id_status       = 4;                                // 報名狀態ID
                    
                    if ($new_pay != '') {
                        $SalesRegistration->pay_model       = $new_pay;              // 付款方式
                    }
                    if ($new_account != '') {
                        $SalesRegistration->account         = $new_account;          // 帳號/卡號後五碼
                    }
                    $SalesRegistration->course_content  = '';                 // 想聽到的課程有哪些
                    $SalesRegistration->memo  = '現場報名';                 // 報名備註
                    
                    $SalesRegistration->save();
                    $id_SalesRegistration = $SalesRegistration->id;
                }
            } else {
                foreach ($check_SalesRegistration as $data_SalesRegistration) {
                    $id_SalesRegistration = $data_SalesRegistration ->id;
                }
            }
            
            /*銷售講座報名資料 - E*/
            if ($id_student != "" && $id_course != "" && $id_SalesRegistration != "") {
                return redirect()->route('course_check', ['id' => $id_course])->with('status', '報名成功');
            } else {
                return redirect()->route('course_check', ['id' => $id_course])->with('status', '報名失敗');
            }
        } catch (\Exception $e) {
            return redirect()->route('course_check', ['id' => $id_course])->with('status', '報名失敗');
            // return json_encode(array(
            //     'errorMsg' => '儲存失敗'
            // ));
        }

    }

    /*** 報到狀態改寫 ***/
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
                                        ->select('sales_registration.id as check_id', 'student.name as check_name', 'sales_registration.id_course as id_course', 'sales_registration.id_status as check_status_val', 'isms_status.name as check_status_name')
                                        ->Where('sales_registration.id','=', $check_id)
                                        ->get();

            
            //報名筆數
            $count_apply = count($new_check);
            //報到筆數
            $count_check = count(SalesRegistration::Where('id_course','=', $new_check[0]->id_course)
                ->Where('id_status','=', 4)
                ->get());
            //取消筆數
            $count_cancel = count(SalesRegistration::Where('id_course','=', $new_check[0]->id_course)
                ->Where('id_status','=', 5)
                ->get());
                
            // return Response($new_check, $count_apply, $count_check, $count_cancel);
            return Response($new_check);

        }catch (Exception $e) {
            return json_encode(array(
                'errorMsg' => '報到狀態修改失敗'
            ));
        }

    }

    /*** 課程資料儲存 ***/
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
