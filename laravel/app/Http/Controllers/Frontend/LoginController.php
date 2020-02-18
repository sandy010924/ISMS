<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // 顯示資訊
    public function show()
    {
        return Auth::user()->name;
    }

    // 登入
    public function login(Request $request)
    {
        $account = $request->get('uname');
        $psw = $request->get('psw');
        // $password = Hash::make('123'); -> 加密
        
        if (Auth::attempt(['account' => $account, 'password' => $psw])) {
            return "1";
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
