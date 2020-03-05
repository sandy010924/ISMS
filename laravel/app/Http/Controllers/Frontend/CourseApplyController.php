<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SalesRegistration;
use App\Model\Course;
use App\Model\EventsCourse;

class CourseApplyController extends Controller
{
    public function show(Request $request)
    {
        //課程資訊
        $id = $request->get('id');
        $course = EventsCourse::rightjoin('course', 'course.id', '=', 'events_course.id_course')
                            ->join('teacher', 'teacher.id', '=', 'course.id_teacher')
                            ->select('course.name as course', 'teacher.name as teacher', 'events_course.*')
                            ->Where('events_course.id', $id)
                            ->first();

        $weekarray = array("日","一","二","三","四","五","六");
        $week = $weekarray[date('w', strtotime($course->course_start_at))];

        //未過場次 狀態預設改為已報名
        if(strtotime(date('Y-m-d', strtotime($course->course_start_at))) > strtotime(date("Y-m-d"))){
            $courseapplys = SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
            ->join('student', 'student.id', '=', 'sales_registration.id_student')
            ->Where('id_events','=', $id)
            ->where(function($q) { 
                $q->orWhere('id_status', 3)
                  ->orWhere('id_status', 4);
            })
            ->update(['id_status' => 1]);
        }

        //報名資訊
        $courseapplys = SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
            ->join('student', 'student.id', '=', 'sales_registration.id_student')
            ->select('student.name as name', 'student.phone as phone', 'student.email as email', 'student.profession as profession', 'sales_registration.*', 'isms_status.name as status_name')
            // ->select('student.*', 'sales_registration.submissiondate as apply_submissiondate', 'sales_registration.id as apply_id', 'sales_registration.id_status as apply_status_val', 'isms_status.name as status_name')
            ->Where('id_events', $id)
            ->Where('id_status', '<>', 2)
            // ->where(function($q) { 
            //     $q->where('id_status', 1)
            //         ->orWhere('id_status', 5);
            // })
            // ->orderByRaw('FIELD(id_status, "4", "3", "5")')
            // ->orderBy('created_at', 'DESC')
            ->get();
            
        //報名筆數
        $count_apply = count($courseapplys);

        //取消筆數
        $count_cancel = count(SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
                                              ->join('student', 'student.id', '=', 'sales_registration.id_student')
                                              ->Where('id_events', $id)
                                              ->Where('id_status', 5)
                                              ->get());

        return view('frontend.course_apply', compact('courseapplys', 'course', 'week', 'count_apply', 'count_cancel'));
    }
}
