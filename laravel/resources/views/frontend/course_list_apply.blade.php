@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '報名名單')

@section('content')
<!-- Content Start -->
        <!--查看報名名單-->
        
        <div class="card m-3">
            <div class="card-body">
                <div class="row mb-3">
                  <div class="col-3 align-middle">
                    <h6>
                      講師名稱<input type="text" class="mt-2" readonly>
                    </h6>
                  </div>
                  <div class="col-3 align-middle">
                    <h6>
                      課程名稱<input type="text" class="mt-2" readonly>
                    </h6>
                  </div>
                  <div class="col-3 text-right">
                    <h6>累計名單 : <input type="text" class="mt-2" style="border:0;"readonly></h6>
                  </div>
                  <hr/>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-sm text-center" id="table_apply">
                    <thead>
                      <tr>
                        <th>Submission Date</th>
                        <th>名單來源</th>
                        <th>(課程名稱)報名場次</th>
                        <th>聯絡電話</th>
                        <th>電子郵件</th>
                        <th>目前職業</th>
                        <th>我想在講座中了解的內容</th>
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