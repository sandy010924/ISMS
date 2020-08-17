@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '課程管理')

@section('content')
<style>
  /* 重複資料Modal Y軸滾輪 Rocky(2020/08/06)*/
  .modal-dialog {
    overflow-y: initial !important
  }

  .modal-body_repeat {
    height: 300px;
    overflow-y: auto;
  }

  /* 重複資料Modal Y軸滾輪 Rocky(2020/08/06)*/
</style>

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" /> --}}
{{-- <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> --}}

<!-- Content Start -->
<!--課程管理內容-->
<div class="card m-3">
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-4">
        @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'saleser' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'officestaff' ))
        <button type="button" class="btn btn-outline-secondary mr-3" data-toggle="modal" data-target="#listform_new">新增課程</button>
        @endif
        <div class="modal fade" id="listform_new" tabindex="-1" role="dialog" aria-labelledby="listform_newLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <!-- <form class="form" action="{{ url('course_list_insert') }}" method="POST" enctype="multipart/form-data"> -->
              <input type="hidden" id="reload_upload" name="reload_upload" value="0">
              <form class="form" id="form_excel_upload" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                  <h5 class="modal-title">新增課程</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group required">
                    <label for="new_name" class="col-form-label">課程名稱</label>
                    {{-- <input type="text" id="new_name" name="new_name" class="form-control" required> --}}
                    <input type="search" list="course" id="new_name" name="new_name" class="form-control" required />
                    <datalist class="w-100" id="course">
                      @foreach($course_list as $data)
                      {{-- <option value="{{ $teacher->id }}">{{ $teacher->name }}</option> --}}
                      <option value="{{ $data->name }}"></option>
                      @endforeach
                    </datalist>
                  </div>
                  <div class="form-group required">
                    <label for="new_teacher" class="col-form-label">講師名稱</label>
                    {{-- <select class="custom-select" id="new_teacher" name="new_teacher" required>
                          <option selected disabled value="">選擇講師</option>
                          @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                    </select> --}}
                    <input type="search" list="teacher" id="new_teacher" name="new_teacher" class="form-control" required />
                    <datalist class="w-100" id="teacher">
                      @foreach($teachers as $teacher)
                      {{-- <option value="{{ $teacher->id }}">{{ $teacher->name }}</option> --}}
                      <option value="{{ $teacher->name }}"></option>
                      @endforeach
                    </datalist>
                  </div>
                  <div class="form-group required">
                    <label for="new_type" class="col-form-label">類型</label>
                    <select class="custom-select" id="new_type" name="new_type" required>
                      <option selected disabled value="">選擇類型</option>
                      <option value="1">銷講</option>
                      <option value="2">二階課程</option>
                      <option value="3">三階課程</option>
                      <option value="4">活動</option>
                    </select>
                  </div>
                  <div id="sales" style="display:none">
                    <div class="form-group required">
                      <label for="new_flie" class="col-form-label">上傳檔案</label>
                      <div class="custom-file">
                        <label class="custom-file-label" for="new_flie" id="import_flie_name">瀏覽檔案</label>
                        <input type="file" class="custom-file-input" id="new_flie" name="new_flie" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required />
                      </div>
                    </div>
                  </div>
                  <div id="formal" style="display:none">
                    <div class="form-group required">
                      <label for="new_location" class="col-form-label">地點</label>
                      <input type="text" id="new_location" name="new_location" class="form-control" required />
                    </div>
                    <div class="form-group required">
                      <label for="new_date" class="col-form-label">課程日期</label>
                      <label class="text-secondary px-2 py-1"><small>(可選擇多天，一次選擇一組場次)</small></label>
                      <br />
                      <div class="input-group date" id="new_date" data-target-input="nearest">
                        <input type="text" name="new_date" class="form-control datetimepicker-input" data-target="#new_date" data-toggle="datetimepicker" autocomplete="off" required />
                        <div class="input-group-append" data-target="#new_date" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-md-6 mb-3 required">
                        <label for="new_starttime" class="col-form-label">課程開始時間</label><br />
                        <div class="input-group date" id="new_starttime" data-target-input="nearest">
                          <input type="text" name="new_starttime" class="form-control datetimepicker-input" data-target="#new_starttime" data-toggle="datetimepicker" autocomplete="off" required />
                          <div class="input-group-append" data-target="#new_starttime" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-clock"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3 required">
                        <label for="new_endtime" class="col-form-label">課程結束時間</label><br />
                        <div class="input-group date" id="new_endtime" data-target-input="nearest">
                          <input type="text" name="new_endtime" class="form-control datetimepicker-input" data-target="#new_endtime" data-toggle="datetimepicker" autocomplete="off" required />
                          <div class="input-group-append" data-target="#new_endtime" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-clock"></i></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group required">
                      <label for="new_event" class="col-form-label">場次</label><br />
                      <input type="search" list="events" id="new_event" name="new_event" class="form-control" required />
                      <datalist class="w-100" id="events">
                        <option value="台北場"></option>
                        <option value="台北上午場"></option>
                        <option value="台北下午場"></option>
                        <option value="台北晚上場"></option>
                        <option value="台中場"></option>
                        <option value="台中上午場"></option>
                        <option value="台中下午場"></option>
                        <option value="台中晚上場"></option>
                        <option value="高雄場"></option>
                        <option value="高雄上午場"></option>
                        <option value="高雄下午場"></option>
                        <option value="高雄晚上場"></option>
                      </datalist>
                    </div>
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
      </div>
      <div class="col-6 mx-3">
        <div class="input-group">
          <input type="search" class="form-control" placeholder="搜尋課程" aria-describedby="btn_search" id="search_name">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
          </div>
        </div>
      </div>
    </div>
    @component('components.datatable')
    @slot('thead')
    <tr>
      <th>講師姓名</th>
      <th>類別</th>
      <th>課程名稱</th>
      <th class="no-sort">表單上場次數</th>
      <th class="no-sort">總場次數</th>
      <th class="no-sort">累計名單</th>
      <th class="no-sort"></th>
    </tr>
    @endslot
    @slot('tbody')
    @foreach($course as $key => $data )
    <tr>
      <td>{{ $data['teacher'] }}</td>
      <td>{{ $data['type'] }}</td>
      <td>{{ $data['course'] }}</td>
      <td>{{ $data['count_form'] }}</td>
      <td>{{ $data['count_events'] }}</td>
      <td>{{ $data['count_list'] }}</td>
      <td>
        <div class="btn-group">
          <button class="btn btn-secondary dropdown-toggle btn-sm mx-1 text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            名單
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('course_list_apply', [ 'id' => $data['id'] ]) }}">報名名單</a>
            @if( $data['type'] != "銷講" && $data['type'] != "活動" )
            <a class="dropdown-item" href="{{ route('course_list_refund', [ 'id' => $data['id'] ]) }}">退費名單</a>
            @endif
          </div>
        </div>

        <a class="btn btn-secondary btn-sm mx-1" href="{{ route('course_list_data', [ 'id' => $data['id'] ] ) }}">場次數據</a>
        @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'officestaff' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'teacher'))
        <a class="btn btn-secondary btn-sm mx-1" href="{{ route('course_list_edit', [ 'id' => $data['id'] ] ) }}">編輯</a>
        @endif
        {{-- <a class="btn btn-danger btn-sm mx-1 text-white" onclick="btn_delete({{ $data['all_id'] }});" value="{{ $data['all_id'] }}" >刪除</a> --}}
        @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'marketer' || Auth::user()->role == 'officestaff' || Auth::user()->role == 'msaleser' || Auth::user()->role == 'teacher'))
        <a class="btn btn-danger btn-sm mx-1 text-white" onclick="btn_delete({{ $data['id'] }});">刪除</a>
        @endif
      </td>
    </tr>
    @endforeach
    @endslot
    @endcomponent
  </div>
