@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '學員管理')

@section('content')
<link href="{{ asset('css/bootstrap-tagsinput.css') }}" rel="stylesheet">
<style>
  input:read-only {
    background-color: #e0e0e0 !important;
  }

  .show_datetime .bootstrap-datetimepicker-widget {
    position: relative;
    z-index: 1000;
    top: 0 !important;
  }

  .show_select select {
    width: 400px;
    text-align: center;
  }

  .show_select select .lt {
    text-align: center;
  }

  .loading_title {
    color: white;
    font-size: 35px;
    font-weight: bold;
    text-align: center;
    padding-top: 3%;
    padding-bottom: 3%;
  }
</style>
<!-- Content Start -->
<!--搜尋學員頁面內容-->
<div class="card m-3">
  <!-- 權限 Rocky(2020/05/10) -->
  <input type="hidden" id="auth_role" value="{{ Auth::user()}}" />
  <div class="card-body">
    <div class="modal fade" id="myModal" style="overflow: hidden;">
      <div class="modal-dialog modal-lg">
        <h2 class="loading_title">資料匯出中...</h2>
        <img id="loading_img" src="../public/img/lo_1.gif" />
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-4"></div>
      <div class="col-3">
        <input type="search" class="form-control" placeholder="輸入電話 / email / 姓名" aria-label="Student's Phone or Email" id="search_input">
      </div>
      <div class="col-4">
        <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
        <button class="btn buttons-excel buttons-html5" type="button" id="btn_excel" onclick="export_excel();">匯出學員詳細資料</button>
      </div>
    </div>
    <div class="table-responsive">
      <table id="tableExcel" width="100%" border="1" cellspacing="0" cellpadding="0" style="display:none">
        <thead>
          <th>姓名</th>
          <th>Email</th>
          <th>電話</th>
          <th>職業</th>
          <th>居住地址</th>
          <th>加入日期</th>
          <th>原始來源</th>
          <th>最新來源</th>
          <th>想了解的內容</th>
          <th>正課報名場次</th>
          <th>銷講報名場次</th>
          <th>銷講後報名狀況</th>
          <th>參與活動</th>
          <th>退款</th>
          <th>銷講報名次數</th>
          <th>銷講報到率</th>
          <th>銷講取消次數</th>
          <th>銷講取消率</th>
        </thead>
        <tbody id="tbody_student_detail"></tbody>
      </table>
      @component('components.datatable')
      @slot('thead')
      <tr>
        <th>姓名</th>
        <th>聯絡電話</th>
        <th>電子郵件</th>
        <th>來源</th>
        <th></th>
        <th>id</th>
      </tr>
      @endslot
      @slot('tbody')
      @foreach($students as $student)
      <tr>
        <td class="align-middle">{{ $student['name'] }}</td>
        <td class="align-middle">{{ $student['phone'] }}</td>
        <td class="align-middle">{{ $student['email'] }}</td>
        @if ($student['datasource'] == '')
        <td class="align-middle">無</td>
        @else
        <td class="align-middle">{{ $student['datasource']}}</td>
        @endif
        <td class="align-middle">
          <button type="button" class="btn btn-primary btn-sm mx-1" data-toggle="modal" onclick="course_data({{ $student['id'] }});">完整內容</button>

          @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'saleser' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'officestaff' ) )
          @if ($student['check_blacklist'] == '1')
          <button type="button" disabled id="{{ $student['id'] }}" class="btn btn-success btn-sm mx-1" data-toggle="modal" onclick="btn_blacklist({{ $student['id'] }});" value="{{ $student['id'] }}">已加入黑名單</button>
          @else
          <button type="button" id="{{ $student['id'] }}" class="btn btn-dark btn-sm mx-1" data-toggle="modal" onclick="btn_blacklist({{ $student['id'] }});" value="{{ $student['id'] }}"><i class="fa fa-bug"></i>列入黑名單</button>
          @endif

          @endif
          <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" onclick="view_form({{ $student['id'] }});">已填表單</button>
          @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'saleser' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'officestaff'))
          <button id="{{ $student['id'] }}" class="btn btn-danger btn-sm mx-1" onclick="btn_delete({{ $student['id'] }},0,this);" value="{{ $student['id'] }}">刪除</button>
          @endif
        </td>
        <td class="align-middle">{{ $student['id'] }}</td>
      </tr>
      @endforeach
      @endslot
      @endcomponent
    </div>

    <!-- 已填表單 -->
    <div class="modal fade bd-example-modal-lg" id="form_finished" tabindex="-1" role="dialog" aria-labelledby="save_newgroupTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">已填報名表</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-4">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                </div>
              </div>
              <div class="col-8">
                <div class="tab-content" id="v-pills-tabContent">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- 已填表單 -->
    <!-- 完整內容 - S -->
    <div class="modal fade bd-example-modal-xl text-left" id="student_information" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content p-3">
          <div class="row">
            <div class="pt-2 pl-3">
              <h3>完整內容</h3>
            </div>
            <div class="col-12 pt-5">
              <div class="row">
                <div class="col-4">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">學員姓名</span>
                    </div>
                    <input type="text" id="student_name" class="form-control bg-white basic-inf col-sm-10 auth_readonly">
                  </div>
                </div>
                <div class="col-4">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">E-mail</span>
                    </div>
                    <input type="text" id="student_email" class="form-control bg-white basic-inf col-sm-8 auth_readonly">
                  </div>
                </div>
                <div class="col-4">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">電話</span>
                    </div>
                    <input id="student_phone" type="text" class="form-control bg-white basic-inf auth_readonly" aria-label="# input" aria-describedby="#">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4 py-3">
              <h7 id="title_old_datasource"></h7><br>
              <h7 id="submissiondate"></h7><br>
              <h7 id="student_datasource"></h7>
            </div>
          </div>
          <!-- 標記 -S  -->
          <div class="row">
            <div class="col-12 py-2">
              <h6>標記 :
                @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'officestaff' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'saleser'))
                <i class="fa fa-plus" aria-hidden="true" style="cursor:pointer;" id="new_tag" data-toggle="modal" data-target="#save_tag"></i>
                @endif
              </h6>
              <input type="text" id="isms_tags" />
            </div>
            <div class="col-5">
            </div>
            <div class="col-4 align-right">
              @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'officestaff' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'saleser'))
              <button type="button" class="btn btn-primary float-right" onclick="btn_delete('','1',this);">刪除聯絡人</button>
              @endif
            </div>
          </div>
          <div class="modal fade" id="save_tag" tabindex="-1" role="dialog" aria-labelledby="save_tagTitle" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">標記名稱</h5>
                  <button type="button" class="close" id="tag_close" aria-label="Close" data-number="1">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="text" id="tag_name" class="input_width">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" onclick="tags_add();">儲存</button>
                </div>
              </div>
            </div>
          </div>
          <!-- 標記 -E -->
          <!-- tab - S -->
          <ul class="nav nav-tabs pb-3" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic_data" role="tab" aria-controls="basic_data" aria-selected="true">基本訊息</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="history-tab" data-toggle="tab" href="#history_data" role="tab" aria-controls="history_data" aria-selected="false" onclick="history_data();">歷史互動</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact_data" role="tab" aria-controls="contact_data" aria-selected="false" onclick="contact_data();">聯絡狀況</a>
            </li>
          </ul>
          <!-- tab - E -->
          <!-- 完整內容 - S -->
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active p-3" id="basic_data" role="tabpanel" aria-labelledby="basic-tab">
              <div class="row">
                <div class="col-6">
                  <div class="row">
                    <div class="col-4">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">最新來源</span>
                        </div>
                        <input type="text" name="new_datasource" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">職業</span>
                        </div>
                        <input id="student_profession" type="text" class="form-control bg-white basic-inf auth_readonly" aria-label="# input" aria-describedby="#">
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">原始來源</span>
                        </div>
                        <input type="text" id="old_datasource" class="form-control bg-white basic-inf auth_readonly" aria-label="# input" aria-describedby="#">
                        <input type="hidden" id="sales_registration_old">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">正課報名場次</span>
                        </div>
                        <input type="text" name="course_events" class="form-control bg-white basic-inf demo2" aria-label="# input" aria-describedby="#" data-placement="bottom" data-html="true" title="" readonly>
                      </div>

                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text ">銷講報名場次</span>
                    </div>
                    <input type="text" name="course_sales_events" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">想了解的內容</span>
                    </div>
                    <input type="text" name="course_content" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">銷講後報名狀況</span>
                    </div>
                    <input type="text" name="course_sales_status" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">居住地址</span>
                    </div>
                    <input type="text" id="student_address" class="form-control bg-white basic-inf auth_readonly" aria-label="# input" aria-describedby="#">
                  </div>
                </div>
                <div class="col-6">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">參與活動</span>
                    </div>
                    <input type="text" id="activity_data" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" data-placement="bottom" data-html="true" readonly>
                    <!-- <input type="text" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" data-placement="bottom" data-html="true" title="參與活動 : 參與次數 : 參與度 : " readonly> -->
                  </div>
                  <div class="input-group mb-3" id="dev_refund">
                    <div class="input-group-prepend">
                      <span class="input-group-text bg-danger text-white">退款</span>
                    </div>
                    <input type="text" name="course_refund" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                  </div>
                  @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'officestaff' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'saleser'))
                  <button type="button" class="btn btn-primary float-right" id="save-inf" style="display:block;" onclick="save();">儲存</button>
                  @endif
                  <!-- <button type="button" class="btn btn-primary float-right" id="update-inf" style="display:block;">修改資料</button> -->
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <h7 name="count_sales_ok"></h7>
                </div>
                <div class="col-3">
                  <h7 name="sales_successful_rate"> </h7>
                </div>
                <div class="col-3">
                  <h7 name="count_sales_no"></h7>
                </div>
                <div class="col-3">
                  <h7 name="sales_cancel_rate"></h7>
                </div>
              </div>
            </div>
            <!-- 歷史互動 -->
            <div class="tab-pane fade" id="history_data" role="tabpanel" aria-labelledby="history-tab">
              <div class="table-responsive">
                @component('components.datatable_history')
                @slot('thead')
                <tr>
                  <th>時間</th>
                  <th>來源</th>
                  <th>動作</th>
                  <th>內容</th>
                </tr>
                @endslot
                @slot('tbody')
                @endslot
                @endcomponent
                <!-- </table> -->
              </div>
            </div>
            <!-- 歷史互動 -->

            <!-- 聯絡狀況 -->
            <div class="tab-pane fade" id="contact_data" role="tabpanel" aria-labelledby="contact-tab">
              <div class="table-responsive">
                <table class="table table-striped table-sm text-center">
                  <thead>
                    <tr>
                      <th class="text-nowrap">
                        <button type="button" class="btn btn-secondary btn-sm mx-1 auth_hidden" data-toggle="modal" data-target="#save_contact"><i class="fa fa-plus" aria-hidden="true"></i></button>
                      </th>
                      <th class="text-nowrap"></th>
                      <th class="text-nowrap">日期</th>
                      <th class="text-nowrap">追單課程</th>
                      <th class="text-nowrap">付款狀態/日期</th>
                      <th class="text-nowrap">聯絡內容</th>
                      <th class="text-nowrap">付款狀態</th>
                      <th class="text-nowrap">最新狀態</th>
                      <th class="text-nowrap">追單人員</th>
                      <th class="text-nowrap">設提醒</th>
                    </tr>
                  </thead>
                  <tbody id="contact_data_detail">
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal fade" id="save_contact" tabindex="-1" role="dialog" aria-labelledby="save_tagTitle" aria-hidden="true" data-backdrop="static">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">新增聯絡狀況</h5>
                    <button type="button" class="close" id="contact_close" aria-label="Close" data-number="1">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="form_debt">
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">日期:</label>
                        <div class="input-group date" data-target-input="nearest">
                          <input type="text" id="debt_date" name="debt_date" class="form-control datetimepicker-input" data-target="#debt_date" placeholder="日期" data-toggle="datetimepicker" autocomplete="off">
                          <div class="input-group-append" data-target="#debt_date" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">追單課程:</label>
                        <input type="text" id="debt_course" class="form-control" placeholder="請輸入追單課程" value="" class="border-0 bg-transparent input_width" required>
                      </div>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">付款狀態 / 日期:</label>
                        <input type="text" id="debt_status_date" class="form-control" placeholder="請輸入付款狀態 / 日期" value="" class="border-0 bg-transparent input_width">
                      </div>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">聯絡內容:</label>
                        <input type="text" id="debt_contact" class="form-control" value="" placeholder="請輸入聯絡內容" class="border-0 bg-transparent input_width">
                      </div>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">付款狀態:</label>
                        <select id="debt_status_payment_name" class="form-control custom-select border-0 bg-transparent input_width">
                          <option selected="" disabled="" value=""></option>
                          <option value="留單">留單</option>
                          <option value="完款">完款</option>
                          <option value="付訂">付訂</option>
                          <option value="退費">退費</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">最新狀態:</label>
                        <select id="debt_status" class="form-control custom-select border-0 bg-transparent input_width">
                          <option selected="" disabled="" value=""></option>
                          <option value="12">待追</option>
                          <option value="15">無意願</option>
                          <option value="16">推薦其他講師</option>
                          <option value="22">通知下一梯次</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">追單人員:</label>
                        <input type="text" id="debt_person" class="form-control" placeholder="請輸入追單人員" value="" class="border-0 bg-transparent input_width" required>
                      </div>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">設提醒:</label>
                        <div class="input-group date" data-target-input="nearest">
                          <input type="text" id="debt_remind" name="debt_remind" class="form-control datetimepicker-input datepicker" data-target="#debt_remind" data-toggle="datetimepicker" autocomplete="off">
                          <div class="input-group-append" data-target="#debt_remind" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" id="btnSubmit" class="btn btn-primary" onclick="debt_add();">儲存</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal fade" id="show_contact" tabindex="-1" role="dialog" aria-labelledby="save_tagTitle" aria-hidden="true" data-backdrop="static">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">顯示聯絡狀況</h5>
                    <button type="button" class="close" id="show_contact_close" aria-label="Close" data-number="1">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">日期:</label>
                      <label id="lbl_debt_date"></label>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">追單課程:</label>
                      <label id="lbl_debt_course"></label>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">付款狀態 / 日期:</label>
                      <label id="lbl_debt_status_date"></label>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">聯絡內容:</label>
                      <label id="lbl_debt_contact"></label>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">付款狀態:</label>
                      <label id="status_payment_name"></label>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">最新狀態:</label>
                      <label id="lbl_debt_status"></label>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">追單人員:</label>
                      <label id="lbl_debt_person"></label>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">設提醒:</label>
                      <label id="lbl_debt_remind"></label>
                      <!-- <div class="input-group date" data-target-input="nearest">
                        <input type="text" id="debt_remind" name="debt_remind" class="form-control datetimepicker-input datepicker" data-target="#debt_remind">
                        <div class="input-group-append" data-target="#debt_remind" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i>
                          </div>
                        </div>
                      </div> -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- 聯絡狀況 -->
              <!-- 完整內容 - E -->
            </div>
          </div>
        </div>
        <!-- 完整內容 - E -->
      </div>
    </div>
    <!-- 列入黑名單 - S -->
    <div class="modal fade" id="save_blacklist" tabindex="-1" role="dialog" aria-labelledby="save_tagTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">加入黑名單原因</h5>
            <button type="button" class="close" id="blacklist_close" aria-label="Close" data-number="1">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="text" id="blacklist_reason" class="input_width">
          </div>
          <div class="modal-footer">
            <button type="button" id="blacklist_add" class="btn btn-primary" onclick="add_blacklist();">儲存</button>
          </div>
        </div>
      </div>
    </div>
    <!-- 列入黑名單 - E -->
    <!-- alert Start-->
    <div class="alert alert-success alert-dismissible m-3 position-fixed fixed-bottom" role="alert" id="success_alert">
      <span id="success_alert_text"></span>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="alert alert-danger alert-dismissible m-3 position-fixed fixed-bottom" role="alert" id="error_alert">
      <span id="error_alert_text"></span>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <!-- alert End -->


    <!-- Content End -->
    <script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-tagsinput-angular.min.js') }}"></script>
    <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

    <script>
      var id_student_old = '';
      var elt = $('#isms_tags');
      var table, table2;

      // 搜尋 Rocky(2020/03/27)
      // $.fn.dataTable.ext.search.push(
      //   function(settings, data, dataIndex) {
      //     var keyword = $('#search_input').val();
      //     var phone = data[1];
      //     var email = data[2];

      //     if ((isNaN(keyword)) || (phone.includes(keyword)) || (email.includes(keyword))) {
      //       return true;
      //     }
      //     return false;
      //   }
      // );
      $("#btn_search").click(function() {

        // 宣告
        var role = '',
          btn_blacklist = '',
          btn_delete = ''
        role = JSON.parse($('#auth_role').val())['role']

        var today = moment(new Date()).format("YYYYMMDD");
        var title = today + '_學員管理';

        // 修改搜尋方式 Rocky (2020/06/11)
        table.clear().draw();
        table.destroy();

        table = $('#table_list').DataTable({
          // "dom": '<l<t>p>',
          "dom": '<Bl<td>tp>',
          "columnDefs": [{
              "targets": 'no-sort',
              "orderable": false,
            },
            {
              "targets": [5],
              "visible": false
            }
          ],
          "deferRender": true,
          "orderCellsTop": true,
          "destroy": true,
          "retrieve": true,
          "autoWidth": false,
          buttons: [{
            extend: 'excel',
            text: '匯出學員基本資料',
            // messageTop: '學員管理',
            exportOptions: {
              columns: [0, 1, 2]
            },
            title: title
          }],
          "ajax": {
            "url": "student_search",
            "type": "POST",
            "data": {
              search_data: $('#search_input').val()
            },
            async: false,
            "dataSrc": function(json) {
              for (var i = 0, ien = json.length; i < ien; i++) {

                var datasource = '無'

                // 權限判斷 - 黑名單按鈕 / 刪除按鈕
                if (role == "admin" || role == "marketer" || role == "officestaff" || role == "msaleser" || role == "saleser") {

                  if (json[i]['check_blacklist'] == '1') {
                    btn_blacklist = '<button type="button"  disabled id="' + json[i]['id'] + '" class="btn btn-success btn-sm mx-1" data-toggle="modal" onclick="btn_blacklist(' + json[i]['id'] + ');" value="' + json[i]['id'] + '">已加入黑名單</button> '
                  } else {
                    btn_blacklist = '<button type="button" id="' + json[i]['id'] + '" class="btn btn-dark btn-sm mx-1" data-toggle="modal" onclick="btn_blacklist(' + json[i]['id'] + ');" value="' + json[i]['id'] + '"><i class="fa fa-bug"></i>列入黑名單</button> '
                  }


                  btn_delete = '<button id="' + json[i]['id'] + '" class="btn btn-danger btn-sm mx-1" onclick="btn_delete(' + json[i]['id'] + ',0,this);" value="' + json[i]['id'] + '">刪除</button> '
                }

                if (json[i]['datasource'] != null) {
                  if (json[i]['datasource']['datasource'] != null) {
                    datasource = json[i]['datasource']['datasource'];
                  }
                }

                json[i][0] = json[i]['name'];
                json[i][1] = json[i]['phone'];
                json[i][2] = json[i]['email'];
                json[i][3] = datasource;
                json[i][4] = '<button type="button" class="btn btn-primary btn-sm mx-1" data-toggle="modal" onclick="course_data(' + json[i]['id'] + ');">完整內容</button> ' +
                  btn_blacklist +
                  ' <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" onclick="view_form(' + json[i]['id'] + ');">已填表單</button> ' +
                  btn_delete
                json[i][5] = json[i]['id'];
              }
              return json;

            }
          }
        });
      });



      $("document").ready(function() {
        var today = moment(new Date()).format("YYYYMMDD");
        var title = today + '_學員管理';

        //日期選擇器
        $('#debt_date').datetimepicker({
          format: 'YYYY-MM-DD'
        });

        $('#debt_remind').datetimepicker({
          format: 'YYYY-MM-DD'
        });

        // Rocky (2020/03/27)
        table = $('#table_list').DataTable({
          // "dom": '<l<t>p>',
          "dom": '<Bl<td>tp>',
          "columnDefs": [{
              "targets": 'no-sort',
              "orderable": false,
            },
            {
              "targets": [5],
              "visible": false
            }
          ],
          "destroy": true,
          "retrieve": true,
          "autoWidth": false,
          buttons: [{
            extend: 'excel',
            text: '匯出學員基本資料',
            // messageTop: '學員管理',
            exportOptions: {
              columns: [0, 1, 2]
            },
            title: title
          }],
        });



        // // Rocky (2020/03/27)
        //     table = $('#table_list').DataTable({
        //       "dom": '<Bl<td>tp>',
        //       "columnDefs": [{
        //         "targets": 'no-sort',
        //         "orderable": false,
        //       }],

        //       "destroy": true,
        //       "retrieve": true,
        //       buttons: [{
        //         extend: 'excel',
        //         text: '匯出Excel',
        //         messageTop: '黑名單',
        //         exportOptions: {
        //           columns: [0, 1, 2, 3]
        //         }
        //       }],
        //       // "ordering": false,
        //     });

        // Rocky (2020/04/17)
        // table2 = $('#table_list_history').DataTable({
        //   "dom": '<l<t>p>',
        //   "columnDefs": [{
        //     "targets": 'no-sort',
        //     "orderable": false,
        //   }],
        //   "orderCellsTop": true,
        //   "destroy": true,
        //   "retrieve": true,
        // });
        table2 = $('#table_list_history').DataTable();

        $(".demo2").tooltip();

        // 學員管理搜尋 (只能輸入數字、字母、_、.、@)
        $('#search_input').on('blur', function() {
          // console.log(`search_input: ${$(this).val()}`);
        });

        // 權限判斷 Rocky(2020/05/10)
        check_auth();
      });


      /*匯出Excel Rocky(2020/08/03)*/

      // 隱藏Loading視窗
      function hide_popup() {
        $('#myModal').modal('hide');
      };

      function ajax_excel(array_sid, type) {
        var defer = $.Deferred();
        var data_student_detail = '',
          id_student = ''
        $.each(array_sid, function(index, val) {
          $('#tbody_student_detail').html('');
          if (type == 0) {
            // 有搜尋
            id_student = array_sid[index]
          } else if (type == 1) {
            // 沒搜尋
            id_student = array_sid[index]['id']
          }
          // console.log(id_student)
          $.ajax({
            type: 'POST',
            url: 'course_data',
            dataType: 'json',
            data: {
              id_student: id_student
            },
            async: false,
            success: function(data) {
              // console.log(data)
              // if (index == 3) {
              //   $("#loading_img").attr("src", "../public/img/lo_2.gif");
              // }
              // if (index == 700) {
              //   $("#loading_img").attr("src", "../public/img/lo_3.gif");
              // }
              // if (index == 1400) {
              //   $("#loading_img").attr("src", "../public/img/lo_4.gif");
              // }
              // if (index == 2000) {
              //   $("#loading_img").attr("src", "../public/img/lo_1.gif");
              // }
              // 宣告
              var datasource_old = '',
                submissiondate = '',
                address = '無',
                course_content = '無'

              // 銷講報到率
              var sales_successful_rate = '0',
                course_cancel_rate = '0';
              var course_sales_status = '無',
                course_sales_events = '';

              var count_sales_ok = '',
                sales_successful_rate2 = '',
                course_cancel_rate = '',
                count_sales_no = '';

              if (data['datas_student'][0]['address'] != null) {
                address = data['datas_student'][0]['address']
              }

              if (data['datas_salesregistration'] != null && data['datas_salesregistration']['count_sales_ok'] != 0) {
                sales_successful_rate = (data['datas_salesregistration']['count_sales_ok'] / (data['datas_salesregistration']['count_sales'] - data['datas_salesregistration']['count_sales_no']) * 100).toFixed(0)
              }

              // 銷講取消率
              if (data['datas_salesregistration'] != null && data['count_sales_no'] != 0) {
                course_cancel_rate = (data['datas_salesregistration']['count_sales_no'] / data['datas_salesregistration']['count_sales'] * 100).toFixed(0)
              }

              // 來源
              if (data['datas_datasource_old'] != null) {
                // 原始來源
                if (data['datas_datasource_old']['datasource'] != null) {
                  datasource_old = data['datas_datasource_old']['datasource']
                } else {
                  datasource_old = "無"
                }

                // submissiondate
                submissiondate = data['datas_datasource_old']['sales_registration_old_submissiondate']

              } else {
                datasource_old = "無"
                submissiondate = "無"
              }

              // 最新來源
              var new_datasource = '無'

              if (data['datas_datasource_new'] != null && data['datas_datasource_new']['datasource'] != null) {
                new_datasource = data['datas_datasource_new']['datasource']
              }

              // 銷講
              if (data['datas_salesregistration'] != null) {

                if (data['datas_salesregistration']['course_content'] != null) {
                  course_content = data['datas_salesregistration']['course_content']
                }
                if (data['datas_salesregistration']['course_sales'] != null) {
                  var course_sales = '',
                    course_sales_events = '',
                    sales_registration_course_start_at = ''
                  if (data['datas_salesregistration']['course_sales'] == null) {
                    course_sales = " "
                  } else {
                    course_sales = data['datas_salesregistration']['course_sales']
                  }

                  if (data['datas_salesregistration']['course_sales_events'] == null) {
                    course_sales_events = " "
                  } else {
                    course_sales_events = data['datas_salesregistration']['course_sales_events']
                  }

                  if (data['datas_salesregistration']['sales_registration_course_start_at'] == null) {
                    // 我很遺憾
                    if (data['datas_salesregistration']['id_events'] == '-99' || data['datas_salesregistration']['events'] != '') {
                      sales_registration_course_start_at = "我很遺憾 - " + data['datas_salesregistration']['events']
                    } else {
                      sales_registration_course_start_at = "無"
                    }

                  } else {
                    sales_registration_course_start_at = data['datas_salesregistration']['sales_registration_course_start_at']
                  }

                  course_sales_events = course_sales + ' ' + course_sales_events + '(' + sales_registration_course_start_at + ' )'
                }

                if (data['datas_registration'] != null && typeof(data['datas_registration']['status_registration']) != 'undefined') {
                  var course_events = '',
                    course_registration = '',
                    status_registration = ''
                  if (data['datas_registration']['course_events'] == null) {
                    course_events = "無"
                  } else {
                    course_events = data['datas_registration']['course_events']
                  }

                  if (data['datas_registration']['course_registration'] == null) {
                    course_registration = " "
                  } else {
                    course_registration = data['datas_registration']['course_registration']
                  }

                  if (data['datas_registration']['status_registration'] == null) {
                    status_registration = " "
                  } else {
                    status_registration = data['datas_registration']['status_registration']
                  }

                  course_sales_status = status_registration + '(' + course_registration + ' ' + course_events + ' )'
                }

                // 銷講報名次數
                if (data['datas_salesregistration']['count_sales_si'] == null) {
                  count_sales_ok = 0
                } else {
                  count_sales_ok = data['datas_salesregistration']['count_sales_si']
                }

                // 銷講報到率
                if (data['datas_salesregistration']['count_sales_ok'] == null) {
                  sales_successful_rate2 = '0%'
                } else {
                  sales_successful_rate2 = sales_successful_rate + '%'
                }

                // 銷講取消次數
                if (data['datas_salesregistration']['count_sales_no'] == null) {
                  count_sales_no = 0
                } else {
                  count_sales_no = data['datas_salesregistration']['count_sales_no']
                }

                // 銷講取消率
                if (data['datas_salesregistration']['count_sales_ok'] == null) {
                  course_cancel_rate = '0%';
                } else {
                  course_cancel_rate = course_cancel_rate + '%';
                }
              }


              // 正課
              var course_registration_events = '無'
              if (data['datas_registration'] != null && typeof(data['datas_registration']['course_registration']) != 'undefined') {
                var course_events = '',
                  course_registration = '',
                  registration_course_start_at = ''

                if (data['datas_registration']['course_events'] == null) {
                  course_events = " "
                } else {
                  course_events = data['datas_registration']['course_events']
                }

                if (data['datas_registration']['course_registration'] == null) {
                  course_registration = " "
                } else {
                  course_registration = data['datas_registration']['course_registration']
                }

                if (data['datas_registration']['registration_course_start_at'] == null) {
                  registration_course_start_at = "無"
                } else {
                  registration_course_start_at = data['datas_registration']['registration_course_start_at']
                }

                course_registration_events = course_registration + ' ' + course_events + '(' + registration_course_start_at + ' )'
              }


              // 退款             
              var refund_reason = '',
                course_refund = '無'
              if (data['datas_refund'] != null) {
                if (data['datas_refund']['refund_reason'] != null) {
                  refund_reason = data['datas_refund']['refund_reason']
                } else {
                  refund_reason = "無"
                }

                if (typeof(data['datas_refund']['refund_course']) != 'undefined') {
                  course_refund = data['datas_refund']['refund_course'] + '(' + refund_reason + ')';
                }
              }

              // 活動 Rocky(2020/08/05)
              var activity_data = ''
              if (data['datas_activity'] != null) {
                var data_activity = ''
                if (data['datas_activity']['course_start_at_activity'] != null) {
                  data_activity =
                    data['datas_activity']['course_start_at_activity']
                } else {
                  data_activity = '無'
                }

                activity_data = data['datas_activity']['course_activity'] + data['datas_activity']['events_activity'] + '(' + data_activity + ')'
              }

              data_student_detail +=
                // 姓名
                '<tr>' +
                '<td>' +
                data['datas_student'][0]['name'] +
                '</td>' +

                // Email
                '<td>' +
                data['datas_student'][0]['email'] +
                '</td>' +

                // 電話
                '<td>' +
                data['datas_student'][0]['phone'] +
                '</td>' +

                // 職業
                '<td>' +
                data['datas_student'][0]['profession'] +
                '</td>' +

                // 地址
                '<td>' +
                address +
                '</td>' +

                // 加入日期
                '<td>' +
                submissiondate +
                '</td>' +

                // 原始來源
                '<td>' +
                datasource_old +
                '</td>' +

                // 最新來源
                '<td>' +
                new_datasource +
                '</td>' +

                // 想了解的內容
                '<td>' +
                course_content +
                '</td>' +

                // 正課報名場次
                '<td>' +
                course_registration_events +
                '</td>' +

                // 銷講報名場次
                '<td>' +
                course_sales_events +
                '</td>' +

                // 銷講後報名狀況
                '<td>' +
                course_sales_status +
                '</td>' +

                // 參與活動
                '<td>' +
                activity_data +
                '</td>' +

                // 退款
                '<td>' +
                course_refund +
                '</td>' +

                // 銷講報名次數
                '<td>' +
                count_sales_ok +
                '</td>' +

                // 銷講報到率
                '<td>' +
                sales_successful_rate2 +
                '</td>' +

                // 銷講取消次數
                '<td>' +
                count_sales_no +
                '</td>' +

                // 銷講取消率
                '<td>' +
                course_cancel_rate +
                '</td>' +
                '</tr>'
            },
            // complete: function() {
            //   window.setTimeout(hide_popup, 1000); // 1 seconds
            // },
            error: function(error) {
              console.log(JSON.stringify(error));
            }
          });

        });
        return data_student_detail;
      }

      // 匯出Excel Button
      function export_excel() {
        var data_student_detail = '',
          type = '';
        var array_sid = [];

        // 如果有搜尋條件抓表格顯示
        if ($('#search_input').val() != '') {
          type = 0;
          array_sid = table.columns('5').data()[0]
        } else {
          // 否則抓全部學員
          $.ajax({
            type: 'POST',
            url: 'get_all_student',
            dataType: 'json',
            async: false,
            success: function(data) {
              type = 1;
              array_sid = data;
            },
            error: function(error) {
              console.log(JSON.stringify(error));
            }
          });
        }

        //Promise集合
        let myPromises = new Array();
        let promiseTemp = {}; //暫存變數

        // 1. 先執行Loading視窗
        let p1 = function() {
          //建立Deferred物件
          let dfd = $.Deferred();

          setTimeout(function() {
            $('#myModal').modal({
              backdrop: 'static',
              keyboard: false
            });
            //標註成功
            dfd.resolve();
          }, 500);
          //回傳promise
          return dfd.promise();
        };
        myPromises.push(p1);

        // 2. 再執行Ajax function
        let p2 = function() {
          //建立Deferred物件
          let dfd = $.Deferred();

          setTimeout(function() {
            $('#myModal').modal({
              backdrop: 'static',
              keyboard: false
            });

            data_student_detail = ajax_excel(array_sid, type)

            //標註成功
            dfd.resolve();
          }, 600);
          //回傳promise
          return dfd.promise();
        };
        myPromises.push(p2);

        // 3. 最後關閉Loading視窗、匯出Excel
        waitAllAsyncFunc(myPromises, function() {
          window.setTimeout(hide_popup, 1000); // 關閉Loading視窗

          // 匯出Excel
          if (data_student_detail != '') {
            $('#tbody_student_detail').html(data_student_detail);

            // Excel file name
            var today = new Date()
            var date = today.getFullYear().toString() + (today.getMonth() + 1).toString() + today.getDate().toString()
            var filename = date + '學員管理_' + $('#search_input').val() + '.xls'

            $("#tableExcel").table2excel({
              exclude: ".noExl", //過濾CSS
              filename: filename,
            });
          }

        });
      }

      //所有非同步function按照順序地逐一執行
      function waitAllAsyncFunc(myPromises, allDoneFunc) {
        if (myPromises !== undefined && myPromises !== null && myPromises.length > 0) {
          //等待第一個setTimeout callback function執行完畢才執行下一個setTimeout callback function
          $.when(myPromises[0]()).then(function() {
            myPromises.splice(0, 1);
            waitAllAsyncFunc(myPromises, allDoneFunc)
          });
        } else {
          allDoneFunc();
        }

      }

      /*匯出Excel Rocky(2020/08/03)*/

      // 權限判斷
      function check_auth() {
        var role = ''
        role = JSON.parse($('#auth_role').val())['role']
        if (role != "admin" && role != "marketer" && role != "officestaff" && role != "msaleser" && role != "saleser") {
          $('.auth_readonly').attr('readonly', 'readonly')
          $('.auth_readonly').attr("disabled", true);
          $(".auth_hidden").attr("style", "display:none");
        }
      }

      // 追單資料關閉
      $("#contact_close").click(function() {
        $('#save_contact').modal('hide');
      });

      $("#show_contact_close").click(function() {
        $('#show_contact').modal('hide');
      });

      // 標記關閉
      $("#tag_close").click(function() {
        $('#save_tag').modal('hide');
      });

      // 黑名單關閉 Rocky(2020/04/19)
      $("#blacklist_close").click(function() {
        $('#save_blacklist').modal('hide');
      });
      // 輸入框
      $('#search_input').on('keyup', function(e) {
        if (e.keyCode === 13) {
          $("#btn_search").click();
        }
      });

      /* 已填表單 -S Rocky(2020/02/29 */

      // 課程
      function view_form(id_student) {
        $('#v-pills-tabContent').html('')
        $.ajax({
          type: 'POST',
          url: 'view_form',
          dataType: 'json',
          data: {
            id_student: id_student
          },
          success: function(data) {
            // console.log(data)
            var course = '';

            // 銷講、正課
            if (data['datas'].length > 0) {
              $.each(data['datas'], function(index, val) {
                if (typeof(val['status_payment']) != 'undefined') {
                  // 正課資料
                  course += '<a class="nav-link " id="form_finished1" data-toggle="pill" onclick="view_form_detail(' + val['id'] + ',' + val['id_course'] + ',' + val['id_events'] + ',1)" role="tab" aria-controls="form_finished_content1" aria-selected="true">' + val['course'] + '（正課）</a>';
                } else {
                  // 銷講資料
                  var status = ''
                  if (val['status'] == '我很遺憾') {
                    status = '（' + val['status'] + '）'
                  }
                  course += '<a class="nav-link " id="form_finished1" data-toggle="pill" onclick="view_form_detail(' + val['id'] + ',' + val['id_course'] + ',' + val['id_events'] + ',0)" role="tab" aria-controls="form_finished_content1" aria-selected="true">' + val['course'] + status + '（銷講）</a>';
                }
              });
            }

            // 活動資料
            if (data['activity'].length > 0) {
              $.each(data['activity'], function(index, val) {
                course += '<a class="nav-link " id="form_finished1" data-toggle="pill" onclick="view_form_detail(' + val['id'] + ',' + val['id_course'] + ',' + val['id_events'] + ',2)" role="tab" aria-controls="form_finished_content1" aria-selected="true">' + val['course'] + '（活動）</a>';
              });
            }

            $('#v-pills-tab').html(course);
            $("#form_finished").modal('show');
          },
          error: function(error) {
            console.log(JSON.stringify(error));
          }
        });
      }

      // 課程詳細資料
      function view_form_detail(id, id_course, id_events, type) {
        $.ajax({
          type: 'POST',
          url: 'view_form_detail',
          dataType: 'json',
          data: {
            id: id,
            id_course: id_course,
            type: type
          },
          success: function(data) {
            var detail = '',
              student = '',
              payment = '',
              course = '',
              sign = '',
              id_select_events = '',
              id_student = '',
              id_events

            $.each(data['datas'], function(index, val) {
              // 學員資料
              var id_identity, sex, phone, email, birthday, company, profession, address, events, events_start, source_events
              id_student = val['r_sid'];
              if (val['id_identity'] != null) {
                id_identity = val['id_identity'];
              } else {
                id_identity = '無'
              }
              if (val['sex'] != null) {
                sex = val['sex'];
              } else {
                sex = '無'
              }
              if (val['phone'] != null) {
                phone = val['phone'];
              } else {
                phone = '無'
              }
              if (val['email'] != null) {
                email = val['email'];
              } else {
                email = '無'
              }
              if (val['birthday'] != null) {
                birthday = val['birthday'];
              } else {
                birthday = '無'
              }

              if (val['company'] != null) {
                company = val['company'];
              } else {
                company = '無'
              }

              if (val['profession'] != null) {
                profession = val['profession'];
              } else {
                profession = '無'
              }

              if (val['address'] != null) {
                address = val['address'];
              } else {
                address = '無'
              }

              if (val['events_start'] != null) {
                events_start = val['events_start']
              } else {
                events_start = '無'
              }

              //已填表單加入來源場次按鈕 Sandy(2020/08/11)
              if (val['source_events'] != null) {
                source_events = val['source_events']
              } else {
                source_events = '無'
              }



              student = '<div style="text-align:left"><b>課程服務報名表</b>' + '<br>' + '姓名:' + val['name'] + '<br>' + '性別:' + sex + '<br>' + '身分證字號:' + id_identity + '<br>' +
                '聯絡電話:' + phone + '<br>' + '電子郵件:' + email + '<br>' + '出生日期:' + birthday + '<br>' +
                '公司名稱:' + company + '<br>' + '職業:' + profession + '<br>' + '聯絡地址:' + address +
                '</div>'

              if (type == 1) {
                var pay_model = '';
                // 正課

                // 付款方式
                switch (val['pay_model']) {
                  case '0':
                    pay_model = '現金'
                    break;
                  case '1':
                    pay_model = '匯款'
                    break;
                  case '2':
                    pay_model = '刷卡:輕鬆付'
                    break;
                  case '3':
                    pay_model = '刷卡:一次付'
                    break;
                }

                // 繳款明細        
                payment = '<hr/><div style="text-align:left;padding-top: 1%;"><b>繳款明細</b>' + '<br>' + '付款金額:' + val['cash'] + '<br>' + '付款方式:' + pay_model + '<br>' + '卡號後五碼:' + val['number'] + '<br>' +
                  '服務人員:' + val['person'] + '<br>' + '統編:' + val['number_taxid'] + '<br>' + '抬頭:' + val['companytitle'] +
                  '</div>'

                // 簽名 Rocky(2020/05/20)
                if (val['sign'] != '') {
                  sign = '<hr/><div style="text-align:left;padding-top: 1%;"><b>簽名</b>' + '<br>' +
                    '<img src = "../public/sign/' + val['sign'] + '" alt = "無簽名" width = "50%" height = "150" > ' +
                    '</div>'
                }
              }


              // 課程資料 Rocky(2020/05/20)

              /*場次 - S*/
              id_select_events = "select_events_" + id
              select_events = '<select class="custom-select form-control col-sm-8" id="' + id_select_events + '" name="select_teacher"  onblur="update_events($(this),' + id + ',' + type + ',' + id_student + ');" > </select >'
              /*場次 - E*/

              id_events = val['id_events']

              if (type == 0) {
                // 銷講
                course = '<hr/><div style="text-align:left;padding-top: 1%;"><b>課程內容</b>' + '<br>' + '課程名稱:<a href="{{ route("course_return") }}' + '?id=' + id_events + '" target="_blank">' + val['course'] + '</a><br>' +
                  '課程開始時間:' + events_start + '<br>' +
                  '<div class="form-group row">' +
                  '<label class="col-sm-2" >場次: </label>' + select_events +
                  '</div>'
                // +'</div>'
              } else if (type == 1) {
                // 正課
                
                if (id_events != "" && id_events != null && id_events != 0 && id_events != -99) {
                  course = '<hr/><div style="text-align:left;padding-top: 1%;"><b>課程內容</b>' + '<br>' + '課程名稱:<a href="{{ route("course_return") }}' + '?id=' + id_events + '" target="_blank">' + val['course'] + '</a><br>' +
                    '課程開始時間:' + events_start + '<br>' +
                    '<div class="form-group row">' +
                    '<label class="col-sm-2" >場次: </label>' + select_events +
                    '</div>'
                  //  +'</div>'
                } else{
                  course = '<hr/><div style="text-align:left;padding-top: 1%;"><b>課程內容</b>' + '<br>' + '課程名稱:' + val['course'] + '<br>' +
                    '課程開始時間:' + events_start + '<br>' +
                    '<div class="form-group row">' +
                    '<label class="col-sm-2" >場次: </label>' + select_events +
                    '</div>'
                  //  +'</div>'
                }
              } else if (type == 2) {
                // 活動
                course = '<hr/><div style="text-align:left;padding-top: 1%;"><b>活動內容</b>' + '<br>' + '活動名稱:<a href="{{ route("course_return") }}' + '?id=' + id_events + '" target="_blank">' + val['course'] + '</a><br>' +
                  '活動開始時間:' + events_start + '<br>' +
                  '<div class="form-group row">' +
                  '<label class="col-sm-2" >場次: </label>' + select_events +
                  '</div>'
                // +'</div>'
              }

              //已填表單加入該場場次報表按鈕 Sandy(2020/08/11)
              if (source_events != '無') {
                course += '<div class="form-group row"><a role="button" class="btn btn-sm btn-primary ml-auto mr-3" href="{{ route("course_return") }}' + '?id=' + source_events + '" target="_blank">場次報表</a></div></div>'
              } else {
                course += '</div>';
              }
              // if (id_events != "" && id_events != null && id_events != 0 && id_events != -99) {
              //   course += '<div class="form-group row"><a role="button" class="btn btn-sm btn-primary ml-auto mr-3" href="{{ route("course_return") }}' + '?id=' + id_events + '" target="_blank">場次報表</a></div></div>'
              // } else {
              //   course += '</div>';
              // }

              detail = '<div class="tab-pane fade show active" id="' + val['id'] + '" role="tabpanel" aria-labelledby="form_finished1">' + student + course + sign + payment + '</div>'


            });


            $('#v-pills-tabContent').html(detail);

            // 場次
            id_select_events = "#" + id_select_events
            $(id_select_events).append("<option value='-99'>請選擇</option>");
            $.each(data['events'], function(index, val) {
              $(id_select_events).append("<option value='" + val['id'] + "'>" + val['events'] + "</option>");
            })
            if (id_events != "") {
              $(id_select_events).val(id_events) // 場次
            } else {
              $(id_select_events).val('') // 場次 
            }

          },
          error: function(error) {
            console.log(JSON.stringify(error));
          }
        });
      }
      /* 已填表單 -E Rocky(2020/02/29) */

      /* 完整內容 -S Rocky(2020/02/29) */

      // 基本訊息
      function course_data(id_student) {
        id_student_old = id_student
        history_data();
        contact_data();
        tags_show(id_student);
        $.ajax({
          type: 'POST',
          url: 'course_data',
          dataType: 'json',
          data: {
            id_student: id_student
          },
          async: false,
          success: function(data) {
            // console.log(data)
            // 宣告
            var datasource_old = '',
              submissiondate = '',
              sales_registration_id = ''


            // 銷講報到率
            var sales_successful_rate = '0',
              course_cancel_rate = '0';
            var course_sales_status = '',
              course_sales_events = '';
            if (data['datas_salesregistration'] != null && data['datas_salesregistration']['count_sales_ok'] != 0) {
              sales_successful_rate = (data['datas_salesregistration']['count_sales_ok'] / (data['datas_salesregistration']['count_sales'] - data['datas_salesregistration']['count_sales_no']) * 100).toFixed(0)
            }

            // 銷講取消率
            if (data['datas_salesregistration'] != null && data['count_sales_no'] != 0) {
              course_cancel_rate = (data['datas_salesregistration']['count_sales_no'] / data['datas_salesregistration']['count_sales'] * 100).toFixed(0)
            }

            // 來源
            if (data['datas_datasource_old'] != null) {
              // 原始來源
              if (data['datas_datasource_old']['datasource'] != null) {
                datasource_old = data['datas_datasource_old']['datasource']
              } else {
                datasource_old = "無"
              }

              // submissiondate
              submissiondate = data['datas_datasource_old']['sales_registration_old_submissiondate']

              // 銷講ID
              sales_registration_id = data['datas_datasource_old']['sales_registration_old']
            } else {
              datasource_old = "無"
              submissiondate = "無"
            }


            // 學員資料
            $('#student_name').val(data['datas_student'][0]['name']);
            $('#student_email').val(data['datas_student'][0]['email']);
            $('#title_student_phone').val(data['datas_student'][0]['phone']);
            $('#title_old_datasource').text('原始來源:' + datasource_old);
            $('#submissiondate').text('加入日期 :' + submissiondate);
            $('#student_profession').val(data['datas_student'][0]['profession']);
            $('#student_address').val(data['datas_student'][0]['address']);
            $('#sales_registration_old').val(sales_registration_id);
            $('#old_datasource').val(datasource_old);
            $('#student_phone').val(data['datas_student'][0]['phone']);



            // 最新來源
            var new_datasource = '無'

            if (data['datas_datasource_new'] != null && data['datas_datasource_new']['datasource'] != null) {
              new_datasource = data['datas_datasource_new']['datasource']
            }
            $('input[name="new_datasource"]').val(new_datasource);

            // 銷講
            if (data['datas_salesregistration'] != null) {

              if (data['datas_salesregistration']['course_sales'] != null) {
                var course_sales = '',
                  course_sales_events = '',
                  sales_registration_course_start_at = ''
                if (data['datas_salesregistration']['course_sales'] == null) {
                  course_sales = " "
                } else {
                  course_sales = data['datas_salesregistration']['course_sales']
                }

                if (data['datas_salesregistration']['course_sales_events'] == null) {
                  course_sales_events = " "
                } else {
                  course_sales_events = data['datas_salesregistration']['course_sales_events']
                }

                if (data['datas_salesregistration']['sales_registration_course_start_at'] == null) {
                  // 我很遺憾
                  if (data['datas_salesregistration']['id_events'] == '-99' || data['datas_salesregistration']['events'] != '') {
                    sales_registration_course_start_at = "我很遺憾 - " + data['datas_salesregistration']['events']
                  } else {
                    sales_registration_course_start_at = "無"
                  }

                } else {
                  sales_registration_course_start_at = data['datas_salesregistration']['sales_registration_course_start_at']
                }

                course_sales_events = course_sales + ' ' + course_sales_events + '(' + sales_registration_course_start_at + ' )'
              }
              $('input[name="course_sales_events"]').val(course_sales_events);

              $('input[name="course_content"]').val(data['datas_salesregistration']['course_content']);
              $('input[name="status_payment"]').val('');
              if (data['datas_registration'] != null && typeof(data['datas_registration']['status_registration']) != 'undefined') {
                var course_events = '',
                  course_registration = '',
                  status_registration = ''
                if (data['datas_registration']['course_events'] == null) {
                  course_events = "無"
                } else {
                  course_events = data['datas_registration']['course_events']
                }

                if (data['datas_registration']['course_registration'] == null) {
                  course_registration = " "
                } else {
                  course_registration = data['datas_registration']['course_registration']
                }

                if (data['datas_registration']['status_registration'] == null) {
                  status_registration = " "
                } else {
                  status_registration = data['datas_registration']['status_registration']
                }

                course_sales_status = status_registration + '(' + course_registration + ' ' + course_events + ' )'
              }
              // 銷講後報名狀況
              $('input[name="course_sales_status"]').val(course_sales_status);

              if (data['datas_salesregistration']['count_sales_si'] == null) {
                $('h7[name="count_sales_ok"]').text('銷講報名次數 :0');
              } else {
                $('h7[name="count_sales_ok"]').text('銷講報名次數 :' + data['datas_salesregistration']['count_sales_si']);
              }
              if (data['datas_salesregistration']['count_sales_ok'] == null) {
                $('h7[name="sales_successful_rate"]').text('銷講報到率 :0%');
              } else {
                $('h7[name="sales_successful_rate"]').text('銷講報到率 :' + sales_successful_rate + '%');
              }
              if (data['datas_salesregistration']['count_sales_no'] == null) {
                $('h7[name="count_sales_no"]').text('銷講取消次數 :0');
              } else {
                $('h7[name="count_sales_no"]').text('銷講取消次數 :' + data['datas_salesregistration']['count_sales_no']);
              }

              if (data['datas_salesregistration']['count_sales_ok'] == null) {
                $('h7[name="sales_cancel_rate"]').text('銷講取消率 :0%');
              } else {
                $('h7[name="sales_cancel_rate"]').text('銷講取消率 :' + course_cancel_rate + '%');
              }
            }
            // 正課
            $('input[name="course_events"]').val('');
            if (data['datas_registration'] != null && typeof(data['datas_registration']['course_registration']) != 'undefined') {
              var course_events = '',
                course_registration = '',
                registration_course_start_at = '',
                course_registration_events = ''
              if (data['datas_registration']['course_events'] == null) {
                course_events = " "
              } else {
                course_events = data['datas_registration']['course_events']
              }

              if (data['datas_registration']['course_registration'] == null) {
                course_registration = " "
              } else {
                course_registration = data['datas_registration']['course_registration']
              }

              if (data['datas_registration']['registration_course_start_at'] == null) {
                registration_course_start_at = "無"
              } else {
                registration_course_start_at = data['datas_registration']['registration_course_start_at']
              }

              course_registration_events = course_registration + ' ' + course_events + '(' + registration_course_start_at + ' )'

              $('input[name="course_events"]').val(course_registration_events);
            }

            // 退款
            $('input[name="course_refund"]').val('');

            var refund_reason = ''
            if (data['datas_refund'] != null) {
              if (data['datas_refund']['refund_reason'] != null) {
                refund_reason = data['datas_refund']['refund_reason']
              } else {
                refund_reason = "無"
              }

              if (typeof(data['datas_refund']['refund_course']) != 'undefined') {
                $('input[name="course_refund"]').val(data['datas_refund']['refund_course'] + '(' + refund_reason + ')');
              } else {
                $('#dev_refund').hide();
              }
            } else {
              $('#dev_refund').hide();
            }


            // 活動 Rocky(2020/08/05)
            $('#activity_data').val('');
            if (data['datas_activity'] != null) {
              var activity_data = '',
                data_activity = ''
              if (data['datas_activity']['course_start_at_activity'] != null) {
                data_activity =
                  data['datas_activity']['course_start_at_activity']
              } else {
                data_activity = '無'
              }

              activity_data = data['datas_activity']['course_activity'] + data['datas_activity']['events_activity'] + '(' + data_activity + ')'

              $('#activity_data').val(activity_data);
            }

            $("#student_information").modal('show');
          },
          error: function(error) {
            console.log(JSON.stringify(error));
          }
        });
      }

      /* 標記 -S Rocky(2020/03/12) */

      // 標記顯示
      function tags_show(id_student) {
        $.ajax({
          type: 'POST',
          url: 'tag_show',
          dataType: 'json',
          data: {
            id_student: id_student
          },
          success: function(data) {
            // console.log(data);

            var cities = new Bloodhound({
              datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
              queryTokenizer: Bloodhound.tokenizers.whitespace,
              local: data
            });
            cities.initialize();
            var elt = $('#isms_tags');
            // 設定標籤
            elt.tagsinput({
              tagClass: function(item) {
                return 'badge badge-primary'
              },
              itemValue: 'value',
              itemText: 'text',
              typeaheadjs: {
                name: 'cities',
                displayKey: 'text',
                source: cities.ttAdapter()
              }
            });
            // 清空標籤
            $('#isms_tags').tagsinput('removeAll');

            if (data.length != 0) {
              // 新增資料到標籤
              $.each(data, function(index, val) {
                elt.tagsinput('add', {
                  "value": val['value'],
                  "text": val['text'],
                  "continent": val['text']
                });
              });
            }
          },
          error: function(error) {
            console.log(JSON.stringify(error));
          }
        });
      }

      // 標記新增
      function tags_add() {
        name = $("#tag_name").val();

        $.ajax({
          type: 'POST',
          url: 'tag_save',
          data: {
            id_student: id_student_old,
            name: name,
          },
          success: function(data) {
            if (data = "儲存成功") {
              tags_show(id_student_old)
              $("#tag_name").val('')
              $("#success_alert_text").html("儲存成功");
              fade($("#success_alert"));
            } else {
              $("#error_alert_text").html("儲存失敗");
              fade($("#error_alert"));
            }
          },
          error: function(error) {
            console.log(JSON.stringify(error));
          }
        });
      }

      // 標記刪除
      elt.on('beforeItemRemove', function(event) {
        // 權限 Rocky (2020/05/11)
        var role = JSON.parse($('#auth_role').val())['role']
        if (role == "admin" || role == "marketer" || role == "officestaff" || role == "msaleser" || role == "saleser") {
          var msg = "是否刪除標記資料?";
          if (confirm(msg) == true) {
            $.ajax({
              type: 'POST',
              url: 'tag_delete',
              dataType: 'json',
              data: {
                id: event.item['value']
              },
              success: function(data) {
                if (data['data'] == "ok") {
                  /** alert **/
                  $("#success_alert_text").html("刪除資料成功");
                  fade($("#success_alert"));

                  // location.reload();
                } else {
                  /** alert **/
                  $("#error_alert_text").html("刪除資料失敗");
                  fade($("#error_alert"));
                }
              },
              error: function(error) {
                console.log(JSON.stringify(error));
              }
            });
          } else {
            tags_show(id_student_old)
            return false;
          }
        } else {
          tags_show(id_student_old)
          return false;
        }
      });

      /* 標記 -E Rocky(2020/03/12) */

      // 歷史互動
      function history_data() {
        table2.clear().draw();
        table2.destroy();

        table2 = $('#table_list_history').DataTable({
          "dom": '<l<t>p>',
          "columnDefs": [{
              "targets": 'no-sort',
              "orderable": false,
            },
            {
              "targets": 2,
              "className": "text-left",
            }
          ],
          "deferRender": true,
          "orderCellsTop": true,
          "destroy": true,
          "retrieve": true,
          "ajax": {
            "url": "history_data",
            "type": "POST",
            "data": {
              id_student: id_student_old
            },
            async: false,
            "dataSrc": function(json) {
              // console.log(json)
              for (var i = 0; i < json.length; i++) {
                var status = '',
                  course_sales = '',
                  datasource = '';
                if (json[i]['status_sales'] == null) {
                  status = '無'
                } else {
                  status = json[i]['status_sales']
                }

                if (json[i]['course_sales'] == null) {
                  course_sales = '無'
                } else {
                  course_sales = json[i]['course_sales']
                }

                if (json[i]['datasource'] == null) {
                  datasource = '無'
                } else {
                  datasource = json[i]['datasource']
                }


                // id_student = json[i]['id_student'];
                json[i][0] = json[i]['created_at'];
                json[i][1] = datasource;
                json[i][2] = status;
                json[i][3] = course_sales;
              }
              return json;

            }
          }
        });


        // 調整Datable.js寬度
        $("#table_list_history").css({
          "width": "100%"
        });

        // $.ajax({
        //   type: 'POST',
        //   url: 'history_data',
        //   dataType: 'json',
        //   data: {
        //     id_student: id_student_old
        //   },
        //   success: function(data) {
        //     var id_student = '';
        //     $('#history_data_detail').html('');
        //     $.each(data, function(index, val) {
        //       var status = '',
        //         course_sales = '';
        //       if (val['status_sales'] == null) {
        //         status = '無'
        //       } else {
        //         status = val['status_sales']
        //       }

        //       if (val['course_sales'] == null) {
        //         course_sales = '無'
        //       } else {
        //         course_sales = val['course_sales']
        //       }

        //       id_student = val['id_student'];
        //       data +=
        //         '<tr>' +
        //         '<td>' + val['created_at'] + '</td>' +
        //         '<td>' + status + '</td>' +
        //         '<td>' + course_sales + '</td>' +
        //         '</tr>'
        //     });

        //     $('#history_data_detail').html(data);

        //   },
        //   error: function(error) {
        //     console.log(JSON.stringify(error));
        //   }
        // });
      }

      // 聯絡狀況
      function contact_data() {
        $('#contact_data_detail').html('');
        $.ajax({
          type: 'POST',
          url: 'contact_data',
          dataType: 'json',
          data: {
            id_student: id_student_old
          },
          // async: false,
          success: function(data) {
            updatetime = '', remindtime = '', id_debt_status_payment_name = '', id_status = '', val_status = '', val_status_payment_name = '', id_debt_status_payment_name2 = '';
            var array_id_status = [],
              array_id_debt_status_payment_name = [],
              array_val_status_payment_name = [],
              array_val_status = []
            $.each(data, function(index, val) {
              opt1 = '', opt2 = '', opt3 = '', opt4 = '', opt5 = '', opt6 = '', opt7 = '';
              id = val['id'];

              // 付款狀態下拉ID
              id_debt_status_payment_name = 'debt_status_payment_name_' + id
              array_id_debt_status_payment_name.push("#" + id_debt_status_payment_name)

              // 最新狀態下拉ID
              id_status = id + '_status'
              array_id_status.push("#" + id_status)

              // 付款狀態Value
              val_status_payment_name = val['status_payment_name']
              array_val_status_payment_name.push(val['status_payment_name'])

              // 最新狀態Value
              val_status = val['id_status']
              array_val_status.push(val['id_status'])

              updatetime += "#new_starttime" + id + ','
              remindtime += "#remind" + id + ','
              var status_payment = '',
                contact = '',
                person = '';

              if (typeof(val['status_payment']) == 'object') {
                status_payment = ''
              } else {
                status_payment = val['status_payment']
              }

              if (val['contact'] != null) {
                contact = val['contact']
              }

              if (val['person'] != null) {
                person = val['person']
              }
              data +=
                '<tr>' +
                '<td><i class="fa fa-address-card " aria-hidden="true" onclick="debt_show(' + id + ');" style="cursor:pointer;padding-top: 20%;"></i></td>' +
                '<td><i class="fa fa-trash auth_hidden" aria-hidden="true" onclick="debt_delete(' + id + ');" style="cursor:pointer;padding-top: 40%; color:#eb6060"></i></td>' +
                '<td>' +
                '<div class="input-group date show_datetime" id="new_starttime' + id + '" data-target-input="nearest"> ' +
                ' <input type="text" onblur="save_data($(this),' + id + ',0);"  value="' + val['updated_at'] + '"   name="new_starttime' + id + '" class="form-control datetimepicker-input datepicker auth_readonly" data-target="#new_starttime' + id + '" data-toggle="datetimepicker" autocomplete="off" required/> ' +
                // ' <div class="input-group-append" data-target="#new_starttime' + id + '" data-toggle="datetimepicker"> ' +
                // ' <div class="input-group-text"><i class="fa fa-calendar"></i></div> ' +
                '</div> ' +
                '</div>' +
                '</td>' +
                '<td>' + '<input type="text"  class="form-control auth_readonly" onblur="save_data($(this),' + id + ',6);" id="' + id + '_name_course" value="' + val['name_course'] + '" class="border-0 bg-transparent input_width">' + '</td>' +
                '<td>' + '<input type="text"  class="auth_readonly form-control" onblur="save_data($(this),' + id + ',1);" id="' + id + '_status_payment" value="' + status_payment + '" class="border-0 bg-transparent input_width">' + '</td>' +
                '<td>' + '<input type="text"  class=" auth_readonly form-control" onblur="save_data($(this),' + id + ',2);" id="' + id + '_contact" value="' + contact + '"  class="border-0 bg-transparent input_width">' + '</td>' +
                '<td style="width:15%;">' + '<div class="form-group show_select m-0"> <select id="' + id_debt_status_payment_name + '" onblur="save_data($(this),' + id + ',7);" class="auth_readonly custom-select border-0 bg-transparent input_width"> ' +
                '<option selected disabled value=""></option>' +
                '<option value="留單">留單</option>' +
                '<option value="完款">完款</option>' +
                '<option value="付訂">付訂</option>' +
                '<option value="退費">退費</option>' +
                '</select>' +
                '</div> </td>' +
                '<td style="width:15%;">' + '<div class="form-group show_select m-0"> <select id="' + id_status + '" onblur="save_data($(this),' + id + ',3);" class="auth_readonly custom-select border-0 bg-transparent input_width"> ' +
                '<option selected disabled value=""></option>' +
                '<option value="12">待追</option>' +
                '<option value="15">無意願</option>' +
                '<option value="16">推薦其他講師</option>' +
                '<option value="22">通知下一梯次</option>' +
                '</select>' +
                '</div> </td>' +
                '<td>' + '<input type="text"  class="auth_readonly form-control" onblur="save_data($(this),' + id + ',5);" id="' + id + '_person" value="' + person + '" class="border-0 bg-transparent input_width">' + '</td>' +
                '<td>' +
                '<div class="input-group date show_datetime" id="remind' + id + '" data-target-input="nearest"> ' +
                ' <input type="text" onblur="save_data($(this),' + id + ',4);"  value="' + val['remind_at'] + '"   name="remind' + id + '" class="auth_readonly form-control datetimepicker-input datepicker" data-target="#remind' + id + '" data-toggle="datetimepicker" autocomplete="off" required/> ' +
                ' <div class="input-group-append" data-target="#remind' + id + '" data-toggle="datetimepicker"> ' +
                // ' <div class="input-group-text"><i class="fa fa-calendar"></i></div> ' +
                '</div> ' +
                '</div>' +
                '</td>' +
                '</tr>'
            });
            $('#contact_data_detail').html(data);
            // 日期
            var iconlist = {
              time: 'fas fa-clock',
              date: 'fas fa-calendar',
              up: 'fas fa-arrow-up',
              down: 'fas fa-arrow-down',
              previous: 'fas fa-arrow-circle-left',
              next: 'fas fa-arrow-circle-right',
              today: 'far fa-calendar-check-o',
              clear: 'fas fa-trash',
              close: 'far fa-times'
            }
            $(updatetime.substring(0, updatetime.length - 1)).datetimepicker({
              format: "YYYY-MM-DD",
              icons: iconlist,
              defaultDate: new Date(),
              pickerPosition: "bottom-left"
            });
            $(remindtime.substring(0, remindtime.length - 1)).datetimepicker({
              format: "YYYY-MM-DD",
              icons: iconlist,
              defaultDate: new Date(),
              pickerPosition: "bottom-left"
            });

            /*付款狀態、最新狀態 - S*/

            // 付款狀態            
            $.each(array_id_debt_status_payment_name, function(index, val) {
              if (array_val_status_payment_name[index] != "") {
                $(array_id_debt_status_payment_name[index]).val(array_val_status_payment_name[index])
              } else {
                $(array_id_debt_status_payment_name[index]).val('')
              }
            })

            // 最新狀態
            $.each(array_id_status, function(index, val) {
              if (array_val_status[index] != "") {
                $(array_id_status[index]).val(array_val_status[index])
              } else {
                $(array_id_status[index]).val('')
              }
            })

            /*付款狀態、最新狀態 - E*/


            // 權限判斷 Rocky(2020/05/10)
            check_auth();
          },
          error: function(error) {
            console.log(JSON.stringify(error));
          }
        });
      }

      // 儲存
      function save() {
        student_name = $("#student_name").val();
        student_email = $("#student_email").val();
        student_profession = $("#student_profession").val();
        student_address = $("#student_address").val();
        sales_registration_old = $("#sales_registration_old").val();
        old_datasource = $("#old_datasource").val();
        student_phone = $("#student_phone").val();


        $.ajax({
          type: 'POST',
          url: 'student_save',
          data: {
            id_student: id_student_old,
            profession: student_profession,
            address: student_address,
            sales_registration_old: sales_registration_old,
            old_datasource: old_datasource,
            student_phone: student_phone,
            student_name: student_name,
            student_email: student_email
          },
          success: function(data) {
            if (data = "更新成功") {
              $("#success_alert_text").html("儲存成功");
              fade($("#success_alert"));
            } else {
              $("#error_alert_text").html("儲存失敗");
              fade($("#error_alert"));

            }
          },
          error: function(error) {
            console.log(JSON.stringify(error));
          }
        });
      }
      /* 完整內容 -E Rocky(2020/02/29 */


      /*聯絡狀況 - 新增 - S Rocky(2020/04/02)*/
      function debt_add() {
        var isValidForm = document.forms['form_debt'].checkValidity();
        if ($("#debt_course").val() == "" || $("#debt_person").val() == "") {
          alert('請填寫追單課程 / 追單人員');
          return false;
        } else {
          if (isValidForm) {
            debt_date = $("#debt_date").val();
            debt_course = $("#debt_course").val();
            debt_status_date = $("#debt_status_date").val();
            debt_contact = $("#debt_contact").val();
            debt_status = $("#debt_status").val();
            debt_status_payment_name = $("#debt_status_payment_name").val();
            debt_person = $("#debt_person").val();
            debt_remind = $("#debt_remind").val();
            id_student = id_student_old;

            $.ajax({
              type: 'POST',
              url: 'debt_save',
              data: {
                id_student: id_student,
                debt_date: debt_date,
                debt_course: debt_course,
                debt_status_date: debt_status_date,
                debt_contact: debt_contact,
                debt_status: debt_status,
                debt_status_payment_name: debt_status_payment_name,
                debt_person: debt_person,
                debt_remind: debt_remind
              },
              success: function(data) {
                if (data = "儲存成功") {
                  contact_data();
                  $("#success_alert_text").html("儲存成功");
                  fade($("#success_alert"));
                  $("#save_contact").modal('hide');
                } else {
                  $("#error_alert_text").html("儲存失敗");
                  fade($("#error_alert"));
                }
              },
              error: function(error) {
                console.log(JSON.stringify(error));
              }
            });
          } else {
            return false;
          }
        }
      }
      /*聯絡狀況 - 新增 - E*/

      /*聯絡狀況 - 刪除 - S Rocky(2020/04/02)*/
      function debt_delete(id) {
        var msg = "是否刪除此筆資料?";
        if (confirm(msg) == true) {
          $.ajax({
            type: 'POST',
            url: 'debt_delete',
            data: {
              id: id
            },
            success: function(data) {
              if (data = "刪除成功") {
                contact_data();
                $("#success_alert_text").html("刪除成功");
                fade($("#success_alert"));
              } else {
                $("#error_alert_text").html("刪除失敗");
                fade($("#error_alert"));
              }
            },
            error: function(error) {
              console.log(JSON.stringify(error));
            }
          });
        } else {
          return false;
        }
      }
      /*聯絡狀況 - 刪除 - E*/

      /*聯絡狀況 - 顯示 - S Rocky(2020/04/21)*/
      function debt_show(id) {
        $("#show_contact").modal('show');
        $.ajax({
          type: 'POST',
          url: 'debt_show',
          data: {
            id: id
          },
          success: function(data) {
            $("#lbl_debt_date").text(data[0]['updated_at']);
            $("#lbl_debt_course").text(data[0]['name_course']);
            $("#lbl_debt_status_date").text(data[0]['status_payment']);
            $("#lbl_debt_contact").text(data[0]['contact']);
            $("#status_payment_name").text(data[0]['status_payment_name']);
            $("#lbl_debt_status").text(data[0]['status_name']);
            $("#lbl_debt_person").text(data[0]['person']);
            $("#lbl_debt_remind").text(data[0]['remind_at']);
          },
          error: function(error) {
            console.log(JSON.stringify(error));
          }
        });
      }
      /*聯絡狀況 - 顯示 - E*/

      /* 自動儲存 - S Rocky(2020/03/08) */

      // 已填表單 - 場次更新 Rocky(2020/05/21)
      function update_events(data, id, type, id_student) {
        $.ajax({
          type: 'POST',
          url: 'view_form_save',
          // dataType:'JSON',
          data: {
            id: id,
            type: type,
            data: data.val(),
            id_student: id_student
          },
          success: function(data) {
            /** alert **/
            $("#success_alert_text").html("資料儲存成功");
            fade($("#success_alert"));
          },
          error: function(jqXHR) {
            console.log(JSON.stringify(jqXHR));

            /** alert **/
            $("#error_alert_text").html("資料儲存失敗");
            fade($("#error_alert"));
          }
        });
      }

      // 日期
      function update_time(data, id, type) {
        // console.log(data.val()) 
        save_data(data.val(), id, type)
      }
      // 付款狀態 / 日期
      function status_payment(data, id, type) {
        save_data(data.val(), id, type)
      }

      // 聯絡內容
      function contact(data, id, type) {
        save_data(data.val(), id, type)
      }

      // 最新狀態
      function status(data, id, type) {
        save_data(data.val(), id, type)
      }
      // 提醒
      function remind(data, id, type) {
        save_data(data.val(), id, type)
      }

      // 追單人員
      function person(data, id, type) {
        save_data(data.val(), id, type)
      }

      // 追單課程
      function name_course(data, id, type) {
        save_data(data.val(), id, type)
      }

      function save_data(data, id, type) {
        $.ajax({
          type: 'POST',
          url: 'contact_data_save',
          data: {
            id: id,
            type: type,
            data: data.val()
          },
          success: function(data) {
            // console.log(data);

            /** alert **/
            $("#success_alert_text").html("資料儲存成功");
            fade($("#success_alert"));
          },
          error: function(jqXHR) {
            console.log(JSON.stringify(jqXHR));

            /** alert **/
            $("#error_alert_text").html("資料儲存失敗");
            fade($("#error_alert"));
          }
        });
      }

      /* 自動儲存 - E Rocky(2020/03/08) */


      /*刪除 Rocky(2020/02/23)*/
      function btn_delete(id_student, type, elem) {
        var msg = "是否刪除此筆資料?";
        var parent = $(elem).parent(); // 找到該筆資料節點

        if (confirm(msg) == true) {
          if (id_student == '' && type == '1') {
            id_student = id_student_old;
          }
          $.ajax({
            type: 'GET',
            url: 'student_delete',
            dataType: 'json',
            data: {
              id_student: id_student
            },
            success: function(data) {
              if (data['data'] == "ok") {
                /** alert **/
                $("#success_alert_text").html("刪除資料成功");
                fade($("#success_alert"));

                if (type == '1') {
                  location.reload();
                } else if (type == '0') {
                  // 刪掉整筆<tr>
                  parent.parent().remove();
                }

              } else {
                /** alert **/
                $("#error_alert_text").html("刪除資料失敗");
                fade($("#error_alert"));
              }
            },
            error: function(error) {
              console.log(JSON.stringify(error));

              /** alert **/
              $("#error_alert_text").html("刪除資料失敗");
              fade($("#error_alert"));
            }
          });
        } else {
          return false;
        }
      }

      /*加入黑名單 Rocky(2020/02/23)*/
      function btn_blacklist(id_student) {
        var msg = "是否加入黑名單?";
        if (confirm(msg) == true) {
          $("#blacklist_add").attr('value', id_student);
          $("#save_blacklist").modal('show');
        } else {
          $("#save_blacklist").modal('hide');
        }
      }

      function add_blacklist() {
        id_student = $("#blacklist_add").val();
        reason = $("#blacklist_reason").val();

        $.ajax({
          type: 'GET',
          url: 'student_addblacklist',
          dataType: 'json',
          data: {
            id_student: id_student,
            reason: reason
          },
          success: function(data) {
            $('#blacklist_reason').val("");
            if (data['data'] == "ok") {
              /** alert **/
              $("#success_alert_text").html("加入黑名單成功");
              fade($("#success_alert"));
              // location.reload();
            } else if (data['data'] == "已加入") {
              /** alert **/
              $("#error_alert_text").html("此學員已入黑名單");
              fade($("#error_alert"));
            } else {
              /** alert **/
              $("#error_alert_text").html("加入黑名單失敗");
              fade($("#error_alert"));
            }
          },
          error: function(error) {
            console.log(JSON.stringify(error));

            /** alert **/
            $("#error_alert_text").html("加入黑名單失敗");
            fade($("#error_alert"));
          }
        });
      }

      /*學員修改基本資料button*/
      var basic_input = document.getElementsByClassName("basic-inf");
      var i;
      // document.getElementById('update-inf').onclick = function() {
      //     for (i = 0; i < basic_input.length; i++) {
      //         basic_input[i].removeAttribute('readonly');
      //     }
      //     document.getElementById("save-inf").style.display = "block";
      //     document.getElementById("update-inf").style.display = "none";
      // };

      // document.getElementById('save-inf').onclick = function() {
      //     for (i = 0; i < basic_input.length; i++) {
      //         basic_input[i].setAttribute('readonly','readonly');
      //     }
      //     /*document.getElementById('basic-inf').setAttribute('readonly','readonly');*/
      //     document.getElementById("save-inf").style.display = "none";
      //     document.getElementById("update-inf").style.display = "block";
      // };
    </script>

    @endsection