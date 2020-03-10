<?php

namespace App\Http\Controllers\Backend;

use App\Model\Mark;
use App\Model\Student;
use App\Model\Blacklist;
use App\Model\SalesRegistration;
use App\Model\Payment;
use App\Model\Registration;
use App\Model\Debt;
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

    // 儲存 Rocky (2020/03/07)
    public function save(Request $request)
    {
        $id = $request->get('id_student');
        $profession = $request->get('profession');
        $address = $request->get('address');


        $data = Student::where('id', $id)
        ->update(['profession' => $profession,'address' => $address]);
        
        if ($data) {
            return '更新成功';
        } else {
            return '更新失敗';
        }
    }

    /*** 課程資料儲存 ***/
    public function updatedata(Request $request)
    {
        //取回data
        $id = $request->input('id');
        $type = $request->input('type');
        $data = $request->input('data');

        // try{
        switch ($type) {
            case '0':
                // 日期時間
                Debt::where('id', $id)
                        ->update(['updated_at' => $data]);
                break;
            case '1':
                // 付款狀態/日期
                Debt::where('id', $id)
                        ->update(['status_payment' => $data]);
                break;
            case '2':
                // 聯絡內容
                Debt::where('id', $id)
                        ->update(['contact' => $data]);
                break;
            case '3':
                // 最新狀態
                Debt::where('id', $id)
                        ->update(['id_status' => $data]);
                break;
            case '4':
                // 設提醒
                Debt::where('id', $id)
                        ->update(['remind_at' => $data]);
                break;
            default:
                return 'error';
                break;
        }
        
            return 'success';

        // }catch (Exception $e) {
        //     return 'error';
        //     // return json_encode(array(
        //     //     'errorMsg' => '儲存失敗'
        //     // ));
        // }
    }

    // 標記儲存 (2020/03/10)
    public function tagsave(Request $request)
    {
        $id_student = $request->get('id_student');
        $name = $request->get('name');

        $mark = new Mark;

         // 新增學員資料
         $mark->id_student       = $id_student;         // 學員ID
         $mark->name_mark        = $name;               // 標記名稱
        
         $mark->save();
         $id_mark = $mark->id;


        if (!empty($id_mark)) {
            return '儲存成功';
        } else {
            return '更新失敗';
        }
    }
 




}
