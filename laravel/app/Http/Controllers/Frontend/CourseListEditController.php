<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Uer;

class CourseListEditController extends Controller
{
    //view
    public function show(Request $request)
    {
        //所有課程
        $course_all = Course::select('name', 'id')
                        ->get();

         //課程資訊
        $id = $request->get('id');
        $course = Course::join('users', 'users.id', '=', 'course.id_teacher')
                        ->select('course.*', 'users.name as teacher')
                        ->Where('course.id', $id)
                        ->first();
                         
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
}
