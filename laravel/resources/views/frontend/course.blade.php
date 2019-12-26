@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '課程管理')

@section('content')
<!-- Content Start -->
       <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            {{-- <div class="row menu_search"> --}}
            <div class="row">
              <div class="col-4">
                <button type="button" class="btn btn-outline-secondary btn_date float-left mr-3" data-toggle="modal" data-target="#exampleModal">匯入表單</button>
              
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">匯入表單</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="form-group">
                            <label for="recipient-name" class="col-form-label">講師</label>
                            <input type="text" class="form-control" id="recipient-name">
                          </div>
                          <div class="form-group">
                            <label for="message-text" class="col-form-label">上傳檔案</label>
                            {{-- <textarea class="form-control" id="message-text"></textarea> --}}
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                              <label class="custom-file-label" for="inputGroupFile01">瀏覽檔案</label>
                            </div>
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
              <div class="col-8 text-right">
                <button type="button" class="btn btn-outline-secondary btn_date float-left mr-3">日期</button>
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
                    <td><a href="{{ route('registration_list') }}"><button type="button" class="btn btn-secondary btn-sm">查看名單</button></a>
                    </td>
                  </tr>
                  <tr>
                    <td>2019/11/20(三)</td>
                    <td>零秒成交數</td>
                    <td>台北晚上場</td>
                    <td>98/5</td>
                    <td></td>
                    <td><button type="button" class="btn btn-secondary btn-sm">查詢名單</button></td>
                  </tr>
                  <tr>
                    <td>2019/11/26(二)</td>
                    <td>零秒成交數</td>
                    <td>台北晚上場</td>
                    <td>47</td>
                    <td></td>
                    <td><button type="button" class="btn btn-secondary btn-sm">查詢名單</button></td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
<!-- Content End -->
@endsection