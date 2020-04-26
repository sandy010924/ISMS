<?php

namespace App\Http\Controllers\Backend;

use App\Model\Bonus;
use App\Model\BonusRule;
use App\Model\Registration;
use App\Model\EventsCourse;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class FinanceController extends Controller
{
    /*** 場次資料 - 自動儲存 ***/
    public function eventsupdate(Request $request)
    {
        //取回data
        $id_group = $request->input('id_group');
        $type = $request->input('type');
        $data = $request->input('data');

        // try{
        switch ($type) {
            case '0':
                // 廣告成本
                EventsCourse::where('id_group', $id_group)
                    ->update(['cost_ad' => $data]);
                break;
            case '1':
                // 訊息成本
                EventsCourse::where('id_group', $id_group)
                    ->update(['cost_message' => $data]);
                break;
            case '2':
                // 場地成本
                EventsCourse::where('id_group', $id_group)
                    ->update(['cost_events' => $data]);
                break;
            default:
                return 'error';
                break;
        }

        return 'success';
    }

    /*** 發票資料 - 自動儲存 ***/
    public function invoiceupdate(Request $request)
    {
        //取回data
        $id = $request->input('id');
        $type = $request->input('type');
        $data = $request->input('data');

        // try{
        switch ($type) {
            case '0':
                // 開立日期
                Registration::where('id', $id)
                    ->update(['invoice_created_at' => $data]);
                break;
            case '1':
                // 發票號碼
                Registration::where('id', $id)
                    ->update(['invoice' => $data]);
                break;
            default:
                return 'error';
                break;
        }

        return 'success';
    }

    /*** 新增獎金規則資料 ***/
    public function addbonus(Request $request)
    {
        //取回data
        $id_events = $request->input('id_events');
        $id_course = $request->input('id_course');
        $id_group = $request->input('id_group');
        $name = $request->input('name');
        $bonus_status = $request->input('bonus_status');
        $namelist = $request->input('namelist');
        $nameidlist = $request->input('nameidlist');
        $checkboxlist = $request->input('checkboxlist');
        $textlist = $request->input('textlist');

        $bonus = new Bonus;


        // 獎金
        $bonus->id_events       = $id_events;         // 場次ID
        $bonus->id_course       = $id_course;         // 課程ID
        $bonus->id_group        = $id_group;          // 群組ID
        $bonus->name            = $name;              // 姓名
        $bonus->status          = $bonus_status;      // 狀態

        $bonus->save();
        $id_bonus = $bonus->id;

        // 獎金規則
        $checkboxlist = explode(",", $checkboxlist);
        $textlist = explode("|", $textlist);
        $namelist = explode(",", $namelist);
        $nameidlist = explode(",", $nameidlist);
        if (!empty($id_bonus)) {
            foreach ($checkboxlist as $key => $value_checkbox) {
                $bonusrule = new BonusRule;
                if ($checkboxlist[$key] == '1') {
                    $bonusrule->id_bonus       = $id_bonus;             // 獎金ID
                    $bonusrule->name           = $namelist[$key];       // 規則名稱
                    $bonusrule->name_id        = $nameidlist[$key];     // 規則名稱ID               
                    $bonusrule->value          = $textlist[$key];       // 規則
                    $bonusrule->status         = $checkboxlist[$key];   // 狀態

                    $bonusrule->save();
                    $id_bonusrule = $bonusrule->id;
                }
            }
        }
        if (!empty($id_bonusrule) || !empty($id_bonus)) {
            return '儲存成功';
        } else {
            return '儲存失敗';
        }
    }

    /*** 刪除獎金資料 ***/
    public function deletebonus(Request $request)
    {
        $status = "";
        $id = $request->get('id');

        // 查詢是否有該筆資料
        $bonus = Bonus::where('id', $id)->get();

        // 刪除資料
        if (!empty($bonus)) {
            Bonus::where('id', $id)->delete();
            BonusRule::where('id_bonus', $id)->delete();

            $status = "刪除成功";
        } else {
            $status = "刪除失敗";
        }
        return $status;
    }

    /*** 更新獎金規則資料 ***/
    public function updatebonus(Request $request)
    {
        //取回data
        $id = $request->input('id');
        $name = $request->input('name');
        $bonus_status = $request->input('bonus_status');
        $namelist = $request->input('namelist');
        $nameidlist = $request->input('nameidlist');
        $checkboxlist = $request->input('checkboxlist');
        $textlist = $request->input('textlist');


        // 更新資料 -> 獎金
        $bonus = Bonus::where('id', $id)
            ->update(['name' => $name, 'status' => $bonus_status]);


        // 獎金規則
        $checkboxlist = explode(",", $checkboxlist);
        $textlist = explode("|", $textlist);
        $namelist = explode(",", $namelist);
        $nameidlist = explode(",", $nameidlist);
        if (!empty($bonus)) {
            // 刪除全部資料
            $id_delete = BonusRule::where('id_bonus', $id)->delete();
            // 新增資料            
            foreach ($checkboxlist as $key => $value_checkbox) {
                $bonusrule = new BonusRule;
                if ($checkboxlist[$key] == '1') {
                    $bonusrule->id_bonus       = $id;                   // 獎金ID
                    $bonusrule->name           = $namelist[$key];       // 規則名稱
                    $bonusrule->name_id        = $nameidlist[$key];     // 規則名稱ID               
                    $bonusrule->value          = $textlist[$key];       // 規則
                    $bonusrule->status         = $checkboxlist[$key];   // 狀態

                    $bonusrule->save();
                    $id_bonusrule = $bonusrule->id;
                }
            }
        }
        if (!empty($bonus) || !empty($id_bonusrule)) {
            return $id_delete;
        } else {
            return '更新失敗';
        }
    }
}