</div>
<!-- Content End -->

<!-- 重複資料 Rocky(2020/08/02) -->
<div class="modal bd-example-modal-xl" tabindex="-1" role="dialog" id="check_excel_upload">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fa fa-bell"></i>
          重複資料提醒
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body modal-body_repeat">
        <!-- 內容 -->
        <div id="dev_repeat"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="cancle_reload_excel();">取消上傳</button>
        <button type="button" class="btn btn-success" onclick="reload_excel_upload();">繼續上傳</button>
      </div>
    </div>
  </div>
</div>
<!-- 重複資料 Rocky(2020/08/02) -->
<script>
  //DataTable
  var table;

  $(document).ready(function() {
    // Rocky(2020/01/06)
    $("#new_flie").change(function() {
      var i = $(this).prev('label').clone();
      var file = $('#new_flie')[0].files[0].name;
      $(this).prev('label').text(file);
    });

    //新增課程 選擇銷講/正課 Sandy (2020/02/26)
    $("select#new_type").change(function() {
      if ($("#new_type").val() == 1 || $("#new_type").val() == 4) {
        $('#sales').show();
        $('#formal').hide();
        $("#sales").find("input").prop('required', true);
        $("#formal").find("input").removeAttr('required');
      } else if ($("#new_type").val() == 2 || $("#new_type").val() == 3) {
        $('#sales').hide();
        $('#formal').show();
        $("#sales").find("input").removeAttr('required');
        $("#formal").find("input").prop('required', true);
      }
    });

    //日期&g時間選擇器 Sandy (2020/02/27)
    var iconlist = {
      time: 'fas fa-clock',
      date: 'fas fa-calendar',
      up: 'fas fa-arrow-up',
      down: 'fas fa-arrow-down',
      previous: 'fas fa-arrow-circle-left',
      next: 'fas fa-arrow-circle-right',
      today: 'far fa-calendar-check-o',
      clear: 'fas fa-trash',
      close: 'far fa-times'
    }
    $('#new_date').datetimepicker({
      format: 'YYYY-MM-DD',
      icons: iconlist,
      allowMultidate: true,
      multidateSeparator: ','
    });
    $('#new_starttime').datetimepicker({
      format: 'HH:mm',
      icons: iconlist
    });
    $('#new_endtime').datetimepicker({
      format: 'HH:mm',
      icons: iconlist
    });

    //DataTable
    table = $('#table_list').DataTable({
      "dom": '<l<t>p>',
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }]
    });
  });


  // 新增課程 Rocky(2020/08/01)
  $('#form_excel_upload').on('submit', function(event) {
    // 關閉表單自動送出
    event.preventDefault();

    var formData = new FormData(this);

    // 增加欄位
    formData.append('reload_upload', $('#reload_upload').val())

    $.ajax({
      url: 'course_list_insert',
      method: "POST",
      data: formData,
      contentType: false,
      cache: false,
      processData: false,
      success: function(data) {
        // console.log(data)
        if ($("#new_type").val() == '1' || $("#new_type").val() == '4') {

          // 判斷有沒有重複資料(銷講 / 活動)
          if (data['status'] == 'repeat') {
            var data_repeat = ''

            // 顯示重複資料Modal
            $('#check_excel_upload').modal('show');

            // 顯示資料
            $.each(data['datas'], function(index, val) {
              var type = ''
              if (val['type'] == '1') {
                type = '<b style="color:red;padding-right: 1.6%;">有同樣姓名、email</b>'
              } else if (val['type'] == '2') {
                type = '<b style="color:#50a71a;padding-right: 2.5%;">有同樣姓名、電話</b>'
              } else if (val['type'] == '3') {
                type = '<b style="color:#2959b2;padding-right: 0.5%;">有同樣email、電話</b>'
              } else if (val['type'] == '4') {
                type = '<b style="color:#ac7e17;padding-right: 0.5%;">有同樣電話</b>'
              }

              data_repeat += type + '匯入檔案第' + val['key'] + '筆資料 - ' + val['sname'] + '學生與系統  ' +
                val['name'] + ' / ' + val['phone'] + ' / ' + val['email'] + '<br>'
            });

            $('#dev_repeat').html(data_repeat)

            // 關閉匯入Modal
            $('#listform_new').modal('hide');

          } else if (data['status'] == 'successful') {
            // 關閉匯入Modal
            $('#listform_new').modal('hide');

            // Alert
            $("#success_alert_text").html("匯入成功");
            fade($("#success_alert"));

            // 清空Form資料
            $('#import_flie_name').text('');
            $("#form_excel_upload")[0].reset();

            window.location.href = "./course";
          } else {
            // Alert
            $("#error_alert_text").html("匯入失敗");
            fade($("#error_alert"));

            // 清空Form資料
            $('#import_flie_name').text('');
            $("#form_excel_upload")[0].reset();
          }
        } else {
          if (data['status'] == 'successful') {
            // 關閉匯入Modal
            $('#listform_new').modal('hide');

            // Alert
            $("#success_alert_text").html("新增成功");
            fade($("#success_alert"));

            // location.reload();
            window.location.href = "./course";
          } else {
            // Alert
            $("#error_alert_text").html("新增失敗");
            fade($("#error_alert"));
          }
        }
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    })
  });

  // 繼續匯入 Rocky(2020/08/01)
  function reload_excel_upload() {
    var formData = new FormData($('#form_excel_upload')[0]);

    // 重新匯入
    $('#reload_upload').val('1');

    // 增加欄位
    formData.append('reload_upload', $('#reload_upload').val())

    $.ajax({
      url: 'course_list_insert',
      method: "POST",
      data: formData,
      contentType: false,
      cache: false,
      processData: false,
      success: function(data) {
        // 判斷有沒有重複資料
        if (data['status'] == 'successful') {
          // 關閉匯入Modal
          $('#check_excel_upload').modal('hide');

          // Alert
          $("#success_alert_text").html("匯入成功");
          fade($("#success_alert"));

          // 清空Form資料
          $('#import_flie_name').text('');
          $("#form_excel_upload")[0].reset();

          window.location.href = "./course";
        } else {
          // Alert
          $("#error_alert_text").html("匯入失敗");
          fade($("#error_alert"));

          // 清空Form資料
          $('#import_flie_name').text('');
          $("#form_excel_upload")[0].reset();
        }
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    })
  }

  // 取消上傳 Rocky(2020/08/02)
  function cancle_reload_excel() {
    // 關閉匯入Modal
    $('#check_excel_upload').modal('hide');

    // 清空Form資料
    $('#import_flie_name').text('');
    $("#form_excel_upload")[0].reset();

  }

  // Sandy(2020/02/26) dt列表搜尋 S
  $('#search_name').on('keyup', function(e) {
    if (e.keyCode === 13) {
      $('#btn_search').click();
    }
  });
  $("#btn_search").click(function() {
    table.columns(2).search($("#search_name").val()).draw();
  });
  // Sandy(2020/02/26) dt列表搜尋 E

  // 刪除 Sandy(2020/02/25) start
  function btn_delete(id_course) {
    var msg = "是否刪除此課程?";
    if (confirm(msg) == true) {
      $.ajax({
        type: 'POST',
        url: 'course_list_delete',
        dataType: 'json',
        data: {
          id_course: id_course
        },
        success: function(data) {
          console.log(data);
          if (data['data'] == "ok") {
            alert('刪除成功！！')
            /** alert **/
            // $("#success_alert_text").html("刪除課程成功");
            // fade($("#success_alert"));

            location.reload();
          } else {
            // alert('刪除失敗！！')

            /** alert **/
            $("#error_alert_text").html("刪除課程失敗");
            fade($("#error_alert"));
          }
        },
        error: function(error) {
          console.log(JSON.stringify(error));

          /** alert **/
          $("#error_alert_text").html("刪除課程失敗");
          fade($("#error_alert"));
        }
      });
    } else {
      return false;
    }
  }
  // 刪除 Sandy(2020/02/25) end
</script>

@endsection