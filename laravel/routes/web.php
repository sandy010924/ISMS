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


/*** 登入 ***/
Route::get('/', function () {
    return view('frontend.login');
})->name('login');


/*** [課程管理] ***/
// Route::get('course', function () {
//     return view('frontend.course');
// })->name('course');

/* Sandy (2020/01/14) */
// Route::get('course', 'Frontend\CourseController@')->name('course');
// Route::get('course', function () {
//     return view('frontend.course');
// })->name('course');
Route::get('course', 'Frontend\CourseController@show')->name('course');
// Route::get('course_show', 'Frontend\CourseController@show');

/* Sandy(2020/01/31)*/
Route::get('course_search', 'Frontend\CourseController@search');

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
Route::get('course_apply','Frontend\CourseApplyController@show')->name('course_apply');
Route::post('course_apply', 'Backend\CourseApplyController@update');
// Sandy (2020/02/03)
Route::get('course_apply_search','Frontend\CourseApplyController@search');


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


/*** [課程管理] 今日課程 ***/
//Sandy (2020/01/17)
// Route::get('course_today', function () {
//     return view('frontend.course_today');
// })->name('course_today');
Route::get('course_today', 'Frontend\CourseTodayController@show')->name('course_today');


/*** [課程管理] 報到 ***/
// Route::get('course_check', function () {
//     return view('frontend.course_check');
// })->name('course_check');

//Sandy (2020/01/17)
Route::get('course_check','Frontend\CourseCheckController@show')->name('course_check');
Route::post('course_check', 'Backend\CourseCheckController@update');
Route::post('dropdown_check', 'Backend\CourseCheckController@update_check');
Route::post('dropdown_absent', 'Backend\CourseCheckController@update_absent');
Route::post('dropdown_cancel', 'Backend\CourseCheckController@update_cancel');


/*** [課程管理] 回報表單 ***/
Route::get('course_return', function () {
    return view('frontend.course_return');
})->name('course_return');


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


/*** 學員管理 ***/
// Route::get('student_list', function () {
//     return view('frontend.student_list');
// })->name('student_list');

/* Rocky (2020/01/14) */
Route::get('student_list', 'Frontend\StudentListController@show')->name('student_list');