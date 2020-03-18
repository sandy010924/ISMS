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
              <input type="text" class="form-control bg-white" aria-label="Course name" value="{{ $course->name }}" disabled readonly>
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
              <input type="text" class="form-control px-3" name="daterange"> 
            </div>
          </div>
        </div>
        @component('components.datatable')
          @slot('thead')
            <tr>
              <th>日期</th>
              <th>場次</th>
              <th>報名筆數</th>
              <th>實到人數</th>
              <th>報到率</th>
              <th>成交人數</th>
              <th>成交率</th>
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
    $(function() {
      //日期區間
      $('input[name="daterange"]').daterangepicker({
        locale: {
          format: 'YYYY-MM-DD',
          separator: ' 至 '
        }
      }, function(start, end, label) {
        console.log(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
      });
      
      //DataTable
      table=$('#table_list').DataTable({
        "dom": '<l<t>p>',
        "columnDefs": [ {
          "targets": 'no-sort',
          "orderable": false,
        } ]
      });
    });
  </script>
@endsection