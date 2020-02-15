@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '學員管理')

@section('content')
<!-- Content Start -->
        <!--搜尋學員頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-5 mx-auto">
                  <input type="search" class="form-control" placeholder="輸入電話或email" aria-label="Student's Phone or Email"
                    id="search_input" onkeyup="value=value.replace(/[^\w_.@]/g,'')">
                </div>
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
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($students as $student)
                    <tr>
                      <td class="align-middle">{{ $student->name }}</td>
                      <td class="align-middle">{{ $student->phone }}</td>
                      <td class="align-middle">{{ $student->email }}</td>
                      <td class="align-middle">

                      </td>
                      <td class="align-middle">
                          <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" data-target="#student_information">完整內容</button>
                          <div class="modal fade bd-example-modal-lg text-left" id="student_information" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content p-3">
                                <div class="row">
                                  <div class="col-4 py-2">
                                    <h5>王曉明</h5>
                                    <h5>example@gmail.com</h5>
                                  </div>
                                  <div class="col-4">
                                  </div>
                                  <div class="col-4 py-3">
                                      <h7>加入日期 : 2019年8月5日 15:21</h7><br>
                                      <h7>原始來源 : ad</h7>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-3 py-2">
                                    <h6>標記 :
                                      <span class="bg-dark p-1 text-light">
                                        <small>JC學員</small>
                                      </span>&nbsp;
                                      <span class="bg-dark p-1 text-light">
                                        <small>黑心學員</small>
                                      </span>
                                    </h6>
                                  </div>
                                  <div class="col-5">
                                  </div>
                                  <div class="col-4 align-right">
                                    <button type="button" class="btn btn-primary float-right">刪除聯絡人</button>
                                  </div>
                                </div>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                  <li class="nav-item">
                                    <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic_data" role="tab" aria-controls="basic_data" aria-selected="true">基本訊息</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" id="history-tab" data-toggle="tab" href="#history_data" role="tab" aria-controls="history_data" aria-selected="false">歷史互動</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact_data" role="tab" aria-controls="contact_data" aria-selected="false">聯絡狀況</a>
                                  </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                  <div class="tab-pane fade show active p-3" id="basic_data" role="tabpanel" aria-labelledby="basic-tab">
                                    <div class="row">
                                      <div class="col-6">
                                        <div class="row">
                                          <div class="col-6">
                                            <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text">最新來源</span>
                                              </div>
                                              <input type="text" class="form-control bg-white basic-inf" id="#" aria-label="# input" aria-describedby="#" readonly>
                                            </div>
                                          </div>
                                          <div class="col-6">
                                            <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text">職業</span>
                                              </div>
                                              <input type="text" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text ">銷講報名場次</span>
                                          </div>
                                          <input type="text" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                                        </div>
                                        <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text">想了解的內容</span>
                                          </div>
                                          <input type="text" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                                        </div>
                                        <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text">銷講後報名狀況</span>
                                          </div>
                                          <input type="text" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                                        </div>
                                        <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text">居住地址</span>
                                          </div>
                                          <input type="text" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                                        </div>
                                      </div>
                                      <div class="col-6">
                                        <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text">正課報名場次</span>
                                          </div>
                                          <input type="text" class="form-control bg-white basic-inf demo2" aria-label="# input" aria-describedby="#" data-placement="bottom" data-html="true" title="60天財富計畫 自在交易-完成" readonly>
                                        </div>
                                        <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                             <span class="input-group-text">參與活動</span>
                                          </div>
                                          <input type="text" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" data-placement="bottom" data-html="true" title="參與活動 : 參與次數 : 參與度 : " readonly>
                                        </div>
                                        <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                             <span class="input-group-text bg-danger text-white">退款</span>
                                          </div>
                                          <input type="text" class="form-control bg-white basic-inf" aria-label="# input" aria-describedby="#" readonly>
                                        </div>
                                        <button type="button" class="btn btn-primary float-right" id="save-inf" style="display:none;">儲存</button>
                                        <button type="button" class="btn btn-primary float-right" id="update-inf" style="display:block;">修改資料</button>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-3">
                                        <h7>銷講報名次數 : 5</h7>
                                      </div>
                                      <div class="col-3">
                                        <h7>銷講報到率 : 50%</h7>
                                      </div>
                                      <div class="col-3">
                                        <h7>銷講取消次數 : 1</h7>
                                      </div>
                                      <div class="col-3">
                                        <h7>銷講取消率 : 20%</h7>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="tab-pane fade" id="history_data" role="tabpanel" aria-labelledby="history-tab">
                                    <div class="table-responsive">
                                      <table class="table table-striped table-sm text-center">
                                        <thead>
                                          <tr>
                                            <th>時間</th>
                                            <th>動作</th>
                                            <th>內容</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td>2019年05月19日 19:50:39</td>
                                            <td>參與</td>
                                            <td>60天財富計畫課後第一次線上輔導</td>
                                          </tr>
                                          <tr>
                                            <td>2019年05月19日 19:50:39</td>
                                            <td>參與</td>
                                            <td>60天財富計畫課後第一次線上輔導</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <div class="tab-pane fade" id="contact_data" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="table-responsive">
                                      <table class="table table-striped table-sm text-center">
                                        <thead>
                                          <tr>
                                            <th class="text-nowrap">日期</th>
                                            <th class="text-nowrap">時間</th>
                                            <th class="text-nowrap">追單課程</th>
                                            <th class="text-nowrap">付款狀態/日期</th>
                                            <th class="text-nowrap">聯絡內容</th>
                                            <th class="text-nowrap">最新狀態</th>
                                            <th class="text-nowrap">追單人員</th>
                                            <th class="text-nowrap">設提醒</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td class="align-middle"></td>
                                            <td class="align-middle"></td>
                                            <td class="align-middle">
                                              <div class="form-group m-0">
                                                <select class="custom-select border-0 bg-transparent input_width">
                                                  <option selected disabled value=""></option>
                                                  <option value="1">現金</option>
                                                  <option value="2">匯款</option>
                                                  <option value="3">輕鬆付</option>
                                                  <option value="4">一次付</option>
                                                </select>
                                              </div>
                                            </td>
                                            <td class="align-middle"><input type="text" class="border-0 bg-transparent input_width"></td>
                                            <td class="align-middle"></td>
                                            <td class="align-middle">
                                              <div class="form-group m-0">
                                                <select class="custom-select border-0 bg-transparent input_width">
                                                  <option selected disabled value=""></option>
                                                  <option value="1">完款</option>
                                                  <option value="2">付訂</option>
                                                  <option value="3">待追</option>
                                                  <option value="4">退款中</option>
                                                  <option value="5">退款完成</option>
                                                  <option value="6">無意願</option>
                                                  <option value="7">推薦其他講師</option>
                                                </select>
                                              </div>
                                            </td>
                                            <td class="align-middle"></td>
                                            <td class="align-middle"></td>
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
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                        <button type="button" class="btn btn-secondary btn-sm mx-1">列入黑名單</button>
                        <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" data-target="#form_finished">已填表單</button>

                        <div class="modal fade bd-example-modal-lg" id="form_finished" tabindex="-1" role="dialog" aria-labelledby="save_newgroupTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">已填報名表</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-4">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                      <a class="nav-link active" id="form_finished1" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="form_finished_content1" aria-selected="true">60天財富計畫報名表</a>
                                      <a class="nav-link" id="form_finished2" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="form_finished_content2" aria-selected="false">自在交易工作坊報名表</a>
                                      <a class="nav-link" id="form_finished3" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="form_finished_content3" aria-selected="false">實戰課程退費表</a>
                                    </div>
                                  </div>
                                  <div class="col-8">
                                    <div class="tab-content" id="v-pills-tabContent">
                                      <div class="tab-pane fade show active" id="form_finished_content1" role="tabpanel" aria-labelledby="form_finished1">...</div>
                                      <div class="tab-pane fade" id="form_finished_content2" role="tabpanel" aria-labelledby="form_finished2">...</div>
                                      <div class="tab-pane fade" id="form_finished_content3" role="tabpanel" aria-labelledby="form_finished3">...</div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mx-1">刪除</button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
<!-- Content End -->


<script>
$("document").ready(function(){
  $(".demo2").tooltip();

  // 學員管理搜尋 (只能輸入數字、字母、_、.、@)
  $('#search_input').on('blur', function() {
      console.log(`search_input: ${$(this).val()}`);
  });
});
</script>

@endsection