<?php

namespace App\Http\Controllers\Backend;

use App\Model\Mark;
use App\Model\Debt;
use App\Model\Refund;
use App\Model\Student;
use App\Model\Payment;
use App\Model\Activity;
use App\Model\Register;
use App\Model\Blacklist;
use App\Model\Registration;
use App\Model\EventsCourse;
use App\Model\SalesRegistration;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class StudentController extends Controller
{
    // 刪除學員資料 Rocky (2020/02/23)
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
            $registration = Registration::where('id_student', $id_student)->delete();
            $payment = Payment::where('id_student', $id_student)->delete();
            Refund::where('id_student', $id_student)->delete();
            Debt::where('id_student', $id_student)->delete();
            Blacklist::where('id_student', $id_student)->delete();
            Mark::where('id_student', $id_student)->delete();
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
        $reason = $request->get('reason');
        $blacklist = new Blacklist;


        // 查詢是否有該筆資料
        $student_data = Blacklist::where('id_student', $id_student)->get();

        if (count($student_data) == 0) {
            // 更新資料 -> 學員資料
            $student = Student::where('id', $id_student)
                ->update(['check_blacklist' => '1']);

            // 新增資料 -> 黑名單資料表
            if ($student != 0) {
                // 新增學員資料
                $blacklist->id_student       = $id_student;         // 學員ID
                $blacklist->reason           = $reason;             // 原因

                $blacklist->save();
                $id_blacklist = $blacklist->id;

                // 新增標記資料 Rocky(2020/08/05)
                $mark = new Mark;
                
                $mark->id_student       = $id_student;         // 學員ID
                $mark->name_mark        = '黑名單';            // 標記名稱

                $mark->save();
                $id_mark = $mark->id;
            }

            if (!empty($id_blacklist) && !empty($id_mark)) {
                $status = "ok";
            } else {
                $status = "error";
            }
        } else {
            $status = '已加入';
        }

        return json_encode(array('data' => $status));
    }

    // 儲存 Rocky (2020/03/07)
    public function save(Request $request)
    {
        $id = $request->get('id_student');
        $profession = $request->get('profession');
        $address = $request->get('address');
        $sales_registration_old = $request->get('sales_registration_old');
        $old_datasource = $request->get('old_datasource');
        $student_phone = $request->get('student_phone');
        $student_name = $request->get('student_name');
        $student_email = $request->get('student_email');

        // 更新學員資料
        $data = Student::where('id', $id)
            ->update(['profession' => $profession, 'address' => $address, 'phone' => $student_phone, 'name' => $student_name, 'email' => $student_email]);

        // 更新原始來源
        $data_datasource = SalesRegistration::where('id', $sales_registration_old)
            ->update(['datasource' => $old_datasource]);

        if ($data && $data_datasource) {
            return '更新成功';
        } else {
            return '更新失敗';
        }
    }

    /*** 聯絡資料 - 儲存 Rocky(2020/04/02) ***/
    public function debtsave(Request $request)
    {
        $id_student = $request->get('id_student');
        $debt_date = $request->get('debt_date');
        $debt_course = $request->get('debt_course');
        $debt_status_date = $request->get('debt_status_date');
        $debt_contact = $request->get('debt_contact');
        $debt_status = $request->get('debt_status');
        $debt_status_payment_name = $request->get('debt_status_payment_name');
        $debt_person = $request->get('debt_person');
        $debt_remind = $request->get('debt_remind');


        $debt = new Debt;

        // 新增資料
        $debt->id_student               = $id_student;
        $debt->created_at               = $debt_date;
        $debt->updated_at               = $debt_date;
        $debt->status_payment           = $debt_status_date;
        $debt->contact                  = $debt_contact;
        $debt->id_status                = $debt_status;
        $debt->status_payment_name      = $debt_status_payment_name;
        $debt->remind_at                = $debt_remind;
        $debt->person                   = $debt_person;
        $debt->name_course              = $debt_course;

        $debt->save();
        $id_debt = $debt->id;

        if (!empty($id_debt)) {
            return '儲存成功';
        } else {
            return '儲存失敗';
        }
    }
    /*** 聯絡資料 - 儲存 Rocky(2020/04/02) ***/

    public function debtdelete(Request $request)
    {
        $id = $request->get('id');
        $id_debt = Debt::where('id', $id)->delete();

        if (!empty($id_debt)) {
            return '刪除成功';
        } else {
            return '刪除失敗';
        }
    }

    /*** 聯絡資料 - 自動儲存 ***/
    public function updatedata(Request $request)
    {
        //取回data
        $id = $request->input('id');
        $type = $request->input('type');
        $data = $request->input('data');

        try {
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
                case '5':
                    // 追單人員
                    Debt::where('id', $id)
                        ->update(['person' => $data]);
                    break;
                case '6':
                    // 追單課程
                    Debt::where('id', $id)
                        ->update(['name_course' => $data]);
                    break;
                case '7':
                    // 付款狀態 
                    Debt::where('id', $id)
                        ->update(['status_payment_name' => $data]);
                    break;
                default:
                    return 'error';
                    break;
            }

            return 'success';
        } catch (Exception $e) {
            return 'error';
        }
    }

    // 標記儲存 (2020/03/10)
    public function tagsave(Request $request)
    {
        $id_student = $request->get('id_student');
        $name = $request->get('name');

        $mark = new Mark;

        // 新增標記資料
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

    // 刪除學員資料 Rocky (2020/02/23)
    public function tagdelete(Request $request)
    {
        $status = "";
        $id = $request->get('id');

        // 查詢是否有該筆資料
        $mark = Mark::where('id', $id)->get();

        // 刪除資料

        if (!empty($mark)) {
            $mark = Mark::where('id', $id)->delete();

            $status = "ok";
        } else {
            $status = "error";
        }
        return json_encode(array('data' => $status));
    }


    public function viewformsave(Request $request)
    {
        //取回data
        $id = $request->input('id');
        $type = $request->input('type');
        $data = $request->input('data');
        $id_student = $request->input('id_student');
        $id_group = '';
        switch ($type) {
            case '0':
                // 銷講
                if ($data != "") {
                    SalesRegistration::where('id', $id)
                        ->update(['id_events' => $data, 'id_status' => '1']);
                } else {
                    SalesRegistration::where('id', $id)
                        ->update(['id_events' => $data]);
                }

                break;
            case '1':
                // 正課
                $memo = '';

                $array_id_group = EventsCourse::where('id', $data)
                    ->select('events_course.id_group')
                    ->get();
                if (count($array_id_group) != 0) {
                    $id_group = $array_id_group[0]['id_group'];
                }


                // 修改報名資料
                Registration::where('id', $id)
                    ->update(['id_events' => $data, 'id_group' => $id_group]);

                $datas_register = Register::where('id_registration', $id)
                    ->orderBy('updated_at', 'desc')
                    ->get();

                if (count($datas_register) != "0") {
                    $memo = $datas_register[0]["memo"];

                    // 刪除報到資料
                    Register::where('id_registration', $id)->delete();
                }

                // 同場是否多天
                $array_id_events = EventsCourse::where('id_group', $id_group)
                    ->select('events_course.id')
                    ->get();

                if (count($array_id_events) > 1) {
                    foreach ($array_id_events as $key => $data_events) {
                        // 新增報到資料
                        $register = new Register;

                        $register->memo                = $memo;
                        $register->id_status           = '3';
                        $register->id_events           = $array_id_events[$key]["id"];
                        $register->id_student          = $id_student;
                        $register->id_registration      = $id;
                        $register->save();
                    }
                } else {
                    // 新增報到資料
                    $register = new Register;

                    $register->memo                = $memo;
                    $register->id_status           = '3';
                    $register->id_events           = $data;
                    $register->id_student          = $id_student;
                    $register->id_registration      = $id;
                    $register->save();
                }
                break;
            case '2':
                // 活動
                if ($data != "") {
                    Activity::where('id', $id)
                        ->update(['id_events' => $data, 'id_status' => '1']);
                } else {
                    Activity::where('id', $id)
                        ->update(['id_events' => $data]);
                }

                break;
            default:
                return 'error';
                break;
        }

        return 'success';
    }
}
