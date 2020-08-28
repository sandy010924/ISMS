<?php

namespace App\Http\Controllers\Frontend;

use DB;
use App\Model\Course;
use App\Model\Student;
use App\Model\Activity;
use App\Model\StudentGroup;
use App\Model\Registration;
use App\Model\SalesRegistration;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class StudentGroupController extends Controller
{
    // 顯示列表資料 Rocky(2020/03/14)
    public function showgroup()
    {
        $datas = StudentGroup::leftjoin('student_groupdetail as b', 'b.id_group', '=', 'student_group.id')
            ->select('student_group.id', 'student_group.name', 'student_group.created_at')
            ->selectraw('COUNT(b.id) as COUNT')
            ->groupby('student_group.id')
            ->get();
        return view('frontend.student_group', compact('datas'));
    }
    // 顯示細分條件資料 Rocky(2020/03/14)
    public function showrequirement(Request $request)
    {
        $type = $request->get('type');

        $datas = Course::select('course.id', 'course.name', 'course.type')
            ->where(function ($query) use ($type) {
                if ($type == "1") {
                    // 銷講
                    $query->where('type', '=', $type);
                } elseif ($type == "2") {
                    // 正課
                    $query->where('type', '=', $type)
                        ->orWhere('type', '=', '3');
                } elseif ($type == "3") {
                    // 活動
                    $query->where('type', '=', '4');
                }
            })
            ->orderby('course.created_at', 'desc')
            ->get();

        // if ($type != "3") {

        // } else {
        //     //活動資料
        // }


        return $datas;
    }
    private static function compareDeepValue($val1, $val2)
    {
        return strcmp($val1['value'], $val2['value']);
    }
    // 搜尋符合條件的學員資料 Rock(2020/03/16)
    public function searchstudents(Request $request)
    {
        $array_search_successful = [];
        $array_search_deal = [];
        $array_search1 = [];
        $array_search2 = [];
        $array_search3 = [];
        // request data
        $array_search = $request->get('array_search');

        for ($i = 0; $i < count($array_search); $i++) {
            if ($i == 0) {
                if (!empty($this->search($array_search[$i]))) {
                    $array_search1 = $this->search($array_search[$i]);
                    // $array_search_deal = array_merge($array_search_deal, json_decode($array_search1, true));
                }
            } elseif ($i == 1) {
                if (!empty($this->search($array_search[$i]))) {
                    $array_search2 = $this->search($array_search[$i]);
                    // $array_search_deal = array_merge($array_search_deal, json_decode($array_search2, true));
                }
            } elseif ($i == 2) {
                if (!empty($this->search($array_search[$i]))) {
                    $array_search3 = $this->search($array_search[$i]);
                    // $array_search_deal = array_merge($array_search_deal, json_decode($array_search3, true));
                }
            }
        }

        // 找到相同資料

        // ($parentPathPieces && count($parentPathPieces) == 1)
        // if (!empty($array_search1) && !empty($array_search2)) {
        //     return '不是空的';
        // } else {
        //     return '空的';
        // }

        if (!empty($array_search1) && !empty($array_search2) && !empty($array_search3)) {
            $array_temp = [];
            $array_temp = array_uintersect(json_decode($array_search1, true), json_decode($array_search2, true), 'self::arrayvalue');
            $array_search_successful = array_uintersect($array_temp, json_decode($array_search3, true), 'self::arrayvalue');
        } elseif (!empty($array_search1) && !empty($array_search2)) {
            $array_search_successful = array_uintersect(json_decode($array_search1, true), json_decode($array_search2, true), 'self::arrayvalue');
        } elseif (!empty($array_search1) && !empty($array_search3)) {
            $array_search_successful = array_uintersect(json_decode($array_search1, true), json_decode($array_search3, true), 'self::arrayvalue');
        } elseif (!empty($array_search2) && !empty($array_search3)) {
            $array_search_successful = array_uintersect(json_decode($array_search2, true), json_decode($array_search3, true), 'self::arrayvalue');
        } elseif (!empty($array_search1)) {
            $array_search_successful = json_decode($array_search1, true);
        } elseif (!empty($array_search2)) {
            $array_search_successful = json_decode($array_search2, true);
        } elseif (!empty($array_search3)) {
            $array_search_successful = json_decode($array_search3, true);
        }

        return array_values($array_search_successful);

        // foreach ($array_search_deal as $current_key => $current_array) {
        //     $search_key = array_search($current_array, $array_search_deal);
        //     if ($current_key != $search_key) {
        //         array_push($array_search_successful, $array_search_deal[$search_key]);
        //     }
        // }
        // if (count($array_search_successful) == 0) {
        //     $array_search_successful = $array_search_deal;
        // }

        // return $array_search_successful;
    }

    public function arrayvalue($val1, $val2)
    {
        return strcmp($val1['id'], $val2['id']);
    }

    public function search($array_search)
    {
        $type_course = "";
        $id_course = "";
        $date = "";
        $type_condition = "";
        $opt1 = "";
        $opt2 = "";
        $value = "";
        $datas = "";

        $type_course = $array_search['type_course'];
        $id_course = $array_search['id_course'];

        $date = $array_search['date'];
        $type_condition = $array_search['type_condition'];
        $opt1 = $array_search['opt1'];
        $opt2 = $array_search['opt2'];
        $value = $array_search['value'];

        // 看日期有沒有'-'，變成陣列
        $date = str_replace(" ", "", explode("-", $date));
        $sdate = $date[0];
        // $edate = $date[1];
        $edate = date_create($date[1]);
        date_time_set($edate, 23, 59, 59);
        $edate =  date_format($edate, "Y/m/d H:i:s");
        //  如果開始日期 = 結束日期 -> 結束日期+1
        // if ($sdate == $edate) {
        //     $edate = date_create($date[1]);
        //     // date_add($edate, date_interval_create_from_date_string("1 days"));
        //     date_time_set($edate, 23, 59, 59);
        //     $edate =  date_format($edate, "Y/m/d H:i:s");
        // } else {
        //     $edate = date_create($date[1]);
        //     date_time_set($edate, 23, 59, 59);
        //     $edate =  date_format($edate, "Y/m/d H:i:s");
        // }
        // echo $sdate . "<br>" . $edate . "<br>";
        if ($type_course == "1") {
            // 銷講
            if ($type_condition == "information") {
                // 名單資料
                if ($opt1 == "datasource_old") {
                    // 原始來源
                    $opt1 = "sales_registration.datasource";
                    $array_student_id = array();
                    $array_student = array();
                    $array_search_deal = array();
                    $from = date('Y-m-d H:m:s', strtotime("-90 days"));
                    $to = date('Y-m-d H:m:s', strtotime("+90 days"));

                    // 更改寫法 Rocky (2020/07/24)

                    // 1. 先找符合條件的學員ID
                    $datas_student_id = Student::join('sales_registration as b', 'b.id_student', '=', 'student.id')
                        ->leftjoin('events_course as c', 'b.id_events', '=', 'c.id')
                        ->select('student.id')
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('b.id_course', $id_course);
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                        })
                        ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                        ->groupby('student.id')
                        ->orderby('b.submissiondate')
                        ->get();


                    foreach ($datas_student_id as $value_student_id) {
                        array_push($array_student_id, $value_student_id['id']);
                    }

                    // 2. 再找現在時間90天內的來源資料 -> 再找所有來源資料 -> 若90天內有資料以90天為主否則以其他資料為主

                    // 搜尋現在日期90天以內的銷講資料 Rocky(2020/07/24)
                    $datas_stuent_90 = SalesRegistration::leftjoin('student as b', 'sales_registration.id_student', '=', 'b.id')
                        ->select('b.*', 'sales_registration.datasource', 'sales_registration.submissiondate')
                        ->where(function ($query) use ($opt1, $opt2, $value) {
                            switch ($opt2) {
                                case "yes":
                                    $query->where($opt1, '=', $value);
                                    break;
                                case "no":
                                    $query->where($opt1, '<>', $value);
                                    break;
                                case "like":
                                    $query->where($opt1, 'like', '%' . $value . '%');
                                    break;
                                case "notlike":
                                    $query->where($opt1, 'not like', '%' . $value . '%');
                                    break;
                            }
                        })
                        ->whereIn('sales_registration.id_student', array_merge($array_student_id))
                        ->whereBetween('sales_registration.submissiondate', [$from, $to])
                        ->groupBy('b.id')
                        ->orderBy('sales_registration.submissiondate', 'ASC')
                        ->get();

                    // 如果90天內沒有銷講資料 -> 抓submissiondate最早的資料 Rocky(2020/07/24)

                    // 將90天內資料新增到array
                    foreach ($datas_stuent_90 as $key => $value_datas_stuent_90) {
                        array_push($array_student, array(
                            'id'                    => $datas_stuent_90[$key]['id'],
                            'name'                  => $datas_stuent_90[$key]['name'],
                            'phone'                 => $datas_stuent_90[$key]['phone'],
                            'email'                 => $datas_stuent_90[$key]['email'],
                            'datasource'            => $datas_stuent_90[$key]['datasource'],
                            'submissiondate'        => $datas_stuent_90[$key]['submissiondate'],
                        ));
                    }

                    // 找全部資料(沒有90天內限制)
                    $datas_stuent = SalesRegistration::leftjoin('student as b', 'sales_registration.id_student', '=', 'b.id')
                        ->select('b.*', 'sales_registration.datasource', 'sales_registration.submissiondate')
                        ->where(function ($query) use ($opt1, $opt2, $value) {
                            switch ($opt2) {
                                case "yes":
                                    $query->where($opt1, '=', $value);
                                    break;
                                case "no":
                                    $query->where($opt1, '<>', $value);
                                    break;
                                case "like":
                                    $query->where($opt1, 'like', '%' . $value . '%');
                                    break;
                                case "notlike":
                                    $query->where($opt1, 'not like', '%' . $value . '%');
                                    break;
                            }
                        })
                        ->where('b.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                        ->whereIn('sales_registration.id_student', array_merge($array_student_id))
                        ->groupBy('b.id')
                        ->orderBy('sales_registration.submissiondate', 'ASC')
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
                                'name'                  => $datas_stuent[$key]['name'],
                                'phone'                 => $datas_stuent[$key]['phone'],
                                'email'                 => $datas_stuent[$key]['email'],
                                'datasource'            => $datas_stuent[$key]['datasource'],
                                'submissiondate'        => $datas_stuent[$key]['submissiondate'],
                            ));
                        }
                    }
                    $datas = json_encode($array_student);

                    // $datas = Student::join(
                    //     DB::raw("(SELECT * FROM sales_registration ORDER BY submissiondate asc) as b"),
                    //     function ($join) {
                    //         $join->on("student.id", "=", "b.id_student");
                    //     }
                    // )
                    //     ->leftjoin('events_course as c', 'b.id_events', '=', 'c.id')
                    //     ->select('student.*', 'b.datasource', 'b.submissiondate')
                    //     ->where(function ($query2) use ($id_course) {
                    //         $query2->whereIn('b.id_course', $id_course);
                    //     })
                    //     ->where(function ($query) use ($opt1, $opt2, $value) {
                    //         switch ($opt2) {
                    //             case "yes":
                    //                 $query->where($opt1, '=', $value);
                    //                 break;
                    //             case "no":
                    //                 $query->where($opt1, '<>', $value);
                    //                 break;
                    //             case "like":
                    //                 $query->where($opt1, 'like', '%' . $value . '%');
                    //                 break;
                    //             case "notlike":
                    //                 $query->where($opt1, 'not like', '%' . $value . '%');
                    //                 break;
                    //         }
                    //     })
                    //     ->where(function ($query3) use ($sdate, $edate) {
                    //         // $query3->whereBetween('b.created_at', [$sdate, $edate]);
                    //         $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                    //     })
                    //     ->groupby('student.id')
                    //     ->distinct()->get();
                } elseif ($opt1 == "datasource_new") {
                    $opt1 = "sales_registration.datasource";
                    // 最新來源
                    $array_student_id = array();

                    // 更改寫法 Rocky (2020/08/04)

                    // 1. 先找符合條件的學員ID
                    $datas_student_id = Student::join('sales_registration as b', 'b.id_student', '=', 'student.id')
                        ->leftjoin('events_course as c', 'b.id_events', '=', 'c.id')
                        ->select('student.id')
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('b.id_course', $id_course);
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                        })
                        ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                        ->groupby('student.id')
                        ->orderby('b.submissiondate')
                        ->get();

                    foreach ($datas_student_id as $value_student_id) {
                        array_push($array_student_id, $value_student_id['id']);
                    }

                    // 2. 再找最新來源

                    // 搜尋最新資料 Rocky(2020/07/24)
                    $datas = SalesRegistration::leftjoin('student as b', 'sales_registration.id_student', '=', 'b.id')
                        ->select('b.*', 'sales_registration.datasource', 'sales_registration.submissiondate')
                        ->where(function ($query) use ($opt1, $opt2, $value) {
                            switch ($opt2) {
                                case "yes":
                                    $query->where($opt1, '=', $value);
                                    break;
                                case "no":
                                    $query->where($opt1, '<>', $value);
                                    break;
                                case "like":
                                    $query->where($opt1, 'like', '%' . $value . '%');
                                    break;
                                case "notlike":
                                    $query->where($opt1, 'not like', '%' . $value . '%');
                                    break;
                            }
                        })
                        ->whereIn('sales_registration.id_student', array_merge($array_student_id))
                        // ->whereBetween('sales_registration.submissiondate', [$from, $to])
                        ->groupBy('b.id')
                        ->orderBy('sales_registration.submissiondate', 'DESC')
                        ->get();

                    // $datas = Student::join(
                    //     DB::raw("(SELECT * FROM sales_registration ORDER BY submissiondate desc) as b"),
                    //     function ($join) {
                    //         $join->on("student.id", "=", "b.id_student");
                    //     }
                    // )
                    //     ->leftjoin('events_course as c', 'b.id_events', '=', 'c.id')
                    //     ->select('student.*', 'b.datasource', 'b.submissiondate')
                    //     ->where(function ($query2) use ($id_course) {
                    //         $query2->whereIn('b.id_course', $id_course);
                    //     })
                    //     ->where(function ($query) use ($opt1, $opt2, $value) {
                    //         switch ($opt2) {
                    //             case "yes":
                    //                 $query->where($opt1, '=', $value);
                    //                 break;
                    //             case "no":
                    //                 $query->where($opt1, '<>', $value);
                    //                 break;
                    //             case "like":
                    //                 $query->where($opt1, 'like', '%' . $value . '%');
                    //                 break;
                    //             case "notlike":
                    //                 $query->where($opt1, 'not like', '%' . $value . '%');
                    //                 break;
                    //         }
                    //     })
                    //     ->where(function ($query3) use ($sdate, $edate) {
                    //         // $query3->whereBetween('b.created_at', [$sdate, $edate]);
                    //         $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                    //     })
                    //     ->groupby('student.id')
                    //     ->distinct()->get();
                } else {
                    $datas = Student::leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                        ->leftjoin('events_course as c', 'b.id_events', '=', 'c.id')
                        ->select('student.*', 'b.datasource', 'b.submissiondate', 'c.name as name_events')
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('b.id_course', $id_course);
                        })
                        ->where(function ($query) use ($opt1, $opt2, $value) {
                            // 報名場次
                            if ($opt1 == 'id_events') {
                                $opt1 = 'c.name';
                            }
                            switch ($opt2) {
                                case "yes":
                                    $query->where($opt1, '=', $value);
                                    break;
                                case "no":
                                    $query->where($opt1, '<>', $value);
                                    break;
                                case "like":
                                    $query->where($opt1, 'like', '%' . $value . '%');
                                    break;
                                case "notlike":
                                    $query->where($opt1, 'not like', '%' . $value . '%');
                                    break;
                            }
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            // $query3->whereBetween('b.created_at', [$sdate, $edate]);
                            $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                        })
                        ->where('b.id_status', '<>', '5')
                        ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                        ->distinct()->get();
                }
            } elseif ($type_condition == "action") {
                // 名單動作
                if ($opt1 == "yes") {
                    if ($opt2 != '3' && $opt2 != '4' && $opt2 != '5') {
                        //留單 or 完款 or 付訂

                        //                         'SELECT c.name,a.id_course,a.id_events,b.id_course FROM `registration` a
                        // 	LEFT JOIN events_course b on a.source_events = b.id
                        //     LEFT JOIN student c on a.id_student = c.id
                        // WHERE b.id_course = '31' AND a.status_payment = '6' AND c.name = '張益裕'

                        $datas = Registration::leftjoin('events_course as b', 'registration.source_events', '=', 'b.id')
                            ->leftjoin('student as c', 'registration.id_student', '=', 'c.id')
                            ->leftjoin('sales_registration as d', 'd.id_student', '=', 'c.id')
                            ->select('c.*', 'd.datasource', 'd.submissiondate', 'd.id_status')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('b.id_course', $id_course);
                            })
                            ->where(function ($query) use ($opt2) {
                                $query->where('registration.status_payment', '=', $opt2);
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('b.course_start_at', [$sdate, $edate]);
                            })
                            ->where('c.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            // 抓最新來源
                            ->orderby('d.submissiondate', 'desc')
                            ->distinct()->get();
                    } else {
                        $datas = Student::leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                            ->leftjoin('events_course as c', 'b.id_events', '=', 'c.id')
                            ->select('student.*', 'b.datasource', 'b.submissiondate', 'b.id_status')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('b.id_course', $id_course);
                            })
                            ->where(function ($query) use ($opt2) {
                                $query->where('b.id_status', '=', $opt2);
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                            })
                            ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            // 抓最新來源
                            ->orderby('b.submissiondate', 'desc')
                            ->distinct()->get();
                    }
                } else {
                    if ($opt2 != '3' && $opt2 != '4' && $opt2 != '5') {
                        //留單 or 完款 or 付訂

                        //                         'SELECT c.name,a.id_course,a.id_events,b.id_course FROM `registration` a
                        // 	LEFT JOIN events_course b on a.source_events = b.id
                        //     LEFT JOIN student c on a.id_student = c.id
                        // WHERE b.id_course = '31' AND a.status_payment = '6' AND c.name = '張益裕'

                        $datas = Registration::leftjoin('events_course as b', 'registration.source_events', '=', 'b.id')
                            ->leftjoin('student as c', 'registration.id_student', '=', 'c.id')
                            ->leftjoin('sales_registration as d', 'd.id_student', '=', 'c.id')
                            ->select('c.*', 'd.datasource', 'd.submissiondate', 'd.id_status')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('b.id_course', $id_course);
                            })
                            ->where(function ($query) use ($opt2) {
                                $query->where('registration.status_payment', '<>', $opt2);
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('b.course_start_at', [$sdate, $edate]);
                            })
                            ->where('c.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            // 抓最新來源
                            ->orderby('d.submissiondate', 'desc')
                            ->distinct()->get();
                    } else {
                        $datas = Student::leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                            ->leftjoin('events_course as c', 'b.id_events', '=', 'c.id')
                            ->select('student.*', 'b.datasource', 'b.submissiondate', 'b.id_status')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('b.id_course', $id_course);
                            })
                            ->where(function ($query) use ($opt2) {
                                // $query->where('b.id_status', '<>', $opt2);
                                if ($opt2 == "4") {
                                    $query->where('b.id_status', '=', '1')
                                        ->orwhere('b.id_status', '=', '3');
                                } else {
                                    $query->where('b.id_status', '<>', $opt2);
                                }
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                            })
                            ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            // 抓最新來源
                            ->orderby('b.submissiondate', 'desc')
                            ->distinct()->get();
                    }
                    // $datas = Student::leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                    //     ->leftjoin('events_course as c', 'b.id_events', '=', 'c.id')
                    //     ->select('student.*', 'b.datasource', 'b.submissiondate', 'b.id_status')
                    //     ->where(function ($query2) use ($id_course) {
                    //         $query2->whereNotIn('b.id_course', $id_course);
                    //     })
                    //     ->where(function ($query3) use ($sdate, $edate) {
                    //         // $query3->whereBetween('b.created_at', [$sdate, $edate]);
                    //         $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                    //     })
                    //     ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                    //     ->distinct()->get();
                }
            } elseif ($type_condition == "tag") {
                // 標籤
                if ($opt1 == "yes") {
                    // 已分配
                    $datas = Student::leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                        // ->leftjoin('course as c', 'b.id_course', '=', 'c.id')
                        ->leftjoin('events_course as c', 'b.id_events', '=', 'c.id')
                        // ->leftjoin('mark as d', 'd.id_student', '=', 'student.id', 'd.course_id', '=', 'c.id')
                        ->leftjoin('mark as d', 'd.id_student', '=', 'student.id')
                        ->select('student.*', 'b.datasource', 'b.submissiondate')
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('b.id_course', $id_course);
                        })
                        ->where(function ($query) use ($opt1, $opt2, $value) {
                            // 標籤
                            $opt1 = 'd.name_mark';

                            switch ($opt2) {
                                case "yes":
                                    $query->where($opt1, '=', $value);
                                    break;
                                case "no":
                                    $query->where($opt1, '<>', $value);
                                    break;
                                case "like":
                                    $query->where($opt1, 'like', '%' . $value . '%');
                                    break;
                                case "notlike":
                                    $query->where($opt1, 'not like', '%' . $value . '%');
                                    break;
                            }
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            // $query3->whereBetween('b.created_at', [$sdate, $edate]);
                            $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                        })

                        ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                        ->groupby('student.id')
                        ->get();
                } else {
                    // 未分配 改寫 Rocky (2020/08/12)

                    // 宣告
                    $array_student_id = array();
                    $array_student = array();
                    $array_search_deal = array();
                    $array_search_student = array();


                    // 1. 先找不存在標籤資料表
                    $datas_notexists_mark = Student::leftjoin(
                        DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as b"),
                        function ($join) {
                            $join->on("b.id_student", "=", "student.id");
                        }
                    )
                        // leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                        // ->leftjoin('course as c', 'b.id_course', '=', 'c.id')
                        ->leftjoin('events_course as c', 'b.id_events', '=', 'c.id')
                        ->select('student.*', 'b.datasource', 'b.submissiondate')
                        ->whereNotExists(function ($query) {
                            $query->from('mark')
                                ->whereRaw('id_student = student.id');
                        })
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('b.id_course', $id_course);
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                        })
                        ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                        ->groupby('student.id')
                        ->get();


                    // 將不存在標籤資料表內資料新增到array
                    foreach ($datas_notexists_mark as $key => $value_notexists_mark) {
                        array_push($array_student, array(
                            'id'                    => $datas_notexists_mark[$key]['id'],
                            'name'                  => $datas_notexists_mark[$key]['name'],
                            'phone'                 => $datas_notexists_mark[$key]['phone'],
                            'email'                 => $datas_notexists_mark[$key]['email'],
                            'datasource'            => $datas_notexists_mark[$key]['datasource'],
                            'submissiondate'        => $datas_notexists_mark[$key]['submissiondate'],
                        ));
                    }


                    if ($value != "") {
                        // 2. 符合標籤條件的學員
                        $datas_exists_mark = Student::leftjoin(
                            DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as b"),
                            function ($join) {
                                $join->on("b.id_student", "=", "student.id");
                            }
                        )
                            // leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                            ->leftjoin('events_course as c', 'b.id_events', '=', 'c.id')
                            // ->leftjoin('mark as d', 'd.id_student', '=', 'student.id', 'd.course_id', '=', 'c.id')
                            ->leftjoin('mark as d', 'd.id_student', '=', 'student.id')
                            ->select('student.*', 'b.datasource', 'b.submissiondate', 'd.name_mark')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('b.id_course', $id_course);
                            })
                            // ->where('d.name_mark', '=', $value)
                            ->where(function ($query) use ($opt1, $opt2, $value) {
                                // 標籤
                                $opt1 = 'd.name_mark';

                                switch ($opt2) {
                                    case "yes":
                                        $query->where($opt1, '=', $value);
                                        break;
                                    case "no":
                                        $query->where($opt1, '<>', $value);
                                        break;
                                    case "like":
                                        $query->where($opt1, 'like', '%' . $value . '%');
                                        break;
                                    case "notlike":
                                        $query->where($opt1, 'not like', '%' . $value . '%');
                                        break;
                                }
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                            })
                            ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            ->groupby('student.id')
                            ->get();

                        // 3. 符合課程條件的全部學員
                        $datas_exists_student = Student::leftjoin(
                            DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as b"),
                            function ($join) {
                                $join->on("b.id_student", "=", "student.id");
                            }
                        )
                            // leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                            ->leftjoin('events_course as c', 'b.id_events', '=', 'c.id')
                            // ->leftjoin('mark as d', 'd.id_student', '=', 'student.id', 'd.course_id', '=', 'c.id')
                            // ->leftjoin('mark as d', 'd.id_student', '=', 'student.id')
                            ->select('student.*', 'b.datasource', 'b.submissiondate')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('b.id_course', $id_course);
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                            })
                            ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            ->groupby('student.id')
                            ->get();

                        $arr = array_column(
                            array_merge($array_search_student, json_decode($datas_exists_mark, true)),
                            'id'
                        );

                        // 比較全部學員和符合標籤學員
                        foreach ($datas_exists_student as $key => $value_exists_student) {
                            $check_array_search = array_search($value_exists_student['id'], $arr);
                            // 沒有重複值才新增
                            if ($check_array_search === false) {
                                array_push($array_student, array(
                                    'id'                    => $datas_exists_student[$key]['id'],
                                    'name'                  => $datas_exists_student[$key]['name'],
                                    'phone'                 => $datas_exists_student[$key]['phone'],
                                    'email'                 => $datas_exists_student[$key]['email'],
                                    'datasource'            => $datas_exists_student[$key]['datasource'],
                                    'submissiondate'        => $datas_exists_student[$key]['submissiondate'],
                                    // 'name_mark'             => $datas_exists_student[$key]['name_mark'],
                                ));
                            }
                        }
                    }
                    $datas = json_encode($array_student);
                }
            }
        } elseif ($type_course == "2") {
            // 正課
            if ($type_condition == "information") {
                // 名單資料

                // 已付金額
                if ($opt1 == 'amount_paid') {

                    /*
                    SELECT id,id_student,id_registration,sum(cash) as tt FROM `payment`
                    WHERE id_registration = '502'
                    GROUP BY id_registration
                    HAVING tt <> 30
                    */

                    $array_registration_id = array();

                    $datas_registration = Registration::leftjoin('student as b', 'b.id', '=', 'registration.id_student')
                        ->leftjoin('register as c', 'c.id_registration', '=', 'registration.id')
                        ->leftjoin('events_course as d', 'c.id_events', '=', 'd.id')
                        // ->leftjoin('sales_registration as e', 'e.id_student', '=', 'b.id')
                        ->leftjoin(
                            DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as e"),
                            function ($join) {
                                $join->on("e.id_student", "=", "b.id");
                            }
                        )
                        // ->select('b.*', 'd.name as name_events', 'e.datasource', 'e.submissiondate')
                        ->select('registration.id')
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('registration.id_course', $id_course);
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('d.course_start_at', [$sdate, $edate]);
                        })
                        ->where('b.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                        ->groupby('registration.id')
                        ->distinct()->get();

                    foreach ($datas_registration as $value_registration_id) {
                        array_push($array_registration_id, $value_registration_id['id']);
                    }

                    if ($opt2 == "yes") {
                        $datas = Registration::leftjoin('student as b', 'b.id', '=', 'registration.id_student')
                            ->leftjoin(
                                DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as e"),
                                function ($join) {
                                    $join->on("e.id_student", "=", "b.id");
                                }
                            )
                            ->leftjoin('payment as f', 'f.id_registration', '=', 'registration.id')
                            ->select('b.*', 'e.datasource', 'e.submissiondate', DB::raw('sum(f.cash) as sum_cash'))
                            ->whereIn('f.id_registration', array_merge($array_registration_id))
                            ->where('b.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            ->groupby('e.id', 'b.id', 'f.id_registration')
                            ->having("sum_cash", "=", $value)
                            ->orderby('e.submissiondate', 'desc')
                            ->distinct()->get();
                    } else {
                        $datas = Registration::leftjoin('student as b', 'b.id', '=', 'registration.id_student')
                            ->leftjoin(
                                DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as e"),
                                function ($join) {
                                    $join->on("e.id_student", "=", "b.id");
                                }
                            )
                            ->leftjoin('payment as f', 'f.id_registration', '=', 'registration.id')
                            ->select('b.*', 'e.datasource', 'e.submissiondate', DB::raw('sum(f.cash) as sum_cash'))
                            ->whereIn('f.id_registration', array_merge($array_registration_id))
                            ->where('b.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            ->groupby('e.id', 'b.id', 'f.id_registration')
                            ->having("sum_cash", "<>", $value)
                            ->orderby('e.submissiondate', 'desc')
                            ->distinct()->get();
                    }

                    return $datas;
                } else {
                    $datas = Registration::leftjoin('student as b', 'b.id', '=', 'registration.id_student')
                        ->leftjoin('register as c', 'c.id_registration', '=', 'registration.id')
                        ->leftjoin('events_course as d', 'c.id_events', '=', 'd.id')
                        // ->leftjoin('sales_registration as e', 'e.id_student', '=', 'b.id')
                        ->leftjoin(
                            DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as e"),
                            function ($join) {
                                $join->on("e.id_student", "=", "b.id");
                            }
                        )
                        ->select('b.*', 'd.name as name_events', 'e.datasource', 'e.submissiondate')
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('registration.id_course', $id_course);
                        })
                        ->where(function ($query) use ($opt1, $opt2, $value) {
                            // 報名場次
                            if ($opt1 == 'id_events') {
                                $opt1 = 'd.name';
                            }
                            switch ($opt2) {
                                case "yes":
                                    $query->where($opt1, '=', $value);
                                    break;
                                case "no":
                                    $query->where($opt1, '<>', $value);
                                    break;
                                case "like":
                                    $query->where($opt1, 'like', '%' . $value . '%');
                                    break;
                                case "notlike":
                                    $query->where($opt1, 'not like', '%' . $value . '%');
                                    break;
                            }
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('d.course_start_at', [$sdate, $edate]);
                        })
                        ->where('b.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                        ->groupby('registration.id')
                        ->distinct()->get();
                }
            } elseif ($type_condition == "action") {
                // 名單動作
                if ($opt1 == "yes") {
                    if ($opt2 != '3' && $opt2 != '4' && $opt2 != '5') {
                        //留單 or 完款 or 付訂
                        /*
                        SELECT c.id,c.name,d.datasource,d.submissiondate,d.id_status,a.status_payment,e.id_status FROM registration a
                            LEFT JOIN events_course b on a.source_events = b.id
                            LEFT JOIN student c ON a.id_student  = c.id
                            LEFT JOIN sales_registration d on d.id_student = c.id
                            LEFT JOIN register e on e.id_registration = a.id
                            WHERE b.id_course = '73'
                        ORDER BY d.submissiondate DESC
                        */

                        $datas = Registration::leftjoin('events_course as b', 'registration.source_events', '=', 'b.id')
                            ->leftjoin('student as c', 'registration.id_student', '=', 'c.id')
                            ->leftjoin('sales_registration as d', 'd.id_student', '=', 'c.id')
                            ->select('c.*', 'd.datasource', 'd.submissiondate', 'd.id_status')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('b.id_course', $id_course);
                            })
                            ->where(function ($query) use ($opt2) {
                                $query->where('registration.status_payment', '=', $opt2);
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('b.course_start_at', [$sdate, $edate]);
                            })
                            ->where('c.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            // 抓最新來源
                            ->orderby('d.submissiondate', 'desc')
                            ->distinct()->get();
                    } else {
                        $datas = Registration::leftjoin('student as b', 'b.id', '=', 'registration.id_student')
                            ->leftjoin('register as c', 'c.id_registration', '=', 'registration.id')
                            ->leftjoin('events_course as d', 'c.id_events', '=', 'd.id')
                            ->leftjoin('sales_registration as e', 'e.id_student', '=', 'b.id')
                            ->select('b.*', 'd.name as name_events', 'e.datasource', 'e.submissiondate')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('registration.id_course', $id_course);
                            })
                            ->where(function ($query) use ($opt2) {
                                $query->where('c.id_status', '=', $opt2);
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('d.course_start_at', [$sdate, $edate]);
                            })
                            ->where('b.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            // ->groupby('registration.id')
                            // 抓最新來源
                            ->orderby('e.submissiondate', 'desc')
                            // ->distinct()
                            ->get();
                    }

                    // $datas = Registration::leftjoin('student as b', 'b.id', '=', 'registration.id_student')
                    //     ->leftjoin('register as c', 'c.id_registration', '=', 'registration.id')
                    //     ->leftjoin('events_course as d', 'c.id_events', '=', 'd.id')
                    //     ->leftjoin('sales_registration as e', 'e.id_student', '=', 'b.id')
                    //     ->select('b.*', 'd.name as name_events', 'e.datasource', 'e.submissiondate')
                    //     ->where(function ($query2) use ($id_course) {
                    //         $query2->whereIn('registration.id_course', $id_course);
                    //     })
                    //     ->where(function ($query) use ($opt2) {
                    //         $query->where('c.id_status', '=', $opt2)
                    //             ->orwhere('registration.status_payment', '=', $opt2);
                    //     })
                    //     ->where(function ($query3) use ($sdate, $edate) {
                    //         $query3->whereBetween('d.course_start_at', [$sdate, $edate]);
                    //     })
                    //     ->groupby('registration.id')
                    //     ->distinct()->get();
                } else {
                    if ($opt2 != '3' && $opt2 != '4' && $opt2 != '5') {
                        //留單 or 完款 or 付訂
                        /*
                        SELECT c.id,c.name,d.datasource,d.submissiondate,d.id_status,a.status_payment,e.id_status FROM registration a
                            LEFT JOIN events_course b on a.source_events = b.id
                            LEFT JOIN student c ON a.id_student  = c.id
                            LEFT JOIN sales_registration d on d.id_student = c.id
                            LEFT JOIN register e on e.id_registration = a.id
                            WHERE b.id_course = '73'
                        ORDER BY d.submissiondate DESC
                        */

                        $datas = Registration::leftjoin('events_course as b', 'registration.source_events', '=', 'b.id')
                            ->leftjoin('student as c', 'registration.id_student', '=', 'c.id')
                            ->leftjoin('sales_registration as d', 'd.id_student', '=', 'c.id')
                            ->select('c.*', 'd.datasource', 'd.submissiondate', 'd.id_status')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('b.id_course', $id_course);
                            })
                            ->where(function ($query) use ($opt2) {
                                $query->where('registration.status_payment', '<>', $opt2);
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('b.course_start_at', [$sdate, $edate]);
                            })
                            ->where('c.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            // 抓最新來源
                            ->orderby('d.submissiondate', 'desc')
                            ->distinct()->get();
                    } else {
                        $datas = Registration::leftjoin('student as b', 'b.id', '=', 'registration.id_student')
                            ->leftjoin('register as c', 'c.id_registration', '=', 'registration.id')
                            ->leftjoin('events_course as d', 'c.id_events', '=', 'd.id')
                            ->leftjoin('sales_registration as e', 'e.id_student', '=', 'b.id')
                            ->select('b.*', 'd.name as name_events', 'e.datasource', 'e.submissiondate')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('registration.id_course', $id_course);
                            })
                            ->where(function ($query) use ($opt2) {
                                $query->where('c.id_status', '<>', $opt2);
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('d.course_start_at', [$sdate, $edate]);
                            })
                            ->where('b.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            // ->groupby('registration.id')
                            // 抓最新來源
                            ->orderby('e.submissiondate', 'desc')
                            // ->distinct()
                            ->get();
                    }
                    // $datas = Registration::leftjoin('student as b', 'b.id', '=', 'registration.id_student')
                    //     ->leftjoin('register as c', 'c.id_registration', '=', 'registration.id')
                    //     ->leftjoin('events_course as d', 'c.id_events', '=', 'd.id')
                    //     ->leftjoin('sales_registration as e', 'e.id_student', '=', 'b.id')
                    //     ->select('b.*', 'd.name as name_events', 'e.datasource', 'e.submissiondate')
                    //     ->where(function ($query2) use ($id_course) {
                    //         $query2->whereIn('registration.id_course', $id_course);
                    //     })
                    //     ->where(function ($query3) use ($sdate, $edate) {
                    //         $query3->whereBetween('d.course_start_at', [$sdate, $edate]);
                    //     })
                    //     ->where('b.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                    //     ->groupby('registration.id')
                    //     ->distinct()->get();
                }
            } elseif ($type_condition == "tag") {
                // 標籤
                if ($opt1 == "yes") {
                    // 已分配
                    $datas = Student::leftjoin('registration as b', 'student.id', '=', 'b.id_student')
                        // ->leftjoin('course as c', 'b.id_course', '=', 'c.id')
                        // ->leftjoin('events_course as c', 'b.id_events', '=', 'c.id')
                        ->leftjoin('events_course as c', 'b.id_group', '=', 'c.id_group')
                        // ->leftjoin(
                        //     DB::raw("(SELECT * FROM events_course  WHERE course_start_at BETWEEN '" . $sdate . "' AND '" . $edate . "' ORDER BY created_at desc) as c "),
                        //     function ($join) {
                        //         $join->on("b.id_group", "=", "c.id_group");
                        //     }
                        // )
                        ->leftjoin('mark as d', 'd.id_student', '=', 'student.id')
                        // ->leftjoin('sales_registration as e', 'e.id_student', '=', 'b.id_student')
                        ->leftjoin(
                            DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as e"),
                            function ($join) {
                                $join->on("e.id_student", "=", "b.id_student");
                            }
                        )
                        ->select('student.*', 'e.datasource', 'e.submissiondate')
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('b.id_course', $id_course);
                        })
                        ->where(function ($query) use ($opt1, $opt2, $value) {
                            // 標籤
                            $opt1 = 'd.name_mark';

                            switch ($opt2) {
                                case "yes":
                                    $query->where($opt1, '=', $value);
                                    break;
                                case "no":
                                    $query->where($opt1, '<>', $value);
                                    break;
                                case "like":
                                    $query->where($opt1, 'like', '%' . $value . '%');
                                    break;
                                case "notlike":
                                    $query->where($opt1, 'not like', '%' . $value . '%');
                                    break;
                            }
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            // $query3->whereBetween('b.created_at', [$sdate, $edate]);
                            $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                        })
                        ->where('b.status_payment', '7')
                        ->where('b.id_events', '<>', '-99')
                        ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                        ->groupby('student.id')
                        ->get();
                } else {
                    // 未分配 改寫 Rocky (2020/08/12)

                    // 宣告
                    $array_student_id = array();
                    $array_student = array();
                    $array_search_deal = array();
                    $array_search_student = array();


                    // 1. 先找不存在標籤資料表
                    $datas_notexists_mark = Student::leftjoin('registration as a', 'student.id', '=', 'a.id_student')
                        ->leftjoin(
                            DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as b"),
                            function ($join) {
                                $join->on("b.id_student", "=", "student.id");
                            }
                        )
                        ->leftjoin('events_course as c', 'a.id_events', '=', 'c.id')
                        ->select('student.*', 'b.datasource', 'b.submissiondate')
                        ->whereNotExists(function ($query) {
                            $query->from('mark')
                                ->whereRaw('id_student = student.id');
                        })
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('a.id_course', $id_course);
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                        })
                        ->where('a.status_payment', '7')
                        ->where('a.id_events', '<>', '-99')
                        ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                        ->groupby('student.id')
                        ->get();

                    // 將不存在標籤資料表內資料新增到array
                    foreach ($datas_notexists_mark as $key => $value_notexists_mark) {
                        array_push($array_student, array(
                            'id'                    => $datas_notexists_mark[$key]['id'],
                            'name'                  => $datas_notexists_mark[$key]['name'],
                            'phone'                 => $datas_notexists_mark[$key]['phone'],
                            'email'                 => $datas_notexists_mark[$key]['email'],
                            'datasource'            => $datas_notexists_mark[$key]['datasource'],
                            'submissiondate'        => $datas_notexists_mark[$key]['submissiondate'],
                        ));
                    }

                    if ($value != "") {
                        // 2. 符合標籤條件的學員
                        $datas_exists_mark = Student::leftjoin('registration as a', 'student.id', '=', 'a.id_student')
                            ->leftjoin(
                                DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as b"),
                                function ($join) {
                                    $join->on("b.id_student", "=", "a.id_student");
                                }
                            )
                            ->leftjoin('events_course as c', 'a.id_events', '=', 'c.id')
                            ->leftjoin('mark as d', 'd.id_student', '=', 'a.id_student')
                            ->select('student.*', 'b.datasource', 'b.submissiondate', 'd.name_mark')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('a.id_course', $id_course);
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                            })
                            // ->where('d.name_mark', '=', $value)
                            ->where(function ($query) use ($opt1, $opt2, $value) {
                                // 標籤
                                $opt1 = 'd.name_mark';

                                switch ($opt2) {
                                    case "yes":
                                        $query->where($opt1, '=', $value);
                                        break;
                                    case "no":
                                        $query->where($opt1, '<>', $value);
                                        break;
                                    case "like":
                                        $query->where($opt1, 'like', '%' . $value . '%');
                                        break;
                                    case "notlike":
                                        $query->where($opt1, 'not like', '%' . $value . '%');
                                        break;
                                }
                            })
                            ->where('a.status_payment', '7')
                            ->where('a.id_events', '<>', '-99')
                            ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            ->groupby('student.id')
                            ->get();

                        // 3. 符合課程條件的全部學員
                        $datas_exists_student = Student::leftjoin('registration as a', 'student.id', '=', 'a.id_student')
                            ->leftjoin(
                                DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as b"),
                                function ($join) {
                                    $join->on("b.id_student", "=", "a.id_student");
                                }
                            )
                            ->leftjoin('events_course as c', 'a.id_events', '=', 'c.id')
                            ->select('student.*', 'b.datasource', 'b.submissiondate')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('a.id_course', $id_course);
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                            })
                            ->where('a.status_payment', '7')
                            ->where('a.id_events', '<>', '-99')
                            ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            ->groupby('student.id')
                            ->get();

                        $arr = array_column(
                            array_merge($array_search_student, json_decode($datas_exists_mark, true)),
                            'id'
                        );

                        // 比較全部學員和符合標籤學員
                        foreach ($datas_exists_student as $key => $value_exists_student) {
                            $check_array_search = array_search($value_exists_student['id'], $arr);
                            // 沒有重複值才新增
                            if ($check_array_search === false) {
                                array_push($array_student, array(
                                    'id'                    => $datas_exists_student[$key]['id'],
                                    'name'                  => $datas_exists_student[$key]['name'],
                                    'phone'                 => $datas_exists_student[$key]['phone'],
                                    'email'                 => $datas_exists_student[$key]['email'],
                                    'datasource'            => $datas_exists_student[$key]['datasource'],
                                    'submissiondate'        => $datas_exists_student[$key]['submissiondate'],
                                ));
                            }
                        }
                    }

                    $datas = json_encode($array_student);
                }



                // $datas = Student::leftjoin('registration as b', 'student.id', '=', 'b.id_student')
                //     // ->leftjoin('course as c', 'b.id_course', '=', 'c.id')
                //     // ->leftjoin('events_course as c', 'b.id_events', '=', 'c.id')
                //     ->leftjoin(
                //         DB::raw("(SELECT * FROM events_course  WHERE course_start_at BETWEEN '" . $sdate . "' AND '" . $edate . "' ORDER BY created_at desc) as c "),
                //         function ($join) {
                //             $join->on("b.id_group", "=", "c.id_group");
                //         }
                //     )
                //     ->leftjoin('sales_registration as e', 'e.id_student', '=', 'b.id_student')
                //     ->select('student.*', 'e.datasource', 'e.submissiondate')
                //     ->whereNotExists(function ($query) {
                //         $query->from('mark')
                //             ->whereRaw('id_student = student.id');
                //     })
                //     ->where(function ($query2) use ($id_course) {
                //         $query2->whereIn('b.id_course', $id_course);
                //     })
                //     ->where(function ($query3) use ($sdate, $edate) {
                //         // $query3->whereBetween('b.created_at', [$sdate, $edate]);
                //         $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                //     })
                //     ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                //     ->groupby('student.id')
                //     ->get();
            }
        } elseif ($type_course == "3") {
            if ($type_condition == "information") {
                $datas = Activity::leftjoin('student as b', 'b.id', '=', 'activity.id_student')
                    ->leftjoin('events_course as d', 'activity.id_events', '=', 'd.id')
                    ->leftjoin(
                        DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as e"),
                        function ($join) {
                            $join->on("e.id_student", "=", "b.id");
                        }
                    )
                    ->select('b.*', 'd.name as name_events', 'e.datasource', 'e.submissiondate')
                    ->where(function ($query2) use ($id_course) {
                        $query2->whereIn('activity.id_course', $id_course);
                    })
                    ->where(function ($query) use ($opt1, $opt2, $value) {
                        // 報名場次
                        if ($opt1 == 'id_events') {
                            $opt1 = 'd.name';
                        }

                        if ($opt1 == 'course_content') {
                            $opt1 = 'activity.course_content';
                        }

                        switch ($opt2) {
                            case "yes":
                                $query->where($opt1, '=', $value);
                                break;
                            case "no":
                                $query->where($opt1, '<>', $value);
                                break;
                            case "like":
                                $query->where($opt1, 'like', '%' . $value . '%');
                                break;
                            case "notlike":
                                $query->where($opt1, 'not like', '%' . $value . '%');
                                break;
                        }
                    })
                    ->where(function ($query3) use ($sdate, $edate) {
                        $query3->whereBetween('d.course_start_at', [$sdate, $edate]);
                    })
                    ->where('b.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                    ->groupby('activity.id')
                    ->distinct()->get();
            } elseif ($type_condition == "action") {
                if ($opt1 == "yes") {
                    //留單 or 完款 or 付訂
                    if ($opt2 != '3' && $opt2 != '4' && $opt2 != '5' && $opt2 != '23') {
                        //                         'SELECT c.name,a.id_course,a.id_events,b.id_course FROM `registration` a
                        // 	LEFT JOIN events_course b on a.source_events = b.id
                        //     LEFT JOIN student c on a.id_student = c.id
                        // WHERE b.id_course = '31' AND a.status_payment = '6' AND c.name = '張益裕'

                        $datas = Registration::leftjoin('events_course as b', 'registration.source_events', '=', 'b.id')
                            ->leftjoin('student as c', 'registration.id_student', '=', 'c.id')
                            ->leftjoin('activity as a', 'c.id', '=', 'a.id_student')
                            ->leftjoin(
                                DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as d"),
                                function ($join) {
                                    $join->on("d.id_student", "=", "a.id_student");
                                }
                            )
                            // ->leftjoin('sales_registration as d', 'd.id_student', '=', 'c.id')
                            ->select('c.*', 'd.datasource', 'd.submissiondate', 'd.id_status')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('b.id_course', $id_course);
                            })
                            ->where(function ($query) use ($opt2) {
                                $query->where('registration.status_payment', '=', $opt2);
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('b.course_start_at', [$sdate, $edate]);
                            })
                            ->where('c.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            // 抓最新來源
                            ->orderby('d.submissiondate', 'desc')
                            ->distinct()->get();
                    } else {
                        $datas = Student::leftjoin('activity as a', 'student.id', '=', 'a.id_student')
                            ->leftjoin(
                                DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as b"),
                                function ($join) {
                                    $join->on("b.id_student", "=", "a.id_student");
                                }
                            )
                            ->leftjoin('events_course as c', 'a.id_events', '=', 'c.id')
                            ->select('student.*', 'b.datasource', 'b.submissiondate', 'b.id_status')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('a.id_course', $id_course);
                            })
                            ->where(function ($query) use ($opt2) {
                                $query->where('a.id_status', '=', $opt2);
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                            })
                            ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            ->orderby('b.submissiondate', 'desc')  // 抓最新來源
                            ->distinct()->get();
                    }
                    // return json_encode(array('opt1_yes'));
                } else {
                    if ($opt2 != '3' && $opt2 != '4' && $opt2 != '5' && $opt2 != '23') {
                        //                         'SELECT c.name,a.id_course,a.id_events,b.id_course FROM `registration` a
                        // 	LEFT JOIN events_course b on a.source_events = b.id
                        //     LEFT JOIN student c on a.id_student = c.id
                        // WHERE b.id_course = '31' AND a.status_payment = '6' AND c.name = '張益裕'

                        $datas = Registration::leftjoin('events_course as b', 'registration.source_events', '=', 'b.id')
                            ->leftjoin('student as c', 'registration.id_student', '=', 'c.id')
                            ->leftjoin('activity as a', 'c.id', '=', 'a.id_student')
                            ->leftjoin(
                                DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as d"),
                                function ($join) {
                                    $join->on("d.id_student", "=", "a.id_student");
                                }
                            )
                            // ->leftjoin('sales_registration as d', 'd.id_student', '=', 'c.id')
                            ->select('c.*', 'd.datasource', 'd.submissiondate', 'd.id_status')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('b.id_course', $id_course);
                            })
                            ->where(function ($query) use ($opt2) {
                                $query->where('registration.status_payment', '<>', $opt2);
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('b.course_start_at', [$sdate, $edate]);
                            })
                            ->where('c.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            // 抓最新來源
                            ->orderby('d.submissiondate', 'desc')
                            ->distinct()->get();
                    } else {
                        $datas = Student::leftjoin('activity as a', 'student.id', '=', 'a.id_student')
                            ->leftjoin(
                                DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as b"),
                                function ($join) {
                                    $join->on("b.id_student", "=", "a.id_student");
                                }
                            )
                            ->leftjoin('events_course as c', 'a.id_events', '=', 'c.id')
                            ->select('student.*', 'b.datasource', 'b.submissiondate', 'b.id_status')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('a.id_course', $id_course);
                            })
                            ->where(function ($query) use ($opt2) {
                                $query->where('a.id_status', '<>', $opt2);
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                            })
                            ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            ->orderby('b.submissiondate', 'desc')  // 抓最新來源
                            ->distinct()->get();
                    }
                }
            } elseif ($type_condition == "tag") {
                // return json_encode(array('tag'));

                // 標籤
                if ($opt1 == "yes") {
                    // 已分配
                    $datas = Student::leftjoin('activity as a', 'student.id', '=', 'a.id_student')
                        // leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                        ->leftjoin(
                            DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as b"),
                            function ($join) {
                                $join->on("b.id_student", "=", "a.id_student");
                            }
                        )
                        ->leftjoin('events_course as c', 'a.id_events', '=', 'c.id')
                        // ->leftjoin('mark as d', 'd.id_student', '=', 'student.id', 'd.course_id', '=', 'c.id')
                        ->leftjoin('mark as d', 'd.id_student', '=', 'student.id')
                        ->select('student.*', 'b.datasource', 'b.submissiondate')
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('a.id_course', $id_course);
                        })
                        ->where(function ($query) use ($opt1, $opt2, $value) {
                            // 標籤
                            $opt1 = 'd.name_mark';

                            switch ($opt2) {
                                case "yes":
                                    $query->where($opt1, '=', $value);
                                    break;
                                case "no":
                                    $query->where($opt1, '<>', $value);
                                    break;
                                case "like":
                                    $query->where($opt1, 'like', '%' . $value . '%');
                                    break;
                                case "notlike":
                                    $query->where($opt1, 'not like', '%' . $value . '%');
                                    break;
                            }
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                        })

                        ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                        ->groupby('student.id')
                        ->get();
                } else {
                    // 未分配 改寫 Rocky (2020/08/12)

                    // 宣告
                    $array_student_id = array();
                    $array_student = array();
                    $array_search_deal = array();
                    $array_search_student = array();


                    // 1. 先找不存在標籤資料表
                    $datas_notexists_mark = Student::leftjoin('activity as a', 'student.id', '=', 'a.id_student')
                        // leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                        ->leftjoin(
                            DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as b"),
                            function ($join) {
                                $join->on("b.id_student", "=", "a.id_student");
                            }
                        )
                        // ->leftjoin('course as c', 'b.id_course', '=', 'c.id')
                        ->leftjoin('events_course as c', 'a.id_events', '=', 'c.id')
                        ->select('student.*', 'b.datasource', 'b.submissiondate')
                        ->whereNotExists(function ($query) {
                            $query->from('mark')
                                ->whereRaw('id_student = student.id');
                        })
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('a.id_course', $id_course);
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                        })
                        ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                        ->groupby('student.id')
                        ->get();


                    // 將不存在標籤資料表內資料新增到array
                    foreach ($datas_notexists_mark as $key => $value_notexists_mark) {
                        array_push($array_student, array(
                            'id'                    => $datas_notexists_mark[$key]['id'],
                            'name'                  => $datas_notexists_mark[$key]['name'],
                            'phone'                 => $datas_notexists_mark[$key]['phone'],
                            'email'                 => $datas_notexists_mark[$key]['email'],
                            'datasource'            => $datas_notexists_mark[$key]['datasource'],
                            'submissiondate'        => $datas_notexists_mark[$key]['submissiondate'],
                        ));
                    }

                    if ($value != "") {
                        // 2. 符合標籤條件的學員
                        $datas_exists_mark = Student::leftjoin('activity as a', 'student.id', '=', 'a.id_student')
                            // leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                            ->leftjoin(
                                DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as b"),
                                function ($join) {
                                    $join->on("b.id_student", "=", "a.id_student");
                                }
                            )
                            ->leftjoin('events_course as c', 'a.id_events', '=', 'c.id')
                            // ->leftjoin('mark as d', 'd.id_student', '=', 'student.id', 'd.course_id', '=', 'c.id')
                            ->leftjoin('mark as d', 'd.id_student', '=', 'student.id')
                            ->select('student.*', 'b.datasource', 'b.submissiondate', 'd.name_mark')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('a.id_course', $id_course);
                            })
                            // ->where('d.name_mark', '=', $value)
                            ->where(function ($query) use ($opt1, $opt2, $value) {
                                // 標籤
                                $opt1 = 'd.name_mark';

                                switch ($opt2) {
                                    case "yes":
                                        $query->where($opt1, '=', $value);
                                        break;
                                    case "no":
                                        $query->where($opt1, '<>', $value);
                                        break;
                                    case "like":
                                        $query->where($opt1, 'like', '%' . $value . '%');
                                        break;
                                    case "notlike":
                                        $query->where($opt1, 'not like', '%' . $value . '%');
                                        break;
                                }
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                            })
                            ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            ->groupby('student.id')
                            ->get();

                        // 3. 符合課程條件的全部學員
                        $datas_exists_student = Student::leftjoin('activity as a', 'student.id', '=', 'a.id_student')
                            // leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                            ->leftjoin(
                                DB::raw(" (SELECT * FROM sales_registration ORDER BY submissiondate desc LIMIT 9999) as b"),
                                function ($join) {
                                    $join->on("b.id_student", "=", "a.id_student");
                                }
                            )
                            ->leftjoin('events_course as c', 'a.id_events', '=', 'c.id')
                            // ->leftjoin('mark as d', 'd.id_student', '=', 'student.id', 'd.course_id', '=', 'c.id')
                            ->leftjoin('mark as d', 'd.id_student', '=', 'student.id')
                            ->select('student.*', 'b.datasource', 'b.submissiondate', 'd.name_mark')
                            ->where(function ($query2) use ($id_course) {
                                $query2->whereIn('a.id_course', $id_course);
                            })
                            ->where(function ($query3) use ($sdate, $edate) {
                                $query3->whereBetween('c.course_start_at', [$sdate, $edate]);
                            })
                            ->where('student.check_blacklist', '0') // 不是黑名單 Rocky (2020/08/05)
                            ->groupby('student.id')
                            ->get();


                        $arr = array_column(
                            array_merge($array_search_student, json_decode($datas_exists_mark, true)),
                            'id'
                        );

                        // 比較全部學員和符合標籤學員
                        foreach ($datas_exists_student as $key => $value_exists_student) {
                            $check_array_search = array_search($value_exists_student['id'], $arr);
                            // 沒有重複值才新增
                            if ($check_array_search === false) {
                                array_push($array_student, array(
                                    'id'                    => $datas_exists_student[$key]['id'],
                                    'name'                  => $datas_exists_student[$key]['name'],
                                    'phone'                 => $datas_exists_student[$key]['phone'],
                                    'email'                 => $datas_exists_student[$key]['email'],
                                    'datasource'            => $datas_exists_student[$key]['datasource'],
                                    'submissiondate'        => $datas_exists_student[$key]['submissiondate'],
                                    'name_mark'             => $datas_exists_student[$key]['name_mark'],
                                ));
                            }
                        }
                    }
                    $datas = json_encode($array_student);
                }
            }
        }

        return $datas;
    }
    /* 修改資料 */
    // 顯示資料
    public function showeditdata(Request $request)
    {
        $id = $request->get('id');
        $datas = StudentGroup::leftjoin('student_groupdetail as b', 'student_group.id', '=', 'b.id_group')
            ->leftjoin('student as c', 'b.id_student', '=', 'c.id')
            ->leftjoin('sales_registration as d', 'd.id_student', '=', 'c.id')
            ->select('student_group.condition', 'c.*', 'd.datasource', 'd.submissiondate', 'student_group.name as name_group')
            ->where('student_group.id', $id)
            ->groupby('c.id')
            ->get();
        return view('frontend.student_group_edit', compact('datas', 'id'));
    }
}
