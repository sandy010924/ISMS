@extends('frontend.layouts.master')

@section('title', '財務管理')
@section('header', '財務管理')

@section('content')
<!-- Content Start -->
<!--搜尋課程頁面內容-->
<div class="card m-3">
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-2">
      </div>
      <div class="col-3">
        <input type="date" class="form-control" id="search_date">
      </div>
      <div class="col-3">
        <input type="search" class="form-control" placeholder="搜尋課程" aria-label="Class's name" id="search_name">
      </div>
      <div class="col-3">
        <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-sm text-center">
        <thead>
          <tr>
            <th>日期</th>
            <th>課程名稱</th>
            <th>場次</th>
            <th>發票</th>
            <th>廣告成本</th>
            <th>訊息成本</th>
            <th>場地成本</th>
            <th>獎金分配</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>2020-03-11</td>
            <td>零秒成交數</td>
            <td>台北下午場</td>
            <td>
              <a href="" data-toggle="modal" data-target="#invoice">AB-12345678</a>
              <div class="modal fade text-left " id="invoice" tabindex="-1" role="dialog" aria-labelledby="invoiceLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">發票資訊</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="row mb-3">
                        <div class="col-2">
                        </div>
                        <div class="col-3">
                          <input type="date" class="form-control" id="search_date">
                        </div>
                        <div class="col-3">
                          <input type="search" class="form-control" placeholder="輸入關鍵字" aria-label="Class's name">
                        </div>
                        <div class="col-3">
                          <button class="btn btn-outline-secondary" type="button" id="btn_search2">搜尋</button>
                        </div>
                      </div>
                      <div class="table-responsive">
                        <table class="table table-striped table-sm text-center ">
                          <thead>
                            <tr>
                              <th>購買日期</th>
                              <th>學員姓名</th>
                              <th>發票</th>
                              <th>開立日期</th>
                              <th>發票號碼</th>
                              <th>抬頭</th>
                              <th>統編</th>
                              <th>地址</th>

                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>2020-03-04</td>
                              <td>王曉明</td>
                              <td>二聯式</td>
                              <td><input type="number" class="form-control form-control-sm" name="startdate"></td>
                              <td><input type="number" class="form-control form-control-sm" name="invoice_num"></td>
                              <td>王曉明</td>
                              <td>54900838</td>
                              <td>新竹市東區園區二路168號</td>
                            </tr>
                            <tr>
                              <td>2020-03-03</td>
                              <td>陳小美</td>
                              <td>三聯式</td>
                              <td><input type="number" class="form-control form-control-sm" name="startdate"></td>
                              <td><input type="number" class="form-control form-control-sm" name="invoice_num"></td>
                              <td>陳小美</td>
                              <td>86522210</td>
                              <td>台北市松山區敦化北路201號</td>
                            </tr>
                            <tr>
                              <td>2020-03-02</td>
                              <td>蔡想想</td>
                              <td>三聯式</td>
                              <td><input type="number" class="form-control form-control-sm" name="startdate"></td>
                              <td><input type="number" class="form-control form-control-sm" name="invoice_num"></td>
                              <td>蔡想想</td>
                              <td>39948453</td>
                              <td>桃園市桃園區興華路23號</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </td>
            <td><input type="number" class="form-control form-control-sm" name="advertise_costs"></td>
            <td><input type="number" class="form-control form-control-sm" name="sms_costs"></td>
            <td><input type="number" class="form-control form-control-sm" name="space_costs"></td>
            <td>
              @if (Auth::user()->role == 'admin' || Auth::user()->role == 'accountant')
              <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" data-target="#bonus_new">新增獎金</button>
              @endif
              <div class="modal fade text-left " id="bonus_new" tabindex="-1" role="dialog" aria-labelledby="bonus_newLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">新增獎金</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group required">
                        <label for="new_name" class="col-form-label">姓名</label>
                        <input type="text" id="new_name" name="new_name" class="form-control" required>
                      </div>
                      <div class="form-group required">
                        <label for="new_condition" class="col-form-label">條件</label>
                        <div class="form-group row mb-3">
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck1">
                                <h6>名單來源包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck2">
                                <h6>工作人員包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck3">
                                <h6>主持開場包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row mb-3">
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck4">
                                <h6>結束收單包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck5">
                                <h6>服務人員包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck6">
                                <h6>追單人員包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group required">
                        <label for="new_mode" class="col-form-label">狀態</label>
                        <!-- <div class="form-group row mb-3">
                                    <div class="col-1 pr-0"> -->
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="">
                          <label class="form-check-label" for="modeCheck1">
                            <h6>啟用</h6>
                          </label>
                        </div>
                        <!-- </div>
                                    <div class="col-1 pr-0"> -->
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="">
                          <label class="form-check-label" for="modeCheck2">
                            <h6>暫停</h6>
                          </label>
                        </div>
                        <!-- </div>
                                  </div> -->
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                      <button type="submit" class="btn btn-primary">確認</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
              <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" data-target="#bonus_check">查看名單</button>
              <div class="modal fade text-left " id="bonus_check" tabindex="-1" role="dialog" aria-labelledby="bonus_checkLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">查看名單</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="table-responsive">
                        <table class="table table-striped table-sm text-center ">
                          <thead>
                            <tr>
                              <th>姓名</th>
                              <th>狀態</th>
                              <th>獎金條件</th>
                              <th>日期</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="align-middle">Ellen</td>
                              <td class="align-middle">啟用</td>
                              <td class="align-middle">名單來源包含Ellen<br>工作人員包含Ellen</td>
                              <td class="align-middle">2020-02-05</td>
                            </tr>
                            <tr>
                              <td class="align-middle">Amy</td>
                              <td class="align-middle">暫停</td>
                              <td class="align-middle">主持開場包含Amy<br></td>
                              <td class="align-middle">2020-02-04</td>
                            </tr>
                            <tr>
                              <td class="align-middle">Allen</td>
                              <td class="align-middle">啟用</td>
                              <td class="align-middle">名單來源包含Allen<br>結束收單包含Allen</td>
                              <td class="align-middle">2020-02-04</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>2020-03-08</td>
            <td>自在交易工作坊</td>
            <td>台中上午場</td>
            <td>
              <a href="" data-toggle="modal" data-target="#invoice">CD-98765432</a>
              <div class="modal fade text-left " id="invoice" tabindex="-1" role="dialog" aria-labelledby="invoiceLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">發票資訊</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="table-responsive">
                        <table class="table table-striped table-sm text-center ">
                          <thead>
                            <tr>
                              <th>購買日期</th>
                              <th>學員姓名</th>
                              <th>發票</th>
                              <th>開立日期</th>
                              <th>發票號碼</th>
                              <th>抬頭</th>
                              <th>統編</th>
                              <th>地址</th>

                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>2020-03-08</td>
                              <td>王曉明</td>
                              <td>二聯式</td>
                              <td><input type="number" class="form-control form-control-sm" name="startdate"></td>
                              <td><input type="number" class="form-control form-control-sm" name="invoice_num"></td>
                              <td>王曉明</td>
                              <td>54900838</td>
                              <td>新竹市東區園區二路168號</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </td>
            <td><input type="number" class="form-control form-control-sm" name="advertise_costs"></td>
            <td><input type="number" class="form-control form-control-sm" name="sms_costs"></td>
            <td><input type="number" class="form-control form-control-sm" name="space_costs"></td>
            <td>
              @if (Auth::user()->role == 'admin' || Auth::user()->role == 'accountant')
              <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" data-target="#bonus_new">新增獎金</button>
              @endif
              <div class="modal fade text-left " id="bonus_new" tabindex="-1" role="dialog" aria-labelledby="bonus_newLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">新增獎金</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group required">
                        <label for="new_name" class="col-form-label">姓名</label>
                        <input type="text" id="new_name" name="new_name" class="form-control" required>
                      </div>
                      <div class="form-group required">
                        <label for="new_condition" class="col-form-label">條件</label>
                        <div class="form-group row mb-3">
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck1">
                                <h6>名單來源包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck2">
                                <h6>工作人員包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck3">
                                <h6>主持開場包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row mb-3">
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck4">
                                <h6>結束收單包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck5">
                                <h6>服務人員包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck6">
                                <h6>追單人員包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group required">
                        <label for="new_mode" class="col-form-label">狀態</label>
                        <!-- <div class="form-group row mb-3">
                                    <div class="col-1 pr-0"> -->
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="">
                          <label class="form-check-label" for="modeCheck1">
                            <h6>啟用</h6>
                          </label>
                        </div>
                        <!-- </div>
                                    <div class="col-1 pr-0"> -->
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="">
                          <label class="form-check-label" for="modeCheck2">
                            <h6>暫停</h6>
                          </label>
                        </div>
                        <!-- </div>
                                  </div> -->
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                      <button type="submit" class="btn btn-primary">確認</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
              <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" data-target="#bonus_check">查看名單</button>
              <div class="modal fade text-left " id="bonus_check" tabindex="-1" role="dialog" aria-labelledby="bonus_checkLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">查看名單</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="table-responsive">
                        <table class="table table-striped table-sm text-center ">
                          <thead>
                            <tr>
                              <th>姓名</th>
                              <th>狀態</th>
                              <th>獎金條件</th>
                              <th>日期</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="align-middle">Ellen</td>
                              <td class="align-middle">啟用</td>
                              <td class="align-middle">名單來源包含Ellen<br>工作人員包含Ellen</td>
                              <td class="align-middle">2020-02-05</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>2020-02-25</td>
            <td>黑心外匯交易員的告白</td>
            <td>台北下午場</td>
            <td>
              <a href="" data-toggle="modal" data-target="#invoice">GR-45628741</a>
              <div class="modal fade text-left " id="invoice" tabindex="-1" role="dialog" aria-labelledby="invoiceLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">發票資訊</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="table-responsive">
                        <table class="table table-striped table-sm text-center ">
                          <thead>
                            <tr>
                              <th>購買日期</th>
                              <th>學員姓名</th>
                              <th>發票</th>
                              <th>開立日期</th>
                              <th>發票號碼</th>
                              <th>抬頭</th>
                              <th>統編</th>
                              <th>地址</th>

                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>2020-03-04</td>
                              <td>王曉明</td>
                              <td>二聯式</td>
                              <td><input type="number" class="form-control form-control-sm" name="startdate"></td>
                              <td><input type="number" class="form-control form-control-sm" name="invoice_num"></td>
                              <td>王曉明</td>
                              <td>54900838</td>
                              <td>新竹市東區園區二路168號</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </td>
            <td><input type="number" class="form-control form-control-sm" name="advertise_costs"></td>
            <td><input type="number" class="form-control form-control-sm" name="sms_costs"></td>
            <td><input type="number" class="form-control form-control-sm" name="space_costs"></td>
            <td>
              @if (Auth::user()->role == 'admin' || Auth::user()->role == 'accountant')
              <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" data-target="#bonus_new">新增獎金</button>
              @endif
              <div class="modal fade text-left " id="bonus_new" tabindex="-1" role="dialog" aria-labelledby="bonus_newLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">新增獎金</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group required">
                        <label for="new_name" class="col-form-label">姓名</label>
                        <input type="text" id="new_name" name="new_name" class="form-control" required>
                      </div>
                      <div class="form-group required">
                        <label for="new_condition" class="col-form-label">條件</label>
                        <div class="form-group row mb-3">
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck1">
                                <h6>名單來源包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck2">
                                <h6>工作人員包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck3">
                                <h6>主持開場包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row mb-3">
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck4">
                                <h6>結束收單包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck5">
                                <h6>服務人員包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="">
                              <label class="form-check-label" for="conditionCheck6">
                                <h6>追單人員包含<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group required">
                        <label for="new_mode" class="col-form-label">狀態</label>
                        <!-- <div class="form-group row mb-3">
                                    <div class="col-1 pr-0"> -->
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="">
                          <label class="form-check-label" for="modeCheck1">
                            <h6>啟用</h6>
                          </label>
                        </div>
                        <!-- </div>
                                    <div class="col-1 pr-0"> -->
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="">
                          <label class="form-check-label" for="modeCheck2">
                            <h6>暫停</h6>
                          </label>
                        </div>
                        <!-- </div>
                                  </div> -->
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                      <button type="submit" class="btn btn-primary">確認</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
              <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" data-target="#bonus_check">查看名單</button>
              <div class="modal fade text-left " id="bonus_check" tabindex="-1" role="dialog" aria-labelledby="bonus_checkLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">查看名單</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="table-responsive">
                        <table class="table table-striped table-sm text-center ">
                          <thead>
                            <tr>
                              <th>姓名</th>
                              <th>狀態</th>
                              <th>獎金條件</th>
                              <th>日期</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="align-middle">Ellen</td>
                              <td class="align-middle">啟用</td>
                              <td class="align-middle">名單來源包含Ellen<br>工作人員包含Ellen</td>
                              <td class="align-middle">2020-02-05</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                    </form>
                  </div>
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