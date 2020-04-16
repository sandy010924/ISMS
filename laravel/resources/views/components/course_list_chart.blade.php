<!-- Content Start -->
<!--搜尋課程頁面內容-->
<div class="card m-3">
  <div class="card-body">
    <!-- content -->
    <div class="content_box">
      <!-- 詳細報名資訊 -->
      <div class="mt-3 mb-3">
        <div class="card custom_card">
          <div class="card-header custom_card_header">
            <h5>{{ $date }}</h5>
            <h5>{{ $course }}</h5>
            <h5>{{ $event }}</h5>
            <div class="row custom_row">
                <label class="custom_label">銷講地點：</label>
                <span>{{ $location }}</span>
            </div>
            <div class="row custom_row">
                <label class="custom_label">結束收單：</label>
                <span>{{ $closeorder }}</span>
            </div>
            <div class="row custom_row">
                <label class="custom_label">主持開場：</label>
                <span>{{ $host }}</span>
            </div>
            <div class="row custom_row">
                <label class="custom_label">工作人員：</label>
                <span>{{ $staff }}</span>
            </div>
            <small>天氣：{{ $weather }}</small>
            <br>
            <small>備註：{{ $memo }}</small>
          </div>
          <div class="card-body custom_card_body">
            <div>
              <div class="row custom_row">
                <label class="custom_label">現場完款：</label>
                <span>{{ $money }}</span>
              </div>
              <div class="row custom_row">
                <label class="custom_label">五日內完款：</label>
                <span>{{ $money_fivedays }}</span>
              </div>
              <div class="row custom_row">
                <label class="custom_label">分期付款：</label>
                <span>{{ $money_installment }}</span>
              </div>
              <div class="row custom_row">
                <label class="custom_label">完款數：</label>
                <span>{{ $settle }}</span>
              </div>
              <div class="row custom_row">
                <label class="custom_label">付訂數：</label>
                <span>{{ $deposit }}</span>
              </div>
              <div class="row custom_row">
                <label class="custom_label">留單數：</label>
                <span>{{ $order }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="pie_box"><canvas id="pie_chart_turnover_rate" width="200px" height="200px"></canvas></div>
        <h6 class="text-center">實到人數: {{ $count_check }}</h6>
        <!-- <div style="text-align: center">取消筆數: 07</div> -->
      </div>
      <div>
        <div class="pie_box"><canvas id="pie-chart_check_in_rate" width="200px" height="200px"></canvas></div>
        <!-- <div style="text-align: center">報名比數: 67</div> -->
        <h6 class="text-center">報名人數: {{ $count_apply }}</h6>
      </div>
    </div>
  </div>
  <!-- <input id="refresh" type="button" value="更新圖表"></button> -->
</div>

{{-- <div class="card m-3">
  <div class="card-body">
    <div class="row">
      <div class="col">
        <h5>{{ $date }} {{ $course }} {{ $event }}</h5>
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <h6>銷講地點： {{ $location }}</h6>
      </div>
      <div class="col-3">
        <h6>備註： {{ $memo }}</h6>
      </div>
      <div class="col">
        <h6>天氣： {{ $weather }}</h6>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <h6>結束收單： {{ $closeorder }}</h6>
      </div>
      <div class="col">
        <h6>主持開場： {{ $host }}</h6>
      </div>
      <div class="col">
        <h6>工作人員： {{ $staff }}</h6>
      </div>
    </div>
  </div>
</div>
<div class="card m-3">
  <div class="card-body">
    <div class="row">
      <!-- 詳細報名資訊 -->
      <div class="col m-3">
        <div class="card custom_card">
          <div class="card-header">
              <div class="row custom_row">
                <h6>現場完款：{{ $money }}</h6>
              </div>
              <div class="row custom_row">
                <label class="custom_label">五日內完款：</label>
                <span>{{ $money_fivedays }}</span>
              </div>
              <div class="row custom_row">
                <label class="custom_label">分期付款：</label>
                <span>{{ $money_installment }}</span>
              </div>
          </div>
          <div class="card-body">
            <div>
              <div class="row custom_row">
                <label class="custom_label">完款數：</label>
                <span>{{ $settle }}</span>
              </div>
              <div class="row custom_row">
                <label class="custom_label">付訂數：</label>
                <span>{{ $deposit }}</span>
              </div>
              <div class="row custom_row">
                <label class="custom_label">留單數：</label>
                <span>{{ $order }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div><canvas id="pie_chart_turnover_rate"></canvas></div>
        <h6 class="text-center">實到人數: {{ $count_check }}</h6>
        <!-- <div style="text-align: center">取消筆數: 07</div> -->
      </div>
      <div class="col-4">
        <div><canvas id="pie-chart_check_in_rate"></canvas></div>
        <!-- <div style="text-align: center">報名比數: 67</div> -->
        <h6 class="text-center">報名人數: {{ $count_apply }}</h6>
      </div>
    </div>
  </div>
  <!-- <input id="refresh" type="button" value="更新圖表"></button> -->
</div> --}}
<!-- Content End -->
<script>
  var settle = '<?php echo $settle; ?>';
  var deposit = '<?php echo $deposit; ?>';
  var order = '<?php echo $order; ?>';
  var count_apply = '<?php echo $count_apply; ?>';
  var count_check = '<?php echo $count_check; ?>';
  var count_cancel = '<?php echo $count_cancel; ?>';
  var rate_check = '<?php echo $rate_check; ?>';
  var rate_settle = '<?php echo $rate_settle; ?>';


</script>
<!-- <script src="../js/Chart.min.js"></script>
<script src="../js/course_list_chart.js"></script> -->
<script src="{{ asset('js/Chart.min.js') }} "></script>
<script src="{{ asset('js/course_list_chart.js') }} "></script>

