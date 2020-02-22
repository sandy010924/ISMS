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
          <h6 class="mb-0">
            {{ $course->name }}&nbsp;&nbsp;
            {{ date('Y-m-d', strtotime($course->course_start_at)) }}
            ( {{ $week }} )&nbsp;&nbsp;
            {{ $course->Events }}
          </h6>
        </div>
        <div class="col text-right">
          <h6 id="count_apply" class="mb-0">報名筆數 : {{ $count_apply }}</h6>
        </div>
        <div class="col text-right">
          <h6 id="count_check" class="mb-0">報到筆數 : {{ $count_check }}</h6>
        </div>
        <div class="col text-right">
          <h6 id="count_cancel" class="mb-0">取消筆數 : {{ $count_cancel }}</h6>
        </div>
        <div class="col text-right">
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
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">工作人員</span>
            </div>
            <input type="text" class="form-control" aria-label="# input" aria-describedby="#" id="staff" value="{{ $course->staff }}">
          </div>
          <label class="text-secondary px-2 py-1"><small>※ 若有多位工作人員，請以「、」做區隔。</small></label>
        </div>
      </div>
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
                <div class="modal-body text-left">
                  <form class="form" action="{{ route('course_check') }}" method="POST">
                    @csrf
                      <input type="hidden" name="form_course_id" id="form_course_id" value="{{ $course->id }}">
                      <div class="form-group required">
                        <label for="new_name" class="col-form-label">姓名</label>
                        <input type="text" class="form-control" name="new_name" id="new_name" required>
                      </div>
                      <div class="form-group required">
                        <label for="new_phone" class="col-form-label">聯絡電話</label>
                        <input type="text" class="form-control" name="new_phone" id="new_phone" required>
                        <label class="text-secondary"><small>聯繫方式</small></label>
                      </div>
                      <div class="form-group required">
                        <label for="new_email">電子郵件</label>
                        <input type="text" class="form-control" name="new_email" id="new_email">
                        <label class="text-secondary"><small>example@example.com</small></label>
                      </div>
                      <div class="form-group">
                        <label for="new_address" class="col-form-label">居住區域</label>
                        <select class="custom-select form-control" name="new_address" id="new_address">
                          <option selected disabled>請選擇居住區域</option>
                          <option>宜蘭</option>
                          <option>基隆</option>
                          <option>台北</option>
                          <option>新北</option>
                          <option>桃園</option>
                          <option>新竹</option>
                          <option>苗栗</option>
                          <option>台中</option>
                          <option>彰化</option>
                          <option>南投</option>
                          <option>雲林</option>
                          <option>嘉義</option>
                          <option>台南</option>
                          <option>高雄</option>
                          <option>屏東</option>
                          <option>台東</option>
                          <option>花蓮</option>
                        </select>
                      </div>
                      <div class="form-group required">
                        <label for="new_profession">目前職業</label>
                        <input type="text" class="form-control" name="new_profession" id="new_profession">
                        <label class="text-secondary"><small>目前的工作職稱</small></label>
                      </div>
                      <div class="form-group">
                        <label for="new_paymodel" class="col-form-label">付款方式</label>
                        <div class="custom-control custom-radio">
                          <input type="radio" class="custom-control-input" id="new_paymodel1" name="new_paymodel" value="刷卡">
                          <label class="custom-control-label" for="new_paymodel1">刷卡</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input type="radio" class="custom-control-input" id="new_paymodel2" name="new_paymodel" value="匯款">
                          <label class="custom-control-label" for="new_paymodel2">匯款</label>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="new_account" class="col-form-label">帳號/卡號後五碼</label>
                        <input type="text" class="form-control" name="new_account" id="new_account">
                      </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary">確認報名</button>
                      </div>
                  </form>
              </div>
            </div>
          </div>

          <button type="button" class="btn btn-outline-secondary mx-1" data-toggle="modal" data-target="#nextForm">二階報名表</button>
          {{-- <a href="{{ route('course_return') }}"><button type="button" class="btn btn-outline-secondary" >回報表單</button></a> --}}
          <!-- 二階報名表 modal -->
          <div class="modal fade" id="nextForm" tabindex="-1" role="dialog" aria-labelledby="nextFormLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="nextFormLabel">二階報名表</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <a href="{{ route('course_form') }}">
                    <img class="img-thumbnail" src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4e/QRcode_image.svg/1200px-QRcode_image.svg.png"/>
                  </a>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">關閉</button>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="table-responsive">
        <table class="table table-striped table-sm text-center">
          <thead>
            <tr>
              <th scope="col">編號</th>
              <th scope="col">姓名</th>
              <th scope="col">聯絡電話</th>
              <th scope="col">電子郵件</th>
              <th scope="col">報到</th>
              <th scope="col" width="20%">報到備註</th>
            </tr>
          </thead>
          <tbody id="courseCheckContent">
            {{-- @foreach($coursechecks as $key => $coursecheck)
              <tr>
                <td>{{ $key+1  }}</td>
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
            @endforeach --}}


            @foreach($coursechecks as $key => $coursecheck)
              <tr>
                <td>{{ $coursecheck['row']  }}</td>
                <td scope="row" class="align-middle">{{ $coursecheck['name'] }}</td>
                <td class="align-middle">{{ substr_replace($coursecheck['phone'], '***', 4, 3) }}</td>
                <td class="align-middle">{{ substr_replace($coursecheck['email'], '***', strrpos($coursecheck['email'], '@')) }}</td>
                <td class="align-middle">
                  <button type="button" class="btn btn-sm text-white update_status" name="check_btn" id="{{ $coursecheck['check_id'] }}" value="{{ $coursecheck['check_status_val'] }}">{{ $coursecheck['check_status_name'] }}</button>
                  <div class="btn-group">
                    <button class="btn btn-sm" type="button" data-toggle="dropdown">
                      •••
                    </button>
                    <div class="dropdown-menu">
                      <button class="dropdown-item update_status" name="dropdown_check" value="{{ $coursecheck['check_id'] }}" type="button">報到</button>
                      <button class="dropdown-item update_status" name="dropdown_absent" value="{{ $coursecheck['check_id'] }}" type="button">未到</button>
                      <button class="dropdown-item update_status" name="dropdown_cancel" value="{{ $coursecheck['check_id'] }}" type="button">取消</button>
                    </div>
                  </div>
                </td>
                <td class="align-middle">
                  <!-- 報到備註 -->
                  <input type="text" class="form-control input-sm checkNote" id="{{ $coursecheck['check_id'] }}" value="{{ ($coursecheck['memo'] == 'null')? '':$coursecheck['memo'] }}">
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
      
  <!-- 現場報名alert -->
  @if (session('status') == "報名成功")
  <div class="alert alert-success alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">
    {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @elseif (session('status') == "報名失敗")  
  <div class="alert alert-danger alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">
    {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

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
    // 輸入框 Rocky(2020/02/19)
    $('#search_keyword').on('keyup', function(e) {
      if (e.keyCode === 13) {
          $('#btn_search').click();
      }
    });

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
            var email = '';
            $.each (data, function (key, value) {
              var phone = value.phone.replace((value.phone).substr(4,3), '***');
              if (value.email != null) {
                email = value.email.replace((value.email).substr(value.email.indexOf('@')), '*****');
              }
              res +=`
              <tr>
                <td scope="row" class="align-middle">${value.name}</td>
                <td scope="row" class="align-middle">${phone}</td>
                <td scope="row" class="align-middle">${email}</td>
                <td scope="row" class="align-middle">
                  <button type="button" class="btn btn-sm text-white update_status" name="check_btn" id="${value.check_id}" value="${value.check_status_val}">${value.check_status_name}</button>
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
                
                // $("#count_cancel").html();

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