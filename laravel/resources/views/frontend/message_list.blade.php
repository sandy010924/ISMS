@extends('frontend.layouts.master')

@section('title', '訊息推播')
@section('header', '訊息列表')

@section('content')
<!-- Content Start -->
       <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">

            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>寄信日期</th>
                    <th>發送方式</th>
                    <th>內容</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="table_list">
                  <tr>
                    <td>2020-02-18 23:49:19</td>
                    <td>簡訊、E-mail</td>
                    <td>
                      想更了解外匯交易.........
                    </td>
                    <td>
                      <a href="{{ route("message_data")}}"><button type="button" class="btn btn-secondary btn-sm mx-1">詳細內容</button></a>
                      <a href="{{ route("message")}}"><button type="button" class="btn btn-secondary btn-sm mx-1">Clone</button></a>
                    </td>
                  </tr>
                  <tr>
                    <td>2020-02-15 20:10:10</td>
                    <td>簡訊</td>
                    <td>
                      黑心直播開始囉!!!......
                    </td>
                    <td>
                      <a href="{{ route("message_data")}}"><button type="button" class="btn btn-secondary btn-sm mx-1">詳細內容</button></a>
                      <a href="{{ route("message")}}"><button type="button" class="btn btn-secondary btn-sm mx-1">Clone</button></a>
                    </td>
                  </tr>
                  <tr>
                    <td>2020-02-10 11:00:34</td>
                    <td>E-mail</td>
                    <td>
                      [找到瘦到停不下來的動力]......
                    </td>
                    <td>
                      <a href="{{ route("message_data")}}"><button type="button" class="btn btn-secondary btn-sm mx-1">詳細內容</button></a>
                      <a href="{{ route("message")}}"><button type="button" class="btn btn-secondary btn-sm mx-1">Clone</button></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

<!-- Content End -->

@endsection