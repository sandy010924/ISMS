@extends('frontend.layouts.master')

@section('title', '課程總覽')
@section('header', '編輯')

@section('content')
<!-- Content Start -->
<!--課程總覽編輯頁面內容-->
  <div class="card m-3">
    <input type="hidden" id="id_course" value="{{ $course->id }}">
    <div class="card-body">
      <div class="row">
        <div class="col-3">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">講師名稱</span>
            </div>
            <input type="text" class="form-control bg-white" aria-label="Teacher name" id="teacher" value="{{ $course->teacher }}">
          </div>
        </div>
        <div class="col-5">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">課程名稱</span>
            </div>
            <input type="text" class="form-control bg-white" aria-label="Course name" id="course" value="{{ $course->name }}">
          </div>
        </div>
        <div class="col align-middle align-self-end">
          @if( $course->id_type != "" && ( $course->type == 2 || $course->type == 3 ) ) 
          <a role="button" href="{{ route('course_form',['source_course'=>$course->id_type, 'source_events'=>0]) }}" target="_blank" class="btn btn-outline-secondary btn_date mr-3">    
              預覽報名表
            </a>
          @endif
          @if( $course->id_type == "" && ( $course->type == 2 || $course->type == 3 ) )
            <button type="button" class="btn btn-outline-secondary btn_date mr-3" data-toggle="modal" data-target="#newform">    
              新增報名表
            </button>
          @elseif( $course->id_type != "" && ( $course->type == 2 || $course->type == 3 ) )
            <button type="button" class="btn btn-outline-secondary btn_date mr-3" data-toggle="modal" data-target="#newform">    
              修改報名表
            </button>
          @endif
          <div class="modal fade" id="newform" tabindex="-1" role="dialog" aria-labelledby="newformLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="form" action="{{ url('course_list_edit_insert') }}" method="POST">
                  @csrf
                  <input type="hidden" id="course_id" name="course_id" value="{{ $course->id }}">
                  <div class="modal-header">
                    <h5 class="modal-title">
                      @if( $course->id_type == "" )
                        新增報名表
                      @else
                        修改報名表
                      @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group required">
                      <label for="newform_course" class="col-form-label">對應課程</label>
                      <select class="custom-select" id="newform_course" name="newform_course" required>
                        @foreach($course_all as $data)
                          @if($course->id_type == $data->id)
                            <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                          @else
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group required">
                      <label for="newform_services" class="col-form-label">課程服務內容</label>
                      <textarea rows="4" cols="50" class="form-control" id="newform_services" name="newform_services" required>{{ $course->courseservices }}</textarea>
                    </div>
                    <div class="form-group required">
                      <label for="newform_price" class="col-form-label">課程一般定價</label>
                      <input type="number" id="newform_price" name="newform_price" class="form-control" value="{{ $course->money }}" required>
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
      </div>
    </div>
  </div>
  <div class="card m-3">
    <div class="card-body">
      @component('components.datatable')
        @slot('thead')
          <tr>
            <th>日期</th>
            <th>場次</th>
            <th>時間</th>
            <th>地點</th>
            <th></th>
          </tr>
        @endslot
        @slot('tbody')
          @foreach($events as $data)
            <tr>
              <td>{{ $data['date'] }}</td>
              <td>{{ $data['event'] }}</td>
              <td>{{ $data['time'] }}</td>
              <td>{{ $data['location'] }}</td>
              <td>
                @if( $data['unpublish'] == 0)
                  <a role="button" class="btn btn-dark btn-sm mx-1 text-white" onclick="btn_update( {{ $data['id_group'] }}, 1 );">取消場次</a>
                @else
                  <a role="button" class="btn btn-success btn-sm mx-1 text-white" onclick="btn_update( {{ $data['id_group'] }}, 0 );">上架場次</a>
                @endif
                <a role="button" class="btn btn-secondary btn-sm text-white mr-1 edit_data" data-id="{{ $data['id_group'] }}" data-toggle="modal" data-target="#edit_form">編輯</a>
                <a role="button" class="btn btn-danger btn-sm text-white mx-1" onclick="btn_delete({{ $data['id_group'] }});">刪除</a>
              </td>
            </tr>
          @endforeach
        @endslot
      @endcomponent
    </div>
  </div>
<!-- Content End -->

