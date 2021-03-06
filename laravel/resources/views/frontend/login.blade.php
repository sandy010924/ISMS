<html lang="zh-TW">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>登入 | 無極限學員系統</title>

  {{-- <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/dashboard/"> --}}

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  {{-- <link href="https://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> --}}

  <!-- Fontawesome Icon -->
  {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
    integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"> --}}
  <link href="{{ asset('font-awesome/css/all.css') }}" rel="stylesheet">

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
                <input type="text" placeholder="Enter Username" name="uname" id="uname" required class="login_input">
                <label for="psw"><b>密碼</b></label>
                <input type="password" placeholder="Enter Password" name="psw" id="psw" required class="login_input">
                <!-- Rocky 2020/02/05 -->
                <button type="button" class="login_button" id="login_button" value="登入">登入</button>
              </div>
            </form>
          </div>
        </div>
    </div>
    </main>
  </div>
  </div>


  <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/feather.min.js') }}"></script>
  {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> --}}
  {{-- <script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script> --}}
  {{-- <script src="https://getbootstrap.com/docs/4.4/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
    crossorigin="anonymous"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script> --}}

  <!-- Rocky (2020/02/05) -->
  <script>
    // 輸入框
    $('#psw').on('keyup', function(e) {
      if (e.keyCode === 13) {
        $('#login_button').click();
      }
    });

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    // 登入
    $("#login_button").click(function(e) {
      var uname = $("#uname").val();
      var psw = $("#psw").val();
      $.ajax({
        type: 'POST',
        url: 'login',
        data: {
          '_token': "{{ csrf_token() }}",
          uname: uname,
          psw: psw
        },
        success: function(data) {
          console.log(data)
          switch (data) {
            case 'admin':
              window.location.href = "./course_list";
              break;
            case 'marketer':
              window.location.href = "./student";
              break;
            case 'accountant':
              window.location.href = "./finance";
              break;
            case 'staff':
              window.location.href = "./ots_course_today";
              break;
            case 'teacher':
              window.location.href = "./course_list";
              break;
            case 'msaleser':
              window.location.href = "./course_list";
              break;
            case 'officestaff':
              window.location.href = "./course_list";
              break;
            case 'saleser':
              window.location.href = "./course_list";
              break;
            default:
              alert('請確認帳號密碼 / 狀態')
          }
        },
        error: function(data) {
          console.log(data)
        }
      });
    });
  </script>
</body>

</html>