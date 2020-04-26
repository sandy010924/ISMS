<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\Receiver;
use App\Model\Teacher;

class MessageResultController extends Controller
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

        $cost_sms = count(Receiver::where('id_message', $data['id'])
                                    ->where('phone', '<>', '')
                                    ->get());

        $msg[$key] = [
          'id' => $data['id'],
          'send_at' => $data['send_at'],
          'name' => $data['name'],
          'content' => strip_tags($data['content']),
          'type' => $type,
          'id_teacher' => $data['id_teacher'],
          'count_receiver' => $count_receiver,
          'cost_sms' => $cost_sms,
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
