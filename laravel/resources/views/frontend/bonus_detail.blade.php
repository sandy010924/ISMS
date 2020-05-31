@extends('frontend.layouts.master')

@section('title', '財務管理')
@section('header', '獎金名單 - 完整內容')

@section('content')
<!-- Content Start -->
<!--搜尋課程頁面內容-->
<div class="card m-3">
  <!-- 權限 Rocky(2020/05/10) -->
  <input type="hidden" id="auth_role" value="{{ Auth::user()}}" />
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-2">
        <h3 id="h3_title">獎金名單：{{$datas_rule[0]['bonus_name']}}</h3>
        <input type="hidden" id="id_bonus" value="{{$id_bonus}}">
      </div>
      <div class="col-2">
        <select id="cars" name="carlist" class=form-control onchange="show_student($(this).val());">
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

    table2 = $('#table_list_history').DataTable();

    // 顯示學員資料 - 名單來源
    show_student('0');

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
    // 權限判斷 Rocky(2020/05/10)
    $('#table_list_history').on('draw.dt', function() {
      check_auth();
    });
    check_auth();

  });

  // 權限判斷
  function check_auth() {
    var role = ''   
    role = JSON.parse($('#auth_role').val())['role']
    if (role != "admin") {
      $('.auth_readonly').attr('readonly', 'readonly')
    }
  }

  /* 自動儲存 - S Rocky(2020/04/28) */
  function auto_update_data(data, id) {
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


    table2.clear().draw();
    table2.destroy();

    table2 = $('#table_list_history').DataTable({
      "dom": '<l<td>Bt>',
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
        "data": null,
      }],
      "orderCellsTop": true,
      "destroy": true,
      "retrieve": true,
      buttons: [{
        extend: 'excel',
        text: '匯出Excel',
        messageTop: $('#h3_title').text(),
      }],
      "ajax": {
        "url": "show_bonus_student",
        "type": "POST",
        "data": {
          id_bonus: $('#id_bonus').val(),
          type: type
        },
        async: false,
        "dataSrc": function(json) {
          console.log(json)
          console.log(json['datas'])

          if (json['datas'].length > 0) {
            for (var i = 0; i < json['datas'].length; i++) {
              var memo = '',
                email = '',
                phone = ''
              if (json['datas'][i]['memo'] != null) {
                memo = json['datas'][i]['memo']
              }
              if (json['datas'][i]['email'] != null) {
                email = json['datas'][i]['email']
              }
              if (json['datas'][i]['phone'] != null) {
                phone = json['datas'][i]['phone']
              }

              json['datas'][i][0] = json['datas_rule_vlue'];
              json['datas'][i][1] = json['datas'][i]['course_start_at'];
              json['datas'][i][2] = json['datas'][i]['course_name'];
              json['datas'][i][3] = json['datas'][i]['events_name'];
              json['datas'][i][4] = json['datas'][i]['student_name'];
              json['datas'][i][5] = email;
              json['datas'][i][6] = phone;
              json['datas'][i][7] = json['datas'][i]['student_name'];
              json['datas'][i][8] = json['datas'][i]['student_name'];
            }
          }
          return json['datas'];
        }
      }
    });
  }
  /* 顯示學員資料 - E Rocky(2020/04/25) */

  $("#btn_search").click(function() {
    table2.search($('#search_name').val() + " " + $('#search_date').val()).draw();
  });
  /* 搜尋 Rocky(2020/04/24) - E */
</script>
@endsection