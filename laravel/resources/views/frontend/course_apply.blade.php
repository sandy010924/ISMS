@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '查詢名單')

@section('content')

<!-- Content Start -->
  <!--查看報名內容-->
  <div class="card m-3">
    <div class="card-body">
      <div class="row">
        <div class="col-3">
          <input type="hidden" id="course_id" value="{{ $course->id }}">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">講師名稱</span>
            </div>
            <input type="text" class="form-control bg-white" aria-label="Teacher name" value="{{ $course->teacher_name }}" readonly>
          </div>
          {{-- <h5>
            講師名稱 : <input type="text" class="mt-2" value="{{ $course->teacher_name }}" readonly>
          </h5> --}}
        </div>
        <div class="col-5">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">課程名稱</span>
            </div>
            <input type="text" class="form-control bg-white" aria-label="Course name" value="{{ $course->name }}" readonly>
          </div>
          {{-- <h5>
            課程名稱 : <input type="text" class="mt-2" value="{{ $course->name }}" readonly>
          </h5> --}}
        </div>
        <hr/>
      </div>
    </div>
  </div>
  <div class="card m-3">
      <div class="card-body">
          <div class="row mb-3">
              <div class="col-8 align-self-center">
                  <h6 class="mb-0">
                    {{ date('Y-m-d', strtotime($course->course_start_at)) }}
                    ( {{ $week }} )&nbsp;&nbsp;
                    {{ $course->Events }}&nbsp;
                    報名筆數 : {{ $count_apply }}&nbsp;
                    取消筆數 : {{ $count_cancel }}
                  </h6>
              </div>
              {{-- <div class="col-2">
              </div> --}}
              <div class="col-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="關鍵字" id="search_keyword">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
                    </div>
                </div>
              </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-sm text-center" id="table_apply">
              <thead>
                <tr>
                  <th>Submission Date</th>
                  <th>名單來源</th>
                  <th>姓名</th>
                  <th>聯絡電話</th>
                  <th>電子郵件</th>
                  <th>目前職業</th>
                  <th>我想在講座中了解的內容</th>
                  @if( strtotime(date('Y-m-d', strtotime($course->course_start_at))) > strtotime(date("Y-m-d")) )
                  <!-- 未過場次 -->
                  <th></th>
                  @elseif( strtotime(date('Y-m-d', strtotime($course->course_start_at))) <= strtotime(date("Y-m-d")) )
                  <!-- 已過場次 -->
                  <th>報到</th>
                  <th>付款狀態</th>
                  @endif
                </tr>
              </thead>
              <tbody id="table_list">
                @foreach($courseapplys as $courseapply)
                  <tr>
                    <td>{{ $courseapply->submissiondate }}</td>
                    <td>{{ $courseapply->datasource }}</td>
                    <td>{{ $courseapply->name }}</td>
                    {{-- <td>{{ $courseapply->phone }}</td>
                    <td>{{ $courseapply->email }}</td> --}}
                    <td>{{ substr_replace($courseapply->phone, '***', 4, 3) }}</td>
                    <td>{{ substr_replace($courseapply->email, '***', strrpos($courseapply->email, '@')) }}</td>
                    <td>{{ $courseapply->profession }}</td>
                    <td>{{ $courseapply->course_content }}</td>
                    @if( strtotime(date('Y-m-d', strtotime($course->course_start_at))) > strtotime(date("Y-m-d")) )
                    <!-- 未過場次 -->
                    <td>
                      <button type="button" name="apply_btn" class="btn btn-sm text-white update_status" id="{{ $courseapply->id }}" value="{{ $courseapply->id_status }}">{{ $courseapply->status_name }}</button>
                    </td>
                    @elseif( strtotime(date('Y-m-d', strtotime($course->course_start_at))) <= strtotime(date("Y-m-d")) )
                    <!-- 已過場次 -->
                    <td>{{ $courseapply->status_name }}</td>
                    <td></td>
                    @endif
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- alert Start-->
      <div class="alert alert-success alert-dismissible m-3 position-fixed fixed-bottom" role="alert" id="success_alert">
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
      </div>
      <!-- alert End -->

  <!-- Content End -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script>
    // Sandy(2020/01/16)
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // 報到狀態修改 Start
    $('body').on('click','.update_status',function(){
        var apply_id = $(this).attr('id');
        var apply_status = $(this).val();
        $.ajax({
           type:'POST',
           url:'course_apply',                
          //  data:{
          //    _token:"{{csrf_token()}}",
          //  },
           data:{
             '_token':"{{ csrf_token() }}",
             apply_id:apply_id, 
             apply_status:apply_status
           },
           success:function(data){
              $("#"+data[0].id).val(data[0].id_status);
              $("#"+data[0].id).html(data[0].status_name);

              status_style(data[0].id, data[0].id_status);
              
              /** alert **/
              $("#success_alert_text").html(data[0].name + " 報名狀態修改成功");
              fade($("#success_alert"));
              // $("main").append('<div class="alert alert-success alert-dismissible fade show m-3 alert_fadeout" role="alert">'+ data[0].name +' 報名狀態修改成功<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           },
           error: function(jqXHR){
              console.log("error: "+ JSON.stringify(jqXHR)); 

              /** alert **/ 
              $("#error_alert_text").html("報名狀態修改失敗");
              fade($("#error_alert"));
              // $("main").append('<div class="alert alert-danger alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">報名狀態修改失敗<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           }
        });
    });
    // 報到狀態修改 End

    //列表搜尋start
    $("#btn_search").click(function(e){
      var search_keyword = $("#search_keyword").val();
      var course_id = $("#course_id").val();
      $.ajax({
          type : 'GET',
          url:'course_apply_search', 
          dataType: 'json',    
          data:{
            search_keyword: search_keyword,
            course_id: course_id
          },
          success:function(data){
            var res = '';
            var buttons = "";
            var d = new Date();
            var nowdate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate();
            $.each (data, function (key, value) {
              course_date = moment(value.course_start_at).format('Y/M/D');
             
              if (course_date > nowdate) {
                buttons =
                '<td>' +
                  '<button type="button" class="btn btn-sm text-white update_status" name="check_btn" id="' + value.id +'" value="' +value.id_status + '">' + value.status_name + '</button>' + 
                '</td>'
              } else if (course_date <= nowdate) {
                buttons = '<td>' + value.status_name + '</td>'
              }
              res +=
              '<tr>'+
                  '<td>' + value.submissiondate + '</td>'+
                  '<td>' + value.datasource + '</td>'+                  
                  '<td>' + value.name + '</td>'+
                  '<td>' + value.phone + '</td>'+
                  '<td>' + value.email + '</td>'+
                  '<td>' + value.profession + '</td>'+
                  '<td>' + value.course_content + '</td>'+                                    
                  buttons +
                  '<td>' + '' + '</td>'+
              '</tr>';
            });           
            $('#table_list').html(res);
            status_onload();
          },
          error: function(jqXHR){
            console.log("error: "+ JSON.stringify(jqXHR));
          }
        });
    });
    //列表搜尋end

  </script>
@endsection