@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '黑名單')

@section('content')
<link href="{{ asset('css/bootstrap-tagsinput.css') }}" rel="stylesheet">
<style>
  input:read-only {
    background-color: #e0e0e0 !important;
  }

  .bootstrap-tagsinput .tag [data-role="remove"] {
    display: none;
  }
</style>
<!-- Content Start -->
<!--黑名單內容-->
<div class="card m-3">
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-4"></div>
      <div class="col-3">
        <input type="search" class="form-control" placeholder="輸入電話或email" aria-label="Student's Phone or Email" id="search_input" onkeyup="value=value.replace(/[^\w_.@]/g,'')">
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
      @component('components.datatable')
      @slot('thead')
      <tr>
        <th>姓名</th>
        <th>連絡電話</th>
        <th>電子郵件</th>
        <th>原因</th>
        <th></th>
      </tr>
      @endslot
      @slot('tbody')
      @foreach($blacklists as $blacklist)
      <tr>
        <td>{{$blacklist->name }}</td>
        <td>{{$blacklist->phone}}</td>
        <td>{{$blacklist->email}}</td>
        <td>{{$blacklist->reason}}</td>

        <td>
          <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" onclick="course_data({{ $blacklist->id }});">完整內容</button>
          <button id="{{ $blacklist->blacklist_id }}" class="btn btn-dark btn-sm mx-1" onclick="btn_blacklist({{ $blacklist->blacklist_id }});" value="{{ $blacklist->blacklist_id }}"><i class="fa fa-ban"></i>取消黑名單</button>
        </td>
      </tr>
      @endforeach
      @endslot
      @endcomponent
    </div>
    <div class="modal fade bd-example-modal-xl text-left" id="student_information" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content p-3">
          <div class="row">
            <div class="col-5 py-2">
              <h5 id="student_name"></h5>
              <h5 id="student_email"></h5>
              <h5 id="title_student_phone"></h5>
            </div>
            <div class="col-4">
            </div>
            <div class="col-4 py-3">
              <h7 id="title_old_datasource"></h7><br>
              <h7 id="student_date"></h7><br>
              <h7 id="student_datasource"></h7>
            </div>
          </div>
          <!-- 標記 -S  -->
          <div class="row">
            <div class="col-12 py-2">
              <h6>標記 :</h6>
              <input type="text" id="isms_tags" />
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
                        <input id="student_profession" type="text" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-6">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">原始來源</span>
                        </div>
                        <input type="text" id="old_datasource" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                        <input type="hidden" id="sales_registration_old">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">電話</span>
                        </div>
                        <input id="student_phone" type="text" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
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
                    <input type="text" id="student_address" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
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
            <!-- 完整內容 - E -->
          </div>
        </div>
      </div>
      <!-- 完整內容 - E -->
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
  var table, table2;


  $("document").ready(function() {
    btn_blackadd();
    // 學員管理搜尋 (只能輸入數字、字母、_、.、@)
    $('#search_input').on('blur', function() {
      // console.log(`search_input: ${$(this).val()}`);
    });

    // Rocky (2020/03/27)
    table = $('#table_list').DataTable({
      "dom": '<l<td>Btp>',
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }],

      "destroy": true,
      "retrieve": true,
      buttons: [{
        extend: 'excel',
        text: '匯出Excel',
        messageTop: '黑名單',
        exportOptions: {
          columns: [0, 1, 2, 3]
        }
      }],
      // "ordering": false,
    });

    // Rocky (2020/04/17)
    table2 = $('#table_list_history').DataTable();
  });


  // 追單資料關閉
  $("#show_contact_close").click(function() {
    $('#show_contact').modal('hide');
  });

  // 輸入框
  $('#search_input').on('keyup', function(e) {
    if (e.keyCode === 13) {
      $('#btn_search').click();
    }
  });

  /*搜尋 Rocky(2020/02/23)*/
  $("#btn_search").click(function(e) {
    table.search($('#search_input').val()).draw();
  });


  /* 完整內容 -S Rocky(2020/02/29) */

  // 基本訊息
  function course_data(id_student) {
    // console.log(id_student)
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
        // 銷講報到率
        var sales_successful_rate = '0',
          course_cancel_rate = '0';
        var course_sales_status = '';
        if (data['count_sales_ok'] != 0) {
          sales_successful_rate = (data['count_sales_ok'] / (data['count_sales'] - data['count_sales_no']) * 100).toFixed(0)
        }

        // 銷講取消率
        if (data['count_sales_no'] != 0) {
          course_cancel_rate = (data['count_sales_no'] / data['count_sales'] * 100).toFixed(0)
        }
        // 學員資料
        $('#student_name').text(data[0]['name']);
        $('#student_email').text(data[0]['email']);
        $('#title_student_phone').text(data[0]['phone']);
        $('#title_old_datasource').text('原始來源:' +
          data[0]['datasource_old']);
        $('#student_date').text('加入日期 :' + data['submissiondate']);
        $('#student_profession').val(data[0]['profession']);
        $('#student_address').val(data[0]['address']);
        $('#sales_registration_old').val(data[0]['sales_registration_old']);
        $('#old_datasource').val(data[0]['datasource_old']);
        $('#student_phone').val(data[0]['phone']);

        // 銷講      
        $('input[name="new_datasource"]').val(data['datasource']);


        // if (data['course_sales_events'] != null) {
        //   $('input[name="course_sales_events"]').val(data['course_sales'] + data['course_sales_events'] + '(' + data['sales_registration_course_start_at'] + ')');
        // }
        if (data['course_sales'] != null) {
          var course_sales = '',
            course_sales_events = '',
            sales_registration_course_start_at = ''
          if (data['course_sales'] == null) {
            course_sales = " "
          } else {
            course_sales = data['course_sales']
          }

          if (data['course_sales_events'] == null) {
            course_sales_events = " "
          } else {
            course_sales_events = data['course_sales_events']
          }

          if (data['sales_registration_course_start_at'] == null) {
            // 我很遺憾
            if (data['id_events'] == '-99' || data['events'] != '') {
              sales_registration_course_start_at = data['events']
            } else {
              sales_registration_course_start_at = "無"
            }

          } else {
            sales_registration_course_start_at = data['sales_registration_course_start_at']
          }

          course_sales_events = course_sales + ' ' + course_sales_events + '(' + sales_registration_course_start_at + ' )'
        }
        $('input[name="course_sales_events"]').val(course_sales_events)



        $('input[name="course_content"]').val(data['course_content']);
        $('input[name="status_payment"]').val('');
        if (typeof(data['status_registration']) != 'undefined') {
          course_sales_status = data['status_registration'] + '(' + data['course_registration'] + data['course_events'] + ')'
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
          var course_events = '',
            course_registration = '',
            registration_course_start_at = '',
            course_registration_events = ''
          if (data['course_events'] == null) {
            course_events = " "
          } else {
            course_events = data['course_events']
          }

          if (data['course_registration'] == null) {
            course_registration = " "
          } else {
            course_registration = data['course_registration']
          }

          if (data['registration_course_start_at'] == null) {
            registration_course_start_at = "無"
          } else {
            registration_course_start_at = data['registration_course_start_at']
          }

          course_registration_events = course_registration + ' ' + course_events + '(' + registration_course_start_at + ' )'

          $('input[name="course_events"]').val(course_registration_events);
        }

        // 退款
        $('input[name="course_refund"]').val('');
        if (typeof(data['refund_course']) != 'undefined') {
          $('input[name="course_refund"]').val(data['refund_course'] + '(' + data['refund_reason'] + ')');
        } else {
          $('#dev_refund').hide();

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
      }],
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
          for (var i = 0, ien = json.length; i < ien; i++) {

            var status = '',
              course_sales = '';
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

            // id_student = json[i]['id_student'];
            json[i][0] = json[i]['created_at'];
            json[i][1] = status;
            json[i][2] = course_sales;
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
        updatetime = '', remindtime = '', id_debt_status_payment_name = '', id_status = '', val_status = '', val_status_payment_name = ''
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
            '<td><i class="fa fa-address-card " aria-hidden="true" onclick="debt_show(' + id + ');" style="cursor:pointer;padding-top: 40%;"></i></td>' +
            '<td>' +
            '<div class="input-group date show_datetime" id="new_starttime' + id + '" data-target-input="nearest"> ' +
            ' <input type="text" readonly onblur="save_data($(this),' + id + ',0);"  value="' + val['updated_at'] + '"   name="new_starttime' + id + '" class="form-control datetimepicker-input datepicker auth_readonly" data-target="#new_starttime' + id + '" data-toggle="datetimepicker" autocomplete="off" required/> ' +
            '</div> ' +
            '</div>' +
            '</td>' +
            '<td>' + '<input type="text" readonly  class="form-control auth_readonly" onblur="save_data($(this),' + id + ',6);" id="' + id + '_name_course" value="' + val['name_course'] + '" class="border-0 bg-transparent input_width">' + '</td>' +
            '<td>' + '<input type="text"   readonly class="auth_readonly form-control" onblur="save_data($(this),' + id + ',1);" id="' + id + '_status_payment" value="' + status_payment + '" class="border-0 bg-transparent input_width">' + '</td>' +
            '<td>' + '<input type="text"  readonly class=" auth_readonly form-control" onblur="save_data($(this),' + id + ',2);" id="' + id + '_contact" value="' + contact + '"  class="border-0 bg-transparent input_width">' + '</td>' +
            '<td style="width:15%;">' + '<div class="form-group show_select m-0"> <select id="' + id_debt_status_payment_name + '" onblur="save_data($(this),' + id + ',7);" disabled class="auth_readonly custom-select border-0 bg-transparent input_width"> ' +
            '<option selected disabled value=""></option>' +
            '<option value="留單">留單</option>' +
            '<option value="完款">完款</option>' +
            '<option value="付訂">付訂</option>' +
            '<option value="退費">退費</option>' +
            '</select>' +
            '</div> </td>' +
            '<td style="width:15%;">' + '<div class="form-group show_select m-0"> <select id="' + id_status + '" disabled  onblur="save_data($(this),' + id + ',3);" class="auth_readonly custom-select border-0 bg-transparent input_width"> ' +
            '<option selected disabled value=""></option>' +
            '<option value="12">待追</option>' +
            '<option value="15">無意願</option>' +
            '<option value="16">推薦其他講師</option>' +
            '<option value="22">通知下一梯次</option>' +
            '</select>' +
            '</div> </td>' +
            '<td>' + '<input type="text"  readonly class="auth_readonly form-control" onblur="save_data($(this),' + id + ',5);" id="' + id + '_person" value="' + person + '" class="border-0 bg-transparent input_width">' + '</td>' +
            '<td>' +
            '<div class="input-group date show_datetime" id="remind' + id + '" data-target-input="nearest"> ' +
            ' <input type="text" readonly onblur="save_data($(this),' + id + ',4);"  value="' + val['remind_at'] + '"   name="remind' + id + '" class="auth_readonly form-control datetimepicker-input datepicker" data-target="#remind' + id + '" data-toggle="datetimepicker" autocomplete="off" required/> ' +
            ' <div class="input-group-append" data-target="#remind' + id + '" data-toggle="datetimepicker"> ' +
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


  /*取消黑名單 Rocky(2020/02/23)*/
  function btn_blacklist(id_blacklist) {
    $.ajax({
      type: 'GET',
      url: 'blacklist_cancel',
      dataType: 'json',
      data: {
        id_blacklist: id_blacklist
      },
      success: function(data) {
        if (data['data'] == "ok") {
          /** alert **/
          $("#success_alert_text").html("取消成功");
          fade($("#success_alert"));

          location.reload();
        } else {
          /** alert **/
          $("#error_alert_text").html("取消失敗");
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
  }

  /*新增黑名單 Rocky(2020/03/01)*/
  function btn_blackadd() {
    $.ajax({
      type: 'post',
      url: 'blacklist_add',
      dataType: 'json',
      success: function(data) {
        // console.log(data);
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }
</script>
@endsection