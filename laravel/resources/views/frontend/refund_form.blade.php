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
          <form class="form" action="{{ url('message_form_apply') }}" method="POST">
            @csrf
            {{-- <input type="hidden" id="course_id" name="course_id" value="{{ $course->id }}"> --}}
              <div class="form-group my-5">
                  <h5 class="font-weight-bold text-center my-3">申請退款請填寫以下資料，退款流程需3~5個工作天。請知悉！</h5>
              </div>
              <div class="form-group required">
                <label for="form_date" class="col-form-label">申請退款日期</label>
                {{-- <input type="date" name="form_date" class="form-control" disabled/> --}}
                <br/>
                <input type="text" class="form-control" id="form_date" name="form_date" data-provide="datepicker" autocomplete="off">
                <label class="text-secondary px-2 py-1"><small>(民國年-月-日)</small></label>
                {{-- <div class="input-group date" id="form_date" data-target-input="nearest">
                    <input type="text" name="form_date" name="form_date" class="form-control datetimepicker-input" data-target="#form_date" required/>
                    <div class="input-group-append" data-target="#form_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div> --}}
              </div>
              <div class="form-group">
                <label for="form_name" class="col-form-label">姓名</label>
                <input type="hidden" class="form-control" id="form_student" name="form_student">
                <input type="text" class="form-control" id="form_name" name="form_stuform_namedent">
              </div>
              <div class="form-group required">
                <label for="form_phone" class="col-form-label">聯絡電話</label>
                <input type="text" class="form-control" id="form_phone" required>
                <label class="text-secondary px-2 py-1"><small>聯繫方式</small></label>
              </div>
              <div class="form-group">
                <label for="form_email" class="col-form-label">電子郵件</label>
                <input type="text" class="form-control" id="form_email" name="form_email">
                <label class="text-secondary px-2 py-1"><small>example@example.com</small></label>
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
                <label for="form_reason" class="col-form-label">退費原因</label>
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
                </div>
              </div>
              <div class="text-center">
                <button id="btn_refund" type="submit" class="btn btn-primary px-4 mt-3">確定</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    {{-- @if ( $status == "success")
      <div class="alert alert-success alert-dismissible m-3 position-fixed fixed-bottom" role="alert">
        {{ $status }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @elseif ( $status == "error") 
      <script>
        alert(33);
        console.log(22);
        </script> 
      <h1>場次報名失敗</h1>
      <div class="alert alert-danger alert-dismissible m-3 position-fixed fixed-bottom" role="alert">
        場次報名失敗
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
    @endif --}}

  </main>
</body>


<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/feather.min.js') }}"></script>
<script src="{{ asset('js/form.js') }}"></script>

<!-- 民國年日期選擇器 Sandy (2020/04/02) -->
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
<script src="{{ asset('js/bootstrap-datepicker.js') }} "></script>


<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


  $(document).ready(function() {
    //日期選擇器 Sandy (2020/05/20)
    $('#form_date').datepicker({ 
      // defaultDate: new Date(),
      languate: 'zh-TW',
      format: 'twy-mm-dd',
    });
  });

  $('#btn_refund').on( "click", function() {
    var course_id = $("#course_id").val();
    var course_id = $("#form_date").val();
    $.ajax({
      type : 'POST',
      url:'refund_form', 
      // dataType: 'json',    
      data:{
        id: id,
        date: date,
        id_student: id_student,
        reason: reason,
        reason_other: reason_other
      },
      success:function(data){
        // console.log(data);
        
        if( data != 'nodata'){
          $('#form_student').val(data['student']['id']);
          $('#form_name').val(data['student']['name']);
          $('#form_email').val(data['student']['email']);
          $('#btn_refund').prop("disabled", false);
          // if( data['student'] != null ){
          //   $('#form_name').val(data['student']['name']);
          //   $('#form_email').val(data['student']['email']);
          // }else{
          //   $('#form_name').val('');
          //   $('#form_email').val('');
          // }
        }else{
          alert('此學員未報名此課程！');
          $('#btn_refund').prop("disabled", true);
        }
        
      },
      error: function(error){
        console.log(JSON.stringify(error));    
      }
    });
  });
</script>

</html>
