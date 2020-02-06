@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '學員管理')

@section('content')
<!-- Content Start -->
        <!--搜尋學員頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-5 mx-auto">
                  <input type="search" class="form-control" placeholder="輸入電話或email" aria-label="Student's Phone or Email" id="search_input">
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>姓名</th>
                    <th>聯絡電話</th>
                    <th>電子郵件</th>
                    <th>來源</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($students as $student)
                    <tr>
                      <td class="align-middle">{{ $student->name }}</td>
                      <td class="align-middle">{{ $student->phone }}</td>
                      <td class="align-middle">{{ $student->email }}</td>
                      <td class="align-middle">
                        
                      </td>
                      <td class="align-middle">
                        <a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1">完整內容</button></a>
                        <a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1">列入黑名單</button></a>
                        <a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1">已填表單</button></a>
                        <a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1">刪除</button></a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
<!-- Content End -->
@endsection
     