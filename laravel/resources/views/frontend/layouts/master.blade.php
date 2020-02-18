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
  {{-- <link href="https://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> --}}

    <!-- Fontawesome Icon -->
  <link href="{{ asset('font-awesome/css/all.css') }}" rel="stylesheet">
  <!-- Custom styles -->
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
  <link href="{{ asset('css/web.css') }}" rel="stylesheet">
  <link href="{{ asset('css/form.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/course_list_chart.css') }}" rel="stylesheet">

  <!-- Rocky(2020/01/11) --> <!-- Sandy(2020/01/31) -->
  <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
</head>

<body>
  <div class="container-fluid">

      @include('frontend.layouts.navbar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10">

          @include('frontend.layouts.header')

          @yield('content')

        </main>
  </div>

  <!-- Rocky(2020/02/17) -->
  <script>  
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  </script>
  <!-- Sandy(2020/01/31) -->
  {{-- <script src="https://getbootstrap.com/docs/4.4/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
    crossorigin="anonymous"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script> --}}
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/feather.min.js') }}"></script>
  <script src="{{ asset('js/style.js') }}"></script>
  <script src="{{ asset('js/otd.js') }}"></script>
  <!-- Sandy(2020/02/07) -->
  {{-- <script src="{{ asset('js/Chart.min.js') }}"></script> --}}
  {{-- <script src="{{ asset('js/course_list_chart.js') }}"></script> --}}
</body>

</html>