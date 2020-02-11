<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Student;
use App\Model\SalesRegistration;

class CourseController extends Controller
{
   

    // Sandy (2020/01/14)
    public function show()
    {
        // $view_array=array();
        $courses = Course::all();
        // $courses_apply = array();
        // $courses_cancel = array();

        foreach ($courses as $key => $data) {
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

            // array_push($courses_apply, $count_apply);
            // array_push($courses_cancel, $count_cancel);
            
            $courses[$key] = [
                'date' => date('Y-m-d', strtotime($data['course_start_at'])),
                'name' => $data['name'],
                'event' => $data['Events'],
                'count_apply' => $count_apply,
                'count_cancel' =>$count_cancel,
                'count_check' =>$count_check,
                'href_list' => route('course_apply',["id"=> $data['id'] ]),
                'href_form' => route('course_form',["id"=> $data['id'] ]),
                'course_id' => $data['id']
            ];
        }
        // dd($courses);
        // return view('frontend.course', compact('courses','courses_apply','courses_cancel'));
        return view('frontend.course', compact('courses'));
    }

    // Sandy (2020/01/31)
    public function search(Request $request)
    {
        $search_date = $request->get('search_date');
        $search_name = $request->get('search_name');
        
        if(empty($search_date)){
            $data_course = Course::Where('course.name', 'like', '%' .$search_name. '%')   
                            ->get();
        }else{
            $data_course = Course::Where('course.name', 'like', '%' .$search_name. '%')
                            ->Where('course.course_start_at', 'like', '%' . $search_date. '%')    
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
                'date' => date('Y-m-d', strtotime($data['course_start_at'])),
                'name' => $data['name'],
                'event' => $data['Events'],
                'count_apply' => $count_apply,
                'count_cancel' => $count_cancel,
                'count_check' => $count_check,
                'href_list' => route('course_apply',["id"=> $data['id'] ]),
                'href_form' => route('course_form',["id"=> $data['id'] ])
            ];
        }

        return Response($courses);
    }

     // Rocky (2020/02/11)
     public function delete(Request $request)
     {
         $status = "";
         $id_course = $request->get('id_course');
 
         // 查詢是否有該筆資料
         $course = Course::where('id',$id_course)->get();
 
         $sales_registration = SalesRegistration::where('id_course',$id_course)->get();
 
          // 刪除資料
         if(!empty($course) && !empty($sales_registration)){
             $sales_registration = SalesRegistration::where('id_course',$id_course)->delete();
             $course = Course::where('id',$id_course)->delete();            
            $status = "ok";
         } else {
             $status = "error";
         }
         return json_encode(array('data' => $status));
     }
}
