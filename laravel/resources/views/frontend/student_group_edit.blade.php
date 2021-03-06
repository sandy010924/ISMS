@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '名單列表修改')

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

  /* .bootstrap-tagsinput .tag [data-role="remove"] {
    display: none;
  } */
</style>
<!-- Content Start -->
<!--學員細分組內容-->
<div class="card m-3">
  <div class="card-body">
    <!-- 權限 Rocky(2020/05/10) -->
    <input type="hidden" id="auth_role" value="{{ Auth::user()}}" />
    <form id="form_condition1">
      <div class="row">
        <div class="col-3">
          <select class="form-control" id="select_type">
            <option value="0">請選擇</option>
            <option value="1">銷講</option>
            <option value="2">正課</option>
            <option value="3">活動</option>
          </select>
        </div>
        <div class="col-3">
          <!-- <select multiple class="selectpicker form-control" data-actions-box="true" id="select_course"></select> -->
          <select class="form-control js-example-basic-multiple bootstrap_multipleSelect" multiple="multiple" id="select_course"></select>
        </div>
        <div class="col-3">
          <input type="text" class="w-100 form-control p-0" name="daterange" id="input_date">
        </div>
        <div class="col-3">
          <select class="form-control" id="condition">
            <option value="information">名單資料</option>
            <option value="action">名單動作</option>
            <option value="tag">標籤</option>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          <select class="form-control mt-2" id="condition_option1">
            <option value="">請選擇</option>
            <option value="datasource_old">原始來源</option>
            <option value="datasource_new">最新來源</option>
            <option value="id_events">報名場次</option>
            <option value="profession">目前職業</option>
            <option value="address">居住地址</option>
            <!-- <option>銷講後最新狀態</option> -->
            <option value="course_content">想了解的內容</option>
          </select>
        </div>
        <div class="col-3">
          <select class="form-control mt-2" id="condition_option2">
            <option value="">請選擇</option>
            <option value="yes">是</option>
            <option value="no">未</option>
            <option value="like">包含</option>
            <option value="notlike">不包含</option>
          </select>
        </div>
        <div class="col-3">
          <input type="text" class="form-control mt-2" style="display:block;" id="condition_input3">
          <!-- <select class="form-control m-1" id="condition_option3" style="display:none;">
              <option value="">請選擇</option>

            </select> -->
        </div>
      </div>
    </form>
    <!-- 添加另一條件 Rocky (2020/04/04) -->
    <div class="row">
      <div class="col-2 mt-2">
        <button class="btn btn-primary" type="button" onclick="condition2();" data-toggle="collapse" data-target="#dev_condition2" aria-expanded="false" aria-controls="dev_condition2">
          <i class="fa fa-plus" aria-hidden="true">添加條件</i>
        </button>
      </div>
      <div class="col-2 mt-2">
        <button class="btn btn-success" type="button" onclick="search();">
          <i class="fa fa-search" aria-hidden="true">搜尋</i>
        </button>
      </div>
    </div>
  </div>
</div>
<!-- 條件篩選器2 -->
<div class="collapse" id="dev_condition2">
  <div class="card m-3">
    <div class="card-body">
      <form id="form_condition2">
        <div class="row">
          <div class="col-3">
            <select class="form-control" id="select_type2">
              <option value="0">請選擇</option>
              <option value="1">銷講</option>
              <option value="2">正課</option>
              <option value="3">活動</option>
            </select>
          </div>
          <div class="col-3">
            <!-- <select multiple class="selectpicker form-control" data-actions-box="true" id="select_course2"></select> -->
            <select class="form-control js-example-basic-multiple bootstrap_multipleSelect" multiple="multiple" id="select_course2"></select>
          </div>
          <div class="col-3">
            <input type="text" class="w-100 form-control p-0" name="daterange" id="input_date2">
          </div>
          <div class="col-3">
            <select class="form-control" id="condition2">
              <option value="information">名單資料</option>
              <option value="action">名單動作</option>
              <option value="tag">標籤</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-3">
            <select class="form-control mt-2" id="condition_option1_2">
              <option value="">請選擇</option>
              <option value="datasource_old">原始來源</option>
              <option value="datasource_new">最新來源</option>
              <option value="id_events">報名場次</option>
              <option value="profession">目前職業</option>
              <option value="address">居住地址</option>
              <!-- <option>銷講後最新狀態</option> -->
              <option value="course_content">想了解的內容</option>
            </select>
          </div>
          <div class="col-3">
            <select class="form-control mt-2" id="condition_option2_2">
              <option value="">請選擇</option>
              <option value="yes">是</option>
              <option value="no">未</option>
              <option value="like">包含</option>
              <option value="notlike">不包含</option>
            </select>
          </div>
          <div class="col-3">
            <input type="text" class="form-control mt-2" style="display:block;" id="condition_input3_2">
          </div>
        </div>
      </form>
      <!-- 添加另一條件 Rocky (2020/04/04) -->
      <div class="row">
        <div class="col-3  mt-2">
          <button class="btn btn-primary" type="button" onclick="condition3();" data-toggle="collapse" data-target="#dev_condition3" aria-expanded="false" aria-controls="dev_condition3">
            <i class="fa fa-plus" aria-hidden="true">添加條件</i>
          </button>
          <button type="button" class="close" style="font-size:30px;color:red" aria-label="Close" data-number="1" data-toggle="collapse" data-target="#dev_condition2" aria-expanded="false" aria-controls="dev_condition2" onclick="close_condition2();">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- 條件篩選器3 -->
<div class="collapse" id="dev_condition3">
  <div class="card m-3">
    <div class="card-body">
      <form id="form_condition3">
        <div class="row">
          <div class="col-3">
            <select class="form-control" id="select_type3">
              <option value="0">請選擇</option>
              <option value="1">銷講</option>
              <option value="2">正課</option>
              <option value="3">活動</option>
            </select>
          </div>
          <div class="col-3">
            <!-- <select multiple class="selectpicker form-control" data-actions-box="true" id="select_course3"></select> -->
            <select class="form-control js-example-basic-multiple bootstrap_multipleSelect" multiple="multiple" id="select_course3"></select>
          </div>
          <div class="col-3">
            <input type="text" class="w-100 form-control p-0" name="daterange" id="input_date3">
          </div>
          <div class="col-3">
            <select class="form-control" id="condition3">
              <option value="information">名單資料</option>
              <option value="action">名單動作</option>
              <option value="tag">標籤</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-3">
            <select class="form-control mt-2" id="condition_option1_3">
              <option value="">請選擇</option>
              <option value="datasource_old">原始來源</option>
              <option value="datasource_new">最新來源</option>
              <option value="id_events">報名場次</option>
              <option value="profession">目前職業</option>
              <option value="address">居住地址</option>
              <!-- <option>銷講後最新狀態</option> -->
              <option value="course_content">想了解的內容</option>
            </select>
          </div>
          <div class="col-3">
            <select class="form-control mt-2" id="condition_option2_3">
              <option value="">請選擇</option>
              <option value="yes">是</option>
              <option value="no">未</option>
              <option value="like">包含</option>
              <option value="notlike">不包含</option>
            </select>
          </div>
          <div class="col-3">
            <input type="text" class="form-control mt-2" style="display:block;" id="condition_input3_3">
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col-3  mt-2">
          <button type="button" class="close" style="font-size:30px;color:red" aria-label="Close" data-number="1" data-toggle="collapse" data-target="#dev_condition3" aria-expanded="false" aria-controls="dev_condition3" onclick="close_condition3();">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card m-3">
  <div class="card-body">
    <div class="row">
      <div class="col-4">
        <button class="btn btn-dark" type="button" data-toggle="collapse" data-target="#model_show_log" aria-expanded="false" aria-controls="model_show_log" onclick="show_log();">
          <i class="fa fa-search" aria-hidden="true"></i>查看條件
        </button>
      </div>
      <div class="col-3">
        <input type="text" id="name_group" class="m-2 form-control" value="{{$datas[0]['name_group']}}">
      </div>
      <div class="col-2">
        <button class="btn btn-outline-secondary m-2" type="button" id="btn_update" onclick="update();">儲存</button>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="collapse" id="model_show_log" style="padding-top:15px;">
          <div class="card card-body">
            <div id="show_log"></div>
            <div id="show_orlog"></div>
            <div id="show_andlog"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="table-responsive mt-3">
      <input type="hidden" id="id_group" value="{{$id}}">
      <input type="hidden" id="data_groupdetail" value="{{$datas}}">
      @component('components.datatable')
      @slot('thead')
      <!-- <table class="table table-striped table-sm text-center">
        <thead> -->
      <tr>
        <th>姓名</th>
        <th>聯絡電話</th>
        <th>電子郵件</th>
        <th>來源</th>
        <th>加入日期</th>
        <th>完整內容</th>
      </tr>
      @endslot
      <!-- </thead> -->
      @slot('tbody')
      <!-- <tbody id="data_student">
      </tbody> -->
      @endslot
      @endcomponent
      </table>
    </div>
  </div>
</div>

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
              <button type="button" class="btn btn-primary float-right" id="save-inf" style="display:block;" onclick="student_save();">儲存</button>
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
        <!-- 聯絡狀況 -->

        <!-- 完整內容 - E -->
      </div>
    </div>
  </div>
</div>
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
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> -->

<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script src="{{ asset('js/angular.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-tagsinput-angular.min.js') }}"></script>

