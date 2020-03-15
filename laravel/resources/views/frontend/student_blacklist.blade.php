@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '黑名單')

@section('content')
<link href="{{ asset('css/bootstrap-tagsinput.css') }}" rel="stylesheet">  
<style>
    input:read-only {
      background-color: #e0e0e0 !important;
    }
    .bootstrap-tagsinput .tag [data-role="remove"] { display: none; }
  </style>
<!-- Content Start -->
        <!--黑名單內容-->
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
                <!-- <div class="col-5 mx-auto">
                  <div class="input-group">
                    <input type="search" class="form-control" placeholder="輸入電話或email" aria-label="Phone or Email">
                  </div>
                </div> -->
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>姓名</th>
                    <th>連絡電話</th>
                    <th>電子郵件</th>
                    <th>原因</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                @foreach($blacklists as $blacklist)
                <tr>
                    <td>{{$blacklist->name }}</td>
                    <td>{{$blacklist->phone}}</td>
                    <td>{{$blacklist->email}}</td>
                    <td>{{$blacklist->reason}}</td>

                    <td>
                    <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" onclick="course_data({{ $blacklist->id }});">完整內容</button>
                        <button id="{{ $blacklist->blacklist_id }}" class="btn btn-dark btn-sm mx-1" onclick="btn_blacklist({{ $blacklist->blacklist_id }});" value="{{ $blacklist->blacklist_id }}" ><i class="fa fa-ban"></i>取消黑名單</button>
                    </td>
                </tr>
                @endforeach                 
                </tbody>
              </table>
            </div>
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
                    <!-- 標記 -->
                    <div class="row">
                      <div class="col-12 py-2">

                        <h6>標記 :
                        <i class="fa fa-plus" aria-hidden="true" style="cursor:pointer;" id="new_tag" data-toggle="modal" data-target="#save_tag"></i>
                          <!-- <span class="bg-dark p-1 text-light">
                            <small>JC學員</small>
                          </span>&nbsp;
                          <span class="bg-dark p-1 text-light">
                            <small>黑心學員</small>
                          </span> -->                                    
                        </h6>
                        <input type="text" id="isms_tags"/>
                      </div>
                      <div class="col-5">
                      </div>
                      <div class="col-4 align-right">
                        <!-- <button type="button" class="btn btn-primary float-right" onclick="btn_delete('','1');">刪除聯絡人</button> -->
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
                            <!-- <button type="button" class="btn btn-primary" onclick="tags_add();">儲存</button> -->
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- 標記 -->
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
                    <!-- 完整內容 -->
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
                                  <input id="student_profession" type="text" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
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
                              <input type="text" id="student_address" class="form-control bg-white basic-inf" aria-label="# input"  aria-describedby="#" readonly>
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
                            <!-- <button type="button" class="btn btn-primary float-right" id="save-inf" style="display:block;"
                            onclick="save();">儲存</button> -->
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
                          @component('components.datatable')
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
                        <!-- 聯絡狀況 -->
                    </div>
                    <!-- 完整內容 -->
                  </div>
                </div>
              </div>
            <div class="row">
              <div class="col-md-5"></div>
              <div class="col-md-4">
                <div class="pull-right">
                  {!! $blacklists->appends(Request::except('page'))->render() !!} 
                </div>
              </div>
            </div>
          </div>
        </div>
<!-- Content End -->

<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script src="{{ asset('js/angular.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-tagsinput-angular.min.js') }}"></script>

<script>
  var id_student_old = '';
  var elt = $('#isms_tags');

  $("document").ready(function(){
    btn_blackadd();
  // 學員管理搜尋 (只能輸入數字、字母、_、.、@)
  $('#search_input').on('blur', function() {
      // console.log(`search_input: ${$(this).val()}`);
  });
});

// 輸入框
$('#search_input').on('keyup', function(e) {
  if (e.keyCode === 13) {
      $('#btn_search').click();
  }
});

/*搜尋 Rocky(2020/02/23)*/
$("#btn_search").click(function(e){
  var search_data = $("#search_input").val();
  $.ajax({
      type : 'GET',
      url:'blacklist_search',    
      data:{
        search_data: search_data,
      },
      success:function(data){
        $('body').html(data);
      },
      error: function(jqXHR){
          console.log('error: ' + JSON.stringify(jqXHR));
      }
  });
});

