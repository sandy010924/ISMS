<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="csrf-token"  content="{{ csrf_token() }}">
  <title>場次選擇 | 無極限學員系統</title>

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
        <div id="course_form" class="card p-3">
          <form class="form" action="{{ url('message_form_apply') }}" method="POST">
            @csrf
            <input type="hidden" id="id_registration" name="id_registration" class="form-control" value="{{ $id }}">
            <div class="form-group mb-5">
                <h5 class="font-weight-bold text-center my-3">基本資料</h5>
            </div>
            <div class="form-group mb-5">
              <label class="col-form-label" for="iname">
                <b>姓名</b>
              </label>
              <input type="text" id="iname" name="iname" class="form-control" value="{{ $student->name }}" disabled>
            </div>
            <div class="form-group mb-5">
              <label class="col-form-label" for="iphone">
                <b>聯絡電話</b>
              </label>
              <input type="text" id="iphone" name="iphone" class="form-control" value="{{ $student->phone }}" disabled>
            </div>
            <div class="form-group mb-5">
              <label class="col-form-label" for="iemail">
                <b>電子郵件</b>
              </label>
              <input type="text" id="iemail" name="iemail" class="form-control" value="{{ $student->email }}" disabled>
            </div>
            <div class="form-group mb-5">
                <h5 class="font-weight-bold text-center my-3">場次選擇</h5>
            </div>
            <div class="form-group mb-5">
              @foreach( $events as $key => $data )
                <div class="form-group mb-5">
                  <label class="col-form-label" for="ievent">
                    <b>{{ $data['course_name'] }} 的場次</b>
                  </label>
                  @foreach( $data['events'] as $data_events )
                    <div class="d-block my-2">
                      <div class="custom-control custom-radio my-3">
                        <input type="radio" id="{{ $data_events['id_group'] }}" value="{{ $data_events['id_group'] }}" name="ievent" class="custom-control-input ievent" required>
                        <label class="custom-control-label h6" for="{{ $data_events['id_group'] }}">{{ $data_events['events'] }}</label>
                      </div>
                    </div>
                  @endforeach
                  {{-- <div class="d-block my-2">
                    <div class="custom-control custom-radio my-3">
                      <input type="radio" id="other{{ $key }}" value="other{{ $data['id_course'] }}" name="ievent" class="custom-control-input ievent" required>
                      <label class="custom-control-label" for="other{{ $key }}">我要選擇其他場次</label>
                    </div>
                  </div> --}}
                </div>
              @endforeach
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary px-4 mt-3">確定</button>
            </div>
          </form>
          <div id="complete" style="display:none;">
            <div class="text-center">
              <h1>報名完成！</h1>
            </div>
          </div>
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


<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>

</html>
