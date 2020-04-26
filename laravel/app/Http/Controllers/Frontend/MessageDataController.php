<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\Receiver;
use App\Model\Student;
// use App\Model\Teacher;
// use App\User;

class MessageDataController extends Controller
{
    // 顯示frontend.message_cost資訊
    public function show(Request $request)
    {
      $id = $request->get('id');
      
      $msg = Message::where('id', $id)->first();

      $receiver = Receiver::leftjoin('student', 'student.id', '=', 'receiver.id_student')
                      ->select('student.name', 'receiver.*')
                      ->where('id_message', $msg->id)
                      ->get();

      return view('frontend.message_data', compact('msg', 'receiver'));
    }

}
