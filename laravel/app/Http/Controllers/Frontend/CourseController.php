<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\Student;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\User;

class CourseController extends Controller
{
    // Sandy (2020/01/14)
    public function show()
    {
        $events = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
                              ->select('events_course.*', 'course.name as course', 'course.type as type')
                              ->orderBy('events_course.course_start_at', 'desc')
                              ->get();
                              
        $teachers = User::Where('role', 'teacher')   
                        ->get();

        foreach ($events as $key => $data) {
            $type = "";
            
            //判斷是銷講or正課
            if($data['type'] == 1){
                $type = "sales_registration";
            }else{
                $type = "registration";
            }

            //判斷是否有下一階
            $nextLevel = count(Course::where('id_type', $data['id_course'])
                               ->get());

            $count_apply = count(EventsCourse::join($type, $type.'.id_events', '=', 'events_course.id')
                        ->Where('events_course.id', $data['id'])       
                        ->Where('id_status', '<>', 2)   
                        ->get());

            $count_cancel = count(EventsCourse::join($type, $type.'.id_events', '=', 'events_course.id')
                        ->Where('events_course.id', $data['id'])       
                        ->Where('id_status', 5)
                        ->get());

            $count_check = count(EventsCourse::join($type, $type.'.id_events', '=', 'events_course.id')
                        ->Where('events_course.id', $data['id'])        
                        ->Where('id_status', 4)
                        ->get());
            
            $events[$key] = [
                'date' => date('Y-m-d', strtotime($data['course_start_at'])),
                'name' => $data['course'],
                'event' => $data['name'],
                'count_apply' => $count_apply,
                'count_cancel' =>$count_cancel,
                'count_check' =>$count_check,
                'href_check' => route('course_check',["id"=> $data['id'] ]),
                'href_list' => route('course_apply',["id"=> $data['id'] ]),
                'href_adv' => route('course_advanced',["id"=> $data['id'] ]),
                'href_return' => route('course_return',["id"=> $data['id'] ]),
                'href_form' => route('course_form',["id"=> $data['id'] ]),
                'id' => $data['id'],
                'nextLevel' => $nextLevel
            ];
        }
        
        return view('frontend.course', compact('events','teachers'));
    }

}
