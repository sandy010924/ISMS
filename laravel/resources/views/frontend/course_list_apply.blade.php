@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '報名名單')

@section('content')
<!-- Content Start -->
        <!--查看報名名單-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row">
              <div class="col align-middle">
                <h5>
                  ...
                </h5>
              </div>
              <div class="col align-middle text-right">
                <h5>報名筆數 : </h5>
              </div>
              <hr/>
            </div>
          </div>
        </div>
        <div class="card m-3">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-3 mx-auto">
                       <div class="input-group">
                          <input type="search" class="form-control" placeholder="電話末三碼" aria-describedby="btn_search">
                          <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-sm text-center" id="table_apply">
                    <thead>
                      <tr>
                        <th>姓名</th>
                        <th>連絡電話</th>
                        <th>電子郵件</th>
                        <th>狀態</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
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