@extends('frontend.layouts.master')

@section('title', '訊息推播')
@section('header', '訊息推播')
@section('content')
<!-- Content Start -->
  <!--搜尋課程頁面內容-->
  <div class="card m-3">
    <div class="card-body">
      {{-- <div class="container"> --}}
      <div class="row mb-5">
        <div class="col-5">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">日期區間</span>
            </div>
            <input type="search" class="form-control px-3" name="daterange" id="daterange" autocomplete="off"> 
          </div>
        </div>
        <div class="col text-right">
          <a href="{{ route('message') }}" role="button" class="btn btn-primary">建立訊息</a>
        </div>
      </div>
      <nav class="message_nav mb-3">
        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" role="tab" data-toggle="tab" id="nav-schedule-tab" href="#nav-schedule" aria-controls="schedule" aria-selected="true">已預約</a>
          <a class="nav-item nav-link" role="tab" data-toggle="tab" id="nav-draft-tab" href="#nav-draft" aria-controls="draft" aria-selected="false">草稿</a>
          <a class="nav-item nav-link" role="tab" data-toggle="tab" id="nav-sent-tab" href="#nav-sent" aria-controls="sent" aria-selected="false">已傳送</a>
        </div>
      </nav>
      <div class="tab-content">
        <div class="tab-pane show active" id="nav-schedule" role="tabpanel" aria-labelledby="nav-schedule-tab">
          <!-- 已預約 -->
          <div class="table-responsive">
            <table id="schedule" class="table table-striped table-sm text-center border rounded-lg datatable">
              <thead>
                <tr>
                  <th class="d-none"></th>
                  <th>訊息名稱</th>
                  <th>內容</th>
                  <th>媒介</th>
                  <th>預計傳送人數</th>
                  <th>預約時間</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($scheduleMsg as $data )
                <tr>
                  <td class="d-none">{{ $data['send_at'] }}</td>
                  <td>{{ $data['name'] }}</td>
                  <td class="ellipsis">{{ $data['content'] }}</td>
                  <td>{{ $data['type'] }}</td>
                  <td>{{ $data['count'] }}</td>
                  <td>{{ $data['send_at'] }}</td>
                  <td>
                    @if( date('Y-m-d', strtotime($data['send_at'])) <= date('Y-m-d', strtotime('now')) )
                      <a role="button" class="btn btn-danger btn-sm mx-1 text-white disable" onclick="alert('當日預約訊息無法取消');">取消預約</a>
                    @else
                      <a role="button" class="btn btn-danger btn-sm mx-1 text-white" onclick="btn_cancel({{ $data['id'] }});">取消預約</a>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane" id="nav-draft" role="tabpanel" aria-labelledby="nav-draft-tab">
          <!-- 草稿 -->
          <div class="table-responsive">
            <table id="draft" class="table table-striped table-sm text-center border rounded-lg datatable">
              <thead>
                <tr>
                  <th class="d-none"></th>
                  <th>訊息名稱</th>
                  <th>內容</th>
                  <th>媒介</th>
                  <th>預計傳送人數</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($draftMsg as $data )
                <tr>
                  <td class="d-none">{{ $data['updated_at'] }}</td>
                  <td>{{ $data['name'] }}</td>
                  <td class="ellipsis">{{ $data['content'] }}</td>
                  <td>{{ $data['type'] }}</td>
                  <td>{{ $data['count'] }}</td>
                  <td>
                    <a role="button" class="btn btn-secondary btn-sm mx-1 text-white" href="{{ route('message',['id'=> $data['id']]) }}">編輯</a>
                    <a role="button" class="btn btn-danger btn-sm mx-1 text-white" onclick="btn_delete({{ $data['id'] }});">刪除</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane" id="nav-sent" role="tabpanel" aria-labelledby="nav-sent-tab">
          <!-- 已傳送 -->
          <div class="table-responsive">
            <table id="sent" class="table table-striped table-sm text-center border rounded-lg datatable">
              <thead>
                <tr>
                  <th class="d-none"></th>
                  <th>訊息名稱</th>
                  <th>內容</th>
                  <th>媒介</th>
                  <th>傳送人數</th>
                  <th>傳送時間</th>
                </tr>
              </thead>
              <tbody>
                @foreach($sentMsg as $data )
                <tr href="{{ route('message_data', ['id' => $data['id']]) }}" style="cursor: pointer;">
                  <td class="d-none">{{ $data['send_at'] }}</td>
                  <td>{{ $data['name'] }}</td>
                  <td class="ellipsis">{{ $data['content'] }}</td>
                  <td>{{ $data['type'] }}</td>
                  <td>{{ $data['count'] }}</td>
                  <td>{{ $data['send_at'] }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 排成設定Modal -->
  <div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">排程傳送</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h4>選擇日期和時間</h4>

          <div class="form-group">
            <div class='input-group date' id='datetimepicker1' data-target-input='nearest'>
              <input type='text' id="scheduleTime" class="form-control datetimepicker-input" data-target="#datetimepicker1" name="params['start_time']" />
              <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" id="saveScheduleBtn" class="btn btn-secondary" data-dismiss="modal">確定排程</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
      </div>
    </div>
  </div>

<!-- Content End -->

{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> --}}

