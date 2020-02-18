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
        $id = $request->get('id');
        $account = $request->get('account');
        $password = $request->get('password');
        $name = $request->get('name');
        $password_check = $request->get('password_check');
        $role = $request->get('updateuser_persona');

        if (!empty($password) && !empty($password_check)) {
            $data = User::where('id', $id)
                ->update(['account' => $account,'password' =>  Hash::make($password),'name' => $name,'role' => $role]);
        } else {
            $data = User::where('id', $id)
                ->update(['account' => $account,'name' => $name,'role' => $role]);
        }
        
        
        if ($data) {
            return redirect('authority')->with('status', '更新成功');
        } else {
            return redirect('authority')->with('status', '更新失敗');
        }
    }

    // 新增
    public function insert(Request $request)
    {
        $id = $request->get('id');
        $account = $request->get('account');
        $password = $request->get('password');
        $name = $request->get('name');
        $password_check = $request->get('password_check');
        $role = $request->get('newuser_persona');


        $data = User::insert(
            ['account' => $account,'password' =>  Hash::make($password),'name' => $name,'role' => $role,'email' => '']
        );

        if ($data) {
            return redirect('authority')->with('status', '新增成功');
        } else {
            return redirect('authority')->with('status', '新增失敗');
        }
    }

    // 刪除
    public function delete(Request $request)
    {
        $status = "";
        $id = $request->get('id');

        // 查詢是否有該筆資料
        $data = User::where('id',$id)->get();
        
         // 刪除資料
        if(!empty($data) ){
            User::where('id',$id)->delete();            
           $status = "ok";
        } else {
            $status = "error";
        }
        
        return json_encode(array('data' => $status));

    }
}
