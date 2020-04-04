@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '數據報表')

@section('content')
<!-- Content Start -->
    <!--場次數據頁面內容-->
    <div class="card m-3">
      <div class="card-body">
        <div class="row mb-3">
          <div class="col align-self-center">
            <!-- <span class="h6">2019/11/01(五) ~ 2019/11/19(二)</span> -->
            <div class="row">
              <div class="col-2">
                <select  class="form-control" id="select_type">
                  <option value="0">最近30天</option>
                  <option value="1">銷講</option>
                  <option value="2">正課</option>
                  <option value="3">活動</option>
                </select>
              </div>

              <div class="col-1.5">
                <select  class="form-control" id="select_type">
                  <option value="0">所有老師</option>
                  <option value="1">Jack</option>
                  <option value="2">Julia</option>
                  <option value="3">北極熊</option>
                </select>
              </div>

              <div class="col-2">
                <select  class="form-control" id="select_type">
                  <option value="0">所有類型</option>
                  <option value="1">類型一</option>
                  <option value="2">類型二</option>
                  <option value="3">類型三</option>
                </select>
              </div>

              <div class="col-1.5">
                <select  class="form-control" id="select_type">
                  <option value="0">所有課程</option>
                  <option value="1">課程一</option>
                  <option value="2">課程二</option>
                  <option value="3">課程三</option>
                </select>
              </div>

              <div class="col-2">
                <select  class="form-control" id="select_type">
                  <option value="0">所有地區</option>
                  <option value="1">地區一</option>
                  <option value="2">地區二</option>
                  <option value="3">地區三</option>
                </select>
              </div>

              <div class="col-2">
                <select  class="form-control" id="select_type">
                  <option value="0">所有時段</option>
                  <option value="1">時段一</option>
                  <option value="2">時段二</option>
                  <option value="3">時段三</option>
                </select>
              </div>

              <div class="col-1.5">
                <select  class="form-control" id="select_type">
                  <option value="0">所有來源</option>
                  <option value="1">下午</option>
                  <option value="2">晚上</option>
                  <option value="3">整天</option>
                </select>
              </div>
            </div>

          </div>
          <div class="col-1">
            <button type="button" class="btn btn-outline-secondary btn_date">搜尋</button>
          </div>
          <div class="col-1">
            <button type="button" class="btn btn-outline-secondary btn_date" data-toggle="modal" data-target="#scheduleModal">+比較</button>
          </div>
        </div>
        <!-- <div class="table-responsive">
          <table class="table table-striped table-sm text-center">
            <thead>
              <tr>
                <th>日期</th>
                <th>課程名稱</th>
                <th>場次</th>
                <th>報名筆數</th>
                <th>實到人數</th>
                <th>報到率</th>
                <th>成交人數</th>
                <th>成交率</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>2019/11/19(二)</td>
                <td>零秒成交數</td>
                <td>台北下午場</td>
                <td>67/7</td>
                <td>25</td>
                <td>41.6%</td>
                <td>3</td>
                <td>0.12%</td>
                <td>
                  <a href="{{ route('report_chart') }}"><button type="button"
                      class="btn btn-secondary btn-sm">完整內容</button></a>
                </td>
              </tr>
            </tbody>
          </table>
        </div> -->
      </div>
    </div>


    <!-- 排成設定Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document" style="max-width: 70%;">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">數據報表-搜尋條件</h5>
                <button id="modalAddFilter" type="button" class="ml-2 btn btn-outline-secondary btn_date">新增搜尋條件</button>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div id="dataFilterModal" class="modal-body">
                <div class="row">
                  <div class="col-2">
                    <select  class="form-control" id="select_type">
                      <option value="0">最近30天</option>
                      <option value="1">銷講</option>
                      <option value="2">正課</option>
                      <option value="3">活動</option>
                    </select>
                  </div>

                  <div class="col-1.5">
                    <select  class="form-control" id="select_type">
                      <option value="0">所有老師</option>
                      <option value="1">Jack</option>
                      <option value="2">Julia</option>
                      <option value="3">北極熊</option>
                    </select>
                  </div>

                  <div class="col-2">
                    <select  class="form-control" id="select_type">
                      <option value="0">所有類型</option>
                      <option value="1">類型一</option>
                      <option value="2">類型二</option>
                      <option value="3">類型三</option>
                    </select>
                  </div>

                  <div class="col-1.5">
                    <select  class="form-control" id="select_type">
                      <option value="0">所有課程</option>
                      <option value="1">課程一</option>
                      <option value="2">課程二</option>
                      <option value="3">課程三</option>
                    </select>
                  </div>

                  <div class="col-2">
                    <select  class="form-control" id="select_type">
                      <option value="0">所有地區</option>
                      <option value="1">地區一</option>
                      <option value="2">地區二</option>
                      <option value="3">地區三</option>
                    </select>
                  </div>

                  <div class="col-2">
                    <select  class="form-control" id="select_type">
                      <option value="0">所有時段</option>
                      <option value="1">時段一</option>
                      <option value="2">時段二</option>
                      <option value="3">時段三</option>
                    </select>
                  </div>

                  <div class="col-1.5">
                    <select  class="form-control" id="select_type">
                      <option value="0">所有來源</option>
                      <option value="1">下午</option>
                      <option value="2">晚上</option>
                      <option value="3">整天</option>
                    </select>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" id="saveScheduleBtn" class="btn btn-secondary" data-dismiss="modal">確定</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
              </div>
            </div>
          </div>
        </div>
  <!-- Content End -->

  <script>
    $(document).ready(function () {
      var filterCount = 0;


      $('#modalAddFilter').on('click', function() {
        filterCount++;
        if (filterCount <4 ) {

          var str = `
          <div class="row mt-2">
                <div class="col-2">
                  <select  class="form-control" id="select_type">
                    <option value="0">最近30天</option>
                    <option value="1">銷講</option>
                    <option value="2">正課</option>
                    <option value="3">活動</option>
                  </select>
                </div>

                <div class="col-1.5">
                  <select  class="form-control" id="select_type">
                    <option value="0">所有老師</option>
                    <option value="1">Jack</option>
                    <option value="2">Julia</option>
                    <option value="3">北極熊</option>
                  </select>
                </div>

                <div class="col-2">
                  <select  class="form-control" id="select_type">
                    <option value="0">所有類型</option>
                    <option value="1">類型一</option>
                    <option value="2">類型二</option>
                    <option value="3">類型三</option>
                  </select>
                </div>

                <div class="col-1.5">
                  <select  class="form-control" id="select_type">
                    <option value="0">所有課程</option>
                    <option value="1">課程一</option>
                    <option value="2">課程二</option>
                    <option value="3">課程三</option>
                  </select>
                </div>

                <div class="col-2">
                  <select  class="form-control" id="select_type">
                    <option value="0">所有地區</option>
                    <option value="1">地區一</option>
                    <option value="2">地區二</option>
                    <option value="3">地區三</option>
                  </select>
                </div>

                <div class="col-2">
                  <select  class="form-control" id="select_type">
                    <option value="0">所有時段</option>
                    <option value="1">時段一</option>
                    <option value="2">時段二</option>
                    <option value="3">時段三</option>
                  </select>
                </div>

                <div class="col-1.5">
                  <select  class="form-control" id="select_type">
                    <option value="0">所有來源</option>
                    <option value="1">下午</option>
                    <option value="2">晚上</option>
                    <option value="3">整天</option>
                  </select>
                </div>
              </div>

            </div>

          `;

          $('#dataFilterModal:last').append(str);
        }else {
          alert('已達到搜尋條件限制!');
        }
      });


    });


  </script>

@endsection