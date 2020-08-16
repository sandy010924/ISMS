@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '報到')

@section('content')
<!-- Content Start -->
<!-- 權限 Rocky(2020/05/10) -->
<input type="hidden" id="auth_role" value="{{ Auth::user()}}" />
<!--簽到表內容-->
<input type="hidden" id="event_id" value="{{ $course->id }}">
<input type="hidden" id="course_type" value="{{ $course->type }}">
<input type="hidden" id="event_date" value="{{ $course->course_start_at }}">
<div class="card m-md-3 px-md-0 px-3">
  <div class="card-body">
    <div class="row mt-1 align-items-center">
      <div class="col-md-6 mb-3">
        <h6 class="mb-0">
          <label id="course_name">{{ $course->course }}</label>&nbsp;&nbsp;
          <label id="course_date">{{ date('Y-m-d', strtotime($course->course_start_at)) }}</label>
          ( {{ $week }} )&nbsp;&nbsp;
          <label id="course_event">{{ $course->name }}</label>
        </h6>
      </div>
      <div class="col mb-3">
        <h6 class="mb-0">報名筆數 :
          <span id="count_apply">{{ $count_apply }}</span>
        </h6>
      </div>
      <div class="col mb-3">
        <h6 class="mb-0">報到筆數 :
          <span id="count_check">{{ $count_check }}</span>
        </h6>
      </div>
      <div class="col mb-3">
        <h6 class="mb-0">取消筆數 :
          <span id="count_cancel">{{ $count_cancel }}</span>
        </h6>
      </div>
      <div class="col-md-auto mb-3 text-right">
        @if( $nextLevel > 0 )
        <a href="{{ route('course_return', ['id' => $course->id]) }}"><button type="button" class="btn btn-primary">場次報表</button></a>
        @else
        <button type="button" class="btn btn-primary" onclick="alert('尚未串接進階課程！\n請先到【課程管理】找到該課程的進階課程，進入至進階課程的【編輯】，點選「新增報名表」按鈕，在「對應課程」選擇此課程做串接。');location.href ='{{ route('course_return', ['id' => $course->id]) }}'">場次報表</button>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-md-auto mb-3">
        {{-- <p class="form_text">主持開場 : <input type="text" class="form_input"></p> --}}
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">主持開場</span>
          </div>
          <input type="text" class="form-control auth_readonly" aria-label="host input" aria-describedby="host" id="host" value="{{ $course->host }}">
        </div>
      </div>
      <div class="col-md-auto mb-3">
        {{-- <p class="form_text">結束收單 : <input type="text" class="form_input"></p> --}}
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">結束收單</span>
          </div>
          <input type="text" class="form-control auth_readonly" aria-label="closeorder input" aria-describedby="closeorder" id="closeorder" value="{{ $course->closeorder }}">
        </div>
      </div>
      <div class="col-md-3 mb-3">
        {{-- <p class="form_text">天氣 : <input type="text" class="form_input"></p> --}}
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">天氣</span>
          </div>
          <input type="text" class="form-control auth_readonly" aria-label="weather input" aria-describedby="weather" id="weather" value="{{ $course->weather }}">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 mb-3">
        {{-- <p class="form_text">工作人員 : <input type="text" class="form_input"></p> --}}
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">工作人員</span>
          </div>
          <input type="text" class="form-control auth_readonly" aria-label="staff input" aria-describedby="staff" id="staff" value="{{ $course->staff }}">
        </div>
        <label class="text-secondary px-2 py-1"><small>※ 若有多位工作人員，請以「、」做區隔。</small></label>
      </div>
    </div>
  </div>
