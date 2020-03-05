<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SalesRegistration;
use App\Model\Course;
use App\Model\EventsCourse;
// use DB;

class CourseCheckController extends Controller
{
    //流水號排序
    private static function statusSort($a,$b) {
        if ($a["check_status_val"] == $b["check_status_val"]){
            return ($a['id'] > $b['id']) ? 1 : -1;
        }
        elseif ($a["check_status_val"] > $b["check_status_val"]) {
            if ($a["check_status_val"] == 4) return -1;
            if ($a["check_status_val"] == 5) return 1;
            
        }
        elseif ($a["check_status_val"] < $b["check_status_val"]) {
            if ($b["check_status_val"] == 4) return 1;
            if ($b["check_status_val"] == 5) return -1;
        }
        return 0;
    }

    //View Data
    public function show(Request $request)
    {
        //課程資訊
        $id = $request->get('id');
        $course = EventsCourse::rightjoin('course', 'course.id', '=', 'events_course.id_course')
                              ->select('events_course.*', 'course.name as course')
                              ->Where('events_course.id','=', $id)
                              ->first();
        $weekarray = array("日","一","二","三","四","五","六");
        $week = $weekarray[date('w', strtotime($course->course_start_at))];

        //已過場次 狀態預設改為未到
        // if(strtotime(date('Y-m-d', strtotime($course->course_start_at))) <= strtotime(date("Y-m-d"))){
            SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
                ->join('student', 'student.id', '=', 'sales_registration.id_student')
                ->select('sales_registration.id as check_id' ,'student.*', 'sales_registration.id_status as check_status_val', 'isms_status.name as check_status_name')
                ->Where('id_events', $id)
                ->Where('id_status', 1)
                ->update(['id_status' => 3]);
        // }

        // DB::statement(DB::raw('set @row:=0'));

        //報名資訊
        $list = SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
            ->join('student', 'student.id', '=', 'sales_registration.id_student')
            ->select('sales_registration.id as check_id' ,'student.*', 'sales_registration.id_status as check_status_val', 'sales_registration.memo as memo', 'isms_status.name as check_status_name')
            // ->selectRaw('@row:=@row+1 as row')
            ->Where('id_events','=', $id)
            ->Where('id_status','<>', 2)
            // ->where(function($q) { 
            //     $q->where('id_status', 3)
            //         ->orWhere('id_status', 4)
            //         ->orWhere('id_status', 5);
            // })
            // ->orderByRaw('FIELD(id_status, "4", "3", "5")')
            ->orderBy('created_at')
            ->get();


        foreach ($list as $key => $data) {
            $coursechecks[$key] = [
                'row' => $key+1,
                'id' => $data['check_id'],
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'check_id' => $data['check_id'],
                'check_status_val' => $data['check_status_val'],
                'check_status_name' => $data['check_status_name'],
                'memo' => $data['memo']
            ];
        }

        usort($coursechecks, array($this, "statusSort"));

        //報名筆數
        $count_apply = count($coursechecks);
        //報到筆數
        $count_check = count(SalesRegistration::Where('id_events','=', $id)
            ->Where('id_status','=', 4)
            ->get());
        //報到筆數
        $count_cancel = count(SalesRegistration::Where('id_events','=', $id)
            ->Where('id_status','=', 5)
            ->get());


        return view('frontend.course_check', compact('coursechecks', 'course', 'week', 'count_apply', 'count_check','count_cancel'));
    }
}
