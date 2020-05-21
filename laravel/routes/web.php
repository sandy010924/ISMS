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
|--------------------------------------------------------------------------
| 登入
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('frontend.login');
})->name('login');

/*** 登入 Rocky(2020/02/05) ***/
Route::post('login', 'Frontend\LoginController@login');
/*** 登出 Rocky(2020/02/16) ***/
Route::get('logout', 'Frontend\LoginController@logout')->name('logout');



/*
|--------------------------------------------------------------------------
| Error
|--------------------------------------------------------------------------
*/
/*** 權限不足頁面 ***/
Route::get('error_authority', function () {
    return view('frontend.error_authority');
})->name('error_authority');



/*
|--------------------------------------------------------------------------
| 課程管理
|--------------------------------------------------------------------------
*/

/*** [課程管理] ***/
/*** 顯示資料 ***/
Route::get('course', 'Frontend\CourseController@show')->name('course');
/*** 顯示資料 Sandy(2020/01/31) ***/
// Route::get('course_search', 'Frontend\CourseController@search');
/*** 刪除資料 Rocky(2020/02/11) ***/
Route::post('course_delete', 'Backend\CourseController@delete');
/*** 匯入表單 Rocky(2019/12/29) ***/
Route::post('course', 'Backend\CourseController@upload');
// Route::get('course', 'CourseController@uploadPage')->name('course');



/*** [課程管理]現場正課表單 ***/
/*** 顯示資料 ***/
Route::get('course_form', 'Frontend\CourseFormController@show')->name('course_form');
/*** 新增資料 Sandy(2020/02/28) ***/
Route::post('course_form_insert', 'Backend\CourseFormController@insert');
/*** 填入學員資料 Sandy(2020/03/04) ***/
Route::get('course_form_fill', 'Frontend\CourseFormController@fill');
// /*** joanna 後端下載電子簽章圖片 ***/
// Route::post('signature', 'Backend\CourseFormController@signature');


/*** [課程管理] 查詢名單 ***/
/*** 顯示資料 Sandy (2020/01/15) ***/
Route::get('course_apply', 'Frontend\CourseApplyController@show')->name('course_apply');
/*** 更新狀態 Sandy (2020/01/15) ***/
Route::post('course_apply', 'Backend\CourseApplyController@update');
/*** 搜尋資料 Sandy (2020/02/03) ***/
// Route::get('course_apply_search', 'Frontend\CourseApplyController@search');


/*** [課程管理] 進階填單名單 ***/
/*** 顯示資料 ***/
Route::get('course_advanced', function () {
    return view('frontend.course_advanced');
})->name('course_advanced');
/*** 新增資料 ***/
Route::get('course_advanced', 'Frontend\CourseAdvancedController@show')->name('course_advanced');
/*** 刪除資料 Sandy(2020/03/12) ***/
Route::post('course_advanced_delete', 'Backend\CourseAdvancedController@delete');


/*** [課程管理] 場次總覽 ***/
/*** 顯示資料 ***/
Route::get('course_list', 'Frontend\CourseListController@show')->name('course_list');
/*** 搜尋資料 Sandy(2020/02/25) ***/
// Route::get('course_list_search', 'Frontend\CourseListController@search');
/*** 刪除資料 Sandy(2020/02/25) ***/
Route::post('course_list_delete', 'Backend\CourseListController@delete');
/*** 新增課程 Sandy(2020/02/27) ***/
Route::post('course_list_insert', 'Backend\CourseListController@insert');


/*** [課程管理] 場次數據 ***/
// Route::get('course_list_data', function () {
//     return view('frontend.course_list_data');
// })->name('course_list_data');
/*** 顯示資料 ***/
Route::get('course_list_data', 'Frontend\CourseListDataController@show')->name('course_list_data');


/*** [課程管理] 報名名單 ***/
/*** 顯示資料 ***/
Route::get('course_list_apply', 'Frontend\CourseListApplyController@show')->name('course_list_apply');
/*** 刪除資料 ***/
Route::post('course_list_apply_delete', 'Backend\CourseListApplyController@delete');


