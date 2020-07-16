<?php

namespace App\Http\Controllers\Frontend;

use Response;
use DB;
use App\Http\Controllers\Controller;
use App\Model\Student;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Refund;
use App\Model\Debt;
use App\Model\Mark;
use App\Model\EventsCourse;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // 顯示資料
    public function show()
    {
        // 講師ID Rocky(2020/05/11)
        if (isset(Auth::user()->role) == '') {
            return view('frontend.error_authority');
        } elseif (isset(Auth::user()->role) != '' && Auth::user()->role == "teacher") {
            $id_teacher = Auth::user()->id_teacher;
            $students = Student::join('sales_registration', 'student.id', '=', 'sales_registration.id_student')
                ->join('course', 'sales_registration.id_course', '=', 'course.id')
                ->select('student.*', 'sales_registration.datasource')
                ->where('course.id_teacher', $id_teacher)
                ->groupBy('id')
                ->orderby('created_at', 'desc')
                ->take(500)
                ->get();
        } else {
            $students = Student::join('sales_registration', 'student.id', '=', 'sales_registration.id_student')
                ->join('course', 'sales_registration.id_course', '=', 'course.id')
                ->select('student.*', 'sales_registration.datasource')
                ->groupBy('id')
                ->orderby('created_at', 'desc')
                ->take(500)
                ->get();
        }


        return view('frontend.student', compact('students'));
    }


    // 已填表單
    public function viewform(Request $request)
    {
        $id_student = $request->get('id_student');

        // 銷售講座
        $datas = SalesRegistration::leftjoin('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
            ->leftjoin('course', 'course.id', '=', 'sales_registration.id_course')
            ->select('sales_registration.*', 'isms_status.name as status', 'course.name as course')
            ->where('sales_registration.id_student', $id_student)
            ->get();
        // 正課
        $data_registration = Registration::leftjoin('register', 'register.id_student', '=', 'registration.id_student')
            ->leftjoin('isms_status', 'isms_status.id', '=', 'register.id_status')
            // leftjoin('isms_status', 'isms_status.id', '=', 'registration.id_status')
            ->leftjoin('course', 'course.id', '=', 'registration.id_course')
            ->select('registration.*', 'isms_status.name as status', 'course.name as course')
            ->where('registration.id_student', $id_student)
            ->get();

        $result = array_merge(json_decode($datas), json_decode($data_registration));
        return $result;
    }

    // 已填表單 - 詳細資料
    public function formdetail(Request $request)
    {
        $type = $request->get('type');
        $id = $request->get('id');
        $datas_events = array();
        if ($type == "0") {
            // 銷售講座
            $datas = SalesRegistration::leftjoin('course', 'course.id', '=', 'sales_registration.id_course')
                ->leftjoin('student', 'student.id', '=', 'sales_registration.id_student')
                ->leftjoin('events_course', 'events_course.id', '=', 'sales_registration.id_events')
                ->select('sales_registration.*', 'student.*', 'course.name as course', 'events_course.course_start_at as events_start')
                ->where('sales_registration.id', $id)
                ->get();

            // $datas_events = EventsCourse::where('id_course', function ($query) use ($id) {
            //     $query->select(DB::raw("(SELECT id_course FROM sales_registration WHERE id='" . $id . "')"));
            // })
            //     ->select('events_course.id', 'events_course.name', 'events_course.course_start_at', 'events_course.course_end_at')
            //     ->get();


            $events_table = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                ->select('events_course.*')
                ->where('events_course.id_course', function ($query) use ($id) {
                    $query->select(DB::raw("(SELECT id_course FROM sales_registration WHERE id='" . $id . "')"));
                })
                ->orderby('events_course.course_start_at', 'asc')
                ->get();

            $id_group = '';
            $events_list = array();

            foreach ($events_table as $key_events => $data_events) {
                if ($id_group == $data_events['id_group']) {
                    continue;
                }

                $course_group = EventsCourse::Where('id_group', $data_events['id_group'])
                    ->get();

                $numItems = count($course_group);
                $i = 0;

                $events_group = '';

                foreach ($course_group as $key_group => $data_group) {
                    //日期
                    $date = date('Y-m-d', strtotime($data_group['course_start_at']));
                    //星期
                    $weekarray = array("日", "一", "二", "三", "四", "五", "六");
                    $week = $weekarray[date('w', strtotime($data_group['course_start_at']))];

                    if (++$i === $numItems) {
                        $events_group .= $date . '(' . $week . ')';
                    } else {
                        $events_group .= $date . '(' . $week . ')' . '、';
                    }
                }
                //時間
                $time_strat = date('H:i', strtotime($data_group['course_start_at']));
                $time_end = date('H:i', strtotime($data_group['course_end_at']));

                $datas_events[$key_events] = [
                    'events' => $events_group . ' ' . $time_strat . '-' . $time_end . ' ' . $data_events['name'] . '-' . $data_events['location'],
                    'id' => $data_events['id'],
                    'id_group' => $data_events['id_group']
                ];

                $id_group = $data_events['id_group'];
            }
        } elseif ($type == "1") {
            // 正課
            $datas = Registration::leftjoin('course', 'course.id', '=', 'registration.id_course')
                ->leftjoin('student', 'student.id', '=', 'registration.id_student')
                ->leftjoin('payment', 'payment.id_student', '=', 'registration.id_student')
                ->leftjoin('events_course', 'events_course.id', '=', 'registration.id_events')
                ->select('registration.*', 'student.*', 'payment.*', 'course.name as course', 'events_course.course_start_at as events_start')
                ->where('registration.id', $id)
                ->get();

            // $datas_events = EventsCourse::where('id_course', function ($query) use ($id) {
            //     $query->select(DB::raw("(SELECT id_course FROM registration WHERE id='" . $id . "')"));
            // })
            //     ->select('events_course.id', 'events_course.name', 'events_course.course_start_at', 'events_course.course_end_at')
            //     ->get();

            $events_table = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                ->select('events_course.*')
                ->where('events_course.id_course', function ($query) use ($id) {
                    $query->select(DB::raw("(SELECT id_course FROM registration WHERE id='" . $id . "')"));
                })
                ->get();

            $id_group = '';
            $events_list = array();

            foreach ($events_table as $key_events => $data_events) {
                if ($id_group == $data_events['id_group']) {
                    continue;
                }

                $course_group = EventsCourse::Where('id_group', $data_events['id_group'])
                    ->get();

                $numItems = count($course_group);
                $i = 0;

                $events_group = '';

                foreach ($course_group as $key_group => $data_group) {
                    //日期
                    $date = date('Y-m-d', strtotime($data_group['course_start_at']));
                    //星期
                    $weekarray = array("日", "一", "二", "三", "四", "五", "六");
                    $week = $weekarray[date('w', strtotime($data_group['course_start_at']))];

                    if (++$i === $numItems) {
                        $events_group .= $date . '(' . $week . ')';
                    } else {
                        $events_group .= $date . '(' . $week . ')' . '、';
                    }
                }
                //時間
                $time_strat = date('H:i', strtotime($data_group['course_start_at']));
                $time_end = date('H:i', strtotime($data_group['course_end_at']));

                $datas_events[$key_events] = [
                    'events' => $events_group . ' ' . $time_strat . '-' . $time_end . ' ' . $data_events['name'] . '(' . $data_events['location'] . ')',
                    'id' => $data_events['id']
                ];

                $id_group = $data_events['id_group'];
            }
        }

        return response::json([
            'datas' => $datas,
            'events' => $datas_events
        ]);
    }


    // 基本資料
    public function coursedata(Request $request)
    {
        $id_student = $request->get('id_student');

        // 學員資料

        $datas_student = Student::leftjoin('sales_registration', 'sales_registration.id_student', '=', 'student.id')
            ->select('student.*', 'sales_registration.datasource as datasource_old', 'sales_registration.id as sales_registration_old')
            ->groupBy('student.id')
            ->orderBy('sales_registration.created_at', 'ASC')
            ->where('student.id', $id_student)
            ->get();
        // 銷售講座
        $datas = SalesRegistration::leftjoin('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
            ->leftjoin('course', 'course.id', '=', 'sales_registration.id_course')
            ->leftjoin('events_course', 'events_course.id', '=', 'sales_registration.id_events')
            ->select('sales_registration.id as sales_registration_id', 'sales_registration.*', 'isms_status.name as status_sales', 'course.name as course_sales', 'events_course.name as  course_sales_events', 'events_course.course_start_at as  sales_registration_course_start_at')
            // ->selectRaw('sales_registration.*, COUNT(sales_registration.id) as count_sales')
            ->selectRaw('(SELECT COUNT(b.id) FROM sales_registration b where b.id_student = ' . $id_student . ' ) as count_sales')
            ->selectRaw("(SELECT SUM(CASE WHEN c.id_status = '4' and c.id_student = " . $id_student . " THEN 1 ELSE 0 END)  FROM sales_registration c) as count_sales_ok")
            ->selectRaw(" (SELECT SUM(CASE WHEN b.id_status = '5' and b.id_student = " . $id_student . " THEN 1 ELSE 0 END)  FROM sales_registration b) as count_sales_no")
            // ->selectRaw("SUM(CASE WHEN sales_registration.id_status = '4' THEN 1 ELSE 0 END) AS count_sales_ok")
            // ->selectRaw("SUM(CASE WHEN sales_registration.id_status = '5' THEN 1 ELSE 0 END) AS count_sales_no")
            ->where('sales_registration.id_student', $id_student)
            // ->groupBy('sales_registration.id_student', 'course.id')
            ->orderBy('sales_registration.created_at', 'desc')
            ->first();

        // 正課
        $data_registration = Registration::leftjoin('register', 'register.id_student', '=', 'registration.id_student')
            ->leftjoin('isms_status', 'isms_status.id', '=', 'registration.status_payment')
            ->leftjoin('course', 'course.id', '=', 'registration.id_course')
            ->leftjoin('events_course', 'events_course.id', '=', 'registration.id_events')
            // ->leftjoin('isms_status as t1', 't1.id', '=', 'registration.status_payment')
            // ->select('registration.*', 'register.id_status', 't1.name as status_payment', 'isms_status.name as status_registration', 'course.name as course_registration', 'events_course.name as course_events')
            ->select('registration.*', 'register.id_status', 'isms_status.name as status_registration', 'course.name as course_registration', 'events_course.name as course_events', 'events_course.course_start_at as registration_course_start_at')
            ->where('registration.id_student', $id_student)
            ->orderBy('registration.created_at', 'desc')
            ->first();
        // 退費
        $data_refund = Refund::where('refund.id_student', $id_student)
            ->leftjoin('registration as r1', 'r1.id', '=', 'refund.id_registration')
            ->leftjoin('events_course as r2', 'r2.id', '=', 'r1.id_events')
            ->leftjoin('course as r3', 'r3.id', '=', 'r1.id_course')
            ->select('refund.refund_reason')
            ->selectraw('CONCAT(r3.name,"-",r2.name) as refund_course')
            ->orderBy('refund.created_at', 'desc')
            ->first();

        if ($datas != "") {
            $datas = $datas->toArray();
        } else {
            $datas = array();
        }

        if ($datas_student != "") {
            $datas_student = $datas_student->toArray();
        }


        if ($data_registration != "") {
            $data_registration = $data_registration->toArray();
            $result = array_merge($datas_student, $datas, $data_registration);
            if ($data_refund != "") {
                $data_refund = $data_refund->toArray();
                $result = array_merge($result, $data_refund);
            }
        } else {
            $result = array_merge($datas_student, $datas);
        }


        return $result;
    }


    // 聯絡狀況
    public function contactdata(Request $request)
    {
        $id_student = $request->get('id_student');

        $datas = Debt::select('debt.*')
            ->where('debt.id_student', $id_student)
            ->get();
        // ->leftjoin('course', 'course.id', '=', 'sales_registration.id_course')



        $result = $datas;

        return $result;
    }

    public function debtshow(Request $request)
    {
        $id = $request->get('id');

        $datas = Debt::select('debt.*')
            ->leftjoin('isms_status as b', 'b.id', '=', 'debt.id_status')
            ->select('debt.*', 'b.name as status_name')
            ->where('debt.id', $id)
            ->get();

        $result = $datas;

        return $result;
    }

    // 歷史互動
    public function historydata(Request $request)
    {
        $id_student = $request->get('id_student');

        // 銷講資料
        $datas_SalesRegistration = SalesRegistration::leftjoin('isms_status as a', 'a.id', '=', 'sales_registration.id_status')
            ->leftjoin('course as b', 'b.id', '=', 'sales_registration.id_course')
            ->leftjoin('events_course as c', 'c.id', '=', 'sales_registration.id_events')
            ->select('sales_registration.created_at', 'sales_registration.id_student')
            ->selectRaw(' CASE
                                        WHEN sales_registration.id_status = 1 THEN "銷講已報名"
                                        WHEN sales_registration.id_status = 2 THEN "我很遺憾"
                                        WHEN sales_registration.id_status = 3 THEN "銷講未到"
                                        WHEN sales_registration.id_status = 4 THEN "銷講報到"
                                        WHEN sales_registration.id_status = 5 THEN "銷講取消"
                                    END as status_sales')
            ->selectRaw("CONCAT(b.name,c.name,date_format(c.course_start_at, '%Y/%m/%d %H:%i'),' ',date_format(c.course_end_at, '%Y/%m/%d %H:%i'),c.location) AS course_sales ")
            ->where('sales_registration.id_student', $id_student)
            ->orderBy('sales_registration.created_at', 'desc')
            ->get();

        // 正課資料
        $datas_registration = Registration::leftjoin('register', 'register.id_student', '=', 'registration.id_student')
            ->leftjoin('isms_status as a', 'a.id', '=', 'register.id_status')
            ->leftjoin('course as b', 'b.id', '=', 'registration.id_course')
            ->leftjoin('events_course as c', 'c.id', '=', 'registration.id_events')
            ->select('registration.created_at', 'registration.id_student')
            ->selectRaw(' CASE
                                        WHEN register.id_status = 1 and registration.status_payment is null THEN "正課已報名"
                                        WHEN register.id_status = 3 and registration.status_payment is null THEN "正課未到"
                                        WHEN register.id_status = 4 and registration.status_payment is null THEN "正課報到"
                                        WHEN register.id_status = 5 and registration.status_payment is null THEN "正課取消"
                                        WHEN registration.status_payment = 6 THEN "正課留單"
                                        WHEN registration.status_payment = 7 THEN "正課完款"
                                        WHEN registration.status_payment = 8 THEN "正課付訂"
                                        WHEN registration.status_payment = 9 THEN "正課退費"
                                    END as status_sales')
            ->selectRaw("CONCAT(b.name,c.name,date_format(c.course_start_at, '%Y/%m/%d %H:%i'),' ',date_format(c.course_end_at, '%Y/%m/%d %H:%i'),c.location) AS course_sales ")
            ->where('registration.id_student', $id_student)
            // ->where('register.id_status', '7')
            ->orderBy('registration.created_at', 'desc')
            ->get();
        // 活動資料

        if ($datas_registration != "") {
            $datas_registration = $datas_registration->toArray();
            $datas_SalesRegistration = $datas_SalesRegistration->toArray();
            $result = array_merge($datas_SalesRegistration, $datas_registration);
            usort($result, array($this, "dateSort"));
        } else {
            $result = $datas_SalesRegistration;
        }
        // $result = $datas_SalesRegistration;
        return $result;
    }

    //日期排序
    private static function dateSort(
        $a,
        $b
    ) {
        if ($a["created_at"] > $b["created_at"]) {
            return -1;
        } elseif ($a["created_at"] < $b["created_at"]) {
            return 1;
        }
        return 0;
    }




    public function tagshow(Request $request)
    {
        $id_student = $request->get('id_student');

        $datas = Mark::where('id_student', $id_student)
            ->select('mark.id as value', 'mark.name_mark as text', 'mark.name_mark as continent')
            ->get();


        return json_encode($datas);
    }



    // 搜尋
    public function search(Request $request)
    {
        $array_student = array();
        $array_search_deal = array();
        $search_data = $request->get('search_data');

        // 講師ID Rocky(2020/05/11)
        if (isset(Auth::user()->role) == '') {
            return view('frontend.error_authority');
        } elseif (isset(Auth::user()->role) != '' && Auth::user()->role == "teacher") {
            $id_teacher = Auth::user()->id_teacher;
            // $students = Student::join('sales_registration', 'student.id', '=', 'sales_registration.id_student')
            //     ->join('course', 'sales_registration.id_course', '=', 'course.id')
            //     ->select('student.*', 'sales_registration.datasource')
            //     ->where('course.id_teacher', $id_teacher)
            //     ->where(function ($query) use ($search_data) {
            //         $query->Where('email', 'like', '%' . $search_data . '%')
            //             ->orWhere('phone', 'like', '%' . $search_data . '%')
            //             ->orWhere('student.name', 'like', '%' . $search_data . '%');
            //     })
            //     ->groupBy('id')
            //     ->orderby('created_at', 'desc')
            //     // ->take(500)
            //     ->get();


            // 改寫學員搜尋 -> 學員和資料來源分開搜尋(因為學員不一定都會報名銷講) Rocky (2020/07/07)

            // 銷講(符合講師ID)
            $sales_registration_data = SalesRegistration::join('course', 'sales_registration.id_course', '=', 'course.id')
                ->where('course.id_teacher', $id_teacher)
                ->select('sales_registration.id_student', 'sales_registration.id_course')
                ->groupBy('sales_registration.id_student')
                ->get();

            // 正課(符合講師ID)
            $registration_data = Registration::leftjoin('course', 'registration.id_course', '=', 'course.id')
                ->where('course.id_teacher', $id_teacher)
                ->select('registration.id_student', 'registration.id_course')
                ->groupBy('registration.id_student')
                ->get();

            // 學員(符合條件)
            $students_data = Student::where(function ($query) use ($search_data) {
                $query->Where('email', 'like', '%' . $search_data . '%')
                    ->orWhere('phone', 'like', '%' . $search_data . '%')
                    ->orWhere('student.name', 'like', '%' . $search_data . '%');
            })
                ->select('student.*')
                ->orderby('created_at', 'desc')
                ->get();

            // 學員資料加入資料來源    
            if (count($students_data) != 0) {
                foreach ($students_data as $key => $data) {
                    $sales_registration_datasource = SalesRegistration::where('sales_registration.id_student', '=', $data['id'])
                        ->select('sales_registration.datasource')
                        ->orderBy('sales_registration.created_at', 'asc')
                        ->first();

                    $datasource = $sales_registration_datasource;

                    $students_data[$key] = [
                        'id'                => $data['id'],
                        'name'              => $data['name'],
                        'phone'             => $data['phone'],
                        'email'             => $data['email'],
                        'datasource'        => $datasource,
                    ];
                }
                // 進行比較 -> 找出三個陣列都有的學員
                $arr = array_column(
                    array_merge($array_search_deal, json_decode($students_data, true)),
                    'id'
                );
                foreach ($sales_registration_data as $value_sales_registration) {
                    $check_array_search = array_search($value_sales_registration['id_student'], $arr);
                    if ($check_array_search !== false) {
                        // 找到重複的
                        $key = array_search(
                            $value_sales_registration['id_student'],
                            // 9100,
                            $arr,
                            true
                        );

                        array_push($array_student, array(
                            'id'                => $students_data[$key]['id'],
                            'name'              => $students_data[$key]['name'],
                            'phone'             => $students_data[$key]['phone'],
                            'email'             => $students_data[$key]['email'],
                            'datasource'             => $students_data[$key]['datasource']
                        ));
                    }
                }

                foreach ($registration_data as $value_registration) {
                    $check_array_search = array_search($value_registration['id_student'], $arr);
                    if ($check_array_search !== false) {

                        // 檢查array_student有沒有重複值
                        $arr_student = array_column(
                            $array_student,
                            'id'
                        );
                        $check_array_search2 = array_search($value_registration['id_student'], $arr_student);
                        // 沒有重複值才新增
                        if ($check_array_search2 === false) {
                            $key = array_search(
                                $value_registration['id_student'],
                                $arr,
                                true
                            );

                            array_push($array_student, array(
                                'id'                => $students_data[$key]['id'],
                                'name'              => $students_data[$key]['name'],
                                'phone'             => $students_data[$key]['phone'],
                                'email'             => $students_data[$key]['email'],
                                'datasource'             => $students_data[$key]['datasource']
                            ));
                        }
                    }
                }
            }
            $students = $array_student;
        } else {
            $students = Student::Where('email', 'like', '%' . $search_data . '%')
                ->orWhere('phone', 'like', '%' . $search_data . '%')
                ->orWhere('student.name', 'like', '%' . $search_data . '%')
                ->select('student.*')
                ->orderby('created_at', 'desc')
                ->get();

            // 改寫學員搜尋 -> 學員和資料來源分開搜尋(因為學員不一定都會報名銷講) Rocky (2020/07/07)
            if (count($students) != 0) {
                foreach ($students as $key => $data) {
                    $sales_registration_data = SalesRegistration::where('sales_registration.id_student', '=', $data['id'])
                        ->select('sales_registration.datasource')
                        ->orderBy('sales_registration.created_at', 'asc')
                        ->first();

                    $datasource = $sales_registration_data;

                    $students[$key] = [
                        'id'                => $data['id'],
                        'name'              => $data['name'],
                        'phone'             => $data['phone'],
                        'email'             => $data['email'],
                        'datasource'        => $datasource,
                    ];
                }
            }
        }

        return $students;

        // return view('frontend.student', compact('students'));

        // $pagesize = 15;
        // $search_data = $request->get('search_data');

        // if (!empty($search_data)) {
        //     $students = Student::Where('email', 'like', '%' . $search_data . '%')
        //         ->orWhere('phone', 'like', '%' . $search_data . '%')
        //         ->paginate($pagesize);
        // } else {
        //     $students = Student::paginate($pagesize);
        // }


        // // $returnHTML = view('frontend.student')->with('students', $students)->renderSections()['content'];
        // $returnHTML = view('frontend.student')->with('students', $students)->render();
        // return $returnHTML;
    }
}
