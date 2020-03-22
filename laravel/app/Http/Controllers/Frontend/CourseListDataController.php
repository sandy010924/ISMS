<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Uer;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Register;

class CourseListDataController extends Controller
{
    //view
    public function show(Request $request)
    {
        $course = array();
        $events = array();
        $start = '';
        $end = '';
        $start_array = array();
        $start_array = array();

         //課程資訊
        $id = $request->get('id');
        $course = Course::join('users', 'users.id', '=', 'course.id_teacher')
                        ->select('course.*', 'users.name as teacher')
                        ->Where('course.id', $id)
                        ->first();
                         
        //場次資訊
        $events_all = EventsCourse::Where('id_course', $id)
                                  ->get();
        
        $date = '';
        $id_group='';

        foreach( $events_all as $key => $data ){

            
            //日期
            $date = date('Y-m-d', strtotime($data['course_start_at']));
            //星期
            $weekarray = array("日","一","二","三","四","五","六");
            $week = $weekarray[date('w', strtotime($data['course_start_at']))];
            
            $date = $date . '（' . $week . '）';

            $apply_table = array();

            //判斷銷講or正課
            if( $course->type == 1 ){
                //銷講

                /* 報名數 */
                $count_apply = count(SalesRegistration::where('id_events', $data['id'])
                                                    ->where('id_status', '<>', 2)
                                                    ->get());

                /* 取消數 */
                $count_cancel = count(SalesRegistration::where('id_events', $data['id'])
                                                    ->where('id_status', 5)
                                                    ->get());

                /* 報到數 */
                $count_check = count(SalesRegistration::where('id_events', $data['id'])
                                                    ->where('id_status', 4)
                                                    ->get());

                /* 報到率 */
                $rate_check = 0;

                if( ($count_apply-$count_cancel) > 0 || $count_check > 0 ){
                    $rate_check = @(round($count_check/($count_apply-$count_cancel), 2))*100;
                }
                
                
                /* 成交數 */
                $deal = 0;
                $rate_deal = 0;

                $deal = count(Registration::Where('source_events', $data['id'] )
                                        ->Where('status_payment', 7)
                                        ->get()); 

                if( $deal > 0 && $count_check > 0 ){
                    $rate_deal = @(round($deal / $count_check ,2))*100;
                }

            }else{
                //正課    

                /* 報名數 */             
                $count_apply = count(Register::where('id_events', $data['id'])
                                            ->where('id_status', '<>', 2)
                                            ->get());

                /* 取消數 */
                $count_cancel = count(Register::where('id_events', $data['id'])
                                                    ->where('id_status', 5)
                                                    ->get());

                /* 報到數 */
                $count_check = count(Register::where('id_events', $data['id'])
                                                    ->where('id_status', 4)
                                                    ->get());

                /* 報到率 */
                $rate_check = 0;
                
                if( ($count_apply-$count_cancel) > 0 || $count_check > 0 ){
                    $rate_check = @(round($count_check/($count_apply-$count_cancel), 2))*100;
                }
                
                /* 成交數 */
                $deal = 0;
                $rate_deal = 0;

                $deal = count(Registration::Where('source_events', $data['id'] )
                                        ->Where('status_payment', 7)
                                        ->get());    

                if( $deal > 0 && $count_check > 0 ){
                    $rate_deal = @(round($deal / $count_check ,2))*100;
                }
            }

            $events[$key] = array(
                'id' => $data['id'],
                'date' => $date,
                'event' => $data['name'],
                'count_apply' => $count_apply,
                'count_cancel' => $count_cancel,
                'count_check' => $count_check,
                'rate_check' => $rate_check . '%',
                'deal' => $deal,
                'rate_deal' => $rate_deal . '%',
            );

        }

        $events_all = EventsCourse::Where('id_course', $id)
                                  ->get();
        //開始時間
        $start_array = EventsCourse::select('course_start_at as date')
                        ->Where('id_course', $id)
                        ->orderBy('course_start_at','asc')
                        ->first();
                        // ->get('date')
                        // ->unique('id');

        //結束時間
        $end_array = EventsCourse::select('course_end_at as date')
                        ->Where('id_course', $id)
                        ->orderBy('course_end_at','desc')
                        ->first();
                        // ->get('date')
                        // ->unique('id');
    
        if( $start_array!="" && $end_array!="" ){
            $start = date('Y-m-d', strtotime($start_array->date));
            $end = date('Y-m-d', strtotime($end_array->date));
        }

        return view('frontend.course_list_data', compact('course', 'events', 'start', 'end'));    
    }








    // //view
    // public function show(Request $request)
    // {
    //      //課程資訊
    //     $id = $request->get('id');
    //     $course = Course::join('users', 'users.id', '=', 'course.id_teacher')
    //                     ->select('course.*', 'users.name as teacher')
    //                     ->Where('course.id', $id)
    //                     ->first();
                         
    //     //場次資訊
    //     $events_all = EventsCourse::Where('id_course', $id)
    //                               ->get();
        
    //     $events = array();
    //     $id_group='';

    //     foreach( $events_all as $key => $data ){
    //         if ($id_group == $data['id_group']){ 
    //             continue;
    //         }

    //         $course_group = EventsCourse::Where('id_group', $data['id_group'])
    //                                     ->Where('id_course', $id)
    //                                     ->get();

    //         $numItems = count($course_group);
    //         $i = 0;

    //         $events_group = '';

