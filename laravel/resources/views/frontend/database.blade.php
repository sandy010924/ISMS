@extends('frontend.layouts.master')

@section('title', '系統設定')
@section('header', '備份管理')

@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<!-- Content Start -->
<!--備份管理頁面內容-->
<div class="card m-3">
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-4"></div>
      <div class="col-7">
        <div class="input-group">
          <div class="col-md-4">
            <input type="search" class="form-control" name="name" placeholder="搜尋姓名" aria-describedby="btn_search" id="search_keyword">
          </div>
          <div class="col-md-3">
            <button type="button" class="btn btn-outline-secondary" id="btn_search">搜尋</button>
          </div>
          <div class="col-md-3">
            <button type="button" class="btn btn-outline-secondary" id="btn_backup" onclick="backup();">點我備份</button>
          </div>
        </div>
        {{-- </form> --}}
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
<!-- <div id="dialog" title="Basic dialog">
  <p>Image:</p>
  <img src="http://placehold.it/50x50" alt="Placeholder Image" />

</div> -->
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
  // Sandy(2020/02/26) dt列表搜尋 S
  var table;
  //針對姓名與角色搜尋 Sandy(2020/02/26)
  $.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
      var keyword = $('#search_keyword').val();
      var role = $('#search_role').val();
      var tname = data[1];
      var trole = data[2];

      if ((isNaN(keyword) && isNaN(role)) || (tname.includes(keyword) && isNaN(role)) || (trole.includes(role) && isNaN(keyword)) || (trole.includes(role) && tname.includes(keyword))) {
        return true;
      }

      return false;
    }
  );

  $("document").ready(function() {
    // Sandy (2020/02/26)
    table = $('#table_list').DataTable({
      "dom": '<l<t>p>',
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }]
      // "ordering": false,
    });
  });

  // 輸入框 Sandy(2020/02/25)
  $('#search_keyword').on('keyup', function(e) {
    if (e.keyCode === 13) {
      $('#btn_search').click();
    }
  });
  $('#search_role').on('keyup', function(e) {
    if (e.keyCode === 13) {
      $('#btn_search').click();
    }
  });

  $("#btn_search").click(function() {
    table.columns(1).search($('#search_keyword').val()).columns(2).search($("#search_role").val()).draw();
  });
  // Sandy(2020/02/26) dt列表搜尋 E

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


  // 還原資料 Rocky(2020/04/10)
  function btn_recover(id) {
    var msg = "是否還原資料?";
    var msg_check = "你確定要還原資料? 若還原錯資料一概不負責";
    // if (confirm(msg) == true) {
    // $("#dialog").dialog();
    // if (confirm(msg_check) == true) {

    // }
    $.ajax({
      type: 'POST',
      url: 'database_recover',
      dataType: 'text',
      data: {
        id: id
      },
      success: function(data) {
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
    // } else {
    //   return false;
    // }
  }
</script>
@endsection