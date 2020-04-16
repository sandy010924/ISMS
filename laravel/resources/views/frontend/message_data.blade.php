@extends('frontend.layouts.master')

@section('title', '訊息推播')
@section('header', '詳細內容')

@section('content')
<!-- Content Start -->
       <!-- 訊息資訊內容 -->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">
              {{-- <div class="col-5">
                <h5>寄件日期：2020-02-18</h5>
              </div> --}}
              <div class="col">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">寄件時間</span>
                  </div>
                  <input type="text" class="form-control bg-white" aria-label="Group's name" value="{{ $msg->send_at }}" disabled readonly>
                </div>
              </div>
              <div class="col">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">發送方式</span>
                  </div>
                  <input type="text" class="form-control bg-white" aria-label="Group's name" value=" @if($msg->type==0)簡訊 @else Email @endif" disabled readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                {{-- <label for="msg_content">訊息內容</label>
                <textarea class="form-control" id="msg_content" rows="3"></textarea>                --}}
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">訊息內容</span>
                  </div>
                  <textarea class="form-control bg-white" aria-label="With textarea" rows="5" disabled readonly>
{{ $msg->content }}
                  </textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card m-3">
          <div class="card-body">
            {{-- <div class="row mb-3">
              <div class="col-5 mx-auto mb-3">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">細分組名稱</span>
                  </div>
                  <input type="text" class="form-control bg-white" aria-label="Group's name" value="黑心忠實學員" disabled readonly>
                </div>
              </div>
            </div> --}}
            @component('components.datatable')
              @slot('thead')
                <tr>
                  <th>姓名</th>
                  <th>聯絡電話</th>
                  <th>email</th>
                </tr>
              @endslot
              @slot('tbody')
                @foreach($sender as $data )
                <tr>
                  <td>{{ $data['name'] }}</td>
                  <td>{{ $data['phone'] }}</td>
                  <td>{{ $data['email'] }}</td>
                </tr>
                @endforeach
              @endslot
            @endcomponent
            {{-- <div class="table-responsive">
              <table class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>姓名</th>
                    <th>聯絡電話</th>
                    <th>電子信箱</th>
                    <th>目前職業</th>
                  </tr>
                </thead>
                  <tbody id="table_list">
                    <tr>
                      <td>周祥詮</td>
                      <td>0912345436</td>
                      <td>joy@abc.com</td>
                      <td>科技業</td>
                    </tr>
                    <tr>
                      <td>陳建華</td>
                      <td>0932455467</td>
                      <td>aabc@test.com</td>
                      <td>服務業</td>
                    </tr>
                    <tr>
                      <td>李宜貞</td>
                      <td>0970488096</td>
                      <td>qqss@oxox.com.tw</td>
                      <td>資訊業</td>
                    </tr>
                  </tbody>
              </table>
            </div> --}}
          </div>
        </div>
      </div>

<!-- Content End -->

@endsection