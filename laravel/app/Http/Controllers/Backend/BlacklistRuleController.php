<?php

namespace App\Http\Controllers\Backend;

use App\Model\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlacklistRuleController extends Controller
{
    public function update(Request $request)
    {
        $checkboxlist = $request->get('checkboxlist');
        $textlist = $request->get('textlist');
       
        $checkboxlist=explode(",", $checkboxlist);
        $textlist=explode(",", $textlist);

        foreach ($checkboxlist as $key => $value_checkbox) {
            $data = Rule::where('rule_value', $key)
                ->update(['rule_status' => $checkboxlist[$key],'regulation' =>  $textlist[$key]]);
        }
        // echo $checkboxlist[1];
    //    print_r($checkboxlist);
        // if (!empty($password) && !empty($password_check)) {
        //     $data = User::where('id', $id)
        //         ->update(['account' => $account,'password' =>  Hash::make($password),'name' => $name,'role' => $role]);
        // } else {
        //     $data = User::where('id', $id)
        //         ->update(['account' => $account,'name' => $name,'role' => $role]);
        // }
        
        
        if ($data) {
            return '更新成功';
        } else {
            return '更新失敗';
        }
        
    }
}
