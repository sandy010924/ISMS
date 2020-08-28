<?php

namespace App\Http\Controllers\Frontend;

use Response;
use App\Model\Debt;
use App\Model\Mark;
use App\Model\Refund;
use App\Model\Course;
use App\Model\Student;
use App\Model\Payment;
use App\Model\Activity;
use App\Model\Receiver;
use App\Model\Register;
use App\Model\Blacklist;
use App\Model\EventsCourse;
use App\Model\Registration;
use App\Model\SalesRegistration;
use App\Model\StudentGroupdetail;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class SandyqController extends Controller
{
    // 顯示資料
    public function show()
    {
        return view('frontend.sandyq');
    }


    // 修改學員資料
    public function sandyqstudent(Request $request)
    {
        $delete_id = [];
        $idlist = $request->input('idlist');
        $change_id_student = $request->input('change_id_student');
        // $delete_id_student = $request->input('delete_id_student');


        $idlist = explode(",", $idlist);

        // 要刪掉的學員id
        $delete_id = $idlist;
        if (($key = array_search($change_id_student, $delete_id)) !== false) {
            unset($delete_id[$key]);
        }

        /*更改學員ID Rocky (2020/08/05)*/

        // 活動
        Activity::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 黑名單
        Blacklist::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 追單
        Debt::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 標記
        Mark::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 付款
        Payment::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 收訊息 
        Receiver::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 退款 
        Refund::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 正課報到 
        Register::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 正課報名 
        Registration::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 銷講報名
        SalesRegistration::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 名單列表 
        StudentGroupdetail::wherein('id_student', $idlist)
            ->update(['id_student' => $change_id_student]);

        // 刪除
        Student::wherein('id', $delete_id)->delete();

        $data = Student::where('id', $change_id_student)
            ->select('student.name')
            ->get();

        /*更改學員ID Rocky (2020/08/05)*/
        return $data;
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
        return view('frontend.sandyq', compact('bonus'));
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
                                            echo $array_datasource[$i] . "<br>";
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
                                    $query->wherein('events_course.staff', explode(',', $data['value']));
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

    
    // 快速搜尋小工具
    public function search(Request $request)
    {
        $list = $request->input('list');

        $list = explode(" ", $list);

        $data = array();

        foreach ( $list as $item){

            $student = Student::where('name', $item)->get();

            $id = '';
            $phone = array();
            $email = array();

            foreach( $student as $key => $item2 ){
                if( $key == 0 ){
                    $id .= $item2['id'] . '|';
                }else if ( $key == count($student)-1 ){
                    $id .= $item2['id'];
                }else{
                    $id .= $item2['id'] . ',';
                }

                array_push($phone, $item2['phone']);
                array_push($email, $item2['email']);
            }

            $phone = array_unique($phone);
            $email = array_unique($email);

            $memo = '';
            if(count($phone)>1){
                $memo .= '電話不同';
            }
            if(count($email)>1){
                if( $memo != '' ){
                    $memo .= '、';
                }
                $memo .= '信箱不同';
            }
            
            $data[count($data)] = [
                'name' => $item,
                'student' => $student,
                'id' => $id,
                'memo' => $memo
            ];
        }


        return $data;
    }
}
