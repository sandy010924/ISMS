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

        return view('frontend.authority', compact('datas'));
    }

    // 搜尋
    public function search(Request $request)
    {
        $pagesize = 15;
        $name = $request->get('name');
        $role = $request->get('role');

        if (!empty($name)) {
            $datas = User::Where('name', 'like', '%' .$name. '%')
                        ->orWhere('account', 'like', '%' .$name. '%')
                        ->orWhere('role', '='.$role)
                        ->paginate($pagesize);
        } elseif (!empty($role)) {
            $datas = User::Where('role', $role)
                        ->paginate($pagesize);
        } else {
            $datas = User::paginate($pagesize);
        }
       
        return view('frontend.authority', compact('datas'));
    }
}
