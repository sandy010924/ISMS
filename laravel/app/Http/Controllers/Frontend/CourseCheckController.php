<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\Register;
use App\Model\Refund;
use App\Model\Activity;
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
                              ->select('events_course.*', 'course.name as course', 'course.type as type')
                              ->Where('events_course.id','=', $id)
                              ->first();

        $weekarray = array("日","一","二","三","四","五","六");
        $week = $weekarray[date('w', strtotime($course->course_start_at))];

        //判斷是否有下一階
        $nextLevel = count(Course::where('id_type', $course->id_course)
                            ->get());

        //判斷是銷講or正課
        if( $course->type == 1 ){
            //銷講
            
            //已過或當天場次 狀態預設改為未到
            if(strtotime(date('Y-m-d', strtotime($course->course_start_at))) <= strtotime(date("Y-m-d"))){
                SalesRegistration::Where('id_events', $id)
                                ->Where('id_status', 1)
                                ->update(['id_status' => 3]);
            }else{
                //未過
                SalesRegistration::Where('id_events', $id)
                                ->where(function($q) { 
                                    $q->orWhere('id_status', 3);
                                    // ->orWhere('id_status', 4);
                                })
                                ->update(['id_status' => 1]);
            }

            // DB::statement(DB::raw('set @row:=0'));

            //報名資訊
            $list = SalesRegistration::join('isms_status', 'isms_status.id', '=', 'sales_registration.id_status')
                ->join('student', 'student.id', '=', 'sales_registration.id_student')
                ->select('sales_registration.id as check_id' ,
                        'student.*', 
                        'sales_registration.id_status as check_status_val', 
                        'sales_registration.memo as memo', 
                        'sales_registration.memo2 as memo2',
                        'isms_status.name as check_status_name')
                // ->selectRaw('@row:=@row+1 as row')
                ->Where('id_events','=', $id)
                ->Where('id_status','<>', 2)
                // ->where(function($q) { 
                //     $q->where('id_status', 3)
                //         ->orWhere('id_status', 4)
                //         ->orWhere('id_status', 5);
                // })
                // ->orderByRaw('FIELD(id_status, "4", "3", "5")')
                ->orderBy('sales_registration.created_at')
                ->get();


            $coursechecks = array();
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
                    'memo' => $data['memo'],
                    'memo2' => $data['memo2']
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
        }elseif( $course->type == 2 || $course->type == 3){
            //正課
            
            //已過或當天場次 狀態預設改為未到
            if(strtotime(date('Y-m-d', strtotime($course->course_start_at))) <= strtotime(date("Y-m-d"))){
                Register::Where('id_events', $id)
                        ->Where('id_status', 1)
                        ->update(['id_status' => 3]);
            }else{
                //未過
                Register::Where('id_events', $id)
                                ->where(function($q) { 
                                    $q->orWhere('id_status', 3);
                                    // ->orWhere('id_status', 4);
                                })
                                ->update(['id_status' => 1]);
            }

            // DB::statement(DB::raw('set @row:=0'));

            //報名資訊
            $list = Register::leftjoin('isms_status', 'isms_status.id', '=', 'register.id_status')
                            ->leftjoin('student', 'student.id', '=', 'register.id_student')
                            ->leftjoin('registration', 'registration.id', '=', 'register.id_registration')
                            ->select('student.*', 
                                    'register.id as check_id',
                                    'register.id_status as check_status_val',
                                    'register.memo as memo',
                                    'isms_status.name as check_status_name',
                                    'registration.id as id_registration')
                            ->Where('register.id_events','=', $id)
                            ->Where('register.id_status','<>', 2)
                            ->where(function($q) { 
                                $q->orWhere('registration.status_payment', 7)
                                  ->orWhere('registration.status_payment', 9);
                            })
                            ->orderBy('register.created_at')
                            ->get();

            $coursechecks = array();

            foreach ($list as $key => $data) {
                //檢查是否通過退費
                $check_refund = array();
                $check_refund = Refund::where('id_registration', $data['id_registration'])
                                      ->where('review', 1)
                                      ->first();
                if( !empty($check_refund) ){
                    continue;
                }

                $coursechecks[count($coursechecks)] = [
                    'row' => count($coursechecks)+1,
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
            
            if( count($coursechecks) != 0){
                usort($coursechecks, array($this, "statusSort"));
            }

            //報名筆數
            $count_apply = count($coursechecks);

            //報到筆數
            // $count_check = count(Register::Where('id_events','=', $id)
            //                             ->Where('id_status','=', 4)
            //                             ->get());
            $count_check = 0;
            foreach( $coursechecks as $data ){
                //檢查狀態為報到
                if( $data['check_status_val'] != 4){
                    continue;
                }else{
                    $count_check++;
                }
            }

            //取消筆數
            // $count_cancel = count(Register::Where('id_events','=', $id)
            //                                 ->Where('id_status','=', 5)
            //                                 ->get());
            $count_cancel = 0;
            foreach( $coursechecks as $data ){
                //檢查狀態為取消
                if( $data['check_status_val'] != 5){
                    continue;
                }else{
                    $count_cancel++;
                }
            }
        }else if( $course->type == 4 ){
            //活動
            
            //已過或當天場次 狀態預設改為未到
            if(strtotime(date('Y-m-d', strtotime($course->course_start_at))) <= strtotime(date("Y-m-d"))){
                Activity::Where('id_events', $id)
                                ->Where('id_status', 1)
                                ->update(['id_status' => 3]);
            }else{
                //未過
                Activity::Where('id_events', $id)
                                ->where(function($q) { 
                                    $q->orWhere('id_status', 3);
                                    // ->orWhere('id_status', 4);
                                })
                                ->update(['id_status' => 1]);
            }

            // DB::statement(DB::raw('set @row:=0'));

            //報名資訊
            $list = Activity::join('isms_status', 'isms_status.id', '=', 'activity.id_status')
                ->join('student', 'student.id', '=', 'activity.id_student')
                ->select('activity.id as check_id' ,
                        'student.*', 
                        'activity.id_status as check_status_val', 
                        'activity.memo as memo', 
                        'isms_status.name as check_status_name')
                // ->selectRaw('@row:=@row+1 as row')
                ->Where('id_events','=', $id)
                ->Where('id_status','<>', 2)
                // ->where(function($q) { 
                //     $q->where('id_status', 3)
                //         ->orWhere('id_status', 4)
                //         ->orWhere('id_status', 5);
                // })
                // ->orderByRaw('FIELD(id_status, "4", "3", "5")')
                ->orderBy('activity.created_at')
                ->get();


            $coursechecks = array();
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
                    'memo' => $data['memo'],
                    // 'memo2' => $data['memo2']
                ];
            }

            usort($coursechecks, array($this, "statusSort"));

            //報名筆數
            $count_apply = count($coursechecks);
            //報到筆數
            $count_check = count(Activity::Where('id_events','=', $id)
                ->Where('id_status','=', 4)
                ->get());
            //報到筆數
            $count_cancel = count(Activity::Where('id_events','=', $id)
                ->Where('id_status','=', 5)
                ->get());
        }

        return view('frontend.course_check', compact('coursechecks', 'course', 'week', 'count_apply', 'count_check', 'count_cancel', 'nextLevel'));
            
    }

    
    // 編輯資料填入 Sandy (2020/06/26)
    public function fill( Request $request )
    {
        $id = $request->input('id');
        $type = $request->input('type');

        if( $type == 1 ){
            //銷講
            $data = SalesRegistration::join('student','student.id','=','sales_registration.id_student')
                            // ->join('payment','id_registration','=','registration.id')
                            ->Where('sales_registration.id', $id)
                            ->first();    
        }else if( $type == 4 ){
            //活動
            $data = Activity::join('student','student.id','=','activity.id_student')
                            ->Where('activity.id', $id)
                            ->first();  
        }

        if( !empty($data) ){
            return $data;
        }else {
            return 'nodata';
        }
    }
}
