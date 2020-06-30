@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '場次總覽')

@section('content')
<!-- Content Start -->
<!--搜尋課程頁面內容-->
<div class="card m-3">
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-3 mx-3">
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
                <form class="form" action="{{url('course')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group required">
                    <label for="import_name" class="col-form-label">課程名稱</label>
                    <input type="text" class="form-control" name="import_name" id="import_name" required />
                  </div>
                  <div class="form-group required">
                    <label for="import_teacher" class="col-form-label">講師</label>
                    {{-- <select class="custom-select" name="import_teacher" id="import_teacher" required>
                        <option selected disabled value="">選擇講師</option>
                        @foreach($teachers as $teacher)
                          <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                    </select> --}}
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
                      <label class="custom-file-label" for="import_flie">瀏覽檔案</label>
                      <input type="file" class="custom-file-input" id="import_flie" name="import_flie" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required />
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <!-- <button type="button" id="import_check" class="btn btn-primary">確認</button> -->
                    <button type="submit" class="btn btn-primary">確認</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col"></div>
      <div class="col-3">
        {{-- <input type="date" class="form-control" id="search_date" name="search_date"> --}}
        <div class="input-group date" data-target-input="nearest">
          <input type="text" id="search_date" name="search_date" class="form-control datetimepicker-input" data-target="#search_date" placeholder="搜尋日期" />
          <div class="input-group-append" data-target="#search_date" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
          </div>
        </div>
      </div>
      <div class="col-3">
        <input type="search" class="form-control" placeholder="搜尋課程" aria-label="Class's name" id="search_name">
      </div>
      <div class="col-2">
        <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
      </div>
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
      <td>{{ $event['name'] }}</td>
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
          <button type="button" class="btn btn-secondary btn-sm mx-1" onclick="alert('尚未串接進階課程！\n請先到【課程管理】找到該課程的進階課程，進入至進階課程的【編輯】，點選「新增報名表」或「修改報名表」按鈕，在「對應課程」選擇此課程做串接。');location.href ='{{ $event['href_adv'] }}'">查看進階填單名單</button>
          <button type="button" class="btn btn-secondary btn-sm mx-1" onclick="alert('尚未串接進階課程！\n請先到【課程管理】找到該課程的進階課程，進入至進階課程的【編輯】，點選「新增報名表」或「修改報名表」按鈕，在「對應課程」選擇此課程做串接。');location.href ='{{ $event['href_return'] }}'">場次報表</button>
          @endif
          @endif
          @endif
          @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'officestaff' ))
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

<script>
  // Sandy(2020/02/26) dt列表搜尋 S
  var table;
  //針對日期與課程搜尋 Sandy(2020/02/26)
  $.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
      var date = $('#search_date').val();
      var name = $('#search_name').val();
      var tdate = data[0];
      var tname = data[1];

      if ((isNaN(date) && isNaN(name)) || (tdate.includes(date) && isNaN(name)) || (tname.includes(name) && isNaN(date)) || (tname.includes(name) && tname.includes(name))) {
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
      "order": [[ 0, "desc" ]],
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }]
      // "ordering": false
    });

    //日期選擇器
    $('#search_date').datetimepicker({
      format: 'YYYY-MM-DD',
    });


  });

  // 輸入框 Sandy(2020/02/25)
  $('#search_name').on('keyup', function(e) {
    if (e.keyCode === 13) {
      $('#btn_search').click();
    }
  });
  $('#search_date').on('keyup', function(e) {
    if (e.keyCode === 13) {
      $('#btn_search').click();
    }
  });
  $('#search_date').on('change.datetimepicker', function(e) {
    $('#btn_search').click();
  });

  $("#btn_search").click(function() {
    table.columns(0).search($('#search_date').val()).columns(1).search($("#search_name").val()).draw();
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