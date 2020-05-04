<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Teacher;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Register;
use App\Model\Course;
use App\Model\EventsCourse;
use DB;

class ReportController extends Controller
{
    // 顯示列表資料 Sandy(2020/05/02)
    public function show()
    {
        $teacher = Teacher::select('id','name')->distinct()->get();
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
        foreach( $item as $key => $data ){

            $search = EventsCourse::leftjoin('course as b', 'b.id', '=', 'events_course.id_course')
                                // ->leftjoin('sales_registration as c', 'c.id_events', '=', 'events_course.id')
                                // ->leftjoin('registration as d', 'd.id_group', '=', 'events_course.id_group')
                                ->selectRaw("
                                    events_course.id as id,
                                    events_course.id_group as id_group,
                                    events_course.name as events,
                                    b.type as type,
                                    b.name as course,
                                    DATE_FORMAT(course_start_at,'%Y-%m-%d') as x")
                                ->orderby('course_start_at')
                                ->whereBetween('events_course.course_start_at', [$startDate, $endDate]);

            //老師
            if($data[0] != '0'){
                $search->where('b.id_teacher', $data[0]);
            }
            
            //類型
            if($data[1] != '0'){
               $search->where('b.type', $data[1]);
            }
            
            //地區
            if($data[4] != '0'){
               $search->where('events_course.name', 'like', '%' . $data[4] . '%');
            }
            
            //時段
            if($data[5] != '0'){
                if( $data[5] == "整天" ){
                    $otherTime = ['上午','下午','晚上'];
                    foreach( $otherTime as $data_time){
                        $search->where('events_course.name', 'not like', '%' . $data_time . '%');
                    }
                }else{
                    $search->where('events_course.name', 'like', '%' . $data[5] . '%');
                }
            }

            $search = $search -> get();
            $result[$key] = [];


            /* 計算名單數據 */
            if($nav == "list"){
                foreach( $search as $key_search => $data_search ){
                    $events = [];
                    if( $data_search['type'] == 1 ){
                        //銷講
                        $count = SalesRegistration::where('id_events', $data_search['id']);

                        //來源
                        if($data[2] != '0'){
                            $count->where('datasource', $data[2]);
                        }

                        //動作
                        if($data[3] != '0'){
                            $count->where('id_status', $data[3]);
                        }

                        // $events[$key_events]['y'] = count($count->get());
                        // $events['y'] = count($count->get());

                    }else if( $data_search['type'] == 2 || $data_search['type'] == 3 ){
                        //正課
                        $count = Register::where('id_events', $data_search['id_events']);

                        // //來源
                        // if($data[2] != '0'){
                        //     $count->where('datasource', $data[2]);
                        // }

                        //動作
                        if($data[3] != '0'){
                            $count->where('id_status', $data[3]);
                        }

                        //付款狀態(營業額)
                        if($data[6] != '0' && $nav == "pay"){
                            $count->where('status_payment', $data[6]);
                        }

                        // $events[$key_events]['y'] = count($count->get());
                    }

                    $out = 0;
                    foreach($result[$key] as $key_result => $data_result){
                        if( $data_search['x'] == $data_result['x'] ){
                            // $index = array_search($data_search['x'], $data_result);
                            $result[$key][$key_result]['y'] += count($count->get());
                            $result[$key][$key_result]['course'] .= "、" .$data_search['course'] . " " . $data_search['events'];
                            // $events['title'] .= "、".$data_search['course'];
                            $out++;
                            break;
                        }
                    }
                    if( $out == 0 ){
                        $events['y'] = count($count->get());
                        $events['x'] = $data_search['x'];
                        $events['course'] = $data_search['course'] . " " . $data_search['events'];
                        // $events['title'] = $data_search['course'];

                        array_push($result[$key], $events);
                    }
                    
                    //記錄每一條件的每一場次資訊
                    // $result[$key][$key_search] = $events;
                    // $result .= [$events];

                    //紀錄每場日期
                    if( !in_array( $data_search['x'], $labelDate) ){
                        array_push($labelDate, $data_search['x']);
                    }
                }
            }

            
            /* 計算報到率 */
            if($nav == "check"){
                //報名數
                foreach( $search as $key_search => $data_search ){
                    $events = [];
                    if( $data_search['type'] == 1 ){
                        //銷講
                        $apply = SalesRegistration::where('id_events', $data_search['id']);
                        $check = SalesRegistration::where('id_events', $data_search['id']);

                        //來源
                        if($data[2] != '0'){
                            $apply->where('datasource', $data[2]);
                            $check->where('datasource', $data[2]);
                        }
                    }else if( $data_search['type'] == 2 || $data_search['type'] == 3 ){
                        //正課
                        $apply = Register::where('id_events', $data_search['id']);
                        $check = Register::where('id_events', $data_search['id']);
                    }


                    $apply = $apply->where('id_status', '<>', 2)->get();
                    $check = $check->where('id_status', 4)->get();
                    
                    $out = 0;
                    foreach($result[$key] as $key_result => $data_result){
                        if( $data_search['x'] == $data_result['x'] ){
                            // $index = array_search($data_search['x'], $data_result);
                            if(count($check)!=0 && count($apply)!=0){
                                $result[$key][$key_result]['y'] += count($check) / count($apply);
                                $result[$key][$key_result]['y'] = round($result[$key][$key_result]['y'] / 2, 2);
                            }else if($result[$key][$key_result]['y'] != 0){
                                $result[$key][$key_result]['y'] /= 2;
                            }
                            $result[$key][$key_result]['course'] .= "、" .$data_search['course'] . " " . $data_search['events'];
                            // $events['title'] .= "、".$data_search['course'];
                            $out++;
                            break;
                        }
                    }
                    if( $out == 0 ){
                        if(count($check)!=0 && count($apply)!=0){
                            $events['y'] = round(count($check) / count($apply),2);
                        }else{
                            $events['y'] = 0;
                        }
                        $events['x'] = $data_search['x'];
                        $events['course'] = $data_search['course'] . " " . $data_search['events'];
                        // $events['title'] = $data_search['course'];

                        array_push($result[$key], $events);
                    }
                    
                    //記錄每一條件的每一場次資訊
                    // $result[$key][$key_search] = $events;
                    // $result .= [$events];

                    //紀錄每場日期
                    if( !in_array( $data_search['x'], $labelDate) ){
                        array_push($labelDate, $data_search['x']);
                    }
                }
            }


            /* 計算成交率 */
            if($nav == "deal"){
                //報名數
                foreach( $search as $key_search => $data_search ){
                    $events = [];
                    if( $data_search['type'] == 1 ){
                        //銷講
                        $check = SalesRegistration::where('id_events', $data_search['id']);
                        //來源
                        if($data[2] != '0'){
                            $check->where('datasource', $data[2]);
                        }
                    }else if( $data_search['type'] == 2 || $data_search['type'] == 3 ){
                        //正課
                        $check = Register::where('id_events', $data_search['id']);
                    }

                    $check = $check->where('id_status', 4)->get();

                    $deal = Registration::where('source_events', $data_search['id'])
                                        ->where('status_payment', 7)
                                        ->get();

                    $out = 0;
                    foreach($result[$key] as $key_result => $data_result){
                        if( $data_search['x'] == $data_result['x'] ){
                            // $index = array_search($data_search['x'], $data_result);
                            if(count($deal)!=0 && count($check)!=0){
                                $result[$key][$key_result]['y'] += count($deal) / count($check);
                                $result[$key][$key_result]['y'] = round($result[$key][$key_result]['y'] / 2, 2);
                            }else if($result[$key][$key_result]['y'] != 0){
                                $result[$key][$key_result]['y'] /= 2;
                            }
                            $result[$key][$key_result]['course'] .= "、" .$data_search['course'] . " " . $data_search['events'];
                            // $events['title'] .= "、".$data_search['course'];
                            $out++;
                            break;
                        }
                    }
                    if( $out == 0 ){
                        if(count($deal)!=0 && count($check)!=0){
                            $events['y'] = round(count($deal) / count($check),2);
                        }else{
                            $events['y'] = 0;
                        }
                        $events['x'] = $data_search['x'];
                        $events['course'] = $data_search['course'] . " " . $data_search['events'];
                        // $events['title'] = $data_search['course'];

                        array_push($result[$key], $events);
                    }
                    
                    //記錄每一條件的每一場次資訊
                    // $result[$key][$key_search] = $events;
                    // $result .= [$events];

                    //紀錄每場日期
                    if( !in_array( $data_search['x'], $labelDate) ){
                        array_push($labelDate, $data_search['x']);
                    }
                }
            }


            /* 計算營業額 */
            if($nav == "income"){
                //報名數
                foreach( $search as $key_search => $data_search ){
                    $events = [];
                    // if( $data_search['type'] == 1 ){
                    //     //銷講
                    //     $check = SalesRegistration::where('id_events', $data_search['id']);
                    //     //來源
                    //     if($data[2] != '0'){
                    //         $check->where('datasource', $data[2]);
                    //     }
                    // }else if( $data_search['type'] == 2 || $data_search['type'] == 3 ){
                    //     //正課
                    //     $check = Register::where('id_events', $data_search['id']);
                    // }
                    $income = 0;
                    
                    //付款狀態
                    if($data[6] != '0'){
                        $pay = Registration::select('amount_payable')
                                            ->where('id_group', $data_search['id_group'])
                                            ->where('status_payment', $data[6])
                                            ->get();
                    }else{
                        $pay = Registration::select('amount_payable')
                                            ->where('id_group', $data_search['id_group'])
                                            ->where('status_payment', '<>', 6)
                                            ->get();
                    }
                    foreach( $pay as $data){
                        $income += $data['amount_payable'];
                    }
                                        
                    $out = 0;
                    foreach($result[$key] as $key_result => $data_result){
                        if( $data_search['x'] == $data_result['x'] ){
                            // $index = array_search($data_search['x'], $data_result);
                            $result[$key][$key_result]['y'] += $income;
                            $result[$key][$key_result]['course'] .= "、" .$data_search['course'] . " " . $data_search['events'];
                            // $events['title'] .= "、".$data_search['course'];
                            $out++;
                            break;
                        }
                    }
                    if( $out == 0 ){
                        $events['y'] = $income;
                        $events['x'] = $data_search['x'];
                        $events['course'] = $data_search['course'] . " " . $data_search['events'];
                        // $events['title'] = $data_search['course'];

                        array_push($result[$key], $events);
                    }
                    
                    //記錄每一條件的每一場次資訊
                    // $result[$key][$key_search] = $events;
                    // $result .= [$events];

                    //紀錄每場日期
                    if( !in_array( $data_search['x'], $labelDate) ){
                        array_push($labelDate, $data_search['x']);
                    }
                }
            }


            /* 計算單場成本 */
            if($nav == "cost"){
                //報名數
                foreach( $search as $key_search => $data_search ){
                    $events = [];
                    
                    $cost_all = EventsCourse::where('id', $data_search['id'])
                                            ->first();

                    //成本
                    if($data[7] != '0'){
                        $cost = $cost_all->$data[8];
                    }else{
                        $cost = $cost_all->cosr_ad + $cost_all->cost_message + $cost_all->cost_events;
                    }
                                        
                    $out = 0;
                    foreach($result[$key] as $key_result => $data_result){
                        if( $data_search['x'] == $data_result['x'] ){
                            // $index = array_search($data_search['x'], $data_result);
                            $result[$key][$key_result]['y'] += $cost;
                            $result[$key][$key_result]['course'] .= "、" .$data_search['course'] . " " . $data_search['events'];
                            // $events['title'] .= "、".$data_search['course'];
                            $out++;
                            break;
                        }
                    }
                    if( $out == 0 ){
                        $events['y'] = $cost;
                        $events['x'] = $data_search['x'];
                        $events['course'] = $data_search['course'] . " " . $data_search['events'];
                        // $events['title'] = $data_search['course'];

                        array_push($result[$key], $events);
                    }
                    
                    //記錄每一條件的每一場次資訊
                    // $result[$key][$key_search] = $events;
                    // $result .= [$events];

                    //紀錄每場日期
                    if( !in_array( $data_search['x'], $labelDate) ){
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

        return array( 'result' => $result , 'labelDate' => $labelDate);
    }
}
