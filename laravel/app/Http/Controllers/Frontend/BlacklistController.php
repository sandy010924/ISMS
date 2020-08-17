<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Student;
use App\Model\Blacklist;
use Symfony\Component\HttpFoundation\Request;

class BlacklistController extends Controller
{
    // 顯示資料
    public function show()
    {
        // $pagesize = 15;

        $blacklists =  Blacklist::leftJoin('student', 'blacklist.id_student', '=', 'student.id')
            ->select('blacklist.id as blacklist_id', 'blacklist.reason', 'student.*')
            ->get();
        // dd($blacklists);
        return view('frontend.student_blacklist', compact('blacklists'));
    }

    // 搜尋
    public function search(Request $request)
    {
        $pagesize = 15;
        $search_data = $request->get('search_data');

        if (!empty($search_data)) {
            $blacklists = Blacklist::leftJoin('student', 'blacklist.id_student', '=', 'student.id')
                ->select('blacklist.id as blacklist_id', 'blacklist.reason', 'student.*')
                ->Where('email', 'like', '%' . $search_data . '%')
                ->orWhere('phone', 'like', '%' . $search_data . '%')
                ->paginate($pagesize);
        } else {
            $blacklists =  Blacklist::leftJoin('student', 'blacklist.id_student', '=', 'student.id')
                ->select('blacklist.id as blacklist_id', 'blacklist.reason', 'student.*')
                ->paginate($pagesize);
        }


        // $returnHTML = view('frontend.student_blacklist')->with('blacklists', $blacklists)->renderSections()['content'];
        $returnHTML = view('frontend.student_blacklist')->with('blacklists', $blacklists)->render();
        return $returnHTML;
    }
}
