<?php

namespace App\Http\Controllers\Backend;

use App\Model\StudentGroup;
use App\Model\StudentGroupdetail;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class StudentGroupController extends Controller
{
    // 刪除細分組 Rocky (2020/03/20)
    public function groupdelete(Request $request)
    {
        $status = "";
        $id = $request->get('id');

        // 查詢是否有該筆資料
        $StudentGroup = StudentGroup::where('id', $id)->get();
        
        // 刪除資料
        
        if (!empty($StudentGroup)) {
            StudentGroup::where('id', $id)->delete();
            StudentGroupdetail::where('id_group', $id)->delete();
            
            $status = "ok";
        } else {
            $status = "error";
        }
        return json_encode(array('data' => $status));
    }


    // 儲存 (2020/03/10)
    public function save(Request $request)
    {
        $id_StudentGroupdetail = "";
        $title = $request->get('title');
        $condition = $request->get('log');
        $array_studentid = $request->get('array_studentid');
        // return $array_studentid;
        

        $StudentGroup = new StudentGroup;
       
       
        // 新增細分組資料
        $StudentGroup->name       = $title;         // 細分組名稱
        $StudentGroup->condition  = $condition;     // 條件

        $StudentGroup->save();
        $id_StudentGroup = $StudentGroup->id;


        if (!empty($id_StudentGroup)) {
            if (!empty($array_studentid)) {
                foreach ($array_studentid as $key => $data) {
                    $StudentGroupdetail = new StudentGroupdetail;

                    // 新增細分組詳細資料
                    $StudentGroupdetail->id_student     = $data['id'];           // 學生ID
                    $StudentGroupdetail->id_group       = $id_StudentGroup;      // 細分組ID

                    $StudentGroupdetail->save();
                }
                $id_StudentGroupdetail = $StudentGroupdetail->id;
            }
        }

        if (!empty($id_StudentGroupdetail) || !empty($id_StudentGroup)) {
            return '儲存成功';
        } else {
            return '更新失敗';
        }
    }

    // 更新 (2020/03/21)
    public function update(Request $request)
    {
        $id_StudentGroupdetail = "";
        $id_StudentGroup = "";
        $id = $request->get('id');
        $name_group = $request->get('name_group');
        $condition = $request->get('condition');
        $array_studentid = $request->get('array_upate_studentid');
       

       

        if ($id != "") {
            $id_StudentGroup = StudentGroup::where('id', $id)
                                ->update(['name' => $name_group,'condition' => $condition]);

            if (!empty($array_studentid)) {
                foreach ($array_studentid as $key => $data) {
                    $StudentGroupdetail = new StudentGroupdetail;
    
                    // 新增細分組詳細資料
                    $StudentGroupdetail->id_student     = $data['id'];           // 學生ID
                    $StudentGroupdetail->id_group       = $id;                   // 細分組ID
    
                    $StudentGroupdetail->save();
                }
                $id_StudentGroupdetail = $StudentGroupdetail->id;
            }
        }

        if (!empty($id_StudentGroupdetail) || !empty($id_StudentGroup)) {
            return '儲存成功';
        } else {
            return '更新失敗';
        }
    }

    // 複製 (2020/03/20)
    public function groupcopy(Request $request)
    {
        $id = $request->get('id');

        // 查詢細分組名稱
        $name_group = StudentGroup::where('id', $id)
                        ->select('student_group.*')
                        ->get();
        
        // 查詢細分組學員資料
        $id_students = StudentGroupdetail::where('id_group', $id)
                    ->select('student_groupdetail.id_student')
                    ->get();

        // 儲存細分組
        $StudentGroup = new StudentGroup;
              
        // 新增細分組資料
        $StudentGroup->name       = $name_group[0]['name'];                   // 細分組名稱
        $StudentGroup->condition       = $name_group[0]['condition'];         // 細分組條件


        $StudentGroup->save();
        $id_StudentGroup = $StudentGroup->id;

        if (!empty($id_StudentGroup)) {
            $StudentGroupdetail = new StudentGroupdetail;
            // 查詢是否有該筆資料
            $check_detail = StudentGroupdetail::where('id_student', $id)->get();
            if (!empty($check_detail)) {
                foreach ($id_students as $key => $data) {
                    $StudentGroupdetail = new StudentGroupdetail;

                    // 新增細分組詳細資料
                    $StudentGroupdetail->id_student     = $data['id_student'];   // 學生ID
                    $StudentGroupdetail->id_group       = $id_StudentGroup;      // 細分組ID

                    $StudentGroupdetail->save();
                }
                $id_StudentGroupdetail = $StudentGroupdetail->id;
            }
        }

        if (!empty($id_StudentGroupdetail) || !empty($id_StudentGroup)) {
            return '複製成功';
        } else {
            return '更新失敗';
        }
    }
}
