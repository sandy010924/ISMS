<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\EventsCourse;
use App\Model\SalesRegistration;
use App\Model\Registration;
use App\Model\Register;
use App\Model\Debt;
use App\Model\Refund;
use App\Model\Payment;

class CourseListEditController extends Controller
{
    /* 新增/編輯報名表 s */
    public function insert(Request $request)
    {
        try{
            //讀取data
            $id = $request->get('course_id');
            $id_type = $request->get('newform_course');
            $courseservices = $request->get('newform_services');
            $money = $request->get('newform_price');
            $url = $request->get('newform_url');
            
            Course::where('id', $id)
                  ->update([
                      'id_type' => $id_type, 
                      'courseservices' => $courseservices, 
                      'money' => $money,
                      'pay_url' => $url,
                    ]);

            return redirect()->route('course_list_edit', ['id' => $id])->with('status', '新增成功');
        } catch (\Exception $e) {
            return redirect()->route('course_list_edit', ['id' => $id])->with('status', '新增失敗');
        }

    }
    /* 新增/編輯報名表 e */


    /* 取消場次Sandy (2020/03/21) s */
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
    /* 取消場次Sandy (2020/03/21) e */

    
    /* 更新資料(講師、課程名稱)Sandy (2020/04/02) s */
    public function update_data(Request $request)
    {
        $status='';

        //取回data
        $id_course = $request->input('id_course');
        $data_type = $request->input('data_type');
        $data_val = $request->input('data_val');

        try{
            switch($data_type){
                case 'teacher':
                    //講師
                    Course::join('teacher', 'teacher.id', '=', 'course.id_teacher' )
                          ->where('course.id', $id_course)
                          ->update(['teacher.name' => $data_val]);
                    $status = "success";
                    break;
                case 'course':
                    //課程
                    Course::where('id', $id_course)
                          ->update(['name' => $data_val]);
                    $status = "success";
                    break;
                default:
                    $status = "error";
                    break;
            }
        }catch (Exception $e) {
            // return json_encode(array(
            //     'errorMsg' => '報到狀態修改失敗'
            // ));
            $status = "error";
        }

        return $status;
    }
    /*  更新資料(講師、課程名稱)Sandy (2020/04/02) e */

    
    // 編輯資料 Sandy (2020/06/27)
    public function edit(Request $request)
    {
        //讀取data
        $id_course = $request->get('edit_idcourse');
        $id_group = $request->get('edit_idgroup');
        $event = $request->get('edit_event');
        $start = $request->get('edit_starttime');
        $end = $request->get('edit_endtime');
        $location = $request->get('edit_location');
        
        try{

            /*場次資料 - S*/

            //判斷系統是否已有該場次資料
            $events = EventsCourse::where('id_group', $id_group)->get();

            // 檢查正課報名資料
            if (count($events) != 0) {
                foreach($events as $data){
                    $date = date('Y-m-d', strtotime(EventsCourse::where('id', $data['id'])->first()->course_start_at));

                    EventsCourse::where('id', $data['id'])->update([
                        'name' => $event,
                        'course_start_at' => date('Y-m-d H:i:s', strtotime($date . " " . $start)),
                        'course_end_at' => date('Y-m-d H:i:s', strtotime($date . " " . $end)),
                        'location' => $location,
                    ]);     
                }                
           }
        
            /*正課報名資料 - E*/
            
            return redirect()->route('course_list_edit', ['id' => $id_course])->with('status', '修改成功');
        
        }catch (Exception $e) {
            return redirect()->route('course_list_edit', ['id' => $id_course])->with('status', '修改失敗');
        }
    }

    // 刪除 Sandy (2020/05/31)
    public function delete(Request $request)
    {
        $status = "";
        $id_group = $request->get('id_group');
        
        $events = EventsCourse::join('course', 'course.id', '=', 'events_course.id_course')
            ->select('course.type as type', 'events_course.*')
            ->where('events_course.id_group', $id_group)
            ->get();

        // 刪除資料
        if (!empty($events)) {
            if ($events[0]->type == 1) {
                //銷講
                foreach ($events as $data) {
                    //刪除報名表
                    SalesRegistration::where('id_events', $data->id)->delete();

                    // $apply_table = SalesRegistration::where('id_events', $events->id)
                    //                                 ->get();

                }
            } elseif ($events[0]->type == 2 || $events[0]->type == 3) {
                //正課
                // foreach( $events as $data){

                $apply_table = Registration::where('id_group', $id_group)->get();

                foreach ($apply_table as $data_apply) {
                    //刪除報到
                    Register::where('id_registration', $data_apply['id'])->delete();

                    //刪除追單
                    Debt::where('id_registration', $data_apply['id'])->delete();

                    //刪除退費
                    Refund::where('id_registration', $data_apply['id'])->delete();

                    //刪除付款
                    Payment::where('id_registration', $data_apply['id'])->delete();
                }

                //刪除報名表
                Registration::where('id_group', $id_group)->delete();
                // }

            }else if ($events[0]->type == 4) {
                //活動
                foreach ($events as $data) {
                    //刪除報名表
                    Activity::where('id_events', $data->id)->delete();
                }
            } 

            //刪除場次  
            EventsCourse::where('id_group', $id_group)->delete();

            $status = "ok";
        } else {
            $status = "error";
        }
        return json_encode(array('data' => $status));
    }
}
