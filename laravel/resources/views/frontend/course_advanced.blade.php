@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '進階填單名單')

@section('content')
<!-- Content Start -->
       <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            {{-- <div class="row menu_search"> --}}
            <div class="row mb-3">
              <div class="col-3 mx-3">
                
              </div>
              <div class="col"></div>
              <div class="col-3">
                <input type="date" class="form-control" id="search_date">
              </div>
              <div class="col-3">
                <input type="search" class="form-control" placeholder="搜尋課程" aria-label="Class's name" id="search_name">
              </div>
              <div class="col-2">
                <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button> 
              </div>
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