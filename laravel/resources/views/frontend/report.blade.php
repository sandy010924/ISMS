@extends('frontend.layouts.master')

@section('title', '數據報表')
@section('header', '數據報表')

@section('content')
<!-- Content Start -->
  <!--場次數據頁面內容-->

  <div class="card m-3">
    <div class="row" style="padding:10px;">
      <div class="col-4" style=" display: flex;justify-content: center;">
        {{-- <h4 style="width:150px;">日期區間:</h4>
        <input type="text" class="w-100 form-control p-0" name="daterange" id="input_date"> --}}
      
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">日期區間</span>
          </div>
          <input type="text" class="form-control px-3" name="daterange" id="input_date" autocomplete="false"> 
        </div>
      </div>
      <ul id="reportTab" class="nav nav-pills nav-fill col-8">
        <li class="nav-item">
          <a class="nav-link active" data-nav="list">名單數據</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-nav="check">報到率</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-nav="deal">成交率</a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" href="#">退費</a>
        </li> --}}
        <li class="nav-item">
          <a class="nav-link" data-nav="income">營業額</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-nav="cost">單場成本</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="collapse show" id="dev_condition1" data-item="1" name="condition">
    <div class="card m-3">
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5>第一組</h5>
          </div>
          <div class="col">
            <select  class="form-control" name="item1" data-select="itemTeacher">
              <option value="0" selected>所有老師</option>
              @foreach($teacher as $data)
                <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <select  class="form-control" name="item1" data-select="itemType">
              <option value="0" selected>所有類型</option>
              <option value="1">銷講</option>
              <option value="2">二階</option>
              <option value="3">三階</option>
            </select>
          </div>
          <div class="col">
            {{-- <select  class="form-control itemSource" name="item1" data-select="itemSource">
              <option value="0" selected>所有來源</option>
              @foreach($source as $data)
                <option value="{{ $data['datasource'] }}">{{ $data['datasource'] }}</option>
              @endforeach
            </select> --}}
            {{-- <select multiple class="selectpicker form-control itemSource" data-actions-box="true" name="item1" id="select_source" data-select="itemSource" value="0"> --}}
            <select class="form-control js-example-basic-multiple itemSource bootstrap_multipleSelect" multiple="multiple" name="item1" data-select="itemSource">
              @foreach($source as $data)
                <option value="{{ $data['datasource'] }}">{{ $data['datasource'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <select class="form-control itemAction" name="item1" data-select="itemAction">
              <option value="0" selected>所有動作</option>
              <option value="4">報到</option>
              <option value="5">取消</option>
              <option value="3">未到</option>
            </select>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col">
            <select class="custom-select" name="item1" data-select="itemCity">
              <option value="0" selected>所有地區</option>
              @foreach($city as $data)
                <option value="{{ $data }}">{{ $data }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <select  class="form-control" name="item1" data-select="itemTime">
              <option value="0" selected>所有時段</option>
              <option value="上午">上午</option>
              <option value="下午">下午</option>
              <option value="晚上">晚上</option>
              <option value="整天">整天</option>
            </select>
          </div>
          <div class="col">
            <select  class="form-control itemPay" name="item1" data-select="itemPay" disabled>
              <option class="itemPay_income" value="0">完款+付訂</option>
              <option class="itemPay_deal" value="現場完款">現場完款</option>
              <option class="itemPay_income" value="7">完款</option>
              <option class="itemPay_income" value="8">付訂</option>
              <option class="itemPay_income" value="9">退費</option>
              <option class="itemPay_deal" value="現場完款+付訂">現場完款+付訂</option>
              <option class="itemPay_deal" value="追完款">追完款</option>
            </select>
          </div>
          <div class="col">
            <select  class="form-control itemCost" name="item1" data-select="itemCost" disabled>
              <option value="0" selected>所有費用</option>
              <option value="cost_events">場地費</option>
              <option value="cost_ad">廣告費</option>
              <option value="cost_message">訊息費</option>
            </select>
          </div>
          <div class="col">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#dev_condition2" aria-expanded="false" aria-controls="dev_condition2">
              <i id="firstCondition" class="fa fa-plus" aria-hidden="true"></i> 增加比較
            </button>
            <button id="searchBtn" type="button" class="btn btn-outline-secondary float-right">搜尋</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 條件篩選器2 -->
  <div class="collapse" id="dev_condition2" data-item="2" name="condition">
    <div class="card m-3">
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5>第二組</h5>
          </div>
          <div class="col">
            <select  class="form-control" name="item2" data-select="itemTeacher">
              <option value="0" selected>所有老師</option>
              @foreach($teacher as $data)
                <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <select  class="form-control" name="item2" data-select="itemType">
              <option value="0" selected>所有類型</option>
              <option value="1">銷講</option>
              <option value="2">二階</option>
              <option value="3">三階</option>
            </select>
          </div>
          <div class="col">
            {{-- <select  class="form-control itemSource" name="item2" data-select="itemSource">
              <option value="0" selected>所有來源</option>
              @foreach($source as $data)
                <option value="{{ $data['datasource'] }}">{{ $data['datasource'] }}</option>
              @endforeach
            </select> --}}
            <select class="form-control js-example-basic-multiple itemSource bootstrap_multipleSelect" multiple="multiple" name="item2" data-select="itemSource">
              @foreach($source as $data)
                <option value="{{ $data['datasource'] }}">{{ $data['datasource'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <select class="form-control itemAction" name="item2" data-select="itemAction">
              <option value="0" selected>所有動作</option>
              <option value="4">報到</option>
              <option value="5">取消</option>
              <option value="3">未到</option>
            </select>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col">
            <select class="custom-select" name="item2" data-select="itemCity">
              <option value="0" selected>所有地區</option>
              @foreach($city as $data)
                <option value="{{ $data }}">{{ $data }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <select  class="form-control" name="item2" data-select="itemTime">
              <option value="0" selected>所有時段</option>
              <option value="上午">上午</option>
              <option value="下午">下午</option>
              <option value="晚上">晚上</option>
              <option value="整天">整天</option>
            </select>
          </div>
          <div class="col">
            <select  class="form-control itemPay" name="item2" data-select="itemPay" disabled>
              <option class="itemPay_income" value="0">完款+付訂</option>
              <option class="itemPay_deal" value="現場完款">現場完款</option>
              <option class="itemPay_income" value="7">完款</option>
              <option class="itemPay_income" value="8">付訂</option>
              <option class="itemPay_income" value="9">退費</option>
              <option class="itemPay_deal" value="現場完款+付訂">現場完款+付訂</option>
              <option class="itemPay_deal" value="追完款">追完款</option>
            </select>
          </div>
          <div class="col">
            <select  class="form-control itemCost" name="item2" data-select="itemCost" disabled>
              <option value="0" selected>所有費用</option>
              <option value="cost_events">場地費</option>
              <option value="cost_ad">廣告費</option>
              <option value="cost_message">訊息費</option>
            </select>
          </div>
          <div class="col">
          <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#dev_condition3" aria-expanded="false" aria-controls="dev_condition3">
            <i class="fa fa-plus" aria-hidden="true"></i> 增加比較
          </button>
          <button type="button" class="close" style="font-size:30px;color:red" aria-label="Close" data-toggle="collapse" data-target="#dev_condition2" aria-expanded="false" aria-controls="dev_condition2">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 條件篩選器3 -->
  <div class="collapse" id="dev_condition3" data-item="3" name="condition">
    <div class="card m-3">
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5>第三組</h5>
          </div>
          <div class="col">
            <select  class="form-control" name="item3" data-select="itemTeacher">
              <option value="0" selected>所有老師</option>
              @foreach($teacher as $data)
                <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <select  class="form-control" name="item3" data-select="itemType">
              <option value="0" selected>所有類型</option>
              <option value="1">銷講</option>
              <option value="2">二階</option>
              <option value="3">三階</option>
            </select>
          </div>
          <div class="col">
            {{-- <select  class="form-control itemSource" name="item3" data-select="itemSource">
              <option value="0" selected>所有來源</option>
              @foreach($source as $data)
                <option value="{{ $data['datasource'] }}">{{ $data['datasource'] }}</option>
              @endforeach
            </select> --}}
            <select class="form-control js-example-basic-multiple itemSource bootstrap_multipleSelect" multiple="multiple" name="item3" data-select="itemSource">
              @foreach($source as $data)
                <option value="{{ $data['datasource'] }}">{{ $data['datasource'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <select class="form-control itemAction" name="item3" data-select="itemAction">
              <option value="0" selected>所有動作</option>
              <option value="4">報到</option>
              <option value="5">取消</option>
              <option value="3">未到</option>
            </select>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col">
            <select class="custom-select" name="item3" data-select="itemCity">
              <option value="0" selected>所有地區</option>
              @foreach($city as $data)
                <option value="{{ $data }}">{{ $data }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <select  class="form-control" name="item3" data-select="itemTime">
              <option value="0" selected>所有時段</option>
              <option value="上午">上午</option>
              <option value="下午">下午</option>
              <option value="晚上">晚上</option>
              <option value="整天">整天</option>
            </select>
          </div>
          <div class="col">
            <select  class="form-control itemPay" name="item3" data-select="itemPay" disabled>
              <option class="itemPay_income" value="0">完款+付訂</option>
              <option class="itemPay_deal" value="現場完款">現場完款</option>
              <option class="itemPay_income" value="7">完款</option>
              <option class="itemPay_income" value="8">付訂</option>
              <option class="itemPay_income" value="9">退費</option>
              <option class="itemPay_deal" value="現場完款+付訂">現場完款+付訂</option>
              <option class="itemPay_deal" value="追完款">追完款</option>
            </select>
          </div>
          <div class="col">
            <select  class="form-control itemCost" name="item3" data-select="itemCost" disabled>
              <option value="0" selected>所有費用</option>
              <option value="cost_events">場地費</option>
              <option value="cost_ad">廣告費</option>
              <option value="cost_message">訊息費</option>
            </select>
          </div>
          <div class="col">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#dev_condition4" aria-expanded="false" aria-controls="dev_condition4">
              <i class="fa fa-plus" aria-hidden="true"></i> 增加比較
            </button>
            <button type="button" class="close" style="font-size:30px;color:red" aria-label="Close" data-toggle="collapse" data-target="#dev_condition3" aria-expanded="false" aria-controls="dev_condition3">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 條件篩選器4 -->
  <div class="collapse" id="dev_condition4" data-item="4" name="condition">
    <div class="card m-3">
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5>第四組</h5>
          </div>
          <div class="col">
            <select  class="form-control" name="item4" data-select="itemTeacher">
              <option value="0" selected>所有老師</option>
              @foreach($teacher as $data)
                <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <select  class="form-control" name="item4" data-select="itemType">
              <option value="0" selected>所有類型</option>
              <option value="1">銷講</option>
              <option value="2">二階</option>
              <option value="3">三階</option>
            </select>
          </div>
          <div class="col">
            {{-- <select  class="form-control itemSource" name="item4" data-select="itemSource">
              <option value="0" selected>所有來源</option>
              @foreach($source as $data)
                <option value="{{ $data['datasource'] }}">{{ $data['datasource'] }}</option>
              @endforeach
            </select> --}}
            <select class="form-control js-example-basic-multiple itemSource bootstrap_multipleSelect" multiple="multiple" name="item4" data-select="itemSource">
              @foreach($source as $data)
                <option value="{{ $data['datasource'] }}">{{ $data['datasource'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <select class="form-control itemAction" name="item4" data-select="itemAction">
              <option value="0" selected>所有動作</option>
              <option value="4">報到</option>
              <option value="5">取消</option>
              <option value="3">未到</option>
            </select>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col">
            <select class="custom-select" name="item4" data-select="itemCity">
              <option value="0" selected>所有地區</option>
              @foreach($city as $data)
                <option value="{{ $data }}">{{ $data }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <select  class="form-control" name="item4" data-select="itemTime">
              <option value="0" selected>所有時段</option>
              <option value="上午">上午</option>
              <option value="下午">下午</option>
              <option value="晚上">晚上</option>
              <option value="整天">整天</option>
            </select>
          </div>
          <div class="col">
            <select  class="form-control itemPay" name="item4" data-select="itemPay" disabled>
              <option class="itemPay_income" value="0">完款+付訂</option>
              <option class="itemPay_deal" value="現場完款">現場完款</option>
              <option class="itemPay_income" value="7">完款</option>
              <option class="itemPay_income" value="8">付訂</option>
              <option class="itemPay_income" value="9">退費</option>
              <option class="itemPay_deal" value="現場完款+付訂">現場完款+付訂</option>
              <option class="itemPay_deal" value="追完款">追完款</option>
            </select>
          </div>
          <div class="col">
            <select  class="form-control itemCost" name="item4" data-select="itemCost" disabled>
              <option value="0" selected>所有費用</option>
              <option value="cost_events">場地費</option>
              <option value="cost_ad">廣告費</option>
              <option value="cost_message">訊息費</option>
            </select>
          </div>
          <div class="col">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#dev_condition5" aria-expanded="false" aria-controls="dev_condition5">
              <i class="fa fa-plus" aria-hidden="true"></i> 增加比較
            </button>
            <button type="button" class="close" style="font-size:30px;color:red" aria-label="Close" data-toggle="collapse" data-target="#dev_condition4" aria-expanded="false" aria-controls="dev_condition4">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 條件篩選器5 -->
  <div class="collapse" id="dev_condition5" data-item="5" name="condition">
    <div class="card m-3">
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5>第五組</h5>
          </div>
          <div class="col">
            <select  class="form-control" name="item5" data-select="itemTeacher">
              <option value="0" selected>所有老師</option>
              @foreach($teacher as $data)
                <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <select  class="form-control" name="item5" data-select="itemType">
              <option value="0" selected>所有類型</option>
              <option value="1">銷講</option>
              <option value="2">二階</option>
              <option value="3">三階</option>
            </select>
          </div>
          <div class="col">
            {{-- <select  class="form-control itemSource" name="item5" data-select="itemSource">
              <option value="0" selected>所有來源</option>
              @foreach($source as $data)
                <option value="{{ $data['datasource'] }}">{{ $data['datasource'] }}</option>
              @endforeach
            </select> --}}
            <select class="form-control js-example-basic-multiple itemSource bootstrap_multipleSelect" multiple="multiple" name="item5" data-select="itemSource">
              @foreach($source as $data)
                <option value="{{ $data['datasource'] }}">{{ $data['datasource'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <select class="form-control itemAction" name="item5" data-select="itemAction">
              <option value="0" selected>所有動作</option>
              <option value="4">報到</option>
              <option value="5">取消</option>
              <option value="3">未到</option>
            </select>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col">
            <select class="custom-select" name="item5" data-select="itemCity">
              <option value="0" selected>所有地區</option>
              @foreach($city as $data)
                <option value="{{ $data }}">{{ $data }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <select  class="form-control" name="item5" data-select="itemTime">
              <option value="0" selected>所有時段</option>
              <option value="上午">上午</option>
              <option value="下午">下午</option>
              <option value="晚上">晚上</option>
              <option value="整天">整天</option>
            </select>
          </div>
          <div class="col">
            <select  class="form-control itemPay" name="item5" data-select="itemPay" disabled>
              <option class="itemPay_income" value="0">完款+付訂</option>
              <option class="itemPay_deal" value="現場完款">現場完款</option>
              <option class="itemPay_income" value="7">完款</option>
              <option class="itemPay_income" value="8">付訂</option>
              <option class="itemPay_income" value="9">退費</option>
              <option class="itemPay_deal" value="現場完款+付訂">現場完款+付訂</option>
              <option class="itemPay_deal" value="追完款">追完款</option>
            </select>
          </div>
          <div class="col">
            <select  class="form-control itemCost" name="item5" data-select="itemCost" disabled>
              <option value="0" selected>所有費用</option>
              <option value="cost_events">場地費</option>
              <option value="cost_ad">廣告費</option>
              <option value="cost_message">訊息費</option>
            </select>
          </div>
          <div class="col">
            <button type="button" class="close" style="font-size:30px;color:red" aria-label="Close" data-toggle="collapse" data-target="#dev_condition5" aria-expanded="false" aria-controls="dev_condition5">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 圖表 -->
  <div id="reportChart" class="card m-3" style="display: none">
    <div class="card-body">
      <button class="btn btn-dark" type="button" data-toggle="collapse" data-target="#model_show_log" aria-expanded="false" aria-controls="model_show_log">
            <i class="fa fa-search" aria-hidden="true"></i>查看/隱藏搜尋條件
      </button>
      <div class="row">
        <div class="col-12">
            <div class="collapse show" id="model_show_log" style="padding-top:15px;">
              <div class="card card-body h6" id="show_log">
              </div>
            </div>
          </div>
      </div>
      <div class="row">
        <div style="width: 70%; height: 70%; margin:10px;">
            <canvas id="myChart" width="100" height="50"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- 表格 -->
  <div id="reportTable" class="card m-3" style="display: none">
    <div class="card-body">
       {{-- @component('components.datatable')
          @slot('thead')
            <tr>
              <th></th>
            </tr>
          @endslot
          @slot('tbody')
            <tr>
              <td></td>
            </tr>
          @endslot
        @endcomponent --}}
    </div>
  </div>


  <style>
    /* .nav-link.active {

    } */
      
    div.dt-buttons {
      float: left;
    }

    #reportTable table tr{
      white-space: nowrap; 
   }
  </style>

  <!-- Content End -->
  <script src="{{ asset('js/Chart.min.js') }}"></script>
  <script src="{{ asset('js/report.js') }}"></script>
  <script>
    var startDate = moment(new Date()).format("YYYY-MM-DD")
    var endDate = moment(new Date()).format("YYYY-MM-DD")
    var chartLineColor = ['#3e95cd','#e83131','#0dd168', '#f70fe0', '#f58300'];
    var table, lineChart;
    
    /* Datatable.js file name Sandy(2020/08/02) - S */
    var today = moment(new Date()).format("YYYYMMDD");
    var title = today + '_數據報表';
    /* Datatable.js file name Sandy(2020/08/02) - E */

    $(document).ready(function () {

      $('input[name="daterange"]').daterangepicker({
        // autoUpdateInput: false,
        locale: {
          format: 'YYYY-MM-DD',
          separator: ' ~ ',
          applyLabel: '選擇',
          cancelLabel: '取消',
        }
      },function(start, end) {
        // console.log("Callback has been called!");
        // $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
        startDate = start.format('YYYY-MM-DD 00:00:00');
        endDate = end.format('YYYY-MM-DD 24:00:00');
      });

      // 上方link 選取狀態切換
      $('#reportTab .nav-item>a').on('click', function(e) {
        e.preventDefault();
        $('#reportTab .nav-link').removeClass('active')
        $(this).addClass('active');

        // if($(this).text() == "營業額" || $(this).text() == "成交率"){
        //   $('.itemPay').prop('disabled',false);
        // }else{
        //   $('.itemPay').prop('disabled', 'disabled');
        // }
        if($(this).text() == "營業額" || $(this).text() == "成交率"){
          $('.itemPay').prop('disabled',false);
          $('.itemPay option').attr('selected', false);
          if($(this).text() == "營業額"){
            $('.itemPay .itemPay_income').show();
            for(var i=1; i<6; i++){
              $('.itemPay[name="item' + i + '"] .itemPay_income').first().attr('selected', 'selected');
            }
            $('.itemPay .itemPay_deal').hide();
          }else if($(this).text() == "成交率"){
            $('.itemPay .itemPay_deal').show();
            for(var i=1; i<6; i++){
              $('.itemPay[name="item' + i + '"] .itemPay_deal').first().attr('selected', 'selected');
            }
            $('.itemPay .itemPay_income').hide();
          }
        }else{
          $('.itemPay').prop('disabled', 'disabled');
        }

        if($(this).text() == "單場成本"){
          $('.itemCost').prop('disabled',false);
          $('.itemSource').prop('disabled', 'disabled');
        }else{
          $('.itemCost').prop('disabled', 'disabled');
          $('.itemSource').prop('disabled', false);
        }

        if($(this).text() == "名單數據"){
          $('.itemAction').prop('disabled', false);
        }else{
          $('.itemAction').prop('disabled', 'disabled');
        }
      });

      //select2 講師及來源、地區下拉式搜尋 Sandy(2020/04/14)
      $(".bootstrap_multipleSelect").select2({
          width: 'resolve', // need to override the changed default
          theme: 'bootstrap',
          placeholder: "所有來源",
      });
      $.fn.select2.defaults.set( "theme", "bootstrap" );


      // // //來源多選 Sandy(2020/07/06)
      // $(".itemSource").selectpicker({
      //   noneSelectedText: '所有來源' //預設顯示內容
      // });


    // 圖表設定
    var ctx = document.getElementById('myChart').getContext('2d');
    lineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: [],
    },
      options: {
        scales: {
            yAxes: [{
                scaleLabel: { 
                  display: true,
                  labelString: '',
                  fontSize: 14,
                  fontFamily: '微軟正黑體',
                },
                ticks: {
                    beginAtZero: false,
                    callback: function (value, index, values) {
                        // return value.toLocaleString()+'%';
                        return value.toLocaleString();
                    },
                    fontFamily: '微軟正黑體',
                    fontSize: 16,
                    stepSize: 20,
                    min: 0, 
                },
                // stacked: true
            }],
            xAxes: [{
                type: 'time',
                time: {
                    displayFormats: {
                        quarter: 'YYYY/MM/DD'
                    },
                    // unit: 'day',
                    // unitStepSize: 1,
                },
                // scaleLabel: { display: true },
                ticks: {
                    beginAtZero: false,
                    callback: function (value, index, values) {
                        // return value.toLocaleString()+'%';
                        return value.toLocaleString();
                    },
                    fontFamily: '微軟正黑體',
                    fontSize: 16,
                }
            }]
        },
        title: {
            display: true,
            text: $("ul#reportTab li a.active").text(),
            fontSize: 20,
            fontFamily: "Microsoft JhengHei",
        },
        tooltips: {
            displayColors: false,
            titleFontSize: 16,
            titleFontFamily: "Microsoft JhengHei",
            bodyFontSize: 16,
            bodyFontFamily: "Microsoft JhengHei",
            hover: { mode: 'point' },
            callbacks: {
                // label: function (tooltipItem, data) {
                //     const dataset = data.datasets[tooltipItem.datasetIndex];
                //     // console.log(dataset)
                //     // 計算總和
                //     // const sum = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                //     //   return previousValue + currentValue;
                //     // });
                //     const currentValue = dataset.data[tooltipItem.index];
                //     const { y, x, course } = currentValue
                //     // console.log(currentValue)
                //     // return " " + data.labels[tooltipItem.index] + ":" + currentValue  + "%";
                //     // return " " + data.labels[tooltipItem.index] + ":" + currentValue  + "%";
                //     // return [x, position, '', `${position}: ${y}`];
                //     return [x, `${course}`, '', `${$("ul#reportTab li a.active").text()}: ${y}`];
                // },
                // title: function (tooltipItem, data) {
                //     return;
                // }
            }
        },
        legend: {
            display: true,
            position: 'top',
            labels: {
                padding: 20,
                boxWidth: 80,
                fontSize: 18,
                fontColor: 'black',
                fontFamily: 'Microsoft JhengHei',
            }
        }
      }
    });



      // 圖表click事件
      /*
      var canvas = document.getElementById("myChart");
      canvas.onclick = function(evt) {
        var activePoints = lineChart.getElementsAtEvent(evt);
        if (activePoints[0]) {
          var chartData = activePoints[0]['_chart'].config.data;
          var idx = activePoints[0]['_index'];

          var label = chartData.labels[idx];
          var value = chartData.datasets[0].data[idx];

          var url = "http://example.com/?label=" + label + "&value=" + value;
          console.log(url);
          // alert(url);
          window.open("https://www.google.com.tw/", "_blank")
        }
      };
      */


  });


      
  /* 搜尋按鈕click */
  $('#searchBtn').click(function(){
    
    //抓出條件區塊
    var collapse = [];
    $('[name="condition"].collapse.show').each(function() {
        // Get clicked element that initiated the collapse...
        collapse.push($(this).data('item'));
    });
    // console.log(collapse);
    
    var item = new Array();
    var log = new Array();

    //抓出項目
    for(var i = 0 ; i < collapse.length ; i++ ){
      item[i] = new Array();
      log[i] = new Array();

      $('select[name="item' + collapse[i] +'"]').each(function() {
        // return($(this).val());
        // item1.push($(this).parent().data('item'));
        // item[i][$(this).parent().data('select')] = $(this).val();

        if($(this).data('select') == "itemSource"){
          //判斷來源是否為空值，是則預設選項為所有來源
          if($(this).val() == ""){
            item[i].push(0);
            if($(this).is(":enabled")){
              log[i].push("所有來源");
            }
          }else{
            var txt = "";
            $(this).find('option:selected').each(function(i, selected) {
              if( i == 0 ){
                txt += $(selected).text();
              }else{
                txt += "、" + $(selected).text();
              }
            });
            item[i].push($(this).val());
            
            if($(this).is(":enabled")){
              log[i].push(txt);
            }
          }
        }else{
          item[i].push($(this).val());
          
          if($(this).is(":enabled")){
            log[i].push($(this).find('option:selected').text());
          }
        }
      });
    }
    // console.log(log);

    //條件log顯示
    var str = "";
    var chNum = new Array("一", "二", "三", "四", "五");
    for( var i = 0 ; i < log.length ; i++ ){
      if( i != 0 ){
        str += "<br>";
      }
      str += "第"+ chNum[collapse[i]-1] + "組：" + log[i];
    }

    $('#show_log').html(str);
    
    // console.log(endDate);

    // console.log($("ul#reportTab a.active").data('nav'));

    $.ajax({
      type:'GET',
      url:'report_search',
      // dataType: 'json',
      data:{
        nav: $("ul#reportTab a.active").data('nav'),
        startDate: startDate,
        endDate: endDate,
        item: item
      },
      success:function(res){
          // console.log(res);  
          
          //圖表x軸
          // lineChart.data.labels = res['labelDate'];

          //圖表重設
          lineChart.data.datasets = [];

          // if($("ul#reportTab a.active").data('nav') == "check" || $("ul#reportTab a.active").data('nav') == "deal"){
          //   lineChart.config.options.scales.yAxes[0].ticks.stepSize = 100;
          // }else if($("ul#reportTab a.active").data('nav') == "income" || $("ul#reportTab a.active").data('nav') == "cost"){
          //   lineChart.config.options.scales.yAxes[0].ticks.stepSize = 2000;
          // }else{
          //   lineChart.config.options.scales.yAxes[0].ticks.stepSize = 20;
          // }

          //圖表title
          lineChart.config.options.title.text = $("ul#reportTab a.active").text();

          //y軸title
          lineChart.config.options.scales.yAxes[0].scaleLabel.labelString = $("ul#reportTab a.active").text();

          //判斷結算數量|金額|百分比
          var settle = "";

          //y軸距差、tooltips內容
          switch ($("ul#reportTab a.active").data('nav')) {
            case 'list':
              //名單數據
              lineChart.config.options.scales.yAxes[0].ticks.stepSize = 20;
              lineChart.config.options.tooltips.callbacks.label = function(tooltipItem, data) {
                const dataset = data.datasets[tooltipItem.datasetIndex];
                const currentValue = dataset.data[tooltipItem.index];
                const { y, x, course } = currentValue
                // return [x, course, '', `${$("ul#reportTab li a.active").text()}: ${y}`];
                return course;
              };

              settle = "amount";

              break;
            case 'check':
              //報到率
              lineChart.config.options.scales.yAxes[0].ticks.stepSize = 100;
              lineChart.config.options.tooltips.callbacks.label = function(tooltipItem, data) {
                const dataset = data.datasets[tooltipItem.datasetIndex];
                const currentValue = dataset.data[tooltipItem.index];
                const { y, x, course } = currentValue
                // return [x, `${course}`, '', `${$("ul#reportTab li a.active").text()}: ${y}%`];
                return course;
              };

              settle = "rate";

              break;
            case 'deal':
              //成交率
              lineChart.config.options.scales.yAxes[0].ticks.stepSize = 100;
              lineChart.config.options.tooltips.callbacks.label = function(tooltipItem, data) {
                const dataset = data.datasets[tooltipItem.datasetIndex];
                const currentValue = dataset.data[tooltipItem.index];
                const { y, x, course } = currentValue
                // return [x, `${course}`, '', `${$("ul#reportTab li a.active").text()}: ${y}%`];
                return course;
              };

              settle = "rate";

              break;
            case 'income':
              //營業額
              lineChart.config.options.scales.yAxes[0].ticks.stepSize = 50000;
              lineChart.config.options.tooltips.callbacks.label = function(tooltipItem, data) {
                const dataset = data.datasets[tooltipItem.datasetIndex];
                const currentValue = dataset.data[tooltipItem.index];
                const { y, x, course } = currentValue
                // return [x, `${course}`, '', `${$("ul#reportTab li a.active").text()}: ${y}`];
                return course;
              };

              settle = "money";

              break;
            case 'cost':
              //單場成本
              lineChart.config.options.scales.yAxes[0].ticks.stepSize = 50000;
              lineChart.config.options.tooltips.callbacks.label = function(tooltipItem, data) {
                const dataset = data.datasets[tooltipItem.datasetIndex];
                const currentValue = dataset.data[tooltipItem.index];
                const { y, x, course } = currentValue
                // return [x, `${course}`, '', `${$("ul#reportTab li a.active").text()}: ${y}`];
                return course;
              };

              settle = "money";

              break;
            default:
              // lineChart.config.options.scales.yAxes[0].ticks.stepSize = 100;
              // lineChart.config.options.tooltips.callbacks.label = function(tooltipItem, data) {
              //   const dataset = data.datasets[tooltipItem.datasetIndex];
              //   const currentValue = dataset.data[tooltipItem.index];
              //   const { y, x, course } = currentValue
              //   // return [x, `${course}`, '', `${$("ul#reportTab li a.active").text()}: ${y}`];
              //   return course;
              // };
              break;
          }


          //datatable Layout
          var tableLayout = `<div id="datatableDiv">
            <div class="table-responsive">
              <table id="table_list" name="table_list" class="table table-striped table-sm text-center border rounded-lg datatable">
                <thead id="tableHead">
                  <tr></tr>
                </thead>
                <tbody id="tableBody">
                  <tr></tr>
                </tbody>
              </table>
            </div>
          </div>`;

          $('#reportTable .card-body').html(tableLayout);


          //表格標頭
          var tableHead = "<th></th>";
          var tableBody = "";
          for( var i = 0 ; i < res['labelDate'].length ; i++ ){
            tableHead += "<th>" + res['labelDate'][i] + "</th>";
          }
          //完全無資料
          if(res['labelDate'].length == 0){
            tableHead += "<th></th>";
          }else{
            if ( settle == "amount" || settle == "money" ) {
              tableHead += "<th>總計</th>";
              tableHead += "<th>平均</th>";
            }else if ( settle == "rate" ) {
              tableHead += "<th>平均</th>";
            }
          }
          $('#reportTable #tableHead tr').html(tableHead);

          
          //圖表資料
          for( var i = 0 ; i < res['result'].length ; i++ ){

              lineChart.data.datasets[i] = [];
              lineChart.data.datasets[i].label = "第"+ chNum[collapse[i]-1] + "組";
              lineChart.data.datasets[i].data = res['result'][i];

              lineChart.data.datasets[i].borderColor = chartLineColor[i];
              lineChart.data.datasets[i].backgroundColor = chartLineColor[i];
              lineChart.data.datasets[i].fill = false; // 不要填滿area
              lineChart.data.datasets[i].lineTension = 0; // 使線條變折線
              // lineChart.data.datasets[i].pointRadius = 5;
              lineChart.data.datasets[i].pointHoverRadius = 8;
              lineChart.data.datasets[i].pointHitRadius = 50;
              lineChart.data.datasets[i].pointBorderWidth = 2;
              // lineChart.data.datasets[i].pointStyle = 'rectRounded';


            if( res['result'][i].length > 0){
              var total = 0;
              
              tableBody += "<tr><th>" + "第"+ chNum[collapse[i]-1] + "組" + "</th>";
                
              for( var k = 0 ; k < res['labelDate'].length ; k++ ){
                for( var j = 0 ; j < res['result'][i].length ; j++ ){
                  if( res['labelDate'][k] == res['result'][i][j]['x'] ){
                    // tableBody += "<td>" + res['result'][i][j]['y'] + "</td>";
                    tableBody += "<td>" + res['result'][i][j]['course'].join("<br/>") + "</td>";
                    total += res['result'][i][j]['y'];
                    break;
                  }else if( j == res['result'][i].length-1){
                    tableBody += "<td>無</td>";
                  }
                }
              }
            
              if ( settle == "amount") {
                tableBody += "<td>" + total + "</td>";
                tableBody += "<td>" + (total / res['result'][i].length ).toFixed(1) + " /天 </td></tr>";
              }else if ( settle == "money" ) {
                tableBody += "<td>$" + total + "</td>";
                tableBody += "<td>$" + (total / res['result'][i].length ).toFixed(1) + " /天 </td></tr>";
              }else if ( settle == "rate" ) {
                tableBody += "<td>" + (total / res['result'][i].length ).toFixed(1) + "% /天 </td></tr>";
              }
              
            }else{
              
              // tableBody += "<tr><th>查無資料</th></tr>";
              tableBody += "<tr><th>" + "第"+ chNum[collapse[i]-1] + "組" + "</th>";
              for( var k = 0 ; k < res['labelDate'].length ; k++ ){
                tableBody += "<td>無</td>";
              }
              //完全無資料
              if(res['labelDate'].length == 0){
                tableBody += "<td>查無資料</td>";
              }
              tableBody += "</tr>";
            }
          }

          $('#reportTable #tableBody').html(tableBody);

          lineChart.update();

          //datatable
          var fixNewLine = {
            format: {
                body: function ( data, column, row ) {
                  return data.replace( /<br\s*\/?>/ig, "\r\n" );
                }
            }
          };
          table = $('#table_list').DataTable({
                "dom": '<B<t>>',
                "ordering": false,
                // "order": [ 0 , 'desc'],      
                buttons: [{
                  extend: 'excel',
                  text: '匯出Excel',
                  padding: 3,
                  exportOptions: fixNewLine,
                  title: title + '_' + $("ul#reportTab a.active").text(),
                  messageTop: $("#show_log").html().replace( /<br\s*\/?>/ig, "\r\n" ),
                }]
            });

          $('#reportChart').show();
          $('#reportTable').show();
      
      
          // /** alert **/
          // $("#success_alert_text").html(data["list"].check_name + "報名狀態修改成功");
          // fade($("#success_alert"));
      },
      error: function(jqXHR){
          console.log("error: "+ JSON.stringify(jqXHR)); 
          
          // /** alert **/ 
          // $("#error_alert_text").html("報名狀態修改失敗");
          // fade($("#error_alert"));      
      }
    });
  });


  </script>

@endsection