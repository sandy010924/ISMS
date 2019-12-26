@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '課程總覽')

@section('content')
<!-- Content Start -->
        <!--搜尋課程頁面內容-->
        <div class="card mb-3">
          <div class="card-body">
            <div class="row menu_search">
              <div class="col-2">
                
              </div>
              <div class="col">
                <div class="input-group mb-3 search">
                  <input type="search" class="form-control" placeholder="搜尋課程" aria-label="Recipient's username"
                    aria-describedby="button-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">搜尋</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm class_table">
                <thead>
                  <tr>
                    <th>講師姓名</th>
                    <th>課程名稱</th>
                    <th>表單上場次數</th>
                    <th>總場次數</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Julia</td>
                    <td>零秒成交數</td>
                    <td>5</td>
                    <td>114</td>
                    <td>
                      <a href="{{ route('course_list_data') }}"><button type="button" class="btn btn-secondary btn-sm">場次數據</button></a>
                      <a href="{{ route('course_list_view') }}"><button type="button" class="btn btn-secondary btn-sm">查看</button></a>
                    </td>
                  </tr>
                  <tr>
                    <td>Julia</td>
                    <td>60天財富計畫</td>
                    <td>2</td>
                    <td>10</td>
                    <td>
                      <a href="#"><button type="button" class="btn btn-secondary btn-sm">場次數據</button></a>
                      <a href="#"><button type="button" class="btn btn-secondary btn-sm">查看</button></a>
                    </td>
                  </tr>
                  <tr>
                    <td>Jack</td>
                    <td>黑心外匯交易員的告白</td>
                    <td>5</td>
                    <td>123</td>
                    <td>
                      <a href="#"><button type="button" class="btn btn-secondary btn-sm">場次數據</button></a>
                      <a href="#"><button type="button" class="btn btn-secondary btn-sm">查看</button></a>
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      <!-- Content End -->
@endsection