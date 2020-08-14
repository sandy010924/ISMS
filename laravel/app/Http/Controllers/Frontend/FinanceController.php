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
            // ->where('unpublish', '0')
            ->groupBy('events_course.id_group')
            ->orderBy('events_course.course_start_at', 'desc')
            ->get();

        foreach ($events as $key => $data) {
            $type = "";
            $course = '';
            $events_multi_data = '';

            // $count_invoice = Registration::Where('status_payment', '7')
            //     ->selectRaw('COUNT(*)  as total')
            //     ->selectRaw("SUM(CASE WHEN invoice is NOT null THEN 1 ELSE 0 END) as count_invoice")
            //     ->Where('id_group', $data['id_group'])
            //     ->get();

            // 銷講要看到下一階報名的學員資料 Rocky(2020/06/28)
            $count_invoice = Registration::selectRaw('COUNT(*)  as total')
                ->selectRaw("SUM(CASE WHEN invoice is NOT null THEN 1 ELSE 0 END) as count_invoice")
                ->Where('source_events', $data['id'])
                ->Where('status_payment', '7')
                ->get();

            // 篩選多天 Rocky(2020/06/30)
            $events_multi = EventsCourse::where('events_course.id_group', '=', $data['id_group'])
                ->select('events_course.course_start_at', 'events_course.id_group')
                ->orderBy('events_course.course_start_at', 'desc')
                ->get();

            if (count($events_multi) > 1) {
                foreach ($events_multi as $key2 => $data2) {
                    $events_multi_data .= date('Y-m-d', strtotime($data2['course_start_at'])) . ',  ';
                }
                $course = $data['course'] . "(多天)";
            } else {
                $course = $data['course'];
            }

            $events[$key] = [
                'id' => $data['id'],
                'id_group' => $data['id_group'],
                'id_course' => $data['id_course'],
                'course_start_at' => date('Y-m-d', strtotime($data['course_start_at'])),
                'course' =>   $course,
                'event' => $data['name'],
                'cost_ad' => $data['cost_ad'],
                'cost_message' => $data['cost_message'],
                'cost_events' => $data['cost_events'],
                'count_invoice' => $count_invoice[0]['count_invoice'],
                'total' => $count_invoice[0]['total'],
                'events_multi_data' => substr($events_multi_data, 0, -3),
            ];
        }
        return view('frontend.finance', compact('events'));
    }


    // 顯示學員資料
    public function showstudent(Request $request)
    {
        $id_events = $request->get('id_events');

        $data = Registration::join('student', 'registration.id_student', '=', 'student.id')
            ->select('registration.*', 'student.name', 'student.address')
            ->Where('status_payment', '7')
            ->Where('source_events', $id_events)
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
        $datas = [];
        $id_bonus = $request->get('id');

        // 獎金規則
        $datas_rule = Bonus::leftjoin('bonus_rule as b', 'Bonus.id', '=', 'b.id_bonus')
            ->select('Bonus.name as bonus_name', 'b.name', 'b.name_id', 'b.value')
            ->where('Bonus.id', $id_bonus)
            ->get();

        foreach ($datas_rule as $key => $data) {
            $array_datasource = explode(',', $data['value']);
            // echo $array_datasource[0] . "<br>";
            switch ($data['name_id']) {
                case "0":
                    // 名單來源包含
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
                                            // echo $array_datasource[$i] . "<br>";
                                        }
                                        // $query->wherein('c.datasource', explode(',', $data['value']));
                                        break;
                                }
                            }
                        })
                        ->groupby('b.id')
                        ->get();
            }
            // echo count($datas) . "<br>";
        }
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
            $array_student = array();
            $array_search_deal = array();
            $from = date('Y-m-d H:m:s', strtotime("-90 days"));
            $to = date('Y-m-d H:m:s', strtotime("+90 days"));
            foreach ($datas_rule as $key => $data) {
                switch ($data['name_id']) {
                    case "0":
                        // 名單來源包含 更改寫法以90天內為主，否則以其他資料為主 Rocky(2020/07/25)


                        // 先找符合條件、90天內資料
                        $datas_stuent_90 = EventsCourse::join('registration as b', 'events_course.id', '=', 'b.source_events')
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
                                            break;
                                    }
                                }
                            })
                            ->whereBetween('c.submissiondate', [$from, $to])
                            ->groupby('b.id')
                            ->get();

                        // 將90天內資料新增到array
                        foreach ($datas_stuent_90 as $key => $value_datas_stuent_90) {
                            array_push($array_student, array(
                                'id'                    => $datas_stuent_90[$key]['id'],
                                'memo'                  => $datas_stuent_90[$key]['memo'],
                                'course_start_at'       => $datas_stuent_90[$key]['course_start_at'],
                                'course_name'           => $datas_stuent_90[$key]['course_name'],
                                'events_name'           => $datas_stuent_90[$key]['events_name'],
                                'student_name'          => $datas_stuent_90[$key]['student_name'],
                                'email'                 => $datas_stuent_90[$key]['email'],
                                'phone'                 => $datas_stuent_90[$key]['phone'],
                                'status_name'           => $datas_stuent_90[$key]['status_name'],
                                'datasource'            => $datas_stuent_90[$key]['datasource'],
                            ));
                        }

                        // 找全部資料(沒有90天內限制)
                        $datas_stuent = EventsCourse::join('registration as b', 'events_course.id', '=', 'b.source_events')
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
                                            break;
                                    }
                                }
                            })
                            ->groupby('b.id')
                            ->get();

                        $arr = array_column(
                            array_merge($array_search_deal, json_decode($datas_stuent_90, true)),
                            'id'
                        );

                        // 比較90天內和沒有90天內，如果同樣學員90天內有資料以90天內為主，否則新增沒有90天內的資料
                        foreach ($datas_stuent as $key => $value_datas_stuent) {
                            $check_array_search = array_search($value_datas_stuent['id'], $arr);
                            // 沒有重複值才新增
                            if ($check_array_search === false) {
                                array_push($array_student, array(
                                    'id'                    => $datas_stuent[$key]['id'],
                                    'memo'                  => $datas_stuent[$key]['memo'],
                                    'course_start_at'       => $datas_stuent[$key]['course_start_at'],
                                    'course_name'           => $datas_stuent[$key]['course_name'],
                                    'events_name'           => $datas_stuent[$key]['events_name'],
                                    'student_name'          => $datas_stuent[$key]['student_name'],
                                    'email'                 => $datas_stuent[$key]['email'],
                                    'phone'                 => $datas_stuent[$key]['phone'],
                                    'status_name'           => $datas_stuent[$key]['status_name'],
                                    'datasource'            => $datas_stuent[$key]['datasource'],
                                ));
                            }
                        }

                        $datas = $array_student;
                }
            }
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
                            // $array_value = explode(',', $data['value']);
                            switch ($data['name_id']) {
                                case "1":
                                    // 工作人員包含
                                    // for ($i = 0; $i < count($array_value); $i++) {
                                    //     $query->orwhere('events_course.staff', 'like', '%' . $array_value[$i] . '%');
                                    // }
                                    // $query->wherein('events_course.staff', explode(',', $data['value']));
                                    $array_datasource = explode(',', $data['value']);
                                    for ($i = 0; $i < count($array_datasource); $i++) {
                                        $query->orwhere('events_course.staff', 'like', '%' . $array_datasource[$i] . '%');
                                    }

                                    break;
                                case "2":
                                    // 主持開場包含
                                    // for ($i = 0; $i < count($array_value); $i++) {
                                    //     $query->orwhere('events_course.host', 'like', '%' . $array_value[$i] . '%');
                                    // }
                                    $query->wherein('events_course.host', explode(',', $data['value']));
                                    break;
                                case "3":
                                    // 結束收單包含
                                    // for ($i = 0; $i < count($array_value); $i++) {
                                    //     $query->orwhere('events_course.closeorder', 'like', '%' . $array_value[$i] . '%');
                                    // }
                                    $query->wherein('events_course.closeorder', explode(',', $data['value']));
                                    break;
                                case "4":
                                    // 服務人員包含
                                    // for ($i = 0; $i < count($array_value); $i++) {
                                    //     $query->orwhere('b.person', 'like', '%' . $array_value[$i] . '%');
                                    // }
                                    $query->wherein('b.person', explode(',', $data['value']));
                                    break;
                                case "5":
                                    // 追單人員包含
                                    // for ($i = 0; $i < count($array_value); $i++) {
                                    //     $query->orwhere('g.person', 'like', '%' . $array_value[$i] . '%');
                                    // }
                                    $query->wherein('g.person', explode(',', $data['value']));
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
