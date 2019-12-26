<!-- Header Start -->
{{-- <div class="card header-card mb-3">
    <div class="card-body">
        <div class="d-flex flex-wrap flex-md-nowrap align-items-center">
            <h5 class="h5 font-weight-bold">@yield('header')</h5>
            <h6 class="h6 float-right"><span class="far fa-user"></span> 王小明</h6>
            <i class="fas fa-sign-out-alt float-right"></i>
        </div>
    </div>
</div> --}}

<div class="header container shadow px-4 py-3 bg-white">
  <div class="row">
    <div class="col">
      <span class="h5 font-weight-bold">@yield('header')</span>
    </div>
    <div class="col text-right">
      <span class="h6 mr-3 align-middle"><li class="far fa-user"></li> 王小明</span>
      <a href="#" class="logout"><span class="h6 align-middle"><li class="fas fa-sign-out-alt"></li> 登出</span></a>
    </div>
  </div>
</div>
<!-- Header End -->