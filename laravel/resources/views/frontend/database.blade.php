@extends('frontend.layouts.master')

@section('title', '系統設定')
@section('header', '備份管理')

@section('content')
<!-- <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> -->
<!-- Content Start -->
<!--備份管理頁面內容-->
<div class="card m-3">
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-4"></div>
      <div class="col-7">
        <div class="input-group">
          <div class="col-md-4">
            <div class="input-group date" data-target-input="nearest">
              <input type="text" id="search_keyword" name="debt_date" class="form-control datetimepicker-input" data-target="#search_keyword" placeholder="日期">
              <div class="input-group-append" data-target="#search_keyword" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <button type="button" class="btn btn-outline-secondary" id="btn_search">搜尋</button>
          </div>
          <div class="col-md-3">
            <!-- <button type="button" class="btn btn-outline-secondary" id="btn_backup" onclick="backup();">點我備份</button> -->
            <!-- <button type="button" class="btn btn-outline-secondary" id="btn_backup" onclick="btn_delete();">點我刪除</button> -->
          </div>
        </div>
      </div>
    </div>
    @component('components.datatable')
    @slot('thead')
    <tr>
      <th>檔名</th>
      <th>日期</th>
      <th class="no-sort"></th>
    </tr>
    @endslot
    @slot('tbody')
    @foreach($datas as $key => $data )
    <tr>
      <td>{{ $data['filename'] }}</td>
      <td>{{ $data['created_at'] }}</td>
      <td>
        <button id="{{ $data['id'] }}" class="btn btn-success btn-sm mx-1" onclick="btn_recover({{ $data['id'] }});" value="{{ $data['id'] }}">還原資料</button>
      </td>
    </tr>
    @endforeach
    @endslot
    @endcomponent
  </div>
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="btn_save" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Content End -->

<!-- alert Start-->
<div class="alert alert-success alert-dismissible  m-3 position-fixed fixed-bottom" role="alert" id="success_alert">
  <span id="success_alert_text"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="alert alert-danger alert-dismissible m-3 position-fixed fixed-bottom" role="alert" id="error_alert">
  <span id="error_alert_text"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<!-- alert End -->

<script>
  // dt列表搜尋 S
  var table;
  $.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
      var keyword = $('#search_keyword').val();
      var tname = data[1];

      if ((isNaN(keyword)) || (tname.includes(keyword))) {
        return true;
      }
      return false;
    }
  );

  $("document").ready(function() {
    table = $('#table_list').DataTable({
      "dom": '<l<t>p>',
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }]
    });

    $('#search_keyword').datetimepicker({
      format: 'YYYY-MM-DD'
    });
  });

  // 輸入框 
  $('#search_keyword').on('keyup', function(e) {
    if (e.keyCode === 13) {
      $('#btn_search').click();
    }
  });

  $("#btn_search").click(function() {
    table.columns(1).search($('#search_keyword').val()).columns(2).search($("#search_role").val()).draw();
  });
  //  dt列表搜尋 E

  // 備份
  function backup() {
    $.ajax({
      type: 'POST',
      url: 'database_backup',
      dataType: 'json',
      success: function(data) {
        console.log(data)
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }

  function btn_delete() {
    $.ajax({
      type: 'POST',
      url: 'database_delete',
      dataType: 'json',
      success: function(data) {
        console.log(data)
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }

  // 還原資料 Rocky(2020/04/10)
  function btn_recover(id) {
    var msg = "是否還原資料?";
    var msg_check = "再給你一次機會，點擊「確定」後就會「還原資料」，你確定還原資料?";
    if (confirm(msg) == true) {
      if (confirm(msg_check) == true) {
        $.ajax({
          type: 'POST',
          url: 'database_recover',
          dataType: 'text',
          data: {
            id: id
          },
          success: function(data) {
            console.log(data)
            if (data == "ok") {
              /** alert **/
              $("#success_alert_text").html("還原成功");
              fade($("#success_alert"));

            } else {
              /** alert **/
              $("#error_alert_text").html("還原失敗");
              fade($("#error_alert"));
            }
          },
          error: function(error) {
            console.log(JSON.stringify(error));

            /** alert **/
            $("#error_alert_text").html("還原失敗");
            fade($("#error_alert"));
          }
        });
      }
    } else {
      return false;
    }
  }
</script>
@endsection