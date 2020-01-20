@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '報到')

@section('content')
<!-- Content Start -->
        <!--開始報到內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-8">
                <h5>
                  {{ $course->name }}&nbsp;&nbsp;
                  {{ date('Y-m-d', strtotime($course->course_start_at)) }}
                  ( {{ $week }} )&nbsp;&nbsp;
                  {{ $course->Events }}
                </h5>
              </div>
              <div class="col-2 text-right">
                <h5 id="count_apply">報名筆數 : {{ $count_apply }}</h5>
              </div>
              <div class="col-2 text-right">
                <h5 id="count_check">報到筆數 : {{ $count_check }}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                <p class="form_text">主持 : <input type="text" class="form_input"></p>
              </div>
              <div class="col-2">
                <p class="form_text">開收 : <input type="text" class="form_input"></p>
              </div>
              <div class="col-3">
                <p class="form_text">工作人員 : <input type="text" class="form_input"></p>
              </div>
              <div class="col-3">
                <p class="form_text">講座地點 : <input type="text" class="form_input"></p>  
              </div>
              <div class="col-2">
                <p class="form_text">天氣 : <input type="text" class="form_input"></p>
              </div>
            </div>
            <div class="row">
              <div class="col-3 mx-auto">
                <button type="button" class="btn btn-secondary  btn-block">儲存</button>
              </div>
            </div>
          </div>
        </div>
        <div class="card m-3">
            <div class="card-body">  
                <div class="row mb-3 mx-5">
                    <div class="col-4 mx-auto text-center">
                       <div class="input-group">
                          <input type="search" class="form-control" placeholder="電話末三碼" aria-describedby="btn_search">
                          <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
                          </div>
                      </div>
                    </div>
                    <div class="col-6 mx-auto text-center">
                        <button type="button" class="btn btn-outline-secondary mr-3" data-toggle="modal" data-target="#presentApply">現場報名</button>
                        <a href="{{ route('course_return') }}"><button type="button" class="btn btn-outline-secondary" >回報表單</button></a>
                    </div>
                    <div class="modal fade" id="presentApply" tabindex="-1" role="dialog" aria-labelledby="presentApplyLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="presentApplyLabel">現場報名</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form>
                                  <div class="form-group">
                                    <label for="newcheck_name" class="col-form-label">姓名</label>
                                    <input type="text" class="form-control" id="newcheck_name" required>
                                    <div class="invalid-feedback">
                                      請輸入姓名
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="newcheck_phone" class="col-form-label">連絡電話</label>
                                    <input type="text" class="form-control" id="newcheck_phone" required>
                                    <div class="invalid-feedback">
                                      請輸入電話
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="newcheck_email" class="col-form-label">電子郵件</label>
                                    <input type="text" class="form-control" id="newcheck_email" required>
                                    <div class="invalid-feedback">
                                      請輸入電話
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="newcheck_address" class="col-form-label">居住地</label>
                                    <input type="text" class="form-control" id="newcheck_address">
                                  </div>
                                  <div class="form-group">
                                    <label for="newcheck_profession" class="col-form-label">目前職業</label>
                                    <input type="text" class="form-control" id="newcheck_profession" required>
                                    <div class="invalid-feedback">
                                      請輸入電話
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="newcheck_paymodel" class="col-form-label">付款方式</label>
                                    <input type="text" class="form-control" id="newcheck_paymodel">
                                  </div>
                                  <div class="form-group">
                                    <label for="newcheck_account" class="col-form-label">帳號/卡號後五碼</label>
                                    <input type="text" class="form-control" id="newcheck_account">
                                  </div>
                                  <div class="form-group">
                                    <label for="newcheck_content" class="col-form-label">我想在講座中瞭解到的內容？</label>
                                    <input type="text" class="form-control" id="newcheck_content">
                                  </div>
                                </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-primary">確認報名</button>
                              </div>
                            </div>
                          </div>
                        </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-sm text-center">
                    <thead>
                      <tr>
                        <th>姓名</th>
                        <th>連絡電話</th>
                        <th>電子郵件</th>
                        <th>狀態</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($coursechecks as $coursecheck)
                        <tr>
                          <td>{{ $coursecheck->name }}</td>
                          <td>{{ $coursecheck->phone }}</td>
                          <td>{{ $coursecheck->email }}</td>
                          <td>
                            <button type="button" class="btn btn-sm text-white check_btn" id="{{ $coursecheck->check_id }}" value="{{ $coursecheck->check_status_val }}">{{ $coursecheck->check_status_name }}</button>
                            <div class="btn-group">
                              <button class="btn btn-sm" type="button" data-toggle="dropdown">
                                •••
                              </button>
                              <div class="dropdown-menu">
                                <button class="dropdown-item dropdown_check" value="{{ $coursecheck->check_id }}" type="button" onclick="check({{$coursecheck->check_id }})">報到</button>
                                <button class="dropdown-item dropdown_absent" value="{{ $coursecheck->check_id }}" type="button" onclick="absent({{$coursecheck->check_id }})">未到</button>
                                <button class="dropdown-item dropdown_cancel" value="{{ $coursecheck->check_id }}" type="button" onclick="cancel({{$coursecheck->check_id }})">取消</button>
                              </div>
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


    $(".check_btn").click(function(e){
        e.preventDefault();
        var check_id = this.id;
        var check_status = this.value;
        $.ajax({
           type:'POST',
           url:'course_check',     
           data:{'_token':"{{ csrf_token() }}",check_id:check_id, check_status:check_status},
           success:function(data){
            //  alert(JSON.stringify(data));
              $("#"+data[0].check_id).html(data[0].check_status_name);
              $("#"+data[0].check_id).val(data[0].check_status_val);
              $("main").append('<div class="alert alert-success alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">'+ data[0].check_name +' 報到狀態修改成功<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
              // $("#count_check").html(data[0]['count_check']);
              // $("#count_apply").html(data[0]['count_apply']);
           },
           error: function(jqXHR){
              //  alert(JSON.stringify(jqXHR));
              $("main").append('<div class="alert alert-danger alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">報到狀態修改失敗<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           }
        });
    });

    $(".dropdown_check").click(function(e){
        e.preventDefault();
        var check_id = this.value;
        $.ajax({
           type:'POST',
           url:'dropdown_check',    
           data:{'_token':"{{ csrf_token() }}",check_id:check_id},
           success:function(data){
              $("#"+data[0].check_id).html(data[0].check_status_name);
              $("#"+data[0].check_id).val(data[0].check_status_val);
              $("main").append('<div class="alert alert-success alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">'+ data[0].check_name +' 報名狀態修改成功<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           },
           error: function(jqXHR){
              //  alert(JSON.stringify(jqXHR));
              $("main").append('<div class="alert alert-danger alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">報名狀態修改失敗<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           }
        });
    });

    $(".dropdown_absent").click(function(e){
        e.preventDefault();
        var check_id = this.value;
        $.ajax({
           type:'POST',
           url:'dropdown_absent',    
           data:{'_token':"{{ csrf_token() }}",check_id:check_id},
           success:function(data){
              $("#"+data[0].check_id).html(data[0].check_status_name);
              $("#"+data[0].check_id).val(data[0].check_status_val);
              $("main").append('<div class="alert alert-success alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">'+ data[0].check_name +' 報名狀態修改成功<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           },
           error: function(jqXHR){
              //  alert(JSON.stringify(jqXHR));
              $("main").append('<div class="alert alert-danger alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">報名狀態修改失敗<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           }
        });
    });

    $(".dropdown_cancel").click(function(e){
        e.preventDefault();
        var check_id = this.value;
        $.ajax({
           type:'POST',
           url:'dropdown_cancel',    
           data:{'_token':"{{ csrf_token() }}",check_id:check_id},
           success:function(data){
              $("#"+data[0].check_id).html(data[0].check_status_name);
              $("#"+data[0].check_id).val(data[0].check_status_val);
              $("main").append('<div class="alert alert-success alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">'+ data[0].check_name +' 報名狀態修改成功<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           },
           error: function(jqXHR){
              //  alert(JSON.stringify(jqXHR));
              $("main").append('<div class="alert alert-danger alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">報名狀態修改失敗<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           }
        });
    });
  </script>
@endsection