@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '今日課程')

@section('content')
<!-- Content Start -->
        <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-6 mx-auto">
                <div class="input-group">
                  <input type="search" class="form-control" placeholder="搜尋課程" aria-describedby="btn_search">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>日期</th>
                    <th>課程名稱</th>
                    <th>場次</th>
                    <th>報名筆數</th>
                    <th>實到人數</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($courses as $key => $course )
                  {{-- @foreach(array_combine($courses, $salesregistrations) as $course => $salesregistration) --}}
                    <tr>
                      <td>{{ date('Y-m-d', strtotime($course->course_start_at)) }}</td>
                      <td>{{ $course->name }}</td>
                      <td>{{ $course->Events }}</td>
                      <td>{{ $courses_apply[$key] }} / <span style="color:red">{{ $courses_cancel[$key] }}</span></td>
                      <td>
                        <a href="{{ route('course_check', ['id'=>$course->id]) }}"><button type="button" class="btn btn-secondary btn-sm">開始報到</button></a>
                      </td>
                    </tr>
                  @endforeach
                  {{-- <tr>
                    <td>2019/11/20(三)</td>
                    <td>零秒成交數</td>
                    <td>台北下午場</td>
                    <td>56/3</td>
                    <td></td>
                    <td><a href="{{ route('course_check') }}"><button type="button" class="btn btn-secondary btn-sm">開始報到</button></a>
                    </td>
                  </tr>
                  <tr>
                    <td>2019/11/20(三)</td>
                    <td>零秒成交數</td>
                    <td>台北晚上場</td>
                    <td>98/5</td>
                    <td></td>
                    <td><a href="{{ route('course_check') }}"><button type="button" class="btn btn-secondary btn-sm">開始報到</button></a>
                    </td>
                  </tr>
                  <tr>
                    <td>2019/11/20(二)</td>
                    <td>黑心外匯交易員的告白</td>
                    <td>台北晚上場</td>
                    <td>47</td>
                    <td></td>
                    <td><a href="{{ route('course_check') }}"><button type="button" class="btn btn-secondary btn-sm">開始報到</button></a>
                    </td>
                  </tr> --}}

                </tbody>
              </table>
            </div>
          </div>
        </div>
      <!-- Content End -->
@endsection