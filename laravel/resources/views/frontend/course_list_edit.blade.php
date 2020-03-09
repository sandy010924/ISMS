@extends('frontend.layouts.master')

@section('title', '課程總覽')
@section('header', '編輯')

@section('content')
<!-- Content Start -->
<!--課程總覽編輯頁面內容-->
<div class="card m-3">
    <div class="card-body">
      <div class="row mb-3">
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
          <a role="button" href="{{ route('course_form',['id'=> $course->id_type]) }}" target="_blank" class="btn btn-outline-secondary btn_date mr-3">    
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
                      <label for="newform_courses" class="col-form-label">對應課程</label><br>
                      <select class="w-100 custom-select" id="newform_courses" name="newform_courses" style="width: 75%;" required>
                        @foreach($courses as $data)
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
                <button role="button" class="btn btn-danger btn-sm mx-1 text-white" onclick="btn_delete( {{ $data['id_group'] }} );">取消場次</a>
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
      $("#courses").select2({
          width: 'resolve' // need to override the changed default
      });
    });
    // Sandy(2020/02/26) dt列表 S

    // 取消場次 Sandy(2020/03/08) start
    function btn_delete(id_group){
      var msg = "是否取消此場次?";
      if (confirm(msg)==true){
        // $.ajax({
        //     type : 'POST',
        //     url:'course_list_edit_delete', 
        //     dataType: 'json',    
        //     data:{
        //       id_group: id_group
        //     },
        //     success:function(data){
        //       console.log(data);
        //       if (data['data'] == "ok") {                           
        //         alert('取消成功！！')
        //         /** alert **/
        //         // $("#success_alert_text").html("取消場次成功");
        //         // fade($("#success_alert"));

        //         location.reload();
        //       }　else {
        //         // alert('取消失敗！！')

        //         /** alert **/ 
        //         $("#error_alert_text").html("取消場次失敗");
        //         fade($("#error_alert"));       
        //       }           
        //     },
        //     error: function(error){
        //       console.log(JSON.stringify(error));   

        //       /** alert **/ 
        //       $("#error_alert_text").html("取消場次失敗");
        //       fade($("#error_alert"));       
        //     }
        // });
      }else{
        return false;
      }    
    }
    // 取消場次 Sandy(2020/03/08) end

  </script>
@endsection