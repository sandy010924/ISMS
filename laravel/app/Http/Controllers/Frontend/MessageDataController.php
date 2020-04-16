<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\Sender;
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

      $sender = Sender::leftjoin('student', 'student.id', '=', 'sender.id_student')
                      ->select('student.name', 'sender.*')
                      ->where('id_message', $msg->id)
                      ->get();

      return view('frontend.message_data', compact('msg', 'sender'));
    }

}
