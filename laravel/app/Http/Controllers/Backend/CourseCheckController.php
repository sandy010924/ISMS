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
use App\Model\Register;
use App\Model\Mark;
use App\Model\Activity;

class CourseCheckController extends Controller
{
    //現場報名(只限銷講、活動)
    public function insert(Request $request)
    {
        try{
            //讀取data
            $id_events = $request->get('form_event_id');
            $type = $request->get('form_event_type');

            $new_name = $request->get('new_name');
            $new_phone = $request->get('new_phone');
            $new_email = $request->get('new_email');
            $new_address = $request->get('new_address');
            $new_profession = $request->get('new_profession');

            //如果是銷講則加上付款方式、卡號後五碼
            if( $type == 1 ){
                $new_pay = $request->get('new_paymodel');
                $new_account = $request->get('new_account');
            }

            //取得課程資訊
            $item_event = EventsCourse::select('id_course')
                                ->where('id', $id_events)->get();
            $id_course = $item_event[0]['id_course'];

            //判斷系統是否已有該學員資料
            $check_student = Student::where('name', $new_name)
                                     ->where('phone', $new_phone)
                                     ->where('email', $new_email)
                                     ->get();


            /*學員報名資料 - S*/

            // 檢查學生資料
            if (count($check_student) != 0) {
                foreach ($check_student as $data_student) {
                    $id_student = $data_student->id;
                }

                //更新學員資料
                Student::where('id', $id_student)
                        ->update(['profession' => $new_profession]);
            } else{
                $student = new Student;

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


            /* 報名資料 - S*/
            if( $type == 1 ){
                //銷講

                $check_SalesRegistration = SalesRegistration::where('id_student', $id_student)
                                                                ->where('id_events', $id_events)
                                                                ->get();
            
                // 檢查是否報名過
                if (count($check_SalesRegistration) == 0 && $id_student != "") {
                    // 新增銷售講座報名資料
                    if ($id_events != "" && $id_student != "") {   
                        $SalesRegistration = new SalesRegistration;

                        // Submission Date
                        $date = date('Y-m-d H:i:s');
                        $SalesRegistration->submissiondate   = $date;                         
                        // 表單來源
                        $SalesRegistration->datasource       = '現場';                   
                        // 學員ID
                        $SalesRegistration->id_student      = $id_student;                      
                        // 課程ID 
                        $SalesRegistration->id_course       = $id_course;  
                        // 場次ID 
                        $SalesRegistration->id_events       = $id_events;   
                        // 報名狀態ID
                        $SalesRegistration->id_status       = 4;                                
                        
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
            }else if( $type == 4 ){
                //活動

                $check_activity = Activity::where('id_student', $id_student)
                                        ->where('id_events', $id_events)
                                        ->get();
            
                // 檢查是否報名過
                if (count($check_activity) == 0 && $id_student != "") {
                    // 新增銷售講座報名資料
                    if ($id_events != "" && $id_student != "") {   
                        $activity = new Activity;

                        // Submission Date
                        $date = date('Y-m-d H:i:s');
                        $activity->submissiondate   = $date;                         
                        // 表單來源
                        $activity->datasource       = '現場';                   
                        // 學員ID
                        $activity->id_student      = $id_student;                      
                        // 課程ID 
                        $activity->id_course       = $id_course;  
                        // 場次ID 
                        $activity->id_events       = $id_events;   
                        // 報名狀態ID
                        $activity->id_status       = 4;                                
                        
                        $activity->course_content  = '';                 // 想聽到的課程有哪些
                        $activity->memo  = '現場報名';                 // 報名備註
                        
                        $activity->save();
                        $id_activity = $activity->id;
                    }
                } else {
                    foreach ($check_activity as $data_activity) {
                        $id_activity = $data_activity ->id;
                    }
                }
            }
            
            /*銷售講座報名資料 - E*/
            if ($id_student != "" && $id_events != "" && $id_SalesRegistration != "" || $id_activity != "") {
                return redirect()->route('course_check', ['id' => $id_events])->with('status', '報名成功');
            } else {
                return redirect()->route('course_check', ['id' => $id_events])->with('status', '報名失敗');
            }
        } catch (\Exception $e) {
            return redirect()->route('course_check', ['id' => $id_events])->with('status', '報名失敗');
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
        $course_type = $request->input('course_type');
        $check_value = $request->input('check_value');
        $update_status = $request->input('update_status');

        try{
            //判斷是銷講or正課
            if($course_type == 1){
                //銷講
                $db_check = SalesRegistration::where('id', $check_id);
            }else if($course_type == 2 || $course_type == 3){
                //正課
                $db_check = Register::where('id', $check_id);                  
            }else if($course_type == 4){
                //活動
                $db_check = Activity::where('id', $check_id);
            }

            switch($update_status){
                case 'check_btn':
                    //報到/未到
                    if( $check_value == 4){
                        $db_check->update(['id_status' => 3]);
                    }
                    else{
                        $db_check->update(['id_status' => 4]);
                    }
                    break;
                case 'dropdown_check':
                    //報到
                    $db_check->update(['id_status' => 4]);
                    break;
                case 'dropdown_absent':
                    //未到
                    $db_check->update(['id_status' => 3]);
                    break;
                case 'dropdown_cancel':
                    //取消
                    $db_check->update(['id_status' => 5]);
                    break;
                default:
                    //報到
                    $db_check->update(['id_status' => 4]);
                    break;
            }
                       
            
            
            //判斷是銷講or正課
            if($course_type == 1){
                //銷講
                $list = SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
                                            ->join('student', 'student.id', '=', 'sales_registration.id_student')
                                            ->select('sales_registration.id as check_id', 'student.name as check_name', 'sales_registration.id_events as id_events', 'sales_registration.id_status as check_status_val', 'isms_status.name as check_status_name')
                                            ->Where('sales_registration.id','=', $check_id)
                                            ->first();

                
                //報到筆數
                $count_check = count(SalesRegistration::Where('id_events', $list->id_events)
                    ->Where('id_status','=', 4)
                    ->get());
                //取消筆數
                $count_cancel = count(SalesRegistration::Where('id_events', $list->id_events)
                    ->Where('id_status','=', 5)
                    ->get());
            }else if($course_type == 2 || $course_type == 3){
                //正課
                $list = Register::join('isms_status', 'isms_status.id', '=', 'register.id_status')
                                ->join('student', 'student.id', '=', 'register.id_student')
                                ->join('registration', 'registration.id', '=', 'register.id_registration')
                                ->select('register.id as check_id', 
                                        'register.id_events as id_events', 
                                        'register.id_status as check_status_val', 
                                        'register.id_registration as id_registration', 
                                        'registration.id_course as id_course', 
                                        'student.id as id_student', 
                                        'student.name as check_name', 
                                        'isms_status.name as check_status_name')
                                ->Where('register.id','=', $check_id)
                                ->first();

                
                //報到筆數
                $count_check = count(Register::Where('id_events', $list->id_events)
                    ->Where('id_status','=', 4)
                    ->get());
                //取消筆數
                $count_cancel = count(Register::Where('id_events', $list->id_events)
                    ->Where('id_status','=', 5)
                    ->get());
                
                

                /* 正課報到標籤 */
                $register = Register::join('registration', 'registration.id', '=', 'register.id_registration')
                                    ->join('events_course', 'events_course.id', '=', 'register.id_events')
                                    ->select('register.*', 'registration.id_course as id_course')
                                    ->where('registration.id_student', $list->id_student)
                                    ->where('registration.id_course', $list->id_course)
                                    ->where('register.id_status', 4)
                                    ->orderby('events_course.course_start_at', 'desc')
                                    ->first();
                                    
                // if($update_status=='dropdown_check' || ($update_status=='check_btn' && $check_value != 4)){
                if( !empty($register) ){
                    //至少一天報到

                    // 檢查是否標記過
                    $check_mark = Mark::where('id_course', $register->id_course)
                                    ->where('id_student', $register->id_student)
                                    ->get();

                    $course = Course::select('id', 'name')->where('id', $register->id_course)->first();

                    if ( count($check_mark) == 0 ) {
                        //沒有標記過

                        // 新增標記資料
                        $mark = new Mark;

                        $mark->id_student    = $register->id_student;         // 學員ID
                        $mark->name_mark     = $course->name . '學員';          // 標記名稱
                        // $mark->name_course   = $name_course;  // 課程名稱
                        $mark->id_course     = $course->id;        // 課程ID
                        $mark->id_events     = $register->id_events;        // 場次ID
                        
                        $mark->save();
                        $id_mark = $mark->id;
                    }else{
                        //有標記過 
                        
                        //更新付款資料
                        Mark::where('id_course', $course->id)
                            ->where('id_student', $register ->id_student)
                            ->update([
                                'id_events' => $register->id_events,
                            ]);
                    }
                    // $group = Register::where('id_registration' ,$register->id_registration)
                    //                 ->orderby('id_events', desc)
                    //                 ->first();

                    // $registration = Registration::where('id' ,$register->id_registration)
                    //                 ->first();
                }else{
                    //皆無報到

                    /* 刪除標記 */
                    Mark::where('id_course', $list->id_course)
                        ->where('id_student', $list->id_student)
                        ->delete();
                }
            

            }else if($course_type == 4){
                //活動
                $list = Activity::join('isms_status', 'isms_status.id', '=', 'activity.id_status')
                                ->join('student', 'student.id', '=', 'activity.id_student')
                                ->select('activity.id as check_id', 
                                        'activity.id_events as id_events', 
                                        'activity.id_status as check_status_val',
                                        'activity.id_course as id_course',  
                                        'student.id as id_student',
                                        'student.name as check_name', 
                                        'isms_status.name as check_status_name')
                                ->Where('activity.id','=', $check_id)
                                ->first();

                
                //報到筆數
                $count_check = count(Activity::Where('id_events', $list->id_events)
                    ->Where('id_status','=', 4)
                    ->get());
                //取消筆數
                $count_cancel = count(Activity::Where('id_events', $list->id_events)
                    ->Where('id_status','=', 5)
                    ->get());

                
                /* 活動報到標籤 */
                $register = Activity::join('events_course', 'events_course.id', '=', 'activity.id_events')
                                    ->where('activity.id_student', $list->id_student)
                                    ->where('activity.id_course', $list->id_course)
                                    ->where('activity.id_status', 4)
                                    ->orderby('events_course.course_start_at', 'desc')
                                    ->first();
                                    
                // if($update_status=='dropdown_check' || ($update_status=='check_btn' && $check_value != 4)){
                if( !empty($register) ){
                    //至少一天報到

                    // 檢查是否標記過
                    $check_mark = Mark::where('id_course', $register->id_course)
                                    ->where('id_student', $register->id_student)
                                    ->get();

                    $course = Course::select('id', 'name')->where('id', $register->id_course)->first();

                    if ( count($check_mark) == 0 ) {
                        //沒有標記過

                        // 新增標記資料
                        $mark = new Mark;

                        $mark->id_student    = $register->id_student;         // 學員ID
                        $mark->name_mark     = $course->name . '學員';          // 標記名稱
                        // $mark->name_course   = $name_course;  // 課程名稱
                        $mark->id_course     = $course->id;        // 課程ID
                        $mark->id_events     = $register->id_events;        // 場次ID
                        
                        $mark->save();
                        $id_mark = $mark->id;
                    }else{
                        //有標記過 
                        
                        //更新付款資料
                        Mark::where('id_course', $course->id)
                            ->where('id_student', $register ->id_student)
                            ->update([
                                'id_events' => $register->id_events,
                            ]);
                    }
                    // $group = Register::where('id_registration' ,$register->id_registration)
                    //                 ->orderby('id_events', desc)
                    //                 ->first();

                    // $registration = Registration::where('id' ,$register->id_registration)
                    //                 ->first();

                    

                }else{
                    //皆無報到

                    /* 刪除標記 */
                    Mark::where('id_course', $list->id_course)
                        ->where('id_student', $list->id_student)
                        ->delete();
                }
            }
                
            return Response(array('list'=>$list, 'count_check'=>$count_check, 'count_cancel'=>$count_cancel));

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
        $event_id = $request->input('event_id');
        $course_type = $request->input('course_type');
        $data_type = $request->input('data_type');
        $data_val = $request->input('data_val');

        try{
            switch($data_type){
                case 'host':
                    //主持開場
                    EventsCourse::where('id', $event_id)
                          ->update(['host' => $data_val]);
                    break;
                case 'closeorder':
                    //結束收單
                    EventsCourse::where('id', $event_id)
                          ->update(['closeorder' => $data_val]);
                    break;
                case 'weather':
                    //天氣
                    EventsCourse::where('id', $event_id)
                          ->update(['weather' => $data_val]);
                    break;
                case 'staff':
                    //工作人員
                    EventsCourse::where('id', $event_id)
                          ->update(['staff' => $data_val]);
                    break;
                case 'checkNote':
                    //報到備註
                    $data_id = $request->input('data_id');

                    //判斷是銷講or正課
                    if( $course_type == 1 ){
                        //銷講
                        SalesRegistration::where('id', $data_id)
                                         ->update(['memo' => $data_val]);
                    }else if($course_type == 2 || $course_type == 3){
                        //正課
                        Register::where('id', $data_id)
                                    ->update(['memo' => $data_val]);
                    }else if( $course_type == 4 ){
                        //活動
                        Activity::where('id', $data_id)
                                ->update(['memo' => $data_val]);
                    }
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


    /*** 修改資料  Sandy(2020/06/28) ***/
    public function edit(Request $request)
    {
        //讀取data
        $id_events = $request->get('edit_idevents');
        $type = $request->get('edit_type');
        $id = $request->get('edit_id');
        $name = $request->get('edit_name');
        $phone = $request->get('edit_phone');
        $email = $request->get('edit_email');
        $address = $request->get('edit_address');
        $profession = $request->get('edit_profession');

        //如果是銷講則加上付款方式、卡號後五碼
        if( $type == 1 ){
            $pay_model = $request->get('edit_paymodel');
            $account = $request->get('edit_account');
        }
        
        try{

            /*學員報名資料 - S*/

            //判斷系統是否已有該學員資料
            $check_student = Student::where('name', $name)
                                    ->where('phone', $phone)
                                    ->where('email', $email)
                                    ->get();

            // 檢查學員資料
            if (count($check_student) != 0) {

                foreach ($check_student as $data_student) {
                    $id_student = $data_student->id;
                }

                if($name == ""){
                    $name = Student::where('id', $id_student)->first()->name;
                }
                if($email == ""){
                    $email = Student::where('id', $id_student)->first()->email;
                }
                
                //如果原本有地址就不更新地址
                $old_address = Student::where('id', $id_student)->first()->address;
                if($old_address != ""){
                    $address = $old_address;
                }
                    
                if($profession == ""){
                    $profession = Student::where('id', $id_student)->first()->profession;
                }

                //更新學員資料
                Student::where('id', $id_student)
                    ->update([
                        'address' => $address,
                        'profession' => $profession,
                    ]);
            } 
            /*學員報名資料 - E*/


            /*報名資料 - S*/

            if( $type == 1 ){
                //銷講

                //判斷系統是否已有該報名資料
                $check_salesregistration = SalesRegistration::where('id', $id)->get();

                // 檢查報名資料
                if (count($check_salesregistration) != 0) {

                    // if($pay_model == ""){
                    //     $pay_model = SalesRegistration::where('id', $id)->first()->pay_model;
                    // }
                    // if($account == ""){
                    //     $account = SalesRegistration::where('id', $id)->first()->account;
                    // }

                    SalesRegistration::where('id', $id)->update([
                        'pay_model' => $pay_model,
                        'account' => $account,
                    ]);                     
                }
            }
            // else if( $type == 4 ){
            //     //活動

            //     //判斷系統是否已有該報名資料
            //     $check_activity = Activity::where('id', $id)->get();

            //     // 檢查報名資料
            //     if (count($check_activity) != 0) {
            //         Activity::where('id', $id)->update([
            //             'pay_model' => $pay_model,
            //             'account' => $account,
            //         ]);                     
            //     }
            // }
            
        
            /*報名資料 - E*/
            
            return redirect()->route('course_check', ['id' => $id_events])->with('status', '修改成功');
        
        }catch (Exception $e) {
            return redirect()->route('course_check', ['id' => $id_events])->with('status', '修改失敗');
        }
    }

    /*** 刪除資料 Sandy (2020/06/28) ***/
    public function delete(Request $request)
    {
        $status = "";
        $type = $request->get('type');
        $id_apply = $request->get('id_apply');
            
        if($type == 1){
            //銷講
            $sale = SalesRegistration::where('id', $id_apply)
                                      ->get();

            if( count($sale) != 0 ){
                //刪除報名表
                SalesRegistration::where('id', $id_apply)->delete();
            }

            $status = "ok";
            
        }elseif( $type == 2 || $type == 3) {
            //正課
            $formal = Registration::where('id', $id_apply)
                                  ->get();

            if( count($formal) != 0 ){
                //刪除報到表
                Register::where('id_registration', $id_apply)->delete();
                //刪除付款表
                Debt::where('id_registration', $id_apply)->delete();   
                //刪除追單表
                Payment::where('id_registration', $id_apply)->delete();
                //刪除退費
                Refund::where('id_registration', $id_apply)->delete();   
                //刪除報名表
                Registration::where('id', $id_apply)->delete();
            }

            $status = "ok";

        }else if($type == 4){
            //活動
            $activity = Activity::where('id', $id_apply)
                                      ->get();

            if( count($activity) != 0 ){
                //刪除報名表
                Activity::where('id', $id_apply)->delete();
            }

            $status = "ok";
            
        }else {
            $status = "error";
        }
        
         return json_encode($status);
    }

}
