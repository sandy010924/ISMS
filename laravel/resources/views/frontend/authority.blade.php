@extends('frontend.layouts.master')

@section('title', '系統設定')
@section('header', '權限管理')

@section('content')
<!-- Content Start -->
       <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-4">
                <button type="button" class="btn btn-outline-secondary btn_date mx-1" data-toggle="modal" data-target="#form_newuser">新增</button>
                <div class="modal fade" id="form_newuser" tabindex="-1" role="dialog" aria-labelledby="form_newuserLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="form_newclassLabel">新增</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form data-toggle="validator">
                          <div class="form-group">
                            <label for="newuser_account" class="col-form-label">帳號</label>
                            <input type="text" class="form-control" id="newuser_account" required>
                          </div>
                          <div class="form-group">
                                <label for="newuser_password" class="col-form-label">密碼</label>
                                <input type="password" class="form-control" id="newuser_password" required>
                              </div>
                              <div class="form-group">
                                <label for="newuser_password2" class="col-form-label">確認密碼</label>
                                <input type="password" class="form-control" id="newuser_password2" data-match="#newuser_password" required>
                              </div>
                          <div class="form-group">
                            <label for="newuser_name" class="col-form-label">姓名</label>
                            <input type="text" class="form-control" id="newuser_name" required>
                          </div>
                          <div class="form-group">
                            <label for="newuser_persona" class="col-form-label">角色</label>
                            <select class="custom-select form-control" id="newuser_persona" required>
                              <option value="1">講師</option>
                              <option value="2">現場人員</option>
                              <option value="3">財會人員</option>
                              <option value="4">行銷人員</option>
                              <option value="5">數據分析人員</option>
                              <option value="6">管理員</option>
                            </select>
                          </div>                          
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                          <button type="submit" id="import_check" class="btn btn-primary">確認</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-5">
                <div class="input-group">
                  <input type="search" class="form-control" placeholder="搜尋姓名、角色" aria-describedby="btn_search">
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
                    <th>帳號</th>
                    <th>姓名</th>
                    <th>角色</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="course_list">
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#form_updateuser">修改</button>
                    <div class="modal fade text-left" id="form_updateuser" tabindex="-1" role="dialog" aria-labelledby="form_updateuserLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="form_newclassLabel">修改資料</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form data-toggle="validator">
                              <div class="form-group">
                                <label for="updateuser_account" class="col-form-label">帳號</label>
                                <input type="text" class="form-control" id="updateuser_account" required>
                              </div>
                              <div class="form-group">
                                <label for="updateuser_password" class="col-form-label">密碼</label>
                                <input type="password" class="form-control" id="updateuser_password" required>
                              </div>
                              <div class="form-group">
                                <label for="updateuser_password2" class="col-form-label">確認密碼</label>
                                <input type="password" class="form-control" id="updateuser_password2" data-match="#updateuser_password" required>
                              </div>
                              <div class="form-group">
                                <label for="updateuser_name" class="col-form-label">姓名</label>
                                <input type="text" class="form-control" id="updateuser_name" required>
                              </div>
                              <div class="form-group">
                                <label for="updateuser_persona" class="col-form-label">角色</label>
                                <select class="custom-select form-control" id="updateuser_persona" required="required">
                                  <option value="1">講師</option>
                                  <option value="2">現場人員</option>
                                  <option value="3">財會人員</option>
                                  <option value="4">行銷人員</option>
                                  <option value="5">數據分析人員</option>
                                  <option value="6">管理員</option>
                                </select>
                              </div>  
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                              <button type="submit" id="import_check" class="btn btn-primary">確認</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm">刪除</button>
                  </td>
                </tbody>
              </table>
            </div>
          </div>
        </div>

<!-- Content End -->

@endsection