@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '數據報表')

@section('content')
<!-- Content Start -->
  <!--場次數據頁面內容-->

  <div class="card m-3">
    <div class="card-body">
      <form id="form_condition1">
        <div class="row">
          <div class="col-3">
            <input type="text" class="w-100 form-control p-0" name="daterange" id="input_date2">
          </div>

          <div class="col-3">
            <select  class="form-control" id="select_type">
              <option value="0">所有老師</option>
              <option value="1">Jack</option>
              <option value="2">Julia</option>
              <option value="3">北極熊</option>
            </select>
          </div>
          <div class="col-3">
            <select  class="form-control" id="select_type">
            <option value="0">所有類型</option>
            <option value="1">類型一</option>
            <option value="2">類型二</option>
            <option value="3">類型三</option>
          </select>
          </div>
          <div class="col-3">
            <select  class="form-control" id="select_type">
            <option value="0">所有課程</option>
            <option value="1">課程一</option>
            <option value="2">課程二</option>
            <option value="3">課程三</option>
          </select>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-3">
            <select  class="form-control" id="select_type">
              <option value="0">所有地區</option>
              <option value="1">地區一</option>
              <option value="2">地區二</option>
              <option value="3">地區三</option>
            </select>
          </div>
          <div class="col-3">
            <select  class="form-control" id="select_type">
              <option value="0">所有時段</option>
              <option value="1">時段一</option>
              <option value="2">時段二</option>
              <option value="3">時段三</option>
            </select>
          </div>
          <div class="col-3">
            <select  class="form-control" id="select_type">
              <option value="0">所有來源</option>
              <option value="1">下午</option>
              <option value="2">晚上</option>
              <option value="3">整天</option>
            </select>
          </div>
          <div class="col-3">
          <button class="btn btn-primary" type="button" onclick="condition2();" data-toggle="collapse" data-target="#dev_condition2" aria-expanded="false" aria-controls="dev_condition2">
            <i class="fa fa-toggle-on" aria-hidden="true">添加條件</i>
          </button>
          <button type="button" class="btn btn-outline-secondary btn_date">搜尋</button>
          </div>
        </div>
      </form>

    </div>
  </div>
    <!-- 條件篩選器2 -->
  <div class="collapse" id="dev_condition2">
      <div class="card m-3">
        <div class="card-body">
          <form id="form_condition1">
            <div class="row">
              <div class="col-3">
                <input type="text" class="w-100 form-control p-0" name="daterange" id="input_date2">
              </div>

              <div class="col-3">
                <select  class="form-control" id="select_type">
                  <option value="0">所有老師</option>
                  <option value="1">Jack</option>
                  <option value="2">Julia</option>
                  <option value="3">北極熊</option>
                </select>
              </div>
              <div class="col-3">
                <select  class="form-control" id="select_type">
                <option value="0">所有類型</option>
                <option value="1">類型一</option>
                <option value="2">類型二</option>
                <option value="3">類型三</option>
              </select>
              </div>
              <div class="col-3">
                <select  class="form-control" id="select_type">
                <option value="0">所有課程</option>
                <option value="1">課程一</option>
                <option value="2">課程二</option>
                <option value="3">課程三</option>
              </select>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-3">
                <select  class="form-control" id="select_type">
                  <option value="0">所有地區</option>
                  <option value="1">地區一</option>
                  <option value="2">地區二</option>
                  <option value="3">地區三</option>
                </select>
              </div>
              <div class="col-3">
                <select  class="form-control" id="select_type">
                  <option value="0">所有時段</option>
                  <option value="1">時段一</option>
                  <option value="2">時段二</option>
                  <option value="3">時段三</option>
                </select>
              </div>
              <div class="col-3">
                <select  class="form-control" id="select_type">
                  <option value="0">所有來源</option>
                  <option value="1">下午</option>
                  <option value="2">晚上</option>
                  <option value="3">整天</option>
                </select>
              </div>
              <div class="col-3">
              <button class="btn btn-primary" type="button" onclick="condition3();" data-toggle="collapse" data-target="#dev_condition3" aria-expanded="false" aria-controls="dev_condition3">
                <i class="fa fa-toggle-on" aria-hidden="true">添加條件</i>
              </button>
              </div>
            </div>
          </form>
        </div>
      </div>
  </div>

  <!-- 條件篩選器3 -->
  <div class="collapse" id="dev_condition3">
    <div class="card m-3">
      <div class="card-body">
        <form id="form_condition1">
          <div class="row">
            <div class="col-3">
              <input type="text" class="w-100 form-control p-0" name="daterange" id="input_date2">
            </div>

            <div class="col-3">
              <select  class="form-control" id="select_type">
                <option value="0">所有老師</option>
                <option value="1">Jack</option>
                <option value="2">Julia</option>
                <option value="3">北極熊</option>
              </select>
            </div>
            <div class="col-3">
              <select  class="form-control" id="select_type">
              <option value="0">所有類型</option>
              <option value="1">類型一</option>
              <option value="2">類型二</option>
              <option value="3">類型三</option>
            </select>
            </div>
            <div class="col-3">
              <select  class="form-control" id="select_type">
              <option value="0">所有課程</option>
              <option value="1">課程一</option>
              <option value="2">課程二</option>
              <option value="3">課程三</option>
            </select>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-3">
              <select  class="form-control" id="select_type">
                <option value="0">所有地區</option>
                <option value="1">地區一</option>
                <option value="2">地區二</option>
                <option value="3">地區三</option>
              </select>
            </div>
            <div class="col-3">
              <select  class="form-control" id="select_type">
                <option value="0">所有時段</option>
                <option value="1">時段一</option>
                <option value="2">時段二</option>
                <option value="3">時段三</option>
              </select>
            </div>
            <div class="col-3">
              <select  class="form-control" id="select_type">
                <option value="0">所有來源</option>
                <option value="1">下午</option>
                <option value="2">晚上</option>
                <option value="3">整天</option>
              </select>
            </div>
            <div class="col-3">
            <button class="btn btn-primary" type="button" onclick="condition4();" data-toggle="collapse" data-target="#dev_condition4" aria-expanded="false" aria-controls="dev_condition4">
              <i class="fa fa-toggle-on" aria-hidden="true">添加條件</i>
            </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

    <!-- 條件篩選器4 -->
    <div class="collapse" id="dev_condition4">
      <div class="card m-3">
        <div class="card-body">
          <form id="form_condition1">
            <div class="row">
              <div class="col-3">
                <input type="text" class="w-100 form-control p-0" name="daterange" id="input_date2">
              </div>

              <div class="col-3">
                <select  class="form-control" id="select_type">
                  <option value="0">所有老師</option>
                  <option value="1">Jack</option>
                  <option value="2">Julia</option>
                  <option value="3">北極熊</option>
                </select>
              </div>
              <div class="col-3">
                <select  class="form-control" id="select_type">
                <option value="0">所有類型</option>
                <option value="1">類型一</option>
                <option value="2">類型二</option>
                <option value="3">類型三</option>
              </select>
              </div>
              <div class="col-3">
                <select  class="form-control" id="select_type">
                <option value="0">所有課程</option>
                <option value="1">課程一</option>
                <option value="2">課程二</option>
                <option value="3">課程三</option>
              </select>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-3">
                <select  class="form-control" id="select_type">
                  <option value="0">所有地區</option>
                  <option value="1">地區一</option>
                  <option value="2">地區二</option>
                  <option value="3">地區三</option>
                </select>
              </div>
              <div class="col-3">
                <select  class="form-control" id="select_type">
                  <option value="0">所有時段</option>
                  <option value="1">時段一</option>
                  <option value="2">時段二</option>
                  <option value="3">時段三</option>
                </select>
              </div>
              <div class="col-3">
                <select  class="form-control" id="select_type">
                  <option value="0">所有來源</option>
                  <option value="1">下午</option>
                  <option value="2">晚上</option>
                  <option value="3">整天</option>
                </select>
              </div>
              <div class="col-3">
              <button class="btn btn-primary" type="button" onclick="condition5();" data-toggle="collapse" data-target="#dev_condition5" aria-expanded="false" aria-controls="dev_condition5">
                <i class="fa fa-toggle-on" aria-hidden="true">添加條件</i>
              </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>


     <!-- 條件篩選器3 -->
  <div class="collapse" id="dev_condition5">
    <div class="card m-3">
      <div class="card-body">
        <form id="form_condition1">
          <div class="row">
            <div class="col-3">
              <input type="text" class="w-100 form-control p-0" name="daterange" id="input_date2">
            </div>

            <div class="col-3">
              <select  class="form-control" id="select_type">
                <option value="0">所有老師</option>
                <option value="1">Jack</option>
                <option value="2">Julia</option>
                <option value="3">北極熊</option>
              </select>
            </div>
            <div class="col-3">
              <select  class="form-control" id="select_type">
              <option value="0">所有類型</option>
              <option value="1">類型一</option>
              <option value="2">類型二</option>
              <option value="3">類型三</option>
            </select>
            </div>
            <div class="col-3">
              <select  class="form-control" id="select_type">
              <option value="0">所有課程</option>
              <option value="1">課程一</option>
              <option value="2">課程二</option>
              <option value="3">課程三</option>
            </select>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-3">
              <select  class="form-control" id="select_type">
                <option value="0">所有地區</option>
                <option value="1">地區一</option>
                <option value="2">地區二</option>
                <option value="3">地區三</option>
              </select>
            </div>
            <div class="col-3">
              <select  class="form-control" id="select_type">
                <option value="0">所有時段</option>
                <option value="1">時段一</option>
                <option value="2">時段二</option>
                <option value="3">時段三</option>
              </select>
            </div>
            <div class="col-3">
              <select  class="form-control" id="select_type">
                <option value="0">所有來源</option>
                <option value="1">下午</option>
                <option value="2">晚上</option>
                <option value="3">整天</option>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- 圖表 -->
  <div class="card m-3">
    <div class="card-body">
      <div class="row">
        <div style="width: 70%; height: 70%; margin:10px;">
            <canvas id="myChart" width="100" height="50"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- 表格 -->
  <div class="card m-3">
    <div class="card-body">
      <div class="row">
        <div class="col-12">
            <div class="collapse" id="model_show_log" style="padding-top:15px;">
              <div class="card card-body" id="show_log">
              </div>
            </div>
          </div>
      </div>
      <div class="table-responsive">
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
      </div>
    </div>
  </div>


  <!-- Content End -->
  <script src="{{ asset('js/Chart.min.js') }}"></script>
  <script>
    $(document).ready(function () {
      $('input[name="daterange"]').daterangepicker({
        opens: 'left',
        locale: {
          format: "YYYY/MM/DD"
        }

      });

      // 圖表設定
      var ctx = document.getElementById('myChart').getContext('2d');

      var chartData = {
        labels: ["星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
        datasets: [{
          label: "黑心外匯交易",
          data: [
            {
              y: 20,
              date: '2020/03/05(ㄧ)',
              position: '台北下午場',
              title: '黑心外匯交易員的告白'
            },
            {
              y: 25,
              date: '2020/03/06(二)',
              position: '台中下午場',
              title: '黑心外匯交易員的告白2'
            },
            {
              y: 15,
              date: '2020/03/05(ㄧ)',
              position: '台北下午場',
              title: '黑心外匯交易員的告白'
            },
            {
              y: 12,
              date: '2020/03/06(二)',
              position: '台中下午場',
              title: '黑心外匯交易員的告白2'
            },
            {
              y: 22,
              date: '2020/03/05(ㄧ)',
              position: '台北下午場',
              title: '黑心外匯交易員的告白'
            },
            {
              y: 28,
              date: '2020/03/06(二)',
              position: '台中下午場',
              title: '黑心外匯交易員的告白2'
            },
            {
              y: 12,
              date: '2020/03/06(二)',
              position: '台中下午場',
              title: '黑心外匯交易員的告白2'
            },
          ],
          borderColor: "#3e95cd",
          fill: false, // 不要填滿area
          lineTension: 0, // 使線條變折線
          pointRadius: 5,
          pointHoverRadius: 10,
          pointHitRadius: 50,
          pointBorderWidth: 2,
          pointStyle: 'rectRounded',
        },
        {
          label: "零秒成交數",
          data: [
            {
              y: 10,
              date: '2020/03/05(ㄧ)',
              position: '台北下午場',
              title: '黑心外匯交易員的告白'
            },
            {
              y: 20,
              date: '2020/03/06(二)',
              position: '台中下午場',
              title: '黑心外匯交易員的告白2'
            },
            {
              y: 23,
              date: '2020/03/05(ㄧ)',
              position: '台北下午場',
              title: '黑心外匯交易員的告白'
            },
            {
              y: 25,
              date: '2020/03/06(二)',
              position: '台中下午場',
              title: '黑心外匯交易員的告白2'
            },
            {
              y: 20,
              date: '2020/03/05(ㄧ)',
              position: '台北下午場',
              title: '黑心外匯交易員的告白'
            },
            {
              y: 10,
              date: '2020/03/06(二)',
              position: '台中下午場',
              title: '黑心外匯交易員的告白2'
            },
            {
              y: 15,
              date: '2020/03/06(二)',
              position: '台中下午場',
              title: '黑心外匯交易員的告白2'
            },
          ],
          borderColor: "#c45850",
          fill: false, // 不要填滿area
          lineTension: 0, // 使線條變折線
          pointRadius: 5,
          pointHoverRadius: 10,
          pointHitRadius: 50,
          pointBorderWidth: 2,
          pointStyle: 'rectRounded'
        }]
      };

      var chartOptions = {
        scales: {
          yAxes: [
            {
              scaleLabel: { display: true },
              ticks: {
                beginAtZero: false,
                callback: function (value, index, values) {
                    return value.toLocaleString()+'%';
                }
              }
            }
          ]
        },
        title: {
          display: true,
          text: '報到率'
        },
        tooltips: {
          displayColors: false,
          hover: { mode: 'point' },
          callbacks: {
            label: function (tooltipItem, data) {
              const dataset = data.datasets[tooltipItem.datasetIndex];
              // console.log(dataset)
              // 計算總和
              // const sum = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
              //   return previousValue + currentValue;
              // });
              const currentValue = dataset.data[tooltipItem.index];
              const { y, date, position, title } = currentValue
              console.log(currentValue)
              // return " " + data.labels[tooltipItem.index] + ":" + currentValue  + "%";
              // return " " + data.labels[tooltipItem.index] + ":" + currentValue  + "%";
              return [date, title, '',`${position}: ${y}%`];
            },
            title: function(tooltipItem, data) {
              return;
            }
          }
        },
        legend: {
          display: true,
          position: 'top',
          labels: {
            boxWidth: 80,
            fontColor: 'black'
          }
        }
      };

      var lineChart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: chartOptions
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


  </script>

@endsection