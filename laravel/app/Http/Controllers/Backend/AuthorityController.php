<?php

namespace App\Http\Controllers\Backend;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Mail;

class AuthorityController extends Controller
{

    // email
    public function sendMail($emailAddr, $mailTitle, $mailContents)
    {
        $mailContents = str_replace("\n", "<br>", $mailContents);

        Mail::send('frontend.model_email', ['content' => $mailContents], function ($message) use ($mailTitle, $emailAddr) {
            $message->subject($mailTitle);
            $message->to($emailAddr);
        });

        return array('status' => 'success', 'email' => $emailAddr);
    }

    public function email(Request $request)
    {
        $emailAddr = $request->get('emailAddr');
        $mailTitle  = $request->get('mailTitle');
        $mailContents = $request->get('mailContents');

        $check = $this->sendMail($emailAddr, $mailTitle, $mailContents);
        return $check;
    }

    // 更新
    public function update(Request $request)
    {
        $check_account = "";
        $check_status = "";
        $id = $request->get('id');
        $account = $request->get('account');
        $old_account = $request->get('old_account');
        $password = $request->get('password');
        $name = $request->get('name');
        $password_check = $request->get('password_check');
        $role = $request->get('role');
        $email = $request->get('email');
        $status = $request->get('status');
        $id_teacher = $request->get('id_teacher');

        // 寄信
        $mailTitle = "無極限學員系統 - 帳號權限通知";

        if ($account != "old_account") {
            $check_account = User::where('account', $account)
                ->select('users.id')
                ->get();
        } else {
            $check_account = [];
        }


        // 檢查重複帳號
        if (count($check_account) == "0") {
            if (!empty($password) && !empty($password_check)) {
                if ($account != "old_account") {
                    // 寄信
                    $mailContents = "您好 " . $name . "<br>  您的帳號：" . $account . " / 密碼：" . $password . "<br>  系統網址：" . env('APP_URL2');

                    $data = User::where('id', $id)
                        ->update(['account' => $account, 'password' =>  Hash::make($password), 'name' => $name, 'role' => $role, 'email' => $email, 'id_teacher' => $id_teacher, 'status' => $status, 'updated_at' => new \DateTime()]);
                } else {
                    // 寄信
                    $mailContents = "您好 " . $name . "<br>  您的帳號：" . $old_account . " / 密碼：" . $password . "<br>  系統網址：" . env('APP_URL2');
                    $data = User::where('id', $id)
                        ->update(['password' =>  Hash::make($password), 'name' => $name, 'role' => $role, 'email' => $email, 'id_teacher' => $id_teacher, 'status' => $status, 'updated_at' => new \DateTime()]);
                }
                if ($data == "1") {
                    // 寄信
                    $this->sendMail($email, $mailTitle, $mailContents);
                }
            } else {
                if ($account != "old_account") {
                    $data = User::where('id', $id)
                        ->update(['account' => $account,  'name' => $name, 'role' => $role, 'email' => $email, 'id_teacher' => $id_teacher, 'status' => $status, 'updated_at' => new \DateTime()]);
                } else {
                    $data = User::where('id', $id)
                        ->update(['name' => $name, 'role' => $role, 'email' => $email, 'id_teacher' => $id_teacher, 'status' => $status, 'updated_at' => new \DateTime()]);
                }
            }

            if ($data == "1") {
                return json_encode(array('data' => 'ok'));
            } else {
                return json_encode(array('data' => 'error'));
            }
        } else {
            return json_encode(array('data' => 'repeat account'));
        }
    }

    // 新增
    public function insert(Request $request)
    {

        $data = "";
        $check_account = "";
        $account = $request->get('account');
        $status = $request->get('status');
        $password = $request->get('password');
        $name = $request->get('name');
        $role = $request->get('role');
        $id_teacher = $request->get('id_teacher');
        $email = $request->get('email');

        // 寄信
        $mailTitle = "無極限學員系統 - 帳號權限通知";
        $mailContents = "您好 " . $name . "<br>  您的帳號：" . $account . " / 密碼：" . $password . "<br>  系統網址：" . env('APP_URL2');

        $check_account = User::where('account', $account)
            ->select('users.id')
            ->get();


        if (count($check_account) == "0") {
            // $data = User::insert(
            //     [
            //         'account' => $account, 'password' =>  Hash::make($password), 'name' => $name, 'role' => $role, 'email' => $email,
            //         'id_teacher' => $id_teacher, 'status' => $status, 'created_at' => new \DateTime(), 'updated_at' => new \DateTime()
            //     ]
            // );

            $user = new User;
            $user->account          = $account;
            $user->password         = Hash::make($password);
            $user->name             = $name;
            $user->role             = $role;
            $user->email            = $email;
            $user->id_teacher       = $id_teacher;
            $user->status           = $status;
            $user->created_at       = new \DateTime();
            $user->updated_at       = new \DateTime();

            $user->save();
            $id_user = $user->id;

            if (!empty($id_user)) {
                // 寄信
                $this->sendMail($email, $mailTitle, $mailContents);
                return json_encode(array('data' => 'ok'));
            } else {
                return json_encode(array('data' => 'error'));
            }
        } else {
            return json_encode(array('data' => 'repeat account'));
        }
    }

    // 刪除
    public function delete(Request $request)
    {
        $status = "";
        $id = $request->get('id');

        // 查詢是否有該筆資料
        $data = User::where('id', $id)->get();

        // 刪除資料
        if (!empty($data)) {
            User::where('id', $id)->delete();
            $status = "ok";
        } else {
            $status = "error";
        }

        return json_encode(array('data' => $status));
    }
}
