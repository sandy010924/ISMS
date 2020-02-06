@extends('frontend.layouts.master')

@section('title', '課程總覽')
@section('header', '編輯')

@section('content')
<!-- Content Start -->
        <!--課程總覽編輯頁面內容-->
        <div class="card m-3">
            <div class="card-body">
              <div class="row m-3">
                <div class="col-3 align-middle">
                  <h6>講師姓名<input type="text" class="mt-2" readonly></h6>
                </div>
                <div class="col-3 align-middle">
                  <h6>講座名稱<input type="text" class="mt-2" readonly></h6>
                </div>
                <div class="col-3">
                  
                </div>
                <div class="col-3 text-right"> 
                    <button type="button" class="btn btn-outline-secondary btn_date mr-3" data-toggle="modal" data-target="#form_newclass">編輯報名表</button>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-striped table-sm class_table">
                  <thead>
                    <tr>
                      <th>日期</th>
                      <th>場次</th>
                      <th>時間</th>
                      <th>地點</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>2019/11/22(四)</td>
                      <td>台北下午場</td>
                      <td>14:00-17:00</td>
                      <td>台北市中山區松江路131號7樓</td>
                      <td><a href="#"><button type="button" class="btn btn-secondary btn-sm">取消場次</button></a></td>
                    </tr>
                    <tr>
                      <td>2019/11/27(三)</td>
                      <td>台北晚上場</td>
                      <td>19:00-22:00</td>
                      <td>台北市中山區松江路131號7樓</td>
                      <td><a href="#"><button type="button" class="btn btn-secondary btn-sm">取消場次</button></a></td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      <!-- Content End -->
@endsection