</div>
<div class="card m-md-3 px-md-0 px-1">
  <div class="card-body">
    <div class="row mt-1">
      <div class="col-md-4 mx-auto mb-3">
        <div class="input-group">
          <input type="search" class="form-control" placeholder="姓名或電話末三碼" id="search_keyword" />
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
          </div>
        </div>
      </div>
      <div class="col mb-3 text-right">
        @if( $course->type == 1 )
        @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'msaleser'|| Auth::user()->role == 'saleser' || Auth::user()->role == 'marketer' || Auth::user()->role == 'officestaff' || Auth::user()->role == 'teacher'))
        <button type="button" class="btn btn-outline-secondary mx-1" data-toggle="modal" data-target="#presentApply">現場報名</button>
        @endif
        @endif
        <!-- 現場報名 modal -->
        <div class="modal fade" id="presentApply" tabindex="-1" role="dialog" aria-labelledby="presentApplyLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="presentApplyLabel">現場報名</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body text-left">
                <form action="{{ url('course_check_insert') }}" name="insert" method="POST">
                  @csrf
                  <input type="hidden" name="form_event_id" id="form_event_id" value="{{ $course->id }}">
                  <div class="form-group required">
                    <label for="new_name" class="col-form-label">姓名</label>
                    <input type="text" class="form-control" name="new_name" id="new_name" required>
                  </div>
                  <div class="form-group required">
                    <label for="new_phone" class="col-form-label">聯絡電話</label>
                    <input type="text" class="form-control" name="new_phone" id="new_phone" required>
                    <label class="text-secondary"><small>聯繫方式</small></label>
                  </div>
                  <div class="form-group required">
                    <label for="new_email">電子郵件</label>
                    <input type="text" class="form-control" name="new_email" id="new_email">
                    <label class="text-secondary"><small>example@example.com</small></label>
                  </div>
                  <div class="form-group">
                    <label for="new_address" class="col-form-label">居住區域</label>
                    <select class="custom-select form-control" name="new_address" id="new_address">
                      <option selected disabled>請選擇居住區域</option>
                      <option>宜蘭</option>
                      <option>基隆</option>
                      <option>台北</option>
                      <option>新北</option>
                      <option>桃園</option>
                      <option>新竹</option>
                      <option>苗栗</option>
                      <option>台中</option>
                      <option>彰化</option>
                      <option>南投</option>
                      <option>雲林</option>
                      <option>嘉義</option>
                      <option>台南</option>
                      <option>高雄</option>
                      <option>屏東</option>
                      <option>台東</option>
                      <option>花蓮</option>
                    </select>
                  </div>
                  <div class="form-group required">
                    <label for="new_profession">目前職業</label>
                    <input type="text" class="form-control" name="new_profession" id="new_profession">
                    <label class="text-secondary"><small>目前的工作職稱</small></label>
                  </div>
                  <div class="form-group">
                    <label for="new_paymodel" class="col-form-label">付款方式</label>
                    <div class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input" id="new_paymodel1" name="new_paymodel" value="刷卡">
                      <label class="custom-control-label" for="new_paymodel1">刷卡</label>
                    </div>
                    <div class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input" id="new_paymodel2" name="new_paymodel" value="匯款">
                      <label class="custom-control-label" for="new_paymodel2">匯款</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="new_account" class="col-form-label">帳號/卡號後五碼</label>
                    <input type="text" class="form-control" name="new_account" id="new_account">
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary">確認報名</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        @if( $nextLevel > 0 )
        <button type="button" class="btn btn-outline-secondary mx-1" data-toggle="modal" data-target="#nextForm">進階報名表</button>
        {{-- <a href="{{ route('course_return') }}"><button type="button" class="btn btn-outline-secondary">回報表單</button></a> --}}
        <!-- 二階報名表 modal -->
        <div class="modal fade" id="nextForm" tabindex="-1" role="dialog" aria-labelledby="nextFormLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="nextFormLabel">進階報名表</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body text-center">
                <a href="{{ route('course_form',['source_course'=>$course->id_course, 'source_events'=>$course->id]) }}">
                  <img class="img-thumbnail" src="https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl={{ route('course_form') }}%3Fsource_course={{$course->id_course}}%26source_events={{$course->id }}&choe=UTF-8" />
                </a>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">關閉</button>
              </div>
            </div>
          </div>
        </div>
        @else
        <button type="button" class="btn btn-outline-secondary mx-1" onclick="alert('尚未串接進階課程！\n請先到【課程管理】找到該課程的進階課程，進入至進階課程的【編輯】，點選「新增報名表」或「修改報名表」按鈕，在「對應課程」選擇此課程做串接。');">進階報名表</button>
        @endif
      </div>
    </div>
    @component('components.datatable')
    @slot('thead')
    <tr>
      <th class="colExcel">編號</th>
      <th class="colExcel">姓名</th>
      <th class="colExcel">聯絡電話</th>
      <th class="colExcel">電子郵件</th>
      <th>報到</th>
      <th class="d-none colExcel">報到</th>
      <th width="20%">報到備註</th>
      <th class="d-none colExcel">報到備註</th>
      @if( $course->type == 1 )
      <th class="colExcel">付費備註</th>
      <th></th>
      @endif
    </tr>
    @endslot
    @slot('tbody')
    @foreach($coursechecks as $key => $coursecheck)
    <tr>
      <td class="align-middle">{{ $coursecheck['row']  }}</td>
      <td scope="row" class="align-middle" name="search_name">{{ $coursecheck['name'] }}</td>
      <td class="align-middle" name="search_phone">{{ substr_replace($coursecheck['phone'], '***', 4, 3) }}</td>
      <td class="align-middle">{{ substr_replace($coursecheck['email'], '***', strrpos($coursecheck['email'], '@')) }}</td>
      <td class="align-middle">
        <button type="button" class="btn btn-sm text-white update_status" name="check_btn" id="{{ $coursecheck['check_id'] }}" value="{{ $coursecheck['check_status_val'] }}">{{ $coursecheck['check_status_name'] }}</button>
        <div class="btn-group ml-1">
          <a data-toggle="dropdown">
            •••
          </a>
          <div class="dropdown-menu">
            <button class="dropdown-item update_status" name="dropdown_check" value="{{ $coursecheck['check_id'] }}">報到</button>
            <button class="dropdown-item update_status" name="dropdown_absent" value="{{ $coursecheck['check_id'] }}">未到</button>
            <button class="dropdown-item update_status" name="dropdown_cancel" value="{{ $coursecheck['check_id'] }}">取消</button>
          </div>
        </div>
      </td>
      <td class="align-middle d-none" id="check{{ $coursecheck['check_id'] }}">{{ $coursecheck['check_status_name'] }}</td>
      <td class="align-middle">
        <!-- 報到備註 -->
        <input type="text" class="form-control input-sm checkNote auth_readonly" id="{{ $coursecheck['check_id'] }}" value="{{ ($coursecheck['memo'] == 'null')? '':$coursecheck['memo'] }}">
      </td>
      <td class="align-middle d-none" id="checkmemo{{ $coursecheck['check_id'] }}">{{ ($coursecheck['memo'] == 'null')? '':$coursecheck['memo'] }}</td>
      @if( $course->type == 1 )
      <td class="align-middle">{{ ($coursecheck['memo2'] == 'null')? '':$coursecheck['memo2'] }}</td>
      <td class="align-middle">
        <a role="button" class="btn btn-secondary btn-sm text-white mr-1 edit_data" data-id="{{ $coursecheck['check_id'] }}" data-toggle="modal" data-target="#edit_form">編輯</a>
        @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'officestaff' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'teacher'))
        <a role="button" class="btn btn-danger btn-sm text-white" onclick="btn_delete({{ $coursecheck['check_id'] }});">刪除</a>
        @endif
      </td>
      @endif
    </tr>
    @endforeach
    @endslot
    @endcomponent
  </div>
