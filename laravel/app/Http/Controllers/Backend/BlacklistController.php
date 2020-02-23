<?php

namespace App\Http\Controllers\Backend;

use App\Model\Student;
use App\Model\Blacklist;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class BlacklistController extends Controller
{

    // 取消黑名單 Rocky (2020/02/23)
    public function cancel(Request $request)
    {
        $status = "";
        $id_blacklist = $request->get('id_blacklist');
        
        // 是否有該筆資料
        $blacklist = Blacklist::where('id', $id_blacklist)->first();

        // 更新資料 -> 學員資料
        if (!empty($blacklist)) {
            $student = Student::where('id', $blacklist->id_student)
                    ->update(['check_blacklist' => '0']);
        }

         // 刪除資料 -> 黑名單資料表
        if ($student != 0 && !empty($blacklist)) {
            Blacklist::where('id', $id_blacklist)->delete();
            $status = "ok";
        } else {
            $status = "error";
        }

        return json_encode(array('data' => $status));
    }
}
