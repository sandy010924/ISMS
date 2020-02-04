@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '課程總覽')

@section('content')
<!-- Content Start -->
        <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">
            <div class="col-4 mx-3">
                <button type="button" class="btn btn-outline-secondary btn_date mr-3" data-toggle="modal" data-target="#form_newclass">新增課程</button>
                <button type="button" class="btn btn-outline-secondary btn_date mr-3" data-toggle="modal" data-target="#form_newclass">新增報名表</button>
              </div>
              <div class="col-6 mx-3">
                <div class="input-group">
                  <input type="search" class="form-control" placeholder="搜尋課程" aria-describedby="btn_search">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
                  </div>
                </div>
              </div>
              
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm class_table">
                <thead>
                  <tr>
                    <th>講師姓名</th>
                    <th>類別</th>
                    <th>課程名稱</th>
                    <th>表單上場次數</th>
                    <th>總場次數</th>
                    <th>累計名單</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Julia</td>
                    <td>銷講</td>
                    <td>零秒成交數</td>
                    <td>5</td>
                    <td>114</td>
                    <td>2154</td>
                    <td>
                      <div class="dropdown">
                          <button class="btn btn-secondary btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            名單
                          </button>
                          <div class="dropdown-menu dropdown_status" aria-labelledby="dropdownMenu2">
                            <a href="{{ route('course_list_apply') }}"><button class="dropdown-item" type="button" onclick="#">報名名單</button></a>
                            <a href="{{ route('course_list_refund') }}"><button class="dropdown-item" type="button" onclick="#">退費名單</button></a>
                          </div>
                          <a href="#"><button type="button" class="btn btn-secondary btn-sm">場次數據</button></a>
                          <!--<a href="#"><button type="button" class="btn btn-secondary btn-sm">查看</button></a>-->
                          <a href="#"><button type="button" class="btn btn-secondary btn-sm">編輯</button></a>
                          <a href="#"><button type="button" class="btn btn-secondary btn-sm">刪除</button></a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Julia</td>
                    <td>二階課程</td>
                    <td>60天財富計畫</td>
                    <td>2</td>
                    <td>10</td>
                    <td>3123</td>
                    <td>
                      <div class="dropdown">
                          <button class="btn btn-secondary btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            名單
                          </button>
                          <div class="dropdown-menu dropdown_status" aria-labelledby="dropdownMenu2">
                            <a href="#"><button class="dropdown-item" type="button" onclick="#">報名名單</button></a>
                            <a href="#"><button class="dropdown-item" type="button" onclick="#">退費名單</button></a>
                          </div>
                          <a href="#"><button type="button" class="btn btn-secondary btn-sm">場次數據</button></a>
                          <!--<a href="#"><button type="button" class="btn btn-secondary btn-sm">查看</button></a>-->
                          <a href="#"><button type="button" class="btn btn-secondary btn-sm">編輯</button></a>
                          <a href="#"><button type="button" class="btn btn-secondary btn-sm">刪除</button></a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Jack</td>
                    <td>三階課程A</td>
                    <td>黑心外匯交易員的告白</td>
                    <td>5</td>
                    <td>123</td>
                    <td>454</td>
                    <td>
                      <div class="dropdown">
                          <button class="btn btn-secondary btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            名單
                          </button>
                          <div class="dropdown-menu dropdown_status" aria-labelledby="dropdownMenu2">
                            <a href="#"><button class="dropdown-item" type="button" onclick="#">報名名單</button></a>
                            <a href="#"><button class="dropdown-item" type="button" onclick="#">退費名單</button></a>
                          </div>
                          <a href="#"><button type="button" class="btn btn-secondary btn-sm">場次數據</button></a>
                          <!--<a href="#"><button type="button" class="btn btn-secondary btn-sm">查看</button></a>-->
                          <a href="#"><button type="button" class="btn btn-secondary btn-sm">編輯</button></a>
                          <a href="#"><button type="button" class="btn btn-secondary btn-sm">刪除</button></a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Jack</td>
                    <td>三階課程A</td>
                    <td>黑心外匯交易員的告白</td>
                    <td>54</td>
                    <td>154</td>
                    <td>987</td>
                    <td>
                      <div class="dropdown">
                          <button class="btn btn-secondary btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            名單
                          </button>
                          <div class="dropdown-menu dropdown_status" aria-labelledby="dropdownMenu2">
                            <a href="#"><button class="dropdown-item" type="button" onclick="#">報名名單</button></a>
                            <a href="#"><button class="dropdown-item" type="button" onclick="#">退費名單</button></a>
                          </div>
                          <a href="#"><button type="button" class="btn btn-secondary btn-sm">場次數據</button></a>
                          <!--<a href="#"><button type="button" class="btn btn-secondary btn-sm">查看</button></a>-->
                          <a href="#"><button type="button" class="btn btn-secondary btn-sm">編輯</button></a>
                          <a href="#"><button type="button" class="btn btn-secondary btn-sm">刪除</button></a>
                      </div>
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      <!-- Content End -->
@endsection