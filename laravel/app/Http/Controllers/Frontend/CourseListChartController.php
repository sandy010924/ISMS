<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Uer;
use App\Model\SalesRegistration;
use App\Model\Registration;

class CourseListChartController extends Controller
{
    
    //view
    public function show(Request $request)
    {
         //課程資訊
        $id = $request->get('id');
                         
        //場次資訊
        $events = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                              ->select('course.name as course', 'course.type as type', 'events_course.*')
                              ->Where('events_course.id', $id)
                              ->first();
        
        $events_data = array();
        $date = '';

        //日期
        $date = date('Y-m-d', strtotime($events->course_start_at));
        //星期
        $weekarray = array("日","一","二","三","四","五","六");
        $week = $weekarray[date('w', strtotime($events->course_start_at))];
        
        $date = $date . '（' . $week . '）';


        //判斷銷講or正課
        if( $events->type == 1 ){
            //銷講

            /* 報名數 */
            $count_apply = count(SalesRegistration::where('id_events', $events->id)
                                                ->where('id_status', '<>', 2)
                                                ->get());

            /* 取消數 */
            $count_cancel = count(SalesRegistration::where('id_events', $events->id)
                                                ->where('id_status', 5)
                                                ->get());

            /* 報到數 */
            $count_check = count(SalesRegistration::where('id_events', $events->id)
                                                ->where('id_status', 4)
                                                ->get());

            /* 報到率 */
            $rate_check = 0;

            if( ($count_apply-$count_cancel) > 0 || $count_check > 0 ){
                $rate_check = @(round($count_check/($count_apply-$count_cancel), 2))*100;
            }
            
            
            

        }elseif( $events->type == 2 || $events->type == 3){
            //正課    

            /* 報名數 */             
            $count_apply = count(Register::where('id_events', $events->id)
                                        ->where('id_status', '<>', 2)
                                        ->get());

            /* 取消數 */
            $count_cancel = count(Register::where('id_events', $events->id)
                                                ->where('id_status', 5)
                                                ->get());

            /* 報到數 */
            $count_check = count(Register::where('id_events', $events->id)
                                                ->where('id_status', 4)
                                                ->get());

            /* 報到率 */
            $rate_check = 0;
            
            if( ($count_apply-$count_cancel) > 0 || $count_check > 0 ){
                $rate_check = @(round($count_check/($count_apply-$count_cancel), 2))*100;
            }
            
            // /* 成交數 */
            // $settle = 0;
            // $rate_settle = 0;

            // $settle = count(Registration::Where('source_events', $events->id )
            //                         ->Where('status_payment', 7)
            //                         ->get());    

            // if( $settle > 0 && $count_check > 0 ){
            //     $rate_settle = @(round($settle / $count_check ,2))*100;
            // }

            // /* 付訂數 */
            // $deposit = 0;
            // $deposit = count(Registration::Where('source_events', $events->id )
            //                         ->Where('status_payment', 8)
            //                         ->get());   


            // /* 留單數 */
            // $order = 0;
            // $order = count(Registration::Where('source_events', $events->id )
            //                         ->Where('status_payment', 6)
            //                         ->get());   
        

        }
        
        /* 成交數 */
        $settle = 0;
        $rate_settle = 0;

        $settle = count(Registration::Where('source_events', $events->id )
                                ->Where('status_payment', 7)
                                ->get()); 

        if( $settle > 0 && $count_check > 0 ){
            $rate_settle = @(round($settle / $count_check ,2))*100;
        }

        
        /* 付訂數 */
        $deposit = 0;
        $deposit = count(Registration::Where('source_events', $events->id )
                                ->Where('status_payment', 8)
                                ->get());   


        /* 留單數 */
        $order = 0;
        $order = count(Registration::Where('source_events', $events->id )
                                ->Where('status_payment', 6)
                                ->get());   
        

        $events_data = [
            'id' => $events->id,
            'date' => $date,
            'event' => $events->name,
            'count_apply' => $count_apply,
            'count_cancel' => $count_cancel,
            'count_check' => $count_check,
            'settle' => $settle,
            'deposit' => $deposit,
            'order' => $order,
            'rate_check' => $rate_check . '%',
            'rate_settle' => $rate_settle . '%',
        ];
        // dd( $events_data );

        return view('frontend.course_list_chart', compact('events', 'events_data'));    
    }
}
