@extends('frontend.layouts.master')

@section('title', '財務管理')
@section('header', '財務管理')

@section('content')
<!-- Content Start -->
<!--搜尋課程頁面內容-->
<div class="card m-3">
  <!-- 權限 Rocky(2020/05/10) -->
  <input type="hidden" id="auth_role" value="{{ Auth::user() }}" />
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-2">
      </div>
      <div class="col-3">
        <div class="input-group date" data-target-input="nearest">
          <input type="text" id="search_date" name="search_date" class="form-control datetimepicker-input" data-target="#search_date" placeholder="日期">
          <div class="input-group-append" data-target="#search_date" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
          </div>
        </div>
      </div>
      <div class="col-3">
        <input type="search" class="form-control" placeholder="搜尋課程" aria-label="Class's name" id="search_course">
      </div>
      <div class="col-3">
        <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
      </div>
    </div>
    <div class="table-responsive">
      @component('components.datatable')
      @slot('thead')
      <tr>
        <th>日期</th>
        <th>課程名稱</th>
        <th>場次</th>
        <th>發票</th>
        <th>廣告成本</th>
        <th>訊息成本</th>
        <th>場地成本</th>
      </tr>
      @endslot
      @slot('tbody')
      @foreach($events as $key => $event )
      <tr>
        <input type="hidden" id="id_group" value="{{ $event['id_group'] }}">
        <td>{{ $event['course_start_at']  }}</td>
        <td style="text-align:left;">
          @if($event['events_multi_data'] != '')
          <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" data-target="#bonus_edite{{$event['id']}}">多天</button>
          @endif
          {{ $event['course'] }}
        </td>
        <td>{{ $event['event'] }}</td>
        <td><a href="javascript:void(0)" onclick="show_invoice({{ $event['id'] }})">{{ (empty($event['count_invoice'])) ? '0' : $event['count_invoice']  }}/{{ $event['total'] }}</a> </td>
        <td>
          <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm auth_readonly" name="advertise_costs" onblur="auto_update_data($(this), {{ $event['id_group'] }},{{ $event['id_course'] }} ,0);" value="{{ $event['cost_ad'] }}" />
          </div>
        </td>
        <td>
          <div class="col-sm-8">
            <span>{{ $event['cost_message'] }}</span>
          </div>
        </td>
        <td>
          <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm auth_readonly" name="space_costs" onblur="auto_update_data($(this), {{ $event['id_group'] }},{{ $event['id_course'] }} ,2);" value="{{ $event['cost_events'] }}">
          </div>
        </td>
        <!-- 場次多天詳細資料 Rocky (2002/06/28) - S -->
        <div class="modal fade text-left " id="bonus_edite{{$event['id']}}" tabindex="-1" role="dialog" aria-labelledby="bonus_editeLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-body">
                {{ $event['events_multi_data'] }}
              </div>
            </div>
          </div>
        </div>
        <!-- 編輯獎金 Rocky (2002/04/26) - E -->
      </tr>
      @endforeach
      @endslot
      @endcomponent
    </div>

    <!-- 新增發票 Rocky(2020/04/25) - S -->
    <div class="modal fade text-left " id="invoice" tabindex="-1" role="dialog" aria-labelledby="invoiceLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">發票資訊</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row mb-3">
              <div class="col-2">
              </div>
              <div class="col-3">
                <div class="input-group date" data-target-input="nearest">
                  <input type="text" id="invoice_search_date" name="invoice_search_date" class="form-control datetimepicker-input" data-target="#invoice_search_date" placeholder="購買日期">
                  <div class="input-group-append" data-target="#invoice_search_date" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
              <div class="col-3">
                <input id="invoice_search_name" type="search" class="form-control" placeholder="輸入學員姓名" aria-label="Class's name">
              </div>
              <div class="col-3">
                <button class="btn btn-outline-secondary" type="button" id="btn_search2">搜尋</button>
              </div>
            </div>
            <div class="table-responsive">
              @component('components.datatable_history')
              @slot('thead')
              <tr>
                <th>購買日期</th>
                <th>學員姓名</th>
                <th>發票</th>
                <th>開立日期</th>
                <th>發票號碼</th>
                <th>抬頭</th>
                <th>統編</th>
                <th>地址</th>
              </tr>
              @endslot
              @slot('tbody')
              @endslot
              @endcomponent
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- 新增發票 Rocky(2020/04/25) - E -->
  </div>
