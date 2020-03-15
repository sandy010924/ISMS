<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;

class CourseListEditController extends Controller
{
    //新增報名表
    public function insert(Request $request)
    {
        try{
            //讀取data
            $id = $request->get('course_id');
            $id_type = $request->get('newform_course');
            $courseservices = $request->get('newform_services');
            $money = $request->get('newform_price');
            
            Course::where('id', $id)
                  ->update(['id_type' => $id_type, 'courseservices' => $courseservices, 'money' => $money]);

            return redirect()->route('course_list_edit', ['id' => $id])->with('status', '新增成功');
        } catch (\Exception $e) {
            return redirect()->route('course_list_edit', ['id' => $id])->with('status', '新增失敗');
        }

    }
}
