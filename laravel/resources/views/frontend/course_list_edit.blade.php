@extends('frontend.layouts.master')

@section('title', '課程總覽')
@section('header', '編輯')

@section('content')
<!-- Content Start -->
<!--課程總覽編輯頁面內容-->
  <div class="card m-3">
    <div class="card-body">
      <div class="row">
        <div class="col-3">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">講師名稱</span>
            </div>
            <input type="text" class="form-control bg-white" aria-label="Teacher name" value="{{ $course->teacher }}" disabled readonly>
          </div>
        </div>
        <div class="col-5">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">課程名稱</span>
            </div>
            <input type="text" class="form-control bg-white" aria-label="Course name" value="{{ $course->name }}" disabled readonly>
          </div>
        </div>
        <div class="col align-middle align-self-end">
          @if( $course->id_type != "") 
          <a role="button" href="{{ route('course_form',['source_course'=>$course->id_type, 'source_events'=>0]) }}" target="_blank" class="btn btn-outline-secondary btn_date mr-3">    
              預覽報名表
            </a>
          @endif
          <button type="button" class="btn btn-outline-secondary btn_date mr-3" data-toggle="modal" data-target="#newform">    
            @if( $course->id_type == "")
              新增報名表
            @else
              修改報名表
            @endif
          </button>
          <div class="modal fade" id="newform" tabindex="-1" role="dialog" aria-labelledby="newformLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="form" action="{{ url('course_list_edit_insert') }}" method="POST">
                  @csrf
                  <input type="hidden" id="course_id" name="course_id" value="{{ $course->id }}">
                  <div class="modal-header">
                    <h5 class="modal-title">
                      @if( $course->id_type == "")
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
                  <a role="button" class="btn btn-danger btn-sm mx-1 text-white" onclick="btn_update( {{ $data['id_group'] }}, 1 );">取消場次</a>
                @else
                  <a role="button" class="btn btn-success btn-sm mx-1 text-white" onclick="btn_update( {{ $data['id_group'] }}, 0 );">上架場次</a>
                @endif
              </td>
            </tr>
          @endforeach
        @endslot
      @endcomponent
    </div>
  </div>
<!-- Content End -->

<script>
    // Sandy(2020/03/08) dt列表 S
    var table;
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

  </script>
@endsection