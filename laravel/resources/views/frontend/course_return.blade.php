@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '場次報表')

@section('content')
<link href="{{ asset('css/bootstrap-tagsinput.css') }}" rel="stylesheet">
<style>
  /* 日期選擇器位置調整 */
  .table-responsive {
    /* z-index: 0; */
    overflow: visible;
  }

  table td {
    position: relative;
  }

  .bootstrap-datetimepicker-widget {
    bottom: 0;
    z-index: 9999 !important;
  }


  input:read-only {
    background-color: #e0e0e0 !important;
  }

  .show_datetime .bootstrap-datetimepicker-widget {
    position: relative;
    z-index: 1000;
    top: 0 !important;
  }

  .show_select select {
    width: 400px;
    text-align: center;
  }

  .show_select select .lt {
    text-align: center;
  }

  .btn_tableName {
    cursor: pointer;
  }
</style>

<!-- Content Start -->
<!--現場表單頁面內容-->
<input type="hidden" id="id_events" value="{{ $course->id }}">
<div class="card m-3">
  <!-- 權限 Rocky(2020/05/10) -->
  <input type="hidden" id="auth_role" value="{{ Auth::user()}}" />
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
      <div class="col text-right">
        <a role="button" class="btn btn-outline-secondary mx-2" href="{{ route('course_list_chart', ['id'=> $course->id ]) }}">場次數據圖表</a>
        <button type="button" class="btn btn-primary mx-2" data-toggle="modal" data-target="#new_form">新增資料</button>
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
                <form action="{{ url('course_return_insert_data') }}" name="insert" method="POST">
                  @csrf
                  <input type="hidden" name="form_event_id" id="form_event_id" value="{{ $course->id }}">
                  <div class="form-group required">
                    <label class="col-form-label" for="idate"><strong>報名日期</strong></label>
                    {{-- <input type="text" id="idate" name="idate" class="form-control"> --}}
                    <div class="input-group date" id="idate" data-target-input="nearest">
                      <input type="text" name="idate" class="form-control datetimepicker-input" data-target="#idate" data-toggle="datetimepicker" autocomplete="off" required />
                      {{-- <div class="input-group-append" data-target="#idate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div> --}}
                    </div>
                    {{-- <input type="text" class="form-control" id="idate" name="idate" data-provide="datepicker" autocomplete="off"> --}}
                  </div>
                  <div class="form-group required">
                    <label for="iphone" class="col-form-label"><strong>聯絡電話</strong></label>
                    <input type="text" class="form-control" name="iphone" id="iphone" required>
                  </div>
                  <div class="form-group required">
                    <label for="iname" class="col-form-label"><strong>姓名</strong></label>
                    <input type="text" class="form-control" name="iname" id="iname" required>
                  </div>
                  <div class="form-group">
                    <label for="isex" class="col-form-label"><strong>性別</strong></label>
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
                    <label for="iid" class="col-form-label"><strong>身分證字號</strong></label>
                    <input type="text" class="form-control" name="iid" id="iid">
                  </div>
                  <div class="form-group">
                    <label for="iemail" class="col-form-label"><strong>電子郵件</strong></label>
                    <input type="text" class="form-control" name="iemail" id="iemail">
                  </div>
                  <div class="form-group">
                    <label for="ibirthday" class="col-form-label"><strong>出生日期</strong></label>
                    {{-- <input type="date" class="form-control" name="ibirthday" id="ibirthday"> --}}
                    {{-- <div class="input-group date" id="ibirthday" data-target-input="nearest">
                            <input type="text" name="ibirthday" class="form-control datetimepicker-input" data-target="#ibirthday"/>
                            <div class="input-group-append" data-target="#ibirthday" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div> --}}
                    <input type="text" class="form-control" id="ibirthday" name="ibirthday" data-provide="datepicker" autocomplete="off">
                    <label class="text-secondary px-2 py-1"><small>(民國年-月-日)</small></label>
                  </div>
                  <div class="form-group">
                    <label for="icompany" class="col-form-label"><strong>公司名稱</strong></label>
                    <input type="text" class="form-control" name="icompany" id="icompany">
                  </div>
                  <div class="form-group">
                    <label for="iprofession" class="col-form-label"><strong>職業</strong></label>
                    <input type="text" class="form-control" name="iprofession" id="iprofession">
                  </div>
                  <div class="form-group">
                    <label for="iaddress" class="col-form-label"><strong>聯絡地址</strong></label>
                    <input type="text" class="form-control" name="iaddress" id="iaddress">
                  </div>
                  <div class="form-group">
                    <label for="ijoin" class="col-form-label"><strong>我想參加課程</strong></label>
                    <div class="d-block my-2">
                      <div class="custom-control custom-radio my-1">
                        <input type="radio" id="ijoin1" name="ijoin" class="custom-control-input" value="0">
                        <label class="custom-control-label" for="ijoin1">現場最優惠價格</label>
                      </div>
                      <div class="custom-control custom-radio my-1">
                        <input type="radio" id="ijoin2" name="ijoin" class="custom-control-input" value="1">
                        <label class="custom-control-label" for="ijoin2">五日內優惠價格</label>
                      </div>
                      <div class="custom-control custom-radio my-1">
                        <input type="radio" id="ijoin3" name="ijoin" class="custom-control-input" value="2">
                        <label class="custom-control-label" for="ijoin3">分期優惠價格</label>
                      </div>
                    </div>
                  </div>
                  <input type="hidden" id="events_len" name="events_len" value="{{ count($events) }}">
                  @foreach( $events as $key => $data )
                  <div class="form-group">
                    <label class="col-form-label" for="ievent"><strong>{{ $data['course_name'] }} 的場次</strong></label>
                    @foreach( $data['events'] as $data_events )
                    <div class="d-block my-2">
                      <div class="custom-control custom-radio my-3">
                        <input type="radio" id="{{ $data_events['id_group'] }}" value="{{ $data_events['id_group'] }}" name="ievent{{ $key }}" class="custom-control-input ievent">
                        <label class="custom-control-label" for="{{ $data_events['id_group'] }}">{{ $data_events['events'] }}</label>
                      </div>
                    </div>
                    @endforeach
                    <div class="d-block my-2">
                      <div class="custom-control custom-radio my-3">
                        <input type="radio" id="other{{ $key }}" value="other_val{{ $key }}" name="ievent{{ $key }}" class="custom-control-input ievent">
                        <input type="hidden" id="other_val{{ $key }}" name="other_val{{ $key }}" value="{{ $data['id_course'] }}">
                        <label class="custom-control-label" for="other{{ $key }}">我要選擇其他場次</label>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  <div class="form-group">
                    <label for="ipay_model" class="col-form-label"><strong>付款方式</strong></label>
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
                    <label for="ipayable" class="col-form-label"><strong>應付金額</strong></label>
                    <input type="number" class="form-control" name="ipayable" id="ipayable">
                  </div>
                  <div class="form-group">
                    <label for="icash" class="col-form-label"><strong>付款金額</strong></label>
                    <input type="number" class="form-control" name="icash" id="icash">
                  </div>
                  <div class="form-group">
                    <label for="ipaydate" class="col-form-label"><strong>付款日期</strong></label>
                    <input type="text" id="ipaydate" name="ipaydate" class="form-control form-control-sm" data-target="#ipaydate" data-toggle="datetimepicker" autocomplete="off" />
                  </div>
                  <div class="form-group">
                    <label for="inumber" class="col-form-label"><strong>匯款帳號/卡號後五碼</strong></label>
                    <input type="number" class="form-control" name="inumber" id="inumber">
                  </div>
                  <div class="form-group">
                    <label for="iinvoice" class="col-form-label"><strong>統一發票</strong></label>
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
                    <label for="inum" class="col-form-label"><strong>統編</strong></label>
                    <input type="number" class="form-control" name="inum" id="inum">
                  </div>
                  <div class="form-group">
                    <label for="icompanytitle" class="col-form-label"><strong>抬頭</strong></label>
                    <input type="text" class="form-control" name="icompanytitle" id="icompanytitle">
                  </div>
                  <div class="form-group">
                    <label for="add_status" class="col-form-label">付款狀態</label>
                    <select class="custom-select" id="istatus" name="istatus">
                      <option value="6">留單</option>
                      <option value="7">完款</option>
                      <option value="8">付訂</option>
                      <option value="9">退款</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="iperson" class="col-form-label"><strong>服務人員</strong></label>
                    <input type="text" class="form-control" name="iperson" id="iperson">
                  </div>
                  <div class="form-group">
                    <label for="ipaymemo" class="col-form-label"><strong>備註</strong></label>
                    <input type="text" class="form-control" name="ipaymemo" id="ipaymemo">
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
        <h6>該場總金額 :
          <span id="cash">{{ $cash }}</span>
        </h6>
      </div>
      <div class="col-3">
        <h6>完款 :
          <span id="count_settle">{{ $count_settle }}</span>
        </h6>
      </div>
      <div class="col-3">
        <h6>付訂 :
          <span id="count_deposit">{{ $count_deposit }}</span>
        </h6>
      </div>
      <div class="col-3">
        <h6>留單 :
          <span id="count_order">{{ $count_order }}</span>
        </h6>
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
    </div>
    <div class="row">
      <div class="col mb-2">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">該場備註</span>
          </div>
          <textarea id="memo" name="memo" class="form-control" aria-label="memo input" aria-describedby="memo input">{{ $course->memo }}</textarea>
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
      <th class="text-nowrap"></th>
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
      {{-- <td class="align-middle" data-toggle="modal" onclick="course_data({{ $data['id_student'] }});">{{ $data['name'] }}</td> --}}
      <td class="align-middle">
        {{-- <a class="contact" data-id="{{ $data['id_student'] }}" data-toggle="modal" data-target="#contact">{{ $data['name'] }}</a> --}}
        <a class="btn_tableName" data-toggle="modal" onclick="course_data({{ $data['id_student'] }});">{{ $data['name'] }}</a>
      </td>
      <td class="align-middle">{{ $data['phone'] }}</td>
      <td class="align-middle">
        <div class="form-group m-0">
          <select class="custom-select border-0 bg-transparent input_width" id="status_payment{{ $data['id'] }}" name="status_payment" value="{{$data['status_payment']}}" data-orgvalue="{{$data['status_payment']}}">
            {{-- <option selected disabled value="{{$data['status_payment']}}">{{$data['status_payment_name']}}
            </option>
            <option value="6">留單</option>
            <option value="7">完款</option>
            <option value="8">付訂</option>
            <option value="9">退款</option> --}}
            @if($data['status_payment'] == 6)
            <option value="6" selected>留單</option>
            <option value="7">完款</option>
            <option value="8">付訂</option>
            <option value="9">退款</option>
            @elseif($data['status_payment'] == 7)
            <option value="6">留單</option>
            <option value="7" selected>完款</option>
            <option value="8">付訂</option>
            <option value="9">退款</option>
            @elseif($data['status_payment'] == 8)
            <option value="6">留單</option>
            <option value="7">完款</option>
            <option value="8" selected>付訂</option>
            <option value="9">退款</option>
            @elseif($data['status_payment'] == 9)
            <option value="6">留單</option>
            <option value="7">完款</option>
            <option value="8">付訂</option>
            <option value="9" selected>退款</option>
            @endif
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
        {{-- <input type="date" id="pay_date{{ $data['id'] }}" name="pay_date" class="form-control form-control-sm" value="{{ $data['pay_date'] }}"/> --}}
        {{-- <div class="input-group date" data-target-input="nearest"> --}}
        <input type="text" id="pay_date{{ $data['id'] }}" name="pay_date{{ $data['id'] }}" class="form-control form-control-sm pay_date" data-target="#pay_date{{ $data['id'] }}" data-toggle="datetimepicker" autocomplete="off" value="{{ $data['pay_date'] }}" />
        {{-- </div> --}}
      </td>
      <td class="align-middle">
        <input type="text" class="form-control form-control-sm" id="person{{ $data['id'] }}" name="person" value="{{ $data['person'] }}">
      </td>
      <td class="align-middle">
        <input type="text" class="form-control form-control-sm" id="pay_memo{{ $data['id'] }}" name="pay_memo" value="{{ $data['pay_memo'] }}">
      </td>
      <td class="align-middle">
        <a role="button" class="btn btn-secondary btn-sm text-white mr-1 edit_data" data-id="{{ $data['id'] }}" data-phone="{{ $data['phone'] }}" data-toggle="modal" data-target="#edit_form">編輯</a>
        <a role="button" class="btn btn-danger btn-sm text-white" onclick="btn_delete_data({{ $data['id'] }});">刪除</a>
      </td>
    </tr>
    <tr>
      <td colspan="11">
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
                      <button type="button" class="btn btn-danger btn-sm mx-1" onclick="btn_delete_payment({{ $data_payment['id_payment'] }});">刪除</button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              @if(count($data['payment']) < 3) <button type="button" class="btn btn-primary btn-sm m-2 add_payment" id="add_payment{{ $data['id'] }}" data-name="{{ $data['name'] }}" data-phone="{{ $data['phone'] }}" data-toggle="modal" data-target="#add_payment">新增付款</button>
                @endif
            </div>
          </div>
        </div>
      </td>
    </tr>
    @endforeach
    @endslot
    @endcomponent

    <!-- 編輯資料 modal -->
    <div class="modal fade" id="edit_form" tabindex="-1" role="dialog" aria-labelledby="edit_formLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">編輯資料</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-left">
            <form action="{{ url('course_return_edit_data') }}" method="POST">
              @csrf
              <input type="hidden" id="edit_idevents" name="edit_idevents" value="">
              <input type="hidden" id="edit_id" name="edit_id" value="">
              <div class="form-group required">
                <label class="col-form-label" for="edit_date"><strong>報名日期</strong></label>
                <div class="input-group date" data-target-input="nearest">
                  <input type="text" id="edit_date" name="edit_date" class="form-control datetimepicker-input edit_input" data-target="#edit_date" autocomplete="off" data-toggle="datetimepicker" required />
                  {{-- <div class="input-group-append" data-target="#edit_date" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div> --}}
                </div>
              </div>
              <div class="form-group required">
                <label for="edit_phone" class="col-form-label"><strong>聯絡電話</strong></label>
                <input type="text" class="form-control edit_input" name="edit_phone" id="edit_phone" readonly required>
              </div>
              <div class="form-group required">
                <label for="edit_name" class="col-form-label"><strong>姓名</strong></label>
                <input type="text" class="form-control edit_input" name="edit_name" id="edit_name" required>
              </div>
              <div class="form-group">
                <label for="edit_sex" class="col-form-label edit_input"><strong>性別</strong></label>
                <div class="d-block my-2">
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="edit_sex1" name="edit_sex" class="custom-control-input edit_input" value="男">
                    <label class="custom-control-label" for="edit_sex1">男</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="edit_sex2" name="edit_sex" class="custom-control-input edit_input" value="女">
                    <label class="custom-control-label" for="edit_sex2">女</label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="edit_identity" class="col-form-label"><strong>身分證字號</strong></label>
                <input type="text" class="form-control edit_input" name="edit_identity" id="edit_identity">
              </div>
              <div class="form-group">
                <label for="edit_email" class="col-form-label"><strong>電子郵件</strong></label>
                <input type="text" class="form-control edit_input" name="edit_email" id="edit_email">
              </div>
              <div class="form-group">
                <label for="edit_birthday" class="col-form-label"><strong>出生日期</strong></label>
                <input type="text" class="form-control edit_input" id="edit_birthday" name="edit_birthday" data-provide="datepicker" autocomplete="off">
                <label class="text-secondary px-2 py-1"><small>(民國年-月-日)</small></label>
              </div>
              <div class="form-group">
                <label for="edit_company" class="col-form-label"><strong>公司名稱</strong></label>
                <input type="text" class="form-control edit_input" name="edit_company" id="edit_company">
              </div>
              <div class="form-group">
                <label for="edit_profession" class="col-form-label"><strong>職業</strong></label>
                <input type="text" class="form-control edit_input" name="edit_profession" id="edit_profession">
              </div>
              <div class="form-group">
                <label for="edit_address" class="col-form-label"><strong>聯絡地址</strong></label>
                <input type="text" class="form-control edit_input" name="edit_address" id="edit_address">
              </div>
              <div class="form-group">
                <label for="1" class="col-form-label"><strong>我想參加課程</strong></label>
                <div class="d-block my-2">
                  <div class="custom-control custom-radio my-1">
                    <input type="radio" id="edit_join1" name="edit_join" class="custom-control-input edit_input" value="0">
                    <label class="custom-control-label" for="edit_join1">現場最優惠價格</label>
                  </div>
                  <div class="custom-control custom-radio my-1">
                    <input type="radio" id="edit_join2" name="edit_join" class="custom-control-input edit_input" value="1">
                    <label class="custom-control-label" for="edit_join2">五日內優惠價格</label>
                  </div>
                  <div class="custom-control custom-radio my-1">
                    <input type="radio" id="edit_join3" name="edit_join" class="custom-control-input edit_input" value="2">
                    <label class="custom-control-label" for="edit_join3">分期優惠價格</label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="edit_events" class="col-form-label edit_input"><strong>報名場次</strong></label>
                <a class="mx-2" data-toggle="collapse" href="#edit_collapse" role="button" aria-expanded="false" aria-controls="edit_collapse">
                  編輯場次
                </a>
                <p name="edit_events" id="edit_events"></p>
              </div>
              <div class="collapse bg-light p-3 border" id="edit_collapse">
                <input type="hidden" id="edit_collapse_val" name="edit_collapse_val" value="0">
                @foreach( $events as $key => $data )
                <div class="form-group">
                  {{-- <label for="edit_events" class="col-form-label edit_input"><strong>報名場次</strong></label><br/> --}}
                  <label class="col-form-label" for="edit_event"><strong>{{ $data['course_name'] }} 的場次</strong></label>
                  @foreach( $data['events'] as $data_events )
                  <div class="d-block my-2">
                    <div class="custom-control custom-radio my-3">
                      <input type="radio" id="edit_events{{ $data_events['id_group'] }}" value="edit_events{{ $data_events['id_group'] }}" name="edit_events" class="custom-control-input">
                      <label class="custom-control-label" for="edit_events{{ $data_events['id_group'] }}">{{ $data_events['events'] }}</label>
                    </div>
                  </div>
                  @endforeach
                  <div class="d-block my-2">
                    <div class="custom-control custom-radio my-3">
                      <input type="radio" id="edit_other{{ $data['id_course'] }}" value="edit_other{{ $data['id_course'] }}" name="edit_events" class="custom-control-input">
                      {{-- <input type="hidden" id="other_val{{ $key }}" name="other_val{{ $key }}" value="{{ $data['id_course'] }}"> --}}
                      <label class="custom-control-label" for="edit_other{{ $data['id_course'] }}">我要選擇其他場次</label>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
              {{-- <div class="form-group">
                    <label for="edit_pay_model" class="col-form-label"><strong>付款方式</strong></label>
                    <div class="d-block my-2">
                      <div class="custom-control custom-radio my-1">
                        <input type="radio" id="edit_pay_model1" name="edit_pay_model" class="custom-control-input" value="0">
                        <label class="custom-control-label" for="epay_model1">現金</label>
                      </div>
                      <div class="custom-control custom-radio my-1">
                        <input type="radio" id="edit_pay_model2" name="epay_model" class="custom-control-input" value="1">
                        <label class="custom-control-label" for="epay_model2">匯款</label>
                      </div>
                      <div class="custom-control custom-radio my-1">
                        <input type="radio" id="edit_pay_model3" name="edit_pay_model" class="custom-control-input" value="2">
                        <label class="custom-control-label" for="edit_pay_model3">刷卡：輕鬆付</label>
                      </div>
                      <div class="custom-control custom-radio my-1">
                        <input type="radio" id="edit_pay_model4" name="edit_pay_model" class="custom-control-input" value="3">
                        <label class="custom-control-label" for="edit_pay_model4">刷卡：一次付</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="edit_cash" class="col-form-label"><strong>付款金額</strong></label>
                    <input type="number" class="form-control" name="edit_cash" id="edit_cash">
                  </div>
                  <div class="form-group">
                    <label for="edit_number" class="col-form-label"><strong>匯款帳號/卡號後五碼</strong></label>
                    <input type="number" class="form-control" name="edit_number" id="edit_number">
                  </div> --}}
              <div class="form-group">
                <label for="edit_invoice" class="col-form-label"><strong>統一發票</strong></label>
                <div class="d-block my-2">
                  <div class="custom-control custom-radio my-1">
                    <input type="radio" id="edit_invoice1" name="edit_invoice" class="custom-control-input edit_input" value="0">
                    <label class="custom-control-label" for="edit_invoice1">捐贈社會福利機構（由無極限國際公司另行辦理）</label>
                  </div>
                  <div class="custom-control custom-radio my-1">
                    <input type="radio" id="edit_invoice2" name="edit_invoice" class="custom-control-input edit_input" value="1">
                    <label class="custom-control-label" for="edit_invoice2">二聯式</label>
                  </div>
                  <div class="custom-control custom-radio my-1">
                    <input type="radio" id="edit_invoice3" name="edit_invoice" class="custom-control-input edit_input" value="2">
                    <label class="custom-control-label" for="edit_invoice3">三聯式</label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="edit_num" class="col-form-label"><strong>統編</strong></label>
                <input type="number" class="form-control edit_input" name="edit_num" id="edit_num">
              </div>
              <div class="form-group">
                <label for="edit_companytitle" class="col-form-label"><strong>抬頭</strong></label>
                <input type="text" class="form-control edit_input" name="edit_companytitle" id="edit_companytitle">
              </div>
              {{-- <div class="form-group">
                    <label for="edit_dit_status" class="col-form-label">付款狀態</label>
                    <select class="custom-select" id="edit_status" name="edit_status">
                        <option value="6">留單</option>
                        <option value="7">完款</option>
                        <option value="8">付訂</option>
                        <option value="9">退款</option>
                    </select>
                  </div> --}}
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary">確認修改</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


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
            <div class="form-group">
              <label for="add_number" class="col-form-label">帳號/卡號後四碼</label>
              <input type="number" class="form-control" name="add_number" id="add_number">
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

    <!-- 完整內容 - S -->
    <div class="modal fade bd-example-modal-xl text-left" id="student_information" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content p-3">
          <div class="row">
            <div class="pt-2 pl-3">
              <h3>完整內容</h3>
            </div>
            <div class="col-12 pt-5">
              <div class="row">
                <div class="col-4">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">學員姓名</span>
                    </div>
                    <input type="text" id="student_name" class="form-control bg-white basic-inf col-sm-10 auth_readonly">
                  </div>
                </div>
                <div class="col-4">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">E-mail</span>
                    </div>
                    <input type="text" id="student_email" class="form-control bg-white basic-inf col-sm-8 auth_readonly">
                  </div>
                </div>
                <div class="col-4">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">電話</span>
                    </div>
                    <input id="student_phone" type="text" class="form-control bg-white basic-inf auth_readonly" aria-label="# input" aria-describedby="#">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4 py-3">
              <h7 id="title_old_datasource"></h7><br>
              <h7 id="student_date"></h7><br>
              <h7 id="student_datasource"></h7>
            </div>
          </div>
          <!-- 標記 -S  -->
          <div class="row">
            <div class="col-12 py-2">
              <h6>標記 :
                @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'officestaff' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'saleser'))
                <i class="fa fa-plus" aria-hidden="true" style="cursor:pointer;" id="new_tag" data-toggle="modal" data-target="#save_tag"></i>
                @endif
              </h6>
              <input type="text" id="isms_tags" />
            </div>
            <div class="col-5">
            </div>
            {{-- <div class="col-4 align-right">
                @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'officestaff' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'saleser'))
                <button type="button" class="btn btn-primary float-right" onclick="btn_delete('','1');">刪除聯絡人</button>
                @endif
              </div> --}}
          </div>
          <div class="modal fade" id="save_tag" tabindex="-1" role="dialog" aria-labelledby="save_tagTitle" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">標記名稱</h5>
                  <button type="button" class="close" id="tag_close" aria-label="Close" data-number="1">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="text" id="tag_name" class="input_width">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" onclick="tags_add();">儲存</button>
                </div>
              </div>
            </div>
          </div>
          <!-- 標記 -E -->
          <!-- tab - S -->
          <ul class="nav nav-tabs pb-3" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic_data" role="tab" aria-controls="basic_data" aria-selected="true">基本訊息</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="history-tab" data-toggle="tab" href="#history_data" role="tab" aria-controls="history_data" aria-selected="false" onclick="history_data();">歷史互動</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact_data" role="tab" aria-controls="contact_data" aria-selected="false" onclick="contact_data();">聯絡狀況</a>
            </li>
          </ul>
          <!-- tab - E -->
          <!-- 完整內容 - S -->
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active p-3" id="basic_data" role="tabpanel" aria-labelledby="basic-tab">
              <div class="row">
                <div class="col-6">
                  <div class="row">
                    <div class="col-4">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">最新來源</span>
                        </div>
                        <input type="text" name="new_datasource" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">職業</span>
                        </div>
                        <input id="student_profession" type="text" class="form-control bg-white basic-inf auth_readonly" aria-label="# input" aria-describedby="#">
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">原始來源</span>
                        </div>
                        <input type="text" id="old_datasource" class="form-control bg-white basic-inf auth_readonly" aria-label="# input" aria-describedby="#">
                        <input type="hidden" id="sales_registration_old">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">正課報名場次</span>
                        </div>
                        <input type="text" name="course_events" class="form-control bg-white basic-inf demo2" aria-label="# input" aria-describedby="#" data-placement="bottom" data-html="true" title="" readonly>
                      </div>

                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text ">銷講報名場次</span>
                    </div>
                    <input type="text" name="course_sales_events" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">想了解的內容</span>
                    </div>
                    <input type="text" name="course_content" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">銷講後報名狀況</span>
                    </div>
                    <input type="text" name="course_sales_status" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">居住地址</span>
                    </div>
                    <input type="text" id="student_address" class="form-control bg-white basic-inf auth_readonly" aria-label="# input" aria-describedby="#">
                  </div>
                </div>
                <div class="col-6">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">參與活動</span>
                    </div>
                    <input type="text" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" data-placement="bottom" data-html="true" title="參與活動 : 參與次數 : 參與度 : " readonly>
                  </div>
                  <div class="input-group mb-3" id="dev_refund">
                    <div class="input-group-prepend">
                      <span class="input-group-text bg-danger text-white">退款</span>
                    </div>
                    <input type="text" name="course_refund" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                  </div>
                  @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'officestaff' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'saleser'))
                  <button type="button" class="btn btn-primary float-right" id="save-inf" style="display:block;" onclick="save();">儲存</button>
                  @endif
                  <!-- <button type="button" class="btn btn-primary float-right" id="update-inf" style="display:block;">修改資料</button> -->
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <h7 name="count_sales_ok"></h7>
                </div>
                <div class="col-3">
                  <h7 name="sales_successful_rate"> </h7>
                </div>
                <div class="col-3">
                  <h7 name="count_sales_no"></h7>
                </div>
                <div class="col-3">
                  <h7 name="sales_cancel_rate"></h7>
                </div>
              </div>
            </div>
            <!-- 歷史互動 -->
            <div class="tab-pane fade" id="history_data" role="tabpanel" aria-labelledby="history-tab">
              <div class="table-responsive">
                @component('components.datatable_history')
                @slot('thead')
                <tr>
                  <th>時間</th>
                  <th>動作</th>
                  <th>內容</th>
                </tr>
                @endslot
                @slot('tbody')
                @endslot
                @endcomponent
                <!-- </table> -->
              </div>
            </div>
            <!-- 歷史互動 -->

            <!-- 聯絡狀況 -->
            <div class="tab-pane fade" id="contact_data" role="tabpanel" aria-labelledby="contact-tab">
              <div class="table-responsive">
                <table class="table table-striped table-sm text-center">
                  <thead>
                    <tr>
                      <th class="text-nowrap">
                        <button type="button" class="btn btn-secondary btn-sm mx-1 auth_hidden" data-toggle="modal" data-target="#save_contact"><i class="fa fa-plus" aria-hidden="true"></i></button>
                      </th>
                      <th class="text-nowrap"></th>
                      <th class="text-nowrap">日期</th>
                      <th class="text-nowrap">追單課程</th>
                      <th class="text-nowrap">付款狀態/日期</th>
                      <th class="text-nowrap">聯絡內容</th>
                      <th class="text-nowrap">付款狀態</th>
                      <th class="text-nowrap">最新狀態</th>
                      <th class="text-nowrap">追單人員</th>
                      <th class="text-nowrap">設提醒</th>
                    </tr>
                  </thead>
                  <tbody id="contact_data_detail">
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal fade" id="save_contact" tabindex="-1" role="dialog" aria-labelledby="save_tagTitle" aria-hidden="true" data-backdrop="static">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">新增聯絡狀況</h5>
                    <button type="button" class="close" id="contact_close" aria-label="Close" data-number="1">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="form_debt">
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">日期:</label>
                        <div class="input-group date" data-target-input="nearest">
                          <input type="text" id="debt_date" name="debt_date" class="form-control datetimepicker-input" data-target="#debt_date" data-toggle="datetimepicker" placeholder="日期">
                          {{-- <div class="input-group-append" data-target="#debt_date" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div> --}}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">追單課程:</label>
                        <input type="text" id="debt_course" class="form-control" placeholder="請輸入追單課程" value="" class="border-0 bg-transparent input_width" required>
                      </div>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">付款狀態 / 日期:</label>
                        <input type="text" id="debt_status_date" class="form-control" placeholder="請輸入付款狀態 / 日期" value="" class="border-0 bg-transparent input_width">
                      </div>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">聯絡內容:</label>
                        <input type="text" id="debt_contact" class="form-control" value="" placeholder="請輸入聯絡內容" class="border-0 bg-transparent input_width">
                      </div>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">付款狀態:</label>
                        <select id="debt_status_payment_name" class="form-control custom-select border-0 bg-transparent input_width">
                          <option selected="" disabled="" value=""></option>
                          <option value="留單">留單</option>
                          <option value="完款">完款</option>
                          <option value="付訂">付訂</option>
                          <option value="退費">退費</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">最新狀態:</label>
                        <select id="debt_status" class="form-control custom-select border-0 bg-transparent input_width">
                          <option selected="" disabled="" value=""></option>
                          <option value="12">待追</option>
                          <option value="15">無意願</option>
                          <option value="16">推薦其他講師</option>
                          <option value="22">通知下一梯次</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">追單人員:</label>
                        <input type="text" id="debt_person" class="form-control" placeholder="請輸入追單人員" value="" class="border-0 bg-transparent input_width" required>
                      </div>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">設提醒:</label>
                        <div class="input-group date" data-target-input="nearest">
                          <input type="text" id="debt_remind" name="debt_remind" class="form-control datetimepicker-input" data-target="#debt_remind" data-toggle="datetimepicker">
                          {{-- <div class="input-group-append" data-target="#debt_remind" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i>
                              </div>
                            </div> --}}
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" id="btnSubmit" class="btn btn-primary" onclick="debt_add();">儲存</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal fade" id="show_contact" tabindex="-1" role="dialog" aria-labelledby="save_tagTitle" aria-hidden="true" data-backdrop="static">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">顯示聯絡狀況</h5>
                    <button type="button" class="close" id="show_contact_close" aria-label="Close" data-number="1">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">日期:</label>
                      <label id="lbl_debt_date"></label>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">追單課程:</label>
                      <label id="lbl_debt_course"></label>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">付款狀態 / 日期:</label>
                      <label id="lbl_debt_status_date"></label>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">聯絡內容:</label>
                      <label id="lbl_debt_contact"></label>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">付款狀態:</label>
                      <label id="status_payment_name"></label>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">最新狀態:</label>
                      <label id="lbl_debt_status"></label>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">追單人員:</label>
                      <label id="lbl_debt_person"></label>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">設提醒:</label>
                      <label id="lbl_debt_remind"></label>
                      <!-- <div class="input-group date" data-target-input="nearest">
                          <input type="text" id="debt_remind" name="debt_remind" class="form-control datetimepicker-input datepicker" data-target="#debt_remind">
                          <div class="input-group-append" data-target="#debt_remind" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                            </div>
                          </div>
                        </div> -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- 聯絡狀況 -->
              <!-- 完整內容 - E -->
            </div>
          </div>
        </div>
        <!-- 完整內容 - E -->
      </div>
    </div>

  </div>
