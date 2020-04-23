<!-- Navbar Start -->
<nav class="col-md-2 d-none d-md-block bg-dark sidebar" id="isms_nav">
  <div class="text-center nav-logo">
    <a href="#">
      <img src="./img/logo.png" width="60" class="rounded" alt="logo">
    </a>
  </div>
  <div class="sidebar-sticky">
    @if (Auth::user() == null)
    @php
    header("Location: ./error_authority");
    exit;
    @endphp
    @endif

    <ul class="nav flex-column">
      <!-- 學員管理 -->
      @if (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'accountant' || Auth::user()->role == 'saleser' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'officestaff')
      <li class="nav-item border-top">
        <a class="nav-link" href="{{ route('student') }}">
          <i data-feather="users"></i>
          學員管理
        </a>
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'saleser' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'officestaff')
        <a class="nav-link nav-sub-item" href="{{ route('student_group') }}">名單列表</a>
        <a class="nav-link nav-sub-item" href="{{ route('student_blacklist') }}">黑名單</a>
        @endif
      </li>
      @endif
      <!-- 學員管理 -->

      <!-- 課程管理 -->
      @if (Auth::user()->role == 'admin' || Auth::user()->role == 'teacher' || Auth::user()->role == 'marketer' || Auth::user()->role == 'staff' || Auth::user()->role == 'saleser' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'officestaff' )
      <li class="nav-item border-top">
        <a class="nav-link" href="{{ route('course_list') }}">
          <i data-feather="book-open"></i>
          課程管理
        </a>
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'teacher' || Auth::user()->role == 'marketer' || Auth::user()->role == 'saleser' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'officestaff')
        <a class="nav-link nav-sub-item" href="{{ route('course') }}">場次總覽</a>
        @endif
        <a class="nav-link nav-sub-item" href="{{ route('course_today') }}">今日課程</a>
      </li>
      @endif
      <!-- 課程管理 -->

      <!-- 財務管理 -->
      @if (Auth::user()->role == 'admin' || Auth::user()->role == 'accountant' || Auth::user()->role == 'marketer' || Auth::user()->role == 'saleser' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'officestaff')
      <li class="nav-item border-top">
        <a class="nav-link" href="{{ route('finance') }}">
          <i data-feather="dollar-sign"></i>
          財務管理
        </a>
      </li>
      @endif
      <!-- 財務管理 -->

      <!-- 訊息推播 -->
      @if (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'accountant' || Auth::user()->role == 'officestaff')
      <li class="nav-item border-top">
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'officestaff' )
        <a class="nav-link" href="{{ route('message_list') }}">
          <i data-feather="mail"></i>
          訊息推播
        </a>
        @else
        <a class="nav-link" href="#">
          <i data-feather="mail"></i>
          訊息推播
        </a>
        @endif
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' )
        <a class="nav-link nav-sub-item" href="#">自動訊息</a>
        @endif
        <a class="nav-link nav-sub-item" href="{{ route('message_result') }}">推播成效</a>
      </li>
      @endif
      <!-- 訊息推播 -->

      <!-- 數據報表 -->
      @if (Auth::user()->role == 'admin' || Auth::user()->role == 'dataanalysis' || Auth::user()->role == 'accountant' || Auth::user()->role == 'officestaff')
      <li class="nav-item border-top">
        <a class="nav-link" href="{{ route('report_chart') }}">
          <i data-feather="pie-chart"></i>
          數據報表
        </a>
      </li>
      @endif
      <!-- 數據報表 -->

      <!-- 系統設定 -->
      @if (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'officestaff')
      <li class="nav-item border-top">
        {{-- <a class="nav-link" href="{{ route('system') }}"> --}}
        <a class="nav-link" href="#">
          <i data-feather="settings"></i>
          系統設定
        </a>
        <a class="nav-link nav-sub-item" href="{{ route('authority') }}">權限管理</a>
        @if (Auth::user()->role == 'admin' )
        <a class="nav-link nav-sub-item" href="{{ route('database') }}">備份管理</a>
        @endif
        <a class="nav-link nav-sub-item" href="{{ route('blacklist_rule') }}">黑名單規則</a>
      </li>
      @endif
      <!-- 系統設定 -->

      <!-- {{-- <li class="nav-item border-top">
              <a class="nav-link" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-users">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                  <circle cx="9" cy="7" r="4"></circle>
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                  <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                成本管理
              </a>
            </li> --}} -->
    </ul>
  </div>
</nav>
<!-- Navbar End -->