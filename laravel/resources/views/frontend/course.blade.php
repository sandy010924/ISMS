@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '場次總覽')

@section('content')
<!-- Content Start -->
  <!--搜尋課程頁面內容-->
  <div class="card m-3">
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-3 mx-3">
          <button type="button" class="btn btn-outline-secondary btn_date float-left mx-1" data-toggle="modal" data-target="#form_import">匯入表單</button>  
          <!-- 匯入表單 modal -->     
          <div class="modal fade" id="form_import" tabindex="-1" role="dialog" aria-labelledby="form_importLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="form_importLabel">匯入表單</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <form class="form" action="{{url('course')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                    <div class="form-group required">
                      <label for="import_name" class="col-form-label">課程名稱</label>
                      <input type="text" class="form-control" name="import_name" id="import_name" required/>
                    </div>
                    <div class="form-group required">
                      <label for="import_teacher" class="col-form-label">講師</label>
                      <select class="custom-select" name="import_teacher" id="import_teacher" required>
                        <option selected disabled value="">選擇講師</option>
                        @foreach($teachers as $teacher)
                          <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group required">
                      <label for="import_flie" class="col-form-label">上傳檔案</label>
                      {{-- <textarea class="form-control" id="message-text"></textarea> --}}
                      <div class="custom-file">
                        <label class="custom-file-label" for="import_flie">瀏覽檔案</label>
                        <input type="file" class="custom-file-input" id="import_flie" name="import_flie" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required/>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                      <!-- <button type="button" id="import_check" class="btn btn-primary">確認</button> -->
                      <button type="submit"  class="btn btn-primary" >確認</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col"></div>
        <div class="col-3">
          <input type="date" class="form-control" id="search_date">
        </div>
        <div class="col-3">
          <input type="search" class="form-control" placeholder="搜尋課程" aria-label="Class's name" id="search_name">
        </div>
        <div class="col-2">
          <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button> 
        </div>
      </div>
      @component('components.datatable')
        @slot('thead')
          <tr>
            <th>日期</th>
            <th>課程名稱</th>
            <th>場次</th>
            <th>報名/取消筆數</th>
            <th>實到筆數</th>
            <th></th>
          </tr>
        @endslot
        @slot('tbody')
            @foreach($events as $key => $event )
              <tr>
                <td>{{ $event['date'] }}</td>
                <td>{{ $event['name'] }}</td>
                <td>{{ $event['event'] }}</td>
                <td>{{ $event['count_apply'] }} / <span style="color:red">{{ $event['count_cancel'] }}</span></td>
                <td>{{ $event['count_check'] }}</span></td>
                <td>
                  @if( strtotime($event['date']) == strtotime(date("Y-m-d")) )
                  <!-- 今日場次 -->
                  <a href="{{ $event['href_check'] }}"><button type="button" class="btn btn-success btn-sm mx-1">開始報到</button></a>
                  <a href="{{ $event['href_list'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">查詢名單</button></a>
                  <a><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">查看進階填單名單</button></a>
                  <a><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">場次報表</button></a>
                  @elseif( strtotime($event['date']) > strtotime(date("Y-m-d")) )
                  <!-- 未過場次 -->
                  <a><button type="button" class="btn btn-success btn-sm mx-1" disabled="ture">開始報到</button></a>
                  <a href="{{ $event['href_list'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">查詢名單</button></a>
                  <a><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">查看進階填單名單</button></a>
                  <a><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">場次報表</button></a>
                  @elseif( strtotime($event['date']) < strtotime(date("Y-m-d")) )
                  <!-- 已過場次 -->
                  <a><button type="button" class="btn btn-success btn-sm mx-1" disabled="ture">開始報到</button></a>
                  <a href="{{ $event['href_list'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">查詢名單</button></a>
                  @if( $event['nextLevel'] > 0 )
                    <a href="{{ $event['href_adv'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">查看進階填單名單</button></a>
                  @else
                    <a><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">查看進階填單名單</button></a>
                  @endif
                  <a href="{{ $event['href_return'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">場次報表</button></a>
                  @endif
                  <button id="{{ $event['id'] }}" class="btn btn-danger btn-sm mx-1" onclick="btn_delete({{ $event['id'] }});" value="{{ $event['id'] }}" >刪除</button>
                </td>
              </tr>
            @endforeach
        @endslot
      @endcomponent
    </div>
  </div>
  <!-- Rocky(2020/01/11) -->
  @if (session('status') == "匯入成功")
  <div class="alert alert-success alert-dismissible m-3 position-fixed fixed-bottom" role="alert">
    {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @elseif (session('status') == "匯入失敗" || session('status') == "請選檔案/填講師姓名")  
  <div class="alert alert-danger alert-dismissible m-3 position-fixed fixed-bottom" role="alert">
    {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  <!-- alert Start-->
  <div class="alert alert-success alert-dismissible m-3 position-fixed fixed-bottom" role="alert" id="success_alert">
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

<!-- Content End -->

<script>
  // Sandy(2020/02/26) dt列表搜尋 S
  var table;
  //針對日期與課程搜尋 Sandy(2020/02/26)
  $.fn.dataTable.ext.search.push(
      function( settings, data, dataIndex ) {
          var date = $('#search_date').val();
          var name = $('#search_name').val();
          var tdate = data[0]; 
          var tname = data[1]; 
  
        if ( (isNaN( date ) && isNaN( name )) || ( tdate.includes(date) && isNaN( name ) ) || ( tname.includes(name) && isNaN( date ) ) || ( tname.includes(name) && tname.includes(name) ) )
          {
              return true;
          }
          return false;
      }
  );

  $("document").ready(function(){
    // Rocky(2020/01/06)
    $("#import_flie").change(function(){
      var i = $(this).prev('label').clone();
      var file = $('#import_flie')[0].files[0].name;
      $(this).prev('label').text(file);
    }); 

    // Sandy (2020/02/26)
    table = $('#table_list').DataTable({
        "dom": '<l<t>p>',
        "ordering": false
    });

  });

  // 輸入框 Sandy(2020/02/25)
  $('#search_name').on('keyup', function(e) {
    if (e.keyCode === 13) {
        $('#btn_search').click();
    }
  });
  $('#search_date').on('keyup', function(e) {
    if (e.keyCode === 13) {
        $('#btn_search').click();
    }
  });
  
  $("#btn_search").click(function(){
    table.columns(0).search($('#search_date').val()).columns(1).search($("#search_name").val()).draw();
  });
  // Sandy(2020/02/26) dt列表搜尋 E

  // 刪除 Rocky(2020/02/11)
  function btn_delete(id_events){
    var msg = "是否刪除此場次?";
    if (confirm(msg)==true){
      $.ajax({
          type : 'POST',
          url:'course_delete', 
          dataType: 'json',    
          data:{
            id_events: id_events
          },
          success:function(data){
            if (data['data'] == "ok") {                           
              alert('刪除成功！！')
              /** alert **/
              // $("#success_alert_text").html("刪除課程成功");
              // fade($("#success_alert"));

              location.reload();
            }　else {
              // alert('刪除失敗！！')

              /** alert **/ 
              $("#error_alert_text").html("刪除課程失敗");
              fade($("#error_alert"));       
            }           
          },
          error: function(error){
            console.log(JSON.stringify(error));   

            /** alert **/ 
            $("#error_alert_text").html("刪除課程失敗");
            fade($("#error_alert"));       
          }
      });
    }else{
      return false;
    }    
  }

</script>
@endsection