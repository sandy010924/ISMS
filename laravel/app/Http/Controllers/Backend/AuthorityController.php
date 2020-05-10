<?php

namespace App\Http\Controllers\Backend;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthorityController extends Controller
{

    // 更新
    public function update(Request $request)
    {
        $check_account = "";
        $check_status = "";
        $id = $request->get('id');
        $account = $request->get('account');
        $password = $request->get('password');
        $name = $request->get('name');
        $password_check = $request->get('password_check');
        $role = $request->get('role');
        $email = $request->get('email');
        $status = $request->get('status');
        $id_teacher = $request->get('id_teacher');

        $check_account = User::where('account', $account)
            ->select('users.id')
            ->get();

        // 檢查重複帳號
        // if (count($check_account) == "0") {
        if (!empty($password) && !empty($password_check)) {
            $data = User::where('id', $id)
                ->update(['account' => $account, 'password' =>  Hash::make($password), 'name' => $name, 'role' => $role, 'email' => $email, 'id_teacher' => $id_teacher, 'status' => $status, 'updated_at' => new \DateTime()]);
            $check_status = "password_ok";
            // 要寄信!!!!!!!!!

        } else {
            $data = User::where('id', $id)
                ->update(['account' => $account, 'name' => $name, 'role' => $role, 'email' => $email, 'id_teacher' => $id_teacher, 'status' => $status, 'updated_at' => new \DateTime()]);
            $check_status = "ok";
        }

        if ($data) {
            return json_encode(array('data' => 'ok'));
        } else {
            return json_encode(array('data' => 'error'));
        }
        // } else {
        //     return json_encode(array('data' => 'repeat account'));
        // }
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


        $check_account = User::where('account', $account)
            ->select('users.id')
            ->get();


        if (count($check_account) == "0") {
            $data = User::insert(
                [
                    'account' => $account, 'password' =>  Hash::make($password), 'name' => $name, 'role' => $role, 'email' => $email,
                    'id_teacher' => $id_teacher, 'status' => $status, 'created_at' => new \DateTime(), 'updated_at' => new \DateTime()
                ]
            );

            if ($data) {
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
