@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '場次數據圖表')

@section('content')

  @include('components.course_list_chart')

  <!-- 名單列表內容 -->
    <div class="card m-3">
      <div class="card-body">
        <div class="row mb-3">
          <div class="col align-self-center">
            <span class="h5 pl-1">報名名單</span>
          </div>
          <div class="col text-right">
            <button type="button" class="btn btn-outline-secondary mx-1">匯出名單</button>  
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-sm text-center">
            <thead>
              <tr>
                <th>Submission Date</th>
                <th>名單來源</th>
                <th>姓名</th>
                <th>聯絡電話</th>
                <th>電子郵件</th>
                <th>目前職業</th>
                <th>報到</th>
                <th>付款狀態</th>
              </tr>
            </thead>
            <tbody id="table_list">
              <tr>
                <td>2020-01-05 20:32:36</td>
                <td>FB</td>
                <td>周祥詮</td>
                <td>0912345436</td>
                <td>joy@abc.com</td>
                <td>科技業</td>
                <td>報到</td>
                <td>完款</td>
              </tr>
              <tr>
                <td>2020-01-05 15:12:26</td>
                <td>Line</td>
                <td>陳建華</td>
                <td>0932455467</td>
                <td>aabc@test.com</td>
                <td>服務業</td>
                <td>報到</td>
                <td>付訂</td>
              </tr>
              <tr>
                <td>2020-01-05 10:32:20</td>
                <td>FB</td>
                <td>李宜貞</td>
                <td>0970488096</td>
                <td>qqss@oxox.com.tw</td>
                <td>資訊業</td>
                <td>報到</td>
                <td>留單</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
@endsection