/*** [課程管理] 退費名單 ***/
/*** 顯示資料 ***/
Route::get('course_list_refund', 'Frontend\CourseListRefundController@show')->name('course_list_refund');
/*** 顯示表單所選場次學員資料 ***/
Route::get('course_list_refund_form', 'Frontend\CourseListRefundController@form');
/*** 新增資料 ***/
Route::post('course_list_refund_insert', 'Backend\CourseListRefundController@insert');
/*** 刪除 ***/
Route::post('course_list_refund_delete', 'Backend\CourseListRefundController@delete');

/*** 退費表單 ***/
Route::get('refund_form', function () {
    return view('frontend.refund_form');
})->name('refund_form');

// Route::get('course_list_refund', function () {
//     return view('frontend.course_list_refund');
// })->name('course_list_refund');

// Route::get('course_list_view', function () {
//     return view('frontend.course_list_view');
// })->name('course_list_view');


/*** [課程管理] 完整內容 ***/
/*** 顯示資料 ***/
Route::get('course_list_chart', 'Frontend\CourseListChartController@show')->name('course_list_chart');


/*** [課程管理] 編輯 ***/
/*** 顯示資料 ***/
Route::get('course_list_edit', 'Frontend\CourseListEditController@show')->name('course_list_edit');
/*** 新增報名表 ***/
Route::post('course_list_edit_insert', 'Backend\CourseListEditController@insert');
/*** 更新場次 ***/
Route::post('course_list_edit_update', 'Backend\CourseListEditController@update');
/*** 更新資料 ***/
Route::post('course_list_edit_updatedata', 'Backend\CourseListEditController@update_data');



/*** [課程管理] 今日課程 ***/
/*** 顯示資料 Sandy(2020/01/17) ***/
Route::get('course_today', 'Frontend\CourseTodayController@show')->name('course_today');
/*** 搜尋資料 Sandy(2020/01/17) ***/
// Route::get('course_today_search', 'Frontend\CourseTodayController@search');


/*** [課程管理] 報到 ***/
/*** 顯示資料 Sandy(2020/01/17) ***/
Route::get('course_check', 'Frontend\CourseCheckController@show')->name('course_check');
/*** 搜尋資料 Sandy(2020/01/17) ***/
Route::get('course_check_search', 'Frontend\CourseCheckController@search');
/*** 現場報名 Sandy ***/
Route::post('course_check_insert', 'Backend\CourseCheckController@insert');
/*** 狀態修改 Sandy ***/
Route::post('course_check_status', 'Backend\CourseCheckController@update_status');
/*** 課程資訊修改 Sandy ***/
Route::post('course_check_data', 'Backend\CourseCheckController@update_data');


/*** [課程管理] 場次報表 ***/
/*** 顯示資料 Sandy(2020/01/17) ***/
Route::get('course_return', 'Frontend\CourseReturnController@show')->name('course_return');
/*** 更新資料 Sandy(2020/03/16) ***/
Route::post('course_return_update', 'Backend\CourseReturnController@update');
/*** 新增付款資料 Sandy(2020/03/16) ***/
Route::post('course_return_insert_payment', 'Backend\CourseReturnController@insert_payment');
/*** 刪除資料 Sandy(2020/03/16) ***/
Route::post('course_return_delete', 'Backend\CourseReturnController@delete');
/*** 新增報表資料 Sandy(2020/03/16) ***/
Route::post('course_return_insert_data', 'Backend\CourseReturnController@insert_data');
/*** 新增填入既有學員資料 Sandy(2020/03/29) ***/
Route::get('course_return_fill', 'Frontend\CourseReturnController@fill');
/*** 完款後寄送訊息 Sandy(2020/05/13) ***/
Route::post('course_return_sendmsg', 'Backend\CourseReturnController@sendmsg');



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
|--------------------------------------------------------------------------
| 學員管理
|--------------------------------------------------------------------------
*/


