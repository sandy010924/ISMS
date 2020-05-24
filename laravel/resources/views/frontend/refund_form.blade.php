<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="csrf-token"  content="{{ csrf_token() }}">
  <title>無極限學員系統</title>

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Fontawesome Icon -->
  <link href="{{ asset('font-awesome/css/all.css') }}" rel="stylesheet">

  <!-- Custom styles -->
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
  <link href="{{ asset('css/web.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  
  <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/feather.min.js') }}"></script>
  <script src="{{ asset('js/form.js') }}"></script>

  <!-- tempusdominus Sandy(2020/02/27) -->
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/moment.min.js') }}"></script>
  <script src="{{ asset('js/zh-tw.js') }}"></script>
  <script src="{{ asset('js/tempusdominus-bootstrap-4.js') }}"></script>
  <link href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">
</head>
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
    button{
      font-weight: bold !important;
    }
</style>

<body>
  <main role="main" class="mw-100 container">
    <img src="{{ asset('img/logo.png') }}" width="100" alt="logo" class="d-block mx-auto mt-5">
    <h4 class="text-center text-white font-weight-bold m-4">無極限國際有限公司</h4>
    <div div="row">
      <div class="col-md-6 mx-auto my-3">
        <div id="course_form" class="card p-4">
          {{-- <form class="form" action="{{ url('refund_form_insert') }}" method="POST">
            @csrf --}}
              <input type="hidden" id="id_course" name="id_course">
              <div class="form-group my-5">
                  <h5 class="font-weight-bold text-center my-3">申請退款請填寫以下資料，退款流程需3~5個工作天。請知悉！</h5>
              </div>
              <div class="form-group required">
                <label for="form_date" class="col-form-label">申請退款日期</label>
                <br/>
                <div class="input-group date" data-target-input="nearest">
                    <input type="text" id="form_date" name="form_date" class="form-control datetimepicker-input" data-target="#form_date" required disabled/>
                    <div class="input-group-append" data-target="#form_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
              </div>
              <div class="form-group required">
                <label for="form_name" class="col-form-label">姓名</label>
                <input type="hidden" class="form-control" id="form_student" name="form_student">
                <input type="text" class="form-control" id="form_name" name="form_stuform_namedent">
                <div class="invalid-feedback">
                  請輸入姓名
                </div>
              </div>
              <div class="form-group required">
                <label for="form_phone" class="col-form-label">聯絡電話</label>
                <input type="text" class="form-control" id="form_phone" required>
                <label class="text-secondary px-2 py-1"><small>聯繫方式</small></label>
                <div class="invalid-feedback">
                  請輸入聯絡電話
                </div>
              </div>
              <div class="form-group required">
                <label for="form_email" class="col-form-label">電子郵件</label>
                <input type="text" class="form-control" id="form_email" name="form_email">
                <label class="text-secondary px-2 py-1"><small>example@example.com</small></label>
                <div class="invalid-feedback">
                  請輸入電子郵件
                </div>
              </div>
              {{-- <div class="form-group required">
                <label for="form_events" class="col-form-label">退費場次選擇</label>
                <select class="custom-select" id="form_events" name="form_events" disabled required>
                  <option selected disabled value="">選擇場次</option>
                  @foreach($events as $data)
                    <option value="{{ $data['id_group'] }}">{{ $data['events'] }}</option>
                  @endforeach
                </select>
              </div> --}}
              {{-- <div class="form-group required">
                <label for="form_course" class="col-form-label">申請退款課程</label>
                <input type="text" class="form-control" id="form_student" name="form_student" required>
                <select class="custom-select" id="form_course" name="form_course" required>
                  <option selected disabled value="">選擇課程</option>
                  @foreach($events as $data)
                    <option value="{{ $data['id_group'] }}">{{ $data['events'] }}</option>
                  @endforeach
                </select>
              </div> --}}
              {{-- <div class="form-group required">
                <label for="form_course" class="col-form-label">申請退款課程</label>
                <select class="custom-select" id="form_course" name="form_course" required>
                  <option selected disabled value="">選擇課程</option>
                </select>
              </div> --}}
              <div class="form-group required">
                <label id="form_reason_label" for="form_reason" class="col-form-label">退費原因</label>
                <div class="invalid-feedback">
                  請選擇退費原因
                </div>
                <div class="custom-control custom-radio my-1">
                  <input type="radio" class="custom-control-input" id="form_reason1" name="form_reason" value="課程時間無法配合">
                  <label class="custom-control-label" for="form_reason1">課程時間無法配合</label>
                </div>
                <div class="custom-control custom-radio my-1">
                  <input type="radio" class="custom-control-input" id="form_reason2" name="form_reason" value="預算不足">
                  <label class="custom-control-label" for="form_reason2">預算不足</label>
                </div>
                <div class="custom-control custom-radio my-1">
                  <input type="radio" class="custom-control-input" id="form_reason3" name="form_reason" value="已購買其他相關課程">
                  <label class="custom-control-label" for="form_reason3">已購買其他相關課程</label>
                </div>
                <div class="custom-control custom-radio my-1">
                  <input type="radio" class="custom-control-input" id="form_reason4" name="form_reason" value="目前沒有需求">
                  <label class="custom-control-label" for="form_reason4">目前沒有需求</label>
                </div>
                <div class="custom-control custom-radio my-1">
                  <input type="radio" class="custom-control-input" id="form_reason5" name="form_reason" value="其他">
                  <label class="custom-control-label" for="form_reason5">其他</label>
                  <input type="text" id="form_reason_other" name="form_reason_other" class="form-control form-control-sm" disabled>
                  <div class="invalid-feedback">
                    請輸入退費原因
                  </div>
                </div>
              </div>
              <div class="text-center">
                <button id="btn_refund" type="submit" class="btn btn-primary px-4 mt-3">確定</button>
              </div>
            </div>
          {{-- </form> --}}
        </div>
      </div>
    </div>
  </main>
