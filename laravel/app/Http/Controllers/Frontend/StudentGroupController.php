<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Student;
use App\Model\Blacklist;
use App\Model\Course;
use App\Model\SalesRegistration;
use Symfony\Component\HttpFoundation\Request;

class StudentGroupController extends Controller
{
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

    // 搜尋符合條件的學員資料 Rock(2020/03/16)
    public function searchstudents(Request $request)
    {
        // request data
        $type_course = $request->get('type_course');
        $id_course = $request->get('id_course');
        $date = $request->get('date');
        $type_condition = $request->get('type_condition');
        $opt1 = $request->get('opt1');
        $opt2 = $request->get('opt2');
        $value = $request->get('value');

        $data_id_course = '';

        // if (count($id_course) != 0) {
        //     foreach ($id_course as $value) {
        //         $data_id_course .=  $value.',';
        //     }
        //     $data_id_course = substr($data_id_course, 0, -1);
        //     $data_id_course = json_decode($data_id_course);
        // }


        // $t = [1,2];

        if ($type_course == "1") {
            if ($type_condition == "information") {
                // 名單資料
                $datas = Student::leftjoin('sales_registration as b', 'student.id', '=', 'b.id_student')
                                ->select('student.*')
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
                                            $query->where($opt1, 'like', '%'.$value.'%');
                                            break;
                                        case "notlike":
                                            $query->where($opt1, 'not like', '%'.$value.'%');
                                            break;
                                    }
                                })
                                ->distinct()->get();
            }
            // 銷講
        } elseif ($type_course == "2") {
            // 正課
        }

        return $datas;
    }

    // 顯示資料
    // public function show()
    // {
    //     $pagesize = 15;
       
    //     $blacklists =  Blacklist::leftJoin('student', 'Blacklist.id_student', '=', 'student.id')
    //                     ->select('Blacklist.id as blacklist_id', 'Blacklist.reason', 'student.*')
    //                     ->paginate($pagesize);
    //     // dd($blacklists);
    //     return view('frontend.student_blacklist', compact('blacklists'));
    // }

    // 搜尋
    // public function search(Request $request)
    // {
    //     $pagesize = 15;
    //     $search_data = $request->get('search_data');

    //     if (!empty($search_data)) {
    //         $blacklists = Blacklist::leftJoin('student', 'Blacklist.id_student', '=', 'student.id')
    //                         ->select('Blacklist.id as blacklist_id', 'Blacklist.reason', 'student.*')
    //                         ->Where('email', 'like', '%' .$search_data. '%')
    //                         ->orWhere('phone', 'like', '%' .$search_data. '%')
    //                         ->paginate($pagesize);
    //     } else {
    //         $blacklists =  Blacklist::leftJoin('student', 'Blacklist.id_student', '=', 'student.id')
    //                     ->select('Blacklist.id as blacklist_id', 'Blacklist.reason', 'student.*')
    //                     ->paginate($pagesize);
    //     }
        

    //     // $returnHTML = view('frontend.student_blacklist')->with('blacklists', $blacklists)->renderSections()['content'];
    //     $returnHTML = view('frontend.student_blacklist')->with('blacklists', $blacklists)->render();
    //     return $returnHTML;
    // }
}
