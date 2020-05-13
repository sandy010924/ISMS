<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\Receiver;
use App\Model\Teacher;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Course;

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

        //寄件人數
        $count_receiver = count(Receiver::where('id_message', $data['id'])->get());

        //簡訊費用
        $cost_sms = count(Receiver::where('id_message', $data['id'])
                                    ->where('phone', '<>', '')
                                    ->get()) * $data['sms_num'];
                 
        //報名人數
        $count_apply = 0;
        if( $data['id_course'] != null){
          $type = Course::where('id', $data['id_course'])->first()->type;
          $startDate = $data['send_at']; 
          $endDate =  date("Y-m-d H:i:s",strtotime("+1 day",strtotime($data['send_at'])));
          if( $type == 1 ){
            $count_apply = count(SalesRegistration::where('id_course', $data['id_course'])
                                                  ->where('datasource', 'SMS')
                                                  ->whereBetween('submissiondate', [$startDate, $endDate])
                                                  ->get());
          }else if( $type == 2 || $type == 3 ){
            $count_apply = count(Registration::where('id_course', $data['id_course'])
                                            ->where('datasource', 'SMS')
                                            ->whereBetween('submissiondate', [$startDate, $endDate])
                                            ->get());
          }
        }

        //報名成本
        $cost_apply = 0;
        if( $cost_sms != 0 && $count_apply != 0){
          $cost_apply = $cost_sms / $count_apply;
        }
        
        //報名率
        $rate_apply = 0;
        if( $count_apply != 0 && $count_receiver != 0){
          $rate_apply = ($count_apply / $count_receiver)*100;
        }

        $msg[$key] = [
          'id' => $data['id'],
          'send_at' => $data['send_at'],
          'name' => $data['name'],
          'content' => strip_tags($data['content']),
          'type' => $type,
          'id_teacher' => $data['id_teacher'],
          'count_receiver' => $count_receiver,
          'cost_sms' => $cost_sms,
          'count_apply' => $count_apply,
          'cost_apply' => $cost_apply,
          'rate_apply' => $rate_apply,
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
