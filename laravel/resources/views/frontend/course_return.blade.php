@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '場次報表')

@section('content')
<!-- Content Start -->
        <!--現場表單頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col text-center">
                <h6>零秒成交數&nbsp;&nbsp;2019/11/20&nbsp;&nbsp;台北下午場&nbsp;&nbsp;講座地點 : 台北市金山南路一段17號5樓(博宇藝享空間)</h6>
              </div>
            </div>
              <div class="row">
                <div class="col-3 mb-2">
                  <h6>主持開場 : </h6>
                </div>
                <div class="col-3 mb-2">
                  <h6>結束收單 : </h6>
                </div>
                <div class="col-3 mb-2">
                  <h6>工作人員 : </h6>
                </div>
                <div class="col-3 mb-2">
                  <h6>天氣 : </h6>
                </div>
                
                
              </div>
              <div class="row">
                
                <div class="col-3 mb-2">
                  <h6>該場總金額 : </h6>
                </div>
                <div class="col-3">
                  <h6>完款 : </h6>
                </div>
                <div class="col-3">
                  <h6>付訂 : </h6>
                </div>
                <div class="col-3">
                  <h6>留單 : </h6>
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">現場完款</span>
                    </div>
                    <input type="text" class="form-control" aria-label="# input" aria-describedby="#">
                  </div>
                </div>
                <div class="col-3">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">五日內完款</span>
                    </div>
                    <input type="text" class="form-control" aria-label="# input" aria-describedby="#">
                  </div>
                </div>
                <div class="col-3">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">分期付款</span>
                    </div>
                    <input type="text" class="form-control" aria-label="# input" aria-describedby="#">
                  </div>
                </div>
                <div class="col-3 mb-2">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">該場備註</span>
                    </div>
                    <input type="text" class="form-control" aria-label="# input" aria-describedby="#">
                  </div>
                </div>
                
              </div>
            </div>
        </div>

        <div class="card m-3">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-sm return_table text-center">
                <thead>
                  <tr>
                    <th class="text-nowrap ">學員姓名</th>
                    <th class="text-nowrap">連絡電話</th>
                    <th class="text-nowrap">付款狀態</th>
                    <th class="text-nowrap">應付</th>
                    <th class="text-nowrap">已付</th>
                    <th class="text-nowrap">待付</th>
                    <th class="text-nowrap">付款方式1</th>
                    <th class="text-nowrap">金額1</th>
                    <th class="text-nowrap">帳戶/卡號後四碼1</th>
                    <th class="text-nowrap">付款方式2</th>
                    <th class="text-nowrap">金額2</th>
                    <th class="text-nowrap">帳戶/卡號後四碼2</th>
                    <th class="text-nowrap">付款方式3</th>
                    <th class="text-nowrap">金額3</th>
                    <th class="text-nowrap">帳戶/卡號後四碼3</th>
                    <th class="text-nowrap" >付款日期</th>
                    <th class="text-nowrap">服務人員</th>
                    <th class="text-nowrap">備註</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="align-middle">王曉明</td>
                    <td class="align-middle">0912345678</td>
                    <td class="align-middle">
                      <div class="form-group m-0">
                        <select class="custom-select border-0 bg-transparent input_width" name="pay_state">
                          <option selected disabled value="">付款狀態</option>
                          <option value="1">完款</option>
                          <option value="2">付訂</option>
                          <option value="3">留單</option>
                        </select>
                      </div>
                    </td>
                    <td class="align-middle"><input type="text" class="border-0 bg-transparent input_width"></td>
                    <td class="align-middle">1000</td>
                    <td class="align-middle">500</td>
                    <td class="align-middle">
                      <div class="form-group m-0">
                        <select class="custom-select border-0 bg-transparent input_width" name="pay_way">
                          <option selected disabled value="">付款方式</option>
                          <option value="1">現金</option>
                          <option value="2">匯款</option>
                          <option value="3">輕鬆付</option>
                          <option value="4">一次付</option>
                        </select>
                      </div>
                    </td>
                    <td class="align-middle">1500</td>
                    <td class="align-middle">1234</td>
                    <td class="align-middle">
                      <div class="form-group m-0">
                        <select class="custom-select border-0 bg-transparent input_width" name="pay_way">
                          <option selected disabled value="">付款方式</option>
                          <option value="1">現金</option>
                          <option value="2">匯款</option>
                          <option value="3">輕鬆付</option>
                          <option value="4">一次付</option>
                        </select>
                      </div>
                    </td>
                    <td class="align-middle"><input type="text" class="border-0 bg-transparent input_width"></td>
                    <td class="align-middle"><input type="text" class="border-0 bg-transparent input_width"></td>
                    <td class="align-middle">
                      <div class="form-group m-0">
                        <select class="custom-select border-0 bg-transparent input_width" name="pay_way">
                          <option selected disabled value="">付款方式</option>
                          <option value="1">現金</option>
                          <option value="2">匯款</option>
                          <option value="3">輕鬆付</option>
                          <option value="4">一次付</option>
                        </select>
                      </div>
                    </td>
                    <td class="align-middle"><input type="text" class="border-0 bg-transparent input_width"></td>
                    <td class="align-middle"><input type="text" class="border-0 bg-transparent input_width"></td>
                    <td class="align-middle"><input type="text" class="border-0 bg-transparent input_width"></td>
                    <td class="align-middle"><input type="text" class="border-0 bg-transparent input_width"></td>
                    <td class="align-middle"><input type="text" class="border-0 bg-transparent input_width"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
<!-- Content End -->
@endsection