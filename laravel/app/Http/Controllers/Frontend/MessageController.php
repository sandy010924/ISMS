<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\StudentGroupdetail;
use App\Model\Student;
use App\Model\Teacher;
use App\User;

class MessageController extends Controller
{
     // 顯示frontend.message_cost資訊

     public function showDetailGroup(Request $request)
     {
       $groupData = StudentGroupdetail::leftjoin('student_group', 'student_groupdetail.id_group', '=', 'student_group.id_group')
       ->select('student_group.id_group', 'student_group.name as name')
       ->groupBy('student_group.id_group')
       -> get();

    $groupDetailData = StudentGroupdetail::leftjoin('student_group', 'student_groupdetail.id_group', '=', 'student_group.id_group')
       ->leftjoin('student', 'student.id', '=', 'student_groupdetail.id_student')
       ->select('student_group.name as groupName', 'student.id as ID', 'student.name as NAME', 'student.email as email', 'student.phone as phone')
       -> get();

       foreach ($groupDetailData as $key => $value) {
           # code...
       }

    //    $data = [
    //        [
    //         "groupName" => "test",
    //         "groupData" => $groupDetailData
    //        ]
    //    ];

    $data_refund = $groupData->toArray();
    $result = array_merge($groupDetailData->toArray(), $data_refund);

        // $result = array_merge(json_decode($groupData), json_decode($groupDetailData));
        return $result;


    //    return $data;

    //    $datas = SalesRegistration::leftjoin('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
    //                         ->leftjoin('course', 'course.id', '=', 'sales_registration.id_course')
    //                         ->select('sales_registration.*', 'isms_status.name as status', 'course.name as course')
    //                         ->where('sales_registration.id_student', $id_student)
    //                         ->get();

    //    return response()->json($data);


     }


    // 顯示frontend.message_cost資訊
    public function show()
    {
      $data = Message::Where('id_student_group', '股票分組') -> get();

      $teachers = Teacher::Where('phone', ' ') -> get();

      return view('frontend.message_cost', compact('data', 'teachers'));
    }

    // 登入
    public function login(Request $request)
    {
        $account = $request->get('uname');
        $psw = $request->get('psw');

        if (Auth::attempt(['account' => $account, 'password' => $psw])) {
            return Auth::user()->role;
        } else {
            return "0";
        }
    }

    // 登出
    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');
    }
}
