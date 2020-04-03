@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '學員管理')

@section('content')
  <link href="{{ asset('css/bootstrap-tagsinput.css') }}" rel="stylesheet">  
<style>
    input:read-only {
      background-color: #e0e0e0 !important;
    }
    .bootstrap-datetimepicker-widget {position: relative;z-index: 1000;top:0 !important;}
  </style>
<!-- Content Start -->
        <!--搜尋學員頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-4"></div>
              <div class="col-3">
                <input type="search" class="form-control" placeholder="輸入電話或email" aria-label="Student's Phone or Email"
                    id="search_input" onkeyup="value=value.replace(/[^\w_.@]/g,'')">
              </div>
              <div class="col-2">
                <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button> 
              </div>
            </div>
            <div class="table-responsive">
              @component('components.datatable')
                @slot('thead')
                  <tr>
                    <th>姓名</th>
                    <th>聯絡電話</th>
                    <th>電子郵件</th>
                    <th>來源</th>
                    <th></th>
                  </tr>
                @endslot
                @slot('tbody')   
                  @foreach($students as $student)
                    <tr>
                      <td class="align-middle">{{ $student['name'] }}</td>
                      <td class="align-middle">{{ $student['phone'] }}</td>
                      <td class="align-middle">{{ $student['email'] }}</td>
                      <td class="align-middle">{{ $student['datasource'] }}</td>
                      <td class="align-middle">
                        <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" onclick="course_data({{ $student['id'] }});">完整內容</button>                       
                        <button id="{{ $student['id'] }}" class="btn btn-dark btn-sm mx-1" onclick="btn_blacklist({{ $student['id'] }});" value="{{ $student['id'] }}" ><i class="fa fa-bug"></i>列入黑名單</button>                      
                        <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" onclick="view_form({{ $student['id'] }});">已填表單</button>                      
                        <button id="{{ $student['id'] }}" class="btn btn-danger btn-sm mx-1" onclick="btn_delete({{ $student['id'] }});" value="{{ $student['id'] }}" >刪除</button>
                      </td>
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
                            <!-- 已填報名表課程詳細資料 -->
                              <!-- <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                          <a class="nav-link active" id="form_finished1" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="form_finished_content1" aria-selected="true">60天財富計畫報名表</a>
                          <a class="nav-link" id="form_finished2" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="form_finished_content2" aria-selected="false">自在交易工作坊報名表</a>
                          <a class="nav-link" id="form_finished3" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="form_finished_content3" aria-selected="false">實戰課程退費表</a>
                        </div> -->
                        </div>
                      </div>
                      <div class="col-8">
                        <div class="tab-content" id="v-pills-tabContent">
                          <!-- 已填報名表詳細資料 -->
                                <!-- <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="form_finished1">.fffff.</div>
                          <div class="tab-pane fade" id="form_finished_content2" role="tabpanel" aria-labelledby="form_finished2">...</div>
                          <div class="tab-pane fade" id="form_finished_content3" role="tabpanel" aria-labelledby="form_finished3">...</div> -->
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
                    <div class="col-5 py-2">
                      <h5 id = "student_name"></h5>
                      <h5 id = "student_email"></h5>
                    </div>
                    <div class="col-4">
                    </div>
                    <div class="col-4 py-3">
                        <h7 id = "student_date"></h7><br>
                        <h7 id = "student_datasource"></h7>
                    </div>
                  </div>
                  <!-- 標記 -S  -->
                  <div class="row">
                    <div class="col-12 py-2">
                      <h6>標記 :
                        <i class="fa fa-plus" aria-hidden="true" style="cursor:pointer;" id="new_tag" data-toggle="modal" data-target="#save_tag"></i>                                 
                      </h6>
                      <input type="text" id="isms_tags"/>
                    </div>
                    <div class="col-5">
                    </div>
                    <div class="col-4 align-right">
                      <button type="button" class="btn btn-primary float-right" onclick="btn_delete('','1');">刪除聯絡人</button>
                    </div>
                  </div>
                  <div class="modal fade" id="save_tag" tabindex="-1" role="dialog" aria-labelledby="save_tagTitle" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">標記名稱</h5>
                          <button type="button" class="close" id="tag_close"  aria-label="Close" data-number="1">
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
                            <div class="col-6">
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">最新來源</span>
                                </div>
                                <input type="text" name="new_datasource" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">職業</span>
                                </div>
                                <input id="student_profession" type="text" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#">
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">原始來源</span>
                                </div>
                                <input type="text" id="old_datasource" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#">
                                <input type="hidden" id="sales_registration_old">
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">電話</span>
                                </div>
                                <input id="student_phone" type="text" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#">
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
                            <input type="text" id="student_address" class="form-control bg-white basic-inf" aria-label="# input"  aria-describedby="#">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text">正課報名場次</span>
                            </div>
                            <input type="text" name="course_events" class="form-control bg-white basic-inf demo2" aria-label="# input" aria-describedby="#" data-placement="bottom" data-html="true" title="" readonly>
                          </div>
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text">參與活動</span>
                            </div>
                            <input type="text" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" data-placement="bottom" data-html="true" title="參與活動 : 參與次數 : 參與度 : " readonly>
                          </div>
                          <div class="input-group mb-3" id="dev_refund">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-danger text-white">退款</span>
                            </div>
                            <input type="text" name="course_refund" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                          </div>
                          <button type="button" class="btn btn-primary float-right" id="save-inf" style="display:block;"
                          onclick="save();">儲存</button>
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
                        <!-- <table class="table table-striped table-sm text-center"> -->
                        @component('components.datatable_history')
                          <!-- <thead> -->
                          @slot('thead')
                            
                          @endslot
                          <!-- </thead> -->
                          <!-- <tbody id = "history_data_detail"> -->
                          @slot('tbody')
                            <!-- <tr>
                              <td>2019年05月19日 19:50:39</td>
                              <td>參與</td>
                              <td>60天財富計畫課後第一次線上輔導</td>
                            </tr>
                            <tr>
                              <td>2019年05月19日 19:50:39</td>
                              <td>參與</td>
                              <td>60天財富計畫課後第一次線上輔導</td>
                            </tr> -->
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
                                <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" data-target="#save_contact"><i class="fa fa-plus" aria-hidden="true"></i></button>     
                              </th>
                              <th class="text-nowrap">日期</th>
                              <th class="text-nowrap">追單課程</th>
                              <th class="text-nowrap">付款狀態/日期</th>
                              <th class="text-nowrap">聯絡內容</th>
                              <th class="text-nowrap">最新狀態</th>
                              <th class="text-nowrap">追單人員</th>
                              <th class="text-nowrap">設提醒</th>
                            </tr>
                          </thead>
                          <tbody id = "contact_data_detail">
                            <tr>
                              <td class="align-middle"></td>
                              <td class="align-middle"></td>
                              <td class="align-middle">
                                <!-- <div class="form-group m-0">
                                  <select class="custom-select border-0 bg-transparent input_width">
                                    <option selected disabled value=""></option>
                                    <option value="1">現金</option>
                                    <option value="2">匯款</option>
                                    <option value="3">輕鬆付</option>
                                    <option value="4">一次付</option>
                                  </select>
                                </div> -->
                              </td>
                              <td class="align-middle"><input type="text" class="border-0 bg-transparent input_width"></td>
                              <td class="align-middle"><input type="text" class="border-0 bg-transparent input_width"></td>
                              <td class="align-middle">
                                <div class="form-group m-0">
                                  <select class="custom-select border-0 bg-transparent input_width">
                                    <option selected disabled value=""></option>
                                    <option value="1">完款</option>
                                    <option value="2">付訂</option>
                                    <option value="3">待追</option>
                                    <option value="4">退款中</option>
                                    <option value="5">退款完成</option>
                                    <option value="6">無意願</option>
                                    <option value="7">推薦其他講師</option>
                                  </select>
                                </div>
                              </td>
                              <td class="align-middle">追單人員</td>
                              <td class="align-middle">設提醒</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="modal fade" id="save_contact" tabindex="-1" role="dialog" aria-labelledby="save_tagTitle" aria-hidden="true" data-backdrop="static">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">新增聯絡狀況</h5>
                            <button type="button" class="close" id="contact_close"  aria-label="Close" data-number="1">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id ="form_debt">
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">日期:</label>
                                <div class="input-group date"  data-target-input="nearest">
                                      <input type="text" id="debt_date" name="debt_date" class="form-control datetimepicker-input" data-target="#debt_date" placeholder="日期">
                                      <div class="input-group-append" data-target="#debt_date" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">追單課程:</label>
                                <input type="text"  id="debt_course" class="form-control" placeholder="請輸入追單課程" value="" class="border-0 bg-transparent input_width" required>
                              </div>
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">付款狀態 / 日期:</label>
                                <input type="text"  id="debt_status_date" class="form-control" placeholder="請輸入付款狀態 / 日期"  value="" class="border-0 bg-transparent input_width">
                              </div>
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">聯絡內容:</label>
                                <input type="text" id="debt_contact" class="form-control" value="" placeholder="請輸入聯絡內容" class="border-0 bg-transparent input_width">
                              </div>
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">付款狀態:</label>
                                <select id="debt_status" class="form-control custom-select border-0 bg-transparent input_width"> 
                                    <option selected="" disabled="" value=""></option>
                                    <option value="11">完款</option>
                                    <option value="10">付訂</option>
                                    <option value="12">待追</option>
                                    <option value="13">退款中</option>
                                    <option value="14">退款完成</option>
                                    <option value="15">無意願</option>
                                    <option value="16">推薦其他講師</option>
                                  </select>
                              </div>
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">追單人員:</label>
                                <input type="text"  id="debt_person" class="form-control" placeholder="請輸入追單人員"   value="" class="border-0 bg-transparent input_width" required>
                              </div>
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">設提醒:</label>
                                <div class="input-group date"  data-target-input="nearest">  
                                  <input type="text" id="debt_remind"  name="debt_remind" class="form-control datetimepicker-input datepicker" data-target="#debt_remind">  
                                  <div class="input-group-append" data-target="#debt_remind" data-toggle="datetimepicker">  
                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                    </div> 
                                  </div> 
                                </div>
                              </div>                          
                              <div class="modal-footer">
                              <input id="btnSubmit" type="submit" class="btn btn-primary" onclick=" debt_add();" value="儲存" />
                              </div>
                            </form>
                        </div>
                      </div>
                    </div>
                      <!-- 聯絡狀況 -->
                  </div>
                  <!-- 完整內容 - E -->
                </div>
              </div>
            </div>
            <!-- 完整內容 - E -->
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
<script src="{{ asset('js/jquery-dateformat.min.js') }}"></script>
<script src="{{ asset('js/dateFormat.min.js') }}"></script>
<!-- <script src="{{ asset('js/date.format.js') }}"></script> -->
<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script src="{{ asset('js/angular.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-tagsinput-angular.min.js') }}"></script>

