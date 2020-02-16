@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '報到')

@section('content')
  <!-- Content Start -->
  <!--開始報到內容-->
  <div class="card m-3">
    <div class="card-body">
      <div class="row mb-3 align-items-center">
        <div class="col-6">
          <input type="hidden" id="course_id" value="{{ $course->id }}">
          <h5 class="mb-0">
            {{ $course->name }}&nbsp;&nbsp;
            {{ date('Y-m-d', strtotime($course->course_start_at)) }}
            ( {{ $week }} )&nbsp;&nbsp;
            {{ $course->Events }}
          </h5>
        </div>
        <div class="col-2 text-right">
          <h5 id="count_apply" class="mb-0">報名筆數 : {{ $count_apply }}</h5>
        </div>
        <div class="col-2 text-right">
          <h5 id="count_check" class="mb-0">報到筆數 : {{ $count_check }}</h5>
        </div>
        <div class="col-2 text-right">
          <a href="{{ route('course_return') }}"><button type="button" class="btn btn-primary" >本日表單</button></a>
        </div>
      </div>
      <div class="row">
        <div class="col">
          {{-- <p class="form_text">主持開場 : <input type="text" class="form_input"></p> --}}
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">主持開場</span>
            </div>
          <input type="text" class="form-control" aria-label="# input" aria-describedby="#" id="host" value="{{ $course->host }}">
          </div>
        </div>
        <div class="col">
          {{-- <p class="form_text">結束收單 : <input type="text" class="form_input"></p> --}}
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">結束收單</span>
            </div>
            <input type="text" class="form-control" aria-label="# input" aria-describedby="#" id="closeOrder" value="{{ $course->closeOrder }}">
          </div>
        </div>
        <div class="col-3">
          {{-- <p class="form_text">天氣 : <input type="text" class="form_input"></p> --}}
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">天氣</span>
            </div>
            <input type="text" class="form-control" aria-label="# input" aria-describedby="#" id="weather" value="{{ $course->weather }}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          {{-- <p class="form_text">工作人員 : <input type="text" class="form_input"></p> --}}
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">工作人員</span>
            </div>
            <input type="text" class="form-control" aria-label="# input" aria-describedby="#" id="staff" value="{{ $course->staff }}">
          </div>
        </div>
        {{-- <div class="col">
          <button type="button" class="btn btn-secondary btn-block">儲存</button>
        </div> --}}
      </div>
      {{-- <div class="row">
        <div class="col-3 mx-auto">
          <button type="button" class="btn btn-secondary btn-block">儲存</button>
        </div>
      </div> --}}
    </div>
  </div>
  <div class="card m-3">
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-4 mx-auto">
          <div class="input-group">
            {{-- <input type="text" class="form-control" placeholder="電話末三碼" id="search_keyword" max="999" maxlength="3" onkeyup="value=value.replace(/[^\d]/g,'')" /> --}}
            <input type="text" class="form-control" placeholder="姓名或電話末三碼" id="search_keyword"/>
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
            </div>
          </div>
        </div>
        <div class="col-3 text-right">
          <button type="button" class="btn btn-outline-secondary mx-1" data-toggle="modal" data-target="#presentApply">現場報名</button>
          <button type="button" class="btn btn-outline-secondary mx-1">二階報名表</button>
          {{-- <a href="{{ route('course_return') }}"><button type="button" class="btn btn-outline-secondary" >回報表單</button></a> --}}
        </div>

        <!-- 現場報名 modal -->
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
              <th scope="col">姓名</th>
              <th scope="col">聯絡電話</th>
              <th scope="col">電子郵件</th>
              <th scope="col">報到</th>
              <th scope="col" width="20%">報到備註</th>
            </tr>
          </thead>
          <tbody id="courseCheckContent">
            @foreach($coursechecks as $coursecheck)
              <tr>
                <td scope="row" class="align-middle">{{ $coursecheck->name }}</td>
                <td class="align-middle">{{ substr_replace($coursecheck->phone, '***', 4, 3) }}</td>
                <td class="align-middle">{{ substr_replace($coursecheck->email, '***', strrpos($coursecheck->email, '@')) }}</td>
                <td class="align-middle">
                  <button type="button" class="btn btn-sm text-white update_status" name="check_btn" id="{{ $coursecheck->check_id }}" value="{{ $coursecheck->check_status_val }}">{{ $coursecheck->check_status_name }}</button>
                  <div class="btn-group">
                    <button class="btn btn-sm" type="button" data-toggle="dropdown">
                      •••
                    </button>
                    <div class="dropdown-menu">
                      <button class="dropdown-item update_status" name="dropdown_check" value="{{ $coursecheck->check_id }}" type="button">報到</button>
                      <button class="dropdown-item update_status" name="dropdown_absent" value="{{ $coursecheck->check_id }}" type="button">未到</button>
                      <button class="dropdown-item update_status" name="dropdown_cancel" value="{{ $coursecheck->check_id }}" type="button">取消</button>
                    </div>
                  </div>
                </td>
                <td class="align-middle">
                  <!-- 報到備註 -->
                  <input type="text" class="form-control input-sm checkNote" id="{{ $coursecheck->check_id }}" value="{{ ($coursecheck->memo == 'null')? '':$coursecheck->memo }}">
                </td>
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

  <script>
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Sandy(2020/02/05)
    // 列表搜尋start
    $("#btn_search").click(function(e){
      var search_keyword = $("#search_keyword").val();
      var course_id = $("#course_id").val();
      $.ajax({
          type : 'GET',
          url:'course_check_search',
          dataType: 'json',
          data:{
            // '_token':"{{ csrf_token() }}",
            search_keyword: search_keyword,
            course_id: course_id
          },
          success:function(data){
            // console.log(data);
            $('#courseCheckContent').children().remove();
            var res = ``;
            $.each (data, function (key, value) {
              var phone = value.phone.replace((value.phone).substr(4,3), '***');
              var email = value.email.replace((value.email).substr(value.email.indexOf('@')), '*****');
              res +=`
              <tr>
                <td scope="row" class="align-middle">${value.name}</td>
                <td scope="row" class="align-middle">${phone}</td>
                <td scope="row" class="align-middle">${email}</td>
                <td scope="row" class="align-middle">
                  <button type="button" class="btn btn-sm text-white update_status" name="check_btn" id="${value.id}" value="${value.check_status_val}">${value.check_status_name}</button>
                  <div class="btn-group">
                    <button class="btn btn-sm" type="button" data-toggle="dropdown">•••</button>
                    <div class="dropdown-menu">
                      <button class="dropdown-item update_status" name="dropdown_check" value="${value.check_id}" type="button">報到</button>
                      <button class="dropdown-item update_status" name="dropdown_absent" value="${value.check_id}" type="button">未到</button>
                      <button class="dropdown-item update_status" name="dropdown_cancel" value="${value.check_id}" type="button">取消</button>
                    </div>
                  </div>
                </td>
                <td class="align-middle">
                  <!-- 報到備註 -->
                  <input type="text" class="form-control input-sm checkNote" id="${value.check_id}" value="${(value.memo == null)?'':value.memo}">
                </td>
              </tr>`
            });

            $('#courseCheckContent').html(res);
            status_onload();

            // 查詢後報到備註 event
            // $('.checkNote').on('blur',function() {
            //   console.log(`${$(this).attr('id')}: ${$(this).val()}`);
            // });
          },
          error: function(jqXHR){
            console.log('error: ' + JSON.stringify(jqXHR));
          }
        });
    });
    // 列表搜尋end

    // Sandy(2020/01/16)
    // 報到狀態修改 start
    $('body').on('click','.update_status',function(){
        var update_status = $(this).attr('name');
        if( update_status == 'check_btn' ){
          var check_id = $(this).attr('id');
          var check_value = $(this).val();
          $.ajax({
            type:'POST',
            url:'course_check_status',
            data:{
              check_id:check_id,
              check_value:check_value,
              update_status:update_status
            },
            success:function(data){
                // console.log(data);  

                $("#"+data[0].check_id).val(data[0].check_status_val);
                $("#"+data[0].check_id).html(data[0].check_status_name);
                
                status_style(data[0].check_id ,data[0].check_status_val);

                /** alert **/
                $("#success_alert_text").html(data[0].check_name + "報名狀態修改成功");
                fade($("#success_alert"));
            },
            error: function(jqXHR){
                console.log("error: "+ JSON.stringify(jqXHR)); 
                
                /** alert **/ 
                $("#error_alert_text").html("報名狀態修改失敗");
                fade($("#error_alert"));      
            }
          });
        }
        else{
          var check_id = this.value;
          $.ajax({
            type:'POST',
            url:'course_check_status',
            data:{
              check_id:check_id,
              update_status:update_status
            },
            success:function(data){
                // console.log(data);  
                $("#"+data[0].check_id).val(data[0].check_status_val);
                $("#"+data[0].check_id).html(data[0].check_status_name);
                
                status_style(data[0].check_id ,data[0].check_status_val);

                /** alert **/
                $("#success_alert_text").html(data[0].check_name + "報名狀態修改成功");
                fade($("#success_alert"));
            },
            error: function(jqXHR){
                console.log("error: "+ JSON.stringify(jqXHR)); 
                
                /** alert **/ 
                $("#error_alert_text").html("報名狀態修改失敗");
                fade($("#error_alert"));      
            }
          });
        }
    });
    // 報到狀態修改 End

    // 資料自動儲存 Start
    // 主持開場
    $('#host').on('blur', function() {
      // console.log(`host: ${$(this).val()}`);
      var course_id = $("#course_id").val();
      var data_val = $(this).val();
      $.ajax({
        type:'POST',
        url:'course_check_data',
        data:{
          course_id: course_id,
          data_type:'host', 
          data_val: data_val
        },
        success:function(data){
          // console.log(JSON.stringify(data));

          /** alert **/
          $("#success_alert_text").html("資料儲存成功");
          fade($("#success_alert"));
        },
        error: function(jqXHR){
          console.log(JSON.stringify(jqXHR));  

          /** alert **/ 
          $("#error_alert_text").html("資料儲存失敗");
          fade($("#error_alert"));      
        }
      });
    });

    // 結束收單
    $('#closeOrder').on('blur', function() {
      // console.log(`closeOrder: ${$(this).val()}`);
      var course_id = $("#course_id").val();
      var data_val = $(this).val();
      $.ajax({
        type:'POST',
        url:'course_check_data',
        data:{
          course_id: course_id,
          data_type:'closeOrder', 
          data_val: data_val
        },
        success:function(data){
          // console.log(JSON.stringify(data));

          /** alert **/
          $("#success_alert_text").html("資料儲存成功");
          fade($("#success_alert"));
        },
        error: function(jqXHR){
          console.log(JSON.stringify(jqXHR));  

          /** alert **/ 
          $("#error_alert_text").html("資料儲存失敗");
          fade($("#error_alert"));      
        }
      });
    });

    // 天氣
    $('#weather').on('blur', function() {
      // console.log(`weather: ${$(this).val()}`);
      var course_id = $("#course_id").val();
      var data_val = $(this).val();
      $.ajax({
        type:'POST',
        url:'course_check_data',
        data:{
          course_id: course_id,
          data_type:'weather', 
          data_val: data_val
        },
        success:function(data){
          // console.log(JSON.stringify(data));

          /** alert **/
          $("#success_alert_text").html("資料儲存成功");
          fade($("#success_alert"));
        },
        error: function(jqXHR){
          console.log(JSON.stringify(jqXHR));  

          /** alert **/ 
          $("#error_alert_text").html("資料儲存失敗");
          fade($("#error_alert"));      
        }
      });
    });

    // 工作人員
    $('#staff').on('blur', function() {
      // console.log(`staff: ${$(this).val()}`);
      var course_id = $("#course_id").val();
      var data_val = $(this).val();
      $.ajax({
        type:'POST',
        url:'course_check_data',
        data:{
          course_id: course_id,
          data_type:'staff', 
          data_val: data_val
        },
        success:function(data){
          // console.log(JSON.stringify(data));

          /** alert **/
          $("#success_alert_text").html("資料儲存成功");
          fade($("#success_alert"));
        },
        error: function(jqXHR){
          console.log(JSON.stringify(jqXHR));  

          /** alert **/ 
          $("#error_alert_text").html("資料儲存失敗");
          fade($("#error_alert"));      
        }
      });
    });

    // 查詢前報到備註 event
    // $('.checkNote').on('blur',function() {
    $('body').on('blur','.checkNote',function(){
      // console.log(`${$(this).attr('id')}: ${$(this).val()}`);
      var course_id = $("#course_id").val();
      var data_id = $(this).attr('id');
      var data_val = $(this).val();
      $.ajax({
        type:'POST',
        url:'course_check_data',
        data:{
          course_id: course_id,
          data_type:'checkNote', 
          data_id: data_id,
          data_val: data_val
        },
        success:function(data){
          // console.log(JSON.stringify(data));

          /** alert **/
          if(data == 'success'){
            $("#success_alert_text").html("資料儲存成功");
            fade($("#success_alert"));
          }
          else if(data == 'error'){
            $("#error_alert_text").html("資料儲存失敗");
            fade($("#error_alert"));              
          }
        },
        error: function(jqXHR){
          console.log(JSON.stringify(jqXHR));  

          /** alert **/ 
          $("#error_alert_text").html("資料儲存失敗");
          fade($("#error_alert"));      
        }
      });
    });
    // 資料自動儲存 End

  </script>
@endsection