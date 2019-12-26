@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '今日課程')

@section('content')
<!-- Content Start -->
        <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row menu_search">
              <div class="col-3"></div>
              <div class="col-9">
                <div class="input-group mb-3 search">
                  <input type="search" class="form-control" placeholder="搜尋課程" aria-label="Recipient's username"
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
                    <th>日期</th>
                    <th>課程名稱</th>
                    <th>場次</th>
                    <th>即時報名筆數</th>
                    <th>實到人數</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>2019/11/20(三)</td>
                    <td>零秒成交數</td>
                    <td>台北下午場</td>
                    <td>56/3</td>
                    <td></td>
                    <td><a href="{{ route('check') }}"><button type="button" class="btn btn-secondary btn-sm">開始報到</button></a>
                    </td>
                  </tr>
                  <tr>
                    <td>2019/11/20(三)</td>
                    <td>零秒成交數</td>
                    <td>台北晚上場</td>
                    <td>98/5</td>
                    <td></td>
                    <td><a href="{{ route('check') }}"><button type="button" class="btn btn-secondary btn-sm">開始報到</button></a>
                    </td>
                  </tr>
                  <tr>
                    <td>2019/11/20(二)</td>
                    <td>黑心外匯交易員的告白</td>
                    <td>台北晚上場</td>
                    <td>47</td>
                    <td></td>
                    <td><a href="{{ route('check') }}"><button type="button" class="btn btn-secondary btn-sm">開始報到</button></a>
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      <!-- Content End -->
@endsection