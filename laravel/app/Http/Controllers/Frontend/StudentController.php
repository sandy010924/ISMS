<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Student;
use Symfony\Component\HttpFoundation\Request;

class StudentController extends Controller
{
    // 顯示資料
    public function show()
    {
        $pagesize = 15;

        $students = Student::paginate($pagesize);
        return view('frontend.student', compact('students'));
    }

    // 搜尋
    public function search(Request $request)
    {
        $pagesize = 15;
        $search_data = $request->get('search_data');

        if (!empty($search_data)) {
            $students = Student::Where('email', 'like', '%' .$search_data. '%')
            ->orWhere('phone', 'like', '%' .$search_data. '%')
            ->paginate($pagesize);
        } else {
            $students = Student::paginate($pagesize);
        }
        

        // $returnHTML = view('frontend.student')->with('students', $students)->renderSections()['content'];
        $returnHTML = view('frontend.student')->with('students', $students)->render();
        return $returnHTML;
    }
}
