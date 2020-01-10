@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '報名名單')

@section('content')
<!-- Content Start -->
        <!--開始報到內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row">
              <div class="col align-middle">
                <h5>零秒成交數 2019/11/20（四） 台北下午場</h5>
              </div>
              <div class="col align-middle text-right">
                <h5>報名筆數 : 3</h5>
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
                        <td>王曉明</td>
                        <td>0912345678</td>
                        <td>asd123123@gmail.com</td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn btn-sm text-white apply_btn" id="1" value="0"></button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>陳美美</td>
                        <td>0987654321</td>
                        <td>ppqq1478@gmail.com</td>
                        <td>
                            <div class="dropdown">
                              <button type="button" class="btn btn-sm text-white apply_btn" id="2" value="3"></button>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <td>蔡阿祥</td>
                        <td>0911223344</td>
                        <td>sfsdf45457@gmail.com</td>
                        <td>
                            <div class="dropdown">
                              <button type="button" class="btn btn-sm text-white apply_btn" id="3" value="0"></button>
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