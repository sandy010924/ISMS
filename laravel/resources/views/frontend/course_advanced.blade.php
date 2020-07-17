@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '進階填單名單')

@section('content')
<!-- Content Start -->
<!--搜尋課程頁面內容-->
<div class="card m-3">
  <div class="card-body">
    <div class="row">
      <div class="col-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">講師名稱</span>
          </div>
          <input type="text" class="form-control bg-white" aria-label="Teacher name" value="{{ $teacher }}" disabled readonly>
        </div>
      </div>
      <div class="col">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">課程名稱</span>
          </div>
          <input type="text" class="form-control bg-white" aria-label="Course name" value="{{ $next_course }}" disabled readonly>
        </div>
      </div>
      <hr />
    </div>
  </div>
</div>
<div class="card m-3">
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-6 p-2 ml-2">
        <h6 class="mb-0">
          {{ date('Y-m-d', strtotime($course->course_start_at)) }}
          ( {{ $week }} )&nbsp;
          {{ $course->name }}&nbsp;&nbsp;
          {{ $course->course }}&nbsp;&nbsp;
          填單筆數：{{ count($fill) }}
        </h6>
        {{-- <h6 class="mb-0">2019/12/31(五)&nbsp;&nbsp;台北下午場&nbsp;&nbsp;零秒成交數&nbsp;&nbsp;填單筆數:5</h6> --}}
      </div>
      <div class="col-4 mx-auto">
        <div class="input-group">
          <input type="search" class="form-control" placeholder="關鍵字" id="search_keyword">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
          </div>
        </div>
      </div>
      {{-- <div class="col-3 align-right">
                      <div class="input-group">
                          <input type="number" class="form-control" placeholder="關鍵字"  max="999">
                          <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">搜尋</button>
                          </div>
                      </div>
                    </div> --}}
    </div>
    @component('components.datatable')
    @slot('thead')
    <tr>
      <th class="colExcel">Submission Date</th>
      <th class="colExcel">報名日期</th>
      <th class="colExcel">姓名</th>
      <th class="colExcel">聯絡電話</th>
      <th class="colExcel">電子郵件</th>
      <th class="colExcel">我想參加課程</th>
      <th class="colExcel">報名場次</th>
      <th class="colExcel">付款狀態</th>
      @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'officestaff' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'teacher'))
      <th class=" no-sort"></th>
      @endif
    </tr>
    @endslot
    @slot('tbody')
    @foreach($fill as $data)
    <tr>
      <td class="align-middle">{{ $data['submission'] }}</td>
      <td class="align-middle">{{ $data['date'] }}</td>
      <td class="align-middle">{{ $data['name'] }}</td>
      <td class="align-middle">{{ $data['phone'] }}</td>
      <td class="align-middle">{{ $data['email'] }}</td>
      <td class="align-middle">{{ $data['join'] }}</td>
      <td class="align-middle">{{ $data['event'] }}</td>
      <td class="align-middle">{{ $data['status_payment'] }}</td>
      @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'officestaff' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'teacher'))
      <td class="align-middle"><button id="{{ $data['id'] }}" class="btn btn-danger btn-sm mx-1" onclick="btn_delete({{ $data['id'] }});">刪除</button></td>
      @endif
    </tr>
    @endforeach
    @endslot
    @endcomponent
  </div>
</div>

<!-- alert Start-->
{{-- <div class="alert alert-success alert-dismissible m-3 position-fixed fixed-bottom" role="alert" id="success_alert">
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
    </div> --}}
<!-- alert End -->
<!-- Content End -->
<script>
  var table;
  $("document").ready(function() {
    // datatable Sandy (2020/03/09)
    table = $('#table_list').DataTable({
      "dom": '<Bl<t>p>',
      "order": [
        [0, "desc"]
      ],
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }],
      buttons: [{
        extend: 'excel',
        text: '匯出Excel',
        exportOptions: {
          columns: '.colExcel'
        }
        // messageTop: $('#h3_title').text(),
      }]
    });
  });

  // Sandy(2020/03/09) dt列表搜尋 S
  // 輸入框 Sandy(2020/02/25)
  $("#btn_search").click(function() {
    table.search($('#search_keyword').val()).draw();
  });

  $('#search_keyword').on('keyup', function(e) {
    if (e.keyCode === 13) {
      $('#btn_search').click();
    }
  });
  // Sandy(2020/03/09) dt列表搜尋 E

  // 刪除 Sandy(2020/03/12) start
  function btn_delete(id_registration) {
    var msg = "是否刪除此資料?";
    if (confirm(msg) == true) {
      $.ajax({
        type: 'POST',
        url: 'course_advanced_delete',
        dataType: 'json',
        data: {
          id_registration: id_registration
        },
        success: function(data) {
          console.log(data);
          if (data['data'] == "ok") {
            alert('刪除成功！！')
            /** alert **/
            // $("#success_alert_text").html("刪除資料成功");
            // fade($("#success_alert"));

            location.reload();
          } else {
            // alert('刪除失敗！！')

            /** alert **/
            $("#error_alert_text").html("刪除資料失敗");
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
    } else {
      return false;
    }
  }
  // 刪除 Sandy(2020/03/12) end
</script>
@endsection