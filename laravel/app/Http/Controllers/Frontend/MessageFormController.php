<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Registration;
use App\Model\EventsCourse;
use App\Model\Course;
use App\Model\Student;

class MessageFormController extends Controller
{
    // 顯示frontend.message_cost資訊
    public function show(Request $request)
    {
      $id = $request->get('id');
      $apply = Registration::where('id', $id)->first();

      $student = array();
      $course = array();
      $events = array();

      if( !empty($apply) ){

        $student = Student::where('id', $apply->id_student)->first();

        //判斷是否有選擇課程的我要選擇其他場次
        if( $apply->id_course != -99){
          //有選擇課程
          $course = Course::join('events_course', 'events_course.id_course' , '=', 'course.id')
                            ->select('course.*')
                            ->Where('course.id_type', $apply->id_course)
                            ->Where('events_course.unpublish', 0)
                            ->distinct('id')
                            ->get();

        }else{
          //沒有選擇課程
          $source_course = EventsCourse::where('id', $apply->source_events)->first()->id_course;

          $course = Course::join('events_course', 'events_course.id_course' , '=', 'course.id')
                            ->select('course.*')
                            ->Where('course.id_type', $source_course)
                            ->Where('events_course.unpublish', 0)
                            ->distinct('id')
                            ->get();

        }
                          
        foreach( $course as $key_course => $data_course){

          $events_table = EventsCourse::join('course', 'course.id' , '=', 'events_course.id_course')
                              ->select('events_course.*')
                              ->Where('events_course.id_course', $data_course['id'])
                              ->get();
                              
          $id_group='';
          $events_list = array();
          
          foreach( $events_table as $key_events => $data_events ){
            
            if ($id_group == $data_events['id_group']){ 
                continue;
            }

            $course_group = EventsCourse::Where('id_group', $data_events['id_group'])
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
                    $events_group .= $date . '(' . $week . ')';
                    // $$events_id .= (string)$data_group['id'];
                }else {
                    $events_group .= $date . '(' . $week . ')' . '、';
                    // $events_id .= (string)$data_group['id'];
                }

            }
            //時間
            $time_strat = date('H:i', strtotime($data_group['course_start_at']));
            $time_end = date('H:i', strtotime($data_group['course_end_at']));

            // $events[$key] = $events_group . ' ' . $time_strat . '-' . $time_end . ' ' . $data['name'] . '(' . $data['location'] . ')';


            $events_list[$key_events] = [
                'events' => $events_group . ' ' . $time_strat . '-' . $time_end . ' ' . $data_events['name'] . '(' . $data_events['location'] . ')',
                'id_group' => $data_events['id_group']
            ];

            $id_group = $data_events['id_group'];
          }

          $events[$key_course] = [
              'id_course' => $data_course['id'],
              'course_name' => $data_course['name'],
              'events' => $events_list
          ];

        }
      }

      return view('frontend.message_form', compact('id', 'course', 'events', 'student'), ['status'=>'55']);
    }
}
