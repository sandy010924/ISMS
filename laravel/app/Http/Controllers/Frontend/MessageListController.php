<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\Student;
use App\Model\Teacher;
use App\Model\Sender;
use App\User;

class MessageListController extends Controller
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
          'id' => $data['id'],
          'id_status' => $data['id_status'],
          'name' => $data['name'],
          'content' => $data['content'],
          'type' => $type,
          'send_at' => $data['send_at'],
          'count_sender' => $count_sender,
        ];
      }
// dd($msg);
      // $teachers = Teacher::Where('phone', ' ') -> get();

      return view('frontend.message_list', compact('msg'));
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
