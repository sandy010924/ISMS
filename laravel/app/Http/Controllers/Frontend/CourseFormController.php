<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\Student;
use App\Model\Teacher;
use App\Model\SalesRegistration;
use App\Model\Registration;

class CourseFormController extends Controller
{
    // Sandy (2020/03/03)
    public function show(Request $request){
        $id = $request->get('id');
        $name = $request->get('name');
        
        $courses = Course::Where('id_type', $name)
                      ->get();
        $id_group='';

        foreach( $courses as $key => $data ){
            if($data['id_group'] == ""){
                //日期
                $date = date('Y-m-d', strtotime($data['course_start_at']));
                //時間
                $time_strat = date('H:i', strtotime($data['course_start_at']));
                $time_end = date('H:i', strtotime($data['course_end_at']));
                //星期
                $weekarray = array("日","一","二","三","四","五","六");
                $week = $weekarray[date('w', strtotime($data['course_start_at']))];

                $events[$key] = $date . '（' . $week . '）' . ' ' . $time_strat . '-' . $time_end . ' ' . $data['Events'] . '（' . $data['location'] . '）';
            }else {
                if ($id_group == $data['id_group']){ 
                    continue;
                }

                $course_group = Course::Where('id_group', $data['id_group'])
                                      ->get();
                $numItems = count($course_group);
                $i = 0;

                $events_group = '';

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
                }
                //時間
                $time_strat = date('H:i', strtotime($data_group['course_start_at']));
                $time_end = date('H:i', strtotime($data_group['course_end_at']));

                $events[$key] = $events_group . ' ' . $time_strat . '-' . $time_end . ' ' . $data['Events'] . '（' . $data['location'] . '）';

                $id_group = $data['id_group'];
            }
        }

        // dd($events);

        //課程服務內容
        // $courseservices =

        //一般定價
        // $price =
        
        return view('frontend.course_form', compact('events'));
    }

    
    // 尋找學員資料做預設填入 Sandy (2020/03/04)
    public function fill( Request $request )
    {
        $phone = $request->input('phone');
        
        $student = Student::Where('phone', $phone)
                          ->get();

        if( count($student)>0 ){
            return Response($student);
        }else {
            return 'nodata';
        }
    }

}