<script>
  var id_student_old = '';
  var elt = $('#isms_tags');
  var table;

// 搜尋 Rocky(2020/03/27)
$.fn.dataTable.ext.search.push(
  function( settings, data, dataIndex ) {
    var keyword = $('#search_input').val();
    var phone = data[1];
    var email = data[2]; 

    if ( (isNaN( keyword )) || ( phone.includes(keyword)) || ( email.includes(keyword)) ){
      return true;
    }
    return false;
  }
);
$("#btn_search").click(function(){
  table.search($('#search_input').val()).draw();
});

$("document").ready(function(){

  // 2020-01-05 15:33:46
  // var test = new Date("2020-01-05 15:33:46").format("m/dd/yy")
  // console.log(jQuery.format.prettyDate("2020-01-05 15:33:46", "yyyy/MM/dd"))
  //日期選擇器
  $('#debt_date').datetimepicker({ 
        format: 'YYYY-MM-DD',
  });

  $('#debt_remind').datetimepicker({ 
        format: 'YYYY-MM-DD',
  });
  
  // Rocky (2020/03/27)
  table = $('#table_list').DataTable({
    "dom": '<l<t>p>',
    "columnDefs": [ {
      "targets": 'no-sort',
      "orderable": false,
    } ]
    // "ordering": false,
  });

  $(".demo2").tooltip();

  // 學員管理搜尋 (只能輸入數字、字母、_、.、@)
  $('#search_input').on('blur', function() {
      // console.log(`search_input: ${$(this).val()}`);
  });   
});

 // 追但資料關閉
 $("#contact_close").click(function(){
  $('#save_contact').modal('hide');
});

 // 標記關閉
