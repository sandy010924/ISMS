<?php

namespace App\Http\Controllers\Frontend;

use Response;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\Student;
use App\Model\Registration;
use App\Model\Bonus;
use App\Model\BonusRule;
use Symfony\Component\HttpFoundation\Request;

class FinanceController extends Controller
{
    // 顯示資料
    public function show()
    {

        $events = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
            ->select('events_course.*', 'course.name as course', 'course.type as type')
            ->where('type', '<>', '1')
            ->where('unpublish', '0')
            ->groupBy('events_course.id_group')
            ->orderBy('events_course.course_start_at', 'desc')
            ->get();

        foreach ($events as $key => $data) {
            $type = "";

            $count_invoice = Registration::Where('status_payment', '7')
                ->selectRaw('COUNT(*)  as total')
                ->selectRaw("SUM(CASE WHEN invoice is NOT null THEN 1 ELSE 0 END) as count_invoice")
                ->Where('id_group', $data['id_group'])
                ->get();

            $events[$key] = [
                'id' => $data['id'],
                'id_group' => $data['id_group'],
                'id_course' => $data['id_course'],
                'course_start_at' => date('Y-m-d', strtotime($data['course_start_at'])),
                'course' => $data['course'],
                'event' => $data['name'],
                'cost_ad' => $data['cost_ad'],
                'cost_message' => $data['cost_message'],
                'cost_events' => $data['cost_events'],
                'count_invoice' => $count_invoice[0]['count_invoice'],
                'total' => $count_invoice[0]['total']
            ];
        }
        return view('frontend.finance', compact('events'));
    }


    // 顯示學員資料
    public function showstudent(Request $request)
    {
        $id_group = $request->get('id_group');

        $data = Registration::join('student', 'registration.id_student', '=', 'student.id')
            ->select('registration.*', 'student.name', 'student.address')
            ->Where('status_payment', '7')
            ->Where('id_group', $id_group)
            ->get();

        return $data;

        // $course = array();
        // $apply = array();
        // $start = '';
        // $end = '';
        // $start_array = array();
        // $end_array = array();

        // //課程資訊
        // $id = $request->get('id');
        // $course = Course::join('teacher', 'teacher.id', '=', 'course.id_teacher')
        //     ->select('course.*', 'teacher.name as teacher')
        //     - where('course.type', '<>', '1')
        //     ->Where('course.id', $id)
        //     ->first();


        // //正課
        // $apply_table = Registration::join('events_course', 'events_course.id', '=', 'registration.id_events')
        //     ->join('student', 'student.id', '=', 'registration.id_student')
        //     ->select('student.phone as phone', 'student.email as email', 'student.profession as profession', 'registration.*', 'events_course.name as event', 'events_course.id_group as id_group')
        //     ->Where('registration.id_course', $id)
        //     ->get();

        // $id_group = '';
        // $id_student = '';

        // foreach ($apply_table as $key => $data) {
        //     $course_group = EventsCourse::Where('id_group', $data['id_group'])
        //         ->get();

        //     $numItems = count($course_group);
        //     $i = 0;

        //     $events = '';

        //     foreach ($course_group as $key_group => $data_group) {
        //         //日期
        //         $date = date('Y-m-d', strtotime($data_group['course_start_at']));
        //         //星期
        //         $weekarray = array("日", "一", "二", "三", "四", "五", "六");
        //         $week = $weekarray[date('w', strtotime($data_group['course_start_at']))];

        //         if (++$i === $numItems) {
        //             $events .= $date . '(' . $week . ')';
        //         } else {
        //             $events .= $date . '(' . $week . ')' . '、';
        //         }
        //     }

        //     $apply[$key] = array(
        //         'id' => $data['id'],
        //         'date' => date('Y-m-d', strtotime($data['created_at'])),
        //         'event' => $events . ' ' . $data['event'],
        //         'phone' => $data['phone'],
        //         'email' => $data['email'],
        //         'profession' => $data['profession'],
        //         'content' => $data['course_content'],
        //     );
        // }

        // //開始時間
        // $start_array = Registration::select('created_at as date')
        //     ->where('id_course', $id)
        //     ->orderBy('date', 'asc')
        //     ->first();

        // //結束時間
        // $end_array = Registration::select('created_at as date')
        //     ->where('id_course', $id)
        //     ->orderBy('date', 'desc')
        //     ->first();


        // if ($start_array != "" && $end_array != "") {
        //     $start = date('Y-m-d', strtotime($start_array->date));
        //     $end = date('Y-m-d', strtotime($end_array->date));
        // }

        // return view('frontend.finance', compact('course', 'apply', 'start', 'end'));
    }

    // 顯示獎金名單資料
    public function showbonus()
    {
        $bonus = Bonus::orderBy('created_at', 'desc')
            ->get();

        foreach ($bonus as $key => $data) {
            $bonusrule = BonusRule::select('name', 'value')
                ->Where('id_bonus', $data['id'])
                ->get();

            $bonus[$key] = [
                'id' => $data['id'],
                'bonus_name' => $data['name'],
                'bonus_status' => $data['status'],
                'created_at' => date('Y-m-d', strtotime($data['created_at'])),
                'bonus_rule' => $bonusrule
            ];
        }
        return view('frontend.bonus', compact('bonus'));
    }

    // 顯示獎金規則資料
    public function showbonusrule(Request $request)
    {
        $id = $request->get('id');
        $bonus = Bonus::where('id', $id)
            ->get();

        foreach ($bonus as $key => $data) {
            $bonusrule = BonusRule::select('name', 'value', 'name_id', 'status')
                ->Where('id_bonus', $data['id'])
                ->get();

            $bonus[$key] = [
                'id' => $data['id'],
                'bonus_name' => $data['name'],
                'bonus_status' => $data['status'],
                'created_at' => date('Y-m-d', strtotime($data['created_at'])),
                'bonus_rule' => $bonusrule
            ];
        }
        return $bonus;
    }

