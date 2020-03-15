<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Student;
use App\Model\Blacklist;
use App\Model\Course;
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
