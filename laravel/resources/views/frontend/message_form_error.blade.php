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

  <style>
    html, body{
      background-color: #f4f4f4;
    }
    .feather{
      width: 200px;
      height: 200px;
    }
  </style>
</head>

<body>
  <div class="container">
    <img src="{{ asset('img/logo_black.png') }}" width="100" alt="logo" class="d-block mx-auto mt-5">
    {{-- <h4 class="text-center text-white font-weight-bold m-4">無極限國際有限公司</h4> --}}
    <div div="row">
      <div class="col-md-6 mx-auto text-center my-3">
          <i data-feather="x-circle" class="text-danger my-5"></i>
          <h1>報名失敗！</h1>
          <a role="button" class="btn btn-danger px-4 mt-3" href="{{ route('message_form',['id'=>$id]) }}" >重新報名</a>
      </div>
    </div>
  </div>
</body>


<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/feather.min.js') }}"></script>
{{-- <script src="{{ asset('js/form.js') }}"></script> --}}


<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  //feather icon
  feather.replace()
</script>

</html>