/*取消黑名單 Rocky(2020/02/23)*/
function btn_blacklist(id_blacklist){
  $.ajax({
      type : 'GET',
      url:'blacklist_cancel', 
      dataType: 'json',    
      data:{
        id_blacklist: id_blacklist
      },
      success:function(data){
        if (data['data'] == "ok") {                           
          /** alert **/
          $("#success_alert_text").html("取消成功");
          fade($("#success_alert"));

          location.reload();
        }　else {
          /** alert **/ 
          $("#error_alert_text").html("取消失敗");
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
}

/*新增黑名單 Rocky(2020/03/01)*/
function btn_blackadd(){
  $.ajax({
      type : 'post',
      url:'blacklist_add',
      dataType: 'json',   
      success:function(data){
        // console.log(data);
      },
      error: function(error){
        console.log(JSON.stringify(error));   
      }
  });
}

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
          sales_successful_rate = (data['count_sales_ok'] / data['count_sales'] *100).toFixed(0)
        }
        
        // 銷講取消率
        if (data['count_sales_no'] != 0) {
          course_cancel_rate = (data['count_sales_no'] / data['count_sales'] *100).toFixed(0)
        } 
        // 學員資料
        $('#student_name').text(data[0]['name']);
        $('#student_email').text(data[0]['email']);
        $('#student_date').text('加入日期 :' + data[0]['created_at']);
        $('#student_profession').val(data[0]['profession']);
        $('#student_address').val(data[0]['address']);
        
        
        // 銷講      
        $('input[name="new_datasource"]').val(data['datasource']);
        $('input[name="course_sales_events"]').val(data['course_sales'] + data['course_sales_events']);
        $('input[name="course_content"]').val(data['course_content']);
        if (typeof(data['status_payment']) != 'undefined') {
          course_sales_status = data['status_payment'] +'(' + data['course_registration'] + data['course_events'] + ')' 
        }
        $('input[name="course_sales_status"]').val(course_sales_status);
        $('h7[name="count_sales_ok"]').text('銷講報名次數 :' + data['count_sales_ok']);        
        $('h7[name="sales_successful_rate"]').text('銷講報到率 :' + sales_successful_rate + '%');
        $('h7[name="count_sales_no"]').text('銷講取消次數 :' + data['count_sales_no']);
        $('h7[name="sales_cancel_rate"]').text('銷講取消率 :' + course_cancel_rate + '%');
        
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
              // switch (item.value % 2) {
                // case 0  : return 'badge badge-primary';
                // case 1  : return 'badge badge-success';
                // defalt   : return 'badge badge-default';
                // case 'Africa'   : return 'badge badge-default';
                // case 'Asia'     : return 'badge badge-warning';
              // }
              // console.log(item.value % 2)
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
  // table = $('#table_list').DataTable();

  $.ajax({
      type : 'POST',
      url:'history_data', 
      dataType: 'json',    
      data:{
        id_student: id_student_old
      },
      success:function(data){
        var id_student = '';
        
        $('#history_data_detail').html(''); 
        $('#table_thead').html(''); 
        // console.log(data)
         $.each(data, function(index,val) {
          id_student = val['id_student'];
          data +=
                '<tr>' +
                '<td>' + val['created_at'] + '</td>' + 
                '<td>' + val['status_sales'] + '</td>' +
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
        //  $('#table_list').dataTable().fnClearTable();   //將資料清除  
        //  render($('#table_list').DataTable());
        // $('#table_list').DataTable({
        //     "dom": '<l<t>p>',
        //     "destroy":true,
        //     "columnDefs": [ {
        //       "targets": 'no-sort',                
        //     } ],
        //     initComplete: function () {                                
        //       this.api().columns().every( function () {
        //           var column = this;
        //           var select = ''
        //           select = $('<select ><option value=""></option></select>')
        //               .appendTo( $(column.header())  )
        //               .on( 'change', function () {
        //                   var val = $.fn.dataTable.util.escapeRegex(
        //                       $(this).val()
        //                   );
        //                   column
        //                       .search( val ? '^'+val+'$' : '', true, false )
        //                       .draw();
        //               } );
        //           column.data().unique().sort().each( function ( d, j ) {
        //               select.append( '<option value="'+d+'">'+d+'</option>' )
        //           } );
        //       });              
        //     }
        //   });                                    
          
      },
      error: function(error){
        console.log(JSON.stringify(error));     
      }
  });
}

// function render(table) { 
//   var currentPage = table.page(); 
//   table.clear(); 
//   table.rows.add(this.staff_list); 
//   table.page(currentPage).draw(false); 
// }
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
        // console.log(data)
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
          data +=
                '<tr>' +
                '<td>' + 
                '<div class="input-group date"  id="new_starttime'+ id +'" data-target-input="nearest"> ' +
                    ' <input type="text" readonly onblur="update_time($(this),'+id+',0);" value="' + val['updated_at'] +'"   name="new_starttime'+ id +'" class="form-control datetimepicker-input " data-target="#new_starttime'+ id +'" required/> ' +
                    ' <div class="input-group-append" data-target="#new_starttime'+ id +'" data-toggle="datetimepicker"> '+
                        ' <div class="input-group-text"><i class="fa fa-calendar"></i></div> '+
                    '</div> ' +
                '</div>' +
                + '</td>' + 
                '<td>' + val['name_course'] + '</td>' + 
                '<td>' + '<input type="text" readonly onblur="status_payment($(this),'+id+',1);" id="' + id +'_status_payment" value="' + val['status_payment'] +'" class="border-0 bg-transparent input_width">' + '</td>' + 
                '<td>' + '<input type="text" readonly onblur="contact($(this),'+id+',2);" id="' + id +'_contact" value="' + val['contact'] +'"  class="border-0 bg-transparent input_width">' + '</td>' +
                '<td>' + '<div class="form-group m-0"> <select readonly id="' + id +'_status" onblur="status($(this),'+id+',3);" class="custom-select border-0 bg-transparent input_width"> ' +
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
                '<td>' + val['person'] + '</td>' +
                '<td>' + 
                  '<div class="input-group date" id="remind'+ id +'" data-target-input="nearest"> ' +
                      ' <input type="text" readonly onblur="remind($(this),'+id+',4);"  value="' + val['remind_at'] +'"   name="remind'+ id +'" class="form-control datetimepicker-input datepicker" data-target="#remind'+ id +'" required/> ' +
                      ' <div class="input-group-append" data-target="#remind'+ id +'" data-toggle="datetimepicker"> '+
                          ' <div class="input-group-text"><i class="fa fa-calendar"></i></div> '+
                      '</div> ' +
                  '</div>' +
                 + '</td>' +
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
          format: "YYYY-MM-DD HH:mm:ss",
          icons: iconlist, 
          defaultDate:new Date(),
          pickerPosition: "bottom-left" 
        });
        $(remindtime.substring(0, remindtime.length-1)).datetimepicker({
          format: "YYYY-MM-DD HH:mm:ss",
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

/* 完整內容 -E Rocky(2020/02/29 */
</script>
@endsection
     