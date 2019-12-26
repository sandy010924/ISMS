@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '回報表單')

@section('content')
<!-- Content Start -->
        <!--現場表單頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="title">
              <div class="row form_title">
                <div class="col-7">
                  <p class="form_text">零秒成交數 2019/11/20 台北下午場</p>
                </div>
                <div class="col-5">
                  <p class="form_text">講座地點 : </p>
                </div>


              </div>
              <div class="row">
                <div class="col-3">
                  <p class="form_text">主持開收 : </p>
                </div>
                <div class="col-3">
                  <p class="form_text">工作人員 : </p>
                </div>
                <div class="col-3">
                  <p class="form_text">天氣 : </p>
                </div>
                <div class="col-3">
                  <p class="form_text">該場備註 : <input type="text" class="form_input"></p>
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <p class="form_text">現場完款 : <input type="text" class="form_input"></p>
                </div>
                <div class="col-3">
                  <p class="form_text">五日內完款 : <input type="text" class="form_input"></p>
                </div>
                <div class="col-3">
                  <p class="form_text">分期付款 : <input type="text" class="form_input"></p>
                </div>
                <div class="col-3">
                  <p class="form_text">該場總金額 : </p>
                </div>

              </div>
            </div>
            <div class="table-responsive ">
              <table class="table table-striped table-sm class_table form_table">
                <thead>
                  <tr>
                    <th>學員姓名</th>
                    <th>連絡電話</th>
                    <th>付款狀態</th>
                    <th>應付</th>
                    <th>已付</th>
                    <th>待付</th>
                    <th>付款方式1</th>
                    <th>金額1</th>
                    <th>帳戶/卡號後四碼1</th>
                    <th>付款方式2</th>
                    <th>金額2</th>
                    <th>帳戶/卡號後四碼2</th>
                    <th>付款方式3</th>
                    <th>金額3</th>
                    <th>帳戶/卡號後四碼3</th>
                    <th>服務人員</th>
                    <th>追單人員</th>
                    <th>備註</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
<!-- Content End -->
@endsection