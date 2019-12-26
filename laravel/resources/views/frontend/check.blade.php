@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '報到')

@section('content')
<!-- Content Start -->
        <!--開始報到內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row check_title">
              <div class="col-3">
                <p>零秒成交數 2019/11/20 台北下午場</p>
              </div>
              <div class="col-3">
                  
              </div>
              <div class="col-3">
                <p>報名筆數:</p>
              </div>
              <div class="col-3">
                <p>報到筆數:</p>
              </div>
              
            </div>
            <div class="row">
              <div class="col-3">
                <p class="form_text">主持開收 : <input type="text" class="form_input"></p>
              </div>
              <div class="col-3">
                <p class="form_text">工作人員 : <input type="text" class="form_input"></p>
              </div>
              <div class="col-3">
                <p class="form_text">講座地點 : <input type="text" class="form_input"></p>  
              </div>
              <div class="col-3">
                <p class="form_text">天氣 : <input type="text" class="form_input"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="card m-3">
            <div class="card-body">  
                <div class="row menu_search">
                    
                    <div class="col-6">
                       <div class="input-group mb-3 search three_num_search">
                          <input type="search" class="form-control" placeholder="電話末三碼" aria-label="Recipient's username" aria-describedby="button-addon2">
                          <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">搜尋</button>
                          </div>
                      </div>
                    </div>
                    <div class="col-6">
                        {{-- <button type="button" class="btn btn-outline-secondary" >現場報名</button> --}}

                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal">現場報名</button>
                      
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">現場報名</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">姓名</label>
                                    <input type="text" class="form-control" id="name" required>
                                    <div class="invalid-feedback">
                                      請輸入姓名
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">連絡電話</label>
                                    <input type="text" class="form-control" id="recipient-name" required>
                                    <div class="invalid-feedback">
                                      請輸入電話
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">電子郵件</label>
                                    <input type="text" class="form-control" id="recipient-name" required>
                                    <div class="invalid-feedback">
                                      請輸入電話
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">居住地</label>
                                    <input type="text" class="form-control" id="recipient-name">
                                  </div>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">目前職業</label>
                                    <input type="text" class="form-control" id="recipient-name" required>
                                    <div class="invalid-feedback">
                                      請輸入電話
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">付款方式</label>
                                    <input type="text" class="form-control" id="recipient-name">
                                  </div>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">帳號/卡號後五碼</label>
                                    <input type="text" class="form-control" id="recipient-name">
                                  </div>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">我想在講座中瞭解到的內容？</label>
                                    <input type="text" class="form-control" id="recipient-name">
                                  </div>
                                </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-primary">確認報名</button>
                              </div>
                            </div>
                          </div>
                        </div>



                        <a href="{{ route('return_form') }}"><button type="button" class="btn btn-outline-secondary" >回報表單</button></a>
                      </div>
                </div>
                <div class="table-responsive check_table">
                    
                  <table class="table table-striped table-sm class_table">
                    <thead>
                      <tr>
                        <th>姓名</th>
                        <th>連絡電話</th>
                        <th>電子郵件</th>
                        <th>狀態</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                        
                      <tr>
                        <td>王曉明</td>
                        <td>0912345678</td>
                        <td>asd123123@gmail.com</td>
                        <td>
                          <div class="dropdown"><button type="button" class="btn btn-secondary btn-sm present">報到</button>
                            <button class="btn btn-sm more" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  •••
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                              <button class="dropdown-item" type="button">報到</button>
                              <button class="dropdown-item" type="button">未到</button>
                              <button class="dropdown-item" type="button">取消</button>
                            </div>
                          </div>
                        </td>
                      </tr>
                    
                      <tr>
                        <td>陳美美</td>
                        <td>0987654321</td>
                        <td>ppqq1478@gmail.com</td>
                        <td>
                            <div class="dropdown"><button type="button" class="btn btn-secondary btn-sm absent">未到</button>
                              <button class="btn btn-sm more" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    •••
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <button class="dropdown-item" type="button">報到</button>
                                <button class="dropdown-item" type="button">未到</button>
                                <button class="dropdown-item" type="button">取消</button>
                              </div>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <td>蔡阿祥</td>
                        <td>0911223344</td>
                        <td>sfsdf45457@gmail.com</td>
                        <td>
                            <div class="dropdown"><button type="button" class="btn btn-secondary btn-sm cancel">取消</button>
                              <button class="btn btn-sm more" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    •••
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <button class="dropdown-item" type="button">報到</button>
                                <button class="dropdown-item" type="button">未到</button>
                                <button class="dropdown-item" type="button">取消</button>
                              </div>
                            </div>
                        </td>
                      </tr>
                    </tbody>
                  
                  </table>
                
                </div>
              </div>
            </div>
          <!-- Content End -->
@endsection