@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '學員列表')

@section('content')
<!-- Content Start -->
        <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row menu_search">
              <div class="col">
                <div class="input-group mb-3">
                  <input type="search" class="form-control" placeholder="搜尋手機" aria-label="Recipient's username"
                    aria-describedby="button-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">搜尋</button>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="input-group mb-3">
                  <input type="search" class="form-control" placeholder="搜尋姓名" aria-label="Recipient's username"
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
                    <th>姓名</th>
                    <th>連絡電話</th>
                    <th>信箱</th>
                    <td></td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>王曉明</td>
                    <td>0912345678</td>
                    <td>asd123123@gmail.com</td>
                    <td><button type="button" class="btn btn-secondary btn-sm">詳細資訊</button></td>
                  </tr>
                  <tr>
                    <td>陳美美</td>
                    <td>0987654321</td>
                    <td>ppqq1478@gmail.com</td>
                    <td><button type="button" class="btn btn-secondary btn-sm">詳細資訊</button></td>
                  </tr>
                  <tr>
                    <td>蔡阿祥</td>
                    <td>0911223344</td>
                    <td>sfsdf45457@gmail.com</td>
                    <td><button type="button" class="btn btn-secondary btn-sm">詳細資訊</button></td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
<!-- Content End -->
@endsection
     