@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '查看')

@section('content')
<!-- Content Start -->
        <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row check_title">
              <div class="col-5">
                <p>講師姓名： Julia</p>
              </div>
              <div class="col-3">
                <p>講座名稱: 零秒成交術</p>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm class_table">
                <thead>
                  <tr>
                    <th>日期</th>
                    <th>場次</th>
                    <th>時間</th>
                    <th>地點</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>2019/11/22(四)</td>
                    <td>台北下午場</td>
                    <td>14:00-17:00</td>
                    <td>台北市中山區松江路131號7樓</td>
                  </tr>
                  <tr>
                    <td>2019/11/27(三)</td>
                    <td>台北晚上場</td>
                    <td>19:00-22:00</td>
                    <td>台北市中山區松江路131號7樓</td>
                  </tr>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
    <!-- Content End -->
@endsection