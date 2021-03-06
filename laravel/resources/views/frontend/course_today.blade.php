@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '今日課程')

@section('content')
<!-- Content Start -->
        <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-6 mx-auto">
                <div class="input-group">
                  <input type="search" id="search_name" class="form-control" placeholder="搜尋課程" aria-label="Course's name" aria-describedby="btn_search">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
                  </div>
                </div>
              </div>
            </div>
            @component('components.datatable')
              @slot('thead')
                <tr>
                  <th>日期</th>
                  <th>課程名稱</th>
                  <th>場次</th>
                  <th>報名/取消筆數</th>
                  <th>實到人數</th>
                  <th></th>
                </tr>
              @endslot
              @slot('tbody')
                @foreach($events as $key => $course )
                  <tr>
                    <td>{{ date('Y-m-d', strtotime($course->course_start_at)) }}</td>
                    <td>{{ $course->course }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $count_apply[$key] }} / <span style="color:red">{{ $count_cancel[$key] }}</span></td>
                    <td>{{ $count_check[$key] }}</td>
                    <td>
                      <a href="{{ route('course_check', ['id'=>$course->id]) }}"><button type="button" class="btn btn-success btn-sm">簽到表</button></a>
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

  $(document).ready(function() {
      table=$('#table_list').DataTable({
      "dom": '<l<t>p>',
      "ordering": false,
      "columnDefs": [ {
        "targets": 'no-sort',
        "orderable": false,
      } ]
    });
  });

  $('#search_name').on('keyup', function(e) {
    if (e.keyCode === 13) {
      $('#btn_search').click();
    }
  });

  $("#btn_search").click(function(){
    table.columns(1).search($("#search_name").val()).draw();
  });
  // Sandy(2020/02/26) dt列表搜尋 E
</script>
@endsection