$("#tag_close").click(function(){
  $('#save_tag').modal('hide');
});

// 輸入框
$('#search_input').on('keyup', function(e) {
  if (e.keyCode === 13) {
    $("#btn_search").click();
  }
});

/* 已填表單 -S Rocky(2020/02/29 */

// 課程
function view_form(id_student){
  $.ajax({
      type : 'POST',
      url:'view_form', 
      dataType: 'json',    
      data:{
        id_student: id_student
      },
      success:function(data){
        var course = '';          
        $.each(data, function(index,val) {             
          if (typeof(val['id_payment']) != 'undefined') {
            // 正課資料
            course += '<a class="nav-link " id="form_finished1" data-toggle="pill" onclick="view_form_detail(' +  val['id'] +',1)" role="tab" aria-controls="form_finished_content1" aria-selected="true">' + val['course'] + '</a>';
          } else {
            // 銷講資料
            course += '<a class="nav-link " id="form_finished1" data-toggle="pill" onclick="view_form_detail(' +  val['id'] +',0)" role="tab" aria-controls="form_finished_content1" aria-selected="true">' + val['course'] + '</a>';
          }
        }); 
        $('#v-pills-tab').html(course);
        $("#form_finished").modal('show');                    
      },
      error: function(error){
        console.log(JSON.stringify(error));     
      }
  });
}