/*** [學員管理] ***/
/*** 顯示資料 Rocky(2020/02/23) ***/
Route::get('student', 'Frontend\StudentController@show')->name('student');
/*** 搜尋資料 Rocky(2020/02/23) ***/
Route::get('student_search', 'Frontend\StudentController@search')->name('student_search');
/*** 刪除資料 Rocky(2020/02/23) ***/
Route::get('student_delete', 'Backend\StudentController@delete');
/*** 加入黑名單 Rocky(2020/02/23) ***/
Route::get('student_addblacklist', 'Backend\StudentController@blacklist');
/*** 已填表單 Rocky(2020/02/28) ***/
Route::post('view_form', 'Frontend\StudentController@viewform');
/*** 已填表單-詳細資料 Rocky(2020/02/28) ***/
Route::post('view_form_detail', 'Frontend\StudentController@formdetail');
/*** 已填表單-詳細資料-自動儲存 Rocky(2020/05/21) ***/
Route::post('view_form_save', 'Backend\StudentController@viewformsave');
/*** 完整內容-基本資料 Rocky(2020/02/29) ***/
Route::post('course_data', 'Frontend\StudentController@coursedata');
/*** 完整內容-標記 - 顯示 Rocky(2020/03/10) ***/
Route::post('tag_show', 'Frontend\StudentController@tagshow');
/*** 完整內容-標記 - 新增 Rocky(2020/03/11) ***/
Route::post('tag_save', 'Backend\StudentController@tagsave');
/*** 完整內容-標記 - 刪除 Rocky(2020/03/12) ***/
Route::post('tag_delete', 'Backend\StudentController@tagdelete');
/*** 完整內容-聯絡狀況 Rocky(2020/03/01) ***/
Route::post('contact_data', 'Frontend\StudentController@contactdata');
/*** 完整內容-聯絡狀況-儲存 Rocky(2020/03/08) ***/
Route::post('debt_save', 'Backend\StudentController@debtsave');
/*** 完整內容-聯絡狀況-刪除 Rocky(2020/03/08) ***/
Route::post('debt_delete', 'Backend\StudentController@debtdelete');
/*** 完整內容-聯絡狀況-自動儲存 Rocky(2020/03/08) ***/
Route::post('contact_data_save', 'Backend\StudentController@updatedata');
/*** 完整內容-歷史互動 Rocky(2020/03/06) ***/
Route::post('history_data', 'Frontend\StudentController@historydata');
/*** 完整內容-儲存 Rocky(2020/03/07) ***/
Route::post('student_save', 'Backend\StudentController@save');
/*** 完整內容-聯絡狀況-刪除 Rocky(2020/04/21) ***/
Route::post('debt_show', 'Frontend\StudentController@debtshow');

/*** [學員管理] 黑名單 ***/
/*** 顯示資料 Rocky(2020/02/23) ***/
Route::get('student_blacklist', 'Frontend\BlacklistController@show')->name('student_blacklist');
/*** 搜尋資料 Rocky(2020/02/23) ***/
Route::get('blacklist_search', 'Frontend\BlacklistController@search')->name('blacklist_search');
/*** 取消黑名單 Rocky(2020/02/23) ***/
Route::get('blacklist_cancel', 'Backend\BlacklistController@cancel');
/*** 自動新增黑名單學員 Rocky(2020/02/23) ***/
Route::post('blacklist_add', 'Backend\BlacklistController@add');

/*** [學員管理] 細分組 ***/
/*** 顯示列表資料 Rocky(2020/03/19) ***/
Route::get('student_group', 'Frontend\StudentGroupController@showgroup')->name('student_group');
/*** 刪除列表資料 Rocky(2020/03/19) ***/
Route::post('group_delete', 'Backend\StudentGroupController@groupdelete');
/*** 複製列表資料 Rocky(2020/03/20) ***/
Route::post('group_copy', 'Backend\StudentGroupController@groupcopy');
/*** 顯示細分組條件 - 課程名稱 Rocky(2020/03/14) ***/
Route::post('show_requirement_course', 'Frontend\StudentGroupController@showrequirement');
/*** 搜尋學員 Rocky(2020/03/16) ***/
Route::post('search_students', 'Frontend\StudentGroupController@searchstudents');
/*** 儲存學員 Rocky(2020/03/19) ***/
Route::post('save', 'Backend\StudentGroupController@save');
/*** 更新學員 Rocky(2020/03/19) ***/
Route::post('studentgroup_update', 'Backend\StudentGroupController@update');

/*** [學員管理] 細分組新增 ***/
Route::get('student_group_add', function () {
    return view('frontend.student_group_add');
})->name('student_group_add');

/*** [學員管理] 細分組編輯 ***/
// Route::get('student_group_edit/{id}', 'Frontend\StudentGroupController@testshow')->name('student_group_edit');
/*** 顯示資料 ***/
Route::get('student_group_edit', 'Frontend\StudentGroupController@showeditdata')->name('student_group_edit');

