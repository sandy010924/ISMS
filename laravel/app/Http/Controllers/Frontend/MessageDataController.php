<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\Receiver;
use App\Model\Student;
use App\Model\Course;
use App\Model\Teacher;
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
                      
        if($msg['id_teacher'] != null && $msg['id_course'] != null){
          //講師
          $teacher = Teacher::where('id', $msg['id_teacher'])
                          ->get();
          if( count($teacher) != 0 ){
            $teacher = Teacher::where('id', $msg['id_teacher'])
                              ->first()->name;
          }else{
            $teacher = '無相關講師';
          }

          //課程
          $course = Course::where('id', $msg['id_course'])
                          ->get();
          if( count($course) != 0 ){
            $course = Course::where('id', $msg['id_course'])
                              ->first()->name;
          }else{
            $course = '無相關課程';
          }
        }else if($msg['id_teacher'] == null && $msg['id_course'] != null){
          $teacher = '無相關講師';
          //課程
          $course = Course::where('id', $msg['id_course'])
                          ->get();
          if( count($course) != 0 ){
            $course = Course::where('id', $msg['id_course'])
                              ->first()->name;
          }else{
            $course = '無相關課程';
          }
        }else if($msg['id_teacher'] != null && $msg['id_course'] == null){
          //講師
          $teacher = Teacher::where('id', $msg['id_teacher'])
                          ->get();
          if( count($teacher) != 0 ){
            $teacher = Teacher::where('id', $msg['id_teacher'])
                              ->first()->name;
          }else{
            $teacher = '無相關講師';
          }
          $course = '無相關課程';
        }else{
          $teacher = '無相關講師';
          $course = '無相關課程';
        }
        


      return view('frontend.message_data', compact('msg', 'receiver', 'teacher', 'course'));
    }

}