<script>
  // 宣告
  var elt = $('#isms_tags');
  var array_studentid = new Array();
  var search_log = '',
    search_orlog = '',
    search_show_log = '',
    or_log = '',
    count_log = 0,
    old_count_log = 0,
    check_search = 0
  var check_condition2 = 0,
    check_condition3 = 0;

  var array_old_studentid = new Array();
  var array_upate_studentid = new Array();
  var table2, table
  //  $('select').selectpicker();
  $("document").ready(function() {
    //日期選擇器
    $('#debt_date').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    $('#debt_remind').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    // 查看條件 - 預設顯示 Rocky(2020/04/21)
    $('#model_show_log').collapse({
      show: true
    })

    array_old_studentid = JSON.parse($('#data_groupdetail').val())


    // console.log($('#data_groupdetail').val())
    //  // 顯示細分條件資料 Rocky(2020/03/14)
    //  show_requirement();

    // 課程多選 Rocky(2020/03/14)
    // $("#select_course").selectpicker({
    //   noneSelectedText: '請選擇' //預設顯示內容
    // });
    // $("#select_course2").selectpicker({
    //   noneSelectedText: '請選擇' //預設顯示內容
    // });
    // $("#select_course3").selectpicker({
    //   noneSelectedText: '請選擇' //預設顯示內容
    // });
    //課程多選樣式改 Sandy(2020/08/02)

    $(".bootstrap_multipleSelect").select2({
      width: 'resolve', // need to override the changed default
      theme: 'bootstrap',
      placeholder: "請選擇",
    });
    $.fn.select2.defaults.set("theme", "bootstrap");

    // Datable.js Rocky (2020/04/30)
    var today = new Date();
    var title = today.getFullYear().toString() + (today.getMonth() + 1).toString() + today.getDate().toString() + '_名單列表_' + $('#name_group').val()
    table2 = $('#table_list_history').DataTable();

    table = $('#table_list').DataTable({
      "dom": '<B<td>t>',
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }],
      "destroy": true,
      "retrieve": true,
      "bPaginate": false,
      buttons: [{
        extend: 'excel',
        text: '匯出Excel',
        messageTop: $('#name_group').val(),
        title: title,
        exportOptions: {
          columns: [0, 1, 2, 3, 4]
        }
      }],
      // "ordering": false,
    });
  });

  // 顯示資料
  show(JSON.parse($('#data_groupdetail').val()), 'show')

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

  /*關閉條件 Rocky (2020/07/21)*/
  function close_condition2() {
    check_condition2--;
  }

  function close_condition3() {
    check_condition3--;
  }

  /*增加條件*/
  function condition2() {
    check_condition2++;
    if (check_condition2 > 1) {
      check_condition2 = 0
    }
  }

  function condition3() {
    check_condition3++;
    if (check_condition3 > 1) {
      check_condition3 = 0
    }
  }

  //時間範圍
  $(function() {
    $('input[name="daterange"]').daterangepicker({
      opens: 'left',
      locale: {
        format: "YYYY/MM/DD"
      }

    }, function(start, end, label) {
      // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
  });

  /*條件判斷 - S Rocky(2020/04/05)*/
  show_condition1();
  show_condition2();
  show_condition3();
  /*條件判斷 - E Rocky(2020/04/05)*/

  function show_requirement_course(type, id) {
    $.ajax({
      type: 'POST',
      url: 'show_requirement_course',
      dataType: 'json',
      data: {
        type: type
      },
      success: function(data) {
        // // console.log(data);
        // $('#select_course').find('option').remove();
        // $.each(data, function(index, val) {
        //   $('#select_course').append(new Option(val['name'], val['id']))
        // });

        // $('#select_course').selectpicker('refresh');
        // console.log(data);
        $(id).find('option').remove();
        $.each(data, function(index, val) {
          $(id).append(new Option(val['name'], val['id']))
        });

        $(id).selectpicker('refresh');

      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }

  /*條件顯示 - S Rocky(2020/04/05)*/
  function write_log() {
    var log_id = []
    // 抓取條件篩選器1
    $("#form_condition1 :input").each(function() {
      if ($(this).attr('id') != undefined) {
        if ($(this).val() != "" || $(this).val() != "請選擇") {
          if ($(this).attr('id') == "input_date" || $(this).attr('id') == "condition_input3") {
            id = '#' + $(this).attr('id')
          } else {
            id = '#' + $(this).attr('id') + ' :selected'
          }
          log_id.push(id)
        }
      }
    });

    get_log(log_id, "篩選器1", 1)

    // 抓取條件篩選器2
    if (check_condition2 == 1) {
      log_id = []
      $("#form_condition2 :input").each(function() {
        if ($(this).attr('id') != undefined) {
          if ($(this).val() != "" || $(this).val() != "請選擇") {
            if ($(this).attr('id') == "input_date2" || $(this).attr('id') == "condition_input3_2") {
              id = '#' + $(this).attr('id')
            } else {
              id = '#' + $(this).attr('id') + ' :selected'
            }
            log_id.push(id)
          }
        }
      });
      get_log(log_id, "篩選器2", 2)
    }

    // 抓取條件篩選器3
    if (check_condition3 == 1) {
      log_id = []
      $("#form_condition3 :input").each(function() {
        if ($(this).attr('id') != undefined) {
          if ($(this).val() != "" || $(this).val() != "請選擇") {
            if ($(this).attr('id') == "input_date3" || $(this).attr('id') == "condition_input3_3") {
              id = '#' + $(this).attr('id')
            } else {
              id = '#' + $(this).attr('id') + ' :selected'
            }
            log_id.push(id)
          }
        }
      });
      get_log(log_id, "篩選器3", 3)
    }
  }

  function get_log(log_id, condition_name, condition_id) {

    var log = '';

    type = $(log_id[0]).text()
    course = $(log_id[1]).text()
    date = $(log_id[2]).val()
    type_condition = $(log_id[3]).text()
    opt1 = $(log_id[4]).text()
    opt2 = $(log_id[5]).text()
    value = $(log_id[6]).val()

    if (type != "") {
      log += type + '/'
    }
    if (course != "") {
      log += course + '/'
    }
    if (date != "") {
      log += date + '/'
    }
    if (type_condition != "") {
      log += type_condition + '/'
    }
    if (opt1 != "請選擇") {
      log += opt1 + '/'
    }
    if (opt2 != "請選擇") {
      log += opt2 + '/'
    }
    if (value != "") {
      log += value + '/'
    }

    if (check_condition3 == 1 && condition_id == 1) {
      tag = "<hr>" + "<h5 style='color: #b83a3a;'>AND</h5>"
      log = tag + condition_name + ":" + log.slice(0, -1) + "<br>"
      search_log += log
    } else if (check_condition2 == 1 && condition_id == 1) {
      tag = "<hr>" + "<h5 style='color: #b83a3a;'>AND</h5>"
      log = tag + condition_name + ":" + log.slice(0, -1) + "<br>"
      search_log += log
    } else if (condition_id == 1) {
      or_log += condition_name + ":" + log.slice(0, -1) + "<br>"
    } else {
      tag = ""
      log = tag + condition_name + ":" + log.slice(0, -1) + "<br>"
      search_log += log
    }

  }

  function show_log() {
    if (count_log != 0) {
      search_orlog = ''
      if (or_log != "") {
        search_orlog = "<hr>" + "<h5 style='color: #3a7eb8;'>OR</h5>" + or_log
      }
      $("#show_orlog").html('');
      $("#show_orlog").html(search_orlog);

      $("#show_andlog").html('');
      $("#show_andlog").html(search_log);
    }
  }
  /*條件顯示 - E */

  // 尋找資料 Rocky(2020/03/14)
  function search() {
    var array_search = [],
      array_condition1 = [],
      array_condition2 = [],
      array_condition3 = [];

    // 抓取條件篩選器1
    $("#form_condition1 :input").each(function() {
      if ($(this).attr('id') != undefined) {
        array_condition1.push($(this).val())
      }
    });

    // 抓取條件篩選器2
    if (check_condition2 == 1) {
      $("#form_condition2 :input").each(function() {
        if ($(this).attr('id') != undefined) {
          array_condition2.push($(this).val())
        }
      });
    }

    // 抓取條件篩選器3
    if (check_condition3 == 1) {
      $("#form_condition3 :input").each(function() {
        if ($(this).attr('id') != undefined) {
          array_condition3.push($(this).val())
        }
      });
    }

    // 將資料push到array
    if (array_condition1[1].length == 0) {
      array_condition1[1] = ['']
    }

    array_search.push({
      type_course: array_condition1[0],
      id_course: array_condition1[1],
      date: array_condition1[2],
      type_condition: array_condition1[3],
      opt1: array_condition1[4],
      opt2: array_condition1[5],
      value: array_condition1[6]
    });

    if (check_condition2 == 1) {
      if (array_condition2[1].length == 0) {
        array_condition2[1] = ['']
      }
      array_search.push({
        type_course: array_condition2[0],
        id_course: array_condition2[1],
        date: array_condition2[2],
        type_condition: array_condition2[3],
        opt1: array_condition2[4],
        opt2: array_condition2[5],
        value: array_condition2[6]
      });
    }

    if (check_condition3 == 1) {
      if (array_condition3[1].length == 0) {
        array_condition3[1] = ['']
      }
      array_search.push({
        type_course: array_condition3[0],
        id_course: array_condition3[1],
        date: array_condition3[2],
        type_condition: array_condition3[3],
        opt1: array_condition3[4],
        opt2: array_condition3[5],
        value: array_condition3[6]
      });
    }

    $.ajax({
      type: 'POST',
      url: 'search_students',
      dataType: 'json',
      data: {
        array_search: array_search
      },
      success: function(data) {
        // console.log(data)
        show(data, "search");
        check_search = 1;
        /*log Rocky(2020/04/04)*/
        count_log++;
        write_log()
        show_log()
      },
      error: function(error) {
        console.log(JSON.stringify(error))
      }
    })
  }

  // 顯示資料 Rocky(2020/03/19)
  function show(data, type_show) {

    if (type_show == "show") {
      if (data[0]['condition'] != null) {
        search_show_log = data[0]['condition']
        $("#show_log").html('');
        $("#show_log").html(search_show_log);
      }
    }

    if (data.length > 0) {
      $.each(data, function(index, val) {
        // 檢查陣列有沒有重複資料
        var check_array_student = array_old_studentid.filter(function(item, index, array) {
          return item.id == val['id']
        });
        if (check_array_student.length == 0) {
          array_old_studentid.push(data[index]);
          // array_upate_studentid.push(data[index]);
        }
        if (check_array_student.length == 0 && type_show == "search") {
          array_upate_studentid.push(data[index]);
        }
      });
    }
    // console.log(data['check_blacklist'])
    if (array_old_studentid.length != 0) {
      $.each(array_old_studentid, function(index, val) {
        if (val['name'] != null) {
          var name = '';
          datasource = val['datasource']
          submissiondate = val['submissiondate']
          email = val['email']
          if (datasource == null) {
            datasource = ''
          }

          if (submissiondate == null) {
            submissiondate = ''
          }
          if (email == null) {
            email = ''
          }

          if (val['check_blacklist'] == 1) {
            name = '<span class="text-danger border border-danger">黑名單</span>' + val['name']

          } else {
            name = val['name']
          }

          data +=
            '<tr>' +
            '<td>' + name + '</td>' +
            '<td>' + val['phone'] + '</td>' +
            '<td>' + email + '</td>' +
            '<td>' + datasource + '</td>' +
            '<td>' + submissiondate + '</td>' +
            '<td>' +
            '<button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" onclick="course_data(' + val['id'] + ');" > 完整內容 </button>'
          '</td>' +
          '</tr>'
        }
      });
      // $('#data_student').html(data);
      $('#tableBody').html(data);

    }
  }



  // 細分組更新
  function update() {
    var name_group = $('#name_group').val()
    var id = $('#id_group').val()
    var condition = search_show_log + search_orlog + search_log

    console.log(array_upate_studentid)
    // 檢查有沒有搜尋 
    if (check_search == 1) {
      $.ajax({
        type: 'POST',
        url: 'studentgroup_update',
        // dataType:'json',
        data: {
          id: id,
          name_group: name_group,
          condition: condition,
          array_upate_studentid: array_upate_studentid
        },
        success: function(data) {
          // console.log(data)
          if (data = "儲存成功") {
            $("#success_alert_text").html("儲存成功");
            fade($("#success_alert"));

            // location.replace(location)
          } else {
            $("#error_alert_text").html("儲存失敗");
            fade($("#error_alert"));
          }
        },
        error: function(error) {
          console.log(JSON.stringify(error))
        }
      })
    } else {
      $.ajax({
        type: 'POST',
        url: 'studentgroup_update',
        // dataType:'json',
        data: {
          id: id,
          name_group: name_group,
          condition: condition
        },
        success: function(data) {
          // console.log(data)
          if (data = "儲存成功") {
            $("#success_alert_text").html("儲存成功");
            fade($("#success_alert"));

            location.replace(location)
          } else {
            $("#error_alert_text").html("儲存失敗");
            fade($("#error_alert"));
          }
        },
        error: function(error) {
          console.log(JSON.stringify(error))
        }
      })
    }

  }

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
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }

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

  /* 完整內容 -E Rocky(2020/02/29 */


  // 儲存資料 Rocky(2020/03/19)

  //完整內容儲存
  function student_save() {
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


  // 自動儲存
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

  function show_condition1() {
    //條件類別判斷
    document.getElementById('condition').onchange = function() {
      var condition_option1 = document.getElementById('condition_option1'),
        condition_option2 = document.getElementById('condition_option2'),
        condition_input3 = document.getElementById('condition_input3');

      condition_option2.style.display = 'none';
      condition_input3.style.display = 'none';

      if (this.value == 'information') {
        // 選項一
        if ($('#select_type').val() == "1") {
          $('#condition_option1').empty();
          $('#condition_option1').append(new Option('請選擇', ''));
          $('#condition_option1').append(new Option('原始來源', 'datasource_old'));
          $('#condition_option1').append(new Option('最新來源', 'datasource_new'));
          $('#condition_option1').append(new Option('報名場次', 'id_events'));
          $('#condition_option1').append(new Option('目前職業', 'profession'));
          $('#condition_option1').append(new Option('居住地址', 'address'));
          $('#condition_option1').append(new Option('想了解的內容', 'course_content'));

        } else if ($('#select_type').val() == "2") {
          $('#condition_option1').empty();
          $('#condition_option1').append(new Option('請選擇', ''));
          $('#condition_option1').append(new Option('應付金額', 'amount_payable'));
          $('#condition_option1').append(new Option('已付金額', 'amount_paid'));
          $('#condition_option1').append(new Option('服務人員', 'person'));
          $('#condition_option1').append(new Option('統一發票', 'type_invoice'));
          $('#condition_option1').append(new Option('統編', 'number_taxid'));
          $('#condition_option1').append(new Option('抬頭', 'companytitle'));
          $('#condition_option1').append(new Option('報名場次', 'id_events'));
          $('#condition_option1').append(new Option('目前職業', 'profession'));
          $('#condition_option1').append(new Option('居住地址', 'address'));
        } else if ($('#select_type').val() == "3") {
          $('#condition_option1').empty();
          $('#condition_option1').append(new Option('請選擇', ''));
          $('#condition_option1').append(new Option('報名場次', 'id_events'));
          $('#condition_option1').append(new Option('目前職業', 'profession'));
          $('#condition_option1').append(new Option('居住地址', 'address'));
          $('#condition_option1').append(new Option('有什麼問題想要詢問', 'course_content'));
        }


        // 選項二
        $('#condition_option2').empty();
        $('#condition_option2').append(new Option('是', 'yes'));
        $('#condition_option2').append(new Option('未', 'no'));
        $('#condition_option2').append(new Option('包含', 'like'));
        $('#condition_option2').append(new Option('不包含', 'notlike'));

        $('#condition_input3').val('');
        // condition_input3.style.display = 'block';

      } else if (this.value == 'action') {
        // 選項一
        $('#condition_option1').empty();
        $('#condition_option1').append(new Option('請選擇', ''));
        $('#condition_option1').append(new Option('是', 'yes'));
        $('#condition_option1').append(new Option('未', 'no'));

        // 選項二
        $('#condition_option2').empty();
        $('#condition_option2').append(new Option('請選擇', ''));
        $('#condition_option2').append(new Option('報到', '4'));
        $('#condition_option2').append(new Option('取消', '5'));
        $('#condition_option2').append(new Option('未到', '3'));
        $('#condition_option2').append(new Option('我很遺憾', '2'));
        $('#condition_option2').append(new Option('留單', '6'));
        $('#condition_option2').append(new Option('完款', '7'));
        $('#condition_option2').append(new Option('付訂', '8'));
        $('#condition_option2').append(new Option('退款', '9'));
        $('#condition_option2').append(new Option('參與', '23'));

        $('#condition_input3').val('');
        condition_input3.style.display = 'none';
      } else if (this.value == 'tag') {
        // 選項一
        $('#condition_option1').empty();
        $('#condition_option1').append(new Option('請選擇', ''));
        $('#condition_option1').append(new Option('已分配', 'yes'));
        $('#condition_option1').append(new Option('未分配', 'no'));

        // 選項二
        $('#condition_option2').empty();
        $('#condition_option2').append(new Option('請選擇', ''));
        $('#condition_option2').append(new Option('是', 'yes'));
        $('#condition_option2').append(new Option('未', 'no'));
        $('#condition_option2').append(new Option('包含', 'like'));
        $('#condition_option2').append(new Option('不包含', 'notlike'));


        $('#condition_input3').val('');
        // condition_input3.style.display = 'block';

      }
    };
    // 類型 Rocky(2020/03/20)
    document.getElementById('select_type').onchange = function() {
      if (this.value == '1') {
        // 銷講
        if ($('#condition').val() == "information") {
          // 選項一
          $('#condition_option1').empty();
          $('#condition_option1').append(new Option('請選擇', ''));
          $('#condition_option1').append(new Option('原始來源', 'datasource_old'));
          $('#condition_option1').append(new Option('最新來源', 'datasource_new'));
          $('#condition_option1').append(new Option('報名場次', 'id_events'));
          $('#condition_option1').append(new Option('目前職業', 'profession'));
          $('#condition_option1').append(new Option('居住地址', 'address'));
          // $('#condition_option1').append(new Option('銷講後最新狀態', ''));
          $('#condition_option1').append(new Option('想了解的內容', 'course_content'));

          // 選項二
          $('#condition_option2').empty();
          $('#condition_option2').append(new Option('是', 'yes'));
          $('#condition_option2').append(new Option('未', 'no'));
          $('#condition_option2').append(new Option('包含', 'like'));
          $('#condition_option2').append(new Option('不包含', 'notlike'));
        }
      } else if (this.value == '2') {
        // 正課
        // 選項一
        if ($('#condition').val() == "information") {
          $('#condition_option1').empty();
          $('#condition_option1').append(new Option('請選擇', ''));
          $('#condition_option1').append(new Option('應付金額', 'amount_payable'));
          $('#condition_option1').append(new Option('已付金額', 'amount_paid'));
          $('#condition_option1').append(new Option('服務人員', 'person'));
          $('#condition_option1').append(new Option('統一發票', 'type_invoice'));
          $('#condition_option1').append(new Option('統編', 'number_taxid'));
          $('#condition_option1').append(new Option('抬頭', 'companytitle'));
          $('#condition_option1').append(new Option('報名場次', 'id_events'));
          $('#condition_option1').append(new Option('目前職業', 'profession'));
          $('#condition_option1').append(new Option('居住地址', 'address'));
        }
      } else if (this.value == '3') {
        // 活動 Rocky(2020/08/13)        
        if ($('#condition').val() == "information") {
          $('#condition_option1').empty();
          $('#condition_option1').append(new Option('請選擇', ''));
          $('#condition_option1').append(new Option('報名場次', 'id_events'));
          $('#condition_option1').append(new Option('目前職業', 'profession'));
          $('#condition_option1').append(new Option('居住地址', 'address'));
          $('#condition_option1').append(new Option('有什麼問題想要詢問', 'course_content'));

          // 選項二
          $('#condition_option2').empty();
          $('#condition_option2').append(new Option('是', 'yes'));
          $('#condition_option2').append(new Option('未', 'no'));
          $('#condition_option2').append(new Option('包含', 'like'));
          $('#condition_option2').append(new Option('不包含', 'notlike'));
        }
      }
    }

    // 選項三 Rocky(2020/08/12)
    document.getElementById('condition_option1').onchange = function() {
      $('#condition_input3').val('');
      $('#condition_option2').val('');

      if ($('#condition').val() == "tag" && this.value == 'yes') {
        // 選項二
        $('#condition_option2').empty();
        $('#condition_option2').append(new Option('是', 'yes'));
        $('#condition_option2').append(new Option('未', 'no'));
        $('#condition_option2').append(new Option('包含', 'like'));
        $('#condition_option2').append(new Option('不包含', 'notlike'));

        condition_option2.style.display = 'block';
        condition_input3.style.display = 'block';
      } else if ($('#condition').val() == "tag" && this.value == 'no') {
        // 選項二
        $('#condition_option2').empty();
        $('#condition_option2').append(new Option('是', 'yes'));
        $('#condition_option2').append(new Option('包含', 'like'));

        condition_option2.style.display = 'block';
        condition_input3.style.display = 'block';
      } else if ($('#condition').val() == "information") {
        condition_option2.style.display = 'block';
        condition_input3.style.display = 'block';
      } else if ($('#condition').val() == "action") {
        condition_option2.style.display = 'block';
        condition_input3.style.display = 'none';
      }

      // 已付、應付金額 Rocky(2020/08/12)
      if ($('#select_type').val() == "2" && (this.value == 'amount_paid' || this.value == 'amount_payable')) {
        $('#condition_option2').empty();
        $('#condition_option2').append(new Option('是', 'yes'));
        $('#condition_option2').append(new Option('未', 'no'));

        // $('#condition_option2').empty();
        // $('#condition_option2').append(new Option('等於', '='));
        // $('#condition_option2').append(new Option('大於', '>'));
        // $('#condition_option2').append(new Option('小於', '<'));
      } else if ($('#select_type').val() == "2" && $('#condition').val() == "information") {
        $('#condition_option2').empty();
        $('#condition_option2').append(new Option('是', 'yes'));
        $('#condition_option2').append(new Option('未', 'no'));
        $('#condition_option2').append(new Option('包含', 'like'));
        $('#condition_option2').append(new Option('不包含', 'notlike'));
      }
    }

    // document.getElementById('condition_option2').onchange = function() {
    //   if (this.value == 'present' || this.value == 'cancel' || this.value == 'absent' || this.value == 'pay') {
    //     condition_option3.innerHTML = '<option value="">請選擇</option><option>課程選項</option>';
    //   } else if (this.value == 'participate') {
    //     condition_option3.innerHTML = '<option value="">請選擇</option><option>課程活動</option>';
    //   } else if (this.value == 'open-mail') {
    //     condition_option3.innerHTML = '<option value="">請選擇</option><option>郵件名稱</option>';
    //   } else if (this.value == 'open-sms') {
    //     condition_option3.innerHTML = '<option value="">請選擇</option><option>簡訊名稱</option>';
    //   }
    // }

    // 顯示細分條件資料 Rocky(2020/03/14)
    $("#select_type").change(function() {
      show_requirement_course($('#select_type').val(), "#select_course");
    });
  }

  function show_condition2() {
    //條件類別判斷
    document.getElementById('condition2').onchange = function() {
      var condition_option1 = document.getElementById('condition_option1_2'),
        condition_option2_2 = document.getElementById('condition_option2_2'),
        condition_input3_2 = document.getElementById('condition_input3_2');

      condition_option2_2.style.display = 'none';
      condition_input3_2.style.display = 'none';

      if (this.value == 'information') {
        // 選項一
        if ($('#select_type2').val() == "1") {
          $('#condition_option1_2').empty();
          $('#condition_option1_2').append(new Option('請選擇', ''));
          $('#condition_option1_2').append(new Option('原始來源', 'datasource_old'));
          $('#condition_option1_2').append(new Option('最新來源', 'datasource_new'));
          $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
          $('#condition_option1_2').append(new Option('目前職業', 'profession'));
          $('#condition_option1_2').append(new Option('居住地址', 'address'));
          $('#condition_option1_2').append(new Option('想了解的內容', 'course_content'));

        } else if ($('#select_type2').val() == "2") {
          $('#condition_option1_2').empty();
          $('#condition_option1_2').append(new Option('請選擇', ''));
          $('#condition_option1_2').append(new Option('應付金額', 'amount_payable'));
          $('#condition_option1_2').append(new Option('已付金額', 'amount_paid'));
          $('#condition_option1_2').append(new Option('服務人員', 'person'));
          $('#condition_option1_2').append(new Option('統一發票', 'type_invoice'));
          $('#condition_option1_2').append(new Option('統編', 'number_taxid'));
          $('#condition_option1_2').append(new Option('抬頭', 'companytitle'));
          $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
          $('#condition_option1_2').append(new Option('目前職業', 'profession'));
          $('#condition_option1_2').append(new Option('居住地址', 'address'));
        } else if ($('#select_type2').val() == "3") {
          $('#condition_option1_2').empty();
          $('#condition_option1_2').append(new Option('請選擇', ''));
          $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
          $('#condition_option1_2').append(new Option('目前職業', 'profession'));
          $('#condition_option1_2').append(new Option('居住地址', 'address'));
          $('#condition_option1_2').append(new Option('有什麼問題想要詢問', 'course_content'));
        }

        // 選項二
        $('#condition_option2_2').empty();
        $('#condition_option2_2').append(new Option('是', 'yes'));
        $('#condition_option2_2').append(new Option('未', 'no'));
        $('#condition_option2_2').append(new Option('包含', 'like'));
        $('#condition_option2_2').append(new Option('不包含', 'notlike'));
        //
        condition_input3_2.style.display = 'block';
      } else if (this.value == 'action') {
        // 選項一
        $('#condition_option1_2').empty();
        $('#condition_option1_2').append(new Option('請選擇', ''));
        $('#condition_option1_2').append(new Option('是', 'yes'));
        $('#condition_option1_2').append(new Option('未', 'no'));

        // 選項二
        $('#condition_option2_2').empty();
        $('#condition_option2_2').append(new Option('請選擇', ''));
        $('#condition_option2_2').append(new Option('報到', '4'));
        $('#condition_option2_2').append(new Option('取消', '5'));
        $('#condition_option2_2').append(new Option('未到', '3'));
        $('#condition_option2_2').append(new Option('我很遺憾', '2'));
        $('#condition_option2_2').append(new Option('完款', '7'));
        $('#condition_option2_2').append(new Option('付訂', '8'));
        $('#condition_option2_2').append(new Option('退款', '9'));
        $('#condition_option2_2').append(new Option('參與', '23'));
        // $('#condition_option2_2').append(new Option('打開郵件', ''));
        // $('#condition_option2_2').append(new Option('打開簡訊', ''));

        condition_input3_2.style.display = 'none';
      } else if (this.value == 'tag') {
        // 選項一
        $('#condition_option1_2').empty();
        $('#condition_option1_2').append(new Option('請選擇', ''));
        $('#condition_option1_2').append(new Option('已分配', 'yes'));
        $('#condition_option1_2').append(new Option('未分配', 'no'));

        // 選項二
        $('#condition_option2_2').empty();
        $('#condition_option2_2').append(new Option('請選擇', ''));
        $('#condition_option2_2').append(new Option('是', 'yes'));
        $('#condition_option2_2').append(new Option('未', 'no'));
        $('#condition_option2_2').append(new Option('包含', 'like'));
        $('#condition_option2_2').append(new Option('不包含', 'notlike'));

        // condition_input3_2.style.display = 'block';
      }
    };

    // 類型 Rocky(2020/03/20)
    document.getElementById('select_type2').onchange = function() {
      if (this.value == '1') {
        // 銷講
        if ($('#condition2').val() == "information") {
          // 選項一
          $('#condition_option1_2').empty();
          $('#condition_option1_2').append(new Option('請選擇', ''));
          $('#condition_option1_2').append(new Option('原始來源', 'datasource_old'));
          $('#condition_option1_2').append(new Option('最新來源', 'datasource_new'));
          $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
          $('#condition_option1_2').append(new Option('目前職業', 'profession'));
          $('#condition_option1_2').append(new Option('居住地址', 'address'));
          $('#condition_option1_2').append(new Option('想了解的內容', 'course_content'));
        }
      } else if (this.value == '2') {
        // 正課
        // 選項一
        if ($('#condition2').val() == "information") {
          $('#condition_option1_2').empty();
          $('#condition_option1_2').append(new Option('請選擇', ''));
          $('#condition_option1_2').append(new Option('應付金額', 'amount_payable'));
          $('#condition_option1_2').append(new Option('已付金額', 'amount_paid'));
          $('#condition_option1_2').append(new Option('服務人員', 'person'));
          $('#condition_option1_2').append(new Option('統一發票', 'type_invoice'));
          $('#condition_option1_2').append(new Option('統編', 'number_taxid'));
          $('#condition_option1_2').append(new Option('抬頭', 'companytitle'));
          $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
          $('#condition_option1_2').append(new Option('目前職業', 'profession'));
          $('#condition_option1_2').append(new Option('居住地址', 'address'));
        }
      } else if (this.value == '3') {
        // 活動 Rocky(2020/08/13)        
        if ($('#condition2').val() == "information") {
          $('#condition_option1_2').empty();
          $('#condition_option1_2').append(new Option('請選擇', ''));
          $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
          $('#condition_option1_2').append(new Option('目前職業', 'profession'));
          $('#condition_option1_2').append(new Option('居住地址', 'address'));
          $('#condition_option1_2').append(new Option('有什麼問題想要詢問', 'course_content'));
        }
      }
    }

    // 選項三 Rocky(2020/08/12)
    document.getElementById('condition_option1_2').onchange = function() {

      if ($('#condition2').val() == "tag" && this.value == 'yes') {
        // 選項二
        $('#condition_option2_2').empty();
        $('#condition_option2_2').append(new Option('是', 'yes'));
        $('#condition_option2_2').append(new Option('未', 'no'));
        $('#condition_option2_2').append(new Option('包含', 'like'));
        $('#condition_option2_2').append(new Option('不包含', 'notlike'));

        condition_option2_2.style.display = 'block';
        condition_input3_2.style.display = 'block';
      } else if ($('#condition2').val() == "tag" && this.value == 'no') {
        // 選項二
        $('#condition_option2_2').empty();
        $('#condition_option2_2').append(new Option('是', 'yes'));
        $('#condition_option2_2').append(new Option('包含', 'like'));

        condition_option2_2.style.display = 'block';
        condition_input3_2.style.display = 'block';
      } else if ($('#condition2').val() == "information") {
        condition_option2_2.style.display = 'block';
        condition_input3_2.style.display = 'block';
      } else if ($('#condition2').val() == "action") {
        condition_option2_2.style.display = 'block';
        condition_input3_2.style.display = 'none';
      }


      // 已付、應付金額 Rocky(2020/08/12)
      if ($('#select_type2').val() == "2" && (this.value == 'amount_paid' || this.value == 'amount_payable')) {
        $('#condition_option2_2').empty();
        $('#condition_option2_2').append(new Option('是', 'yes'));
        $('#condition_option2_2').append(new Option('未', 'no'));

        // $('#condition_option2_2').empty();
        // $('#condition_option2_2').append(new Option('等於', '='));
        // $('#condition_option2_2').append(new Option('大於', '>'));
        // $('#condition_option2_2').append(new Option('小於', '<'));
      } else if ($('#select_type2').val() == "2" && $('#condition2').val() == "information") {
        $('#condition_option2_2').empty();
        $('#condition_option2_2').append(new Option('是', 'yes'));
        $('#condition_option2_2').append(new Option('未', 'no'));
        $('#condition_option2_2').append(new Option('包含', 'like'));
        $('#condition_option2_2').append(new Option('不包含', 'notlike'));
      }
    }

    // document.getElementById('condition_option2_2').onchange = function() {
    //   if (this.value == 'present' || this.value == 'cancel' || this.value == 'absent' || this.value == 'pay') {
    //     condition_option3.innerHTML = '<option value="">請選擇</option><option>課程選項</option>';
    //   } else if (this.value == 'participate') {
    //     condition_option3.innerHTML = '<option value="">請選擇</option><option>課程活動</option>';
    //   } else if (this.value == 'open-mail') {
    //     condition_option3.innerHTML = '<option value="">請選擇</option><option>郵件名稱</option>';
    //   } else if (this.value == 'open-sms') {
    //     condition_option3.innerHTML = '<option value="">請選擇</option><option>簡訊名稱</option>';
    //   }
    // }

    // 顯示細分條件資料 Rocky(2020/03/14)
    $("#select_type2").change(function() {
      show_requirement_course($('#select_type2').val(), '#select_course2');
    });
  }

  function show_condition3() {
    //條件類別判斷
    document.getElementById('condition3').onchange = function() {
      var condition_option3 = document.getElementById('condition_option1_3'),
        condition_option2_3 = document.getElementById('condition_option2_3'),
        condition_input3_3 = document.getElementById('condition_input3_3');

      condition_option2_3.style.display = 'none';
      condition_input3_3.style.display = 'none';

      if (this.value == 'information') {
        // 選項一
        if ($('#select_type3').val() == "1") {
          $('#condition_option1_3').empty();
          $('#condition_option1_3').append(new Option('請選擇', ''));
          $('#condition_option1_3').append(new Option('原始來源', 'datasource_old'));
          $('#condition_option1_3').append(new Option('最新來源', 'datasource_new'));
          $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
          $('#condition_option1_3').append(new Option('目前職業', 'profession'));
          $('#condition_option1_3').append(new Option('居住地址', 'address'));
          $('#condition_option1_3').append(new Option('想了解的內容', 'course_content'));
        } else if ($('#select_type3').val() == "2") {
          $('#condition_option1_3').empty();
          $('#condition_option1_3').append(new Option('請選擇', ''));
          $('#condition_option1_3').append(new Option('應付金額', 'amount_payable'));
          $('#condition_option1_3').append(new Option('已付金額', 'amount_paid'));
          $('#condition_option1_3').append(new Option('服務人員', 'person'));
          $('#condition_option1_3').append(new Option('統一發票', 'type_invoice'));
          $('#condition_option1_3').append(new Option('統編', 'number_taxid'));
          $('#condition_option1_3').append(new Option('抬頭', 'companytitle'));
          $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
          $('#condition_option1_3').append(new Option('目前職業', 'profession'));
          $('#condition_option1_3').append(new Option('居住地址', 'address'));

        } else if ($('#select_type3').val() == "3") {
          $('#condition_option1_3').empty();
          $('#condition_option1_3').append(new Option('請選擇', ''));
          $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
          $('#condition_option1_3').append(new Option('目前職業', 'profession'));
          $('#condition_option1_3').append(new Option('居住地址', 'address'));
          $('#condition_option1_3').append(new Option('有什麼問題想要詢問', 'course_content'));

        }

        // 選項二
        $('#condition_option2_3').empty();
        $('#condition_option2_3').append(new Option('是', 'yes'));
        $('#condition_option2_3').append(new Option('未', 'no'));
        $('#condition_option2_3').append(new Option('包含', 'like'));
        $('#condition_option2_3').append(new Option('不包含', 'notlike'));

        // condition_input3_3.style.display = 'block';
      } else if (this.value == 'action') {
        // 選項一
        $('#condition_option1_3').empty();
        $('#condition_option1_3').append(new Option('請選擇', ''));
        $('#condition_option1_3').append(new Option('是', 'yes'));
        $('#condition_option1_3').append(new Option('未', 'no'));

        // 選項二
        $('#condition_option2_3').empty();
        $('#condition_option2_3').append(new Option('請選擇', ''));
        $('#condition_option2_3').append(new Option('報到', '4'));
        $('#condition_option2_3').append(new Option('取消', '5'));
        $('#condition_option2_3').append(new Option('未到', '3'));
        $('#condition_option2_3').append(new Option('我很遺憾', '2'));
        $('#condition_option2_3').append(new Option('完款', '7'));
        $('#condition_option2_3').append(new Option('付訂', '8'));
        $('#condition_option2_3').append(new Option('退款', '9'));
        $('#condition_option2_3').append(new Option('參與', '23'));

        condition_input3_3.style.display = 'none';
      } else if (this.value == 'tag') {
        // 選項一
        $('#condition_option1_3').empty();
        $('#condition_option1_3').append(new Option('請選擇', ''));
        $('#condition_option1_3').append(new Option('已分配', 'yes'));
        $('#condition_option1_3').append(new Option('未分配', 'no'));

        // 選項二
        $('#condition_option2_3').empty();
        $('#condition_option2_3').append(new Option('請選擇', ''));
        $('#condition_option2_3').append(new Option('是', 'yes'));
        $('#condition_option2_3').append(new Option('未', 'no'));
        $('#condition_option2_3').append(new Option('包含', 'like'));
        $('#condition_option2_3').append(new Option('不包含', 'notlike'));

        // condition_input3_3.style.display = 'block';
      }
    };

    // 類型 Rocky(2020/03/20)
    document.getElementById('select_type3').onchange = function() {
      if (this.value == '1') {
        // 銷講
        if ($('#condition3').val() == "information") {
          // 選項一
          $('#condition_option1_3').empty();
          $('#condition_option1_3').append(new Option('請選擇', ''));
          $('#condition_option1_3').append(new Option('原始來源', 'datasource_old'));
          $('#condition_option1_3').append(new Option('最新來源', 'datasource_new'));
          $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
          $('#condition_option1_3').append(new Option('目前職業', 'profession'));
          $('#condition_option1_3').append(new Option('居住地址', 'address'));
          $('#condition_option1_3').append(new Option('想了解的內容', 'course_content'));
        }
      } else if (this.value == '2') {
        // 正課
        // 選項一
        if ($('#condition3').val() == "information") {
          $('#condition_option1_3').empty();
          $('#condition_option1_3').append(new Option('請選擇', ''));
          $('#condition_option1_3').append(new Option('應付金額', 'amount_payable'));
          $('#condition_option1_3').append(new Option('已付金額', 'amount_paid'));
          $('#condition_option1_3').append(new Option('服務人員', 'person'));
          $('#condition_option1_3').append(new Option('統一發票', 'type_invoice'));
          $('#condition_option1_3').append(new Option('統編', 'number_taxid'));
          $('#condition_option1_3').append(new Option('抬頭', 'companytitle'));
          $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
          $('#condition_option1_3').append(new Option('目前職業', 'profession'));
          $('#condition_option1_3').append(new Option('居住地址', 'address'));
        }
      } else if (this.value == '3') {
        // 活動 Rocky(2020/08/13)        
        if ($('#condition2').val() == "information") {
          $('#condition_option1_3').empty();
          $('#condition_option1_3').append(new Option('請選擇', ''));
          $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
          $('#condition_option1_3').append(new Option('目前職業', 'profession'));
          $('#condition_option1_3').append(new Option('居住地址', 'address'));
          $('#condition_option1_3').append(new Option('有什麼問題想要詢問', 'course_content'));

          // 選項二
          $('#condition_option2_2').empty();
          $('#condition_option2_2').append(new Option('是', 'yes'));
          $('#condition_option2_2').append(new Option('未', 'no'));
          $('#condition_option2_2').append(new Option('包含', 'like'));
          $('#condition_option2_2').append(new Option('不包含', 'notlike'));
        }
      }
    }

    // 選項三 Rocky(2020/08/12)
    document.getElementById('condition_option1_3').onchange = function() {

      if ($('#condition3').val() == "tag" && this.value == 'yes') {
        // 選項二
        $('#condition_option2_2').empty();
        $('#condition_option2_2').append(new Option('是', 'yes'));
        $('#condition_option2_2').append(new Option('未', 'no'));
        $('#condition_option2_2').append(new Option('包含', 'like'));
        $('#condition_option2_2').append(new Option('不包含', 'notlike'));

        condition_option2_3.style.display = 'block';
        condition_input3_3.style.display = 'block';
      } else if ($('#condition3').val() == "tag" && this.value == 'no') {
        // 選項二
        $('#condition_option2_2').empty();
        $('#condition_option2_2').append(new Option('是', 'yes'));
        $('#condition_option2_2').append(new Option('包含', 'like'));


        condition_option2_3.style.display = 'block';
        condition_input3_3.style.display = 'block';
      } else if ($('#condition3').val() == "information") {
        condition_option2_3.style.display = 'block';
        condition_input3_3.style.display = 'block';
      } else if ($('#condition3').val() == "action") {
        condition_option2_3.style.display = 'block';
        condition_input3_3.style.display = 'none';
      }

      // 已付、應付金額 Rocky(2020/08/12)
      if ($('#select_type3').val() == "2" && (this.value == 'amount_paid' || this.value == 'amount_payable')) {
        $('#condition_option2_3').empty();
        $('#condition_option2_3').append(new Option('是', 'yes'));
        $('#condition_option2_3').append(new Option('未', 'no'));

        // $('#condition_option2_2').empty();
        // $('#condition_option2_2').append(new Option('等於', '='));
        // $('#condition_option2_2').append(new Option('大於', '>'));
        // $('#condition_option2_2').append(new Option('小於', '<'));
      } else if ($('#select_type3').val() == "2" && $('#condition3').val() == "information") {
        $('#condition_option2_3').empty();
        $('#condition_option2_3').append(new Option('是', 'yes'));
        $('#condition_option2_3').append(new Option('未', 'no'));
        $('#condition_option2_3').append(new Option('包含', 'like'));
        $('#condition_option2_3').append(new Option('不包含', 'notlike'));
      }
    }

    // document.getElementById('condition_option2_3').onchange = function() {
    //   if (this.value == 'present' || this.value == 'cancel' || this.value == 'absent' || this.value == 'pay') {
    //     condition_option3.innerHTML = '<option value="">請選擇</option><option>課程選項</option>';
    //   } else if (this.value == 'participate') {
    //     condition_option3.innerHTML = '<option value="">請選擇</option><option>課程活動</option>';
    //   } else if (this.value == 'open-mail') {
    //     condition_option3.innerHTML = '<option value="">請選擇</option><option>郵件名稱</option>';
    //   } else if (this.value == 'open-sms') {
    //     condition_option3.innerHTML = '<option value="">請選擇</option><option>簡訊名稱</option>';
    //   }
    // }

    // 顯示細分條件資料 Rocky(2020/03/14)
    $("#select_type3").change(function() {
      show_requirement_course($('#select_type3').val(), '#select_course3');
    });
  }
  // function show_condition1() {
  //   //條件類別判斷
  //   document.getElementById('condition').onchange = function() {
  //     var condition_option1 = document.getElementById('condition_option1'),
  //       condition_option2 = document.getElementById('condition_option2')
  //       // ,condition_option3=document.getElementById('condition_option3')
  //       ,
  //       condition_input3 = document.getElementById('condition_input3');

  //     if (this.value == 'information') {
  //       // 選項一
  //       $('#condition_option1').empty();
  //       $('#condition_option1').append(new Option('請選擇', ''));
  //       $('#condition_option1').append(new Option('原始來源', 'datasource_old'));
  //       $('#condition_option1').append(new Option('最新來源', 'datasource_new'));
  //       $('#condition_option1').append(new Option('報名場次', 'id_events'));
  //       $('#condition_option1').append(new Option('目前職業', 'profession'));
  //       $('#condition_option1').append(new Option('居住地址', 'address'));
  //       // $('#condition_option1').append(new Option('銷講後最新狀態', ''));
  //       $('#condition_option1').append(new Option('想了解的內容', 'course_content'));

  //       // 選項二
  //       $('#condition_option2').empty();
  //       $('#condition_option2').append(new Option('是', 'yes'));
  //       $('#condition_option2').append(new Option('未', 'no'));
  //       $('#condition_option2').append(new Option('包含', 'like'));
  //       $('#condition_option2').append(new Option('不包含', 'notlike'));

  //       $('#condition_input3').val('');
  //       condition_input3.style.display = 'block';

  //     } else if (this.value == 'action') {
  //       // 選項一
  //       $('#condition_option1').empty();
  //       $('#condition_option1').append(new Option('請選擇', ''));
  //       $('#condition_option1').append(new Option('是', 'yes'));
  //       $('#condition_option1').append(new Option('未', 'no'));

  //       // 選項二
  //       $('#condition_option2').empty();
  //       $('#condition_option2').append(new Option('請選擇', ''));
  //       $('#condition_option2').append(new Option('報到', '4'));
  //       $('#condition_option2').append(new Option('取消', '5'));
  //       $('#condition_option2').append(new Option('未到', '3'));
  //       $('#condition_option2').append(new Option('留單', '6'));
  //       $('#condition_option2').append(new Option('完款', '7'));
  //       $('#condition_option2').append(new Option('付訂', '8'));
  //       $('#condition_option2').append(new Option('退款', '9'));
  //       $('#condition_option2').append(new Option('參與', ''));
  //       // $('#condition_option2').append(new Option('打開郵件', ''));
  //       // $('#condition_option2').append(new Option('打開簡訊', ''));

  //       // condition_option2.innerHTML='<option value="">請選擇</option><option value="present">報到</option><option value="cancel">取消</option><option value="absent">未到</option><option value="pay">交付</option><option value="participate">參與</option><option value="open-mail">打開郵件</option><option value="open-sms">打開簡訊</option>';
  //       // condition_option3.style.display='block';
  //       $('#condition_input3').val('');
  //       condition_input3.style.display = 'none';
  //     } else if (this.value == 'tag') {
  //       // 選項一
  //       $('#condition_option1').empty();
  //       $('#condition_option1').append(new Option('請選擇', ''));
  //       $('#condition_option1').append(new Option('已分配', 'yes'));
  //       $('#condition_option1').append(new Option('未分配', 'no'));
  //       // condition_option1.innerHTML='<option value="">請選擇</option><option>已分配</option><option>未分配</option>';
  //       // 選項二
  //       $('#condition_option2').empty();
  //       $('#condition_option2').append(new Option('請選擇', ''));
  //       $('#condition_option2').append(new Option('是', 'yes'));
  //       $('#condition_option2').append(new Option('未', 'no'));
  //       $('#condition_option2').append(new Option('包含', 'like'));
  //       $('#condition_option2').append(new Option('不包含', 'notlike'));

  //       // condition_option2.innerHTML='<option value="">請選擇</option><option>是</option><option>未</option><option>包含</option><option>不包含</option>';
  //       $('#condition_input3').val('');
  //       condition_input3.style.display = 'block';
  //       // condition_option3.style.display='none';
  //     }
  //   };
  //   // 類型 Rocky(2020/03/20)
  //   document.getElementById('select_type').onchange = function() {
  //     if (this.value == '1') {
  //       // 銷講
  //       if ($('#condition').val() == "information") {
  //         // 選項一
  //         $('#condition_option1').empty();
  //         $('#condition_option1').append(new Option('請選擇', ''));
  //         $('#condition_option1').append(new Option('原始來源', 'datasource_old'));
  //         $('#condition_option1').append(new Option('最新來源', 'datasource_new'));
  //         $('#condition_option1').append(new Option('報名場次', 'id_events'));
  //         $('#condition_option1').append(new Option('目前職業', 'profession'));
  //         $('#condition_option1').append(new Option('居住地址', 'address'));
  //         // $('#condition_option1').append(new Option('銷講後最新狀態', ''));
  //         $('#condition_option1').append(new Option('想了解的內容', 'course_content'));

  //         // 選項二
  //         $('#condition_option2').empty();
  //         $('#condition_option2').append(new Option('是', 'yes'));
  //         $('#condition_option2').append(new Option('未', 'no'));
  //         $('#condition_option2').append(new Option('包含', 'like'));
  //         $('#condition_option2').append(new Option('不包含', 'notlike'));
  //       }
  //     } else if (this.value == '2') {
  //       // 正課
  //       // 選項一
  //       if ($('#condition').val() == "information") {
  //         $('#condition_option1').empty();
  //         $('#condition_option1').append(new Option('請選擇', ''));
  //         $('#condition_option1').append(new Option('應付金額', 'amount_payable'));
  //         $('#condition_option1').append(new Option('已付金額', 'amount_paid'));
  //         $('#condition_option1').append(new Option('服務人員', 'person'));
  //         $('#condition_option1').append(new Option('統一發票', 'type_invoice'));
  //         $('#condition_option1').append(new Option('統編', 'number_taxid'));
  //         $('#condition_option1').append(new Option('抬頭', 'companytitle'));
  //         $('#condition_option1').append(new Option('報名場次', 'id_events'));
  //         $('#condition_option1').append(new Option('目前職業', 'profession'));
  //         $('#condition_option1').append(new Option('居住地址', 'address'));
  //       }
  //     }
  //   }

  //   // 標籤 Rocky(2020/08/12)
  //   document.getElementById('condition_option1').onchange = function() {
  //     $('#condition_input3').val('');
  //     $('#condition_option2').val('');
  //     if ($('#condition').val() == "tag" && this.value == 'yes') {
  //       condition_option2.style.display = 'block';
  //       condition_input3.style.display = 'block';
  //     } else if ($('#condition').val() == "tag" && this.value == 'no') {
  //       condition_option2.style.display = 'none';
  //       condition_input3.style.display = 'block';
  //     }

  //     // 已付、應付金額 Rocky(2020/08/12)
  //     if ($('#select_type').val() == "2" && (this.value == 'amount_paid' || this.value == 'amount_payable')) {
  //       $('#condition_option2').empty();
  //       $('#condition_option2').append(new Option('是', 'yes'));
  //       $('#condition_option2').append(new Option('未', 'no'));

  //       // $('#condition_option2').empty();
  //       // $('#condition_option2').append(new Option('等於', '='));
  //       // $('#condition_option2').append(new Option('大於', '>'));
  //       // $('#condition_option2').append(new Option('小於', '<'));
  //     } else if ($('#select_type').val() == "2") {
  //       $('#condition_option2').empty();
  //       $('#condition_option2').append(new Option('是', 'yes'));
  //       $('#condition_option2').append(new Option('未', 'no'));
  //       $('#condition_option2').append(new Option('包含', 'like'));
  //       $('#condition_option2').append(new Option('不包含', 'notlike'));
  //     }
  //   }

  //   document.getElementById('condition_option2').onchange = function() {
  //     if (this.value == 'present' || this.value == 'cancel' || this.value == 'absent' || this.value == 'pay') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>課程選項</option>';
  //     } else if (this.value == 'participate') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>課程活動</option>';
  //     } else if (this.value == 'open-mail') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>郵件名稱</option>';
  //     } else if (this.value == 'open-sms') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>簡訊名稱</option>';
  //     }
  //   }

  //   // 顯示細分條件資料 Rocky(2020/03/14)
  //   $("#select_type").change(function() {
  //     show_requirement_course($('#select_type').val(), "#select_course");
  //   });
  // }

  // function show_condition2() {
  //   //條件類別判斷
  //   document.getElementById('condition2').onchange = function() {
  //     var condition_option1 = document.getElementById('condition_option1_2'),
  //       condition_option2_2 = document.getElementById('condition_option2_2'),
  //       condition_input3_2 = document.getElementById('condition_input3_2');

  //     if (this.value == 'information') {
  //       // 選項一
  //       $('#condition_option1_2').empty();
  //       $('#condition_option1_2').append(new Option('請選擇', ''));
  //       $('#condition_option1_2').append(new Option('原始來源', 'datasource_old'));
  //       $('#condition_option1_2').append(new Option('最新來源', 'datasource_new'));
  //       $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
  //       $('#condition_option1_2').append(new Option('目前職業', 'profession'));
  //       $('#condition_option1_2').append(new Option('居住地址', 'address'));
  //       // $('#condition_option1_2').append(new Option('銷講後最新狀態', ''));
  //       $('#condition_option1_2').append(new Option('想了解的內容', 'course_content'));

  //       // 選項二
  //       $('#condition_option2_2').empty();
  //       $('#condition_option2_2').append(new Option('是', 'yes'));
  //       $('#condition_option2_2').append(new Option('未', 'no'));
  //       $('#condition_option2_2').append(new Option('包含', 'like'));
  //       $('#condition_option2_2').append(new Option('不包含', 'notlike'));

  //       condition_input3_2.style.display = 'block';
  //     } else if (this.value == 'action') {
  //       // 選項一
  //       $('#condition_option1_2').empty();
  //       $('#condition_option1_2').append(new Option('請選擇', ''));
  //       $('#condition_option1_2').append(new Option('是', 'yes'));
  //       $('#condition_option1_2').append(new Option('未', 'no'));

  //       // 選項二
  //       $('#condition_option2_2').empty();
  //       $('#condition_option2_2').append(new Option('請選擇', ''));
  //       $('#condition_option2_2').append(new Option('報到', '4'));
  //       $('#condition_option2_2').append(new Option('取消', '5'));
  //       $('#condition_option2_2').append(new Option('未到', '3'));
  //       $('#condition_option2_2').append(new Option('完款', '7'));
  //       $('#condition_option2_2').append(new Option('付訂', '8'));
  //       $('#condition_option2_2').append(new Option('退款', '9'));
  //       $('#condition_option2_2').append(new Option('參與', ''));
  //       // $('#condition_option2_2').append(new Option('打開郵件', ''));
  //       // $('#condition_option2_2').append(new Option('打開簡訊', ''));

  //       condition_input3_2.style.display = 'none';
  //     } else if (this.value == 'tag') {
  //       // 選項一
  //       $('#condition_option1_2').empty();
  //       $('#condition_option1_2').append(new Option('請選擇', ''));
  //       $('#condition_option1_2').append(new Option('已分配', 'yes'));
  //       $('#condition_option1_2').append(new Option('未分配', 'no'));

  //       // 選項二
  //       $('#condition_option2_2').empty();
  //       $('#condition_option2_2').append(new Option('請選擇', ''));
  //       $('#condition_option2_2').append(new Option('是', 'yes'));
  //       $('#condition_option2_2').append(new Option('未', 'no'));
  //       $('#condition_option2_2').append(new Option('包含', 'like'));
  //       $('#condition_option2_2').append(new Option('不包含', 'notlike'));

  //       condition_input3_2.style.display = 'block';
  //     }
  //   };

  //   // 類型 Rocky(2020/03/20)
  //   document.getElementById('select_type2').onchange = function() {
  //     if (this.value == '1') {
  //       // 銷講
  //       if ($('#condition2').val() == "information") {
  //         // 選項一
  //         $('#condition_option1_2').empty();
  //         $('#condition_option1_2').append(new Option('請選擇', ''));
  //         $('#condition_option1_2').append(new Option('原始來源', 'datasource_old'));
  //         $('#condition_option1_2').append(new Option('最新來源', 'datasource_new'));
  //         $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
  //         $('#condition_option1_2').append(new Option('目前職業', 'profession'));
  //         $('#condition_option1_2').append(new Option('居住地址', 'address'));
  //         // $('#condition_option1_2').append(new Option('銷講後最新狀態', ''));
  //         $('#condition_option1_2').append(new Option('想了解的內容', 'course_content'));



  //         // 選項二
  //         // $('#condition_option2_1').empty();
  //         // $('#condition_option2_1').append(new Option('是', 'yes'));
  //         // $('#condition_option2_1').append(new Option('未', 'no'));
  //         // $('#condition_option2_1').append(new Option('包含', 'like'));
  //         // $('#condition_option2_1').append(new Option('不包含', 'notlike'));
  //       }
  //     } else if (this.value == '2') {
  //       // 正課
  //       // 選項一
  //       if ($('#condition2').val() == "information") {
  //         $('#condition_option1_2').empty();
  //         $('#condition_option1_2').append(new Option('請選擇', ''));
  //         $('#condition_option1_2').append(new Option('應付金額', 'amount_payable'));
  //         $('#condition_option1_2').append(new Option('已付金額', 'amount_paid'));
  //         $('#condition_option1_2').append(new Option('服務人員', 'person'));
  //         $('#condition_option1_2').append(new Option('統一發票', 'type_invoice'));
  //         $('#condition_option1_2').append(new Option('統編', 'number_taxid'));
  //         $('#condition_option1_2').append(new Option('抬頭', 'companytitle'));
  //         $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
  //         $('#condition_option1_2').append(new Option('目前職業', 'profession'));
  //         $('#condition_option1_2').append(new Option('居住地址', 'address'));
  //       }
  //     } else if (this.value == '3') {
  //       // 活動
  //       // 選項一
  //       $('#condition_option1_2').empty();
  //       $('#condition_option1_2').append(new Option('請選擇', ''));
  //       $('#condition_option1_2').append(new Option('原始來源', 'datasource_old'));
  //       $('#condition_option1_2').append(new Option('最新來源', 'datasource_new'));
  //       $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
  //       $('#condition_option1_2').append(new Option('目前職業', 'profession'));
  //       $('#condition_option1_2').append(new Option('居住地址', 'address'));
  //       // $('#condition_option1_2').append(new Option('銷講後最新狀態', ''));
  //       $('#condition_option1_2').append(new Option('想了解的內容', 'course_content'));
  //     }
  //   }

  //   // 標籤 Rocky(2020/08/12)
  //   document.getElementById('condition_option1_2').onchange = function() {
  //     if (this.value == 'yes') {
  //       condition_option2_2.style.display = 'block';
  //       condition_input3_2.style.display = 'block';
  //     } else if (this.value == 'no') {
  //       condition_option2_2.style.display = 'none';
  //       condition_input3_2.style.display = 'block';
  //     }

  //     // 已付、應付金額 Rocky(2020/08/12)
  //     if ($('#select_type2').val() == "2" && (this.value == 'amount_paid' || this.value == 'amount_payable')) {
  //       $('#condition_option2_2').empty();
  //       $('#condition_option2_2').append(new Option('是', 'yes'));
  //       $('#condition_option2_2').append(new Option('未', 'no'));

  //       // $('#condition_option2_2').empty();
  //       // $('#condition_option2_2').append(new Option('等於', '='));
  //       // $('#condition_option2_2').append(new Option('大於', '>'));
  //       // $('#condition_option2_2').append(new Option('小於', '<'));
  //     } else if ($('#select_type2').val() == "2") {
  //       $('#condition_option2_2').empty();
  //       $('#condition_option2_2').append(new Option('是', 'yes'));
  //       $('#condition_option2_2').append(new Option('未', 'no'));
  //       $('#condition_option2_2').append(new Option('包含', 'like'));
  //       $('#condition_option2_2').append(new Option('不包含', 'notlike'));
  //     }
  //   }

  //   document.getElementById('condition_option2_2').onchange = function() {
  //     if (this.value == 'present' || this.value == 'cancel' || this.value == 'absent' || this.value == 'pay') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>課程選項</option>';
  //     } else if (this.value == 'participate') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>課程活動</option>';
  //     } else if (this.value == 'open-mail') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>郵件名稱</option>';
  //     } else if (this.value == 'open-sms') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>簡訊名稱</option>';
  //     }
  //   }

  //   // 顯示細分條件資料 Rocky(2020/03/14)
  //   $("#select_type2").change(function() {
  //     show_requirement_course($('#select_type2').val(), '#select_course2');
  //   });
  // }

  // function show_condition3() {
  //   //條件類別判斷
  //   document.getElementById('condition3').onchange = function() {
  //     var condition_option3 = document.getElementById('condition_option1_3'),
  //       condition_option2_3 = document.getElementById('condition_option2_3'),
  //       condition_input3_3 = document.getElementById('condition_input3_3');

  //     if (this.value == 'information') {
  //       // 選項一
  //       $('#condition_option1_3').empty();
  //       $('#condition_option1_3').append(new Option('請選擇', ''));
  //       $('#condition_option1_3').append(new Option('原始來源', 'datasource_old'));
  //       $('#condition_option1_3').append(new Option('最新來源', 'datasource_new'));
  //       $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
  //       $('#condition_option1_3').append(new Option('目前職業', 'profession'));
  //       $('#condition_option1_3').append(new Option('居住地址', 'address'));
  //       // $('#condition_option1_3').append(new Option('銷講後最新狀態', ''));
  //       $('#condition_option1_3').append(new Option('想了解的內容', 'course_content'));

  //       // 選項二
  //       $('#condition_option2_3').empty();
  //       $('#condition_option2_3').append(new Option('是', 'yes'));
  //       $('#condition_option2_3').append(new Option('未', 'no'));
  //       $('#condition_option2_3').append(new Option('包含', 'like'));
  //       $('#condition_option2_3').append(new Option('不包含', 'notlike'));

  //       condition_input3_3.style.display = 'block';
  //     } else if (this.value == 'action') {
  //       // 選項一
  //       $('#condition_option1_3').empty();
  //       $('#condition_option1_3').append(new Option('請選擇', ''));
  //       $('#condition_option1_3').append(new Option('是', 'yes'));
  //       $('#condition_option1_3').append(new Option('未', 'no'));

  //       // 選項二
  //       $('#condition_option2_3').empty();
  //       $('#condition_option2_3').append(new Option('請選擇', ''));
  //       $('#condition_option2_3').append(new Option('報到', '4'));
  //       $('#condition_option2_3').append(new Option('取消', '5'));
  //       $('#condition_option2_3').append(new Option('未到', '3'));
  //       $('#condition_option2_3').append(new Option('完款', '7'));
  //       $('#condition_option2_3').append(new Option('付訂', '8'));
  //       $('#condition_option2_3').append(new Option('退款', '9'));
  //       $('#condition_option2_3').append(new Option('參與', ''));
  //       // $('#condition_option2_3').append(new Option('打開郵件', ''));
  //       // $('#condition_option2_3').append(new Option('打開簡訊', ''));

  //       condition_input3_3.style.display = 'none';
  //     } else if (this.value == 'tag') {
  //       // 選項一
  //       $('#condition_option1_3').empty();
  //       $('#condition_option1_3').append(new Option('請選擇', ''));
  //       $('#condition_option1_3').append(new Option('已分配', 'yes'));
  //       $('#condition_option1_3').append(new Option('未分配', 'no'));

  //       // 選項二
  //       $('#condition_option2_3').empty();
  //       $('#condition_option2_3').append(new Option('請選擇', ''));
  //       $('#condition_option2_3').append(new Option('是', 'yes'));
  //       $('#condition_option2_3').append(new Option('未', 'no'));
  //       $('#condition_option2_3').append(new Option('包含', 'like'));
  //       $('#condition_option2_3').append(new Option('不包含', 'notlike'));

  //       condition_input3_3.style.display = 'block';
  //     }
  //   };
  //   // 類型 Rocky(2020/03/20)
  //   document.getElementById('select_type3').onchange = function() {
  //     if (this.value == '1') {
  //       // 銷講
  //       if ($('#condition3').val() == "information") {
  //         // 選項一
  //         $('#condition_option1_3').empty();
  //         $('#condition_option1_3').append(new Option('請選擇', ''));
  //         $('#condition_option1_3').append(new Option('原始來源', 'datasource_old'));
  //         $('#condition_option1_3').append(new Option('最新來源', 'datasource_new'));
  //         $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
  //         $('#condition_option1_3').append(new Option('目前職業', 'profession'));
  //         $('#condition_option1_3').append(new Option('居住地址', 'address'));
  //         // $('#condition_option1_3').append(new Option('銷講後最新狀態', ''));
  //         $('#condition_option1_3').append(new Option('想了解的內容', 'course_content'));
  //       }
  //     } else if (this.value == '2') {
  //       // 正課
  //       // 選項一
  //       if ($('#condition3').val() == "information") {
  //         $('#condition_option1_3').empty();
  //         $('#condition_option1_3').append(new Option('請選擇', ''));
  //         $('#condition_option1_3').append(new Option('應付金額', 'amount_payable'));
  //         $('#condition_option1_3').append(new Option('已付金額', 'amount_paid'));
  //         $('#condition_option1_3').append(new Option('服務人員', 'person'));
  //         $('#condition_option1_3').append(new Option('統一發票', 'type_invoice'));
  //         $('#condition_option1_3').append(new Option('統編', 'number_taxid'));
  //         $('#condition_option1_3').append(new Option('抬頭', 'companytitle'));
  //         $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
  //         $('#condition_option1_3').append(new Option('目前職業', 'profession'));
  //         $('#condition_option1_3').append(new Option('居住地址', 'address'));
  //       }
  //     } else if (this.value == '3') {
  //       // 活動
  //       // 選項一
  //       $('#condition_option1_3').empty();
  //       $('#condition_option1_3').append(new Option('請選擇', ''));
  //       $('#condition_option1_3').append(new Option('原始來源', 'datasource_old'));
  //       $('#condition_option1_3').append(new Option('最新來源', 'datasource_new'));
  //       $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
  //       $('#condition_option1_3').append(new Option('目前職業', 'profession'));
  //       $('#condition_option1_3').append(new Option('居住地址', 'address'));
  //       // $('#condition_option1_3').append(new Option('銷講後最新狀態', ''));
  //       $('#condition_option1_3').append(new Option('想了解的內容', 'course_content'));
  //     }
  //   }

  //   // 標籤 Rocky(2020/08/12)
  //   document.getElementById('condition_option1_3').onchange = function() {
  //     if (this.value == 'yes') {
  //       condition_option2_3.style.display = 'block';
  //       condition_input3_3.style.display = 'block';
  //     } else if (this.value == 'no') {
  //       condition_option2_3.style.display = 'none';
  //       condition_input3_3.style.display = 'block';
  //     }
  //   }

  //   document.getElementById('condition_option2_3').onchange = function() {
  //     if (this.value == 'present' || this.value == 'cancel' || this.value == 'absent' || this.value == 'pay') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>課程選項</option>';
  //     } else if (this.value == 'participate') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>課程活動</option>';
  //     } else if (this.value == 'open-mail') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>郵件名稱</option>';
  //     } else if (this.value == 'open-sms') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>簡訊名稱</option>';
  //     }
  //   }

  //   // 顯示細分條件資料 Rocky(2020/03/14)
  //   $("#select_type3").change(function() {
  //     show_requirement_course($('#select_type3').val(), '#select_course3');
  //   });
  // }
  // function show_condition1() {
  //   //條件類別判斷
  //   document.getElementById('condition').onchange = function() {
  //     var condition_option1 = document.getElementById('condition_option1'),
  //       condition_option2 = document.getElementById('condition_option2')
  //       // ,condition_option3=document.getElementById('condition_option3')
  //       ,
  //       condition_input3 = document.getElementById('condition_input3');

  //     if (this.value == 'information') {
  //       // 選項一
  //       $('#condition_option1').empty();
  //       $('#condition_option1').append(new Option('請選擇', ''));
  //       $('#condition_option1').append(new Option('原始來源', 'datasource_old'));
  //       $('#condition_option1').append(new Option('最新來源', 'datasource_new'));
  //       $('#condition_option1').append(new Option('報名場次', 'id_events'));
  //       $('#condition_option1').append(new Option('目前職業', 'profession'));
  //       $('#condition_option1').append(new Option('居住地址', 'address'));
  //       // $('#condition_option1').append(new Option('銷講後最新狀態', ''));
  //       $('#condition_option1').append(new Option('想了解的內容', 'course_content'));

  //       // 選項二
  //       $('#condition_option2').empty();
  //       $('#condition_option2').append(new Option('是', 'yes'));
  //       $('#condition_option2').append(new Option('未', 'no'));
  //       $('#condition_option2').append(new Option('包含', 'like'));
  //       $('#condition_option2').append(new Option('不包含', 'notlike'));

  //       // <option value="yes">是</option>
  //       //                 <option value="no">未</option>
  //       //                 <option value="like">包含</option>
  //       //                 <option value="notlike">不包含</option>
  //       // condition_option1.innerHTML='<option value="">請選擇</option><option>原始來源</option><option>最新來源</option><option>報名場次</option><option>目前職業</option><option>居住地址</option><option>銷講後最新狀態</option><option>想了解的內容</option>';
  //       // condition_option2.innerHTML='<option value="">請選擇</option><option>是</option><option>未</option><option>包含</option><option>不包含</option>';
  //       condition_input3.style.display = 'block';
  //       // condition_option3.style.display='none';
  //     } else if (this.value == 'action') {
  //       // 選項一
  //       $('#condition_option1').empty();
  //       $('#condition_option1').append(new Option('請選擇', ''));
  //       $('#condition_option1').append(new Option('是', 'yes'));
  //       $('#condition_option1').append(new Option('未', 'no'));
  //       // condition_option1.innerHTML='<option value="">請選擇</option><option>是</option><option>未</option>';
  //       // 選項二
  //       $('#condition_option2').empty();
  //       $('#condition_option2').append(new Option('請選擇', ''));
  //       $('#condition_option2').append(new Option('報到', '4'));
  //       $('#condition_option2').append(new Option('取消', '5'));
  //       $('#condition_option2').append(new Option('未到', '3'));
  //       $('#condition_option2').append(new Option('留單', '6'));
  //       $('#condition_option2').append(new Option('完款', '7'));
  //       $('#condition_option2').append(new Option('付訂', '8'));
  //       $('#condition_option2').append(new Option('退款', '9'));
  //       $('#condition_option2').append(new Option('參與', ''));
  //       // $('#condition_option2').append(new Option('打開郵件', ''));
  //       // $('#condition_option2').append(new Option('打開簡訊', ''));

  //       // condition_option2.innerHTML='<option value="">請選擇</option><option value="present">報到</option><option value="cancel">取消</option><option value="absent">未到</option><option value="pay">交付</option><option value="participate">參與</option><option value="open-mail">打開郵件</option><option value="open-sms">打開簡訊</option>';
  //       // condition_option3.style.display='block';
  //       condition_input3.style.display = 'none';
  //     } else if (this.value == 'tag') {
  //       // 選項一
  //       $('#condition_option1').empty();
  //       $('#condition_option1').append(new Option('請選擇', ''));
  //       $('#condition_option1').append(new Option('已分配', 'yes'));
  //       $('#condition_option1').append(new Option('未分配', 'no'));
  //       // condition_option1.innerHTML='<option value="">請選擇</option><option>已分配</option><option>未分配</option>';
  //       // 選項二
  //       $('#condition_option2').empty();
  //       $('#condition_option2').append(new Option('請選擇', ''));
  //       $('#condition_option2').append(new Option('是', 'yes'));
  //       $('#condition_option2').append(new Option('未', 'no'));
  //       $('#condition_option2').append(new Option('包含', 'like'));
  //       $('#condition_option2').append(new Option('不包含', 'notlike'));

  //       // condition_option2.innerHTML='<option value="">請選擇</option><option>是</option><option>未</option><option>包含</option><option>不包含</option>';
  //       condition_input3.style.display = 'block';
  //       // condition_option3.style.display='none';
  //     }
  //   };
  //   // 類型 Rocky(2020/03/20)
  //   document.getElementById('select_type').onchange = function() {
  //     if (this.value == '1') {
  //       // 銷講
  //       if ($('#condition').val() == "information") {
  //         // 選項一
  //         $('#condition_option1').empty();
  //         $('#condition_option1').append(new Option('請選擇', ''));
  //         $('#condition_option1').append(new Option('原始來源', 'datasource_old'));
  //         $('#condition_option1').append(new Option('最新來源', 'datasource_new'));
  //         $('#condition_option1').append(new Option('報名場次', 'id_events'));
  //         $('#condition_option1').append(new Option('目前職業', 'profession'));
  //         $('#condition_option1').append(new Option('居住地址', 'address'));
  //         // $('#condition_option1').append(new Option('銷講後最新狀態', ''));
  //         $('#condition_option1').append(new Option('想了解的內容', 'course_content'));
  //       }
  //     } else if (this.value == '2') {
  //       // 正課
  //       // 選項一
  //       if ($('#condition').val() == "information") {
  //         $('#condition_option1').empty();
  //         $('#condition_option1').append(new Option('請選擇', ''));
  //         $('#condition_option1').append(new Option('應付金額', 'amount_payable'));
  //         $('#condition_option1').append(new Option('已付金額', 'amount_paid'));
  //         $('#condition_option1').append(new Option('服務人員', 'person'));
  //         $('#condition_option1').append(new Option('統一發票', 'type_invoice'));
  //         $('#condition_option1').append(new Option('統編', 'number_taxid'));
  //         $('#condition_option1').append(new Option('抬頭', 'companytitle'));
  //         $('#condition_option1').append(new Option('報名場次', 'id_events'));
  //         $('#condition_option1').append(new Option('目前職業', 'profession'));
  //         $('#condition_option1').append(new Option('居住地址', 'address'));
  //       }
  //     } else if (this.value == '3') {
  //       // 活動
  //       // 選項一
  //       $('#condition_option1').empty();
  //       $('#condition_option1').append(new Option('請選擇', ''));
  //       $('#condition_option1').append(new Option('原始來源', 'datasource_old'));
  //       $('#condition_option1').append(new Option('最新來源', 'datasource_new'));
  //       $('#condition_option1').append(new Option('報名場次', 'id_events'));
  //       $('#condition_option1').append(new Option('目前職業', 'profession'));
  //       $('#condition_option1').append(new Option('居住地址', 'address'));
  //       // $('#condition_option1').append(new Option('銷講後最新狀態', ''));
  //       $('#condition_option1').append(new Option('想了解的內容', 'course_content'));
  //     }
  //   }

  //   // 選項一 Rocky(2020/03/20)
  //   document.getElementById('condition_option1').onchange = function() {
  //     if (this.value == 'yes') {
  //       condition_option2.style.display = 'block';
  //     } else if (this.value == 'no') {
  //       condition_option2.style.display = 'none';
  //       condition_input3.style.display = 'none';
  //     }

  //     // 已付、應付金額 Rocky(2020/08/12)
  //     if ($('#select_type').val() == "2" && (this.value == 'amount_paid' || this.value == 'amount_payable')) {
  //       $('#condition_option2').empty();
  //       $('#condition_option2').append(new Option('是', 'yes'));
  //       $('#condition_option2').append(new Option('未', 'no'));

  //       // $('#condition_option2').empty();
  //       // $('#condition_option2').append(new Option('等於', '='));
  //       // $('#condition_option2').append(new Option('大於', '>'));
  //       // $('#condition_option2').append(new Option('小於', '<'));
  //     } else if ($('#select_type').val() == "2") {
  //       $('#condition_option2').empty();
  //       $('#condition_option2').append(new Option('是', 'yes'));
  //       $('#condition_option2').append(new Option('未', 'no'));
  //       $('#condition_option2').append(new Option('包含', 'like'));
  //       $('#condition_option2').append(new Option('不包含', 'notlike'));
  //     }
  //   }

  //   document.getElementById('condition_option2').onchange = function() {
  //     if (this.value == 'present' || this.value == 'cancel' || this.value == 'absent' || this.value == 'pay') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>課程選項</option>';
  //     } else if (this.value == 'participate') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>課程活動</option>';
  //     } else if (this.value == 'open-mail') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>郵件名稱</option>';
  //     } else if (this.value == 'open-sms') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>簡訊名稱</option>';
  //     }
  //   }

  //   // 顯示細分條件資料 Rocky(2020/03/14)
  //   $("#select_type").change(function() {
  //     show_requirement_course($('#select_type').val(), "#select_course");
  //   });
  // }


  // function show_condition2() {
  //   //條件類別判斷
  //   document.getElementById('condition2').onchange = function() {
  //     var condition_option1 = document.getElementById('condition_option1_2'),
  //       condition_option2_2 = document.getElementById('condition_option2_2'),
  //       condition_input3_2 = document.getElementById('condition_input3_2');

  //     if (this.value == 'information') {
  //       // 選項一
  //       $('#condition_option1_2').empty();
  //       $('#condition_option1_2').append(new Option('請選擇', ''));
  //       $('#condition_option1_2').append(new Option('原始來源', 'datasource_old'));
  //       $('#condition_option1_2').append(new Option('最新來源', 'datasource_new'));
  //       $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
  //       $('#condition_option1_2').append(new Option('目前職業', 'profession'));
  //       $('#condition_option1_2').append(new Option('居住地址', 'address'));
  //       // $('#condition_option1_2').append(new Option('銷講後最新狀態', ''));
  //       $('#condition_option1_2').append(new Option('想了解的內容', 'course_content'));

  //       // 選項二
  //       $('#condition_option2_2').empty();
  //       $('#condition_option2_2').append(new Option('是', 'yes'));
  //       $('#condition_option2_2').append(new Option('未', 'no'));
  //       $('#condition_option2_2').append(new Option('包含', 'like'));
  //       $('#condition_option2_2').append(new Option('不包含', 'notlike'));

  //       condition_input3_2.style.display = 'block';
  //     } else if (this.value == 'action') {
  //       // 選項一
  //       $('#condition_option1_2').empty();
  //       $('#condition_option1_2').append(new Option('請選擇', ''));
  //       $('#condition_option1_2').append(new Option('是', 'yes'));
  //       $('#condition_option1_2').append(new Option('未', 'no'));

  //       // 選項二
  //       $('#condition_option2_2').empty();
  //       $('#condition_option2_2').append(new Option('請選擇', ''));
  //       $('#condition_option2_2').append(new Option('報到', '4'));
  //       $('#condition_option2_2').append(new Option('取消', '5'));
  //       $('#condition_option2_2').append(new Option('未到', '3'));
  //       $('#condition_option2_2').append(new Option('完款', '7'));
  //       $('#condition_option2_2').append(new Option('付訂', '8'));
  //       $('#condition_option2_2').append(new Option('退款', '9'));
  //       $('#condition_option2_2').append(new Option('參與', ''));
  //       // $('#condition_option2_2').append(new Option('打開郵件', ''));
  //       // $('#condition_option2_2').append(new Option('打開簡訊', ''));

  //       condition_input3_2.style.display = 'none';
  //     } else if (this.value == 'tag') {
  //       // 選項一
  //       $('#condition_option1_2').empty();
  //       $('#condition_option1_2').append(new Option('請選擇', ''));
  //       $('#condition_option1_2').append(new Option('已分配', 'yes'));
  //       $('#condition_option1_2').append(new Option('未分配', 'no'));

  //       // 選項二
  //       $('#condition_option2_2').empty();
  //       $('#condition_option2_2').append(new Option('請選擇', ''));
  //       $('#condition_option2_2').append(new Option('是', 'yes'));
  //       $('#condition_option2_2').append(new Option('未', 'no'));
  //       $('#condition_option2_2').append(new Option('包含', 'like'));
  //       $('#condition_option2_2').append(new Option('不包含', 'notlike'));

  //       condition_input3_2.style.display = 'block';
  //     }
  //   };
  //   // 類型 Rocky(2020/03/20)
  //   document.getElementById('select_type2').onchange = function() {
  //     if (this.value == '1') {
  //       // 銷講
  //       if ($('#condition2').val() == "information") {
  //         // 選項一
  //         $('#condition_option1_2').empty();
  //         $('#condition_option1_2').append(new Option('請選擇', ''));
  //         $('#condition_option1_2').append(new Option('原始來源', 'datasource_old'));
  //         $('#condition_option1_2').append(new Option('最新來源', 'datasource_new'));
  //         $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
  //         $('#condition_option1_2').append(new Option('目前職業', 'profession'));
  //         $('#condition_option1_2').append(new Option('居住地址', 'address'));
  //         // $('#condition_option1_2').append(new Option('銷講後最新狀態', ''));
  //         $('#condition_option1_2').append(new Option('想了解的內容', 'course_content'));
  //       }
  //     } else if (this.value == '2') {
  //       // 正課
  //       // 選項一
  //       if ($('#condition2').val() == "information") {
  //         $('#condition_option1_2').empty();
  //         $('#condition_option1_2').append(new Option('請選擇', ''));
  //         $('#condition_option1_2').append(new Option('應付金額', 'amount_payable'));
  //         $('#condition_option1_2').append(new Option('已付金額', 'amount_paid'));
  //         $('#condition_option1_2').append(new Option('服務人員', 'person'));
  //         $('#condition_option1_2').append(new Option('統一發票', 'type_invoice'));
  //         $('#condition_option1_2').append(new Option('統編', 'number_taxid'));
  //         $('#condition_option1_2').append(new Option('抬頭', 'companytitle'));
  //         $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
  //         $('#condition_option1_2').append(new Option('目前職業', 'profession'));
  //         $('#condition_option1_2').append(new Option('居住地址', 'address'));
  //       }
  //     } else if (this.value == '3') {
  //       // 活動
  //       // 選項一
  //       $('#condition_option1_2').empty();
  //       $('#condition_option1_2').append(new Option('請選擇', ''));
  //       $('#condition_option1_2').append(new Option('原始來源', 'datasource_old'));
  //       $('#condition_option1_2').append(new Option('最新來源', 'datasource_new'));
  //       $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
  //       $('#condition_option1_2').append(new Option('目前職業', 'profession'));
  //       $('#condition_option1_2').append(new Option('居住地址', 'address'));
  //       // $('#condition_option1_2').append(new Option('銷講後最新狀態', ''));
  //       $('#condition_option1_2').append(new Option('想了解的內容', 'course_content'));
  //     }
  //   }

  //   // 選項一 Rocky(2020/03/20)
  //   document.getElementById('condition_option1_2').onchange = function() {
  //     if (this.value == 'yes') {
  //       condition_option2_2.style.display = 'block';
  //     } else if (this.value == 'no') {
  //       condition_option2_2.style.display = 'none';
  //       condition_input3_2.style.display = 'none';
  //     }
  //   }

  //   document.getElementById('condition_option2_2').onchange = function() {
  //     if (this.value == 'present' || this.value == 'cancel' || this.value == 'absent' || this.value == 'pay') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>課程選項</option>';
  //     } else if (this.value == 'participate') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>課程活動</option>';
  //     } else if (this.value == 'open-mail') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>郵件名稱</option>';
  //     } else if (this.value == 'open-sms') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>簡訊名稱</option>';
  //     }
  //   }

  //   // 顯示細分條件資料 Rocky(2020/03/14)
  //   $("#select_type2").change(function() {
  //     show_requirement_course($('#select_type2').val(), '#select_course2');
  //   });
  // }

  // function show_condition3() {
  //   //條件類別判斷
  //   document.getElementById('condition3').onchange = function() {
  //     var condition_option3 = document.getElementById('condition_option1_3'),
  //       condition_option2_3 = document.getElementById('condition_option2_3'),
  //       condition_input3_3 = document.getElementById('condition_input3_3');

  //     if (this.value == 'information') {
  //       // 選項一
  //       $('#condition_option1_3').empty();
  //       $('#condition_option1_3').append(new Option('請選擇', ''));
  //       $('#condition_option1_3').append(new Option('原始來源', 'datasource_old'));
  //       $('#condition_option1_3').append(new Option('最新來源', 'datasource_new'));
  //       $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
  //       $('#condition_option1_3').append(new Option('目前職業', 'profession'));
  //       $('#condition_option1_3').append(new Option('居住地址', 'address'));
  //       // $('#condition_option1_3').append(new Option('銷講後最新狀態', ''));
  //       $('#condition_option1_3').append(new Option('想了解的內容', 'course_content'));

  //       // 選項二
  //       $('#condition_option2_3').empty();
  //       $('#condition_option2_3').append(new Option('是', 'yes'));
  //       $('#condition_option2_3').append(new Option('未', 'no'));
  //       $('#condition_option2_3').append(new Option('包含', 'like'));
  //       $('#condition_option2_3').append(new Option('不包含', 'notlike'));

  //       condition_input3_3.style.display = 'block';
  //     } else if (this.value == 'action') {
  //       // 選項一
  //       $('#condition_option1_3').empty();
  //       $('#condition_option1_3').append(new Option('請選擇', ''));
  //       $('#condition_option1_3').append(new Option('是', 'yes'));
  //       $('#condition_option1_3').append(new Option('未', 'no'));

  //       // 選項二
  //       $('#condition_option2_3').empty();
  //       $('#condition_option2_3').append(new Option('請選擇', ''));
  //       $('#condition_option2_3').append(new Option('報到', '4'));
  //       $('#condition_option2_3').append(new Option('取消', '5'));
  //       $('#condition_option2_3').append(new Option('未到', '3'));
  //       $('#condition_option2_3').append(new Option('完款', '7'));
  //       $('#condition_option2_3').append(new Option('付訂', '8'));
  //       $('#condition_option2_3').append(new Option('退款', '9'));
  //       $('#condition_option2_3').append(new Option('參與', ''));
  //       // $('#condition_option2_3').append(new Option('打開郵件', ''));
  //       // $('#condition_option2_3').append(new Option('打開簡訊', ''));

  //       condition_input3_3.style.display = 'none';
  //     } else if (this.value == 'tag') {
  //       // 選項一
  //       $('#condition_option1_3').empty();
  //       $('#condition_option1_3').append(new Option('請選擇', ''));
  //       $('#condition_option1_3').append(new Option('已分配', 'yes'));
  //       $('#condition_option1_3').append(new Option('未分配', 'no'));

  //       // 選項二
  //       $('#condition_option2_3').empty();
  //       $('#condition_option2_3').append(new Option('請選擇', ''));
  //       $('#condition_option2_3').append(new Option('是', 'yes'));
  //       $('#condition_option2_3').append(new Option('未', 'no'));
  //       $('#condition_option2_3').append(new Option('包含', 'like'));
  //       $('#condition_option2_3').append(new Option('不包含', 'notlike'));

  //       condition_input3_3.style.display = 'block';
  //     }
  //   };
  //   // 類型 Rocky(2020/03/20)
  //   document.getElementById('select_type3').onchange = function() {
  //     if (this.value == '1') {
  //       // 銷講
  //       if ($('#condition3').val() == "information") {
  //         // 選項一
  //         $('#condition_option1_3').empty();
  //         $('#condition_option1_3').append(new Option('請選擇', ''));
  //         $('#condition_option1_3').append(new Option('原始來源', 'datasource_old'));
  //         $('#condition_option1_3').append(new Option('最新來源', 'datasource_new'));
  //         $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
  //         $('#condition_option1_3').append(new Option('目前職業', 'profession'));
  //         $('#condition_option1_3').append(new Option('居住地址', 'address'));
  //         // $('#condition_option1_3').append(new Option('銷講後最新狀態', ''));
  //         $('#condition_option1_3').append(new Option('想了解的內容', 'course_content'));
  //       }
  //     } else if (this.value == '2') {
  //       // 正課
  //       // 選項一
  //       if ($('#condition3').val() == "information") {
  //         $('#condition_option1_3').empty();
  //         $('#condition_option1_3').append(new Option('請選擇', ''));
  //         $('#condition_option1_3').append(new Option('應付金額', 'amount_payable'));
  //         $('#condition_option1_3').append(new Option('已付金額', 'amount_paid'));
  //         $('#condition_option1_3').append(new Option('服務人員', 'person'));
  //         $('#condition_option1_3').append(new Option('統一發票', 'type_invoice'));
  //         $('#condition_option1_3').append(new Option('統編', 'number_taxid'));
  //         $('#condition_option1_3').append(new Option('抬頭', 'companytitle'));
  //         $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
  //         $('#condition_option1_3').append(new Option('目前職業', 'profession'));
  //         $('#condition_option1_3').append(new Option('居住地址', 'address'));
  //       }
  //     } else if (this.value == '3') {
  //       // 活動
  //       // 選項一
  //       $('#condition_option1_3').empty();
  //       $('#condition_option1_3').append(new Option('請選擇', ''));
  //       $('#condition_option1_3').append(new Option('原始來源', 'datasource_old'));
  //       $('#condition_option1_3').append(new Option('最新來源', 'datasource_new'));
  //       $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
  //       $('#condition_option1_3').append(new Option('目前職業', 'profession'));
  //       $('#condition_option1_3').append(new Option('居住地址', 'address'));
  //       // $('#condition_option1_3').append(new Option('銷講後最新狀態', ''));
  //       $('#condition_option1_3').append(new Option('想了解的內容', 'course_content'));
  //     }
  //   }

  //   // 選項一 Rocky(2020/03/20)
  //   document.getElementById('condition_option1_3').onchange = function() {
  //     if (this.value == 'yes') {
  //       condition_option2_3.style.display = 'block';
  //     } else if (this.value == 'no') {
  //       condition_option2_3.style.display = 'none';
  //       condition_input3_3.style.display = 'none';
  //     }
  //   }

  //   document.getElementById('condition_option2_3').onchange = function() {
  //     if (this.value == 'present' || this.value == 'cancel' || this.value == 'absent' || this.value == 'pay') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>課程選項</option>';
  //     } else if (this.value == 'participate') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>課程活動</option>';
  //     } else if (this.value == 'open-mail') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>郵件名稱</option>';
  //     } else if (this.value == 'open-sms') {
  //       condition_option3.innerHTML = '<option value="">請選擇</option><option>簡訊名稱</option>';
  //     }
  //   }

  //   // 顯示細分條件資料 Rocky(2020/03/14)
  //   $("#select_type3").change(function() {
  //     show_requirement_course($('#select_type3').val(), '#select_course3');
  //   });
  // }
</script>



@endsection