<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\Student;
use App\Model\Teacher;
use App\Model\Receiver;
use App\User;

class MessageListController extends Controller
{
    // 顯示frontend.message_cost資訊
    public function show()
    {
      $msg = [];

      $msg_all = Message::orderby('created_at', 'desc')->get();

      foreach( $msg_all as $key => $data){
        switch ($data['type']) {
          case 0:
            $type = '簡訊';
            break;
          case 1:
            $type = 'E-mail';
            break;
          case 2:
            $type = '簡訊、E-mail';
            break;
          default:
            $type = '';
            break;
        }

        $count_receiver = count(Receiver::where('id_message', $data['id'])->get());

        $msg[$key] = [
          'id' => $data['id'],
          'id_status' => $data['id_status'],
          'name' => $data['name'],
          'content' => strip_tags($data['content']),
          'type' => $type,
          'send_at' => $data['send_at'],
          'count_receiver' => $count_receiver,
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