</div>
<!-- Content End -->


<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script src="{{ asset('js/angular.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-tagsinput-angular.min.js') }}"></script>
<script>
  var id_student_old = '';
  var elt = $('#isms_tags');
  var table, table2;

  $(document).ready(function() {
    // // 新增報表 - 報名日期
    // var d = new Date();

    // var month = d.getMonth() + 1;
    // var day = d.getDate();

    // var output = d.getFullYear() + '-' +
    //     (month < 10 ? '0' : '') + month + '-' +
    //     (day < 10 ? '0' : '') + day;

    // $("#idate").val(output);


    //日期&g時間選擇器 Sandy (2020/02/27)
    var iconlist = {
      time: 'fas fa-clock',
      date: 'fas fa-calendar',
      up: 'fas fa-arrow-up',
      down: 'fas fa-arrow-down',
      previous: 'fas fa-arrow-circle-left',
      next: 'fas fa-arrow-circle-right',
      today: 'far fa-calendar-check-o',
      clear: 'fas fa-trash',
      close: 'far fa-times'
    }

    $('.pay_date').datetimepicker({
      languate: 'zh-TW',
      format: 'YYYY-MM-DD',
      icons: iconlist
    });

    $('#idate').datetimepicker({
      defaultDate: new Date(),
      languate: 'zh-TW',
      format: 'YYYY-MM-DD',
      icons: iconlist
    });

    $('#ipaydate').datetimepicker({
      languate: 'zh-TW',
      format: 'YYYY-MM-DD',
      icons: iconlist
    });

    $('#ibirthday').datepicker({
      // defaultDate: new Date(),
      languate: 'zh-TW',
      format: 'twy-mm-dd',
    });

    // $('#ibirthday').datetimepicker({ 
    //   // locale : 'zh-tw',
    //   languate: 'zh-TW',
    //   format: 'twy-MM-DD',
    //   icons: iconlist, 
    // });

    $('#edit_date').datetimepicker({
      defaultDate: new Date(),
      languate: 'zh-TW',
      format: 'YYYY-MM-DD',
      icons: iconlist,
    });

    $('#edit_birthday').datepicker({
      languate: 'zh-TW',
      format: 'twy-mm-dd',
    });


    //日期選擇器
    $('#debt_date').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    $('#debt_remind').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    table2 = $('#table_list_history').DataTable();

    $(".demo2").tooltip();

    // 權限判斷 Rocky(2020/05/10)
    check_auth();

  });


  // 權限判斷
  function check_auth() {
    var role = ''
    role = JSON.parse($('#auth_role').val())['role']
    if (role != "admin" && role != "marketer" && role != "officestaff" && role != "msaleser" && role != "saleser") {
      $('.auth_readonly').attr('readonly', 'readonly')
      $('.auth_readonly').attr("disabled", true);
      $(".auth_hidden").attr("style", "display:none");
    }
  }


  // 追單資料關閉
  $("#contact_close").click(function() {
    $('#save_contact').modal('hide');
  });

  $("#show_contact_close").click(function() {
    $('#show_contact').modal('hide');
  });

  // 標記關閉
  $("#tag_close").click(function() {
    $('#save_tag').modal('hide');
  });


  /* 日期選擇器位置 */
  $(document).on('show', $('.datepicker').datepicker(), function() {
    $('.datepicker').removeClass('datepicker-orient-top');
    $('.datepicker').addClass('datepicker-orient-bottom');
  });
  /* 日期選擇器位置 */

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

  function fill_data(phone) {
    $.ajax({
      type: 'GET',
      url: 'course_return_fill',
      data: {
        phone: phone
      },
      success: function(data) {
        // console.log(data);  

        if (data != "nodata") {
          //針對空格做填入 

          if ($("#iname").val() == "") {
            $("#iname").val(data.name);
          }

          if (typeof($('[name="isex"]:checked').val()) == "undefined") {
            if (data.sex == '男') {
              $("#isex1").click();
            } else {
              $("#isex2").click();
            }
          }

          if ($("#iid").val() == "") {
            $("#iid").val(data.id_identity);
          }

          if ($("#iphone").val() == "") {
            $("#iphone").val(data.phone);
          }

          if ($("#iemail").val() == "") {
            $("#iemail").val(data.email);
          }

          if ($("#ibirthday").val() == "") {
            $("#ibirthday").val(data.birthday);
          }

          if ($("#icompany").val() == "") {
            $("#icompany").val(data.company);
          }

          if ($("#iprofession").val() == "") {
            $("#iprofession").val(data.profession);
          }

          if ($("#iaddress").val() == "") {
            $("#iaddress").val(data.address);
          }

        }

      },
      error: function(jqXHR, textStatus, errorMessage) {
        console.log("error: " + errorMessage);
      }
    });
  }
  /* 新增資料-聯絡電話 搜尋學員既有資料Sandy(0329) S */

  /* 編輯資料 S Sandy(2020/06/25) */
  $('.edit_data').on('click', function(e) {
    var id = $(this).data('id');
    var phone = $(this).data('phone');
    $.ajax({
      type: 'GET',
      url: 'course_return_edit_fill',
      data: {
        id: id,
        phone: phone
      },
      success: function(data) {
        // console.log(data);  

        // $('.edit_input').val('');
        // $('.edit_input').prop('checked',false);

        if (data != "nodata") {
          $("#edit_id").val(id); //報名ID
          $("#edit_idevents").val($('#id_events').val()); //場次ID
          $("#edit_date").val(data['data']['submissiondate']); //報名日期
          $("#edit_phone").val(data['data']['phone']); //電話
          $("#edit_name").val(data['data']['name']);
          if (data['data']['sex'] == '男') {
            $("#edit_sex1").click();
          } else {
            $("#edit_sex2").click();
          }
          $("#edit_identity").val(data['data']['id_identity']); //身分證
          $("#edit_email").val(data['data']['email']); //信箱
          $("#edit_birthday").val(data['data']['birthday']); //生日
          $("#edit_company").val(data['data']['company']); //公司
          $("#edit_profession").val(data['data']['profession']); //職業
          $("#edit_address").val(data['data']['address']); //地址
          //我想參加課程
          switch (data['data']['registration_join']) {
            case "0":
              $('#edit_join1').click();
              break;
            case "1":
              $('#edit_join2').click();
              break;
            case "2":
              $('#edit_join3').click();
              break;
            default:
              break;
          }
          $("#edit_events").text(data['events']); //報名場次
          if (data['id_events'] != "") {
            $("#" + data['id_events']).attr("checked", true); //選擇場次
          }
          switch (data['data']['type_invoice']) { //統一發票
            case "0":
              $('#edit_invoice1').click();
              break;
            case "1":
              $('#edit_invoice2').click();
              break;
            case "2":
              $('#edit_invoice3').click();
              break;
            default:
              break;
          }
          $("#edit_num").val(data['data']['number_taxid']); //統編
          $("#edit_companytitle").val(data['data']['companytitle']); //抬頭

        }


      },
      error: function(jqXHR, textStatus, errorMessage) {
        console.log(jqXHR);
      }
    });
  });

  //編輯場次開啟
  $('#edit_collapse').on('show.bs.collapse', function () {
    $('#edit_collapse_val').val(1);
  })
  //編輯場次關閉
  $('#edit_collapse').on('hidden.bs.collapse', function () {
    $('#edit_collapse_val').val(0);
  })
  /* 編輯資料 E Sandy(2020/06/25) */

  /* 刪除資料 S Sandy(2020/06/25) */
  function btn_delete_data(id_apply) {
    var msg = "是否刪除此筆資料?";
    if (confirm(msg) == true) {
      $.ajax({
        type: 'POST',
        url: 'course_return_delete_data',
        dataType: 'json',
        data: {
          id_apply: id_apply
        },
        success: function(data) {
          // console.log(data);
          if (data['data'] == "ok") {
            alert('刪除成功！！')
            /** alert **/
            // $("#success_alert_text").html("刪除資料成功");
            // fade($("#success_alert"));

            location.reload();
          } else {
            // alert('刪除失敗！！')

            /** alert **/
            $("#error_alert_text").html("刪除資料失敗");
            fade($("#error_alert"));
          }
        },
        error: function(error) {
          console.log(JSON.stringify(error));

          /** alert **/
          $("#error_alert_text").html("刪除資料失敗");
          fade($("#error_alert"));
        }
      });
    } else {
      return false;
    }
  }
  /* 刪除資料 E Sandy(2020/06/25) */


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
  $('body').on('change', 'select[name="status_payment"]', function() {
    var data_id = ($(this).attr('id')).substr(14);
    var data_type = 'status_payment';
    var status = '';

    // if($(this).val() == 7){
    //   // var msg = "確認此學員付款狀態為「完款」? 確認後系統將寄出報名成功訊息給此學員。";
    //   var msg = "付款狀態為「完款」，是否傳訊息報名成功訊息此學員？ 確認後系統將寄出報名成功訊息給此學員。";
    //   if (confirm(msg)==true){
    //     // status = save_data($(this), data_type, data_id);
    //     //寄訊息
    //     sendMsg(data_id);
    //   // }else{          
    //   //   $(this).val($(this).data('orgvalue'));
    //   //   return false;
    //   }
    // }
    // else{
    //   status = save_data($(this), data_type, data_id);
    // }

    status = save_data($(this), data_type, data_id);

    //完款、付訂、留單數目更新
    if (status == 'success') {
      switch ($(this).val()) {
        case '6':
          var count_order = parseInt($('#count_order').text()) + 1;
          $('#count_order').html(count_order);
          break;
        case '7':
          var count_settle = parseInt($('#count_settle').text()) + 1;
          $('#count_settle').html(count_settle);
          break;
        case '8':
          var count_deposit = parseInt($('#count_deposit').text()) + 1;
          $('#count_deposit').html(count_deposit);
          break;
        default:
          break;
      }

      switch ($(this).data('orgvalue').toString()) {
        case '6':
          var count_order = parseInt($('#count_order').text()) - 1;
          $('#count_order').html(count_order);
          break;
        case '7':
          var count_settle = parseInt($('#count_settle').text()) - 1;
          $('#count_settle').html(count_settle);
          break;
        case '8':
          var count_deposit = parseInt($('#count_deposit').text()) - 1;
          $('#count_deposit').html(count_deposit);
          break;
        default:
          break;
      }
    }
    $(this).data('orgvalue', $(this).val());


  });

  // 應付
  $('body').on('blur', 'input[name="amount_payable"]', function() {
    var data_id = ($(this).attr('id')).substr(14);
    var data_type = 'amount_payable';
    save_data($(this), data_type, data_id);

    //已付更新
    $('#amount_paid' + data_id).html(function() {
      return $('#payment' + data_id + ' input[name="cash"]').toArray().reduce(function(tot, val) {
        return tot + parseInt(val.value);
      }, 0);
    });
    //待付更新
    $('#pending' + data_id).html(function() {
      return parseInt($('#amount_payable' + data_id).val() - $('#amount_paid' + data_id).html());
    });
  });
  $('body').on('keyup', 'input[name="amount_payable"]', function(e) {
    if (e.keyCode === 13) {
      var data_id = ($(this).attr('id')).substr(14);
      var data_type = 'amount_payable';
      save_data($(this), data_type, data_id);

      //已付更新
      $('#amount_paid' + data_id).html(function() {
        return $('#payment' + data_id + ' input[name="cash"]').toArray().reduce(function(tot, val) {
          return tot + parseInt(val.value);
        }, 0);
      });
      //待付更新
      $('#pending' + data_id).html(function() {
        return parseInt($('#amount_payable' + data_id).val() - $('#amount_paid' + data_id).html());
      });
    }
  });

  // 付款日期
  $('body').on('blur', 'input[name^="pay_date"]', function() {
    var data_id = ($(this).attr('id')).substr(8);
    var data_type = 'pay_date';
    save_data($(this), data_type, data_id);
    $('.pay_date').datetimepicker('hide');
  });
  $('body').on('keyup', 'input[name^="pay_date"]', function(e) {
    if (e.keyCode === 13) {
      var data_id = ($(this).attr('id')).substr(8);
      var data_type = 'pay_date';
      save_data($(this), data_type, data_id);
      $('.pay_date').datetimepicker('hide');
    }
  });

  // 服務人員
  $('body').on('blur', 'input[name="person"]', function() {
    var data_id = ($(this).attr('id')).substr(6);
    var data_type = 'person';
    save_data($(this), data_type, data_id);
  });
  $('body').on('keyup', 'input[name="person"]', function(e) {
    if (e.keyCode === 13) {
      var data_id = ($(this).attr('id')).substr(6);
      var data_type = 'person';
      save_data($(this), data_type, data_id);
    }
  });

  // 備註
  $('body').on('blur', 'input[name="pay_memo"]', function() {
    var data_id = ($(this).attr('id')).substr(8);
    var data_type = 'pay_memo';
    save_data($(this), data_type, data_id);
  });
  $('body').on('keyup', 'input[name="pay_memo"]', function(e) {
    if (e.keyCode === 13) {
      var data_id = ($(this).attr('id')).substr(8);
      var data_type = 'pay_memo';
      save_data($(this), data_type, data_id);
    }
  });

  // 付款資料 - 付款方式
  $('body').on('change', 'select[name="pay_model"]', function(e) {
    var data_id = ($(this).attr('id')).substr(9);
    var data_type = 'pay_model';
    save_data($(this), data_type, data_id);
  });

  // 付款資料 - 金額
  $('body').on('blur', 'input[name="cash"]', function(e) {
    e.preventDefault();
    var data_val = $(this).val();
    if (data_val == "") {
      /** alert **/
      $("#error_alert_text").html("金額欄位不可空白，請輸入金額");
      fade($("#error_alert"));
      $(this).focus();
    } else {
      var data_id = ($(this).attr('id')).substr(4);
      var data_type = 'cash';
      save_data($(this), data_type, data_id);

      var id_registration = $(this).attr('data-registration');
      //已付更新
      $('#amount_paid' + id_registration).html(function() {
        return $('#payment' + id_registration + ' input[name="cash"]').toArray().reduce(function(tot, val) {
          return tot + parseInt(val.value);
        }, 0);
      });
      //待付更新
      $('#pending' + id_registration).html(function() {
        return parseInt($('#amount_payable' + id_registration).val() - $('#amount_paid' + id_registration).html());
      });
    }

    //總金額更新
    $('#cash').html(function() {
      return $('input[name="cash"]').toArray().reduce(function(tot, val) {
        return tot + parseInt(val.value);
      }, 0);
    });

  });
  $('body').on('keyup', 'input[name="cash"]', function(e) {
    e.preventDefault();
    if (e.keyCode === 13) {
      var data_val = $(this).val();
      if (data_val == "") {
        /** alert **/
        $("#error_alert_text").html("金額欄位不可空白，請輸入金額");
        fade($("#error_alert"));
        $(this).focus();
      } else {
        var data_id = ($(this).attr('id')).substr(4);
        var data_type = 'cash';
        save_data($(this), data_type, data_id);

        var id_registration = $(this).attr('data-registration');
        //已付更新
        $('#amount_paid' + id_registration).html(function() {
          return $('#payment' + id_registration + ' input[name="cash"]').toArray().reduce(function(tot, val) {
            return tot + parseInt(val.value);
          }, 0);
        });
        //待付更新
        $('#pending' + id_registration).html(function() {
          return parseInt($('#amount_payable' + id_registration).val() - $('#amount_paid' + id_registration).html());
        });
      }

      //總金額更新
      $('#cash').html(function() {
        return $('input[name="cash"]').toArray().reduce(function(tot, val) {
          return tot + parseInt(val.value);
        }, 0);
      });
    }
  });

  // 付款資料 - 帳戶/卡號後四碼
  $('body').on('blur', 'input[name="number"]', function(e) {
    // var data_val = $(this).val();
    var data_id = ($(this).attr('id')).substr(6);
    var data_type = 'number';
    save_data($(this), data_type, data_id);
    // if( data_val == "" ){
    //   /** alert **/ 
    //   $("#error_alert_text").html("帳戶/卡號後四碼不可空白，請輸入帳戶/卡號後四碼");
    //   fade($("#error_alert")); 
    //   $(this).focus();
    // }else{
    //   var data_id = ($(this).attr('id')).substr(6);
    //   var data_type = 'number';
    //   save_data($(this), data_type, data_id);
    // }
  });
  $('body').on('keyup', 'input[name="number"]', function(e) {
    if (e.keyCode === 13) {
      // var data_val = $(this).val();
      var data_id = ($(this).attr('id')).substr(6);
      var data_type = 'number';
      save_data($(this), data_type, data_id);
      // if( data_val == "" ){
      //   /** alert **/ 
      //   $("#error_alert_text").html("卡號後四碼不可空白");
      //   fade($("#error_alert")); 
      //   $(this).focus();
      // }else{
      //   var data_id = ($(this).attr('id')).substr(6);
      //   var data_type = 'number';
      //   save_data($(this), data_type, data_id);
      // }
    }
  });

  function save_data(data, data_type, data_id) {
    var id_events = $("#id_events").val();
    var data_val = data.val();
    var status = '';
    $.ajax({
      type: 'POST',
      url: 'course_return_update',
      async: false,
      data: {
        id_events: id_events,
        data_type: data_type,
        data_val: data_val,
        data_id: data_id
      },
      success: function(data) {
        // console.log(JSON.stringify(data));

        if (data == 'success') {
          status = 'success';

          /** alert **/
          $("#success_alert_text").html("資料儲存成功");
          fade($("#success_alert"));
        } else {
          status = 'error';

          /** alert **/
          $("#error_alert_text").html("資料儲存失敗");
          fade($("#error_alert"));
        }

      },
      error: function(jqXHR) {
        // console.log(JSON.stringify(jqXHR));  

        status = 'error';

        /** alert **/
        $("#error_alert_text").html("資料儲存失敗");
        fade($("#error_alert"));
      }
    });

    return status;
  }

  /* 資料儲存 End */

  /* 新增付款 Start */
  $('body').on('click', '.add_payment', function() {
    var data_id = ($(this).attr('id')).substr(11);
    $("#add_payment #id_registration").val(data_id);
    $("#add_payment #add_student").val($(this).attr('data-name'));
    $("#add_payment #add_phone").val($(this).attr('data-phone'));
    // var payment_len = $('tr[name="tr'+data_id+'"]').length;
    // if( payment_len < 3 ){
    //   $('#payment_table' + data_id + ' tbody').append(`

    //   `);
    // }
  });
  $('body').on('click', '#btn_payment', function() {
    var id_registration = $("#id_registration").val();
    var pay_model = $("#add_paymodel").val();
    var cash = $("#add_cash").val();
    var number = $("#add_number").val();

    if (cash == "") {
      alert('請輸入金額');
      return false;
    }

    var payment_len = $('tr[name="tr' + id_registration + '"]').length;

    $.ajax({
      type: 'POST',
      url: 'course_return_insert_payment',
      data: {
        id_registration: id_registration,
        pay_model: pay_model,
        cash: cash,
        number: number
      },
      success: function(data) {
        // console.log(JSON.stringify(data));

        if (data != 'error') {

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
                  <button type="button" class="btn btn-danger btn-sm mx-1" onclick="btn_delete_payment(${ data.id });">刪除</button>
                </td>
              </tr>
            `);

          if ($('#payment_table' + id_registration + ' tbody tr').length == 3) {
            $('#payment' + id_registration + ' button.add_payment').remove();
          }

          //已付更新
          $('#amount_paid' + data.id_registration).html(function() {
            return $('#payment' + data.id_registration + ' input[name="cash"]').toArray().reduce(function(tot, val) {
              return tot + parseInt(val.value);
            }, 0);
          });
          //待付更新
          $('#pending' + data.id_registration).html(function() {
            return parseInt($('#amount_payable' + data.id_registration).val() - $('#amount_paid' + data.id_registration).html());
          });
          //總金額更新
          $('#cash').html(function() {
            return $('input[name="cash"]').toArray().reduce(function(tot, val) {
              return tot + parseInt(val.value);
            }, 0);
          });

          $('#add_payment').modal('hide');

          /** alert **/
          $("#success_alert_text").html("新增付款成功");
          fade($("#success_alert"));

        } else {
          /** alert **/
          $("#error_alert_text").html("新增付款失敗");
          fade($("#error_alert"));
        }

      },
      error: function(jqXHR) {
        // console.log(JSON.stringify(jqXHR));  

        /** alert **/
        $("#error_alert_text").html("新增付款失敗");
        fade($("#error_alert"));
      }
    });
  });

  /* 新增付款 End */


  /* 刪除付款 Sandy(2020/03/22) */
  function btn_delete_payment(id_payment) {
    var msg = "是否刪除此付款資訊?";
    if (confirm(msg) == true) {
      $.ajax({
        type: 'POST',
        url: 'course_return_delete_payment',
        dataType: 'json',
        data: {
          id_payment: id_payment,
        },
        success: function(data) {
          if (data['data'] == "ok") {
            alert('刪除付款成功！！')
            location.reload();
          } else {
            /** alert **/
            $("#error_alert_text").html("刪除付款失敗");
            fade($("#error_alert"));
          }
        },
        error: function(error) {
          console.log(JSON.stringify(error));

          /** alert **/
          $("#error_alert_text").html("刪除付款失敗");
          fade($("#error_alert"));
        }
      });
    } else {
      return false;
    }
  }
  /* 刪除付款 Sandy(2020/03/22) */




  /* 完整內容 -S Rocky(2020/02/29) */

  // 基本訊息
  function course_data(id_student) {
    id_student_old = id_student
    history_data();
    contact_data();
    tags_show(id_student);
    $.ajax({
      type: 'POST',
      url: 'course_data',
      dataType: 'json',
      data: {
        id_student: id_student
      },
      async: false,
      success: function(data) {
        // console.log(data)

        // 宣告
        var datasource_old = ''

        // 銷講報到率
        var sales_successful_rate = '0',
          course_cancel_rate = '0';
        var course_sales_status = '',
          course_sales_events = '';
        if (data['count_sales_ok'] != 0) {
          sales_successful_rate = (data['count_sales_ok'] / (data['count_sales'] - data['count_sales_no']) * 100).toFixed(0)
        }

        // 銷講取消率
        if (data['count_sales_no'] != 0) {
          course_cancel_rate = (data['count_sales_no'] / data['count_sales'] * 100).toFixed(0)
        }

        if (data[0]['datasource_old'] != null) {
          datasource_old = data[0]['datasource_old']
        } else {
          datasource_old = "無"
        }

        // 學員資料
        $('#student_name').val(data[0]['name']);
        $('#student_email').val(data[0]['email']);
        $('#title_student_phone').val(data[0]['phone']);
        $('#title_old_datasource').text('原始來源:' + datasource_old);
        $('#student_date').text('加入日期 :' + data['submissiondate']);
        $('#student_profession').val(data[0]['profession']);
        $('#student_address').val(data[0]['address']);
        $('#sales_registration_old').val(data[0]['sales_registration_old']);
        $('#old_datasource').val(datasource_old);
        $('#student_phone').val(data[0]['phone']);

        // 銷講      
        $('input[name="new_datasource"]').val(data['datasource']);
        if (data['course_sales'] != null) {
          var course_sales = '',
            course_sales_events = '',
            sales_registration_course_start_at = ''
          if (data['course_sales'] == null) {
            course_sales = " "
          } else {
            course_sales = data['course_sales']
          }

          if (data['course_sales_events'] == null) {
            course_sales_events = " "
          } else {
            course_sales_events = data['course_sales_events']
          }

          if (data['sales_registration_course_start_at'] == null) {
            sales_registration_course_start_at = "無"
          } else {
            sales_registration_course_start_at = data['sales_registration_course_start_at']
          }

          course_sales_events = course_sales + ' ' + course_sales_events + '(' + sales_registration_course_start_at + ' )'
        }
        $('input[name="course_sales_events"]').val(course_sales_events);

        $('input[name="course_content"]').val(data['course_content']);
        $('input[name="status_payment"]').val('');
        if (typeof(data['status_registration']) != 'undefined') {
          var course_events = '',
            course_registration = '',
            status_registration = ''
          if (data['course_events'] == null) {
            course_events = "無"
          } else {
            course_events = data['course_events']
          }

          if (data['course_registration'] == null) {
            course_registration = " "
          } else {
            course_registration = data['course_registration']
          }

          if (data['status_registration'] == null) {
            status_registration = " "
          } else {
            status_registration = data['status_registration']
          }

          course_sales_status = status_registration + '(' + course_registration + ' ' + course_events + ' )'
        }
        $('input[name="course_sales_status"]').val(course_sales_status);
        if (data['count_sales_ok'] == null) {
          $('h7[name="count_sales_ok"]').text('銷講報名次數 :0');
        } else {
          $('h7[name="count_sales_ok"]').text('銷講報名次數 :' + data['count_sales_ok']);
        }
        if (data['count_sales_ok'] == null) {
          $('h7[name="sales_successful_rate"]').text('銷講報到率 :0%');
        } else {
          $('h7[name="sales_successful_rate"]').text('銷講報到率 :' + sales_successful_rate + '%');
        }
        if (data['count_sales_no'] == null) {
          $('h7[name="count_sales_no"]').text('銷講取消次數 :0');
        } else {
          $('h7[name="count_sales_no"]').text('銷講取消次數 :' + data['count_sales_no']);
        }

        if (data['count_sales_ok'] == null) {
          $('h7[name="sales_cancel_rate"]').text('銷講取消率 :0%');
        } else {
          $('h7[name="sales_cancel_rate"]').text('銷講取消率 :' + course_cancel_rate + '%');
        }



        // 正課
        $('input[name="course_events"]').val('');
        if (typeof(data['course_registration']) != 'undefined') {
          var course_events = '',
            course_registration = ''
          if (data['course_events'] == null) {
            course_events = " "
          } else {
            course_events = data['course_events']
          }

          if (data['course_registration'] == null) {
            course_registration = " "
          } else {
            course_registration = data['course_registration']
          }

          $('input[name="course_events"]').val(course_registration + ' ' + course_events);
        }

        // 退款
        $('input[name="course_refund"]').val('');

        var refund_reason = ''
        if (data['refund_reason'] != null) {
          refund_reason = data['refund_reason']
        } else {
          refund_reason = "無"
        }

        if (typeof(data['refund_course']) != 'undefined') {
          $('input[name="course_refund"]').val(data['refund_course'] + '(' + refund_reason + ')');
        } else {
          $('#dev_refund').hide();

        }

        $("#student_information").modal('show');
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }

  /* 標記 -S Rocky(2020/03/12) */

  // 標記顯示
  function tags_show(id_student) {
    $.ajax({
      type: 'POST',
      url: 'tag_show',
      dataType: 'json',
      data: {
        id_student: id_student
      },
      success: function(data) {
        // console.log(data);

        var cities = new Bloodhound({
          datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          local: data
        });
        cities.initialize();
        var elt = $('#isms_tags');
        // 設定標籤
        elt.tagsinput({
          tagClass: function(item) {
            return 'badge badge-primary'
          },
          itemValue: 'value',
          itemText: 'text',
          typeaheadjs: {
            name: 'cities',
            displayKey: 'text',
            source: cities.ttAdapter()
          }
        });
        // 清空標籤
        $('#isms_tags').tagsinput('removeAll');

        if (data.length != 0) {
          // 新增資料到標籤
          $.each(data, function(index, val) {
            elt.tagsinput('add', {
              "value": val['value'],
              "text": val['text'],
              "continent": val['text']
            });
          });
        }
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }

  // 標記新增
  function tags_add() {
    name = $("#tag_name").val();

    $.ajax({
      type: 'POST',
      url: 'tag_save',
      data: {
        id_student: id_student_old,
        name: name,
      },
      success: function(data) {
        if (data = "儲存成功") {
          tags_show(id_student_old)
          $("#tag_name").val('')
          $("#success_alert_text").html("儲存成功");
          fade($("#success_alert"));
        } else {
          $("#error_alert_text").html("儲存失敗");
          fade($("#error_alert"));
        }
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }

  // 標記刪除
  elt.on('beforeItemRemove', function(event) {
    // 權限 Rocky (2020/05/11)
    var role = $('#auth_role').val()
    if (role == "admin" || role == "marketer" || role == "officestaff" || role == "msaleser" || role == "saleser") {
      var msg = "是否刪除標記資料?";
      if (confirm(msg) == true) {
        $.ajax({
          type: 'POST',
          url: 'tag_delete',
          dataType: 'json',
          data: {
            id: event.item['value']
          },
          success: function(data) {
            if (data['data'] == "ok") {
              /** alert **/
              $("#success_alert_text").html("刪除資料成功");
              fade($("#success_alert"));

              // location.reload();
            } else {
              /** alert **/
              $("#error_alert_text").html("刪除資料失敗");
              fade($("#error_alert"));
            }
          },
          error: function(error) {
            console.log(JSON.stringify(error));
          }
        });
      } else {
        tags_show(id_student_old)
        return false;
      }
    } else {
      tags_show(id_student_old)
      return false;
    }
  });

  /* 標記 -E Rocky(2020/03/12) */

  // 歷史互動
  function history_data() {
    table2.clear().draw();
    table2.destroy();

    table2 = $('#table_list_history').DataTable({
      "dom": '<l<t>p>',
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }],
      "deferRender": true,
      "orderCellsTop": true,
      "destroy": true,
      "retrieve": true,
      "ajax": {
        "url": "history_data",
        "type": "POST",
        "data": {
          id_student: id_student_old
        },
        async: false,
        "dataSrc": function(json) {
          for (var i = 0, ien = json.length; i < ien; i++) {

            var status = '',
              course_sales = '';
            if (json[i]['status_sales'] == null) {
              status = '無'
            } else {
              status = json[i]['status_sales']
            }

            if (json[i]['course_sales'] == null) {
              course_sales = '無'
            } else {
              course_sales = json[i]['course_sales']
            }

            // id_student = json[i]['id_student'];
            json[i][0] = json[i]['created_at'];
            json[i][1] = status;
            json[i][2] = course_sales;
          }
          return json;

        }
      }
    });


    // 調整Datable.js寬度
    $("#table_list_history").css({
      "width": "100%"
    });

    // $.ajax({
    //   type: 'POST',
    //   url: 'history_data',
    //   dataType: 'json',
    //   data: {
    //     id_student: id_student_old
    //   },
    //   success: function(data) {
    //     var id_student = '';
    //     $('#history_data_detail').html('');
    //     $.each(data, function(index, val) {
    //       var status = '',
    //         course_sales = '';
    //       if (val['status_sales'] == null) {
    //         status = '無'
    //       } else {
    //         status = val['status_sales']
    //       }

    //       if (val['course_sales'] == null) {
    //         course_sales = '無'
    //       } else {
    //         course_sales = val['course_sales']
    //       }

    //       id_student = val['id_student'];
    //       data +=
    //         '<tr>' +
    //         '<td>' + val['created_at'] + '</td>' +
    //         '<td>' + status + '</td>' +
    //         '<td>' + course_sales + '</td>' +
    //         '</tr>'
    //     });

    //     $('#history_data_detail').html(data);

    //   },
    //   error: function(error) {
    //     console.log(JSON.stringify(error));
    //   }
    // });
  }

  // 聯絡狀況
  function contact_data() {
    $('#contact_data_detail').html('');
    $.ajax({
      type: 'POST',
      url: 'contact_data',
      dataType: 'json',
      data: {
        id_student: id_student_old
      },
      // async: false,
      success: function(data) {
        updatetime = '', remindtime = '', id_debt_status_payment_name = '', id_status = '', val_status = '', val_status_payment_name = ''
        var array_id_status = [],
          array_id_debt_status_payment_name = [],
          array_val_status_payment_name = [],
          array_val_status = []
        $.each(data, function(index, val) {
          opt1 = '', opt2 = '', opt3 = '', opt4 = '', opt5 = '', opt6 = '', opt7 = '';
          id = val['id'];

          // 付款狀態下拉ID
          id_debt_status_payment_name = 'debt_status_payment_name_' + id
          array_id_debt_status_payment_name.push("#" + id_debt_status_payment_name)

          // 最新狀態下拉ID
          id_status = id + '_status'
          array_id_status.push("#" + id_status)

          // 付款狀態Value
          val_status_payment_name = val['status_payment_name']
          array_val_status_payment_name.push(val['status_payment_name'])

          // 最新狀態Value
          val_status = val['id_status']
          array_val_status.push(val['id_status'])

          updatetime += "#new_starttime" + id + ','
          remindtime += "#remind" + id + ','
          var status_payment = '',
            contact = '',
            person = '';

          if (typeof(val['status_payment']) == 'object') {
            status_payment = ''
          } else {
            status_payment = val['status_payment']
          }

          if (val['contact'] != null) {
            contact = val['contact']
          }

          if (val['person'] != null) {
            person = val['person']
          }

          data +=
            '<tr>' +
            '<td><i class="fa fa-address-card " aria-hidden="true" onclick="debt_show(' + id + ');" style="cursor:pointer;padding-top: 20%;"></i></td>' +
            '<td><i class="fa fa-trash auth_hidden" aria-hidden="true" onclick="debt_delete(' + id + ');" style="cursor:pointer;padding-top: 40%; color:#eb6060"></i></td>' +
            '<td>' +
            '<div class="input-group date show_datetime" id="new_starttime' + id + '" data-target-input="nearest"> ' +
            ' <input type="text" onblur="save_student_data($(this),' + id + ',0);"  value="' + val['updated_at'] + '"   name="new_starttime' + id + '" class="form-control datetimepicker-input datepicker auth_readonly" data-target="#new_starttime' + id + '" data-toggle="datetimepicker" required/> ' +
            // ' <div class="input-group-append" data-target="#new_starttime' + id + '" data-toggle="datetimepicker"> ' +
            // ' <div class="input-group-text"><i class="fa fa-calendar"></i></div> ' +
            // '</div> ' +
            '</div>' +
            '</td>' +
            '<td>' + '<input type="text"  class="form-control auth_readonly" onblur="save_student_data($(this),' + id + ',6);" id="' + id + '_name_course" value="' + val['name_course'] + '" class="border-0 bg-transparent input_width">' + '</td>' +
            '<td>' + '<input type="text"  class="auth_readonly form-control" onblur="save_student_data($(this),' + id + ',1);" id="' + id + '_status_payment" value="' + status_payment + '" class="border-0 bg-transparent input_width">' + '</td>' +
            '<td>' + '<input type="text"  class=" auth_readonly form-control" onblur="save_student_data($(this),' + id + ',2);" id="' + id + '_contact" value="' + contact + '"  class="border-0 bg-transparent input_width">' + '</td>' +
            '<td style="width:15%;">' + '<div class="form-group show_select m-0"> <select id="' + id_debt_status_payment_name + '" onblur="save_student_data($(this),' + id + ',7);" class="auth_readonly custom-select border-0 bg-transparent input_width"> ' +
            '<option selected disabled value=""></option>' +
            '<option value="留單">留單</option>' +
            '<option value="完款">完款</option>' +
            '<option value="付訂">付訂</option>' +
            '<option value="退費">退費</option>' +
            '</select>' +
            '</div> </td>' +
            '<td style="width:15%;">' + '<div class="form-group show_select m-0"> <select id="' + id_status + '" onblur="save_student_data($(this),' + id + ',3);" class="auth_readonly custom-select border-0 bg-transparent input_width"> ' +
            '<option selected disabled value=""></option>' +
            '<option value="12">待追</option>' +
            '<option value="15">無意願</option>' +
            '<option value="16">推薦其他講師</option>' +
            '<option value="22">通知下一梯次</option>' +
            '</select>' +
            '</div> </td>' +
            '<td>' + '<input type="text"  class="auth_readonly form-control" onblur="save_student_data($(this),' + id + ',5);" id="' + id + '_person" value="' + person + '" class="border-0 bg-transparent input_width">' + '</td>' +
            '<td>' +
            '<div class="input-group date show_datetime" id="remind' + id + '" data-target-input="nearest"> ' +
            ' <input type="text" onblur="save_student_data($(this),' + id + ',4);"  value="' + val['remind_at'] + '"   name="remind' + id + '" class="auth_readonly form-control datetimepicker-input" data-target="#remind' + id + '" data-toggle="datetimepicker" required/> ' +
            // ' <div class="input-group-append" data-target="#remind' + id + '" data-toggle="datetimepicker"> ' +
            // ' <div class="input-group-text"><i class="fa fa-calendar"></i></div> ' +
            // '</div> ' +
            '</div>' +
            '</td>' +
            '</tr>'
        });
        $('#contact_data_detail').html(data);
        // 日期
        var iconlist = {
          time: 'fas fa-clock',
          date: 'fas fa-calendar',
          up: 'fas fa-arrow-up',
          down: 'fas fa-arrow-down',
          previous: 'fas fa-arrow-circle-left',
          next: 'fas fa-arrow-circle-right',
          today: 'far fa-calendar-check-o',
          clear: 'fas fa-trash',
          close: 'far fa-times'
        }
        $(updatetime.substring(0, updatetime.length - 1)).datetimepicker({
          format: "YYYY-MM-DD",
          icons: iconlist,
          defaultDate: new Date(),
          pickerPosition: "bottom-left"
        });
        $(remindtime.substring(0, remindtime.length - 1)).datetimepicker({
          format: "YYYY-MM-DD",
          icons: iconlist,
          defaultDate: new Date(),
          pickerPosition: "bottom-left"
        });

        /*付款狀態、最新狀態 - S*/

        // 付款狀態            
        $.each(array_id_debt_status_payment_name, function(index, val) {
          if (array_val_status_payment_name[index] != "") {
            $(array_id_debt_status_payment_name[index]).val(array_val_status_payment_name[index])
          } else {
            $(array_id_debt_status_payment_name[index]).val('')
          }
        })

        // 最新狀態
        $.each(array_id_status, function(index, val) {
          if (array_val_status[index] != "") {
            $(array_id_status[index]).val(array_val_status[index])
          } else {
            $(array_id_status[index]).val('')
          }
        })

        /*付款狀態、最新狀態 - E*/


        // 權限判斷 Rocky(2020/05/10)
        check_auth();
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }

  // 儲存
  function save() {
    student_name = $("#student_name").val();
    student_email = $("#student_email").val();
    student_profession = $("#student_profession").val();
    student_address = $("#student_address").val();
    sales_registration_old = $("#sales_registration_old").val();
    old_datasource = $("#old_datasource").val();
    student_phone = $("#student_phone").val();


    $.ajax({
      type: 'POST',
      url: 'student_save',
      data: {
        id_student: id_student_old,
        profession: student_profession,
        address: student_address,
        sales_registration_old: sales_registration_old,
        old_datasource: old_datasource,
        student_phone: student_phone,
        student_name: student_name,
        student_email: student_email
      },
      success: function(data) {
        if (data = "更新成功") {
          $("#success_alert_text").html("儲存成功");
          fade($("#success_alert"));
        } else {
          $("#error_alert_text").html("儲存失敗");
          fade($("#error_alert"));

        }
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }
  /* 完整內容 -E Rocky(2020/02/29 */


  /*聯絡狀況 - 新增 - S Rocky(2020/04/02)*/
  function debt_add() {
    var isValidForm = document.forms['form_debt'].checkValidity();
    if ($("#debt_course").val() == "" || $("#debt_person").val() == "") {
      alert('請填寫追單課程 / 追單人員');
      return false;
    } else {
      if (isValidForm) {
        debt_date = $("#debt_date").val();
        debt_course = $("#debt_course").val();
        debt_status_date = $("#debt_status_date").val();
        debt_contact = $("#debt_contact").val();
        debt_status = $("#debt_status").val();
        debt_status_payment_name = $("#debt_status_payment_name").val();
        debt_person = $("#debt_person").val();
        debt_remind = $("#debt_remind").val();
        id_student = id_student_old;

        $.ajax({
          type: 'POST',
          url: 'debt_save',
          data: {
            id_student: id_student,
            debt_date: debt_date,
            debt_course: debt_course,
            debt_status_date: debt_status_date,
            debt_contact: debt_contact,
            debt_status: debt_status,
            debt_status_payment_name: debt_status_payment_name,
            debt_person: debt_person,
            debt_remind: debt_remind
          },
          success: function(data) {
            if (data = "儲存成功") {
              contact_data();
              $("#success_alert_text").html("儲存成功");
              fade($("#success_alert"));
              $("#save_contact").modal('hide');
            } else {
              $("#error_alert_text").html("儲存失敗");
              fade($("#error_alert"));
            }
          },
          error: function(error) {
            console.log(JSON.stringify(error));
          }
        });
      } else {
        return false;
      }
    }
  }
  /*聯絡狀況 - 新增 - E*/

  /*聯絡狀況 - 刪除 - S Rocky(2020/04/02)*/
  function debt_delete(id) {
    var msg = "是否刪除此筆資料?";
    if (confirm(msg) == true) {
      $.ajax({
        type: 'POST',
        url: 'debt_delete',
        data: {
          id: id
        },
        success: function(data) {
          if (data = "刪除成功") {
            contact_data();
            $("#success_alert_text").html("刪除成功");
            fade($("#success_alert"));
          } else {
            $("#error_alert_text").html("刪除失敗");
            fade($("#error_alert"));
          }
        },
        error: function(error) {
          console.log(JSON.stringify(error));
        }
      });
    } else {
      return false;
    }
  }
  /*聯絡狀況 - 刪除 - E*/

  /*聯絡狀況 - 顯示 - S Rocky(2020/04/21)*/
  function debt_show(id) {
    $("#show_contact").modal('show');
    $.ajax({
      type: 'POST',
      url: 'debt_show',
      data: {
        id: id
      },
      success: function(data) {
        $("#lbl_debt_date").text(data[0]['updated_at']);
        $("#lbl_debt_course").text(data[0]['name_course']);
        $("#lbl_debt_status_date").text(data[0]['status_payment']);
        $("#lbl_debt_contact").text(data[0]['contact']);
        $("#status_payment_name").text(data[0]['status_payment_name']);
        $("#lbl_debt_status").text(data[0]['status_name']);
        $("#lbl_debt_person").text(data[0]['person']);
        $("#lbl_debt_remind").text(data[0]['remind_at']);
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }
  /*聯絡狀況 - 顯示 - E*/



  /* 自動儲存 - S Rocky(2020/03/08) */

  // 日期
  function update_time(data, id, type) {
    // console.log(data.val()) 
    save_student_data(data.val(), id, type)
  }
  // 付款狀態 / 日期
  function status_payment(data, id, type) {
    save_student_data(data.val(), id, type)
  }

  // 聯絡內容
  function contact(data, id, type) {
    save_student_data(data.val(), id, type)
  }

  // 最新狀態
  function status(data, id, type) {
    save_student_data(data.val(), id, type)
  }
  // 提醒
  function remind(data, id, type) {
    save_student_data(data.val(), id, type)
  }

  // 追單人員
  function person(data, id, type) {
    save_student_data(data.val(), id, type)
  }

  // 追單課程
  function name_course(data, id, type) {
    save_student_data(data.val(), id, type)
  }

  function save_student_data(data, id, type) {
    $.ajax({
      type: 'POST',
      url: 'contact_data_save',
      data: {
        id: id,
        type: type,
        data: data.val()
      },
      success: function(data) {
        // console.log(data);

        /** alert **/
        $("#success_alert_text").html("資料儲存成功");
        fade($("#success_alert"));
      },
      error: function(jqXHR) {
        console.log(JSON.stringify(jqXHR));

        /** alert **/
        $("#error_alert_text").html("資料儲存失敗");
        fade($("#error_alert"));
      }
    });
  }

  /* 自動儲存 - E Rocky(2020/03/08) */

  /*學員修改基本資料button*/
  var basic_input = document.getElementsByClassName("basic-inf");
  var i;




  /* 完款後寄出報名成功訊息 Sandy(2020/05/13) */
  // function sendMsg(id){
  //   $.ajax({
  //     type:'POST',
  //     url:'course_return_sendmsg',
  //     data:{
  //       id: id
  //     },
  //     success:function(res){
  //       console.log(res);  

  //       // if( res['status'] == 'success' && res['AccountPoint'] != null){
  //       //   /** alert **/
  //       //   $("#success_alert_text").html("寄送成功，簡訊餘額尚有" + res['AccountPoint'] + "。");
  //       //   fade($("#success_alert"));

  //       //   $('button').prop('disabled', 'disabled');
  //       //   setTimeout( function(){location.href="{{URL::to('message')}}"}, 3000);
  //       // }else if( res['status'] == 'success' ){
  //       //   /** alert **/ 
  //       //   $("#success_alert_text").html("寄送成功。");
  //       //   fade($("#success_alert"));    

  //       //   $('button').prop('disabled', 'disabled');
  //       //   setTimeout( function(){location.href="{{URL::to('message')}}"}, 3000);
  //       // }else if( res['status'] == 'error' && typeof(res['msg']) != "undefined"){
  //       //   /** alert **/ 
  //       //   $("#error_alert_text").html("寄送失敗，" + res['msg'] + "。");
  //       //   fade($("#error_alert"));    

  //       //   $('#sendMessageBtn').html('立即傳送');
  //       //   $('#sendMessageBtn').prop('disabled', false);
  //       // }else if( res['status'] == 'error' ){
  //       //   /** alert **/ 
  //       //   $("#error_alert_text").html("寄送失敗。");
  //       //   fade($("#error_alert"));   

  //       //   $('#sendMessageBtn').html('立即傳送');
  //       //   $('#sendMessageBtn').prop('disabled', false); 
  //       // }else{
  //       //   /** alert **/ 
  //       //   $("#error_alert_text").html("寄送失敗。");
  //       //   fade($("#error_alert"));   

  //       //   $('#sendMessageBtn').html('立即傳送');
  //       //   $('#sendMessageBtn').prop('disabled', false); 
  //       // }

  //     },
  //     error: function(jqXHR, textStatus, errorMessage){
  //         console.log("error: "+ errorMessage);    
  //         console.log(jqXHR);
  //         $(this).html('立即傳送');
  //         $(this).prop('disabled', false);
  //     }
  //   });
  // }
  /* 完款後寄出報名成功訊息 Sandy(2020/05/13) */
</script>
@endsection