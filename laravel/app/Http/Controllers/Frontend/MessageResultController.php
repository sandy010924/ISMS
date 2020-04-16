<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\Sender;
use App\Model\Teacher;

class MessageResultController extends Controller
{
    // 顯示frontend.message_cost資訊
    public function show()
    {
      $msg = [];

      $msg_all = Message::all();

      foreach( $msg_all as $key => $data){
        if( $data['type'] == 0){
          $type = '簡訊';
        }else{
          $type = 'email';
        }

        $count_sender = count(Sender::where('id_message', $data['id'])->get());

        $msg[$key] = [
          'send_at' => $data['send_at'],
          'name' => $data['name'],
          'content' => $data['content'],
          'type' => $type,
          'id_teacher' => $data['id_teacher'],
          'count_sender' => $count_sender,
          'cost_sms' => $count_sender,
        ];
      }
      
      $teachers = Teacher::all();

      return view('frontend.message_result', compact('msg', 'teachers'));
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
