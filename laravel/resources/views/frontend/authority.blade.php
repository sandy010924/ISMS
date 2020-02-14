@extends('frontend.layouts.master')

@section('title', '系統設定')
@section('header', '權限管理')

@section('content')
<!-- Content Start -->
       <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">
              
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>日期</th>
                    <th>課程名稱</th>
                    <th>場次</th>
                    <th>報名筆數</th>
                    <th>實到筆數</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="course_list">
                
                </tbody>
              </table>
            </div>
          </div>
        </div>

<!-- Content End -->

@endsection