@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '創建細分組')

@section('content')
<!-- Content Start -->
        <!--學員細分組內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row">
              <div class="col form-inline">
                <span class="p-1 border border-secondary rounded-pill ">
                  <small class="text-secondary">篩選器1</small>
                </span>
                <h5 class="mx-2 mb-0">符合下列</h5>
                <div class="form-group m-0">
                  <select class="custom-select border-0 bg-transparent" name="filter">
                    <option value="1">全部</option>
                    <option value="2">姓名</option>
                    <option value="3">聯絡電話</option>
                    <option value="4">電子郵件</option>
                    <option value="5">來源</option>
                    <option value="6">加入日期</option>
                  </select>
                 </div>                
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                <input type="text" class="m-1">                
              </div>
              <div class="col-2">
                <input type="text" class="m-1">                
              </div>
              <div class="col-2">
                <input type="text" class="m-1">                
              </div>
              <div class="col-2">
                <input type="text" class="m-1">                
              </div>
              <div class="col-2">
                <input type="text" class="m-1">                
              </div>
              <div class="col-2">
                <button type="button" class="btn btn-secondary btn-sm mx-1">確定</button>
                <button type="button" class="btn btn-secondary btn-sm mx-1">取消</button>                
              </div>
            </div>
            <h7 class="ml-1">添加另一條件+</h7>
          </div>
        </div>
        <div class="card m-3">
          <div class="card-body">
            <div class="row mt-2 mb-3">
              <div class="col">
                <button class="btn btn-outline-secondary mr-2 " type="button" id="btn_newgroup" data-toggle="modal" data-target="#save_newgroup">保存為細分組</button>
                <div class="modal fade" id="save_newgroup" tabindex="-1" role="dialog" aria-labelledby="save_newgroupTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">細分組名稱</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <input type="text" class="input_width">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary">保存</button>
                      </div>
                    </div>
                  </div>
                </div>
                <button class="btn btn-outline-secondary" type="button" id="btn_newgroup">添加條件組</button>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>姓名</th>
                    <th>聯絡電話</th>
                    <th>電子郵件</th>
                    <th>來源</th>
                    <th>加入日期</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="align-middle">王小名</td>
                    <td class="align-middle">0912345678</td>
                    <td class="align-middle">a123@gmail.com</td>
                    <td class="align-middle">ad</td>
                    <td class="align-middle">2019年12月31日</td>
                  </tr>
                  <tr>
                    <td class="align-middle">陳小美</td>
                    <td class="align-middle">0987654321</td>
                    <td class="align-middle">fd546@gmail.com</td>
                    <td class="align-middle">ellen</td>
                    <td class="align-middle">2019年08月17日</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
<!-- Content End -->
@endsection
     