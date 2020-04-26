@extends('frontend.layouts.master')

@section('title', '財務管理')
@section('header', '財務管理')

@section('content')
<!-- Content Start -->
<!--搜尋課程頁面內容-->
<div class="card m-3">
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
        <th>獎金分配</th>
      </tr>
      @endslot
      @slot('tbody')
      @foreach($events as $key => $event )
      <tr>
        <td>{{ $event['course_start_at']  }}</td>
        <td>{{ $event['course'] }}</td>
        <td>{{ $event['event'] }}</td>
        <td><a href="javascript:void(0)" onclick="show_invoice({{ $event['id_group'] }})">{{ (empty($event['count_invoice'])) ? '0' : $event['count_invoice']  }}/{{ $event['total'] }}</a> </td>
        <td>
          <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm" name="advertise_costs" onblur="auto_update_data($(this), {{ $event['id_group'] }},{{ $event['id_course'] }} ,0);" value="{{ $event['cost_ad'] }}" />
          </div>
        </td>
        <td>
          <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm" name="sms_costs" onblur="auto_update_data($(this), {{ $event['id_group'] }},{{ $event['id_course'] }} ,1);" value="{{ $event['cost_message'] }}">
          </div>
        </td>
        <td>
          <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm" name="space_costs" onblur="auto_update_data($(this), {{ $event['id_group'] }},{{ $event['id_course'] }} ,2);" value="{{ $event['cost_events'] }}">
          </div>
        </td>
        <td>
          @if (isset(Auth::user()->role) == 'admin' || isset(Auth::user()->role) == 'accountant')
          <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" data-target="#bonus_new" onclick="show_bonus({{ $event['id']}},{{ $event['id_course'] }},{{ $event['id_group'] }})">新增獎金</button>
          @endif
        </td>
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
                  <input type="text" id="invoice_search_date" name="search_date" class="form-control datetimepicker-input" data-target="#search_date" placeholder="日期">
                  <div class="input-group-append" data-target="#search_date" data-toggle="datetimepicker">
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
              <tr>
                <td>2020-03-04</td>
                <td>王曉明</td>
                <td>二聯式</td>
                <td><input type="number" class="form-control form-control-sm" name="startdate"></td>
                <td><input type="number" class="form-control form-control-sm" name="invoice_num"></td>
                <td>王曉明</td>
                <td>54900838</td>
                <td>新竹市東區園區二路168號</td>
              </tr>
              @endslot
              @endcomponent
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- 新增發票 Rocky(2020/04/25) - E -->

    <!-- 新增獎金 Rocky (2002/04/24) - S -->
    <div class="modal fade text-left " id="bonus_new" tabindex="-1" role="dialog" aria-labelledby="bonus_newLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">新增獎金</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="input_id_events">
            <input type="hidden" id="input_id_course">
            <input type="hidden" id="input_id_group">
            <div class="form-group required">
              <label for="new_name" class="col-form-label">姓名</label>
              <input type="text" id="bonus_name" name="new_name" class="form-control" required>
            </div>
            <div class="form-group required">
              <label for="new_condition" class="col-form-label">條件</label>
              <div class="form-group row mb-3">
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="c_0">
                    <label class="form-check-label" for="c_0">
                      <h6 name="rule_name">名單來源包含<input id="t_0" type="text" name="rule" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="c_1">
                    <label class="form-check-label" for="c_1">
                      <h6 name="rule_name">工作人員包含<input id="t_1" type="text" name="rule" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="c_2">
                    <label class="form-check-label" for="c_2">
                      <h6 name="rule_name">主持開場包含<input id="t_2" type="text" name="rule" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group row mb-3">
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="c_3">
                    <label class="form-check-label" for="c_3">
                      <h6 name="rule_name">結束收單包含<input id="t_3" type="text" name="rule" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="c_4">
                    <label class="form-check-label" for="c_4">
                      <h6 name="rule_name">服務人員包含<input id="t_4" type="text" name="rule" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="c_5">
                    <label class="form-check-label" for="c_5">
                      <h6 name="rule_name">追單人員包含<input id="t_5" type="text" name="rule" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group required">
              <label for="new_mode" class="col-form-label">狀態</label>
              <div class="form-check">
                <input id="status_1" type="radio" name="status" value="1">
                <label for="status_1">啟用</label>&nbsp; &nbsp;
                <input id="status_0" type="radio" name="status" value="0">
                <label for="status_0">暫停</label>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary" onclick="add_bonus();">確認</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- 新增獎金 Rocky (2002/04/24) - E -->
  </div>
</div>

