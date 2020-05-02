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
          <a class="nav-link active" href="#">名單數據</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">報到率</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">成交率</a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" href="#">退費</a>
        </li> --}}
        <li class="nav-item">
          <a class="nav-link" href="#">營業額</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">單場成本</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="collapse show" id="dev_condition1" data-item="1" name="condition">
    <div class="card m-3">
      <div class="card-body">
        <div class="row">
          <div class="col-3">
            <h5>第一組</h5>
          </div>
          <div class="col-3">
            <select  class="form-control" name="item1" data-select="itemTeacher">
              <option value="0" selected>所有老師</option>
              @foreach($teacher as $data)
                <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-3">
            <select  class="form-control" name="item1" data-select="itemType">
              <option value="0" selected>所有類型</option>
              <option value="1">銷講</option>
              <option value="2">二階</option>
              <option value="3">三階</option>
            </select>
          </div>
          <div class="col-3">
            <select  class="form-control" name="item1" data-select="itemSource">
              <option value="0" selected>所有來源</option>
              @foreach($source as $data)
                <option value="{{ $data['datasource'] }}">{{ $data['datasource'] }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-3">
            <select  class="form-control" name="item1" data-select="itemAction">
              <option value="0" selected>所有動作</option>
              <option value="4">報到</option>
              <option value="5">取消</option>
              <option value="3">未到</option>
            </select>
          </div>
          <div class="col-3">
            <select class="custom-select" name="item1" data-select="itemCity">
              <option value="0" selected>所有地區</option>
              @foreach($city as $data)
                <option value="{{ $data }}">{{ $data }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-3">
            <select  class="form-control" name="item1" data-select="itemTime">
              <option value="0" selected>所有時段</option>
              <option value="上午">上午</option>
              <option value="下午">下午</option>
              <option value="晚上">晚上</option>
              <option value="整天">整天</option>
            </select>
          </div>
          <div class="col-3">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#dev_condition2" aria-expanded="false" aria-controls="dev_condition2">
              <i id="firstCondition" class="fa fa-toggle-on" aria-hidden="true">比較條件</i>
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
          <div class="col-3">
            <h5>第二組</h5>
          </div>
          <div class="col-3">
            <select  class="form-control" name="item2" data-select="itemTeacher">
              <option value="0" selected>所有老師</option>
              @foreach($teacher as $data)
                <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-3">
            <select  class="form-control" name="item2" data-select="itemType">
              <option value="0" selected>所有類型</option>
              <option value="1">銷講</option>
              <option value="2">二階</option>
              <option value="3">三階</option>
            </select>
          </div>
          <div class="col-3">
            <select  class="form-control" name="item2" data-select="itemSource">
              <option value="0" selected>所有來源</option>
              @foreach($source as $data)
                <option value="{{ $data['datasource'] }}">{{ $data['datasource'] }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-3">
            <select  class="form-control" name="item2" data-select="itemAction">
              <option value="0" selected>所有動作</option>
              <option value="4">報到</option>
              <option value="5">取消</option>
              <option value="3">未到</option>
            </select>
          </div>
          <div class="col-3">
            <select class="custom-select" name="item2" data-select="itemCity">
              <option value="0" selected>所有地區</option>
              @foreach($city as $data)
                <option value="{{ $data }}">{{ $data }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-3">
            <select  class="form-control" name="item2" data-select="itemTime">
              <option value="0" selected>所有時段</option>
              <option value="上午">上午</option>
              <option value="下午">下午</option>
              <option value="晚上">晚上</option>
              <option value="整天">整天</option>
            </select>
          </div>
          <div class="col-3">
          <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#dev_condition3" aria-expanded="false" aria-controls="dev_condition3">
            <i class="fa fa-toggle-on" aria-hidden="true">比較條件</i>
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
        <form id="form_condition1">
          <div class="row">
            <div class="col-3">
              <h5>第三組</h5>
            </div>
            <div class="col-3">
              <select  class="form-control" name="item3" data-select="itemTeacher">
                <option value="0" selected>所有老師</option>
                @foreach($teacher as $data)
                  <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-3">
              <select  class="form-control" name="item3" data-select="itemType">
                <option value="0" selected>所有類型</option>
                <option value="1">銷講</option>
                <option value="2">二階</option>
                <option value="3">三階</option>
              </select>
            </div>
            <div class="col-3">
              <select  class="form-control" name="item3" data-select="itemSource">
                <option value="0" selected>所有來源</option>
                @foreach($source as $data)
                  <option value="{{ $data['datasource'] }}">{{ $data['datasource'] }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-3">
              <select  class="form-control" name="item3" data-select="itemAction">
                <option value="0" selected>所有動作</option>
                <option value="4">報到</option>
                <option value="5">取消</option>
                <option value="3">未到</option>
              </select>
            </div>
            <div class="col-3">
              <select class="custom-select" name="item3" data-select="itemCity">
                <option value="0" selected>所有地區</option>
                @foreach($city as $data)
                  <option value="{{ $data }}">{{ $data }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-3">
              <select  class="form-control" name="item3" data-select="itemTime">
                <option value="0" selected>所有時段</option>
                <option value="上午">上午</option>
                <option value="下午">下午</option>
                <option value="晚上">晚上</option>
                <option value="整天">整天</option>
              </select>
            </div>
            <div class="col-3">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#dev_condition4" aria-expanded="false" aria-controls="dev_condition4">
              <i class="fa fa-toggle-on" aria-hidden="true">比較條件</i>
            </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- 條件篩選器4 -->
  <div class="collapse" id="dev_condition4" data-item="4" name="condition">
    <div class="card m-3">
      <div class="card-body">
        <form id="form_condition1">
          <div class="row">
            <div class="col-3">
              <h5>第四組</h5>
            </div>
            <div class="col-3">
              <select  class="form-control" name="item4" data-select="itemTeacher">
                <option value="0" selected>所有老師</option>
                @foreach($teacher as $data)
                  <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-3">
              <select  class="form-control" name="item4" data-select="itemType">
                <option value="0" selected>所有類型</option>
                <option value="1">銷講</option>
                <option value="2">二階</option>
                <option value="3">三階</option>
              </select>
            </div>
            <div class="col-3">
              <select  class="form-control" name="item4" data-select="itemSource">
                <option value="0" selected>所有來源</option>
                @foreach($source as $data)
                  <option value="{{ $data['datasource'] }}">{{ $data['datasource'] }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-3">
              <select  class="form-control" name="item4" data-select="itemAction">
                <option value="0" selected>所有動作</option>
                <option value="4">報到</option>
                <option value="5">取消</option>
                <option value="3">未到</option>
              </select>
            </div>
            <div class="col-3">
              <select class="custom-select" name="item4" data-select="itemCity">
                <option value="0" selected>所有地區</option>
                @foreach($city as $data)
                  <option value="{{ $data }}">{{ $data }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-3">
              <select  class="form-control" name="item4" data-select="itemTime">
                <option value="0" selected>所有時段</option>
                <option value="上午">上午</option>
                <option value="下午">下午</option>
                <option value="晚上">晚上</option>
                <option value="整天">整天</option>
              </select>
            </div>
            <div class="col-3">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#dev_condition5" aria-expanded="false" aria-controls="dev_condition5">
              <i class="fa fa-toggle-on" aria-hidden="true">比較條件</i>
            </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- 條件篩選器5 -->
  <div class="collapse" id="dev_condition5" data-item="5" name="condition">
    <div class="card m-3">
      <div class="card-body">
        <div class="row">
          <div class="col-3">
            <h5>第五組</h5>
          </div>
          <div class="col-3">
            <select  class="form-control" name="item5" data-select="itemTeacher">
              <option value="0" selected>所有老師</option>
              @foreach($teacher as $data)
                <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-3">
            <select  class="form-control" name="item5" data-select="itemType">
              <option value="0" selected>所有類型</option>
              <option value="1">銷講</option>
              <option value="2">二階</option>
              <option value="3">三階</option>
            </select>
          </div>
          <div class="col-3">
            <select  class="form-control" name="item5" data-select="itemSource">
              <option value="0" selected>所有來源</option>
              @foreach($source as $data)
                <option value="{{ $data['datasource'] }}">{{ $data['datasource'] }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-3">
            <select  class="form-control" name="item5" data-select="itemAction">
              <option value="0" selected>所有動作</option>
              <option value="4">報到</option>
              <option value="5">取消</option>
              <option value="3">未到</option>
            </select>
          </div>
          <div class="col-3">
            <select class="custom-select" name="item5" data-select="itemCity">
              <option value="0" selected>所有地區</option>
              @foreach($city as $data)
                <option value="{{ $data }}">{{ $data }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-3">
            <select  class="form-control" name="item5" data-select="itemTime">
              <option value="0" selected>所有時段</option>
              <option value="上午">上午</option>
              <option value="下午">下午</option>
              <option value="晚上">晚上</option>
              <option value="整天">整天</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 圖表 -->
  <div id="reportChart" class="card m-3" style="display:none">
    <div class="card-body">
      <button class="btn btn-dark" type="button" data-toggle="collapse" data-target="#model_show_log" aria-expanded="false" aria-controls="model_show_log">
            <i class="fa fa-search" aria-hidden="true"></i>查看/隱藏搜尋條件
      </button>
      <div class="row">
        <div class="col-12">
            <div class="collapse show" id="model_show_log" style="padding-top:15px;">
              <div class="card card-body" id="show_log">
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
  <div id="reportTable" class="card m-3" style="display:none">
    <div class="card-body">
      {{-- <div class="table-responsive">
        <input type="hidden" id="id_group"  value="2">
        <input type="hidden" id="data_groupdetail"  value="2">
        <table class="table table-striped table-sm text-center">
          <thead>
            <tr>
              <th>課程名稱</th>
              <th>2020/03/05</th>
              <th>2020/03/06</th>
              <th>2020/03/07</th>
              <th>2020/03/08</th>
              <th>2020/03/09</th>
              <th>2020/03/10</th>
              <th>2020/03/11</th>
            </tr>
          </thead>
          <tbody id= "data_student">
            <tr>
                <th>黑心外匯交易</th>
                <th>20%</th>
                <th>25%</th>
                <th>15%</th>
                <th>12%</th>
                <th>22%</th>
                <th>28%</th>
                <th>12%</th>
            </tr>
            <tr>
                <th>零秒成交術</th>
                <th>10%</th>
                <th>20%</th>
                <th>23%</th>
                <th>25%</th>
                <th>20%</th>
                <th>10%</th>
                <th>15%</th>
            </tr>
          </tbody>
        </table>
      </div> --}}
    </div>
  </div>


  <style>
    /* .nav-link.active {

    } */
  </style>

  <!-- Content End -->
  <script src="{{ asset('js/Chart.min.js') }}"></script>
  <script src="{{ asset('js/report.js') }}"></script>
  <script>
    var startDate = "";
    var endDate = "";
    // var chartData;
    var chartLineColor = ['#3e95cd','#e83131','#0dd168', '#f70fe0', '#f58300'];

    $(document).ready(function () {

      $('input[name="daterange"]').daterangepicker({
        // autoUpdateInput: false,
        locale: {
          format: 'YYYY-MM-DD',
          separator: ' ~ '
        }
      },function(start, end) {
        // console.log("Callback has been called!");
        // $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
        startDate = start.format('YYYY-MM-DD');
        endDate = end.format('YYYY-MM-DD');
      });

      // 上方link 選取狀態切換
      $('#reportTab .nav-item > a').on('click', function(e) {
        e.preventDefault();
        $('#reportTab .nav-link').removeClass('active')
        $(this).addClass('active');
      });

      //select2 講師及來源、地區下拉式搜尋 Sandy(2020/04/14)
      $("[name='itemSource']itemTeacher, [name='itemSource'], [name='itemCity']").select2({
          width: 'resolve', // need to override the changed default
          theme: 'bootstrap'
      });
      $.fn.select2.defaults.set( "theme", "bootstrap" );





      // var chartData = {
      //   labels: ["2020/03/05", "2020/03/06", "2020/03/07", "2020/03/08", "2020/03/09", "2020/03/10", "2020/03/11", "2020/04/11"],
      //   datasets: [{
      //     label: "第一組",
      //     data: [
      //       {
      //         y: 20,
      //         x: '2020/03/05',
      //         // date: '2020/03/05',
      //         position: '台北下午場',
      //         title: '黑心外匯交易'
      //       },
      //       {
      //         y: 25,
      //         x: '2020/03/06',
      //         // date: '2020/03/06',
      //         position: '台中下午場',
      //         title: '黑心外匯交易'
      //       },
      //       {
      //         y: 15,
      //         x: '2020/03/07',
      //         // date: '2020/03/07',
      //         position: '台北下午場',
      //         title: '黑心外匯交易'
      //       },
      //       {
      //         y: 12,
      //         x: '2020/03/08',
      //         // date: '2020/03/08',
      //         position: '台中下午場',
      //         title: '黑心外匯交易'
      //       },
      //       {
      //         y: 22,
      //         x: '2020/03/09',
      //         // date: '2020/03/09',
      //         position: '台北下午場',
      //         title: '黑心外匯交易'
      //       },
      //       {
      //         y: 28,
      //         x: '2020/03/10',
      //         // date: '2020/03/10',
      //         position: '台中下午場',
      //         title: '黑心外匯交易'
      //       },
      //       {
      //         y: 12,
      //         x: '2020/04/11',
      //         // date: '2020/04/11',
      //         position: '台中下午場',
      //         title: '黑心外匯交易'
      //       },
      //     ],
      //     borderColor: "#3e95cd",
      //     backgroundColor: "#3e95cd",
      //     fill: false, // 不要填滿area
      //     lineTension: 0, // 使線條變折線
      //     pointRadius: 5,
      //     pointHoverRadius: 10,
      //     pointHitRadius: 50,
      //     pointBorderWidth: 2,
      //     pointStyle: 'rectRounded',
      //   }
      //   // {
      //   //   label: "第二組",
      //   //   data: [
      //   //     {
      //   //       y: 10,
      //   //       date: '2020/03/05',
      //   //       position: '台北下午場',
      //   //       title: '零秒成交術'
      //   //     },
      //   //     {
      //   //       y: 20,
      //   //       date: '2020/03/06',
      //   //       position: '台中下午場',
      //   //       title: '零秒成交術'
      //   //     },
      //   //     {
      //   //       y: 23,
      //   //       date: '2020/03/07',
      //   //       position: '台北下午場',
      //   //       title: '零秒成交術'
      //   //     },
      //   //     {
      //   //       y: 25,
      //   //       date: '2020/03/08',
      //   //       position: '台中下午場',
      //   //       title: '零秒成交術'
      //   //     },
      //   //     {
      //   //       y: 20,
      //   //       date: '2020/03/09',
      //   //       position: '台北下午場',
      //   //       title: '零秒成交術'
      //   //     },
      //   //     {
      //   //       y: 10,
      //   //       date: '2020/03/10',
      //   //       position: '台中下午場',
      //   //       title: '零秒成交術'
      //   //     },
      //   //     {
      //   //       y: 15,
      //   //       date: '2020/03/11',
      //   //       position: '台中下午場',
      //   //       title: '零秒成交術'
      //   //     },
      //   //   ],
      //   //   borderColor: "#c45850",
      //   //   fill: false, // 不要填滿area
      //   //   lineTension: 0, // 使線條變折線
      //   //   pointRadius: 5,
      //   //   pointHoverRadius: 10,
      //   //   pointHitRadius: 50,
      //   //   pointBorderWidth: 2,
      //   //   pointStyle: 'rectRounded'
      //   // }
      // ]
      // };


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

  
  // 圖表設定
  var ctx = document.getElementById('myChart').getContext('2d');
  var lineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: "",
      datasets: [{
          data: [],
          borderColor: "#3e95cd",
          backgroundColor: "#3e95cd",
          fill: false, // 不要填滿area
          lineTension: 0, // 使線條變折線
          pointRadius: 5,
          pointHoverRadius: 10,
          pointHitRadius: 50,
          pointBorderWidth: 2,
          pointStyle: 'rectRounded',
      }]
    },
    options: chartOptions
  });

      
  /* 搜尋按鈕click */
  $('#searchBtn').click(function(){

      // var data= [
      //       {
      //         y: 10,
      //         date: '2020/03/05',
      //         position: '台北下午場',
      //         title: '零秒成交術'
      //       },
      //       {
      //         y: 20,
      //         date: '2020/03/06',
      //         position: '台中下午場',
      //         title: '零秒成交術'
      //       },
      //       {
      //         y: 23,
      //         date: '2020/03/07',
      //         position: '台北下午場',
      //         title: '零秒成交術'
      //       },
      //       {
      //         y: 25,
      //         date: '2020/03/08',
      //         position: '台中下午場',
      //         title: '零秒成交術'
      //       },
      //       {
      //         y: 20,
      //         date: '2020/03/09',
      //         position: '台北下午場',
      //         title: '零秒成交術'
      //       },
      //       {
      //         y: 10,
      //         date: '2020/03/10',
      //         position: '台中下午場',
      //         title: '零秒成交術'
      //       },
      //       {
      //         y: 15,
      //         date: '2020/03/11',
      //         position: '台中下午場',
      //         title: '零秒成交術'
      //       },
      //     ];
      //   console.log(data);
      //   return false;










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
      $('select[name="item' + (i+1) +'"] option:selected').each(function() {
        // return($(this).val());
        // item1.push($(this).parent().data('item'));
        // item[i][$(this).parent().data('select')] = $(this).val();
        item[i].push($(this).val());
        log[i].push($(this).text());
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
      str += "第"+ chNum[i] + "組：" + log[i];
    }

    $('#show_log').html(str);
    
    // console.log(endDate);

    $.ajax({
      type:'GET',
      url:'report_search',
      // dataType: 'json',
      data:{
        startDate: startDate,
        endDate: endDate,
        item: item
      },
      success:function(res){
          console.log(res);  
          
          lineChart.data.labels = res['labelDate'];

          for( var i = 0 ; i < res['result'].length ; i++ ){
            // for( var j = 0 ; j < res['result'][i].length ; j++ ){
              lineChart.data.datasets[i].label = "第"+ chNum[i] + "組";
              lineChart.data.datasets[i].data.push(res['result'][i]);
            // }
          }
          lineChart.update();

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