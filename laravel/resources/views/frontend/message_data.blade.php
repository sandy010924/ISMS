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
                    <span class="input-group-text">寄件日期</span>
                  </div>
                  <input type="text" class="form-control bg-white" aria-label="Group's name" value="2020-02-18" disabled readonly>
                </div>
              </div>
              <div class="col">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">發送方式</span>
                  </div>
                  <input type="text" class="form-control bg-white" aria-label="Group's name" value="簡訊、Email" disabled readonly>
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
想更了解外匯交易，
卻擔心學的不夠多🙋🙋‍♂
別擔心! 傑克教練線上教室要開課了
手刀卡位：https://lihi1.com/97BjY/line

看直播好處
1. 免費學賺錢的技術💰
聽聽長期待在交易市場操盤手是怎麼樣長期穩定獲利來賺錢

2.現在仍處於防疫狀態，人多的地方少去，沒事多在家，在家不但不用花錢還可以學賺錢👍

3.防疫一定要做，當時機來臨時也要及時掌握⏰，走在對的路上

除了以上眾多好處外.....
最重要的當然還是..
多學一樣賺錢的技能來充實自己🎁
萬一哪天金融巨浪襲來～被裁員，你也不用怕啦！
                  </textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-5 mx-auto mb-3">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">細分組名稱</span>
                  </div>
                  <input type="text" class="form-control bg-white" aria-label="Group's name" value="黑心忠實學員" disabled readonly>
                </div>
              </div>
            </div>
            <div class="table-responsive">
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
            </div>
          </div>
        </div>
      </div>

<!-- Content End -->

@endsection