    //         foreach( $course_group as $key_group => $data_group ){
    //             //日期
    //             $date = date('Y-m-d', strtotime($data_group['course_start_at']));
    //             //星期
    //             $weekarray = array("日","一","二","三","四","五","六");
    //             $week = $weekarray[date('w', strtotime($data_group['course_start_at']))];
                
    //             if( ++$i === $numItems){
    //                 $events_group .= $date . '（' . $week . '）';
    //             }else {
    //                 $events_group .= $date . '（' . $week . '）' . '、';
    //             }

    //             $apply_table = array();

    //             //判斷銷講or正課
    //             if( $course->type == 1 ){
    //                 //銷講

    //                 /* 報名數 */
    //                 $count_apply = count(SalesRegistration::where('id_events', $data_group['id'])
    //                                                  ->where('id_status', '<>', 2)
    //                                                  ->get());

    //                 /* 取消數 */
    //                 $count_cancel = count(SalesRegistration::where('id_events', $data_group['id'])
    //                                                  ->where('id_status', 5)
    //                                                  ->get());

    //                 /* 報到數 */
    //                 $count_check = count(SalesRegistration::where('id_events', $data_group['id'])
    //                                                  ->where('id_status', 4)
    //                                                  ->get());

    //                 /* 報到率 */
    //                 $rate_check = 0;

    //                 if( ($count_apply-$count_cancel) > 0 || $count_check > 0 ){
    //                     $rate_check = @(round($count_check/($count_apply-$count_cancel), 2))*100;
    //                 }
                    
                    
    //                 /* 成交數 */
    //                 $deal = 0;
    //                 //判斷是否有下階
    //                 $next_course = Course::join('events_course', 'events_course.id_course', '=', 'course.id')
    //                                     ->select('events_course.id as id_events', 'course.id_type as id_type','events_course.course_start_at as course_start_at')
    //                                     ->Where('course.id_type', $course->id)
    //                                     ->groupby('id_course')
    //                                     ->get();
                                        
    //                 $fill_all = array();

    //                 foreach( $next_course as $key_next => $data_next){
    //                     if( $data_next['id_type'] != null ){
    //                         //填單名單
    //                         $fill_all[$key_next] = Registration::join('events_course', 'events_course.id', '=', 'registration.id_events')
    //                                             ->select('registration.*')
    //                                             ->Where('registration.id_events', $data_next['id_events'])
    //                                             ->Where('registration.created_at', 'like', '%'. date('Y-m-d', strtotime($data_next['course_start_at'])). '%' )
    //                                             ->Where('registration.status_payment', 7)
    //                                             ->get();
    //                     }  
    //                 }
    //                 $deal = count($fill_all); 


    //             }else{
    //                 //正課    

    //                 /* 報名數 */             
    //                 $count_apply = count(Registration::join('events_course', 'events_course.id', '=', 'registration.id_events')
    //                                                  ->where('events_course.id_group', $data_group['id_group'])
    //                                                  ->where('registration.id_events', $data_group['id'])
    //                                                  ->where('registration.id_status', '<>', 2)
    //                                                  ->get());

    //                 /* 取消數 */
    //                 $count_cancel = count(Registration::join('events_course', 'events_course.id', '=', 'registration.id_events')
    //                                                  ->where('events_course.id_group', $data_group['id_group'])
    //                                                  ->where('registration.id_events', $data_group['id'])
    //                                                  ->where('registration.id_status', 5)
    //                                                  ->get());

    //                 /* 報到數 */
    //                 $count_check = count(Registration::join('events_course', 'events_course.id', '=', 'registration.id_events')
    //                                                  ->where('events_course.id_group', $data_group['id_group'])
    //                                                  ->where('registration.id_events', $data_group['id'])
    //                                                  ->where('registration.id_status', 4)
    //                                                  ->get());

    //                 /* 報到率 */
    //                 $rate_check = 0;
                    
    //                 if( ($count_apply-$count_cancel) > 0 || $count_check > 0 ){
    //                     $rate_check = @(round($count_check/($count_apply-$count_cancel), 2))*100;
    //                 }
                    
    //                 /* 成交數 */
    //                 $deal = 0;
    //                 //判斷是否有下階
    //                 $next_course = Course::join('events_course', 'events_course.id_course', '=', 'course.id')
    //                                     ->select('course.id as id_course', 'events_course.course_start_at as course_start_at')
    //                                     ->Where('course.id_type', $course->id_course)
    //                                     ->get();
                                        
    //                 foreach( $next_course as $key_next => $data_next){
    //                     //填單名單
    //                     $fill_all[$key_next] = Registration::join('events_course', 'events_course.id', '=', 'registration.id_events')
    //                                         ->select('registration.*')
    //                                         ->Where('registration.id_course', $data_next['id_course'])
    //                                         ->Where('registration.created_at', 'like', '%'. date('Y-m-d', strtotime($data_next['course_start_at'])). '%' )
    //                                         ->Where('registration.status_payment', 7)
    //                                         ->get();
    //                 }          
    //                 $deal = count($fill_all);    

    //             }
    //         }
    //         //群組ID
    //         $id_group = $data['id_group'];

    //         $events[$key] = array(
    //             'date' => $events_group,
    //             'event' => $data['name'],
    //             'count_apply' => $count_apply,
    //             'count_cancel' => $count_cancel,
    //             'count_check' => $count_check,
    //             'rate_check' => $rate_check . '%',
    //             'deal' => $deal,
    //             // 'rate_deal' => $rate_deal,
    //         );

    //     }

    //     return view('frontend.course_list_data', compact('course', 'events'));    
    // }
}
