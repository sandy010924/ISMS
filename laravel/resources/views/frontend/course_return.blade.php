@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '場次報表')

@section('content')

  <style>
    /* 日期選擇器位置調整 */
    .table-responsive{
      /* z-index: 0; */
      overflow: visible;
    }
    table td{
      position: relative;
    }
    .bootstrap-datetimepicker-widget{
      bottom: 0;
      z-index: 9999 !important;
    }
  </style>

<!-- Content Start -->
  <!--現場表單頁面內容-->
  <input type="hidden" id="id_events" value="{{ $course->id }}">
  <div class="card m-3">
    <div class="card-body">
      <div class="row mb-3">
        <div class="col align-self-center">
          <h6 class="mb-0 ">
            {{ $course->course }}&nbsp;&nbsp;
            {{ date('Y-m-d', strtotime($course->course_start_at)) }}
            ( {{ $week }} )&nbsp;
            {{ $course->name }}&nbsp;&nbsp;
            講座地點：
            {{ $course->location }}
          </h6>
          {{-- <h6>零秒成交數&nbsp;&nbsp;2019/11/20&nbsp;&nbsp;台北下午場&nbsp;&nbsp;講座地點 : 台北市金山南路一段17號5樓(博宇藝享空間)</h6> --}}
        </div>
        <div class="col-2 text-right">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new_form">新增資料</button>
          <!-- 新增資料 modal -->
          {{-- <div class="modal fade" id="new_form" tabindex="-1" role="dialog" aria-labelledby="new_formLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="presentApplyLabel">新增資料</h5>
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
          </div> --}}
        </div>
      </div>
        <div class="row">
          <div class="col-3 mb-2">
            <h6>主持開場 : {{ $course->host }}</h6>
          </div>
          <div class="col-3 mb-2">
            <h6>結束收單 : {{ $course->closeorder }}</h6>
          </div>
          <div class="col-3 mb-2">
            <h6>工作人員 : {{ $course->staff }}</h6>
          </div>
          <div class="col-3 mb-2">
            <h6>天氣 : {{ $course->weather }}</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-3 mb-2">
            <h6>該場總金額 : {{ $cash }}</h6>
          </div>
          <div class="col-3">
            <h6>完款 : {{ $count_settle }}</h6>
          </div>
          <div class="col-3">
            <h6>付訂 : {{ $count_deposit }}</h6>
          </div>
          <div class="col-3">
            <h6>留單 : {{ $count_order }}</h6>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">現場完款</span>
              </div>
              <input type="number" id="money" name="money" class="form-control" aria-label="money input" aria-describedby="money input" value="{{ $course->money }}">
            </div>
          </div>
          <div class="col">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">五日內完款</span>
              </div>
              <input type="number" id="money_fivedays" name="money_fivedays" class="form-control" aria-label="money_fivedays input" aria-describedby="money_fivedays input" value="{{ $course->money_fivedays }}">
            </div>
          </div>
          <div class="col">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">分期付款</span>
              </div>
              <input type="number" id="money_installment" name="money_installment" class="form-control" aria-label="money_installment input" aria-describedby="money_installment input" value="{{ $course->money_installment }}">
            </div>
          </div>
          <div class="col mb-2">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">該場備註</span>
              </div>
              <input type="text" id="memo" name="memo" class="form-control" aria-label="memo input" aria-describedby="memo input" value="{{ $course->memo }}">
            </div>
          </div>
          
        </div>
      </div>
  </div>

  <div class="card m-3">
    <div class="card-body">
      @component('components.datatable')
        @slot('thead')
          <tr>
            <th class="text-nowrap"></th>
            <th class="text-nowrap">學員姓名</th>
            <th class="text-nowrap">連絡電話</th>
            <th class="text-nowrap">付款狀態</th>
            <th class="text-nowrap">應付</th>
            <th class="text-nowrap">已付</th>
            <th class="text-nowrap">待付</th>
            {{-- <th class="text-nowrap">付款方式</th> --}}
            <th class="text-nowrap">付款日期</th>
            <th class="text-nowrap">服務人員</th>
            <th class="text-nowrap">備註</th>
          </tr>
        @endslot
        @slot('tbody')
          @foreach($fill as $data)
            <tr>
              <td class="align-middle">
                <button type="button" class="btn collapse-btn" data-toggle="collapse" data-target="#payment_{{ $data['id'] }}" aria-expanded="false" aria-controls="payment_{{ $data['id'] }}">
                <span class="fas fa-angle-right fa-lg collapse_open"></span>
                <span class="fas fa-angle-down fa-lg collapse_close"></span>
                </button>
              </td>
              <td class="align-middle">{{ $data['name'] }}</td>
              <td class="align-middle">{{ $data['phone'] }}</td>
              <td class="align-middle">
                <div class="form-group m-0">
                  <select class="custom-select border-0 bg-transparent input_width" id="pay_state_{{ $data['id'] }}" name="pay_state" value="{{$data['status_payment']}}">
                    <option selected disabled value="{{$data['status_payment']}}">{{$data['status_payment_name']}}
                    </option>
                    <option value="6">留單</option>
                    <option value="7">完款</option>
                    <option value="8">付訂</option>
                    <option value="9">退款</option>
                  </select>
                </div>
              </td>
              <td class="align-middle">
                <input type="number" class="form-control form-control-sm" id="amount_payable{{ $data['id'] }}" name="amount_payable" value="{{ $data['amount_payable'] }}">
              </td>
              <td class="align-middle">{{ $data['amount_paid'] }}</td>
              <td class="align-middle"></td>
              <td class="align-middle">
                {{-- <input type="text" id="pay_date{{ $data['id'] }}" name="pay_date" class="form-control form-control-sm datetimepicker-input" data-toggle="datetimepicker" data-target="#pay_date{{ $data['id'] }}" value="{{ $data['pay_date'] }}"/> --}}
                <input type="date" id="pay_date{{ $data['id'] }}" name="pay_date" class="form-control form-control-sm" value="{{ $data['pay_date'] }}"/>
              </td>
              <td class="align-middle">
                <input type="text" class="form-control form-control-sm" id="person{{ $data['id'] }}" name="person" value="{{ $data['person'] }}">
              </td>
              <td class="align-middle">
                <input type="text" class="form-control form-control-sm" id="pay_memo{{ $data['id'] }}" name="pay_memo" value="{{ $data['pay_memo'] }}">
              </td>
            </tr>
            <tr>
              <td colspan="10">
                <div class="collapse multi-collapse" id="payment_{{ $data['id'] }}">
                  <div class="card card-body p-1">
                    <div class="table-responsive">
                      <table class="table table-striped table-sm text-center border rounded-lg mb-0 return_table">
                        <thead class="thead-dark" style="font-size:14px;">
                          <tr>
                            <th class="text-nowrap"></th>
                            <th class="text-nowrap">付款方式</th>
                            <th class="text-nowrap">金額</th>
                            <th class="text-nowrap">帳戶/卡號後四碼</th>
                            <th class="text-nowrap"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data['payment'] as $key_payment => $data_payment)
                            <tr>
                              <td class="align-middle">{{ $key_payment+1 }}</td>
                              <td class="align-middle">
                                {{ $data_payment['pay_model'] }}
                              </td>
                              <td class="align-middle">
                                {{ $data_payment['cash'] }}
                              </td>
                              <td class="align-middle">
                                {{ $data_payment['number'] }}
                              </td>
                              <td class="align-middle">
                                <button type="button" class="btn btn-secondary btn-sm mx-1">修改</button>
                                <button type="button" class="btn btn-success btn-sm mx-1">儲存</button>
                                <button type="button" class="btn btn-danger btn-sm mx-1">刪除</button>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <button type="button" class="btn btn-primary btn-sm m-2">新增付款</button>
                    </div>
                  </div>
                </div>    
              </td>
            </tr>
          @endforeach
        @endslot
      @endcomponent
      
      <!-- alert Start-->
      {{-- @component('components.alert')
      @endcomponent --}}
      <!-- alert End -->

    </div>
  </div>
