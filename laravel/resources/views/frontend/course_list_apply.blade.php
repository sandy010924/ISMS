@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '報名名單')

@section('content')
<!-- Content Start -->
  <!--查看報名名單-->
  <input type="hidden" id="course_id" value="{{ $course->id }}">
  <input type="hidden" id="course_type" value="{{ $course->type }}">
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
        <div class="col px-5 text-right align-self-center">
          <h6 class="mb-0">累積筆數 : {{ count($apply) }} </h6>
        </div>
      </div>
      @component('components.datatable')
        @slot('thead')
          <tr>
            <th>Submission Date</th>
            <!-- 如果是銷講多加名單來源 -->
            @if( $course->type == 1 )
              <th>名單來源</th>
            @endif
            <th>報名場次</th>
            <th>聯絡電話</th>
            <th>電子郵件</th>
            <th>目前職業</th>
            <!-- 如果是銷講多加我想在講座中了解的內容 -->
            @if( $course->type == 1 )
              <th>我想在講座中了解的內容</th>
            @endif
            <th></th>
          </tr>
        @endslot
        @slot('tbody')
          @foreach($apply as $data)
            <tr>
              @if( $course->type == 1 )
                <td>{{ $data['date'] }}</td>
                <td>{{ $data['source'] }}</td >
              @else
                <td>{{ $data['date'] }}</td>
              @endif

              <td>{{ $data['event'] }}</td>
              <td>{{ substr_replace($data['phone'], '***', 4, 3) }}</td>
              <td>{{ substr_replace($data['email'], '***', strrpos($data['email'], '@')) }}</td>
              <td>{{ $data['profession'] }}</td>

              <!-- 如果是銷講多加我想在講座中了解的內容 -->
              @if( $course->type == 1 )
                <td>{{ ($data['content']  == 'null')? '':$data['content'] }}</td>
              @endif
              <td><button id="{{ $data['id'] }}" class="btn btn-danger btn-sm mx-1" onclick="btn_delete({{ $data['id'] }});">刪除</button></td>
            </tr>
          @endforeach
        @endslot
      @endcomponent
      </div>
    </div>
  <!-- Content End -->
  <script>
  
    // 刪除 Sandy(2020/03/08)
    function btn_delete(id_apply){
      var type = $("#course_type").val();
      var msg = "是否刪除此筆報名資料?";
      if (confirm(msg)==true){
        // $.ajax({
        //     type : 'POST',
        //     url:'course_list_apply_delete', 
        //     dataType: 'json',    
        //     data:{
        //       type: type,
        //       id_apply: id_apply
        //     },
        //     success:function(data){
        //       if (data['data'] == "ok") {                           
        //         alert('刪除成功！！')
        //         /** alert **/
        //         // $("#success_alert_text").html("刪除課程成功");
        //         // fade($("#success_alert"));

        //         location.reload();
        //       }　else {
        //         // alert('刪除失敗！！')

        //         /** alert **/ 
        //         $("#error_alert_text").html("刪除資料失敗");
        //         fade($("#error_alert"));       
        //       }           
        //     },
        //     error: function(error){
        //       console.log(JSON.stringify(error));   

        //       /** alert **/ 
        //       $("#error_alert_text").html("刪除資料失敗");
        //       fade($("#error_alert"));       
        //     }
        // });
      }else{
        return false;
      }    
    }
  </script>
@endsection