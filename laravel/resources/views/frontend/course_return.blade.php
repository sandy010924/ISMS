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
          <div class="modal fade" id="new_form" tabindex="-1" role="dialog" aria-labelledby="new_formLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="presentApplyLabel">新增資料</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-left">
                  <form action="{{ url('course_return_insert_data') }}" name="insert" method="POST" >
                    @csrf
                      <input type="hidden" name="form_event_id" id="form_event_id" value="{{ $course->id }}">
                      <div class="form-group required">
                        <label class="col-form-label" for="idate">報名日期</label>
                        {{-- <input type="text" id="idate" name="idate" class="form-control"> --}}
                        <div class="input-group date" id="idate" data-target-input="nearest">
                            <input type="text" name="idate" class="form-control datetimepicker-input" data-target="#idate" required/>
                            <div class="input-group-append" data-target="#idate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                      </div>
                      <div class="form-group required">
                        <label for="iphone" class="col-form-label">聯絡電話</label>
                        <input type="text" class="form-control" name="iphone" id="iphone" required>
                      </div>
                      <div class="form-group required">
                        <label for="iname" class="col-form-label">姓名</label>
                        <input type="text" class="form-control" name="iname" id="iname" required>
                      </div>
                      <div class="form-group">
                        <label for="isex" class="col-form-label">性別</label>
                        <div class="d-block my-2">
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="isex1" name="isex" class="custom-control-input" value="男">
                            <label class="custom-control-label" for="isex1">男</label>
                          </div>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="isex2" name="isex" class="custom-control-input" value="女">
                            <label class="custom-control-label" for="isex2">女</label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="iid" class="col-form-label">身分證字號</label>
                        <input type="text" class="form-control" name="iid" id="iid">
                      </div>
                      <div class="form-group">
                        <label for="iemail" class="col-form-label">電子郵件</label>
                        <input type="text" class="form-control" name="iemail" id="iemail">
                      </div>
                      <div class="form-group">
                        <label for="ibirthday" class="col-form-label">出生日期</label>
                        {{-- <input type="date" class="form-control" name="ibirthday" id="ibirthday"> --}}
                        <div class="input-group date" id="ibirthday" data-target-input="nearest">
                            <input type="text" name="ibirthday" class="form-control datetimepicker-input" data-target="#ibirthday"/>
                            <div class="input-group-append" data-target="#ibirthday" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="icompany" class="col-form-label">公司名稱</label>
                        <input type="text" class="form-control" name="icompany" id="icompany">
                      </div>
                      <div class="form-group">
                        <label for="iprofession" class="col-form-label">職業</label>
                        <input type="text" class="form-control" name="iprofession" id="iprofession">
                      </div>
                      <div class="form-group">
                        <label for="iaddress" class="col-form-label">聯絡地址</label>
                        <input type="text" class="form-control" name="iaddress" id="iaddress">
                      </div>
                      <div class="form-group">
                        <label for="ijoin" class="col-form-label">我想參加課程</label>
                        <div class="d-block my-2">
                          <div class="custom-control custom-radio my-1">
                            <input type="radio" id="ijoin1" name="ijoin" class="custom-control-input" value="0">
                            <label class="custom-control-label" for="ijoin1">現場最優惠價格</label>
                          </div>
                          <div class="custom-control custom-radio my-1">
                            <input type="radio" id="ijoin2" name="ijoin" class="custom-control-input" value="1">
                            <label class="custom-control-label" for="ijoin2">五日內優惠價格</label>
                          </div>
                        </div>
                      </div>
                      @foreach( $events as $key => $data )
                        <div class="form-group">
                          <label class="col-form-label" for="ievent">{{ $data['course_name'] }} 的場次</label>
                          @foreach( $data['events'] as $data_events )
                            <div class="d-block my-2">
                              <div class="custom-control custom-radio my-3">
                                <input type="radio" id="{{ $data_events['id_group'] }}" value="{{ $data_events['id_group'] }}" name="ievent" class="custom-control-input ievent">
                                <label class="custom-control-label" for="{{ $data_events['id_group'] }}">{{ $data_events['events'] }}</label>
                              </div>
                            </div>
                          @endforeach
                        </div>
                      @endforeach
                      <div class="form-group">
                        <label for="ipay_model" class="col-form-label">付款方式</label>
                        <div class="d-block my-2">
                          <div class="custom-control custom-radio my-1">
                            <input type="radio" id="ipay_model1" name="ipay_model" class="custom-control-input" value="0">
                            <label class="custom-control-label" for="ipay_model1">現金</label>
                          </div>
                          <div class="custom-control custom-radio my-1">
                            <input type="radio" id="ipay_model2" name="ipay_model" class="custom-control-input" value="1">
                            <label class="custom-control-label" for="ipay_model2">匯款</label>
                          </div>
                          <div class="custom-control custom-radio my-1">
                            <input type="radio" id="ipay_model3" name="ipay_model" class="custom-control-input" value="2">
                            <label class="custom-control-label" for="ipay_model3">刷卡：輕鬆付</label>
                          </div>
                          <div class="custom-control custom-radio my-1">
                            <input type="radio" id="ipay_model4" name="ipay_model" class="custom-control-input" value="3">
                            <label class="custom-control-label" for="ipay_model4">刷卡：一次付</label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="icash" class="col-form-label">付款金額</label>
                        <input type="number" class="form-control" name="icash" id="icash">
                      </div>
                      <div class="form-group">
                        <label for="inumber" class="col-form-label">匯款帳號/卡號後五碼 </label>
                        <input type="number" class="form-control" name="inumber" id="inumber">
                      </div>
                      <div class="form-group">
                        <label for="iinvoice" class="col-form-label">統一發票</label>
                        <div class="d-block my-2">
                          <div class="custom-control custom-radio my-1">
                            <input type="radio" id="iinvoice1" name="iinvoice" class="custom-control-input" value="0">
                            <label class="custom-control-label" for="iinvoice1">捐贈社會福利機構（由無極限國際公司另行辦理）</label>
                          </div>
                          <div class="custom-control custom-radio my-1">
                            <input type="radio" id="iinvoice2" name="iinvoice" class="custom-control-input" value="1">
                            <label class="custom-control-label" for="iinvoice2">二聯式</label>
                          </div>
                          <div class="custom-control custom-radio my-1">
                            <input type="radio" id="iinvoice3" name="iinvoice" class="custom-control-input" value="2">
                            <label class="custom-control-label" for="iinvoice3">三聯式</label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inum" class="col-form-label">統編</label>
                        <input type="number" class="form-control" name="inum" id="inum">
                      </div>
                      <div class="form-group">
                        <label for="icompanytitle" class="col-form-label">抬頭</label>
                        <input type="text" class="form-control" name="icompanytitle" id="icompanytitle">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary">確認報名</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
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
                <span class="input-group-text">現場完款金額</span>
              </div>
              <input type="number" id="money" name="money" class="form-control" aria-label="money input" aria-describedby="money input" value="{{ $course->money }}">
            </div>
          </div>
          <div class="col">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">五日內完款金額</span>
              </div>
              <input type="number" id="money_fivedays" name="money_fivedays" class="form-control" aria-label="money_fivedays input" aria-describedby="money_fivedays input" value="{{ $course->money_fivedays }}">
            </div>
          </div>
          <div class="col">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">分期付款金額</span>
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
                <button type="button" class="btn collapse-btn" data-toggle="collapse" data-target="#payment{{ $data['id'] }}" aria-expanded="false" aria-controls="payment{{ $data['id'] }}">
                <span class="fas fa-angle-right fa-lg collapse_open"></span>
                <span class="fas fa-angle-down fa-lg collapse_close"></span>
                </button>
              </td>
              <td class="align-middle">{{ $data['name'] }}</td>
              <td class="align-middle">{{ $data['phone'] }}</td>
              <td class="align-middle">
                <div class="form-group m-0">
                  <select class="custom-select border-0 bg-transparent input_width" id="status_payment{{ $data['id'] }}" name="status_payment" value="{{$data['status_payment']}}">
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
              <td class="align-middle" id="amount_paid{{ $data['id'] }}">{{ $data['amount_paid'] }}</td>
              <td class="align-middle" id="pending{{ $data['id'] }}">
                @if( $data['amount_payable'] != '')
                  {{ $data['amount_payable'] - $data['amount_paid'] }} 
                @else
                  0
                @endif
              </td>
              <td class="align-middle">
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
                <div class="collapse multi-collapse" id="payment{{ $data['id'] }}">
                  <div class="card card-body p-1">
                    <div class="table-responsive">
                      <table class="table table-striped table-sm text-center border rounded-lg mb-0 return_table" id="payment_table{{ $data['id'] }}">
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
                            <tr name="tr{{ $data['id'] }}">
                              <td class="align-middle">{{ $key_payment+1 }}</td>
                              <td class="align-middle">
                                {{-- <input type="select" class="form-control form-control-sm" value="{{ $data_payment['pay_model'] }}"> --}}
                                <select class="custom-select border-0 bg-transparent" id="pay_model{{ $data_payment['id_payment'] }}" name="pay_model" value="{{$data_payment['pay_model']}}">
                                  <option selected disabled>{{$data_payment['pay_model']}}</option>
                                  <option value="0">現金</option>
                                  <option value="1">匯款</option>
                                  <option value="2">刷卡：輕鬆付</option>
                                  <option value="3">刷卡：一次付</option>
                                </select>
                              </td>
                              <td class="align-middle">
                                <input type="number" class="form-control form-control-sm" id="cash{{ $data_payment['id_payment'] }}" name="cash" value="{{ $data_payment['cash'] }}" data-registration="{{ $data['id'] }}">                                
                              </td>
                              <td class="align-middle">
                                <input type="number" class="form-control form-control-sm" id="number{{ $data_payment['id_payment'] }}" name="number" value="{{ $data_payment['number'] }}">               
                              </td>
                              <td class="align-middle">
                                {{-- <button type="button" class="btn btn-secondary btn-sm mx-1">修改</button>
                                <button type="button" class="btn btn-success btn-sm mx-1">儲存</button> --}}
                                <button type="button" class="btn btn-danger btn-sm mx-1" onclick="btn_delete({{ $data_payment['id_payment'] }});">刪除</button>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      @if(count($data['payment']) < 3)
                        <button type="button" class="btn btn-primary btn-sm m-2 add_payment" id="add_payment{{ $data['id'] }}" data-name="{{ $data['name'] }}" data-phone="{{ $data['phone'] }}" data-toggle="modal" data-target="#add_payment">新增付款</button>
                      @endif
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
        @endslot
      @endcomponent

      <!-- 新增付款 modal -->
      <div class="modal fade" id="add_payment" tabindex="-1" role="dialog" aria-labelledby="add_paymentLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="presentApplyLabel">新增付款</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body text-left">
              {{-- <form action="{{ url('course_return_insert') }}" name="insert" method="POST" >
                @csrf --}}
                  <input type="hidden" name="id_registration" id="id_registration" value="">
                  <div class="form-group">
                    <label for="add_student">學員姓名</label>
                    <input type="text" class="form-control" name="add_student" id="add_student" value="" disabled>
                  </div>
                  <div class="form-group">
                    <label for="add_phone">聯絡電話</label>
                    <input type="text" class="form-control" name="add_phone" id="add_phone" value="" disabled>
                  </div>
                  <div class="form-group required">
                    <label for="add_paymodel" class="col-form-label">付款方式</label>
                    <select class="custom-select form-control" name="add_paymodel" id="add_paymodel" required>
                      <option value="0" selected>現金</option>
                      <option value="1">匯款</option>
                      <option value="2">刷卡：輕鬆付</option>
                      <option value="3">刷卡：一次付</option>
                    </select>
                  </div>
                  <div class="form-group required">
                    <label for="add_cash" class="col-form-label">金額</label>
                    <input type="number" class="form-control" name="add_cash" id="add_cash" required>
                  </div>
                  <div class="form-group required">
                    <label for="add_number" class="col-form-label">帳號/卡號後四碼</label>
                    <input type="number" class="form-control" name="add_number" id="add_number" required>
                  </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary" id="btn_payment">確認新增</button>
                  </div>
              {{-- </form> --}}
          </div>
        </div>
      </div>
      

    </div>
  </div>
