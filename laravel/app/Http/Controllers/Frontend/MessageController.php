<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\Student;
use App\Model\Teacher;
use App\Model\Course;
use App\User;

class MessageController extends Controller
{
    public function show()
    {
      $course = Course::all();

      $teacher = Teacher::all();

      return view('frontend.message', compact('course', 'teacher'));
    }

    // 登入
    public function login(Request $request)
    {
        $account = $request->get('uname');
        $psw = $request->get('psw');

        if (Auth::attempt(['account' => $account, 'password' => $psw])) {
            return Auth::user()->role;
        } else {
            return "0";
        }
    }

    // 登出
    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');
    }
}
