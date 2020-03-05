<?php

namespace App\Http\Controllers\Backend;

use App\Model\Student;
use App\Model\Blacklist;
use App\Model\Rule;
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

    public function add()
    {
        // 宣告變數
        $array_acc = array();   // 累積課程陣列
        $array_sin = array();   // 單一課程陣列

        // 累積未到、取消
        $acc_student = Student::leftjoin('sales_registration as b', 'b.id_student', '=', 'student.id')
                            ->leftjoin('course as c', 'b.id_course', '=', 'c.id')
                            ->where('student.check_blacklist', '0')
                            ->where(function ($query) {
                                $query->where(function ($query) {
                                    $query->where('b.id_status', '3')->orwhere('b.id_status', '5');
                                });
                            })
                            ->groupby('student.id')
                            ->select('student.id', 'student.name as name_student', 'b.id_status', 'c.name as name_course')
                            ->selectRaw("SUM(CASE WHEN b.id_status ='3' THEN 1 ELSE 0 END) AS count_no")
                            ->selectRaw("SUM(CASE WHEN b.id_status ='5' THEN 1 ELSE 0 END) AS count_cancel")
                            ->get();
                            
        // 一個學員對一個課程的 取消、未到總計
        $sin_student = Student::leftjoin('sales_registration as b', 'b.id_student', '=', 'student.id')
                            ->leftjoin('course as c', 'b.id_course', '=', 'c.id')
                            ->where('student.check_blacklist', '0')
                            ->where(function ($query) {
                                $query->where(function ($query) {
                                    $query->where('b.id_status', '3')->orwhere('b.id_status', '5');
                                });
                            })
                            ->groupby('student.id', 'c.name')
                            ->select('student.id', 'student.name as name_student', 'b.id_status', 'c.name as name_course')
                            ->selectRaw("SUM(CASE WHEN b.id_status ='3' THEN 1 ELSE 0 END) AS count_no")
                            ->selectRaw("SUM(CASE WHEN b.id_status ='5' THEN 1 ELSE 0 END) AS count_cancel")
                            ->get();

        // 規則
        $rule = Rule::where('type', '0')
                        ->where('rule_status', '1')
                        ->select('rule_value', 'name', 'regulation')
                        ->get();

        
        // 單一課程
        
        foreach ($sin_student as $key_student => $value_student) {
            foreach ($rule as $key_rule => $value_rule) {
                // 單一課程累積_未到幾次
                if ($value_rule['rule_value'] == '0') {
                    if ($value_student['count_no'] >= $value_rule['regulation'] && $value_rule['regulation'] != '0') {
                        // 判斷陣列是否有重複資料
                        if (!in_array($value_student['id'], $array_sin)) {
                            array_push($array_sin, array(
                                'id' => $value_student['id'],'reason' => '單一課程累積未到'.$value_student['count_no'].'次'
                            ));
                        }
                    }
                }
                // 單一課程累積_取消幾次
                if ($value_rule['rule_value'] == '1') {
                    if ($value_student['count_cancel'] >= $value_rule['regulation'] && $value_rule['regulation'] != '0') {
                        // 判斷陣列是否有重複資料
                        if (!in_array($value_student['id'], $array_sin)) {
                            array_push($array_sin, array(
                                'id' => $value_student['id'],'reason' => '單一課程累積取消'.$value_student['count_cancel'].'次'
                            ));
                        }
                    }
                }

                // 單一課程累積_未到+取消幾次
                if ($value_rule['rule_value'] == '2') {
                    $total = $value_student['count_no'] + $value_student['count_cancel'];
                    if ($total >= $value_rule['regulation'] && $value_rule['regulation'] != '0') {
                        // 判斷陣列是否有重複資料
                        if (!in_array($value_student['id'], $array_sin)) {
                            array_push($array_sin, array(
                                'id' => $value_student['id'],
                                'reason' => '單一課程累積未到+取消'.$total.'幾次'
                            ));
                        }
                    }
                }
                // 單一課程累積_出席幾次但未留單
            }
        }

        // 累積課程
        foreach ($acc_student as $key_student => $value_student) {
            foreach ($rule as $key_rule => $value_rule) {
                // 所有課程累積_未到幾次
                if ($value_rule['rule_value'] == '4') {
                    if ($value_student['count_no'] >= $value_rule['regulation'] && $value_rule['regulation'] != '0') {
                        // 判斷陣列是否有重複資料
                        if (!in_array($value_student['id'], $array_acc)) {
                            array_push($array_acc, array(
                                'id' => $value_student['id'],
                                'reason' => '所有課程累積未到'.$value_student['count_no'].'次'
                            ));
                        }
                    }
                }
                // 所有課程累積_取消幾次
                if ($value_rule['rule_value'] == '5') {
                    if ($value_student['count_cancel'] >= $value_rule['regulation'] && $value_rule['regulation'] != '0') {
                        // 判斷陣列是否有重複資料
                        if (!in_array($value_student['id'], $array_acc)) {
                            array_push($array_acc, array(
                                'id' => $value_student['id'],
                                'reason' => '所有課程累積取消'.$value_student['count_cancel'].'次'
                            ));
                        }
                    }
                }

                // 所有課程累積_未到+取消幾次
                if ($value_rule['rule_value'] == '6') {
                    $total = $value_student['count_no'] + $value_student['count_cancel'];
                    if ($total >= $value_rule['regulation'] && $value_rule['regulation'] != '0') {
                        // 判斷陣列是否有重複資料
                        if (!in_array($value_student['id'], $array_acc)) {
                            array_push($array_acc, array(
                                'id' => $value_student['id'],
                                'reason' => '所有課程累積未到+取消'.$total.'次'
                            ));
                        }
                    }
                }
            }
        }

        return json_encode($array_sin);
    }
}