// Route::get('student_group_edit', function () {
//     return view('frontend.student_group_edit');
// })->name('student_group_edit');

// Route::get('student_group_edit/{id}', function () {
//     return view('frontend.student_group_edit/{id}');
// })->name('student_group_edit');


/*
------------
|
| 財務管理
|
------------
*/
/*** [財務管理] ***/
/*** 場次 - 顯示場次資料 Rocky(2020/04/25) ***/
Route::get('finance', 'Frontend\FinanceController@show')->name('finance');
/*** 場次 - 顯示學員資料 Rocky(2020/04/25) ***/
Route::post('show_student', 'Frontend\FinanceController@showstudent');
/*** 場次 - 自動儲存 Rocky(2020/04/25) ***/
Route::post('events_update', 'Backend\FinanceController@eventsupdate');
/*** 場次 - 發票自動儲存 Rocky(2020/04/25) ***/
Route::post('invoice_update', 'Backend\FinanceController@invoiceupdate');
/*** 獎金 - 儲存 Rocky(2020/04/26) ***/
Route::post('add_bonus', 'Backend\FinanceController@addbonus');


/*** 獎金名單 - 顯示資料 Rocky(2020/04/26) ***/
Route::get('bonus', 'Frontend\FinanceController@showbonus')->name('bonus');
/*** 獎金名單 - 顯示資料規則 Rocky(2020/04/26) ***/
Route::post('show_bonusrule', 'Frontend\FinanceController@showbonusrule');
/*** 獎金名單 - 刪除 Rocky(2020/04/26) ***/
Route::post('delete_bonus', 'Backend\FinanceController@deletebonus');
/*** 獎金名單 - 更新 Rocky(2020/04/26) ***/
Route::post('update_bonus', 'Backend\FinanceController@updatebonus');
/*** 獎金名單 - 完整內容 Rocky(2020/04/26) ***/
Route::get('show_bonus_detail', 'Frontend\FinanceController@showeditdata')->name('show_bonus_detail');
/*** 獎金名單 - 完整內容 Rocky(2020/04/27) ***/
Route::post('show_bonus_student', 'Frontend\FinanceController@showbonusstudent');
/*** 獎金名單 - 完整內容 Rocky(2020/04/27) ***/
Route::post('regi_memo_update', 'Backend\FinanceController@regimemoupdate');

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
Route::get('message', 'Frontend\MessageController@show')->name('message');

/*** [立即傳送] ***/
Route::post('message_insert', 'Backend\MessageController@insert');

/*** [儲存草稿] ***/
Route::post('draftInsert', 'Backend\MessageController@insert_draft');

/*** [排程設定] ***/
Route::post('scheduleInsert', 'Backend\MessageController@insert_schedule');

/*** [訊息推播] 撈出細分組資料 ***/
Route::post('messageDetailGroup', 'Backend\MessageController@showDetailGroup')->name('messageDetailGroup');

/*** [訊息推播] 訊息列表 ***/
Route::get('message_list', 'Frontend\MessageListController@show')->name('message_list');

/*** [訊息推播] 刪除訊息 ***/
Route::post('message_list_cancel', 'Backend\MessageListController@cancel');

/*** [訊息推播] 刪除訊息 ***/
Route::post('message_list_delete', 'Backend\MessageListController@delete');


/*** [訊息推播] 詳細內容 ***/
// Route::get('message_data', function () {
//     return view('frontend.message_data');
// })->name('message_data');
Route::get('message_data', 'Frontend\MessageDataController@show')->name('message_data');

/*** [訊息推播] 推播成本***/
// Route::get('message_cost', function () {
//     return view('frontend.message_cost');
// })->name('message_cost');

/*** [訊息推播] 推播成效***/
// Route::get('message_result', function () {
//     return view('frontend.message_result');
// })->name('message_result');
Route::get('message_result', 'Frontend\MessageResultController@show')->name('message_result');

/*** [訊息推播] 單筆簡訊API***/
Route::post('messageApi', 'Backend\MessageController@messageApi');

/*** [訊息推播] 多筆簡訊API***/
Route::post('messageBulkApi', 'Backend\MessageController@messageBulkApi');

/*** [自動訊息] 場次選擇 ***/
Route::get('message_form', 'Frontend\MessageFormController@show')->name('message_form');

