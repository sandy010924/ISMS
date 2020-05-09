<?php

namespace App\Http\Controllers\Frontend;

use App\User;
use App\Model\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/* Rocky (2020/02/18) */

class AuthorityController extends Controller
{

    // 顯示資訊
    public function show()
    {
        $datas = User::orderby('created_at', 'desc')
            ->get();

        foreach ($datas as $key => $data) {
            $role_name = "";
            switch ($data['role']) {
                case 'admin':
                    $role_name = "管理員";
                    break;
                case 'marketer':
                    $role_name = "行銷人員";
                    break;
                case 'accountant':
                    $role_name = "財務人員";
                    break;
                case 'staff':
                    $role_name = "臨時人員";
                    break;
                case 'teacher':
                    $role_name = "講師";
                    break;
                case 'msaleser':
                    $role_name = "業務主管";
                    break;
                case 'officestaff':
                    $role_name = "行政人員";
                    break;
                case 'saleser':
                    $role_name = "業務人員";
                    break;
            }

            $datas[$key] = [
                'id' => $data['id'],
                'account' => $data['account'],
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'role_name' => $role_name
            ];
        }
        return view('frontend.authority', compact('datas'));
    }

    // 顯示修改資料
    public function showedite(Request $request)
    {
        $id = $request->get('id');
        $datas = User::where('id', $id)
            ->get();

        foreach ($datas as $key => $data) {
            $role_name = "";
            switch ($data['role']) {
                case 'admin':
                    $role_name = "管理員";
                    break;
                case 'marketer':
                    $role_name = "行銷人員";
                    break;
                case 'accountant':
                    $role_name = "財務人員";
                    break;
                case 'staff':
                    $role_name = "臨時人員";
                    break;
                case 'teacher':
                    $role_name = "講師";
                    break;
                case 'msaleser':
                    $role_name = "業務主管";
                    break;
                case 'officestaff':
                    $role_name = "行政人員";
                    break;
                case 'saleser':
                    $role_name = "業務人員";
                    break;
            }

            $datas[$key] = [
                'id' => $data['id'],
                'account' => $data['account'],
                'name' => $data['name'],
                'email' => $data['email'],
                'id_teacher' => $data['id_teacher'],
                'role' => $data['role'],
                'status' => $data['status'],
                'role_name' => $role_name
            ];
        }
        return $datas;
    }
    // 講師資料
    public function showteacher()
    {
        $datas = Teacher::select('teacher.id', 'teacher.name', 'teacher.created_at')
            ->orderby('teacher.created_at', 'desc')
            ->get();

        return $datas;
    }
}
