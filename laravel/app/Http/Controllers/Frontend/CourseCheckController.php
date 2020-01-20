<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SalesRegistration;
use App\Model\Course;

class CourseCheckController extends Controller
{
    public function show(Request $request)
    {
        //課程資訊
        $id = $request->get('id');
        $course = Course::Where('id','=', $id)
            ->first();
        $weekarray = array("日","一","二","三","四","五","六");
        $week = $weekarray[date('w', strtotime($course->course_start_at))];

        SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
            ->join('student', 'student.id', '=', 'sales_registration.id_student')
            ->select('sales_registration.id as check_id' ,'student.*', 'sales_registration.id_status as check_status_val', 'isms_status.name as check_status_name')
            ->Where('id_course','=', $id)
            ->Where('id_status','=', 1)
            ->update(['id_status' => 3]);

        //報名資訊
        $coursechecks = SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
            ->join('student', 'student.id', '=', 'sales_registration.id_student')
            ->select('sales_registration.id as check_id' ,'student.*', 'sales_registration.id_status as check_status_val', 'isms_status.name as check_status_name')
            ->Where('id_course','=', $id)
            ->where(function($q) { 
                $q->where('id_status', 3)
                    ->orWhere('id_status', 4)
                    ->orWhere('id_status', 5);
            })
            ->get();
            
        //報名比數
        $count_apply = count($coursechecks);
        //報到比數
        $count_check = count(SalesRegistration::Where('id_course','=', $id)
            ->Where('id_status','=', 4)
            ->get());

        return view('frontend.course_check', compact('coursechecks', 'course', 'week', 'count_apply', 'count_check'));
    }
}
