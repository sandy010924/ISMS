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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('frontend.login');
})->name('login');

/*** 課程管理 ***/
Route::get('course', function () {
    return view('frontend.course');
})->name('course');

Route::get('course_form', function () {
    return view('frontend.course_form');
})->name('course_form');

Route::get('course_apply', function () {
    return view('frontend.course_apply');
})->name('course_apply');

Route::get('course_list', function () {
    return view('frontend.course_list');
})->name('course_list');

Route::get('course_list_data', function () {
    return view('frontend.course_list_data');
})->name('course_list_data');

Route::get('course_list_view', function () {
    return view('frontend.course_list_view');
})->name('course_list_view');

Route::get('course_list_chart', function () {
    return view('frontend.course_list_chart');
})->name('course_list_chart');

Route::get('course_today', function () {
    return view('frontend.course_today');
})->name('course_today');

Route::get('course_return', function () {
    return view('frontend.course_return');
})->name('course_return');

Route::get('course_check', function () {
    return view('frontend.course_check');
})->name('course_check');

/*** 現場人員報名 ***/
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
Route::get('student_list', function () {
    return view('frontend.student_list');
})->name('student_list');