    // 顯示獎金詳細資料(完整內容)
    public function showeditdata(Request $request)
    {
        $id_bonus = $request->get('id');

        // 獎金規則
        $datas_rule = Bonus::leftjoin('bonus_rule as b', 'Bonus.id', '=', 'b.id_bonus')
            ->select('Bonus.name as bonus_name', 'b.name', 'b.name_id', 'b.value')
            ->where('Bonus.id', $id_bonus)
            ->get();

        $datas = EventsCourse::join('registration as b', 'events_course.id', '=', 'b.source_events')
            ->leftjoin('sales_registration as c', 'b.id_student', '=', 'c.id_student', 'b.source_events', '=', 'c.id_events')
            ->leftjoin('student as d', 'b.id_student', '=', 'd.id')
            ->leftjoin('course as e', 'events_course.id_course', '=', 'e.id')
            ->leftjoin('isms_status as f', 'f.id', '=', 'b.status_payment')
            ->select('b.id', 'events_course.course_start_at', 'e.name as course_name', 'events_course.name as events_name', 'd.name as student_name', 'd.email', 'd.phone', 'f.name as status_name')
            ->where(function ($query) use ($datas_rule) {
                foreach ($datas_rule as $key => $data) {
                    switch ($data['name_id']) {
                        case "0":
                            // 名單來源包含
                            $query->wherein('c.datasource', explode(',', $data['value']));
                            break;
                    }
                }
            })
            ->get();

        return view('frontend.bonus_detail', compact('datas', 'datas_rule', 'id_bonus'));
    }

    public function showbonusstudent(Request $request)
    {
        $id_bonus = $request->get('id_bonus');
        $type = $request->get('type');
        $datas_rule_vlue = '';
        $datas = '';

        // 獎金規則
        $datas_rule = Bonus::leftjoin('bonus_rule as b', 'Bonus.id', '=', 'b.id_bonus')
            ->select('Bonus.name as bonus_name', 'b.name', 'b.name_id', 'b.value')
            ->where('Bonus.id', $id_bonus)
            ->where('b.name_id', $type)
            ->get();

        // 學員資料
        if ($type == "0") {
            $datas = EventsCourse::join('registration as b', 'events_course.id', '=', 'b.source_events')
                ->leftjoin('sales_registration as c', 'b.id_student', '=', 'c.id_student', 'b.source_events', '=', 'c.id_events')
                ->leftjoin('student as d', 'b.id_student', '=', 'd.id')
                ->leftjoin('course as e', 'events_course.id_course', '=', 'e.id')
                ->leftjoin('isms_status as f', 'f.id', '=', 'b.status_payment')
                ->select('b.id', 'events_course.course_start_at', 'e.name as course_name', 'events_course.name as events_name', 'd.name as student_name', 'd.email', 'd.phone', 'f.name as status_name', 'c.datasource')
                ->where(function ($query) use ($datas_rule) {
                    foreach ($datas_rule as $key => $data) {
                        switch ($data['name_id']) {
                            case "0":
                                // 名單來源包含
                                $query->wherein('c.datasource', explode(',', $data['value']));
                                break;
                        }
                    }
                })
                ->get();
        } else {
            if (count($datas_rule) != 0) {
                $datas = EventsCourse::join('registration as b', 'events_course.id', '=', 'b.source_events')
                    ->leftjoin('student as d', 'b.id_student', '=', 'd.id')
                    ->leftjoin('course as e', 'events_course.id_course', '=', 'e.id')
                    ->leftjoin('isms_status as f', 'f.id', '=', 'b.status_payment')
                    ->leftjoin('debt as g', 'g.id_registration', '=', 'b.id')
                    ->select('b.id', 'events_course.course_start_at', 'e.name as course_name', 'events_course.name as events_name', 'd.name as student_name', 'd.email', 'd.phone', 'f.name as status_name')
                    ->where(function ($query) use ($datas_rule) {
                        foreach ($datas_rule as $key => $data) {
                            switch ($data['name_id']) {
                                case "1":
                                    // 工作人員包含
                                    $query->wherein('events_course.staff', explode(',', $data['value']));
                                    break;
                                case "2":
                                    // 主持開場包含
                                    $query->wherein('events_course.host', explode(',', $data['value']));
                                    break;
                                case "3":
                                    // 結束收單包含
                                    $query->wherein('events_course.closeorder', explode(',', $data['value']));
                                    break;
                                case "4":
                                    // 服務人員包含
                                    $query->wherein('b.person', explode(',', $data['value']));
                                    break;
                                case "5":
                                    // 追單人員包含
                                    $query->wherein('g.person', explode(',', $data['value']));
                                    break;
                            }
                        }
                    })
                    ->get();
            }
        }
        if (!empty($datas_rule[0]['value'])) {
            $datas_rule_vlue = $datas_rule[0]['value'];
        }

        return response::json([
            'datas' => $datas,
            'datas_rule_vlue' => $datas_rule_vlue,
            'type' =>  $type,
            'datas_rule' => $datas_rule,
            'count' => count($datas_rule)
        ]);
    }
    // //日期排序
    // private static function dateSort(
    //     $a,
    //     $b
    // ) {
    //     if ($a["created_at"] > $b["created_at"]) {
    //         return -1;
    //     } elseif ($a["created_at"] < $b["created_at"]) {
    //         return 1;
    //     }
    //     return 0;
    // }
}
