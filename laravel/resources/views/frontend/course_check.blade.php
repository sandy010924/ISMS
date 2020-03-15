@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '報到')

@section('content')
  <!-- Content Start -->
  <!--開始報到內容-->
  <input type="hidden" id="event_id" value="{{ $course->id }}">
  <input type="hidden" id="course_type" value="{{ $course->type }}">
  <div class="card m-3">
    <div class="card-body">
      <div class="row mb-3 mt-1 align-items-center">
        <div class="col-6">
          <h6 class="mb-0">
            {{ $course->course }}&nbsp;&nbsp;
            {{ date('Y-m-d', strtotime($course->course_start_at)) }}
            ( {{ $week }} )&nbsp;&nbsp;
            {{ $course->name }}
          </h6>
        </div>
        <div class="col text-right">
          <h6 class="mb-0">報名筆數 : 
            <span id="count_apply">{{ $count_apply }}</span>
          </h6>
        </div>
        <div class="col text-right">
          <h6 class="mb-0">報到筆數 : 
            <span id="count_check">{{ $count_check }}</span>
          </h6>
        </div>
        <div class="col text-right">
          <h6 class="mb-0">取消筆數 : 
            <span id="count_cancel">{{ $count_cancel }}</span>
          </h6>
        </div>
        @if( $nextLevel > 0 )
          <div class="col text-right">
            <a href="{{ route('course_return', ['id' => $course->id]) }}"><button type="button" class="btn btn-primary" >場次報表</button></a>
          </div>
        @endif
      </div>
      <div class="row">
        <div class="col">
          {{-- <p class="form_text">主持開場 : <input type="text" class="form_input"></p> --}}
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">主持開場</span>
            </div>
          <input type="text" class="form-control" aria-label="host input" aria-describedby="host" id="host" value="{{ $course->host }}">
          </div>
        </div>
        <div class="col">
          {{-- <p class="form_text">結束收單 : <input type="text" class="form_input"></p> --}}
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">結束收單</span>
            </div>
            <input type="text" class="form-control" aria-label="closeorder input" aria-describedby="closeorder" id="closeorder" value="{{ $course->closeorder }}">
          </div>
        </div>
        <div class="col-3">
          {{-- <p class="form_text">天氣 : <input type="text" class="form_input"></p> --}}
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">天氣</span>
            </div>
            <input type="text" class="form-control" aria-label="weather input" aria-describedby="weather" id="weather" value="{{ $course->weather }}">
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
            <input type="text" class="form-control" aria-label="staff input" aria-describedby="staff" id="staff" value="{{ $course->staff }}">
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
            <input type="search" class="form-control" placeholder="姓名或電話末三碼" id="search_keyword"/>
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
            </div>
          </div>
        </div>
        <div class="col-3 text-right">
          @if( $course->type == 1 )
            <button type="button" class="btn btn-outline-secondary mx-1" data-toggle="modal" data-target="#presentApply">現場報名</button>
          @Endif
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
                  <form action="{{ url('course_check_insert') }}" name="insert" method="POST" >
                    @csrf
                      <input type="hidden" name="form_event_id" id="form_event_id" value="{{ $course->id }}">
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
          @if( $nextLevel > 0 )
            <button type="button" class="btn btn-outline-secondary mx-1" data-toggle="modal" data-target="#nextForm">下階報名表</button>
            {{-- <a href="{{ route('course_return') }}"><button type="button" class="btn btn-outline-secondary" >回報表單</button></a> --}}
            <!-- 二階報名表 modal -->
            <div class="modal fade" id="nextForm" tabindex="-1" role="dialog" aria-labelledby="nextFormLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="nextFormLabel">下階報名表</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <a href="{{ route('course_form',['source_course'=>$course->id_course, 'source_events'=>$course->id]) }}">
                      <img class="img-thumbnail" src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4e/QRcode_image.svg/1200px-QRcode_image.svg.png"/>
                    </a>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">關閉</button>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
      @component('components.datatable')
        @slot('thead')
          <tr>
            <th>編號</th>
            <th>姓名</th>
            <th>聯絡電話</th>
            <th>電子郵件</th>
            <th>報到</th>
            <th width="20%">報到備註</th>
          </tr>
        @endslot
        @slot('tbody')
          @foreach($coursechecks as $key => $coursecheck)
            <tr>
              <td class="align-middle">{{ $coursecheck['row']  }}</td>
              <td scope="row" class="align-middle" name="search_name">{{ $coursecheck['name'] }}</td>
              <td class="align-middle" name="search_phone">{{ substr_replace($coursecheck['phone'], '***', 4, 3) }}</td>
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
        @endslot
      @endcomponent
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
    var table;
    //針對姓名與電話末三碼搜尋 Sandy(2020/02/26)
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
          var keyword = $('#search_keyword').val();
          var tname = data[1]; 
          var tphone = data[2].substr(7,3); 
          
          if ( isNaN( keyword ) || tname.includes(keyword) || tphone.includes(keyword) ){
            return true;
          }
          return false;
        }
    );

    $("document").ready(function(){
      // Sandy (2020/02/26)
      table = $('#table_list').DataTable({
          "dom": '<l<t>p>',
          "ordering": false,
          drawCallback: function(){
            //換頁或切換每頁筆數按鈕觸發報到狀態樣式
            $('.paginate_button, .dataTables_length', this.api().table().container())          .on('click', function(){
                status_onload();
            });       
          }
      });
    });

    // 輸入框 Rocky(2020/02/19)
    $('#search_keyword').on('keyup', function(e) {
      if (e.keyCode === 13) {
          $('#btn_search').click();
      }
    });
    
    $("#btn_search").click(function(){
      table.search($('#search_keyword').val()).draw();
      status_onload();
    });

    // Sandy(2020/01/16)
    // 報到狀態修改 start
    $('body').on('click','.update_status',function(){
        var update_status = $(this).attr('name');
        var course_type = $("#course_type").val();
        if( update_status == 'check_btn' ){
          var check_id = $(this).attr('id');
          var check_value = $(this).val();
          $.ajax({
            type:'POST',
            url:'course_check_status',
            data:{
              check_id:check_id,
              course_type:course_type,
              check_value:check_value,
              update_status:update_status
            },
            success:function(data){
                // console.log(data);  
                
                $("#"+data["list"].check_id).val(data["list"].check_status_val);
                $("#"+data["list"].check_id).html(data["list"].check_status_name);
                
                $("#count_check").html(data.count_check);
                $("#count_cancel").html(data.count_cancel);

                status_style(data["list"].check_id ,data["list"].check_status_val);

                /** alert **/
                $("#success_alert_text").html(data["list"].check_name + "報名狀態修改成功");
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
              course_type:course_type,
              update_status:update_status
            },
            success:function(data){
                // console.log(data);  

                $("#"+data["list"].check_id).val(data["list"].check_status_val);
                $("#"+data["list"].check_id).html(data["list"].check_status_name);
                
                $("#count_check").html(data.count_check);
                $("#count_cancel").html(data.count_cancel);

                status_style(data["list"].check_id ,data["list"].check_status_val);

                /** alert **/
                $("#success_alert_text").html(data["list"].check_name + "報名狀態修改成功");
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
      var data_type = 'host';
      save_data($(this), data_type);
    });
    $('#host').on('keyup', function(e) {
      if (e.keyCode === 13) {
        var data_type = 'host';
        save_data($(this), data_type);
      }
    });

    // 結束收單
    $('#closeorder').on('blur', function() {
      var data_type = 'closeorder';
      save_data($(this), data_type);
    });
    $('#closeorder').on('keyup', function(e) {
      if (e.keyCode === 13) {
        var data_type = 'closeorder';
        save_data($(this), data_type);
      }
    });

    // 天氣
    $('#weather').on('blur', function() {
      var data_type = 'weather';
      save_data($(this), data_type);
    });
    $('#weather').on('keyup', function(e) {
      if (e.keyCode === 13) {
        var data_type = 'weather';
        save_data($(this), data_type);
      }
    });

    // 工作人員
    $('#staff').on('blur', function() {
      var data_type = 'staff';
      save_data($(this), data_type);
    });
    $('#staff').on('keyup', function(e) {
      if (e.keyCode === 13) {
        var data_type = 'staff';
        save_data($(this), data_type);
      }
    });

    // 查詢前報到備註 event
    $('body').on('blur','.checkNote',function(){
      var data_id = $(this).attr('id');
      var data_type = 'checkNote';
      save_data($(this), data_type, data_id);
    });
    $('body').on('keyup','.checkNote',function(e){
      if (e.keyCode === 13) {
        var data_id = $(this).attr('id');
        var data_type = 'checkNote';
        save_data($(this), data_type, data_id);
      }
    });

    function save_data(data, data_type, data_id){
      var event_id = $("#event_id").val();
      var course_type = $("#course_type").val();
      var data_val = data.val();
      $.ajax({
        type:'POST',
        url:'course_check_data',
        data:{
          event_id: event_id,
          course_type: course_type,
          data_type: data_type, 
          data_val: data_val,
          data_id: data_id
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
    }
    // 資料自動儲存 End

  </script>
@endsection