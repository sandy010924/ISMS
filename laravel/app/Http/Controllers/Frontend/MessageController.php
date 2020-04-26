<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\Student;
use App\Model\Teacher;
use App\Model\Course;
use App\User;
use App\Model\Receiver;

class MessageController extends Controller
{
    public function show(Request $request)
    {
        //取得id_message (草稿編輯)
        $id = $request->get('id');

        $message = Message::where('id', $id)->first();
        $receiver = Receiver::where('id_message', $id)->get();

        $phone = [];
        $email = [];

        if($message['type'] == 0 || $message['type'] == 2){
            foreach( $receiver as $data){
                if($data['phone'] != ""){
                    array_push($phone, $data['phone']);
                }
            }
        }

        if($message['type'] == 1 || $message['type'] == 2){
            foreach( $receiver as $data){
                if($data['email'] != ""){
                    array_push($email, $data['email']);
                }
            }
        }

        $receiver_phone = '';
        $receiver_email = '';

        if(!empty($phone)){
            $receiver_phone = implode(',', $phone);
        }
        if(!empty($email)){
            $receiver_email = implode(',', $email);
        }

        // $message = [

        // ];

        $course = Course::all();

        $teacher = Teacher::all();

        return view('frontend.message', compact('course', 'teacher', 'message', 'receiver_phone', 'receiver_email'));
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
