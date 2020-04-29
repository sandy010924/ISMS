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
      $scheduleMsg = [];
      $draftMsg= [];
      $sentMsg= [];

      $msg_all = Message::all();

      foreach( $msg_all as $data){
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

        $count = count(Receiver::where('id_message', $data['id'])->get());

        switch ($data['id_status']) {
          case 21:
            //已預約
            //當天預約訊息不得取消故不顯示
            if( date('Y-m-d', strtotime($data['send_at'])) > date('Y-m-d') ){
              $scheduleMsg[count($scheduleMsg)] = [
                'created_at' => $data['created_at'],
                'id' => $data['id'],
                'name' => $data['name'],
                'content' => strip_tags($data['content']),
                'type' => $type,
                'send_at' => $data['send_at'],
                'count' => $count,
              ];
            }
            break;
          case 18:
            //草稿
            $draftMsg[count($draftMsg)] = [
              'created_at' => $data['created_at'],
              'id' => $data['id'],
              'name' => $data['name'],
              'content' => strip_tags($data['content']),
              'type' => $type,
              'count' => $count,
            ];
            break;
          case 19:
            //已傳送
            $sentMsg[count($sentMsg)] = [
              'created_at' => $data['created_at'],
              'id' => $data['id'],
              'name' => $data['name'],
              'content' => strip_tags($data['content']),
              'type' => $type,
              'send_at' => $data['send_at'],
              'count' => $count,
            ];
            break;
          default:
            break;
        }
      }

      return view('frontend.message_list', compact('scheduleMsg', 'draftMsg', 'sentMsg'));
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
