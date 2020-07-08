<!-- Content Start -->
<!--搜尋課程頁面內容-->
<div class="card m-3">
  <div class="card-body">
    <!-- 詳細報名資訊 -->
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col">
            <h6>{{ $date }} {{ $course }} {{ $event }}</h6>
          </div>
          <div class="col">
            <h6>銷講地點：{{ $location }}</h6>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <h6>主持開場：{{ $host }}</h6>
          </div>
          <div class="col">
            <h6>結束收單：{{ $closeorder }}</h6>
          </div>
          <div class="col">
            <h6>工作人員：{{ $staff }}</h6>
          </div>
          <div class="col">
            <h6>天氣：{{ $weather }}</h6>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <h6>現場完款：{{ $money }}</h6>
          </div>
          <div class="col">
            <h6>五日內完款：{{ $money_fivedays }}</h6>
          </div>
          <div class="col">
            <h6>分期付款：{{ $money_installment }}</h6>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <h6>備註：{{ $memo }}</h6>
          </div>
        </div>
      </div>
    </div>
    <!-- 圓餅圖 -->
    <div class="row mt-5">
      <div class="col my-auto mx-auto">
        <div class="card">
          <div class="card-header">
            <h6 class="mb-0">原始數據</h6>
          </div>
          <div class="card-body p-3">
            <div class="row">
              <div class="col">
                <h6>完款數：{{ $settle_original }}</h6>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <h6>付訂數：{{ $deposit_original }}</h6>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <h6>留單數：{{ $order_original }}</h6>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <h6>退費數：{{ $refund_original }}</h6>
              </div>
            </div>
          </div>
        </div>
        <div class="card mt-3">
          <div class="card-header">
            <h6 class="mb-0">最新數據</h6>
          </div>
          <div class="card-body p-3">
            <div class="row">
              <div class="col">
                <h6>完款數：{{ $settle }}</h6>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <h6>付訂數：{{ $deposit }}</h6>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <h6>留單數：{{ $order }}</h6>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <h6>退費數：{{ $refund }}</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-5 px-5 mx-auto text-center">
        <canvas id="pie_chart_turnover_rate" width="200px" height="200px"></canvas>
        <h5 class="my-3">實到人數: {{ $count_check }}</h5>
        <!-- <div style="text-align: center">取消筆數: 07</div> -->
      </div>
      <div class="col-5 px-5 mx-auto text-center">
        <canvas id="pie-chart_check_in_rate" width="200px" height="200px"></canvas>
        <!-- <div style="text-align: center">報名比數: 67</div> -->
        <h5 class="my-3">報名人數: {{ $count_apply }}</h5>
      </div>
    </div>
  </div>
</div>
<!-- Content End -->
<script>
  var chart_settle_original = '<?php echo $chart_settle_original; ?>';
  var chart_settle_new = '<?php echo $chart_settle_new; ?>';
  var settle_original = '<?php echo $settle_original; ?>';
  var settle = '<?php echo $settle; ?>';
  var deposit_original = '<?php echo $deposit_original; ?>';
  var deposit = '<?php echo $deposit; ?>';
  var order_original = '<?php echo $order_original; ?>';
  var order = '<?php echo $order; ?>';
  var refund_original = '<?php echo $refund_original; ?>';
  var refund = '<?php echo $refund; ?>';
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

