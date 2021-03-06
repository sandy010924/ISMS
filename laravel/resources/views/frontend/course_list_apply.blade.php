@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '報名名單')

@section('content')
<!-- Content Start -->
<!--查看報名名單-->
<input type="hidden" id="course_id" value="{{ $course->id }}">
<input type="hidden" id="course_type" value="{{ $course->type }}">
<div class="card m-3">
  <div class="card-body">
    <div class="row">
      <div class="col-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">講師名稱</span>
          </div>
          <input type="text" class="form-control bg-white" aria-label="Teacher name" value="{{ $course->teacher }}" disabled readonly>
        </div>
      </div>
      <div class="col-5">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">課程名稱</span>
          </div>
          <input type="text" class="form-control bg-white" aria-label="Course name" id="course_name" value="{{ $course->name }}" disabled readonly>
        </div>
      </div>
      <div class="col px-5 text-right align-self-center">
        <h6 class="mb-0">累積筆數 : {{ count($apply) }} </h6>
      </div>
    </div>
  </div>
</div>
<div class="card m-3">
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-5 mx-auto">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">日期區間</span>
          </div>
          <input type="search" class="form-control px-3" name="daterange" id="daterange" autocomplete="off">
        </div>
      </div>
    </div>
    @component('components.datatable')
    @slot('thead')
    <tr>
      <th class="colExcel">報名日期</th>
      <!-- 如果是銷講多加名單來源 -->
      @if( $course->type == 1 )
      <th class="colExcel">名單來源</th>
      @endif
      <th class="colExcel">報名場次</th>
      <th class="colExcel">姓名</th>
      <th class="colExcel">聯絡電話</th>
      <th class="colExcel">電子郵件</th>
      <th class="colExcel">目前職業</th>
      <!-- 如果是銷講多加我想在講座中了解的內容 -->
      @if( $course->type == 1 )
      <th class="colExcel">我想在講座中了解的內容</th>
      @endif
      <th class="no-sort"></th>
    </tr>
    @endslot
    @slot('tbody')
    @foreach($apply as $data)
    <tr>
      @if( $course->type == 1 )
      <td>{{ $data['date'] }}</td>
      <td>{{ $data['source'] }}</td>
      @else
      <td>{{ $data['date'] }}</td>
      @endif

      @if( $data['refund_status'] == 1 )
      <td><span class="text-danger border border-danger">退費</span> {{ $data['event'] }}</td>
      @else
      <td>{{ $data['event'] }}</td>
      @endif

      <td>{{ $data['name'] }}</td>
      <td>{{ $data['phone'] }}</td>
      <td>{{ $data['email'] }}</td>
      {{-- <td>{{ substr_replace($data['phone'], '***', 4, 3) }}</td>
      <td>{{ substr_replace($data['email'], '***', strrpos($data['email'], '@')) }}</td> --}}
      <td>{{ $data['profession'] }}</td>

      <!-- 如果是銷講多加我想在講座中了解的內容 -->
      @if( $course->type == 1 )
      <td>{{ ($data['content']  == 'null')? '':$data['content'] }}</td>
      @endif
      <td>
        @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'officestaff' || Auth::user()->role == 'teacher'))
        <button id="{{ $data['id'] }}" class="btn btn-danger btn-sm mx-1" onclick="btn_delete({{ $data['id'] }});">刪除</button>
        @endif
      </td>
    </tr>
    @endforeach
    @endslot
    @endcomponent
  </div>
</div>
<style>
  table td {
    vertical-align: middle !important;
  }
</style>
<!-- Content End -->
<script>
  var table;
  var today = moment(new Date()).format("YYYYMMDD");
  var title = today + '_報名名單' + '_' + $('#course_name').val();

  $(document).ready(function() {
    //DataTable
    table = $('#table_list').DataTable({
      "dom": '<Bl<t>p>',
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }],
      buttons: [{
        extend: 'excel',
        text: '匯出Excel',
        exportOptions: {
          columns: '.colExcel'
        },
        title: title,
        // messageTop: $('#course_name').val() + ' 報名名單',
      }]
    });


    /* 日期區間 */
    if ('<?php echo $start ?>' == '' && '<?php echo $end ?>' == '') {
      //沒有資料則關閉區間搜尋
      $('#daterange').prop('disabled', true);;
    } else {
      //有資料設定日期區間
      $('input[name="daterange"]').daterangepicker({
        startDate: '<?php echo $start ?>',
        endDate: '<?php echo $end ?>',
        locale: {
          format: 'YYYY-MM-DD',
          separator: ' ~ ',
          applyLabel: '搜尋',
          cancelLabel: '取消',
        }
      });
    }

    /* 日期區間搜尋 */
    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
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
      //重設定日期區間(回到預設)
      $('#daterange').data('daterangepicker').setStartDate('<?php echo $start ?>');
      $('#daterange').data('daterangepicker').setEndDate('<?php echo $end ?>');

      //取消搜尋
      $.fn.dataTable.ext.search.pop();
      table.draw();
    });


  });


  // 刪除 Sandy(2020/03/12) start
  function btn_delete(id_apply) {
    var type = $("#course_type").val();
    var msg = "是否刪除此資料?";
    if (confirm(msg) == true) {
      $.ajax({
        type: 'POST',
        url: 'course_list_apply_delete',
        dataType: 'json',
        data: {
          type: type,
          id_apply: id_apply
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