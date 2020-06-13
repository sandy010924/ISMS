<?php

namespace App\Http\Controllers\Frontend;

use DB;
use App\Http\Controllers\Controller;
use App\Model\Student;
use App\Model\Course;
use App\Model\StudentGroup;
use App\Model\Registration;
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

        if ($type != "3") {
            $datas = Course::select('course.id', 'course.name', 'course.type')
                ->where(function ($query) use ($type) {
                    if ($type == "1") {
                        $query->where('type', '=', $type);
                    } elseif ($type == "2") {
                        $query->where('type', '=', $type)
                            ->orWhere('type', '=', '3');
                    }
                })
                ->orderby('course.created_at', 'desc')
                ->get();
        } else {
            //活動資料
        }


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
                    $array_search_deal = array_merge($array_search_deal, json_decode($array_search1, true));
                }
            } elseif ($i == 1) {
                if (!empty($this->search($array_search[$i]))) {
                    $array_search2 = $this->search($array_search[$i]);
                    $array_search_deal = array_merge($array_search_deal, json_decode($array_search2, true));
                }
            } elseif ($i == 2) {
                if (!empty($this->search($array_search[$i]))) {
                    $array_search3 = $this->search($array_search[$i]);
                    $array_search_deal = array_merge($array_search_deal, json_decode($array_search3, true));
                }
            }
        }

        // 找到相同資料
        foreach ($array_search_deal as $current_key => $current_array) {
            $search_key = array_search($current_array, $array_search_deal);
            if ($current_key != $search_key) {
                array_push($array_search_successful, $array_search_deal[$search_key]);
            }
        }
        if (count($array_search_successful) == 0) {
            $array_search_successful = $array_search_deal;
        }

        return $array_search_successful;
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
        $edate = $date[1];
        //  如果開始日期 = 結束日期 -> 結束日期+1
        if ($sdate == $edate) {
            $edate = date_create($date[1]);
            date_add($edate, date_interval_create_from_date_string("1 days"));
            $edate =  date_format($edate, "Y/m/d");
        }

        if ($type_course == "1") {
            // 銷講
            if ($type_condition == "information") {
                // 名單資料
                if ($opt1 == "datasource_old") {
                    $opt1 = "datasource";
                    // 原始來源
                    $datas = Student::join(
                        DB::raw("(SELECT * FROM sales_registration ORDER BY created_at asc LIMIT 9999) as b"),
                        function ($join) {
                            $join->on("student.id", "=", "b.id_student");
                        }
                    )
                        ->select('student.*', 'b.datasource', 'b.submissiondate')
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('b.id_course', $id_course);
                        })
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
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('b.created_at', [$sdate, $edate]);
                        })
                        ->groupby('student.id')
                        ->distinct()->get();
                } elseif ($opt1 == "datasource_new") {
                    $opt1 = "datasource";
                    // 最新來源
                    $datas = Student::join(
                        DB::raw("(SELECT * FROM sales_registration ORDER BY created_at desc LIMIT 9999) as b"),
                        function ($join) {
                            $join->on("student.id", "=", "b.id_student");
                        }
                    )
                        ->select('student.*', 'b.datasource', 'b.submissiondate')
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('b.id_course', $id_course);
                        })
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
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('b.created_at', [$sdate, $edate]);
                        })
                        ->groupby('student.id')
                        ->distinct()->get();
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
                            $query3->whereBetween('b.created_at', [$sdate, $edate]);
                        })
                        ->distinct()->get();
                }
            } elseif ($type_condition == "action") {
                // 名單動作
                if ($opt1 == "yes") {
                    $datas = Student::leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                        ->select('student.*', 'b.datasource', 'b.submissiondate', 'b.id_status')
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('b.id_course', $id_course);
                        })
                        ->where(function ($query) use ($opt2) {
                            $query->where('b.id_status', '=', $opt2);
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('b.created_at', [$sdate, $edate]);
                        })
                        ->distinct()->get();
                } else {
                    $datas = Student::leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                        ->select('student.*', 'b.datasource', 'b.submissiondate', 'b.id_status')
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereNotIn('b.id_course', $id_course);
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('b.created_at', [$sdate, $edate]);
                        })
                        ->distinct()->get();
                }
            } elseif ($type_condition == "tag") {
                // 標籤
                if ($opt1 == "yes") {
                    // 已分配
                    $datas = Student::leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                        ->leftjoin('course as c', 'b.id_course', '=', 'c.id')
                        ->leftjoin('mark as d', 'd.id_student', '=', 'student.id', 'd.course_id', '=', 'c.id')
                        ->select('student.*', 'b.datasource', 'c.name as name_events')
                        ->where('c.type', '1')
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('d.course_id', $id_course);
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
                            $query3->whereBetween('b.created_at', [$sdate, $edate]);
                        })
                        ->groupby('student.id')
                        ->get();
                } else {
                    // 未分配
                    $datas = Student::leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                        ->leftjoin('course as c', 'b.id_course', '=', 'c.id')
                        ->select('student.*', 'b.datasource', 'c.name as name_events')
                        ->where('c.type', '1')
                        ->whereNotExists(function ($query) {
                            $query->from('mark')
                                ->whereRaw('id_student = student.id');
                        })
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('b.id_course', $id_course);
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('b.created_at', [$sdate, $edate]);
                        })
                        ->groupby('student.id')
                        ->get();
                }
            }
        } elseif ($type_course == "2") {
            // 正課
            if ($type_condition == "information") {
                // 名單資料
                $datas = Registration::leftjoin('student as b', 'b.id', '=', 'registration.id_student')
                    ->leftjoin('register as c', 'c.id_registration', '=', 'registration.id')
                    ->leftjoin('events_course as d', 'c.id_events', '=', 'd.id')
                    ->leftjoin('sales_registration as e', 'e.id_student', '=', 'b.id')
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
                        $query3->whereBetween('registration.created_at', [$sdate, $edate]);
                    })
                    ->groupby('registration.id')
                    ->distinct()->get();
            } elseif ($type_condition == "action") {
                // 名單動作
                if ($opt1 == "yes") {
                    $datas = Registration::leftjoin('student as b', 'b.id', '=', 'registration.id_student')
                        ->leftjoin('register as c', 'c.id_registration', '=', 'registration.id')
                        ->leftjoin('events_course as d', 'c.id_events', '=', 'd.id')
                        ->leftjoin('sales_registration as e', 'e.id_student', '=', 'b.id')
                        ->select('b.*', 'd.name as name_events', 'e.datasource', 'e.submissiondate')
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('registration.id_course', $id_course);
                        })
                        ->where(function ($query) use ($opt2) {
                            $query->where('c.id_status', '=', $opt2)
                                ->orwhere('registration.status_payment', '=', $opt2);
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('registration.created_at', [$sdate, $edate]);
                        })
                        ->groupby('registration.id')
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
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('registration.created_at', [$sdate, $edate]);
                        })
                        ->groupby('registration.id')
                        ->distinct()->get();
                }
            } elseif ($type_condition == "tag") {
                // 標籤
                if ($opt1 == "yes") {
                    // 已分配
                    $datas = Student::leftjoin('registration as b', 'student.id', '=', 'b.id_student')
                        ->leftjoin('course as c', 'b.id_course', '=', 'c.id')
                        ->leftjoin('mark as d', 'd.id_student', '=', 'student.id', 'd.course_id', '=', 'c.id')
                        ->leftjoin('sales_registration as e', 'e.id_student', '=', 'b.id_student')
                        ->select('student.*', 'e.datasource', 'c.name as name_events', 'e.submissiondate')
                        ->where('c.type', '<>', '1')
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('d.course_id', $id_course);
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
                            $query3->whereBetween('b.created_at', [$sdate, $edate]);
                        })
                        ->groupby('student.id')
                        ->get();
                } else {
                    // 未分配
                    $datas = Student::leftjoin('registration as b', 'student.id', '=', 'b.id_student')
                        ->leftjoin('course as c', 'b.id_course', '=', 'c.id')
                        ->leftjoin('sales_registration as e', 'e.id_student', '=', 'b.id_student')
                        ->select('student.*', 'e.datasource', 'c.name as name_events', 'e.submissiondate')
                        ->where('c.type', '<>', '1')
                        ->whereNotExists(function ($query) {
                            $query->from('mark')
                                ->whereRaw('id_student = student.id');
                        })
                        ->where(function ($query2) use ($id_course) {
                            $query2->whereIn('b.id_course', $id_course);
                        })
                        ->where(function ($query3) use ($sdate, $edate) {
                            $query3->whereBetween('b.created_at', [$sdate, $edate]);
                        })
                        ->groupby('student.id')
                        ->get();
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
