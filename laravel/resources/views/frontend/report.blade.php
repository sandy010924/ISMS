@extends('frontend.layouts.master')

@section('title', '數據報表')
@section('header', '數據報表')

@section('content')
<!-- Content Start -->
        <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-5 mx-auto">
                <div class="input-group">
                  <input type="search" class="form-control" placeholder="搜尋課程" aria-describedby="btn_search">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>講師姓名</th>
                    <th>類別</th>
                    <th>課程名稱</th>
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
                    <td>114</td>
                    <td>2154</td>
                    <td>
                      <a href="{{ route('report_data') }}"><button type="button" class="btn btn-secondary btn-sm">場次數據</button></a>
                    </td>
                  </tr>
                  <tr>
                    <td>Julia</td>
                    <td>二階課程</td>
                    <td>60天財富計畫</td>
                    <td>10</td>
                    <td>3123</td>
                    <td>
                      <a href="#"><button type="button" class="btn btn-secondary btn-sm">場次數據</button></a>
                    </td>
                  </tr>
                  <tr>
                    <td>Jack</td>
                    <td>三階課程A</td>
                    <td>黑心外匯交易員的告白</td>
                    <td>123</td>
                    <td>454</td>
                    <td>
                      <a href="#"><button type="button" class="btn btn-secondary btn-sm">場次數據</button></a>
                    </td>
                  </tr>
                  <tr>
                    <td>Jack</td>
                    <td>三階課程A</td>
                    <td>黑心外匯交易員的告白</td>
                    <td>154</td>
                    <td>987</td>
                    <td>
                      <a href="#"><button type="button" class="btn btn-secondary btn-sm">場次數據</button></a>
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      <!-- Content End -->
@endsection