<!-- 編輯場次 -->
<div class="modal fade" id="edit_form" tabindex="-1" role="dialog" aria-labelledby="edit_formLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="form" action="{{ url('course_list_edit_editdata') }}" method="POST">
        @csrf
        <input type="hidden" name="edit_idgroup" id="edit_idgroup" value="">
        <input type="hidden" name="edit_idcourse" id="edit_idcourse" value="">
        <div class="modal-header">
          <h5 class="modal-title">編輯場次</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="edit_date" class="col-form-label">課程日期</label>
            <br />
            <p id="edit_date" name="edit_date"></p>
            {{-- <div class="input-group date" id="edit_date" data-target-input="nearest">
              <input type="text" name="edit_date" class="form-control datetimepicker-input" data-target="#edit_date" required />
              <div class="input-group-append" data-target="#edit_date" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div> --}}
          </div>
          <div class="form-group required">
            <label for="edit_event" class="col-form-label">場次</label><br />
            <input type="search" list="events" id="edit_event" name="edit_event" class="form-control" required />
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
          <div class="form-row">
            <div class="col-md-6 mb-3 required">
              <label for="edit_starttime" class="col-form-label">課程開始時間</label><br />
              <div class="input-group date" id="edit_starttime" data-target-input="nearest">
                <input type="text" name="edit_starttime" class="form-control datetimepicker-input" data-target="#edit_starttime" required />
                <div class="input-group-append" data-target="#edit_starttime" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-clock"></i></div>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-3 required">
              <label for="edit_endtime" class="col-form-label">課程結束時間</label><br />
              <div class="input-group date" id="edit_endtime" data-target-input="nearest">
                <input type="text" name="edit_endtime" class="form-control datetimepicker-input" data-target="#edit_endtime" required />
                <div class="input-group-append" data-target="#edit_endtime" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-clock"></i></div>
                </div>
              </div>
            </div>
          </div> 
          <div class="form-group required">
            <label for="edit_location" class="col-form-label">地點</label>
            <input type="text" id="edit_location" name="edit_location" class="form-control" required />
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
<style>
  .bootstrap-datetimepicker-widget.dropdown-menu {
    width: fit-content !important;
  }