// 課程詳細資料
function view_form_detail(id,type){
  $.ajax({
    type : 'POST',
    url:'view_form_detail', 
    dataType: 'json',    
    data:{
      id: id,
      type:type
    },
    success:function(data){
      var detail = '',student = '',payment = '';
      // console.log(data)
      $.each(data, function(index,val) {
        // 學員資料
        student = '<div style="text-align:left"><b>課程服務報名表</b>'  + '<br>' + '姓名:' + val['name'] + '<br>' + '性別:' + val['sex'] + '<br>' + '身分證字號:' + val['id_identity'] + '<br>' +  
        '聯絡電話:' + val['phone'] + '<br>' + '電子郵件:' + val['email'] + '<br>' + '出生日期:' + val['birthday'] + '<br>' + 
        '公司名稱:' + val['company'] + '<br>' + '職業:' + val['profession'] + '<br>' + '聯絡地址:' + val['address'] +
        '</div>'

        if (type == 1) {
          var pay_model = '';
          // 正課

          // 付款方式
          switch(val['pay_model']) {
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
          payment = '<hr/><div style="text-align:left;padding-top: 1%;"><b>繳款明細</b>'  + '<br>' + '付款金額:' + val['cash'] + '<br>' + '付款方式:' +   pay_model + '<br>' + '卡號後五碼:' + val['number'] + '<br>' +  
          '服務人員:' + val['person'] + '<br>' + '統編:' + val['number_taxid'] + '<br>' + '抬頭:' + val['companytitle'] +
          '</div>'          
        }
        
        detail = '<div class="tab-pane fade show active" id="' + val['id'] + '" role="tabpanel" aria-labelledby="form_finished1">' + student + payment + '</div>'
      }); 
      $('#v-pills-tabContent').html(detail);       
    },
    error: function(error){
      console.log(JSON.stringify(error));     
    }
    });
}
/* 已填表單 -E Rocky(2020/02/29) */

/* 完整內容 -S Rocky(2020/02/29) */

// 基本訊息
function course_data(id_student){
  // console.log(id_student)
  id_student_old = id_student  
  history_data();
  contact_data();
  tags_show(id_student);
  $.ajax({
      type : 'POST',
      url:'course_data', 
      dataType: 'json',    
      data:{
        id_student: id_student
      },
      success:function(data){
        // console.log(data)
        // 銷講報到率
        var sales_successful_rate ='0',course_cancel_rate = '0';
        var course_sales_status = '';
        if (data['count_sales_ok'] != 0) {
          sales_successful_rate = (data['count_sales_ok'] / (data['count_sales'] - data['count_sales_no']) *100).toFixed(0)
        }
        
        // 銷講取消率
        if (data['count_sales_no'] != 0) {
          course_cancel_rate = (data['count_sales_no'] / data['count_sales'] *100).toFixed(0)
        } 
        // 學員資料
        $('#student_name').text(data[0]['name']);
        $('#student_email').text(data[0]['email']);
        $('#student_date').text('加入日期 :' + data['submissiondate']);
        $('#student_profession').val(data[0]['profession']);
        $('#student_address').val(data[0]['address']);        
        $('#sales_registration_old').val(data[0]['sales_registration_old']);
        $('#old_datasource').val(data[0]['datasource_old']);
        $('#student_phone').val(data[0]['phone']);       
        
        // 銷講      
        $('input[name="new_datasource"]').val(data['datasource']);
        if(data['course_sales_events'] != null){
          $('input[name="course_sales_events"]').val(data['course_sales'] + data['course_sales_events'] + '(' + data['sales_registration_course_start_at'] +')');
        }
        $('input[name="course_content"]').val(data['course_content']);
        $('input[name="status_payment"]').val('');
        if (typeof(data['status_registration']) != 'undefined' ) {
          course_sales_status = data['status_registration'] +'(' + data['course_registration'] + data['course_events'] + ')' 
        }
        $('input[name="course_sales_status"]').val(course_sales_status);
        if (data['count_sales_ok'] == null) {
          $('h7[name="count_sales_ok"]').text('銷講報名次數 :0');        
        } else {
          $('h7[name="count_sales_ok"]').text('銷講報名次數 :' + data['count_sales_ok']);        
        }        
        if (data['count_sales_ok'] == null) {  
          $('h7[name="sales_successful_rate"]').text('銷講報到率 :0%');    
        } else {
          $('h7[name="sales_successful_rate"]').text('銷講報到率 :' + sales_successful_rate + '%');      
        }
        if (data['count_sales_no'] == null) {
          $('h7[name="count_sales_no"]').text('銷講取消次數 :0');
        } else {
          $('h7[name="count_sales_no"]').text('銷講取消次數 :' + data['count_sales_no']);
        }

        if (data['count_sales_ok'] == null) {  
          $('h7[name="sales_cancel_rate"]').text('銷講取消率 :0%');
        } else {
          $('h7[name="sales_cancel_rate"]').text('銷講取消率 :' + course_cancel_rate + '%');   
        }

        
        
        // 正課
        $('input[name="course_events"]').val('');
        if (typeof(data['course_registration']) != 'undefined') {
          $('input[name="course_events"]').val(data['course_registration'] + data['course_events']);
        }
                
        // 退款
        $('input[name="course_refund"]').val('');
        if (typeof(data['refund_course']) != 'undefined') {
          $('input[name="course_refund"]').val(data['refund_course'] + '(' +data['refund_reason'] + ')');
        } else {
          $('#dev_refund').hide();
          
        }
        
        $("#student_information").modal('show');                    
      },
      error: function(error){
        console.log(JSON.stringify(error));     
      }
  });
}

/* 標記 -S Rocky(2020/03/12) */

// 標記顯示
function tags_show(id_student){
  $.ajax({
      type : 'POST',
      url:'tag_show', 
      dataType: 'json',    
      data:{
        id_student: id_student
      },
      success:function(data){        
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

          if (data.length != 0){
            // 新增資料到標籤
            $.each(data, function(index,val) {    
              elt.tagsinput('add', { "value": val['value'] , "text": val['text']   , "continent": val['text']    });  
            });
          }
      },
      error: function(error){
        console.log(JSON.stringify(error));     
      }
  });
}

// 標記新增
function tags_add(){
  name = $("#tag_name").val();
 
  $.ajax({
      type : 'POST',
      url:'tag_save',    
      data:{
        id_student: id_student_old,
        name:name,
      },
      success:function(data){    
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
      error: function(error){
        console.log(JSON.stringify(error));     
      }
  });
}

// 標記刪除
elt.on('itemRemoved', function(event) {
  var msg = "是否刪除標記資料?";
    if (confirm(msg)==true){      
      $.ajax({
          type : 'POST',
          url:'tag_delete', 
          dataType: 'json',    
          data:{
            id: event.item['value']
          },
          success:function(data){
            if (data['data'] == "ok") {                           
              /** alert **/
              $("#success_alert_text").html("刪除資料成功");
              fade($("#success_alert"));

              // location.reload();
            }　else {
              /** alert **/ 
              $("#error_alert_text").html("刪除資料失敗");
              fade($("#error_alert"));       
            }           
          },
          error: function(error){
            console.log(JSON.stringify(error));      
          }
      });
    }else{
    return false;
    }  
});

/* 標記 -E Rocky(2020/03/12) */

// 歷史互動
function history_data() {
  // $('#table_list_history').dataTable().fnClearTable();
  $.ajax({
      type : 'POST',
      url:'history_data', 
      dataType: 'json',    
      data:{
        id_student: id_student_old
      },
      success:function(data){
        var id_student = '';

        $('#table_list_history').html('');
        $('#table_list_history').append('<thead id="table_thead"></thead> <tbody id="history_data_detail"></tbody>');
        $('#history_data_detail').html(''); 
        $('#table_thead').html(''); 
        // console.log(data)
         $.each(data, function(index,val) {
          var status = '';
          if(val['status_sales'] == null){
            status = '無'
          }else{
            status = val['status_sales']
          }
          id_student = val['id_student'];
          data +=
                '<tr>' +
                '<td>' + val['created_at'] + '</td>' + 
                '<td>' + status + '</td>' +
                '<td>' + val['course_sales'] + '</td>' +
                '</tr>'
        });
        data_thead =
        '<tr>' +
          '<th>時間</th>' +
          '<th>動作</th>' +
          '<th>內容</th>' +
        '</tr>'        
         $('#history_data_detail').html(data);
         $('#table_thead').html(data_thead);
        $('#table_list_history').DataTable({
            "dom": '<l<td>p>',
            "destroy":true,
            "ordering": true,
            "columnDefs": [ {
              "targets": 'no-sort',                
            } ]            
          });                                    
      },
      error: function(error){
        console.log(JSON.stringify(error));     
      }
  });
}

// 聯絡狀況
function contact_data() {
  $('#contact_data_detail').html(''); 
  $.ajax({
      type : 'POST',
      url:'contact_data', 
      dataType: 'json',    
      data:{
        id_student: id_student_old
      },
      success:function(data){
        updatetime = '',remindtime='';
        $.each(data, function(index,val) {
          opt1 = '',opt2 = '',opt3 = '',opt4 = '',opt5 = '',opt6 = '',opt7 = '';
          id = val['id'];
          switch (val['id_status']) {
          case 10:
            　opt1 = 'selected';
          　break;
          case 11:
            　opt2 = 'selected';
          　break;
          case 12:
            　opt3 = 'selected';
          　break;
          case 13:
            　opt4 = 'selected';
          　break;
          case 14:
            　opt5 = 'selected';
          　break;
          case 15:
            　opt6 = 'selected';
          　break;
          case 16:
            　opt7 = 'selected';
          　break;
          }
          updatetime +="#new_starttime" + id + ','
          remindtime +="#remind" + id + ','
          var status_payment = '',contact = '',person = '';
          
          if ( typeof(val['status_payment']) == 'object'){
            status_payment = ''
          }else{
            status_payment = val['status_payment']
          }

          if (val['contact'] != null){
            contact = val['contact']
          }

          if (val['person'] != null){
            person = val['person']
          }
          
          // console.log(updatetime)
          data +=
                '<tr>' +
                '<td><i class="fa fa-trash" aria-hidden="true" onclick="debt_delete(' + id +');" style="cursor:pointer;padding-top: 20%; color:#eb6060"></i></td>' +
                '<td>' + 
                // '<div class="input-group date datetime_show"  id="new_starttime'+ id +'" data-target-input="nearest"> ' +
                //     ' <input type="text" id="new_starttime'+ id +'"  onblur="update_time($(this),'+id+',0);" value="' + val['updated_at'] +'"   name="new_starttime'+ id +'" class="form-control datetimepicker-input " data-target="#new_starttime'+ id +'" required/> ' +
                //     ' <div class="input-group-append" data-target="#new_starttime'+ id +'" data-toggle="datetimepicker"> '+
                //         ' <div class="input-group-text"><i class="fa fa-calendar"></i></div> '+
                //     '</div> ' +
                // '</div>' +
                '<div class="input-group date" id="new_starttime'+ id +'" data-target-input="nearest"> ' +
                      ' <input type="text" onblur="update_time($(this),'+id+',0);"  value="' + val['updated_at'] +'"   name="new_starttime'+ id +'" class="form-control datetimepicker-input datepicker" data-target="#new_starttime'+ id +'" required/> ' +
                      ' <div class="input-group-append" data-target="#new_starttime'+ id +'" data-toggle="datetimepicker"> '+
                          ' <div class="input-group-text"><i class="fa fa-calendar"></i></div> '+
                      '</div> ' +
                  '</div>' 



                // '<div class="input-group date"  id="new_starttime'+ id +'" ata-target-input="nearest"> ' +
                //     '<input type="text" id="new_starttime'+ id +'" onblur="update_time($(this),'+id+',0);" name="new_starttime'+ id +'"  class="form-control datetimepicker-input"' + ' data-target="#new_starttime'+ id +'"  value="' + val['updated_at'] +'" >' +
                //     '<div class="input-group-append" data-target="#new_starttime'+ id +'" data-toggle="datetimepicker"> ' +
                //         '<div class="input-group-text"><i class="fa fa-calendar"></i></div>' +
                //     '</div>' + 
                // '</div>'+ 
                + '</td>' + 
                '<td>' + '<input type="text"  class="form-control" onblur="name_course($(this),'+id+',6);" id="' + id +'_name_course" value="' + val['name_course'] +'" class="border-0 bg-transparent input_width">' +  '</td>' + 
                '<td>' + '<input type="text"  class="form-control" onblur="status_payment($(this),'+id+',1);" id="' + id +'_status_payment" value="' + status_payment +'" class="border-0 bg-transparent input_width">' + '</td>' + 
                '<td>' + '<input type="text"  class="form-control" onblur="contact($(this),'+id+',2);" id="' + id +'_contact" value="' + contact +'"  class="border-0 bg-transparent input_width">' + '</td>' +
                '<td>' + '<div class="form-group m-0"> <select id="' + id +'_status" onblur="status($(this),'+id+',3);" class="custom-select border-0 bg-transparent input_width"> ' +
                            '<option selected disabled value=""></option>' +
                            '<option value="11" '+　opt2 +'>完款</option>' +
                            '<option value="10" '+　opt1 +'>付訂</option>' +
                            '<option value="12" '+　opt3 +'>待追</option>' +
                            '<option value="13" '+　opt4 +'>退款中</option>' +
                            '<option value="14" '+　opt5 +'>退款完成</option>' +
                            '<option value="15" '+　opt6 +'>無意願</option>' +
                            '<option value="16" '+　opt7 +'>推薦其他講師</option>' +
                        '</select>' +
                    '</div> </td>' +
                '<td>' + '<input type="text"  class="form-control" onblur="person($(this),'+id+',5);" id="' + id +'_person" value="' + person +'" class="border-0 bg-transparent input_width">'  + '</td>' +
                '<td>' + 
                  '<div class="input-group date" id="remind'+ id +'" data-target-input="nearest"> ' +
                      ' <input type="text" onblur="remind($(this),'+id+',4);"  value="' + val['remind_at'] +'"   name="remind'+ id +'" class="form-control datetimepicker-input datepicker" data-target="#remind'+ id +'" required/> ' +
                      ' <div class="input-group-append" data-target="#remind'+ id +'" data-toggle="datetimepicker"> '+
                          ' <div class="input-group-text"><i class="fa fa-calendar"></i></div> '+
                      '</div> ' +
                  '</div>' +
                  // '<div class="input-group date"  id="remind'+ id +'" ata-target-input="nearest"> ' +
                  //   '<input type="text" onblur="remind($(this),'+id+',4);"  value="' + val['remind_at'] +'"   name="remind'+ id +'" name="new_starttime'+ id +'"  class="form-control datetimepicker-input"' + ' data-target="#remind'+ id +'" >' +
                  //   '<div class="input-group-append" data-target="#remind'+ id +'" data-toggle="datetimepicker"> ' +
                  //       '<div class="input-group-text"><i class="fa fa-calendar"></i></div>' +
                  //   '</div>' +
                  // '</div>' + 
                '</td>' +
                '</tr>'
        });
        $('#contact_data_detail').html(data);  
        // 日期
        var iconlist = {  time: 'fas fa-clock',
                      date: 'fas fa-calendar',
                      up: 'fas fa-arrow-up',
                      down: 'fas fa-arrow-down',
                      previous: 'fas fa-arrow-circle-left',
                      next: 'fas fa-arrow-circle-right',
                      today: 'far fa-calendar-check-o',
                      clear: 'fas fa-trash',
                      close: 'far fa-times' } 
        $(updatetime.substring(0, updatetime.length-1)).datetimepicker({
          format: "YYYY-MM-DD",
          icons: iconlist, 
          defaultDate:new Date(),
          pickerPosition: "bottom-left"
        });
        $(remindtime.substring(0, remindtime.length-1)).datetimepicker({
          format: "YYYY-MM-DD",
          icons: iconlist, 
          defaultDate:new Date(),
          pickerPosition: "bottom-left" 
        });       

        // $(".datepicker").datepicker();
        // $('.ui-datepicker').addClass('notranslate'); 
      },
      error: function(error){
        console.log(JSON.stringify(error));     
      }
  });
}

// 儲存
function save() {
  student_profession = $("#student_profession").val();
  student_address = $("#student_address").val();
  sales_registration_old = $("#sales_registration_old").val();
  old_datasource = $("#old_datasource").val();
  student_phone = $("#student_phone").val();

  
  $.ajax({
      type : 'POST',
      url:'student_save',    
      data:{
        id_student: id_student_old,
        profession:student_profession,
        address:student_address,
        sales_registration_old:sales_registration_old,
        old_datasource:old_datasource,
        student_phone:student_phone
      },
      success:function(data){        
        if (data = "更新成功") {
          $("#success_alert_text").html("儲存成功");
          fade($("#success_alert"));
        } else {
          $("#error_alert_text").html("儲存失敗");
          fade($("#error_alert"));       
          
        }
      },
      error: function(error){
        console.log(JSON.stringify(error));     
      }
  });
}
/* 完整內容 -E Rocky(2020/02/29 */


/*聯絡狀況 - 新增 - S Rocky(2020/04/02)*/
function debt_add(){
  var isValidForm = document.forms['form_debt'].checkValidity();
  if (isValidForm)
  {
    debt_date = $("#debt_date").val();
    debt_course = $("#debt_course").val();
    debt_status_date = $("#debt_status_date").val();
    debt_contact = $("#debt_contact").val();
    debt_status = $("#debt_status").val();
    debt_person = $("#debt_person").val();
    debt_remind = $("#debt_remind").val();
    id_student = id_student_old;
    $.ajax({
        type : 'POST',
        url:'debt_save',    
        data:{            
          id_student:id_student,
          debt_date:debt_date,
          debt_course:debt_course,
          debt_status_date:debt_status_date,
          debt_contact:debt_contact,
          debt_status:debt_status,
          debt_person:debt_person,
          debt_remind:debt_remind
        },
        success:function(data){    
          if (data = "儲存成功") {
            contact_data();
            // $('#save_contact').modal('hide');
            $("#success_alert_text").html("儲存成功");
            fade($("#success_alert"));
          } else {
            $("#error_alert_text").html("儲存失敗");
            fade($("#error_alert"));                 
          }
        },
        error: function(error){
          console.log(JSON.stringify(error));     
        }
    });
  }else
  {
    return false;
  }
}
/*聯絡狀況 - 新增 - E*/

/*聯絡狀況 - 刪除 - S Rocky(2020/04/02)*/
function debt_delete(id){
   var msg = "是否刪除此筆資料?";
  if (confirm(msg)==true){
    $.ajax({
      type : 'POST',
      url:'debt_delete',    
      data:{            
        id:id
      },
      success:function(data){    
        if (data = "刪除成功") {
          contact_data();
          $("#success_alert_text").html("刪除成功");
          fade($("#success_alert"));
        } else {
          $("#error_alert_text").html("刪除失敗");
          fade($("#error_alert"));                 
        }
      },
      error: function(error){
        console.log(JSON.stringify(error));     
      }
    });
  }else{
    return false;
  }    
}
/*聯絡狀況 - 刪除 - E*/

/* 自動儲存 - S Rocky(2020/03/08) */

// 日期
function update_time(data,id,type){
  // console.log(data.val()) 
  save_data(data.val(),id,type)
}
// 付款狀態 / 日期
function status_payment(data,id,type){    
  save_data(data.val(),id,type)
}

// 聯絡內容
function contact(data,id,type){    
    save_data(data.val(),id,type)
}

// 最新狀態
function status(data,id,type){    
    save_data(data.val(),id,type)
}
// 提醒
function remind(data,id,type){    
    save_data(data.val(),id,type)
}

// 追單人員
function person(data,id,type){    
    save_data(data.val(),id,type)
}

// 追單課程
function name_course(data, id,type ){
  save_data(data.val(),id,type)
}
function save_data(data, id,type ){
  $.ajax({
    type:'POST',
    url:'contact_data_save',
    // dataType:'JSON',
    data:{
      id: id,
      type: type,
      data: data
    },
    success:function(data){
      // console.log(data);

      /** alert **/
      $("#success_alert_text").html("資料儲存成功");
      fade($("#success_alert"));
    },
    error: function(jqXHR){
      console.log(JSON.stringify(jqXHR));  

      /** alert **/ 
      $("#error_alert_text").html("資料儲存失敗");
      fade($("#error_alert"));      
    }
  });
}



/* 自動儲存 - E Rocky(2020/03/08) */


 /*刪除 Rocky(2020/02/23)*/
 function btn_delete(id_student,type){   
    var msg = "是否刪除此筆資料?";
    if (confirm(msg)==true){
      if (id_student == '' && type=='1') {
        id_student = id_student_old;
      }
      $.ajax({
          type : 'GET',
          url:'student_delete', 
          dataType: 'json',    
          data:{
            id_student: id_student
          },
          success:function(data){
            if (data['data'] == "ok") {                           
              /** alert **/
              $("#success_alert_text").html("刪除資料成功");
              fade($("#success_alert"));

              location.reload();
            }　else {
              /** alert **/ 
              $("#error_alert_text").html("刪除資料失敗");
              fade($("#error_alert"));       
            }           
          },
          error: function(error){
            console.log(JSON.stringify(error));   

            /** alert **/ 
            $("#error_alert_text").html("刪除資料失敗");
            fade($("#error_alert"));       
          }
      });
    }else{
    return false;
    }    
}

/*加入黑名單 Rocky(2020/02/23)*/
function btn_blacklist(id_student){
    // var msg = "是否刪除此筆資料?";
    // if (confirm(msg)==true){
      $.ajax({
          type : 'GET',
          url:'student_addblacklist', 
          dataType: 'json',    
          data:{
            id_student: id_student
          },
          success:function(data){
            if (data['data'] == "ok") {                           
              /** alert **/
              $("#success_alert_text").html("加入黑名單成功");
              fade($("#success_alert"));

              location.reload();
            }　else {
              /** alert **/ 
              $("#error_alert_text").html("入黑名單失敗");
              fade($("#error_alert"));       
            }           
          },
          error: function(error){
            console.log(JSON.stringify(error));   

            /** alert **/ 
            $("#error_alert_text").html("刪除資料失敗");
            fade($("#error_alert"));       
          }
      });
    // }else{
    // return false;
    // }    
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