<!-- Content End -->
<script>
  var table;

  $("document").ready(function() {
    // 日期選擇器 Rocky(2020/04/24)
    $('#search_date').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    /* Datatable.js Rocky(2020/04/24) - S */
    table = $('#table_list').DataTable({
      "dom": '<l<t>p>',
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }]
    });

    $('#table_list_history').DataTable({
      "dom": '<l<td>p>',
      "destroy": true,
      "ordering": true,
      "columnDefs": [{
        "targets": 'no-sort',
      }]
    });
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

    // $('#invoice_search_date').on('keyup', function(e) {
    //   if (e.keyCode === 13) {
    //     $("#btn_search2").click();
    //   }
    // });
    // $('#invoice_search_name').on('keyup', function(e) {
    //   if (e.keyCode === 13) {
    //     $("#btn_search2").click();
    //   }
    // });
    /* 輸入框 Rocky(2020/04/24) - E */
  });

  /* 新增獎金資料 - S Rocky(2020/04/26) */
  function show_bonus(id_events, id_course, id_group) {
    $('#input_id_events').val(id_events)
    $('#input_id_course').val(id_course)
    $('#input_id_group').val(id_group)
  }

  function add_bonus() {
    var checkboxlist = '',
      namelist = '',
      nameidlist = '',
      textlist = '';

    // 名稱
    $("h6[name='rule_name']").each(function(index) {
      if (this.text != '') {
        namelist += $(this).text() + ",";
      }
    });
    if (namelist.length > 0) {
      namelist = namelist.substring(0, namelist.length - 1);
    }

    // 勾選
    $("input[type=checkbox]").each(function(index) {
      if (this.checked) {
        checkboxlist += "1,";
      } else {
        checkboxlist += "0,";
      }
    });
    if (checkboxlist.length > 0) {
      checkboxlist = checkboxlist.substring(0, checkboxlist.length - 1);
    }

    // 輸入框
    $("input[name='rule']").each(function(index) {
      if (this.val != '') {
        textlist += $(this).val() + "|";
      } else {
        textlist += "0|";
      }
    });
    if (textlist.length > 0) {
      textlist = textlist.substring(0, textlist.length - 1);
    }
    nameidlist = '0,1,2,3,4,5';
    console.log(namelist + '\n' + nameidlist + '\n' + checkboxlist + '\n' + textlist)

    $.ajax({
      type: 'POST',
      url: 'add_bonus',
      data: {
        id_events: $('#input_id_events').val(),
        id_course: $('#input_id_course').val(),
        id_group: $('#input_id_group').val(),
        name: $('#bonus_name').val(),
        bonus_status: $('input[name="status"]:checked').val(),
        namelist: namelist,
        nameidlist: nameidlist,
        checkboxlist: checkboxlist,
        textlist: textlist
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
  /* 新增獎金資料 - E Rocky(2020/04/26) */

  /* 顯示學員資料 - S Rocky(2020/04/25) */
  function show_invoice(id_group) {
    $("#invoice").modal('show');

    $.ajax({
      type: 'POST',
      url: 'show_student',
      data: {
        id_group: id_group
      },
      success: function(data) {
        // console.log(data)
        var updatetime = ''
        $('#history_data_detail').html('');
        $.each(data, function(index, val) {
          var type_invoice = ''
          if (val['type_invoice'] == '0') {
            type_invoice = '捐贈社會福利機構（ 由無極限國際公司另行辦理）'
          } else if (val['type_invoice'] == '1') {
            type_invoice = '二聯式'
          } else if (val['type_invoice'] == '2') {
            type_invoice = '三聯式'
          }
          updatetime += "#new_starttime" + val['id'] + ','
          data +=
            '<tr>' +
            '<td>' + val['created_at'] + '</td>' +
            '<td>' + val['name'] + '</td>' +
            '<td>' + type_invoice + '</td>' +
            '<td> ' +
            '<div class="input-group date show_datetime" id="new_starttime' + val['id'] + '" data-target-input="nearest"> ' +
            ' <input type="text" onblur="auto_update_invoice($(this),' + val['id'] + ',0);" value="' + val['invoice_created_at'] + '" class="form-control datetimepicker-input datepicker" data-target="#new_starttime' + val['id'] + '" /> ' +
            ' <div class="input-group-append" data-target="#new_starttime' + val['id'] + '" data-toggle="datetimepicker"> ' +
            ' <div class="input-group-text"><i class="fa fa-calendar"></i></div> ' +
            '</div> ' +
            '</div>' +
            '</td>' +
            '<td><input type="number" class="form-control form-control-sm"  onblur="auto_update_invoice($(this),' + val['id'] + ',1);"  value="' + val['invoice'] + '"></td>' +
            '<td>' + val['companytitle'] + '</td>' +
            '<td>' + val['number_taxid'] + '</td>' +
            '<td>' + val['address'] + '</td>' +
            '</tr>'
        });
        $('#history_data_detail').html(data);
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
      },
      error: function(jqXHR) {
        console.log(JSON.stringify(jqXHR));
      }
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
  $.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
      var seatch_date = $('#search_date').val();
      var seatch_course = $('#search_course').val();
      var date = data[0];
      var course = data[1];

      if ((isNaN(seatch_date) && isNaN(seatch_course)) || (date.includes(seatch_date) && isNaN(seatch_course)) || (course.includes(seatch_course) && isNaN(seatch_date)) || (course.includes(seatch_course) && date.includes(seatch_date))) {
        return true;
      }
      return false;
    }
  );

  $("#btn_search").click(function() {
    table.columns(0).search($('#search_date').val()).columns(1).search($("#search_course").val()).draw();
  });
  /* 搜尋 Rocky(2020/04/24) - E */
</script>
@endsection