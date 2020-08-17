<html lang="zh-TW">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title') | 無極限學員系統</title>

  {{-- <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/dashboard/"> --}}

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Fontawesome Icon -->
  <link href="{{ asset('font-awesome/css/all.css') }}" rel="stylesheet">

  <!-- DataTable styles Sandy(2020/02/25) -->
  {{-- <link href="{{ asset('css/dataTables.css') }}" rel="stylesheet"> --}}
  {{-- <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet"> --}}
  <link href="{{ asset('css/datatables.bootstrap4.min.css') }}" rel="stylesheet">

  <!-- Rocky(2020/01/11) -->
  <!-- Sandy(2020/02/27) -->
  <script src="{{ asset('js/jquery-3.4.1.slim.min.js') }}"></script>
  <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/feather.min.js') }}"></script>

  <!-- DataTable Sandy(2020/02/25) -->
  <!-- <script src="{{ asset('js/dataTables.js') }}"></script> -->
  <script src="{{ asset('js/ datatables.js') }}"></script>

  <script src="{{ asset('js/datatables.bootstrap4.js') }}"></script>
  <!-- <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script> -->
  {{-- <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script> --}}

  <script src="{{ asset('js/popper.min.js') }}"></script>

  <!-- tempusdominus Sandy(2020/02/27) -->
  {{-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> --}}
  <script src="{{ asset('js/moment.min.js') }}"></script>
  <script src="{{ asset('js/zh-tw.js') }}"></script>
  <script src="{{ asset('js/tempusdominus-bootstrap-4.js') }}"></script>
  <link href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">

  <!-- select2 -->
  <script src="{{ asset('js/select2.min.js') }}"></script>
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/select2-bootstrap.min.css') }}" rel="stylesheet">

  <!-- daterangepicker -->
  <script src="{{ asset('js/daterangepicker.min.js') }}"></script>
  <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet">

  <!-- 下拉多選 Rocky (2020/03/19) -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
  <script src="{{ asset('js/bootstrap-select.min.js') }} "></script>

  <!-- message 細分組搜尋 Joanna (2020/04/01) -->
  <link rel="stylesheet" href="{{ asset('css/icon_font.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery.transfer.css') }}">
  <script src="{{ asset('js/jquery.transfer.js') }} "></script>

  <!-- 民國年日期選擇器 Sandy (2020/04/02) -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
  <script src="{{ asset('js/bootstrap-datepicker.js') }} "></script>

  <!-- Custom styles -->
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
  <link href="{{ asset('css/web.css') }}" rel="stylesheet">
  <link href="{{ asset('css/form.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/course_list_chart.css') }}" rel="stylesheet">
  <!-- Excel 匯出 Rocky (2020/04/30) -->
  <style>
    .buttons-excel {
      color: #212529;
      cursor: pointer;
      background-color: transparent;
      border: 1px solid transparent;
      padding: .375rem .75rem;
      line-height: 1.5;
      border-radius: .25rem;
      color: #28a745;
      border-color: #28a745;
    }

    .buttons-excel:hover {
      color: #fff;
      background-color: #28a745;
    }

    /* table */
    /* th, td {
        white-space:nowrap;
    } */
    #table_list th,
    #table_list td {
      vertical-align: middle;
    }

    /* datatable excel button */
    div.dt-buttons {
      float: right;
      margin-bottom: 10px;
    }
  </style>
  <script src="{{ asset('js/datatables.buttons.min.js') }}"></script>
  <script src="{{ asset('js/jszip.min.js') }}"></script>
  <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
  <!-- Excel 匯出 Rocky (2020/04/30) -->
</head>

<body>
  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-1 shadow d-md-none">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3 " href="{{ route('course') }}">無極限學員系統</a>
    <button class="navbar-toggler position-absolute collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation" style="right: 10px;">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>
  <div class="container-fluid">
    <div class="row">
      @include('frontend.layouts.navbar')
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-2">

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
        <!-- success -->
        <div class="alert alert-success alert-dismissible m-3 position-fixed fixed-bottom" role="alert" id="success_alert">
          <span id="success_alert_text"></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- error -->
        <div class="alert alert-danger alert-dismissible m-3 position-fixed fixed-bottom" role="alert" id="error_alert">
          <span id="error_alert_text"></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- warn -->
        <div class="alert alert-warning alert-dismissible m-3 position-fixed fixed-bottom" role="alert" id="warn_alert">
          <span id="warn_alert_text"></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- alert End -->

      </main>
    </div>
  </div>

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
  {{-- <script src="{{ asset('js/otd.js') }}"></script> --}}

  <!-- feather icon -->
  <script>
    feather.replace()
  </script>
</body>

</html>