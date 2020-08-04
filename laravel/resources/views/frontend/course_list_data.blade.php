@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '場次數據')

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
              <th class="colExcel">日期</th>
              <th class="colExcel">場次</th>
              <th class="colExcel">報名筆數</th>
              <th class="colExcel">實到人數</th>
              <th class="colExcel">報到率</th>
              <th class="colExcel">成交人數</th>
              <th class="colExcel">成交率</th>
              <th></th>
            </tr>
          @endslot
          @slot('tbody')
            @foreach($events as $data)
              <tr>
                <td>{{ $data['date'] }}</td>
                <td>{{ $data['event'] }}</td>
                <td>{{ $data['count_apply'] }} / <span style="color:red">{{ $data['count_cancel'] }}</span></td>
                <td>{{ $data['count_check'] }}</td>
                <td>{{ $data['rate_check'] }}</td>
                <td>{{ $data['deal'] }}</td>
                <td>{{ $data['rate_deal'] }}</td>
                <td>
                  <a href="{{ route('course_list_chart', ['id' => $data['id']]) }}"><button type="button"
                      class="btn btn-secondary btn-sm">完整內容</button></a>
                </td>
              </tr>
            @endforeach
          @endslot
        @endcomponent
      </div>
    </div>
  <!-- Content End -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <script>
    var table;
    var today = moment(new Date()).format("YYYYMMDD");
    var title = today + '_場次數據' + '_' + $('#course_name').val();

    $(function() {

      //DataTable
      table=$('#table_list').DataTable({
        "dom": '<Bl<t>p>',
        "columnDefs": [ {
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
          // messageTop: $('#h3_title').text(),
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

            //取日期，因為有星期所以取字串的前10文字 YYYY-MM-DD
            var startDate = data[0].substring(0, 10);
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
  </script>
@endsection