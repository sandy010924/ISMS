<?php

namespace App\Http\Controllers\Frontend;

use Response;
use App\Model\Debt;
use App\Model\Mark;
use App\Model\Refund;
use App\Model\Course;
use App\Model\Student;
use App\Model\Payment;
use App\Model\Activity;
use App\Model\Receiver;
use App\Model\Register;
use App\Model\Blacklist;
use App\Model\EventsCourse;
use App\Model\Registration;
use App\Model\SalesRegistration;
use App\Model\StudentGroupdetail;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class SandyqController extends Controller
{
    // 顯示資料
    public function show()
    {
        return view('frontend.sandyq');
    }


    // 修改學員資料
    public function sandyqstudent(Request $request)
    {
        $delete_id = [];
        $idlist = $request->input('idlist');
        $change_id_student = $request->input('change_id_student');
        // $delete_id_student = $request->input('delete_id_student');


        $idlist = explode(",", $idlist);

        // 要刪掉的學員id
        $delete_id = $idlist;
        if (($key = array_search($change_id_student, $delete_id)) !== false) {
            unset($delete_id[$key]);
        }

        /*更改學員ID Rocky (2020/08/05)*/

        // 活動
        Activity::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 黑名單
        Blacklist::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 追單
        Debt::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 標記
        Mark::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 付款
        Payment::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 收訊息 
        Receiver::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 退款 
        Refund::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 正課報到 
        Register::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 正課報名 
        Registration::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 銷講報名
        SalesRegistration::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 名單列表 
        StudentGroupdetail::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 刪除
        Student::wherein('id', $delete_id)->delete();

        $data = Student::where('id', $change_id_student)
            ->select('student.name')
            ->get();

        /*更改學員ID Rocky (2020/08/05)*/
        return $data;
    }



    // 快速搜尋小工具
    public function search(Request $request)
    {
        $list = $request->input('list');

        $list = explode(" ", $list);

        $data = array();

        foreach ($list as $item) {

            $student = Student::where('name', $item)->get();

            $id = '';
            $phone = array();
            $email = array();

            foreach ($student as $key => $item2) {
                if ($key == 0) {
                    $id .= $item2['id'] . '|';
                } else if ($key == count($student) - 1) {
                    $id .= $item2['id'];
                } else {
                    $id .= $item2['id'] . ',';
                }

                array_push($phone, $item2['phone']);
                array_push($email, $item2['email']);
            }

            $phone = array_unique($phone);
            $email = array_unique($email);

            $memo = '';
            if (count($student) == 1) {
                $memo .= '只有一筆';
            }
            if (count($phone) > 1) {
                $memo .= '電話不同';
            }
            if (count($email) > 1) {
                if ($memo != '') {
                    $memo .= '、';
                }
                $memo .= '信箱不同';
            }

            $data[count($data)] = [
                'name' => $item,
                'student' => $student,
                'id' => $id,
                'memo' => $memo
            ];
        }


        return $data;
    }
}
