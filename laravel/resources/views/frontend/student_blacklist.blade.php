@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '黑名單')

@section('content')
<!-- Content Start -->
        <!--黑名單內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">
                <div class="col-5 mx-auto">
                  <div class="input-group">
                    <input type="search" class="form-control" placeholder="輸入電話或email" aria-label="Phone or Email">
                  </div>
                </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>姓名</th>
                    <th>連絡電話</th>
                    <th>電子郵件</th>
                    <th>原因</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <tr>
                    <td>王曉明</td>
                    <td>0912345678</td>
                    <td>a124445@gmail.com</td>
                    <td>銷講報到率</td>
                    <td>
                        <a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1">完整內容</button></a>
                        <a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1">取消黑名單</button></a>
                    </td>
                  </tr>
                  <tr>
                    <td>陳小美</td>
                    <td>0987654321</td>
                    <td>qwes1458@gmail.com</td>
                    <td>報名多次未到</td>
                    <td>
                        <a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1">完整內容</button></a>
                        <a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1">取消黑名單</button></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
<!-- Content End -->
@endsection
     