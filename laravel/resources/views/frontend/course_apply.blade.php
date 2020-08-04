@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '查詢名單')

@section('content')

<!-- Content Start -->
  <!--查看報名內容-->
  <input type="hidden" id="id_events" value="{{ $course->id }}">
  <input type="hidden" id="course_type" value="{{ $course->type }}">
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
            <input type="text" class="form-control bg-white" aria-label="Course name" id="course_name" value="{{ $course->course }}" disabled readonly>
          </div>
        </div>
        <hr/>
      </div>
    </div>
  </div>
  <div class="card m-3">
      <div class="card-body">
          <div class="row mb-3 align-self-center">
              <div class="col-3 align-self-center">
                  <h6 class="mb-0">
                    <label id="course_date">{{ date('Y-m-d', strtotime($course->course_start_at)) }}</label>
                    ( {{ $week }} )&nbsp;
                    <label id="course_event">{{ $course->name }}</label>&nbsp;&nbsp;
                    {{-- 報名筆數 : {{ $count_apply }}&nbsp;&nbsp;
                    取消筆數 : {{ $count_cancel }} --}}
                  </h6>
              </div>
              <div class="col align-self-center">
                <h6 class="mb-0">報名筆數 : 
                  <span id="count_apply">{{ $count_apply }}</span>
                </h6>
              </div>
              @if( strtotime(date('Y-m-d', strtotime($course->course_start_at))) <= strtotime(date("Y-m-d")) )
                  <!-- 已過場次 -->
                  <div class="col align-self-center">
                    <h6 class="mb-0">報到筆數 : 
                      <span id="count_check">{{ $count_check }}</span>
                    </h6>
                  </div>
              @endif
              <div class="col align-self-center">
                <h6 class="mb-0">取消筆數 : 
                  <span id="count_cancel">{{ $count_cancel }}</span>
                </h6>
              </div>
              {{-- <div class="col-2">
              </div> --}}
              <div class="col-4">
                <div class="input-group">
                    <input type="search" class="form-control" placeholder="關鍵字" id="search_keyword">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
                    </div>
                </div>
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

                <th>姓名</th>
                <th>聯絡電話</th>
                <th>電子郵件</th>
                <th>目前職業</th>

                <!-- 如果是銷講多加我想在講座中了解的內容 -->
                @if( $course->type == 1 )
                  <th>我想在講座中了解的內容</th>
                @endif

                @if( strtotime(date('Y-m-d', strtotime($course->course_start_at))) > strtotime(date("Y-m-d")) )
                <!-- 未過場次 -->
                <th></th>
                @elseif( strtotime(date('Y-m-d', strtotime($course->course_start_at))) <= strtotime(date("Y-m-d")) )
                <!-- 已過場次 -->
                <th>報到</th>
                <th>付款狀態</th>
                @endif
              </tr>
            @endslot
            @slot('tbody')
              @foreach($courseapplys as $courseapply)
                <tr>
                  @if( $course->type == 1 )
                    <td>{{ $courseapply['submissiondate'] }}</td>
                    <td>{{ $courseapply['datasource'] }}</td >
                  @else
                    <td>{{ $courseapply['submissiondate'] }}</td>
                  @endif

                  <td>{{ $courseapply['name'] }}</td>
                  <td>{{ $courseapply['phone'] }}</td>
                  <td>{{ $courseapply['email'] }}</td>
                  <td>{{ $courseapply['profession'] }}</td>
                  
                  <!-- 如果是銷講多加我想在講座中了解的內容 -->
                  @if( $course->type == 1 )
                    <td>{{ ($courseapply['course_content']  == 'null')? '':$courseapply['course_content'] }}</td>
                  @endif
                  
                  @if( strtotime(date('Y-m-d', strtotime($course->course_start_at))) > strtotime(date("Y-m-d")) )
                  <!-- 未過場次 -->
                  <td>
                    <button type="button" name="apply_btn" class="btn btn-sm text-white update_status" id="{{ $courseapply['id'] }}" value="{{ $courseapply['id_status'] }}">{{ $courseapply['status_name'] }}</button>
                  </td>
                  @elseif( strtotime(date('Y-m-d', strtotime($course->course_start_at))) <= strtotime(date("Y-m-d")) )
                  <!-- 已過場次 -->
                  <td>{{ $courseapply['status_name'] }}</td>
                  <td></td>
                  @endif
                </tr>
              @endforeach
            @endslot
          @endcomponent
        </div>
      </div>
  <!-- Content End -->
  <style>
    div.dt-buttons {
      float: right;
    }
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script>
    // Sandy(2020/02/26) dt列表搜尋 S
    var table;
    var today = moment(new Date()).format("YYYYMMDD");
    var title = today + '_查詢名單' + '_' + $('#course_name').val() + '(' + $('#course_date').text() + ' ' + $('#course_event').text() + ')';

    $("document").ready(function(){
      table_onload();
      status_onload();

      //排序按鈕觸發報到狀態樣式
      $('#table_list').on( 'order.dt',  function () { 
        status_onload();
      });
      
      // Restore state
      var state = table.state.loaded();
      if ( state ) {
        $( '#search_keyword' ).val( state.search.search );
      }
    });

    
    //datatable onload
    function table_onload(){
      // Sandy (2020/02/26)
      table = $('#table_list').DataTable({
          "dom": '<Bl<t>p>',
          // "ordering": false,
          "bStateSave": true,
          "fnStateSave": function (oSettings, oData) {
              localStorage.setItem('offersDataTables', JSON.stringify(oData));
          },
          "fnStateLoad": function (oSettings) {
              return JSON.parse(localStorage.getItem('offersDataTables'));
          },
          drawCallback: function(){
            //換頁或切換每頁筆數按鈕觸發報到狀態樣式
            $('.paginate_button, .dataTables_length', this.api().table().container()).on('click', function(){
                status_onload();
            });       
          },
          buttons: [{
            extend: 'excel',
            text: '匯出Excel',
            // exportOptions: {
            //   columns: '.colExcel'
            // },
            title: title,
          }]
      });
    }


    // 輸入框 Sandy(2020/02/25)
    $("#btn_search").click(function(){
      table.search($('#search_keyword').val()).draw();
    });

    $('#search_keyword').on('keyup', function(e) {
      if (e.keyCode === 13) {
          $('#btn_search').click();
      }
    });


    // Sandy(2020/02/26) dt列表搜尋 S

    // 報到狀態修改 Start
    $('body').on('click','.update_status',function(){
        var id_events = $("#id_events").val();
        var course_type = $("#course_type").val();
        var apply_id = $(this).attr('id');
        var apply_status = $(this).val();
        $.ajax({
           type:'POST',
           url:'course_apply',                
           data:{
             id_events:id_events,
             course_type:course_type,
             apply_id:apply_id, 
             apply_status:apply_status
           },
           success:function(data){
              console.log(data); 

              //重整datatable區塊
              $("#datatableDiv").load(window.location.href + " #datatableDiv" , function() {
                status_onload();
                table_onload();
              });

              // $("#"+data["list"].id).val(data["list"].id_status);
              // $("#"+data["list"].id).html(data["list"].status_name);
              
              // $("#count_check").html(data.count_check);
              // $("#count_cancel").html(data.count_cancel);

              // status_style(data["list"].id, data["list"].id_status);
              
              /** alert **/
              $("#success_alert_text").html(data["list"].name + " 報名狀態修改成功");
              fade($("#success_alert"));
              // $("main").append('<div class="alert alert-success alert-dismissible fade show m-3 alert_fadeout" role="alert">'+ data["list"].name +' 報名狀態修改成功<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           },
           error: function(jqXHR){
              console.log("error: "+ JSON.stringify(jqXHR)); 

              /** alert **/ 
              $("#error_alert_text").html("報名狀態修改失敗");
              fade($("#error_alert"));
              // $("main").append('<div class="alert alert-danger alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">報名狀態修改失敗<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           }
        });
    });
    // 報到狀態修改 End

  </script>
@endsection