</body>





<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


  $(document).ready(function() {
    //取課程id
    var getUrlString = location.href;
    var url = new URL(getUrlString);
    var id = url.searchParams.get('id_course');
    $("#id_course").val(id);

    //日期選擇器 Sandy (2020/05/20)
    $('#form_date').datetimepicker({ 
        format: 'YYYY-MM-DD',
        // icons: iconlist,
        defaultDate: moment().format('YYYY-MM-DD'), 
      });
  });

  
  $('input[name="form_reason"]').on( "change", function() {
    if($('#form_reason5').prop('checked')){
      $('#form_reason_other').prop("disabled", false);
      $('#form_reason_other').prop("required", true);
    }else{
      $('#form_reason_other').prop("disabled", true);
      $('#form_reason_other').prop("required", false);
    }
  });


  $('#btn_refund').on( "click", function() {
    var id = $("#id_course").val();
    var name = $("#form_name").val();
    var phone = $("#form_phone").val();
    var email = $("#form_email").val();
    var reason = $("input[name='form_reason']:checked").val();
    var reason_other = $("#form_reason_other").val();

    var nullValue = verify();
    if( nullValue > 0 ){
      return false;
    }

    $.ajax({
      type : 'POST',
      url:'refund_form_insert', 
      // dataType: 'json',    
      data:{
        id: id,
        name: name,
        phone: phone,
        email: email,
        reason: reason,
        reason_other: reason_other
      },
      success:function(data){
        console.log(data);
        
        switch (data) {
          case 'success':
            alert('送出表單成功，已收到您的退費申請。');
            location.reload();
            break;
          case 'error':
            alert('送出表單失敗。');
            break;
          case 'nostudent':
            alert('查無此學員資料，請與無極限國際相關人員聯絡。');
            break;
          case 'nodata':
            alert('查無此學員報名資料，請與無極限國際相關人員聯絡。');
            break;
          default:
            alert('送出表單失敗。');
            break;
        }        
      },
      error: function(error){
        alert('送出表單失敗。');
        console.log(JSON.stringify(error));    
      }
    });
  });


  /* 驗證是否輸入為空值 */
  function verify(){
    var nullValue = 0;
    var name = $("#form_name").val();
    var phone = $("#form_phone").val();
    var email = $("#form_email").val();
    var reason = $("input[name='form_reason']:checked").val();
    var reason_other = $("#form_reason_other").val();

    if(name == ""){
      $("#form_name").addClass("is-invalid");
      nullValue++;
    }else{
      $("#form_name").removeClass("is-invalid");
    }

    if(phone == ""){
      $("#form_phone").addClass("is-invalid");
      nullValue++;
    }else{
      $("#form_phone").removeClass("is-invalid");
    }
    
    if(email == ""){
      $("#form_email").addClass("is-invalid");
      nullValue++;
    }else{
      $("#form_email").removeClass("is-invalid");
    }

    if(reason == null){
      $("#form_reason_label").addClass("is-invalid");
      nullValue++;
    }else if( reason == '其他' && reason_other == ""){
      $("#form_reason_label").removeClass("is-invalid");
      $("#form_reason_other").addClass("is-invalid");
      nullValue++;
    }else{
      $("#form_reason_label").removeClass("is-invalid");
      $("#form_reason_other").removeClass("is-invalid");
    }

    return nullValue;
  }
</script>

</html>
