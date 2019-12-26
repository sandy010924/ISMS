<html lang="zh-TW">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Jekyll v3.8.6">
  
  <title>@yield('title') | 無極限學員系統</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/dashboard/">
  
  <!-- Bootstrap core CSS -->
  <link href="https://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  
    <!-- Fontawesome Icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
    integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>

  <!-- Custom styles -->
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
  <link href="{{ asset('css/web.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
  
<div class="container-fluid ">
    <div class="row">
      <main role="main" class="col-md-9 col-lg-10 px-4 main_body ">
        <div class="card mb-3 login_back">
          <div class="card-body">
          <form class="login_form">
            <img src="./img/logo.png" width="150" alt="logo" style="display:block; margin:3% auto;">
            <div class="container">
              <label for="uname"><b>帳號</b></label>
              <input type="text" placeholder="Enter Username" name="uname" required class="login_input">
          
              <label for="psw"><b>密碼</b></label>
              <input type="password" placeholder="Enter Password" name="psw" required class="login_input">
          
            <a href="{{ route('course') }}"><input type="button" class="login_button" value="登入"></a>
              
            </div>
          </form>
          </div>
          </div>
       </div>
        </main>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
  <script src="https://getbootstrap.com/docs/4.4/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>

</body>

</html>