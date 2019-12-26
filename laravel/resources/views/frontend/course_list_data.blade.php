@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '場次數據')

@section('content')
<!-- Content Start -->
        <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row menu_search mb-3">
              <div class="col">
                <p>2019/11/01(五))~2019/11/19(二)</p>
              </div>
              <div class="col-2">
                <button type="button" class="btn btn-outline-secondary btn_date">搜日期區間</button>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm class_table">
                <thead>
                  <tr>
                    <th>日期</th>
                    <th>課程名稱</th>
                    <th>場次</th>
                    <th>報名筆數</th>
                    <th>實到人數</th>
                    <th>報到率</th>
                    <th>成交人數</th>
                    <th>成交率</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>2019/11/19(二)</td>
                    <td>零秒成交數</td>
                    <td>台北下午場</td>
                    <td>67/7</td>
                    <td>25</td>
                    <td>41.6%</td>
                    <td>3</td>
                    <td>0.12%</td>
                    <td>
                      <a href="{{ route('course_list_chart') }}"><button type="button"
                          class="btn btn-secondary btn-sm">完整內容</button></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <!-- Content End -->
@endsection