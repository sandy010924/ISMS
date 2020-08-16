@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '場次總覽')

@section('content')
<style>
  /* 重複資料Modal Y軸滾輪 Rocky(2020/08/06)*/
  .modal-dialog {
    overflow-y: initial !important
  }

  .modal-body_repeat {
    height: 300px;
    overflow-y: auto;
  }

  /* 重複資料Modal Y軸滾輪 Rocky(2020/08/06)*/
</style>
<!-- Content Start -->
<!--搜尋課程頁面內容-->
<div class="card m-3">
  <div class="card-body">
    <div class="row">
      <div class="col-md-3 mb-3">
        @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'saleser' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'officestaff'))
        <button type="button" class="btn btn-outline-secondary btn_date float-left mx-1" data-toggle="modal" data-target="#form_import">匯入表單</button>
        @endif
        <!-- 匯入表單 modal -->
        <div class="modal fade" id="form_import" tabindex="-1" role="dialog" aria-labelledby="form_importLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="form_importLabel">匯入表單</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="hidden" id="reload_upload" name="reload_upload" value="0">
                <form class="form" id="form_excel_upload" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group required">
                    <label for="import_name" class="col-form-label">課程名稱</label>
                    {{-- <input type="search" class="form-control" name="import_name" id="import_name" required /> --}}
                    <input type="search" list="course" id="import_name" name="import_name" class="form-control" required />
                    <datalist class="w-100" id="course">
                      @foreach($course as $data)
                      {{-- <option value="{{ $teacher->id }}">{{ $teacher->name }}</option> --}}
                      <option value="{{ $data->name }}"></option>
                      @endforeach
                    </datalist>
                  </div>
                  <div class="form-group required">
                    <label for="import_teacher" class="col-form-label">講師</label>
                    <input type="search" list="teacher" id="import_teacher" name="import_teacher" class="form-control" required />
                    <datalist class="w-100" id="teacher">
                      @foreach($teachers as $teacher)
                      {{-- <option value="{{ $teacher->id }}">{{ $teacher->name }}</option> --}}
                      <option value="{{ $teacher->name }}"></option>
                      @endforeach
                    </datalist>
                  </div>
                  <div class="form-group required">
                    <label for="import_flie" class="col-form-label">上傳檔案</label>
                    {{-- <textarea class="form-control" id="message-text"></textarea> --}}
                    <div class="custom-file">
                      <label class="custom-file-label" for="import_flie" id="import_flie_name">瀏覽檔案</label>
                      <input type="file" class="custom-file-input" id="import_flie" name="import_flie" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required />
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <!-- <button type="button" class="btn btn-primary" onclick="course_import();">確認</button> -->
                    <button type="submit" class="btn btn-primary">確認</button>

                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-5 mb-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">日期區間</span>
          </div>
          <input type="search" class="form-control px-3" name="daterange" id="daterange" autocomplete="off">
        </div>
      </div>
      <div class="col-md-auto mb-3">
        {{-- <input type="text" class="form-control" placeholder="搜尋課程" aria-label="Class's name" id="search_name"> --}}
        <div class="input-group">
          <input type="text" class="form-control" placeholder="搜尋課程" aria-label="Class's name" id="search_name">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
          </div>
        </div>
      </div>
      {{-- <div class="col">
        <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
      </div> --}}
    </div>
    @component('components.datatable')
    @slot('thead')
    <tr>
      <th>日期</th>
      <th>課程名稱</th>
      <th>場次</th>
      <th>報名/取消筆數</th>
      <th>實到筆數</th>
      <th class="no-sort"></th>
    </tr>
    @endslot
    @slot('tbody')
    @foreach($events as $key => $event )
    <tr>
      <td>{{ $event['date'] }}</td>
      <td>
        @if( $event['type'] == 1 && $event['unpublish'] == 1 )
        <span class="text-danger border border-danger">取消場次</span>
        @endif
        {{ $event['name'] }}
      </td>
      <td>{{ $event['event'] }}</td>
      <td>{{ $event['count_apply'] }} / <span style="color:red">{{ $event['count_cancel'] }}</span></td>
      <td>{{ $event['count_check'] }}</span></td>
      <td>
        <a href="{{ $event['href_check'] }}"><button type="button" class="btn btn-success btn-sm mx-1">簽到表</button></a>
        @if( strtotime($event['date']) == strtotime(date("Y-m-d")) )
        <!-- 今日場次 -->
        {{-- <a href="{{ $event['href_check'] }}"><button type="button" class="btn btn-success btn-sm mx-1">簽到表</button></a> --}}
        <a href="{{ $event['href_list'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">查詢名單</button></a>
        <a><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">查看進階填單名單</button></a>
        <a><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">場次報表</button></a>
        @elseif( strtotime($event['date']) > strtotime(date("Y-m-d")) )
        <!-- 未過場次 -->
        {{-- <a><button type="button" class="btn btn-success btn-sm mx-1" disabled="ture">簽到表</button></a> --}}
        <a href="{{ $event['href_list'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">查詢名單</button></a>
        <a><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">查看進階填單名單</button></a>
        <a><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">場次報表</button></a>
        @elseif( strtotime($event['date']) < strtotime(date("Y-m-d")) ) <!-- 已過場次 -->
          {{-- <a><button type="button" class="btn btn-success btn-sm mx-1" disabled="ture">簽到表</button></a> --}}
          <a href="{{ $event['href_list'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">查詢名單</button></a>
          @if( $event['nextLevel'] > 0 )
          <a href="{{ $event['href_adv'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">查看進階填單名單</button></a>
          <a href="{{ $event['href_return'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">場次報表</button></a>
          @else
          @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'teacher' || Auth::user()->role == 'marketer' || Auth::user()->role == 'saleser' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'accountant' || Auth::user()->role == 'officestaff'))
          <button type="button" class="btn btn-secondary btn-sm mx-1" onclick="alert('尚未串接進階課程！\n請先到【課程管理】找到該課程的進階課程，進入至進階課程的【編輯】，點選「新增報名表」或「修改報名表」按鈕，在「對應課程」選擇此課程做串接。');">查看進階填單名單</button>
          <button type="button" class="btn btn-secondary btn-sm mx-1" onclick="alert('尚未串接進階課程！\n請先到【課程管理】找到該課程的進階課程，進入至進階課程的【編輯】，點選「新增報名表」或「修改報名表」按鈕，在「對應課程」選擇此課程做串接。');location.href ='{{ $event['href_return'] }}'">場次報表</button>
          @endif
          @endif
          @endif
          @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'officestaff' || Auth::user()->role == 'teacher'))
          <button id="{{ $event['id'] }}" name="{{ $event['id_group'] }}" class="btn btn-danger btn-sm mx-1" onclick="btn_delete({{ $event['id'] }});" value="{{ $event['id'] }}">刪除</button>
          @endif
      </td>
    </tr>
    @endforeach
    @endslot
    @endcomponent
  </div>
