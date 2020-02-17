<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



/*
|--------------------------------------------------------------------------
| 框架
|--------------------------------------------------------------------------
*/
/*** 個人資訊 Rocky(2020/02/17) ***/
Route::post('user', 'Frontend\LoginController@show');


/*
------------
|
| 登入 
|
------------
*/
Route::get('/', function () {
    return view('frontend.login');
})->name('login');

/*** 登入 Rocky(2020/02/05) ***/
Route::post('login', 'Frontend\LoginController@login');
/*** 登出 Rocky(2020/02/16) ***/
Route::get('logout', 'Frontend\LoginController@logout')->name('logout');


/*
------------
|
| 課程管理 
|
------------
*/

/*** [課程管理] ***/
// Route::middleware('can:admin')-> middleware('can:teacher')->group(function () {
    Route::get('course', 'Frontend\CourseController@show')->name('course');
    /* Sandy(2020/01/31)*/
    Route::get('course_search', 'Frontend\CourseController@search');
    /* Rockyy(2020/02/11)*/
    Route::post('course_delete', 'Backend\CourseController@delete');
    /* Rocky(2019/12/29)*/
    Route::post('course', 'Backend\CourseController@upload');
    // Route::get('course', 'CourseController@uploadPage')->name('course');


    /*** [課程管理]現場正課表單 ***/
    Route::get('course_form', function () {
        return view('frontend.course_form');
    })->name('course_form');


    /*** [課程管理] 查看名單 ***/
    // Route::get('course_apply', function () {
    //     return view('frontend.course_apply');
    // })->name('course_apply');

    //Sandy (2020/01/15)
    Route::get('course_apply', 'Frontend\CourseApplyController@show')->name('course_apply');
    Route::post('course_apply', 'Backend\CourseApplyController@update');
    // Sandy (2020/02/03)
    Route::get('course_apply_search', 'Frontend\CourseApplyController@search');


    /*** [課程管理] 進階填單名單 ***/
    Route::get('course_advanced', function () {
        return view('frontend.course_advanced');
    })->name('course_advanced');


    /*** [課程管理] 課程總覽 ***/
    Route::get('course_list', function () {
        return view('frontend.course_list');
    })->name('course_list');

    Route::get('course_list_data', function () {
        return view('frontend.course_list_data');
    })->name('course_list_data');

    Route::get('course_list_apply', function () {
        return view('frontend.course_list_apply');
    })->name('course_list_apply');

    Route::get('course_list_refund', function () {
        return view('frontend.course_list_refund');
    })->name('course_list_refund');

    Route::get('course_list_view', function () {
        return view('frontend.course_list_view');
    })->name('course_list_view');

    Route::get('course_list_chart', function () {
        return view('frontend.course_list_chart');
    })->name('course_list_chart');

    Route::get('course_list_edit', function () {
        return view('frontend.course_list_edit');
    })->name('course_list_edit');


    /*** [課程管理] 今日課程 ***/
    //Sandy (2020/01/17)
    // Route::get('course_today', function () {
    //     return view('frontend.course_today');
    // })->name('course_today');
    Route::get('course_today', 'Frontend\CourseTodayController@show')->name('course_today');
    Route::get('course_today_search', 'Frontend\CourseTodayController@search');


    /*** [課程管理] 報到 ***/
    // Route::get('course_check', function () {
    //     return view('frontend.course_check');
    // })->name('course_check');

    //Sandy (2020/01/17)
    Route::get('course_check', 'Frontend\CourseCheckController@show')->name('course_check');
    Route::post('course_check_status', 'Backend\CourseCheckController@update_status');
    Route::post('course_check_data', 'Backend\CourseCheckController@update_data');
    // Route::post('dropdown_check', 'Backend\CourseCheckController@update_check');
    // Route::post('dropdown_absent', 'Backend\CourseCheckController@update_absent');
    // Route::post('dropdown_cancel', 'Backend\CourseCheckController@update_cancel');

    //Sandy (2020/02/05)
    Route::get('course_check_search', 'Frontend\CourseCheckController@search');


    /*** [課程管理] 回報表單 ***/
    Route::get('course_return', function () {
        return view('frontend.course_return');
    })->name('course_return');

// });


/*** [現場人員] 報到 ***/
Route::get('ots_check', function () {
    return view('frontend.ots_check');
})->name('ots_check');

Route::get('ots_course_today', function () {
    return view('frontend.ots_course_today');
})->name('ots_course_today');

Route::get('ots_return', function () {
    return view('frontend.ots_return');
})->name('ots_return');



/*
------------
|
| 學員管理 
|
------------
*/

// Route::get('student_list', function () {
//     return view('frontend.student_list');
// })->name('student_list');

/*** [學員管理] 學員列表 ***/
/* Rocky (2020/01/14) */
// Route::get('student_list', 'Frontend\StudentListController@show')->name('student_list');
Route::get('student', 'Frontend\StudentController@show')->name('student');

/*** [學員管理] 黑名單 ***/
Route::get('student_blacklist', function () {
    return view('frontend.student_blacklist');
})->name('student_blacklist');

/*** [學員管理] 細分組 ***/
Route::get('student_group', function () {
    return view('frontend.student_group');
})->name('student_group');

/*** [學員管理] 細分組編輯 ***/
Route::get('student_group_edit', function () {
    return view('frontend.student_group_edit');
})->name('student_group_edit');



/*
------------
|
| 財務管理
|
------------
*/
/*** [財務管理] ***/
Route::get('finance', function () {
    return view('frontend.finance');
})->name('finance');
/*** [財務管理] 查看報表 ***/
Route::get('finance_return', function () {
    return view('frontend.finance_return');
})->name('finance_return');


/*
------------
|
| 訊息推播
|
------------
*/
/*** [訊息推播] ***/
Route::get('message', function () {
    return view('frontend.message');
})->name('message');

/*** [訊息推播] 內容管理 ***/
Route::get('message_content', function () {
    return view('frontend.message_content');
})->name('message_content');

/*** [訊息推播] 推播排程 ***/
Route::get('message_schedule', function () {
    return view('frontend.message_schedule');
})->name('message_schedule');



/*
------------
|
| 數據報表
|
------------
*/
/*** [數據報表] ***/
Route::get('report', function () {
    return view('frontend.report');
})->name('report');




/*
------------
|
| 系統設定
|
------------
*/
/*** [系統設定] ***/
Route::get('system', function () {
    return view('frontend.system');
})->name('system');

/*** [系統設定] 權限管理 ***/
Route::get('authority', function () {
    return view('frontend.authority');
})->name('authority');