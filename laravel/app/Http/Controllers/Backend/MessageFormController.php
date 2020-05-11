<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Model\Registration;
// use App\Model\EventsCourse;
// use App\Model\Course;
// use App\Model\Student;

class MessageFormController extends Controller
{
    // 顯示frontend.message_cost資訊
    public function update(Request $request)
    {
      $id_registration = $request->get('id_registration');
      $ievent = $request->get('ievent');

      // if(strpos($ievent, 'other') !== false){
      //   $events = EventsCourse::where('id_group', $ievent)->orderby('course_start_at', 'desc')->first();

      //   //選擇場次後更新報名資料
      //   Registration::where('id', $id_registration)
      //       ->update([
      //           'id_course' => $events->id_course,
      //           'id_events' => $events->id,
      //           'id_group' => $ievent
      //       ]);
      // }else{
      //   //更新報名資料
      //   Registration::where('id', $id_registration)
      //       ->update([
      //           'id_course' => substr($ievent, 6)
      //       ]);
      // }


      // return view('frontend.message_form_success');
      // return view('frontend.message_form', ['id' => $id_registration, 'status'=>'error']);
      return redirect()->route('message_form', ['id' => $id_registration])->with('status', 'error');

    }
}
