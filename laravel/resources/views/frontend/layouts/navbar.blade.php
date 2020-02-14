<!-- Navbar Start -->
<nav class="col-md-2 d-none d-md-block bg-dark sidebar">
    <div class="text-center nav-logo">
        <a href="#">
          <img src="./img/logo.png" width="60" class="rounded" alt="logo">
        </a>
    </div>
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item border-top">
              <a class="nav-link" href="{{ route('student') }}">
                {{-- <h6 class="sidebar-heading d-flex justify-content-start align-items-center px-3 mt-2 mb-1 text-muted"> --}}
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-file">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                  </svg>
                  &nbsp;學員管理
                {{-- </h6> --}}
              </a>
              <a class="nav-link nav-sub-item" href="{{ route('student_blacklist') }}">黑名單</a>
              <a class="nav-link nav-sub-item" href="{{ route('student_group') }}">細分組</a>
            </li>
            <li class="nav-item border-top">
              <a class="nav-link" href="{{ route('course') }}">
                {{-- <h6 class="sidebar-heading d-flex justify-content-start align-items-center px-3 mt-2 mb-1 text-muted"> --}}
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-shopping-cart">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                  </svg>
                  &nbsp;課程管理
                {{-- </h6> --}}
              </a>
              <a class="nav-link nav-sub-item" href="{{ route('course_list') }}">課程總覽</a>
              <a class="nav-link nav-sub-item" href="{{ route('course_today') }}">今日課程</a>
            </li>
            <li class="nav-item border-top">
              <a class="nav-link" href="{{ route('finance') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-users">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                  <circle cx="9" cy="7" r="4"></circle>
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                  <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                財務管理
              </a>
            </li>
            <li class="nav-item border-top">
              <a class="nav-link" href="{{ route('message') }}">
                {{-- <h6 class="sidebar-heading d-flex justify-content-start align-items-center px-3 mt-2 mb-1 text-muted"> --}}
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-bar-chart-2">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                  </svg>
                  &nbsp;訊息推播
                {{-- </h6> --}}
              </a>
              <a class="nav-link nav-sub-item" href="#">內容管理</a>
              <a class="nav-link nav-sub-item" href="#">推播排程</a>
            </li>
            <li class="nav-item border-top">
              <a class="nav-link" href="{{ route('report') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-bar-chart-2">
                  <line x1="18" y1="20" x2="18" y2="10"></line>
                  <line x1="12" y1="20" x2="12" y2="4"></line>
                  <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                數據報表
              </a>
            </li>
            <li class="nav-item border-top">
              <a class="nav-link" href="{{ route('system') }}">
                {{-- <h6 class="sidebar-heading d-flex justify-content-start align-items-center px-3 mt-2 mb-1 text-muted"> --}}
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-layers">
                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                    <polyline points="2 17 12 22 22 17"></polyline>
                    <polyline points="2 12 12 17 22 12"></polyline>
                  </svg>
                  &nbsp;系統設定
                {{-- </h6> --}}
              </a>
              <a class="nav-link nav-sub-item" href="#">權限管理</a>
            </li>
            {{-- <li class="nav-item border-top">
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
            </li> --}}
          </ul>
    </div>
</nav>
<!-- Navbar End -->