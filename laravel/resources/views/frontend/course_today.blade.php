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
            <div class="table-responsive">
              <table id="table_list" class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>日期</th>
                    <th>課程名稱</th>
                    <th>場次</th>
                    <th>報名筆數</th>
                    <th>實到人數</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($courses as $key => $course )
                  {{-- @foreach(array_combine($courses, $salesregistrations) as $course => $salesregistration) --}}
                    <tr>
                      <td>{{ date('Y-m-d', strtotime($course->course_start_at)) }}</td>
                      <td>{{ $course->name }}</td>
                      <td>{{ $course->Events }}</td>
                      <td>{{ $courses_apply[$key] }} / <span style="color:red">{{ $courses_cancel[$key] }}</span></td>
                      <td>{{ $courses_check[$key] }}</td>
                      <td>
                        <a href="{{ route('course_check', ['id'=>$course->id]) }}"><button type="button" class="btn btn-success btn-sm">開始報到</button></a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
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


  // Sandy(2020/02/07) 列表搜尋start
  // $("#btn_search").click(function(e){
  //     var search_name = $("#search_name").val();
  //     $.ajax({
  //         type : 'GET',
  //         url:'course_today_search',
  //         dataType: 'json',
  //         data:{
  //           // '_token':"{{ csrf_token() }}",
  //           search_name: search_name
  //         },
  //         success:function(data){
  //           // console.log(data);

  //           $('#courseTodayContent').children().remove();
  //           var res = ``;
  //           $.each (data, function (key, value) {
  //             res +=`
  //             <tr>
  //               <td>${ value.date }</td>
  //               <td>${ value.name }</td>
  //               <td>${ value.event }</td>
  //               <td>${ value.count_apply } / <span style="color:red">${ value.count_cancel }</span></td>
  //               <td>${ value.count_check }</td>
  //               <td>
  //                 <a href="${ value.href_check }"><button type="button" class="btn btn-secondary btn-sm">開始報到</button></a>
  //               </td>
  //             </tr>`
  //           });

  //           $('#courseTodayContent').html(res);
  //         }
  //         // error: function(jqXHR){
  //         //    alert(JSON.stringify(jqXHR));
  //         // }
  //     });
  // });
  // Sandy(2020/02/07) 列表搜尋end
</script>
@endsection