</div>

<!-- Content End -->

<!-- 重複資料 Rocky(2020/08/02) -->
<div class="modal bd-example-modal-xl" tabindex="-1" role="dialog" id="check_excel_upload">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fa fa-bell"></i>
          重複資料提醒
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body modal-body_repeat">
        <!-- 內容 -->
        <div id="dev_repeat"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="cancle_reload_excel();">取消上傳</button>
        <button type="button" class="btn btn-success" onclick="reload_excel_upload();">繼續上傳</button>
      </div>
    </div>
  </div>
</div>
<!-- 重複資料 Rocky(2020/08/02) -->


<script>
  // Sandy(2020/02/26) dt列表搜尋 S
  var table;
  //針對日期與課程搜尋 Sandy(2020/02/26)
  $.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
      var name = $('#search_name').val();
      // var tdate = data[0];
      var tname = data[1];

      // if ((isNaN(date) && isNaN(name)) || (tdate.includes(date) && isNaN(name)) || (tname.includes(name) && isNaN(date)) || (tname.includes(name) && tname.includes(name))) {
      if (isNaN(name) || (tname.includes(name) && tname.includes(name))) {
        return true;
      }
      return false;
    }
  );

  $("document").ready(function() {
    // Rocky(2020/01/06)
    $("#import_flie").change(function() {
      var i = $(this).prev('label').clone();
      var file = $('#import_flie')[0].files[0].name;
      $(this).prev('label').text(file);
    });

    // Sandy (2020/02/26)
    table = $('#table_list').DataTable({
      "dom": '<l<t>p>',
      "order": [
        [0, "desc"]
      ],
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }]
      // "ordering": false
    });

    /* 日期區間 */

    //有資料設定日期區間
    $('input[name="daterange"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
        format: 'YYYY-MM-DD',
        separator: ' ~ ',
        applyLabel: '搜尋',
        cancelLabel: '取消',
      }
    });

    /* 日期區間搜尋 */
    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
      //輸入框key入選取的日期
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' ~ ' + picker.endDate.format('YYYY-MM-DD'));

      $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {

          var min = picker.startDate.format('YYYY-MM-DD');
          var max = picker.endDate.format('YYYY-MM-DD');

          var startDate = data[0];
          if (startDate <= max && startDate >= min) {
            return true;
          }
          return false;
        });

      table.draw();
    });

    /* 取消日期區間搜尋 */
    $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
      //輸入框清空
      $(this).val('');

      //取消搜尋
      $.fn.dataTable.ext.search.pop();
      table.draw();
    });


  });


  // Excel 匯入 Rocky(2020/08/01)
  $('#form_excel_upload').on('submit', function(event) {
    // 關閉表單自動送出
    event.preventDefault();

    var formData = new FormData(this);

    // 增加欄位
    formData.append('reload_upload', $('#reload_upload').val())

    $.ajax({
      url: 'course',
      method: "POST",
      data: formData,
      contentType: false,
      cache: false,
      processData: false,
      success: function(data) {
        // console.log(data)
        // 判斷有沒有重複資料
        if (data['status'] == 'repeat') {
          var data_repeat = ''

          // 顯示重複資料Modal
          $('#check_excel_upload').modal('show');

          // 顯示資料
          $.each(data['datas'], function(index, val) {
            var type = ''
            if (val['type'] == '1') {
              type = '<b style="color:red;padding-right: 1.6%;">有同樣姓名、email</b>'
            } else if (val['type'] == '2') {
              type = '<b style="color:#50a71a;padding-right: 2.5%;">有同樣姓名、電話</b>'
            } else if (val['type'] == '3') {
              type = '<b style="color:#2959b2;padding-right: 0.5%;">有同樣email、電話</b>'
            } else if (val['type'] == '4') {
              type = '<b style="color:#ac7e17;padding-right: 0.5%;">有同樣電話</b>'
            }

            data_repeat += type + '匯入檔案第' + val['key'] + '筆資料 - ' + val['sname'] + '學生與系統  ' +
              val['name'] + ' / ' + val['phone'] + ' / ' + val['email'] + '<br>'
          });

          $('#dev_repeat').html(data_repeat)

          // 關閉匯入Modal
          $('#form_import').modal('hide');

        } else if (data['status'] == 'successful') {
          // 關閉匯入Modal
          $('#form_import').modal('hide');

          // Alert
          $("#success_alert_text").html("匯入成功");
          fade($("#success_alert"));

          // 清空Form資料
          $('#import_flie_name').text('');
          $("#form_excel_upload")[0].reset();
        } else {
          // Alert
          $("#error_alert_text").html("匯入失敗");
          fade($("#error_alert"));

          // 清空Form資料
          $('#import_flie_name').text('');
          $("#form_excel_upload")[0].reset();
        }
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    })
  });

  // 繼續匯入 Rocky(2020/08/01)
  function reload_excel_upload() {
    var formData = new FormData($('#form_excel_upload')[0]);

    // 重新匯入
    $('#reload_upload').val('1');

    // 增加欄位
    formData.append('reload_upload', $('#reload_upload').val())

    $.ajax({
      url: 'course',
      method: "POST",
      data: formData,
      contentType: false,
      cache: false,
      processData: false,
      success: function(data) {
        // 判斷有沒有重複資料
        if (data['status'] == 'successful') {
          // 關閉匯入Modal
          $('#check_excel_upload').modal('hide');

          // Alert
          $("#success_alert_text").html("匯入成功");
          fade($("#success_alert"));

          // 清空Form資料
          $('#import_flie_name').text('');
          $("#form_excel_upload")[0].reset();

        } else {
          // Alert
          $("#error_alert_text").html("匯入失敗");
          fade($("#error_alert"));

          // 清空Form資料
          $('#import_flie_name').text('');
          $("#form_excel_upload")[0].reset();
        }
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    })
  }

  // 取消上傳 Rocky(2020/08/02)
  function cancle_reload_excel() {
    // 關閉匯入Modal
    $('#check_excel_upload').modal('hide');

    // 清空Form資料
    $('#import_flie_name').text('');
    $("#form_excel_upload")[0].reset();

  }

  // 輸入框 Sandy(2020/02/25)
  $('#search_name').on('keyup', function(e) {
    if (e.keyCode === 13) {
      $('#btn_search').click();
    }
  });

  $("#btn_search").click(function() {
    table
      .columns(1)
      .search($("#search_name").val())
      .draw();
  });
  // Sandy(2020/02/26) dt列表搜尋 E

  // 刪除 Rocky(2020/02/11) Sandy(2020/03/12)
  function btn_delete(id_events) {
    //判斷是否有群組場次
    var id_group = $("#" + id_events).attr('name');
    var group = $("button[name='" + id_group + "']").length;

    if (group > 1) {
      var msg = "此場次與其他場次有群組關係，是否刪除此場次連帶同群組場次?";
    } else {
      var msg = "是否刪除此場次?";
    }

    if (confirm(msg) == true) {
      $.ajax({
        type: 'POST',
        url: 'course_delete',
        dataType: 'json',
        data: {
          id_events: id_events,
          id_group: id_group
        },
        success: function(data) {
          if (data['data'] == "ok") {
            alert('刪除成功！！')
            /** alert **/
            // $("#success_alert_text").html("刪除課程成功");
            // fade($("#success_alert"));

            location.reload();
          } else {
            // alert('刪除失敗！！')

            /** alert **/
            $("#error_alert_text").html("刪除課程失敗");
            fade($("#error_alert"));
          }
        },
        error: function(error) {
          console.log(JSON.stringify(error));

          /** alert **/
          $("#error_alert_text").html("刪除課程失敗");
          fade($("#error_alert"));
        }
      });
    } else {
      return false;
    }
  }
</script>
@endsection