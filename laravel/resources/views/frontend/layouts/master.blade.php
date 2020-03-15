<html lang="zh-TW">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="csrf-token"  content="{{ csrf_token() }}">

  <title>@yield('title') | 無極限學員系統</title>

  {{-- <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/dashboard/"> --}}

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Fontawesome Icon -->
  <link href="{{ asset('font-awesome/css/all.css') }}" rel="stylesheet">
  <!-- Custom styles -->
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
  <link href="{{ asset('css/web.css') }}" rel="stylesheet">
  <link href="{{ asset('css/form.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/course_list_chart.css') }}" rel="stylesheet">

  <!-- DataTable styles Sandy(2020/02/25) -->
  {{-- <link href="{{ asset('css/dataTables.css') }}" rel="stylesheet"> --}}
  {{-- <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet"> --}}
  <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

  <!-- Rocky(2020/01/11) --> <!-- Sandy(2020/02/27) -->
  <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/feather.min.js') }}"></script>
  
  <!-- DataTable Sandy(2020/02/25) -->
  <script src="{{ asset('js/dataTables.js') }}"></script>
  <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
  {{-- <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script> --}}

  <script src="{{ asset('js/popper.min.js') }}" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <!-- tempusdominus Sandy(2020/02/27) -->
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/moment.min.js') }}"></script>
  {{-- <script src="{{ asset('js/zh-tw.js') }}"></script> --}}
  <script src="{{ asset('js/tempusdominus-bootstrap-4.js') }}"></script>
  <link href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">

  <!-- select2 -->
  <script src="{{ asset('js/select2.min.js') }}"></script>
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
  
  <!-- daterangepicker -->
  <script src="{{ asset('js/daterangepicker.min.js') }}"></script>
  <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet">

</head>

<body>
  {{-- <div class="container-fluid"> --}}

      @include('frontend.layouts.navbar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10">

          @include('frontend.layouts.header')

          @yield('content')

          <!-- form alert Start-->
          @if (session('status') == "報名成功")
            <div class="alert alert-success alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">
              {{ session('status') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @elseif (session('status') == "報名失敗")  
            <div class="alert alert-danger alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">
              {{ session('status') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
          <!-- form alert End -->

          <!-- alert Start-->
          <div class="alert alert-success alert-dismissible m-3 position-fixed fixed-bottom" role="alert" id="success_alert">
            <span id="success_alert_text"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="alert alert-danger alert-dismissible m-3 position-fixed fixed-bottom" role="alert" id="error_alert">
            <span id="error_alert_text"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!-- alert End -->

        </main>
  {{-- </div> --}}

  <!-- Rocky(2020/02/17) -->
  <script>  
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  </script>
  
  <!-- Web js -->
  <script src="{{ asset('js/style.js') }}"></script>
  <script src="{{ asset('js/otd.js') }}"></script>

  <!-- feather icon -->
  <script>
    feather.replace()
  </script>
</body>

</html>