</style>
<script>
    // Sandy(2020/03/08) dt列表 S
    var table;
    //日期&時間選擇器 Sandy (2020/06/28)
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

    $("document").ready(function(){
      table = $('#table_list').DataTable({
          "dom": '<l<t>p>',
          // "ordering": false,
      });

    //select2 對應課程 Sandy(2020/03/08)
    $("#newform_course").select2({
        width: 'resolve', // need to override the changed default
        theme: 'bootstrap'
    });

    //時間選擇器
    $('#edit_starttime').datetimepicker({
      format: 'HH:mm',
      icons: iconlist
    });
    $('#edit_endtime').datetimepicker({
      format: 'HH:mm',
      icons: iconlist
    });

  });
  
  $.fn.select2.defaults.set( "theme", "bootstrap" );
  // Sandy(2020/02/26) dt列表 S

  // 取消場次 Sandy(2020/03/21) start
  function btn_update(id_group, action){
    var msg;
    if(action == 0){
      msg = "是否上架此場次?";
    }else{
      msg = "是否取消此場次?";
    }

    if (confirm(msg)==true){
      $.ajax({
          type : 'POST',
          url:'course_list_edit_update', 
          dataType: 'json',    
          data:{
            id_group: id_group,
            action: action
          },
          success:function(data){
            console.log(data);
            if (data['data'] == "publish_ok") {                           
              alert('上架場次成功！！')
              location.reload();
              /** alert **/
              // $("#success_alert_text").html("取消場次成功");
              // fade($("#success_alert"));
            }else if (data['data'] == "unpublish_ok") {                           
              alert('取消場次成功！！')
              location.reload();
              /** alert **/
              // $("#success_alert_text").html("取消場次成功");
              // fade($("#success_alert"));
            }else{
              // alert('取消失敗！！')

              /** alert **/ 
              $("#error_alert_text").html("取消場次失敗");
              fade($("#error_alert"));       
            }           
          },
          error: function(error){
            console.log(JSON.stringify(error));   

            /** alert **/ 
            $("#error_alert_text").html("取消場次失敗");
            fade($("#error_alert"));       
          }
      });
    }else{
      return false;
    }    
  }
  // 取消場次 Sandy(2020/03/21) end

  /* 資料自動儲存 start */
  // 講師
  $('#teacher').on('blur', function() {
    var data_type = 'teacher';
    save_data($(this), data_type);
  });
  $('#teacher').on('keyup', function(e) {
    if (e.keyCode === 13) {
      var data_type = 'teacher';
      save_data($(this), data_type);
    }
  });

  // 課程
  $('#course').on('blur', function() {
    var data_type = 'course';
    save_data($(this), data_type);
  });
  $('#course').on('keyup', function(e) {
    if (e.keyCode === 13) {
      var data_type = 'course';
      save_data($(this), data_type);
    }
  });

  function save_data(data, data_type){
    var id_course = $("#id_course").val();
    var data_val = data.val();
    $.ajax({
      type:'POST',
      url:'course_list_edit_updatedata',
      data:{
        id_course: id_course,
        data_type: data_type, 
        data_val: data_val,
      },
      success:function(data){
        // console.log(JSON.stringify(data));

        if( data == "success" ){
          /** alert **/
          $("#success_alert_text").html("資料儲存成功");
          fade($("#success_alert"));
        }else{
          /** alert **/ 
          $("#error_alert_text").html("資料儲存失敗");
          fade($("#error_alert"));    
        }

      },
      error: function(jqXHR){
        console.log(JSON.stringify(jqXHR));  

        /** alert **/ 
        $("#error_alert_text").html("資料儲存失敗");
        fade($("#error_alert"));      
      }
    });
  }
  /* 資料自動儲存 end */

  // 刪除 Sandy(2020/05/31) start
  function btn_delete(id_group) {
    //判斷是否有群組場次
    var msg = "是否刪除該場次?";

    if (confirm(msg) == true) {
      $.ajax({
        type: 'POST',
        url: 'course_list_edit_delete',
        dataType: 'json',
        data: {
          // id_events: id_events,
          id_group: id_group
        },
        success: function(data) {
          if (data['data'] == "ok") {
            alert('刪除成功！！')
            /** alert **/
            // $("#success_alert_text").html("刪除課程成功");
            // fade($("#success_alert"));

            location.reload();
          } else {
            // alert('刪除失敗！！')

            /** alert **/
            $("#error_alert_text").html("刪除場次失敗");
            fade($("#error_alert"));
          }
        },
        error: function(error) {
          console.log(JSON.stringify(error));

          /** alert **/
          $("#error_alert_text").html("刪除場次失敗");
          fade($("#error_alert"));
        }
      });
    } else {
      return false;
    }
  }
  // 刪除 Sandy(2020/05/31) end


  /* 編輯資料 S Sandy(2020/06/28) */
  // //日期隨群組日期數變動
  // function edit_date(len){
  //   $('#edit_date').datetimepicker({
  //     format: 'YYYY-MM-DD',
  //     icons: iconlist,
  //     allowMultidate: true,
  //     multidateSeparator: ','
  //   });

  //   $('#edit_date').on('change.datetimepicker', function (e) {
  //     if (e.date != false && $(this).datetimepicker('date').split(',').length > len) {
  //         $(this).find('td.day.active:contains(' + moment(e.date).format("D") + ')').trigger('click');
  //     }
  //   });
  // }

  //編輯資料
  $('.edit_data').on('click', function (e) {
    var id = $(this).data('id');
    $.ajax({
      type:'GET',
      url:'course_list_edit_fill',
      data:{
        id:id
      },
      success:function(data){
        console.log(data);  
        // //日期隨群組日期數變動
        // edit_date(data['count']);
        
        if( data != "nodata" ){    
          $("#edit_idcourse").val($('#id_course').val());  //群組ID
          $("#edit_idgroup").val(id);  //群組ID
          $("#edit_event").val(data['data']['name']);  //場次
          $('#edit_date').text(data['events_group']);  //日期
          $('#edit_starttime').datetimepicker('date',data['start'] );  //開始時間
          $('#edit_endtime').datetimepicker('date', data['end'] );  //結束時間
          $("#edit_location").val(data['data']['location']);   //地點
        }


      },
      error: function(jqXHR, textStatus, errorMessage){
          console.log(jqXHR);    
      }
    });
  });
  /* 編輯資料 E Sandy(2020/06/28) */


  </script>
@endsection