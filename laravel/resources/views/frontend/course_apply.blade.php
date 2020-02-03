@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '報名名單')

@section('content')
<!-- Content Start -->
        <!--查看報名內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row">
              <div class="col align-middle">
                <input type="hidden" id="course_id" value="{{ $course->id }}">
                <h5>
                  {{ $course->name }}&nbsp;&nbsp;
                  {{ date('Y-m-d', strtotime($course->course_start_at)) }}
                  ( {{ $week }} )&nbsp;&nbsp;
                  {{ $course->Events }}
                </h5>
              </div>
              <div class="col align-middle text-right">
                <h5>報名筆數 : {{ $count }}</h5>
              </div>
              <hr/>
            </div>
          </div>
        </div>
        <div class="card m-3">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-3">
                       <div class="input-group">
                          <input type="number" class="form-control" placeholder="電話末三碼" id="search_phone" max="999">
                          <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
                          </div>
                      </div>
                    </div>
                    <div class="col-9 text-right">
                      <button class="btn btn-secondary mx-1" type="button" id="#">編輯</button>
                      <button class="btn btn-secondary mx-1" type="button" id="#">儲存</button>
                    </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-sm text-center" id="table_apply">
                    <thead>
                      <tr>
                        <th>姓名</th>
                        <th>連絡電話</th>
                        <th>電子郵件</th>
                        <th>狀態</th>
                      </tr>
                    </thead>
                    <tbody id="apply_list">
                      @foreach($courseapplys as $courseapply)
                        <tr>
                          <td>{{ $courseapply->name }}</td>
                          <td>{{ $courseapply->phone }}</td>
                          <td>{{ $courseapply->email }}</td>
                          <td>
                            <div class="dropdown">
                              <button type="button" name="apply_status" class="btn btn-sm text-white apply_btn" id="{{ $courseapply->apply_id }}" value="{{ $courseapply->apply_status_val }}">{{ $courseapply->apply_status_name }}</button>
                            </div>
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
    // Sandy(2020/01/16)
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(".apply_btn").click(function(e){
        e.preventDefault();
        var apply_id = this.id;
        var apply_status = this.value;
        $.ajax({
           type:'POST',
           url:'course_apply',                
          //  data:{
          //    _token:"{{csrf_token()}}",
          //  },
           data:{'_token':"{{ csrf_token() }}",apply_id:apply_id, apply_status:apply_status},
           success:function(data){
              $("#"+data[0].apply_id).html(data[0].apply_status_name);
              $("#"+data[0].apply_id).val(data[0].apply_status_val);
              $("main").append('<div class="alert alert-success alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">'+ data[0].apply_name +' 報名狀態修改成功<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           },
           error: function(jqXHR){
              //  alert(JSON.stringify(jqXHR));
              $("main").append('<div class="alert alert-danger alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">報名狀態修改失敗<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           }
        });
    });


    //列表搜尋start
    $("#btn_search").click(function(e){
      var search_phone = $("#search_phone").val();
      var course_id = $("#course_id").val();
      $.ajax({
          type : 'GET',
          url:'course_apply_search', 
          dataType: 'json',    
          data:{
            // '_token':"{{ csrf_token() }}",
            search_phone: search_phone,
            course_id: course_id
          },
          success:function(data){
            console.log(data);
          },
          error: function(jqXHR){
            //  alert(JSON.stringify(jqXHR));
            // $("main").append('<div class="alert alert-danger alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">報名狀態修改失敗<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          }
        });
    });
    //列表搜尋end

  </script>
@endsection