</div>


<!-- 編輯報名 modal -->
<div class="modal fade" id="edit_form" tabindex="-1" role="dialog" aria-labelledby="EditCheckLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditCheckLabel">現場報名</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-left">
        <form action="{{ url('course_check_edit') }}" method="POST">
          @csrf
          <input type="hidden" name="edit_idevents" id="edit_idevents" value="">
          <input type="hidden" name="edit_id" id="edit_id" value="">
          <div class="form-group required">
            <label for="edit_name" class="col-form-label">姓名</label>
            <input type="text" class="form-control" name="edit_name" id="edit_name" required>
          </div>
          <div class="form-group required">
            <label for="edit_phone" class="col-form-label">聯絡電話</label>
            <input type="text" class="form-control" name="edit_phone" id="edit_phone" readonly>
            <label class="text-secondary"><small>聯繫方式</small></label>
          </div>
          <div class="form-group">
            <label for="edit_email">電子郵件</label>
            <input type="text" class="form-control" name="edit_email" id="edit_email">
            <label class="text-secondary"><small>example@example.com</small></label>
          </div>
          <div class="form-group">
            <label for="edit_address" class="col-form-label">居住區域</label>
            <select class="custom-select form-control" name="edit_address" id="edit_address" readonly>
              <option selected disabled>請選擇居住區域</option>
              <option>宜蘭</option>
              <option>基隆</option>
              <option>台北</option>
              <option>新北</option>
              <option>桃園</option>
              <option>新竹</option>
              <option>苗栗</option>
              <option>台中</option>
              <option>彰化</option>
              <option>南投</option>
              <option>雲林</option>
              <option>嘉義</option>
              <option>台南</option>
              <option>高雄</option>
              <option>屏東</option>
              <option>台東</option>
              <option>花蓮</option>
            </select>
          </div>
          <div class="form-group">
            <label for="edit_profession">目前職業</label>
            <input type="text" class="form-control" name="edit_profession" id="edit_profession">
            <label class="text-secondary"><small>目前的工作職稱</small></label>
          </div>
          <div class="form-group">
            <label for="edit_paymodel" class="col-form-label">付款方式</label>
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="edit_paymodel1" name="edit_paymodel" value="刷卡">
              <label class="custom-control-label" for="edit_paymodel1">刷卡</label>
            </div>
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="edit_paymodel2" name="edit_paymodel" value="匯款">
              <label class="custom-control-label" for="edit_paymodel2">匯款</label>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_account" class="col-form-label">帳號/卡號後五碼</label>
            <input type="text" class="form-control" name="edit_account" id="edit_account">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-primary">確認修改</button>
      </div>
      </form>
    </div>
  </div>
