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
            ->orderby('registration.created_at', 'desc')
            ->get();

        return $data;
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
            ->select('b.id', 'b.memo', 'events_course.course_start_at', 'e.name as course_name', 'events_course.name as events_name', 'd.name as student_name', 'd.email', 'd.phone', 'f.name as status_name')
            ->where(function ($query) use ($datas_rule) {
                foreach ($datas_rule as $key => $data) {
                    $array_datasource = explode(',', $data['value']);
                    switch ($data['name_id']) {
                        case "0":
                            // 名單來源包含
                            for ($i = 0; $i < count($array_datasource); $i++) {
                                $query->orwhere('c.datasource', 'like', '%' . $array_datasource[$i] . '%');
                            }
                            // $query->wherein('c.datasource', explode(',', $data['value']));
                            break;
                    }
                }
            })
            ->groupby('b.id')
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
                ->select('b.id', 'b.memo', 'events_course.course_start_at', 'e.name as course_name', 'events_course.name as events_name', 'd.name as student_name', 'd.email', 'd.phone', 'f.name as status_name', 'c.datasource')
                ->where(function ($query) use ($datas_rule) {
                    foreach ($datas_rule as $key => $data) {
                        switch ($data['name_id']) {
                            case "0":
                                // 名單來源包含
                                $array_datasource = explode(',', $data['value']);
                                for ($i = 0; $i < count($array_datasource); $i++) {
                                    $query->orwhere('c.datasource', 'like', '%' . $array_datasource[$i] . '%');
                                }
                                // $query->wherein('c.datasource', explode(',', $data['value']));
                                break;
                        }
                    }
                })
                ->groupby('b.id')
                ->get();
        } else {
            if (count($datas_rule) != 0) {
                $datas = EventsCourse::join('registration as b', 'events_course.id', '=', 'b.source_events')
                    ->leftjoin('student as d', 'b.id_student', '=', 'd.id')
                    ->leftjoin('course as e', 'events_course.id_course', '=', 'e.id')
                    ->leftjoin('isms_status as f', 'f.id', '=', 'b.status_payment')
                    ->leftjoin('debt as g', 'g.id_registration', '=', 'b.id')
                    ->select('b.id', 'b.memo', 'events_course.course_start_at', 'e.name as course_name', 'events_course.name as events_name', 'd.name as student_name', 'd.email', 'd.phone', 'f.name as status_name')
                    ->where(function ($query) use ($datas_rule) {
                        foreach ($datas_rule as $key => $data) {
                            $array_value = explode(',', $data['value']);
                            switch ($data['name_id']) {
                                case "1":
                                    // 工作人員包含
                                    for ($i = 0; $i < count($array_value); $i++) {
                                        $query->orwhere('events_course.staff', 'like', '%' . $array_value[$i] . '%');
                                    }
                                    // $query->wherein('events_course.staff', explode(',', $data['value']));
                                    break;
                                case "2":
                                    // 主持開場包含
                                    for ($i = 0; $i < count($array_value); $i++) {
                                        $query->orwhere('events_course.host', 'like', '%' . $array_value[$i] . '%');
                                    }
                                    // $query->wherein('events_course.host', explode(',', $data['value']));
                                    break;
                                case "3":
                                    // 結束收單包含
                                    for ($i = 0; $i < count($array_value); $i++) {
                                        $query->orwhere('events_course.closeorder', 'like', '%' . $array_value[$i] . '%');
                                    }
                                    // $query->wherein('events_course.closeorder', explode(',', $data['value']));
                                    break;
                                case "4":
                                    // 服務人員包含
                                    for ($i = 0; $i < count($array_value); $i++) {
                                        $query->orwhere('b.person', 'like', '%' . $array_value[$i] . '%');
                                    }
                                    // $query->wherein('b.person', explode(',', $data['value']));
                                    break;
                                case "5":
                                    // 追單人員包含
                                    for ($i = 0; $i < count($array_value); $i++) {
                                        $query->orwhere('g.person', 'like', '%' . $array_value[$i] . '%');
                                    }
                                    // $query->wherein('g.person', explode(',', $data['value']));
                                    break;
                            }
                        }
                    })
                    ->groupby('b.id')
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
}
