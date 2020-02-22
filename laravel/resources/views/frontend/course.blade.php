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
                              <option value="1">Julia</option>
                              <option value="2">Jack</option>
                              <option value="3">Mark</option>
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
                {{-- <button type="button" class="btn btn-outline-secondary btn_date mx-1" data-toggle="modal" data-target="#form_newclass">新增課程</button>
                <div class="modal fade" id="form_newclass" tabindex="-1" role="dialog" aria-labelledby="form_newclassLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="form_newclassLabel">新增課程</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="form-group">
                            <label for="newclass_name" class="col-form-label">課程名稱</label>
                            <input type="text" class="form-control" id="newclass_name" required>
                          </div>
                          <div class="form-group">
                            <label for="newclass_teacher" class="col-form-label">講師</label>
                            <select class="custom-select" id="newclass_teacher" required>
                              <option selected>選擇講師</option>
                              <option value="1">Julia</option>
                              <option value="2">Jack</option>
                              <option value="3">Mark</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="newclass_date" class="col-form-label">日期</label>
                            <input type="date" class="form-control" id="newclass_date">
                          </div>
                          <div class="form-group">
                            <label for="newclass_session" class="col-form-label">場次</label>
                            <select class="custom-select form-control" id="newclass_session">
                              <option selected>選擇場次</option>
                              <option value="1">台北上午場</option>
                              <option value="2">台北下午場</option>
                              <option value="3">台北晚上場</option>
                              <option value="4">台中上午場</option>
                              <option value="5">台中下午場</option>
                              <option value="6">台中晚上場</option>
                              <option value="7">高雄上午場</option>
                              <option value="8">高雄下午場</option>
                              <option value="9">高雄晚上場</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="newclass_location" class="col-form-label">地點</label>
                            <input type="text" class="form-control" id="newclass_location">
                          </div>
                          <div class="form-group">
                            <label for="newclass_timestart" class="col-form-label">開始時間</label>
                            <input type="time" class="form-control" id="newclass_timestart">
                          </div>
                          <div class="form-group">
                            <label for="newclass_timeend" class="col-form-label">結束時間</label>
                            <input type="time" class="form-control" id="newclass_timeend">
                          </div>
                          
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="button" id="import_check" class="btn btn-primary">確認</button>
                      </div>
                    </div>
                  </div>
                </div> --}}
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
            <div class="table-responsive">
              <table class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>日期</th>
                    <th>課程名稱</th>
                    <th>場次</th>
                    <th>報名/取消筆數</th>
                    <th>實到筆數</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="table_list">
                @foreach($courses as $key => $course )
                  <tr>
                    <td>{{ $course['date'] }}</td>
                    <td>{{ $course['name'] }}</td>
                    <td>{{ $course['event'] }}</td>
                    <td>{{ $course['count_apply'] }} / <span style="color:red">{{ $course['count_cancel'] }}</span></td>
                    <td>{{ $course['count_check'] }}</span></td>
                    <td>
                      @if( strtotime($course['date']) == strtotime(date("Y-m-d")) )
                      <!-- 今日場次 -->
                      <a href="{{ $course['href_check'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">開始報到</button></a>
                      <a href="{{ $course['href_list'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">查詢名單</button></a>
                      <a><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">查看進階填單名單</button></a>
                      <a><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">場次報表</button></a>
                      @elseif( strtotime($course['date']) > strtotime(date("Y-m-d")) )
                      <!-- 未過場次 -->
                      <a><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">開始報到</button></a>
                      <a href="{{ $course['href_list'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">查詢名單</button></a>
                      <a><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">查看進階填單名單</button></a>
                      <a><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">場次報表</button></a>
                      @elseif( strtotime($course['date']) < strtotime(date("Y-m-d")) )
                      <!-- 已過場次 -->
                      <a><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">開始報到</button></a>
                      <a href="{{ $course['href_list'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">查詢名單</button></a>
                      <a href="{{ $course['href_adv'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">查看進階填單名單</button></a>
                      <a href="{{ $course['href_return'] }}"><button type="button" class="btn btn-secondary btn-sm mx-1">場次報表</button></a>
                      @endif
                      <button id="{{ $course['course_id'] }}" class="btn btn-danger btn-sm mx-1" onclick="btn_delete({{ $course['course_id'] }});" value="{{ $course['course_id'] }}" >刪除</button>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- Rocky(2020/01/11) -->
        @if (session('status') == "匯入成功")
        <div class="alert alert-success alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">
          {{ session('status') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @elseif (session('status') == "匯入失敗" || session('status') == "請選檔案/填講師姓名")  
        <div class="alert alert-danger alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">
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
  $("document").ready(function(){
    // Rocky(2020/01/06)
    $("#import_flie").change(function(){
      var i = $(this).prev('label').clone();
      var file = $('#import_flie')[0].files[0].name;
      $(this).prev('label').text(file);
    }); 
  });

  // Sandy(2020/01/31) 列表搜尋start
  $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

  $("#btn_search").click(function(e){
      var search_date = $("#search_date").val();
      var search_name = $("#search_name").val();
      $.ajax({
          type : 'GET',
          url:'course_search', 
          dataType: 'json',    
          data:{
            // '_token':"{{ csrf_token() }}",
            search_date: search_date,
            search_name: search_name
          },
          success:function(data){
            console.log(data);
            var res = '';
            $.each (data, function (key, value) {
              res +=
              '<tr>'+
                  '<td>' + value.date + '</td>'+
                  '<td>' + value.name + '</td>'+
                  '<td>' + value.event + '</td>'+
                  '<td>' + value.count_apply + ' / <span style="color:red">'+ value.count_cancel +'</span></td>'+
                  '<td>' + value.count_check + '</td>'+
                  '<td>' + 
                    '<a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">開始報名</button></a>'+
                    '<a href="' + value.href_list + '"><button type="button" class="btn btn-secondary btn-sm mx-1">查詢名單</button></a>'+
                    '<a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">查看進階填單名單</button></a>'+
                    '<a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1" disabled="ture">場次報表</button></a>'+
                    '<input type="hidden" name="_charset_">'+
                    '<button id="' + value.id + '" class="btn btn-danger btn-sm mx-1" onclick="btn_delete(' + value.id + ');" value="' + value.id + '" >刪除</button>'+
              '</tr>';
            });

            $('#table_list').html(res);
          },
          error: function(jqXHR){
             console.log('error: ' + JSON.stringify(jqXHR));
            // $("main").append('<div class="alert alert-danger alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">報名狀態修改失敗<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          }
      });
  });
  // Sandy(2020/01/31) 列表搜尋end

  // 刪除 Rocky(2020/02/11)
  function btn_delete(id_course){
    var msg = "是否刪除此課程?";
    if (confirm(msg)==true){
      $.ajax({
          type : 'POST',
          url:'course_delete', 
          dataType: 'json',    
          data:{
            id_course: id_course
          },
          success:function(data){
            if (data['data'] == "ok") {                           
              // alert('刪除成功！！')
              /** alert **/
              $("#success_alert_text").html("刪除課程成功");
              fade($("#success_alert"));

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