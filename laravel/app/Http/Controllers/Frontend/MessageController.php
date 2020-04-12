<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\Student;
use App\Model\Teacher;
use App\User;

class MessageController extends Controller
{
    // 顯示frontend.message_cost資訊
    // public function show()
    // {
    //   $data = Message::Where('id_student_group', '股票分組') -> get();

    //   $teachers = Teacher::Where('phone', ' ') -> get();

    //   return view('frontend.message_cost', compact('data', 'teachers'));
    // }

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
