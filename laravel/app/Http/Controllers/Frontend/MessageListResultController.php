<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\Sender;
use App\Model\Teacher;

class MessageListResultController extends Controller
{
    // 顯示frontend.message_cost資訊
    public function show()
    {
      $data = Message::join('sender', 'sender.id_message', '=', 'message');

      $teachers = Teacher::all();

      return view('frontend.message_result', compact('data', 'teachers'));
    }

    // // 登入
    // public function login(Request $request)
    // {
    //     $account = $request->get('uname');
    //     $psw = $request->get('psw');

    //     if (Auth::attempt(['account' => $account, 'password' => $psw])) {
    //         return Auth::user()->role;
    //     } else {
    //         return "0";
    //     }
    // }

    // // 登出
    // public function logout()
    // {
    //     Auth::logout();
    //     return Redirect::to('/');
    // }
}
