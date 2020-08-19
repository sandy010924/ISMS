<!-- Content Start -->
<!--搜尋課程頁面內容-->
<div class="card m-3" id="contentPDF">
  <div class="card-body">
    <!-- 詳細報名資訊 -->
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col">
            <h6>
              <label id="course_date">{{ $date }}</label>
              （{{ $week }}）
              <label id="course_name">{{ $course }}</label>
              <label id="course_event">{{ $event }}</label>
            </h6>
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

<button id="btnPDF" title="匯出PDF">
  <i data-feather="file"></i>
  匯出PDF
</button>

<!-- Content End -->
<style>
  /* main {
    margin-bottom: 35px;
  } */
#btnPDF{
  width: 120px;
  /* height: 50px; */
  position: fixed;
  bottom: 20px;
  right: 30px;
  border: 3px #ddd solid;
  border-radius: 30px;
  padding: 5px;
  background-color: rgba(221, 221, 221, 0.8);
  font-weight: 600;
  font-size: 15px;
  color: #888;
}
#btnPDF:hover{
  border: 3px #333 solid;
  background-color: #ba2222;
  color: #fff;
}
#btnPDF svg{
  width: 18px;
  height: 18px;
  color: #888;
  /* margin: 1px; */
}
#btnPDF:hover svg{
  color: #fff;
}
</style>
<!--PDF外掛START-->
{{-- <script src="https://cdn.bootcss.com/jspdf/1.3.5/jspdf.min.js"></script> --}}
{{-- <script src="https://cdn.bootcss.com/jspdf/1.3.5/jspdf.debug.js"></script>
<script src="https://cdn.bootcss.com/jspdf-autotable/3.0.0-alpha.1/jspdf.plugin.autotable.min.js"></script> --}}
{{-- <script  src="http://html2canvas.hertzen.com/dist/html2canvas.js"></script> --}}
<!--PDF外掛END-->

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


  /* 匯出pdf Sandy(2020/07/14) */
  
  var today = moment(new Date()).format("YYYYMMDD");
  var title = today + '_場次數據圖表' + '_' + $('#course_name').text() + '(' + $('#course_date').text() + ' ' +$('#course_event').text() + ')';

  $(function () {
    $('#btnPDF').click(function () {        
      html2canvas( $('#contentPDF') , { 
        onrendered:function(canvas) { 
          //返回圖片dataURL，參數：圖片格式和清晰度(0-1) 
          var pageData = canvas.toDataURL('image/png'); 
          //方向默認豎直，尺寸ponits，格式a4[595.28,841.89] 
          var pdf = new jsPDF('landscape'); 
          //addImage後兩個參數控制添加圖片的尺寸，此處將頁面高度按照a4紙寬高比列進行壓縮
          pdf.addImage(pageData, 'PNG', 10, 10); 
          // pdf.addImage(pageData, 'PNG', 0, 0, 595.28, 592.28/canvas.width * canvas.height ); 
          pdf.save( title + '.pdf' ); 
        } 
      })
    });
  });

</script>
<script src="{{ asset('js/Chart.min.js') }} "></script>
<script src="{{ asset('js/course_list_chart.js') }} "></script>