<style>
  .fade_row {
    display: none;
  }
  .show_row {
    display: table-row;
  }
  /* datatable內容欄位的... */
  .ellipsis {
    max-width: 100px;
    overflow:hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }

  .dataTables_paginate {
    text-align: center !important;
    margin-top: 1rem !important;
  }
  .dataTables_paginate ul{
    justify-content: center !important;
  }
</style>

<script>
  var table;

  $("document").ready(function() {

    //草稿datatable
    $('#draft').DataTable({
        "dom": '<l<t>p>',
        "autoWidth": false,
        "order": [[ 0, 'desc' ]]
    });
    //預約、已傳送datatable
    table = $('#schedule, #sent').DataTable({
        "dom": '<l<t>p>',
        "autoWidth": false,
        "order": [[ 0, 'desc' ]]
    });

    /* 日期區間 */
    if ('<?php echo $start ?>' == '' && '<?php echo $end ?>' == '') {
      //沒有資料則關閉區間搜尋
      $('#daterange').prop('disabled', true);;
    } else {
      //有資料設定日期區間
      $('input[name="daterange"]').daterangepicker({
        startDate: '<?php echo $start ?>',
        endDate: '<?php echo $end ?>',
        locale: {
          format: 'YYYY-MM-DD',
          separator: ' ~ ',
          applyLabel: '搜尋',
          cancelLabel: '取消',
        }
      });
    }

    /* 日期區間搜尋 */
    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
      $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {

          var min = picker.startDate.format('YYYY-MM-DD 00:00:00');
          var max = picker.endDate.format('YYYY-MM-DD 24:00:00');

          var startDate = data[5];
          
          if (startDate <= max && startDate >= min) {
            return true;
          }
          return false;
        });

      table.draw();
    });

    /* 取消日期區間搜尋 */
    $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
      //重設定日期區間(回到預設)
      $('#daterange').data('daterangepicker').setStartDate('<?php echo $start ?>');
      $('#daterange').data('daterangepicker').setEndDate('<?php echo $end ?>');
      
      
      //取消搜尋
      $.fn.dataTable.ext.search.pop();
      table.draw();
    });


    // $('.nav-item').on('click', function() {
    //   var target = $(this).attr('data-target');
    //   $('.show_row').removeClass('show_row')
    //   $(`.${target}`).addClass('show_row');
    // });

    // fakeData.forEach((data, idx) => {
    //   // $('#nav-tab a').eq(idx).text(data.name);

    //   var dataLen = fakeData[idx].data.length;


    //   var tdData = ``;

    //   for (let index = 0; index < dataLen; index++) {
    //     tdData += `<tr ${ idx != 0 ? `class='fade_row ${ fakeData[idx].name }'` : `class='fade_row show_row ${ fakeData[idx].name }'` }>
    //     <td>${ fakeData[idx].data[index].sendTime }</td>
    //     <td>${ fakeData[idx].data[index].msgTitle }</td>
    //     <td>${ fakeData[idx].data[index].contents }</td>
    //     <td>${ fakeData[idx].data[index].sendType }</td>
    //     <td>${ fakeData[idx].data[index].sendPeople }</td>
    //     <td>${ fakeData[idx].data[index].msgFee }</td>
    //     <td>${ fakeData[idx].data[index].registerTotal }</td>
    //     <td>${ fakeData[idx].data[index].registrationCost }</td>
    //     <td>${ fakeData[idx].data[index].registerRate }</td>
    //     </tr>`;
    //   }


    //    $('tbody').append(tdData);

    // });

    // $('[name="col_time"]').show();
    // $('[name="col_btn"]').show();
    // $('a[name="btn_edit"]').hide();
    // $('#th_time').html('預約時間');
    // $('#th_count').html('預約傳送人數');
  // })

  // //已預約分頁
  // $('#schedule').on('click', function() {
  //   table
  //     .columns( 6 )
  //     .search( 21 )
  //     .draw();

  //   $('[name="col_time"]').show();
  //   $('[name="col_btn"]').show();
  //   $('a[name="btn_edit"]').hide();
  //   $('#th_time').html('預約時間');
  //   $('#th_count').html('預約傳送人數');
  // });
  
  // //草稿分頁
  // $('#draft').on('click', function() {
  //   table
  //     .columns( 6 )
  //     .search( 18 )
  //     .draw();

  //   $('[name="col_time"]').hide();
  //   $('[name="col_btn"]').show();
  //   $('a[name="btn_edit"]').show();
  //   $('#th_count').html('預約傳送人數');
  // });
  
  // //已傳送分頁
  // $('#sent').on('click', function() {
  //   table
  //     .columns( 6 )
  //     .search( 19 )
  //     .draw();

  //   $('[name="col_time"]').show();
  //   $('[name="col_btn"]').hide();
  //   $('a[name="btn_edit"]').show();
  //   $('#th_time').html('傳送時間');
  //   $('#th_count').html('傳送人數');

    $('body').on('click','#nav-sent tbody tr',function(){
        window.location = $(this).attr('href');
        // return false;
    });
  });


  /* 取消預約 Sandy(2020/04/29) */
  function btn_cancel(id_message){
    var msg = "是否取消此預約訊息?";

    if (confirm(msg)==true){
      $.ajax({
          type : 'POST',
          url:'message_list_cancel', 
          data:{
            id_message: id_message,
          },
          success:function(res){
            // console.log(res);

            switch (res['status']) {
              case 'success':
                  alert('取消預約成功！');
                  location.reload();
                  // /** alert **/
                  // $("#success_alert_text").html("刪除課程成功");
                  // fade($("#success_alert"));
                break;
              case 'warn':
                  // alert('取消預約成功！');

                  /** alert **/
                  $("#warn_alert_text").html("取消預約成功！ 5秒後重整頁面" + "<br><br>" + res['msg']);
                  $("#warn_alert").show();

                  $('a').prop('disabled', 'disabled');
                  setTimeout( function(){location.href="{{URL::to('message_list')}}"}, 5000);
                break;            
              default:
                /** alert **/ 
                $("#error_alert_text").html("取消預約失敗，" + res['msg']);
                fade($("#error_alert"));      
                break;
            }
          },
          error: function(res){
            console.log(JSON.stringify(res));   

            /** alert **/ 
            $("#error_alert_text").html("取消預約失敗");
            fade($("#error_alert"));       
          }
      });
    }else{
      return false;
    }    
  }


  /* 刪除 Sandy(2020/04/21) */
  function btn_delete(id_message){
    var msg = "是否刪除此訊息?";

    if (confirm(msg)==true){
      $.ajax({
          type : 'POST',
          url:'message_list_delete', 
          // dataType: 'json',    
          data:{
            id_message: id_message,
          },
          success:function(res){
            if ( res == 'success' ) {                           
              alert('刪除草稿成功！')
              /** alert **/
              // $("#success_alert_text").html("刪除課程成功");
              // fade($("#success_alert"));

              location.reload();
            }　else {
              // alert('刪除失敗！！')

              /** alert **/ 
              $("#error_alert_text").html("刪除草稿失敗");
              fade($("#error_alert"));       
            }           
          },
          error: function(res){
            console.log(JSON.stringify(res));   

            /** alert **/ 
            $("#error_alert_text").html("刪除草稿失敗");
            fade($("#error_alert"));       
          }
      });
    }else{
      return false;
    }    
  }
</script>


@endsection