@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '細分組')

@section('content')
<!-- Content Start -->
        <!--學員細分組內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row">
              <div class="col-3 mx-auto">
                <button class="btn btn-outline-secondary" type="button" id="btn_newgroup">創建細分組</button>
              </div>
              <div class="col-6 mx-auto">
                <div class="input-group mb-3">
                  <input type="search" class="form-control" placeholder="輸入細分組名稱" aria-label="Group's name" aria-describedby="btn_search">
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
                    <th>細分組名稱</th>
                    <th>創建日期</th>
                    <th>名單筆數</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="align-middle">JC學員</td>
                    <td class="align-middle">2019年12月18日</td>
                    <td class="align-middle">95</td>
                    <td class="align-middle">
                      <a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1">編輯</button></a>
                      <a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1">複製</button></a>
                      <a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1">刪除</button></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
<!-- Content End -->
@endsection
     