<!-- Content End -->
<script>
  $(document).ready(function () {
    //日期&時間選擇器 Sandy (2020/02/27)
    // var iconlist = {  time: 'fas fa-clock',
    //                   date: 'fas fa-calendar',
    //                   up: 'fas fa-arrow-up',
    //                   down: 'fas fa-arrow-down',
    //                   previous: 'fas fa-arrow-circle-left',
    //                   next: 'fas fa-arrow-circle-right',
    //                   today: 'far fa-calendar-check-o',
    //                   clear: 'fas fa-trash',
    //                   close: 'far fa-times' } 

    // $('input[name="pay_date"]').datetimepicker({ 
    //   format: 'YYYY-MM-DD',
    //   icons: iconlist, 
    //   pickerPosition: "bottom-left",
    //   // defaultDate: new Date(), 
    //   // widgetParent: 'td'
    // });


    // $("#addButton").click(function () {
    //   if( ($('.form-horizontal .control-group').length+1) > 2) {
    //     alert("Only 2 control-group allowed");
    //     return false;
    //   }
    //   var id = ($('.form-horizontal .control-group').length + 1).toString();
    //   $('.form-horizontal').append('<div class="control-group" id="control-group' + id + '"><label class="control-label" for="inputEmail' + id + '">Email' + id + '</label><div class="controls' + id + '"><input type="text" id="inputEmail' + id + '" placeholder="Email"></div></div>');
    // });

    // $("#removeButton").click(function () {
    //   if ($('.form-horizontal .control-group').length == 1) {
    //     alert("No more textbox to remove");
    //     return false;
    //   }

    //   $(".form-horizontal .control-group:last").remove();
    // });
  });

  // 資料自動儲存 Start
    // 現場完款
    $('#money').on('blur', function() {
      var data_type = 'money';
      save_data($(this), data_type);
    });
    $('#money').on('keyup', function(e) {
      if (e.keyCode === 13) {
        var data_type = 'money';
        save_data($(this), data_type);
      }
    });

    // 五日內完款
    $('#money_fivedays').on('blur', function() {
      var data_type = 'money_fivedays';
      save_data($(this), data_type);
    });
    $('#money_fivedays').on('keyup', function(e) {
      if (e.keyCode === 13) {
        var data_type = 'money_fivedays';
        save_data($(this), data_type);
      }
    });

    // 分期付款
    $('#money_installment').on('blur', function() {
      var data_type = 'money_installment';
      save_data($(this), data_type);
    });
    $('#money_installment').on('keyup', function(e) {
      if (e.keyCode === 13) {
        var data_type = 'money_installment';
        save_data($(this), data_type);
      }
    });

    // 該場備註
    $('#memo').on('blur', function() {
      var data_type = 'memo';
      save_data($(this), data_type);
    });
    $('#memo').on('keyup', function(e) {
      if (e.keyCode === 13) {
        var data_type = 'memo';
        save_data($(this), data_type);
      }
    });

    // 應付
    $('body').on('blur','input[name="amount_payable"]',function(){
      var data_id = ($(this).attr('id')).substr(14);
      var data_type = 'amount_payable';
      save_data($(this), data_type, data_id);
    });
    $('body').on('keyup','input[name="amount_payable"]',function(e){
      if (e.keyCode === 13) {
        var data_id = ($(this).attr('id')).substr(14);
        var data_type = 'amount_payable';
        save_data($(this), data_type, data_id);
      }
    });

    // 付款日期
    $('body').on('blur','input[name="pay_date"]',function(){
      var data_id = ($(this).attr('id')).substr(8);
      var data_type = 'pay_date';
      save_data($(this), data_type, data_id);
    });
    $('body').on('keyup','input[name="pay_date"]',function(e){
      if (e.keyCode === 13) {
        var data_id = ($(this).attr('id')).substr(8);
        var data_type = 'pay_date';
        save_data($(this), data_type, data_id);
      }
    });
    
    // 服務人員
    $('body').on('blur','input[name="person"]',function(){
      var data_id = ($(this).attr('id')).substr(6);
      var data_type = 'person';
      save_data($(this), data_type, data_id);
    });
    $('body').on('keyup','input[name="person"]',function(e){
      if (e.keyCode === 13) {
        var data_id = ($(this).attr('id')).substr(6);
        var data_type = 'person';
        save_data($(this), data_type, data_id);
      }
    });

    // 備註
    $('body').on('blur','input[name="pay_memo"]',function(){
      var data_id = ($(this).attr('id')).substr(8);
      var data_type = 'pay_memo';
      save_data($(this), data_type, data_id);
    });
    $('body').on('keyup','input[name="pay_memo"]',function(e){
      if (e.keyCode === 13) {
        var data_id = ($(this).attr('id')).substr(8);
        var data_type = 'pay_memo';
        save_data($(this), data_type, data_id);
      }
    });

    function save_data(data, data_type, data_id){
      var id_events = $("#id_events").val();
      var data_val = data.val();
      $.ajax({
        type:'POST',
        url:'course_return_update',
        data:{
          id_events: id_events,
          data_type : data_type,
          data_val: data_val,
          data_id: data_id
        },
        success:function(data){
          // console.log(JSON.stringify(data));

          if( data == 'success' ){
            /** alert **/
            $("#success_alert_text").html("資料儲存成功");
            fade($("#success_alert"));
          }else{
            /** alert **/ 
            $("#error_alert_text").html("資料儲存失敗");
            fade($("#error_alert"));     
          }

        },
        error: function(jqXHR){
          // console.log(JSON.stringify(jqXHR));  

          /** alert **/ 
          $("#error_alert_text").html("資料儲存失敗");
          fade($("#error_alert"));      
        }
      });
    }
    // 資料自動儲存 End
</script>
@endsection