</div>


<style>
  table#table_list {
    width: 100% !important;
  }
</style>
<script>
  var table;
  var today = moment(new Date()).format("YYYYMMDD");
  var title = today + '_簽到表' + '_' + $('#course_name').text() + '(' + $('#course_date').text() + ' ' + $('#course_event').text() + ')';

  //針對姓名與電話末三碼搜尋 Sandy(2020/02/26)
  $.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
      var keyword = $('#search_keyword').val();
      var tname = data[1];
      var tphone = data[2].substr(7, 3);

      if (isNaN(keyword) || tname.includes(keyword) || tphone.includes(keyword)) {
        return true;
      }
      return false;
    }
  );

  $("document").ready(function() {
    table_onload();

    // 權限判斷 Rocky(2020/05/10)
    $('#table_list').on('draw.dt', function() {
      check_auth();
    });
    check_auth();


    // Restore state
    var state = table.state.loaded();
    if (state) {
      //     console.log(state);
      // table.columns().eq( 0 ).each( function ( colIdx ) {
      //   var colSearch = state.columns[colIdx].search;
      //   if ( colSearch.search ) {
      //   }
      // } );
      $('#search_keyword').val(state.search.search);
      // table.draw();
    }
  });

  // 權限判斷
  function check_auth() {
    var role = ''
    role = JSON.parse($('#auth_role').val())['role']
    if (role == "accountant" || role == "staff") {
      $('.auth_readonly').attr('readonly', 'readonly')
    }
  }

  //datatable onload
  function table_onload() {
    // Sandy (2020/02/26)
    table = $('#table_list').DataTable({
      "dom": '<Bl<t>p>',
      "ordering": false,
      // "bStateSave": true,
      // "fnStateSave": function (oSettings, oData) {
      //     localStorage.setItem('offersDataTables', JSON.stringify(oData));
      // },
      // "fnStateLoad": function (oSettings) {
      //     return JSON.parse(localStorage.getItem('offersDataTables'));
      // },
      drawCallback: function() {
        //換頁或切換每頁筆數按鈕觸發報到狀態樣式
        $('.paginate_button, .dataTables_length', this.api().table().container()).on('click', function() {
          status_onload();
        });
      },
      buttons: [{
        extend: 'excel',
        text: '匯出Excel',
        exportOptions: {
          columns: '.colExcel'
        },
        title: title,
        // messageTop: $('#h3_title').text(),
      }]
    });

  }


  // 輸入框 Rocky(2020/02/19)
  $('#search_keyword').on('keyup', function(e) {
    if (e.keyCode === 13) {
      $('#btn_search').click();
    }
  });

  $("#btn_search").click(function() {
    table.search($('#search_keyword').val()).draw();
    status_onload();
  });

  // Sandy(2020/01/16)
  // 報到狀態修改 start
  $('body').on('click', '.update_status', function() {
    var today = moment().format("YYYY-MM-DD");
    var date = moment($('#event_date').val()).format("YYYY-MM-DD");

    //非當日更改狀態防呆機制 Sandy(2020/03/29)
    if (today == date) {
      update_status($(this));
    } else {
      var msg = "非當日場次，是否確定要更改狀態?";
      if (confirm(msg) == true) {
        update_status($(this));
      } else {
        return false;
      }
    }
  });

  function update_status(btn) {
    var update_status = btn.attr('name');
    var course_type = $("#course_type").val();

    var check_id, check_value;
    if (update_status == 'check_btn') {
      check_id = btn.attr('id');
      check_value = btn.val();
    } else {
      check_id = btn.val();
    }

    $.ajax({
      type: 'POST',
      url: 'course_check_status',
      data: {
        check_id: check_id,
        course_type: course_type,
        check_value: check_value,
        update_status: update_status
      },
      success: function(data) {
        // console.log(data);  

        var info = table.page.info();

        //重整datatable區塊
        $("#datatableDiv").load(window.location.href + " #datatableDiv", function() {
          status_onload();
          table_onload();
          //儲存不跳頁
          table.page( info.page ).draw( 'page' );
        });

        // $("#" + data["list"].check_id).val(data["list"].check_status_val);
        // $("#" + data["list"].check_id).html(data["list"].check_status_name);

        // $("#count_check").html(data.count_check);
        // $("#count_cancel").html(data.count_cancel);

        // status_style(data["list"].check_id, data["list"].check_status_val);

        // //更新隱藏報到狀態欄位(export用)
        // $("#check"+data["list"].check_id).html(data["list"].check_status_name);


        /** alert **/
        $("#success_alert_text").html(data["list"].check_name + "報名狀態修改成功");
        fade($("#success_alert"));
      },
      error: function(jqXHR) {
        console.log("error: " + JSON.stringify(jqXHR));

        /** alert **/
        $("#error_alert_text").html("報名狀態修改失敗");
        fade($("#error_alert"));
      }
    });
  }
  // 報到狀態修改 End


  // 資料自動儲存 Start
  // 主持開場
  $('#host').on('blur', function() {
    var data_type = 'host';
    save_data($(this), data_type);
  });
  $('#host').on('keyup', function(e) {
    if (e.keyCode === 13) {
      var data_type = 'host';
      save_data($(this), data_type);
    }
  });

  // 結束收單
  $('#closeorder').on('blur', function() {
    var data_type = 'closeorder';
    save_data($(this), data_type);
  });
  $('#closeorder').on('keyup', function(e) {
    if (e.keyCode === 13) {
      var data_type = 'closeorder';
      save_data($(this), data_type);
    }
  });

  // 天氣
  $('#weather').on('blur', function() {
    var data_type = 'weather';
    save_data($(this), data_type);
  });
  $('#weather').on('keyup', function(e) {
    if (e.keyCode === 13) {
      var data_type = 'weather';
      save_data($(this), data_type);
    }
  });

  // 工作人員
  $('#staff').on('blur', function() {
    var data_type = 'staff';
    save_data($(this), data_type);
  });
  $('#staff').on('keyup', function(e) {
    if (e.keyCode === 13) {
      var data_type = 'staff';
      save_data($(this), data_type);
    }
  });

  // 查詢前報到備註 event
  $('body').on('blur', '.checkNote', function() {
    var data_id = $(this).attr('id');
    var data_type = 'checkNote';
    save_data($(this), data_type, data_id);
  });
  $('body').on('keyup', '.checkNote', function(e) {
    if (e.keyCode === 13) {
      var data_id = $(this).attr('id');
      var data_type = 'checkNote';
      save_data($(this), data_type, data_id);
    }
  });

  function save_data(data, data_type, data_id) {
    var event_id = $("#event_id").val();
    var course_type = $("#course_type").val();
    var data_val = data.val();
    $.ajax({
      type: 'POST',
      url: 'course_check_data',
      data: {
        event_id: event_id,
        course_type: course_type,
        data_type: data_type,
        data_val: data_val,
        data_id: data_id
      },
      success: function(data) {
        // console.log(JSON.stringify(data));

        var info = table.page.info();

        $("#datatableDiv").load(window.location.href + " #datatableDiv", function() {
          status_onload();
          table_onload();
          //儲存不跳頁
          table.page( info.page ).draw( 'page' );
        });

        // //更新隱藏報到備註欄位(export用)
        // if( course_type == "checkNote"){
        //   $("#checkmemo"+data_id).html(data_val);
        // }
        // table.ajax.reload();

        /** alert **/
        $("#success_alert_text").html("資料儲存成功");
        fade($("#success_alert"));
      },
      error: function(jqXHR) {
        console.log(JSON.stringify(jqXHR));

        /** alert **/
        $("#error_alert_text").html("資料儲存失敗");
        fade($("#error_alert"));
      }
    });
  }
  // 資料自動儲存 End


  /* 編輯資料 S Sandy(2020/06/28) */
  $('.edit_data').on('click', function(e) {
    var id = $(this).data('id');
    $.ajax({
      type: 'GET',
      url: 'course_check_fill',
      data: {
        id: id
      },
      success: function(data) {
        console.log(data);

        // $('.edit_input').val('');
        // $('.edit_input').prop('checked',false);

        if (data != "nodata") {
          $("#edit_idevents").val($('#event_id').val()); //場次ID
          $("#edit_id").val(id); //報名ID
          $("#edit_name").val(data['name']);
          $("#edit_phone").val(data['phone']); //電話
          $("#edit_email").val(data['email']); //信箱
          $("#edit_address").val(data['address']); //居住地區
          $("#edit_profession").val(data['profession']); //職業
          //付款方式
          switch (data['pay_model']) {
            case "刷卡":
              $('#edit_paymodel1').click();
              break;
            case "匯款":
              $('#edit_paymodel2').click();
              break;
            default:
              break;
          }
          $("#edit_account").val(data['account']); //帳號/卡號後五碼
        }


      },
      error: function(jqXHR, textStatus, errorMessage) {
        console.log(jqXHR);
      }
    });
  });
  /* 編輯資料 E Sandy(2020/06/28) */


  /* 刪除資料 S Sandy(2020/06/25) */
  function btn_delete(id_apply) {
    var type = $('#course_type').val();
    var msg = "是否刪除此筆資料?";
    if (confirm(msg) == true) {
      $.ajax({
        type: 'POST',
        url: 'course_check_delete',
        dataType: 'json',
        data: {
          type: type,
          id_apply: id_apply
        },
        success: function(data) {
          console.log(data);
          if (data == "ok") {
            alert('刪除成功！！')
            /** alert **/
            // $("#success_alert_text").html("刪除資料成功");
            // fade($("#success_alert"));

            location.reload();
          } else {
            // alert('刪除失敗！！')

            /** alert **/
            $("#error_alert_text").html("刪除資料失敗");
            fade($("#error_alert"));
          }
        },
        error: function(error) {
          console.log(JSON.stringify(error));

          /** alert **/
          $("#error_alert_text").html("刪除資料失敗");
          fade($("#error_alert"));
        }
      });
    } else {
      return false;
    }
  }
  /* 刪除資料 E Sandy(2020/06/25) */
</script>
@endsection