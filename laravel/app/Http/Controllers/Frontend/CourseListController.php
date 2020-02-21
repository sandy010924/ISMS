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
        // $courses = Course::distinct('id_teacher')
        //                  ->join('teacher', 'teacher.id', '=', 'course.id_teacher')
        //                  ->select('course.*', 'teacher.name as teacher')
        //                  ->orderBy('id_teacher', 'desc')
        //                  ->get();
                         
        $courses= Course::selectRaw('course.*, MAX(teacher.id) AS id_teacher')
            ->join('teacher', 'teacher.id', '=', 'course.id_teacher')
            ->groupBy('course.id_teacher')
            ->get();

        foreach ($courses as $key => $data) {
            // //表單上場次
            // $count_form = count($courses::Where('course_start_at', '>=', date('Y-m-d H:i:s'))       
            //             ->Where('id_status', 4)
            //             ->get());

            // //總場次
            // $count_events = count(Course::join('sales_registration', 'sales_registration.id_course', '=', 'course.id')
            //             ->Where('course.id', $data['id'])       
            //             ->Where('id_status', '<>', 2)   
            //             ->get());

            // //累計名單
            // $count_list = count(Course::join('sales_registration', 'sales_registration.id_course', '=', 'course.id')
            //             ->Where('course.id', $data['id'])       
            //             ->Where('id_status', 5)
            //             ->get());


            $courses[$key] = [
                'teacher' => $data['teacher'],
                'type' => $data['type'],
                'name' => $data['name'],
                // 'count_form' =>$count_form,
                // 'count_events' => $count_events,
                // 'count_list' =>$count_list,
                'href_apply' => route('course_list_apply',["id"=> $data['id'] ]),
                'href_refund' => route('course_list_refund',["id"=> $data['id'] ]),
                'href_data' => route('course_list_data',["id"=> $data['id'] ]),
                'course_id' => $data['course.id']
            ];
        }
        // dd($courses);
        // return view('frontend.course', compact('courses','courses_apply','courses_cancel'));
        return view('frontend.course_list', compact('courses'));
    }

    // Sandy (2020/01/31)
    public function search(Request $request)
    {
        $search_date = $request->get('search_date');
        $search_name = $request->get('search_name');
        
        if(empty($search_date)){
            $data_course = Course::Where('course.name', 'like', '%' .$search_name. '%')   
                                 ->orderBy('course_start_at', 'desc')                
                                 ->get();
        }else{
            $data_course = Course::Where('course.name', 'like', '%' .$search_name. '%')
                                 ->Where('course.course_start_at', 'like', '%' . $search_date. '%')    
                                 ->orderBy('course_start_at', 'desc') 
                                 ->get();
        }

        $courses = array();

        foreach ($data_course as $key => $data) {
            $count_apply = count(Course::join('sales_registration', 'sales_registration.id_course', '=', 'course.id')
                        ->Where('course.id', $data['id'])      
                        ->Where('id_status', '<>', 2)  
                        ->get());

            $count_cancel = count(Course::join('sales_registration', 'sales_registration.id_course', '=', 'course.id')
                        ->Where('course.id', $data['id'])       
                        ->Where('id_status', 5)
                        ->get());
                        
            $count_check = count(Course::join('sales_registration', 'sales_registration.id_course', '=', 'course.id')
                        ->Where('course.id', $data['id'])       
                        ->Where('id_status', 4)
                        ->get());

            $courses[$key] = [
                'id' => $data['id'],
                'date' => date('Y-m-d', strtotime($data['course_start_at'])),
                'name' => $data['name'],
                'event' => $data['Events'],
                'count_apply' => $count_apply,
                'count_cancel' => $count_cancel,
                'count_check' => $count_check,
                'href_check' => route('course_check',["id"=> $data['id'] ]),
                'href_list' => route('course_apply',["id"=> $data['id'] ]),
                'href_adv' => route('course_advanced',["id"=> $data['id'] ]),
                'href_return' => route('course_return',["id"=> $data['id'] ]),
                'href_form' => route('course_form',["id"=> $data['id'] ])
            ];
        }

        return Response($courses);
    }

}
