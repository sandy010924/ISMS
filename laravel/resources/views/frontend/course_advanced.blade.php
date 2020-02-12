@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '進階填單名單')

@section('content')
<!-- Content Start -->
       <!--搜尋課程頁面內容-->
       <div class="card m-3">
          <div class="card-body">
            <div class="row">
              <div class="col-3 align-middle">
                <h6>
                      講師名稱 : <input type="text" class="mt-2" readonly>
                </h6>
              </div>
              <div class="col-3 align-middle">
                <h6>
                    課程名稱 : <input type="text" class="mt-2" readonly>
                </h6>
              </div>
              <hr/>
            </div>
          </div>
        </div>
        <div class="card m-3">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6 p-2 ml-2">
                        <h6 class="mb-0">2019/12/31(五)&nbsp;&nbsp;台北下午場&nbsp;&nbsp;零秒成交數&nbsp;&nbsp;填單筆數:5</h6>
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-3 align-right">
                      <div class="input-group">
                          <input type="number" class="form-control" placeholder="關鍵字"  max="999">
                          <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">搜尋</button>
                          </div>
                      </div>
                    </div>
                </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>Submission Date</th>
                    <th>報名日期</th>
                    <th>姓名</th>
                    <th>聯絡電話</th>
                    <th>電子郵件</th>
                    <th>我想參加課程</th>
                    <th>報名場次</th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>現場最優惠價格</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><a href="#"><button type="button" class="btn btn-secondary btn-sm">刪除</button></a></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>五日內最優惠價格</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><a href="#"><button type="button" class="btn btn-secondary btn-sm">刪除</button></a></td>
                    </tr>
                    
                  </tbody>
              </table>
            </div>
          </div>
        </div>
<!-- Content End -->
@endsection