<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;

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


    // 取消場次 Sandy (2020/03/21)
    public function update(Request $request)
    {
        $status = "";
        $id_group = $request->get('id_group');
        $action = $request->get('action');

        // 查詢是否有該筆資料
        $events = EventsCourse::where('id_group', $id_group)->get();
            
        //  foreach ($id_course as $key => $data) {
            
        if(!empty($events)){
            if($action == 0){
                //上架場次
                EventsCourse::where('id_group', $id_group)->update(['unpublish' => 0]);
                $status = "publish_ok";
            }elseif($action == 1){
                //取消場次
                EventsCourse::where('id_group', $id_group)->update(['unpublish' => 1]);
                $status = "unpublish_ok";
            } 
        } else {
            $status = "error";
        }
        //  }
        return json_encode(array('data' => $status));
    }
}
