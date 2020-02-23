<html lang="zh-TW">

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

<body>
  
  <main role="main" class="px-4 main_body text-center">
    <div class="row w-50 mx-auto error" style="position: relative; transform:translateY(100%);">
      <div class="col-4 error_img">
        <img src="./img/attention.png" width="80%"class=" mx-auto my-3" >
      </div>
      <div class="col-8 error_msg">
        <div class="card mx-auto bg-transparent border-white my-5" >
          <div class="card-body " >
            <span class="h1 text-white"><b>使用者權限不足!</b></span><br>
            <button type="button" class="btn btn-info my-auto" onclick="lastpage()" >返回上一頁</button>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/feather.min.js') }}"></script>
  <script src="{{ asset('js/style.js') }}"></script>
  
</body>

</html>