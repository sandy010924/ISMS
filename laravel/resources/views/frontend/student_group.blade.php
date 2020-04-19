@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '名單列表')

@section('content')
<!-- Content Start -->
<!--學員名單列表內容-->
<div class="card m-3">
  <div class="card-body">
    <div class="row">
      <div class="col-3 "></div>
      <div class="col-2">
        <button class="btn btn-outline-secondary" type="button" id="btn_add">創建名單列表</button>
      </div>
      <div class="col-4">
        <div class="input-group mb-3">
          <input type="search" id="search_keyword" class="form-control" placeholder="輸入名單列表名稱" aria-label="Group's name" aria-describedby="btn_search">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
          </div>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      @component('components.datatable')
      @slot('thead')
      <tr>
        <th>名單列表名稱</th>
        <th>創建日期</th>
        <th>名單筆數</th>
        <th></th>
      </tr>
      @endslot
      @slot('tbody')
      @foreach($datas as $data)
      <tr>
        <td class="align-middle">{{ $data['name'] }}</td>
        <td class="align-middle">{{ $data['created_at'] }}</td>
        <td class="align-middle">{{ $data['COUNT'] }}</td>
        <td class="align-middle">
          <!-- <a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1">編輯</button></a> -->
          <!-- <button id="edit_{{ $data['id'] }}" class="btn btn-secondary btn-sm mx-1" onclick="btn_edit({{ $data['id'] }});">編輯</button> -->
          <a role="button" class="btn btn-secondary btn-sm mx-1" href="{{ route('student_group_edit', [ 'id' => $data['id'] ] ) }}">編輯</a>
          <button id="copy_{{ $data['id'] }}" class="btn btn-secondary btn-sm mx-1" onclick="btn_copy({{ $data['id'] }});" value="{{ $data['id'] }}">複製</button>
          <!-- <a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1">複製</button></a> -->
          <!-- <button href="#"><button type="button" class="btn btn-secondary btn-sm mx-1">刪除</button></a> -->
          <button id="{{ $data['id'] }}" class="btn btn-danger btn-sm mx-1" onclick="btn_delete({{ $data['id'] }});" value="{{ $data['id'] }}">刪除</button>
        </td>
      </tr>
      @endforeach
      @endslot
      @endcomponent
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
  // 搜尋 Rocky(2020/03/20)
  var table;
  $.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
      var keyword = $('#search_keyword').val();
      var tname = data[0];

      if ((isNaN(keyword)) || (tname.includes(keyword))) {
        return true;
      }
      return false;
    }
  );
  $("#btn_search").click(function() {
    table.columns(0).search($('#search_keyword').val()).draw();
  });

  $("document").ready(function() {
    // Rocky (2020/03/20)
    table = $('#table_list').DataTable({
      "dom": '<l<t>p>',
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }]
      // "ordering": false,
    });
  });

  // 跳頁
  $("#btn_add").click(function() {
    $(location).attr('href', "{{ route('student_group_add') }}");
  });

  function btn_edit(id) {
    $.ajax({
      type: 'POST',
      url: 'testshow',
      data: {
        id: id
      },
      success: function(data) {
        console.log(data);
        // if (data == "複製成功") {
        //   location.reload();
        // }
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }


  // 刪除 Rocky(2020/03/20)
  function btn_delete(id) {
    var msg = "是否刪除此筆資料?";
    if (confirm(msg) == true) {
      $.ajax({
        type: 'POST',
        url: 'group_delete',
        dataType: 'json',
        data: {
          id: id
        },
        success: function(data) {
          if (data['data'] == "ok") {
            // alert('刪除成功！！')
            /** alert **/
            $("#success_alert_text").html("刪除課程成功");
            fade($("#success_alert"));

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

  // 複製 Rocky(2020/03/20)
  function btn_copy(id) {
    $.ajax({
      type: 'POST',
      url: 'group_copy',
      data: {
        id: id
      },
      success: function(data) {
        if (data == "複製成功") {
          location.reload();
        }
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }
</script>
@endsection