<!-- Content End -->
<script>
  $(document).ready(function () {
    // // 新增報表 - 報名日期
    // var d = new Date();

    // var month = d.getMonth() + 1;
    // var day = d.getDate();

    // var output = d.getFullYear() + '-' +
    //     (month < 10 ? '0' : '') + month + '-' +
    //     (day < 10 ? '0' : '') + day;

    // $("#idate").val(output);

    //日期&g時間選擇器 Sandy (2020/02/27)
    var iconlist = {  time: 'fas fa-clock',
                  date: 'fas fa-calendar',
                  up: 'fas fa-arrow-up',
                  down: 'fas fa-arrow-down',
                  previous: 'fas fa-arrow-circle-left',
                  next: 'fas fa-arrow-circle-right',
                  today: 'far fa-calendar-check-o',
                  clear: 'fas fa-trash',
                  close: 'far fa-times' } 

    $('#idate').datetimepicker({ 
      defaultDate: new Date(),
      format: 'YYYY-MM-DD',
      icons: iconlist, 
    });

    $('#ibirthday').datetimepicker({ 
      format: 'YYYY-MM-DD',
      icons: iconlist, 
    });
    
  });


  /* 新增資料-聯絡電話 搜尋學員既有資料Sandy(0329) S */
    // 現場完款
    $('#iphone').on('blur', function() {
      var phone = $(this).val();
      fill_data(phone);
    });
    $('#iphone').on('keyup', function(e) {
      if (e.keyCode === 13) {
        var phone = $(this).val();
        fill_data(phone);
      }
    });

    function fill_data(phone){
      $.ajax({
        type:'GET',
        url:'course_return_fill',
        data:{
          phone:phone
        },
        success:function(data){
          // console.log(data);  

          if( data != "nodata" ){    
            $("#iname").val(data.name);
            if( data.sex == '男'){
              $("#isex1").click();
            }else{
              $("#isex2").click();
            }
            $("#iid").val(data.id_identity);
            $("#iphone").val(data.phone);
            $("#iemail").val(data.email);
            $("#ibirthday").val(data.birthday);
            $("#icompany").val(data.company);
            $("#iprofession").val(data.profession);
            $("#iaddress").val(data.address);
          }

        },
        error: function(jqXHR, textStatus, errorMessage){
            console.log("error: "+ errorMessage);    
        }
      });
    }
  /* 新增資料-聯絡電話 搜尋學員既有資料Sandy(0329) S */


  /* 資料儲存 Start */

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

    // 付款狀態
    $('body').on('change','select[name="status_payment"]',function(){
      var data_id = ($(this).attr('id')).substr(14);
      var data_type = 'status_payment';
      save_data($(this), data_type, data_id);
    });

    // 應付
    $('body').on('blur','input[name="amount_payable"]',function(){
      var data_id = ($(this).attr('id')).substr(14);
      var data_type = 'amount_payable';
      save_data($(this), data_type, data_id);
      
      //已付更新
      $('#amount_paid' + data_id).html( function(){
        return $('#payment'+ data_id + ' input[name="cash"]').toArray().reduce(function(tot, val) {
          return tot + parseInt(val.value);
        }, 0);
      });
      //待付更新
      $('#pending' + data_id).html( function(){
        return parseInt($('#amount_payable' + data_id).val() - $('#amount_paid' + data_id).html());
      });
    });
    $('body').on('keyup','input[name="amount_payable"]',function(e){
      if (e.keyCode === 13) {
        var data_id = ($(this).attr('id')).substr(14);
        var data_type = 'amount_payable';
        save_data($(this), data_type, data_id);

        //已付更新
        $('#amount_paid' + data_id).html( function(){
          return $('#payment'+ data_id + ' input[name="cash"]').toArray().reduce(function(tot, val) {
            return tot + parseInt(val.value);
          }, 0);
        });
        //待付更新
        $('#pending' + data_id).html( function(){
          return parseInt($('#amount_payable' + data_id).val() - $('#amount_paid' + data_id).html());
        });
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

    // 付款資料 - 付款方式
    $('body').on('change','select[name="pay_model"]',function(e){
      var data_id = ($(this).attr('id')).substr(9);
      var data_type = 'pay_model';
      save_data($(this), data_type, data_id);
    });

    // 付款資料 - 金額
    $('body').on('blur','input[name="cash"]',function(e){
	    e.preventDefault();
      var data_val = $(this).val();
      if( data_val == "" ){
        /** alert **/ 
        $("#error_alert_text").html("金額欄位不可空白，請輸入金額");
        fade($("#error_alert")); 
        $(this).focus();
      }else{
        var data_id = ($(this).attr('id')).substr(4);
        var data_type = 'cash';
        save_data($(this), data_type, data_id);

        var id_registration = $(this).attr('data-registration');
        //已付更新
        $('#amount_paid' + id_registration).html( function(){
          return $('#payment'+ id_registration + ' input[name="cash"]').toArray().reduce(function(tot, val) {
            return tot + parseInt(val.value);
          }, 0);
        });
        //待付更新
        $('#pending' + id_registration).html( function(){
          return parseInt($('#amount_payable' + id_registration).val() - $('#amount_paid' + id_registration).html());
        });
      }
    });
    $('body').on('keyup','input[name="cash"]',function(e){
      e.preventDefault();
      if (e.keyCode === 13) {
        var data_val = $(this).val();
        if( data_val == "" ){
          /** alert **/ 
          $("#error_alert_text").html("金額欄位不可空白，請輸入金額");
          fade($("#error_alert")); 
          $(this).focus();
        }else{
          var data_id = ($(this).attr('id')).substr(4);
          var data_type = 'cash';
          save_data($(this), data_type, data_id);

          var id_registration = $(this).attr('data-registration');
          //已付更新
          $('#amount_paid' + id_registration).html( function(){
            return $('#payment'+ id_registration + ' input[name="cash"]').toArray().reduce(function(tot, val) {
              return tot + parseInt(val.value);
            }, 0);
          });
          //待付更新
          $('#pending' + id_registration).html( function(){
            return parseInt($('#amount_payable' + id_registration).val() - $('#amount_paid' + id_registration).html());
          });
        }
      }
    });
    
    // 付款資料 - 帳戶/卡號後四碼
    $('body').on('blur','input[name="number"]',function(e){
      var data_val = $(this).val();
      if( data_val == "" ){
        /** alert **/ 
        $("#error_alert_text").html("帳戶/卡號後四碼不可空白，請輸入帳戶/卡號後四碼");
        fade($("#error_alert")); 
        $(this).focus();
      }else{
        var data_id = ($(this).attr('id')).substr(6);
        var data_type = 'number';
        save_data($(this), data_type, data_id);
      }
    });
    $('body').on('keyup','input[name="number"]',function(e){
      if (e.keyCode === 13) {
        var data_val = $(this).val();
        if( data_val == "" ){
          /** alert **/ 
          $("#error_alert_text").html("卡號後四碼不可空白");
          fade($("#error_alert")); 
          $(this).focus();
        }else{
          var data_id = ($(this).attr('id')).substr(6);
          var data_type = 'number';
          save_data($(this), data_type, data_id);
        }
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

  /* 資料儲存 End */

  /* 新增付款 Start */
  $('body').on('click', '.add_payment',function(){
    var data_id = ($(this).attr('id')).substr(11);
     $("#add_payment #id_registration").val( data_id );
     $("#add_payment #add_student").val( $(this).attr('data-name') );
     $("#add_payment #add_phone").val( $(this).attr('data-phone') );
    // var payment_len = $('tr[name="tr'+data_id+'"]').length;
    // if( payment_len < 3 ){
    //   $('#payment_table' + data_id + ' tbody').append(`
        
    //   `);
    // }
  });

  $('body').on('click', '#btn_payment',function(){
    var id_registration = $("#id_registration").val();
    var pay_model = $("#add_paymodel").val();
    var cash = $("#add_cash").val();
    var number = $("#add_number").val();
    
    var payment_len = $('tr[name="tr'+id_registration+'"]').length;

    $.ajax({
        type:'POST',
        url:'course_return_insert_payment',
        data:{
          id_registration: id_registration,
          pay_model : pay_model,
          cash: cash,
          number: number
        },
        success:function(data){
          // console.log(JSON.stringify(data));

          if( data != 'error' ){

            $('#payment_table' + id_registration + ' tbody').append(`
              <tr name="tr${ data.id_registration }">
                <td class="align-middle">${ payment_len+1 }</td>
                <td class="align-middle">
                  <select class="custom-select border-0 bg-transparent" id="pay_model${ data.id }" name="pay_model" value="${ data.pay_model }">
                    <option selected disabled>${ data.pay_model }</option>
                    <option value="0">現金</option>
                    <option value="1">匯款</option>
                    <option value="2">刷卡：輕鬆付</option>
                    <option value="3">刷卡：一次付</option>
                  </select>
                </td>
                <td class="align-middle">
                  <input type="number" class="form-control form-control-sm" id="cash${ data.id }" name="cash" value="${ data.cash }" data-registration="${ data.id_registration }">                                
                </td>
                <td class="align-middle">
                  <input type="number" class="form-control form-control-sm" id="number${ data.id }" name="number" value="${ data.number }">               
                </td>
                <td class="align-middle">
                  <button type="button" class="btn btn-danger btn-sm mx-1">刪除</button>
                </td>
              </tr>
            `);
            
            //已付更新
            $('#amount_paid' + data.id_registration).html( function(){
              return $('#payment'+ data.id_registration + ' input[name="cash"]').toArray().reduce(function(tot, val) {
                return tot + parseInt(val.value);
              }, 0);
            });
            //待付更新
            $('#pending' + data.id_registration).html( function(){
              return parseInt($('#amount_payable' + data.id_registration).val() - $('#amount_paid' + data.id_registration).html());
            });

            $('#add_payment').modal('hide');

            /** alert **/
            $("#success_alert_text").html("新增付款成功");
            fade($("#success_alert"));

          }else{
            /** alert **/ 
            $("#error_alert_text").html("新增付款失敗");
            fade($("#error_alert"));     
          }

        },
        error: function(jqXHR){
          // console.log(JSON.stringify(jqXHR));  

          /** alert **/ 
          $("#error_alert_text").html("新增付款失敗");
          fade($("#error_alert"));      
        }
      });
  });
  
  /* 新增付款 End */


  /* 刪除付款 Sandy(2020/03/22) */
  function btn_delete(id_payment){
    var msg = "是否刪除此付款資訊?";
    if (confirm(msg)==true){
      $.ajax({
          type : 'POST',
          url:'course_return_delete', 
          dataType: 'json',    
          data:{
            id_payment: id_payment,
          },
          success:function(data){
            if (data['data'] == "ok") {                           
              alert('刪除付款成功！！')
              location.reload();
            }　else {
              /** alert **/ 
              $("#error_alert_text").html("刪除付款失敗");
              fade($("#error_alert"));       
            }           
          },
          error: function(error){
            console.log(JSON.stringify(error));   

            /** alert **/ 
            $("#error_alert_text").html("刪除付款失敗");
            fade($("#error_alert"));       
          }
      });
    }else{
      return false;
    }    
  }
  /* 刪除付款 Sandy(2020/03/22) */

</script>
@endsection