</div>

<!-- Content End -->
<script>
  var table, table2;

  $("document").ready(function() {

    // 日期選擇器 Rocky(2020/04/24)
    $('#search_date').datetimepicker({
      format: 'YYYY-MM-DD'
    });
    $('#invoice_search_date').datetimepicker({
      format: 'YYYY-MM-DD'
    });


    /* Datatable.js Rocky(2020/04/24) - S */
    table = $('#table_list').DataTable({
      "dom": '<l<t>p>',
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }],
      "orderCellsTop": true
    });

    table2 = $('#table_list_history').DataTable();
    /* Datatable.js Rocky(2020/04/24) - E */

    /* 輸入框 Rocky(2020/04/24) - S */
    $('#search_date').on('keyup', function(e) {
      if (e.keyCode === 13) {
        $("#btn_search").click();
      }
    });

    $('#search_course').on('keyup', function(e) {
      if (e.keyCode === 13) {
        $("#btn_search").click();
      }
    });

    $('#invoice_search_date').on('keyup', function(e) {
      if (e.keyCode === 13) {
        $("#btn_search2").click();
      }
    });
    $('#invoice_search_name').on('keyup', function(e) {
      if (e.keyCode === 13) {
        $("#btn_search2").click();
      }
    });
    /* 輸入框 Rocky(2020/04/24) - E */

    // 權限判斷 Rocky(2020/05/10)
    $('#table_list').on('draw.dt', function() {
      check_auth();
    });
    check_auth();
  });

  // 權限判斷
  function check_auth() {
    var role = ''
    role = JSON.parse($('#auth_role').val())['role']
    if (role != "admin" && role != "accountant") {
      $('.auth_readonly').attr('readonly', 'readonly')
    }
  }

  /* 顯示學員資料 - S Rocky(2020/04/25) */
  function show_invoice(id_events) {
    var updatetime = ''
    $("#invoice").modal('show');
    $("#invoice_search_date").val('');
    $("#invoice_search_name").val('');

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
        "url": "show_student",
        "type": "POST",
        "data": {
          id_events: id_events
        },
        async: false,
        "dataSrc": function(json) {
          console.log(json)
          for (var i = 0, ien = json.length; i < ien; i++) {
            var type_invoice = ''

            if (json[i]['type_invoice'] == '0') {
              type_invoice = '捐贈社會福利機構（ 由無極限國際公司另行辦理）'
            } else if (json[i]['type_invoice'] == '1') {
              type_invoice = '二聯式'
            } else if (json[i]['type_invoice'] == '2') {
              type_invoice = '三聯式'
            }
            updatetime += "#new_starttime" + json[i]['id'] + ','
            json[i][0] = json[i]['created_at'];
            json[i][1] = json[i]['name'];
            json[i][2] = type_invoice;
            // json[i][3] = '<div class="input-group date show_datetime " id="new_starttime' + json[i]['id'] + '" data-target-input="nearest"> ' +
            //   ' <input type="text onblur="auto_update_invoice($(this),' + json[i]['id'] + ',0);" value="' + json[i]['invoice_created_at'] + '" class="form-control datetimepicker-input datepicker" data-target="#new_starttime' + json[i]['id'] + '" /> ' +
            //   ' <div class="input-group-append" data-target="#new_starttime' + json[i]['id'] + '" data-toggle="datetimepicker"> ' +
            //   ' <div class="input-group-text"><i class="fa fa-calendar"></i></div> ' +
            //   '</div> ' +
            //   '</div>'
            json[i][3] = '<div class="input-group date" data-target-input="nearest"> ' +
              ' <input type="text" onblur="auto_update_invoice($(this),' + json[i]['id'] + ',0);" id="new_starttime' + json[i]['id'] + '" name="new_starttime' + json[i]['id'] + '" value="' + json[i]['invoice_created_at'] + '"  class="form-control datetimepicker-input" data-target="#search_date" placeholder="日期"> ' +
              ' <div class="input-group-append" data-target="#new_starttime' + json[i]['id'] + '" data-toggle="datetimepicker"> ' +
              ' <div class="input-group-text"><i class="fa fa-calendar"></i></div> ' +
              '</div> </div>';
            // <div class="input-group date" data-target-input="nearest">
            //     <input type="text" id="invoice_search_date" name="search_date" class="form-control datetimepicker-input" data-target="#search_date" placeholder="日期">
            //     <div class="input-group-append" data-target="#search_date" data-toggle="datetimepicker">
            //       <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            //     </div>
            //   </div>
            json[i][4] = '<input type="number" class="form-control form-control-sm"  onblur="auto_update_invoice($(this),' + json[i]['id'] + ',1);"  value="' + json[i]['invoice'] + '">';
            json[i][5] = json[i]['companytitle'];
            json[i][6] = json[i]['number_taxid'];
            json[i][7] = json[i]['address'];
          }
          return json;

        }
      }
    });

    // 日期
    $(updatetime.substring(0, updatetime.length - 1)).datetimepicker({
      format: "YYYY-MM-DD",
      pickerPosition: "bottom-left"
    })

    // 調整Datable.js寬度
    $("#table_list_history").css({
      "width": "100%"
    });
  }

  /* 顯示學員資料 - E Rocky(2020/04/25) */

  /* 自動儲存 - S Rocky(2020/04/25) */
  function auto_update_data(data, id_group, id_course, type) {
    // console.log(data.val())
    events_update(data.val(), id_group, type)
  }

  function events_update(data, id_group, type) {
    $.ajax({
      type: 'POST',
      url: 'events_update',
      data: {
        id_group: id_group,
        type: type,
        data: data
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

  // 發票
  function auto_update_invoice(data, id, type) {
    invoice_update(data.val(), id, type)
  }

  function invoice_update(data, id, type) {
    $.ajax({
      type: 'POST',
      url: 'invoice_update',
      data: {
        id: id,
        type: type,
        data: data
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
  /* 自動儲存 - S Rocky(2020/04/25) */

  /* 搜尋 Rocky(2020/04/24) - S */
  // $.fn.dataTable.ext.search.push(
  //   function(settings, data, dataIndex) {
  //     console.log(settings.nTable)
  //     if (settings.nTable == document.getElementById('table_list')) {
  //       var seatch_date = $('#search_date').val();
  //       var seatch_course = $('#search_course').val();
  //       var date = data[0];
  //       var course = data[1];

  //       if ((isNaN(seatch_date) && isNaN(seatch_course)) || (date.includes(seatch_date) && isNaN(seatch_course)) || (course.includes(seatch_course) && isNaN(seatch_date)) || (course.includes(seatch_course) && date.includes(seatch_date))) {
  //         return true;
  //       }
  //       return false;
  //     } else {
  //       var seatch_date = $('#invoice_search_date').val();
  //       var seatch_name = $('#invoice_search_name').val();
  //       var date = data[0];
  //       var name = data[1];
  //       console.log(name)
  //       if ((isNaN(seatch_date) && isNaN(seatch_name)) || (date.includes(seatch_date) && isNaN(seatch_name)) || (name.includes(seatch_name) && isNaN(seatch_date)) || (name.includes(seatch_name) && date.includes(seatch_date))) {
  //         return true;
  //       }
  //     }
  //   }
  // );

  $("#btn_search").click(function() {
    table.columns(0).search($('#search_date').val()).columns(1).search($("#search_course").val()).draw();
    // table.search($('#search_course').val() + " " + $('#search_date').val()).draw();
  });

  $("#btn_search2").click(function() {
    table2.columns(0).search($('#invoice_search_date').val()).columns(1).search($("#invoice_search_name").val()).draw();
  });
  /* 搜尋 Rocky(2020/04/24) - E */
</script>
@endsection