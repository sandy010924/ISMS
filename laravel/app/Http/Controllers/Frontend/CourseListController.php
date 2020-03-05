<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Student;
use App\Model\Teacher;
use App\Model\SalesRegistration;
use App\Model\EventsCourse;

class CourseListController extends Controller
{
    //View
    public function show()
    {
        // $courses = Course::join('teacher', 'teacher.id', '=', 'course.id_teacher')
        //                  ->select('course.name as course', 'course.type as type', 'teacher.id as id_teacher', 'teacher.name as teacher')
        //                  ->orderBy('id_teacher', 'desc')
        //                  ->distinct()
        //                  ->get();

        $courses = Course::join('teacher', 'teacher.id', '=', 'course.id_teacher')
                        //  ->rightjoin('events_course', 'events_course.id_course', '=', 'course.id')
                         ->select('course.id as id_course', 'course.name as course', 'course.type as type', 'teacher.id as id_teacher', 'teacher.name as teacher')
                         ->orderBy('id_teacher', 'desc')
                         ->distinct()
                         ->get();

        $teachers = Teacher::all();
                         
        foreach ($courses as $key => $data) {
            //表單上場次
            $count_form = count(EventsCourse::Where('course_start_at', '>=', date('Y-m-d H:i:s'))       
                        ->Where('id_course', $data['id_course'])
                        ->get());


            //總場次
            $count_events = count(EventsCourse::Where('id_course', $data['id_course'])
                                              ->get());
            

            //累計名單            
            $count_list = count(SalesRegistration::Where('id_course', $data['id_course'])
                                                  ->Where('id_status','<>', 2)
                                                  ->get());

            // $all_events = EventsCourse::select('id')
            //                           ->Where('id_course', $data['id_course'])
            //                           ->get();
            // $count_list = 0;
            
            // foreach ($all_courses as $key_course => $data_course) {
            //     $count = count(SalesRegistration::Where('id_course', $data_course['id'])
            //                                     ->Where('id_status','<>', 2)            
            //                                     ->get());
            //     $count_list += $count;
            // }

            
            switch($data['type']){
                case 1:
                    //銷講
                    $type = '銷講';
                    break;
                case 2:
                    //二階課程
                    $type = '二階課程';
                    break;
                case 3:
                    //三階課程A
                    $type = '三階課程';
                    break;
                case 4:
                    //三階課程B
                    $type = '活動';
                    break;
                default:
                    return 'error';
                    break;
            }

            $courses[$key] = [
                'teacher' => $data['teacher'],
                'type' => $type,
                'course' => $data['course'],
                'count_form' =>$count_form,
                'count_events' => $count_events,
                'count_list' => $count_list,
                'href_apply' => route('course_list_apply',["id"=> $data['id_course'] ]),
                'href_refund' => route('course_list_refund',["id"=> $data['id_course'] ]),
                'href_data' => route('course_list_data',["id"=> $data['id_course'] ]),
                'id' => $data['id_course']
            ];
        }
        
        return view('frontend.course_list', compact('courses','teachers'));
    }
}