/*** [自動訊息] 場次選擇 ***/
Route::post('message_form_apply', 'Backend\MessageFormController@update');

/*** [自動訊息] 場次選擇成功 ***/
Route::get('message_form_success', function () {
    return view('frontend.message_form_success');
})->name('message_form_success');

/*** [自動訊息] 場次選擇失敗 ***/
Route::get('message_form_error', function () {
    return view('frontend.message_form_error');
})->name('message_form_error');




/*
------------
|
| 數據報表
|
------------
*/
/*** [數據報表] ***/
Route::get('report', 'Frontend\ReportController@show')->name('report');

/*** [查詢報表] ***/
Route::get('report_search', 'Frontend\ReportController@search');
// /*** [數據報表] 場次數據 ***/
// Route::get('report_data', function () {
//     return view('frontend.report_data');
// })->name('report_data');

// /*** [數據報表] 完整內容 ***/
// Route::get('report_chart', function () {
//     return view('frontend.report_chart');
// })->name('report_chart');




/*
------------
|
| 系統設定
|
------------
*/
/*** [系統設定] ***/
// Route::get('system', function () {
//     return view('frontend.system');
// })->name('system');

/*
|--------------------------------------------------------------------------
| 權限管理
|--------------------------------------------------------------------------
*/
/*** 顯示資料 Rocky(2020/02/17) ***/
Route::get('authority', 'Frontend\AuthorityController@show')->name('authority');
/*** 搜尋資料 Rocky(2020/02/17) ***/
// Route::get('authority_search', 'Frontend\AuthorityController@search');
/*** 更新資料 Rocky(2020/02/17) ***/
Route::post('authority_update', 'Backend\AuthorityController@update');
/*** 新增資料 Rocky(2020/02/17) ***/
Route::post('authority_insert', 'Backend\AuthorityController@insert');
/*** 刪除資料 Rocky(2020/02/17) ***/
Route::post('authority_delete', 'Backend\AuthorityController@delete');
/*** 測試email Rocky(2020/05/11) ***/
Route::post('authority_email', 'Backend\AuthorityController@email');

/*** 顯示講師資料 Rocky(2020/05/01) ***/
Route::post('show_teacher', 'Frontend\AuthorityController@showteacher');
/*** 顯示修改資料 Rocky(2020/05/01) ***/
Route::post('show_edite', 'Frontend\AuthorityController@showedite');

/*
|--------------------------------------------------------------------------
| 黑名單規則
|--------------------------------------------------------------------------
*/
Route::get('blacklist_rule', function () {
    return view('frontend.blacklist_rule');
})->name('blacklist_rule');
/*** 顯示資料 Rocky(2020/03/01) ***/
Route::post('blacklist_rule', 'Frontend\BlacklistRuleController@show');
/*** 更新資料 Rocky(2020/03/01) ***/
Route::post('blacklist_rule_update', 'Backend\BlacklistRuleController@update');


/*
|--------------------------------------------------------------------------
| 資料備份
|--------------------------------------------------------------------------
*/
// Route::get('blacklist_rule', function () {
//     return view('frontend.blacklist_rule');
// })->name('blacklist_rule');
// /*** 顯示資料 Rocky(2020/03/01) ***/
// Route::post('blacklist_rule', 'Frontend\BlacklistRuleController@show');
// /*** 更新資料 Rocky(2020/03/01) ***/
// Route::post('blacklist_rule_update', 'Backend\BlacklistRuleController@update');

/*** 顯示資料 Rocky(2020/04/10) ***/
Route::get('database', 'Frontend\DatabaseController@show')->name('database');
/*** 資料還原 Rocky(2020/04/10) ***/
Route::post('database_recover', 'Frontend\DatabaseController@recover');

/*** 資料還原 Rocky(2020/04/10) ***/
Route::post('database_backup', 'Frontend\DatabaseController@backup');

/*** 資料刪除 Rocky(2020/05/06) ***/
Route::post('database_delete', 'Frontend\DatabaseController@delete');

/*
------------
|
| mail server
|
------------
*/
// Route::get('sendmail', function() {
//     $data = ['name' => 'Test'];
//     Mail::send('email.welcome', $data, function($message) {
//         $message->to('your@email')->subject('This is test email');
//     });
//     return 'Your email has been sent successfully!';
// });


Route::post('/sendMail', 'Backend\MessageController@sendMail');
