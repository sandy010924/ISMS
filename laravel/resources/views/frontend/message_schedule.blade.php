@extends('frontend.layouts.master')

@section('title', '訊息推播')
@section('header', '推播排程')

@section('content')
<!-- Content Start -->
       <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-header">
            正課報名
          </div>
          <div class="card-body p-3">
            {{-- <div class="row mb-3">
              <div class="col-5">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"></span>
                  </div>
                  <input type="text" class="form-control bg-white" aria-label="Group's name" value="黑心忠實學員" disabled readonly>
                </div>
              </div>
            </div> --}}
            <div class="row mb-5">
              <div class="col">
                <h6 class="card-title font-weight-bold">填完表單成功時發送</h6>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">訊息內容</span>
                  </div>
                  <textarea class="form-control bg-white" aria-label="With textarea" rows="3">
報名成功！．．．．．．
                  </textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <h6 class="card-title font-weight-bold">報到提醒</h6>
                <div class="row mb-3">
                  <div class="col-3">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">倒數</span>
                      </div>
                      <input type="text" class="form-control" aria-label="" value="3">
                      <div class="input-group-append">
                        <span class="input-group-text">天</span>
                      </div>
                    </div>
                  </div>
                  <div class="col align-self-center">
                    <span class="card-text h6 mr-3">發送方式：</span>
                    <div class="custom-control custom-checkbox d-inline mx-1">
                      <input type="checkbox" class="custom-control-input" id="customCheck1">
                      <label class="custom-control-label h6" for="customCheck1">簡訊</label>
                    </div>
                    <div class="custom-control custom-checkbox d-inline mx-1">
                      <input type="checkbox" class="custom-control-input" id="customCheck2">
                      <label class="custom-control-label h6" for="customCheck2">Email</label>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">訊息內容</span>
                      </div>
                      <textarea class="form-control bg-white" aria-label="With textarea" rows="3">
您好，提醒您3天就是【XXX】課程，我們不見不散．．．．．．
                      </textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col text-right">
                <button class="btn btn-primary" type="button">儲存</button>
              </div>
            </div>
          </div>
        </div>

<!-- Content End -->

@endsection