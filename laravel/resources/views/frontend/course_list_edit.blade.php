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
                <div class="col-3 align-middle"> 
                    <button type="button" class="btn btn-outline-secondary btn_date mr-3" data-toggle="modal" data-target="#form_newregistrationform">新增報名表</button>
                    <div class="modal fade" id="form_newregistrationform" tabindex="-1" role="dialog" aria-labelledby="form_newregistrationformLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">新增報名表</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="form-group">
                            <label for="correspond_class" class="col-form-label">對應課程</label>
                            <input type="text" class="form-control" required>
                          </div>
                          <div class="form-group">
                            <label for="class_name" class="col-form-label">課程名稱</label>
                            <input type="text" class="form-control" required>
                          </div>
                          <div class="form-group">
                            <label for="class_servicecontent" class="col-form-label">課程服務內容</label>
                            <textarea rows="4" cols="50" class="form-control"></textarea>
                          </div>
                          <div class="form-group">
                            <label for="class_price" class="col-form-label">課程一般定價</label>
                            <input type="number" class="form-control" required>
                          </div>  
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary">確認</button>
                      </div>
                    </div>
                  </div>
                </div>
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