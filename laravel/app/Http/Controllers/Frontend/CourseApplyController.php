<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SalesRegistration;
use App\Model\Course;

class CourseApplyController extends Controller
{
    public function show(Request $request)
    {
        //課程資訊
        $id = $request->get('id');
        $course = Course::Where('id','=', $id)
            ->first();
        $weekarray = array("日","一","二","三","四","五","六");
        $week = $weekarray[date('w', strtotime($course->course_start_at))];

        //報名資訊
        $courseapplys = SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
            ->join('student', 'student.id', '=', 'sales_registration.id_student')
            ->select('sales_registration.id as apply_id' ,'student.*', 'sales_registration.id_status as apply_status_val', 'isms_status.name as apply_status_name')
            ->Where('id_course','=', $id)
            ->where(function($q) { 
                $q->where('id_status', 1)
                    ->orWhere('id_status', 5);
            })
            ->get();
            
        //報名比數
        $count = count($courseapplys);

        return view('frontend.course_apply', compact('courseapplys', 'course', 'week', 'count'));
    }
}
