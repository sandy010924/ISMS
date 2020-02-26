<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Student;
use App\Model\SalesRegistration;

class CourseListController extends Controller
{
    //view
    public function show()
    {
        $courses = Course::join('teacher', 'teacher.id', '=', 'course.id_teacher')
                         ->select('course.name as course', 'course.type as type', 'teacher.id as id_teacher', 'teacher.name as teacher')
                         ->orderBy('id_teacher', 'desc')
                         ->distinct()
                         ->get();
                         
        foreach ($courses as $key => $data) {
            //表單上場次
            $count_form = count(Course::Where('course_start_at', '>=', date('Y-m-d H:i:s'))       
                        ->Where('name', $data['course'])
                        ->Where('id_teacher', $data['id_teacher'])
                        ->get());


            //總場次
            $count_events = count(Course::Where('name', $data['course'])
                                        ->Where('id_teacher', $data['id_teacher'])
                                        ->get());
            

            //累計名單            
            $all_courses = Course::select('id as id')
                                 ->Where('name', $data['course'])
                                 ->Where('id_teacher', $data['id_teacher'])
                                 ->get();

            $count_list = 0;
            
            foreach ($all_courses as $key_course => $data_course) {
                $count = count(SalesRegistration::Where('id_course', $data_course['id'])
                                                ->Where('id_status','<>', 2)            
                                                ->get());
                $count_list += $count;
            }

            
            
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
                    $type = '三階課程A';
                    break;
                case 4:
                    //三階課程B
                    $type = '三階課程B';
                    break;
                // case 5:
                //     //三階課程A+B
                //     $type = '三階課程A+B';
                //     break;
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
                'href_apply' => route('course_list_apply',["id"=> $data['id'] ]),
                'href_refund' => route('course_list_refund',["id"=> $data['id'] ]),
                'href_data' => route('course_list_data',["id"=> $data['id'] ]),
                'all_id' => $all_courses
            ];
        }
        
        return view('frontend.course_list', compact('courses'));
        return view('frontend.course_list',Response($courses));
    }

    // Sandy (2020/02/25)
    // public function search(Request $request)
    // {
    //     $search_name = $request->get('search_name');
        
    //     $courses = Course::join('teacher', 'teacher.id', '=', 'course.id_teacher')
    //                      ->select('course.name as course', 'course.type as type', 'teacher.id as id_teacher', 'teacher.name as teacher')
    //                      ->Where('course.name', 'like', '%' .$search_name. '%') 
    //                      ->orderBy('id_teacher', 'desc')
    //                      ->distinct()
    //                      ->get();
                         
    //     foreach ($courses as $key => $data) {
    //         //表單上場次
    //         $count_form = count(Course::Where('course_start_at', '>=', date('Y-m-d H:i:s'))       
    //                     ->Where('name', $data['course'])
    //                     ->Where('id_teacher', $data['id_teacher'])
    //                     ->get());


    //         //總場次
    //         $count_events = count(Course::Where('name', $data['course'])
    //                                     ->Where('id_teacher', $data['id_teacher'])
    //                                     ->get());
            

    //         //累計名單            
    //         $all_courses = Course::select('id as id')
    //                              ->Where('name', $data['course'])
    //                              ->Where('id_teacher', $data['id_teacher'])
    //                              ->get();

    //         $count_list = 0;
            
    //         foreach ($all_courses as $key_course => $data_course) {
    //             $count = count(SalesRegistration::Where('id_course', $data_course['id'])
    //                                             ->Where('id_status','<>', 2)            
    //                                             ->get());
    //             $count_list += $count;
    //         }

            
            
    //         switch($data['type']){
    //             case 1:
    //                 //銷講
    //                 $type = '銷講';
    //                 break;
    //             case 2:
    //                 //二階課程
    //                 $type = '二階課程';
    //                 break;
    //             case 3:
    //                 //三階課程A
    //                 $type = '三階課程A';
    //                 break;
    //             case 4:
    //                 //三階課程B
    //                 $type = '三階課程B';
    //                 break;
    //             // case 5:
    //             //     //三階課程A+B
    //             //     $type = '三階課程A+B';
    //             //     break;
    //             default:
    //                 return 'error';
    //                 break;
    //         }

    //         $courses[$key] = [
    //             'teacher' => $data['teacher'],
    //             'type' => $type,
    //             'course' => $data['course'],
    //             'count_form' =>$count_form,
    //             'count_events' => $count_events,
    //             'count_list' => $count_list,
    //             'href_apply' => route('course_list_apply',["id"=> $data['id'] ]),
    //             'href_refund' => route('course_list_refund',["id"=> $data['id'] ]),
    //             'href_data' => route('course_list_data',["id"=> $data['id'] ]),
    //             'course_id' => $data['course.id']
    //         ];
    //     }

    //     return Response($courses);
    // }

}
