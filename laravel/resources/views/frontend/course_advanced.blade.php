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
                  <input type="text" class="form-control bg-white" aria-label="Teacher name" value="{{ $next_course->teacher }}" disabled readonly>
                </div>
              </div>
              <div class="col-5">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">課程名稱</span>
                  </div>
                  <input type="text" class="form-control bg-white" aria-label="Course name" value="{{ $next_course->course }}" disabled readonly>
                </div>
              </div>
              <hr/>
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
                      <th>Submission Date</th>
                      <th>報名日期</th>
                      <th>姓名</th>
                      <th>聯絡電話</th>
                      <th>電子郵件</th>
                      <th>我想參加課程</th>
                      <th>報名場次</th>
                      <th class=" no-sort"></th>
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
                        <td class="align-middle"><button id="{{ $data['id'] }}" class="btn btn-danger btn-sm mx-1" onclick="btn_delete({{ $data['id'] }});">刪除</button></td>
                      </tr>
                    @endforeach
                  @endslot
                @endcomponent
            {{-- <div class="table-responsive">
              <table class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>Submission Date</th>
                    <th>報名日期</th>
                    <th>姓名</th>
                    <th>聯絡電話</th>
                    <th>電子郵件</th>
                    <th>我想參加課程</th>
                    <th>報名場次</th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>現場最優惠價格</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><a href="#"><button type="button" class="btn btn-secondary btn-sm">刪除</button></a></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>五日內最優惠價格</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><a href="#"><button type="button" class="btn btn-secondary btn-sm">刪除</button></a></td>
                    </tr>
                    
                  </tbody>
              </table>
            </div> --}}
          </div>
        </div>
<!-- Content End -->
<script>
  var table;
  $("document").ready(function(){
    // datatable Sandy (2020/03/09)
    table = $('#table_list').DataTable({
        "dom": '<l<t>p>',
        "columnDefs": [ {
          "targets": 'no-sort',
          "orderable": false,
        }]
    });
  });

  // Sandy(2020/03/09) dt列表搜尋 S
  // 輸入框 Sandy(2020/02/25)
  $("#btn_search").click(function(){
    table.search($('#search_keyword').val()).draw();
  });

  $('#search_keyword').on('keyup', function(e) {
    if (e.keyCode === 13) {
        $('#btn_search').click();
    }
  });
  // Sandy(2020/03/09) dt列表搜尋 E

</script>
@endsection