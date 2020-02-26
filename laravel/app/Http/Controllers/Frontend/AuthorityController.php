<?php
namespace App\Http\Controllers\Frontend;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/* Rocky (2020/02/18) */
class AuthorityController extends Controller
{
   
    // 顯示資訊
    public function show()
    {
        $pagesize = 15;

        $datas = User::paginate($pagesize);

        foreach ($datas as $key => $data) {
            $role_name = "";
            switch ($data['role']) {
                case 'admin':
                    $role_name = "管理員";
                    break;
                case 'dataanalysis':
                    $role_name = "數據分析人員";
                    break;
                case 'marketer':
                    $role_name = "行銷人員";
                    break;
                case 'accountant':
                    $role_name = "財會人員";
                    break;
                case 'staff':
                    $role_name = "現場人員";
                    break;
                case 'teacher':
                    $role_name = "講師";
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

    // 搜尋
    // public function search(Request $request)
    // {
    //     $pagesize = 15;
    //     $name = $request->get('name');
    //     $role = $request->get('role');

    //     if (!empty($name)) {
    //         $datas = User::Where('name', 'like', '%' .$name. '%')
    //                     ->orWhere('account', 'like', '%' .$name. '%')
    //                     ->orWhere('role', '='.$role)
    //                     ->paginate($pagesize);
    //     } elseif (!empty($role)) {
    //         $datas = User::Where('role', $role)
    //                     ->paginate($pagesize);
    //     } else {
    //         $datas = User::paginate($pagesize);
    //     }
       
    //     foreach ($datas as $key => $data) {
    //         $role_name = "";
    //         switch ($data['role']) {
    //             case 'admin':
    //                 $role_name = "管理員";
    //                 break;
    //             case 'dataanalysis':
    //                 $role_name = "數據分析人員";
    //                 break;
    //             case 'marketer':
    //                 $role_name = "行銷人員";
    //                 break;
    //             case 'accountant':
    //                 $role_name = "財會人員";
    //                 break;
    //             case 'staff':
    //                 $role_name = "現場人員";
    //                 break;
    //             case 'teacher':
    //                 $role_name = "講師";
    //                 break;
    //         }

    //         $datas[$key] = [
    //             'id' => $data['id'],
    //             'account' => $data['account'],
    //             'name' => $data['name'],
    //             'email' => $data['email'],
    //             'role' => $data['role'],
    //             'role_name' => $role_name
    //         ];
    //     }
        
    //     return view('frontend.authority', compact('datas'));
    // }
}
