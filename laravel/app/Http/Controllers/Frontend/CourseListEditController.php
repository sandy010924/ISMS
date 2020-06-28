<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Uer;
use App\Model\Teacher;

class CourseListEditController extends Controller
{
    //view
    public function show(Request $request)
    {
         //課程資訊
        $id = $request->get('id');
        $course = Course::join('teacher', 'teacher.id', '=', 'course.id_teacher')
                        ->select('course.*', 'teacher.name as teacher')
                        ->Where('course.id', $id)
                        ->first();

        //所有對應上階課程
        $course_all = array();
        
        if( $course->type == 2 ){
            $course_all = Course::select('name', 'id')
                        ->where('type', 1)
                        ->get();
        }elseif (  $course->type == 3 ) {
            $course_all = Course::select('name', 'id')
                        ->where('type', 2)
                        ->get();
        }
                         
        //場次資訊
        $events_all = EventsCourse::Where('id_course', $id)
                                  ->get();
                                  
        
        $events = array();
        $id_group='';

        foreach( $events_all as $key => $data ){
            // if($data['id_group'] == ""){
            //     //日期
            //     $date = date('Y-m-d', strtotime($data['course_start_at']));
            //     //時間
            //     $time_strat = date('H:i', strtotime($data['course_start_at']));
            //     $time_end = date('H:i', strtotime($data['course_end_at']));
            //     //星期
            //     $weekarray = array("日","一","二","三","四","五","六");
            //     $week = $weekarray[date('w', strtotime($data['course_start_at']))];

            //     // $events[$key] = $date . '（' . $week . '）' . ' ' . $time_strat . '-' . $time_end . ' ' . $data['Events'] . '（' . $data['location'] . '）';
                
            //     //群組ID
            //     $id_group = $data['id_group'];
                
            //     $events[$key] = array(
            //         'date' => $date,
            //         'event' => $data['name'],
            //         'time' => $time_strat . '-' . $time_end,
            //         'location' => $data['location'],
            //         'id_group' => $id_group,
            //     );
            // }else {
                if ($id_group == $data['id_group']){ 
                    continue;
                }

                $course_group = EventsCourse::Where('id_group', $data['id_group'])
                                            ->Where('id_course', $id)
                                            ->get();

                $numItems = count($course_group);
                $i = 0;

                $events_group = '';
                $unpublish_group = array();

                foreach( $course_group as $key_group => $data_group ){

                    // //已過場次 就取消場次
                    // if(strtotime(date('Y-m-d', strtotime($data_group['course_start_at']))) < strtotime(date("Y-m-d"))){
                    //     EventsCourse::Where('id', $data_group['id'])
                    //                 ->update(['unpublish' => 1]);
                    // }

                    //日期
                    $date = date('Y-m-d', strtotime($data_group['course_start_at']));
                    //星期
                    $weekarray = array("日","一","二","三","四","五","六");
                    $week = $weekarray[date('w', strtotime($data_group['course_start_at']))];
                    
                    if( ++$i === $numItems){
                        $events_group .= $date . '（' . $week . '）';
                    }else {
                        $events_group .= $date . '（' . $week . '）' . '、';
                    }

                    array_push($unpublish_group, $data_group['unpublish']); 
                }
                //時間
                $time_strat = date('H:i', strtotime($data['course_start_at']));
                $time_end = date('H:i', strtotime($data['course_end_at']));

                //群組ID
                $id_group = $data['id_group'];

                // $events[$key] = $events_group . ' ' . $time_strat . '-' . $time_end . ' ' . $data['Events'] . '（' . $data['location'] . '）';

                //不公開
                $unpublish = 0;
                if( in_array(1, $unpublish_group) ){
                    $unpublish = 1;
                }else {
                    $unpublish = 0;
                }

                $events[$key] = array(
                    'date' => $events_group,
                    'event' => $data['name'],
                    'time' => $time_strat . '-' . $time_end,
                    'location' => $data['location'],
                    'id_group' => $id_group,
                    'unpublish' => $unpublish,
                );

            // }
        }

        return view('frontend.course_list_edit', compact('course', 'course_all', 'events'));    
    }
    
    // 編輯資料填入 Sandy (2020/06/28)
    public function fill( Request $request )
    {
        $id = $request->input('id');
        $data = EventsCourse::Where('id_group', $id)->first();
        $count = count(EventsCourse::Where('id_group', $id)->get());

        if( !empty($data) ){
            $group = EventsCourse::Where('id_group', $id)->get();
            $i = 0;
            $events_group = "";
            foreach($group as $item){
                //日期
                $date = date('Y-m-d', strtotime($item['course_start_at']));
                //星期
                $weekarray = array("日","一","二","三","四","五","六");
                $week = $weekarray[date('w', strtotime($item['course_start_at']))];
                
                if( ++$i === $count){
                    $events_group .= $date . '（' . $week . '）';
                }else {
                    $events_group .= $date . '（' . $week . '）' . '、';
                }

                $start = date('H:i', strtotime($item['course_start_at']));
                $end = date('H:i', strtotime($item['course_end_at']));
            }

            return array('data' => $data, 'events_group'=> $events_group, 'count' => $count, 'start' => $start, 'end' => $end);
        }else {
            return 'nodata';
        }
    }
}
