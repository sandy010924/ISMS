@extends('frontend.layouts.master')

@section('title', '財務管理')
@section('header', '獎金名單 - 完整內容')

@section('content')
<!-- Content Start -->
<!--搜尋課程頁面內容-->
<div class="card m-3">
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-2">
        <h3 id="h3_title">獎金名單：{{$datas_rule[0]['bonus_name']}}</h3>
        <input type="hidden" id="id_bonus" value="{{$id_bonus}}">
      </div>
      <div class="col-2">
        <select id="cars" name="carlist" class=form-control onchange="show_student($(this));">
          <option value="0">名單來源</option>
          <option value="1">工作人員</option>
          <option value="2">主持開場</option>
          <option value="3">結束收單</option>
          <option value="4">服務人員</option>
          <option value="5">追單人員</option>
        </select>
      </div>
    </div>
    <hr />
    <div class="row ml-4 mt-4 mb-3">
      <div class="col-2"></div>
      <div class="col-3">
        <div class="input-group date" data-target-input="nearest">
          <input type="text" id="search_date" name="search_date" class="form-control datetimepicker-input" data-target="#search_date" placeholder="日期">
          <div class="input-group-append" data-target="#search_date" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
          </div>
        </div>
      </div>
      <div class="col-3">
        <input type="search" class="form-control" placeholder="請輸入關鍵字" aria-label="Class's name" id="search_name">
      </div>
      <div class="col-3">
        <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
      </div>
    </div>
    <div class="table-responsive">
      @component('components.datatable_history')
      @slot('thead')
      <tr>
        <th>包含</th>
        <th>日期</th>
        <th>課程</th>
        <th>場次</th>
        <th>學員姓名</th>
        <th>email</th>
        <th>電話</th>
        <th>付款狀態</th>
        <th>備註</th>
      </tr>
      @endslot
      @slot('tbody')
      @foreach($datas as $key => $data )
      <tr>
        <td>{{$datas_rule[0]['value']}}</td>
        <td>{{ $data['course_start_at'] }}</td>
        <td>{{ $data['course_name'] }}</td>
        <td>{{ $data['events_name'] }}</td>
        <td>{{ $data['student_name'] }}</td>
        <td>{{ $data['email'] }}</td>
        <td>{{ $data['phone'] }}</td>
        <td>{{ $data['status_name'] }}</td>
        <td><input type="text" class="form-control form-control-sm" value="{{ $data['memo'] }}" onblur="auto_update_data($(this), {{ $data['id'] }});"></td>
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
  var table2;

  $("document").ready(function() {
    // 日期選擇器 Rocky(2020/04/24)
    $('#search_date').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    /* Datatable.js Rocky(2020/04/24) - S */

    table2 = $('#table_list_history').DataTable({
      "dom": '<l<td>Bt>',
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }],
      lengthChange: false,
      buttons: [{
        extend: 'excel',
        text: '匯出Excel',
        messageTop: $('#h3_title').text(),
      }],
    });
    /* Datatable.js Rocky(2020/04/24) - E */

    /* 輸入框 Rocky(2020/04/24) - S */
    $('#search_date').on('keyup', function(e) {
      if (e.keyCode === 13) {
        $("#btn_search").click();
      }
    });
    $('#search_name').on('keyup', function(e) {
      if (e.keyCode === 13) {
        $("#btn_search").click();
      }
    });
  });
  /* 自動儲存 - S Rocky(2020/04/28) */
  function auto_update_data(data, id) {
    console.log(data.val() + '\n' + id)
    regi_memo_update(data.val(), id);
  }

  function regi_memo_update(data, id) {
    $.ajax({
      type: 'POST',
      url: 'regi_memo_update',
      data: {
        id: id,
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
  /* 自動儲存 - E Rocky(2020/04/28) */

  /* 顯示獎金資料 - S Rocky(2020/04/26) */
  function show_bonus(id) {
    // $('#input_id').val(id)
    // $.ajax({
    //   type: 'POST',
    //   url: 'show_bonusrule',
    //   data: {
    //     id: id
    //   },
    //   dataType: 'json',
    //   success: function(data) {
    //     $("#bonus_name").val(data[0]['bonus_name']) // 姓名
    //     // 狀態
    //     if (data[0]['bonus_status'] == "1") {
    //       $('#status_1').attr('checked', 'checked');
    //     } else if (data[0]['bonus_status'] == "0") {
    //       $('#status_0').attr('checked', 'checked');
    //     }


    //     $.each(data[0]['bonus_rule'], function(index, val) {
    //       // 勾選狀態        
    //       if (val['status'] == '1') {
    //         $('input[id=c_' + val['name_id'] + ']').prop("checked", true);
    //         $('input[id=c_' + val['name_id'] + ']').val('1');
    //         $('input[id=t_' + val['name_id'] + ']').val(val['value']);
    //       } else {
    //         $('input[id=c_' + val['name_id'] + ']').prop("checked", false);
    //         $('input[id=c_' + val['name_id'] + ']').val('0');
    //       }

    //       // 規則
    //       // $('input[id=t_' + val['rule_value'] + ']').val(val['regulation']);;
    //     });
    //   },
    //   error: function(error) {
    //     console.log(JSON.stringify(error));
    //   }
    // });
  }
  /* 顯示獎金資料 - E Rocky(2020/04/26) */

  /* 顯示學員資料 - S Rocky(2020/04/25) */
  function show_student(type) {
    $.ajax({
      type: 'POST',
      url: 'show_bonus_student',
      dataType: 'json',
      data: {
        id_bonus: $('#id_bonus').val(),
        type: type.val()
      },
      success: function(data) {
        var data_table = '';

        $('#history_data_detail').html('');
        if (data['datas'].length > 0) {
          $.each(data['datas'], function(index, val) {
            var memo = ''
            if (val['memo'] != null) {
              memo = val['memo']
            }
            data_table +=
              '<tr>' +
              '<td>' + data['datas_rule_vlue'] + '</td>' +
              '<td>' + val['course_start_at'] + '</td>' +
              '<td>' + val['course_name'] + '</td>' +
              '<td>' + val['events_name'] + '</td>' +
              '<td>' + val['student_name'] + '</td>' +
              '<td>' + val['email'] + '</td>' +
              '<td>' + val['phone'] + '</td>' +
              '<td>' + val['status_name'] + '</td>' +
              '<td><input type="text" class="form-control form-control-sm" value="' + memo + '" onblur="auto_update_data($(this),' + val['id'] + ');"></td>' +
              '</tr>'
          })
        };
        $('#history_data_detail').html(data_table);
      },
      error: function(jqXHR) {
        console.log(JSON.stringify(jqXHR));
      }
    });
  }
  /* 顯示學員資料 - E Rocky(2020/04/25) */

  /* 搜尋 Rocky(2020/04/24) - S */
  // $.fn.dataTable.ext.search.push(
  //   function(settings, data, dataIndex) {
  //     if (settings.nTable == document.getElementById('table_list_history')) {
  //       var seatch_date = $('#search_date').val();
  //       var search_name = $('#search_name').val();
  //       var date = data[1];
  //       var name = data[4];
  //       var phone = data[6];

  //       if ((isNaN(seatch_date) && isNaN(search_name)) || (date.includes(seatch_date) && isNaN(search_name)) ||
  //         ((phone.includes(search_name) || name.includes(search_name)) && isNaN(seatch_date)) ||
  //         ((phone.includes(search_name) || name.includes(search_name)) && date.includes(seatch_date))) {
  //         return true;
  //       }
  //       return false;
  //     }
  //   }
  // );

  $("#btn_search").click(function() {
    table2.search($('#search_name').val() + " " + $('#search_date').val()).draw();
  });
  /* 搜尋 Rocky(2020/04/24) - E */
</script>
@endsection