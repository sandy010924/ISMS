<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
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
    $draftMsg = [];
    $sentMsg = [];

    $msg_all = Message::all();

    foreach ($msg_all as $data) {
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
          //過時預約訊息不得取消故不顯示
          if (date('Y-m-d H:i', strtotime($data['send_at'])) > date('Y-m-d H:i', strtotime('now'))) {
            $scheduleMsg[count($scheduleMsg)] = [
              'updated_at' => $data['updated_at'],
              'id' => $data['id'],
              'name' => $data['name'],
              'content' => html_entity_decode(strip_tags($data['content'])),
              'type' => $type,
              'send_at' => date('Y-m-d H:i', strtotime($data['send_at'])),
              'count' => $count,
            ];
          }
          break;
        case 18:
          //草稿
          $draftMsg[count($draftMsg)] = [
            'updated_at' => $data['updated_at'],
            'id' => $data['id'],
            'name' => $data['name'],
            'content' => html_entity_decode(strip_tags($data['content'])),
            'type' => $type,
            'count' => $count,
          ];
          break;
        case 19:
          //已傳送
          $sentMsg[count($sentMsg)] = [
            'updated_at' => $data['updated_at'],
            'id' => $data['id'],
            'name' => $data['name'],
            'content' => html_entity_decode(strip_tags($data['content'])),
            'type' => $type,
            'send_at' => $data['send_at'],
            'count' => $count,
          ];
          break;
        default:
          break;
      }
    }

    //開始時間
    $start_array = Message::orderBy('send_at', 'asc')
      ->whereNotNull('send_at')
      ->where('send_at', '<>', '0000-00-00 00:00:00')
      // ->orderBy('updated_at', 'asc')
      ->first();

    //結束時間
    $end_array = Message::orderBy('send_at', 'desc')
      ->whereNotNull('send_at')
      ->where('send_at', '<>', '0000-00-00 00:00:00')
      // ->orderBy('updated_at', 'desc')
      ->first();


    if ($start_array != "" && $end_array != "") {
      $start = date('Y-m-d', strtotime($start_array->send_at));
      $end = date('Y-m-d', strtotime($end_array->send_at));
    }

    $x_time = Carbon::parse('2022-01-01 00:00:00');
    $xxx = $x_time->timestamp;

 
    return view('frontend.message_list', compact('scheduleMsg', 'draftMsg', 'sentMsg', 'start', 'end'));
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
