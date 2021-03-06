@extends('frontend.layouts.master')

@section('title', '訊息推播')
@section('header', '推播成效')

@section('content')
<!-- Content Start -->
  <!--搜尋課程頁面內容-->
  <div class="card m-3">
    <div class="card-body">
      <div class="row mb-5">
        <div class="col-5 mx-auto">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">日期區間</span>
            </div>
            <input type="search" class="form-control px-3" name="daterange" id="daterange" autocomplete="off"> 
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <nav class="message_nav mb-3">
            <ul class="nav nav-pills" id="nav-tab" role="tablist">
            @foreach($teachers as $key => $item )
              @if( $key == 0 )
                <li class="nav-item">
                  <a class="nav-link active" name="teacher_tab" data-id="{{ $item->id }}" data-target="{{ $item->name }}">{{ $item['name'] }}</a>
                </li>
                {{-- <a class="nav-item nav-link active" data-toggle="tab" name="teacher_tab" data-id="{{ $item->id }}" data-target="{{ $item->name }}" role="tab">{{ $item['name'] }}</a> --}}
              @else
                <li class="nav-item">
                  <a class="nav-link" name="teacher_tab" data-id="{{ $item->id }}" data-target="{{ $item->name }}">{{ $item['name'] }}</a>
                </li>
                {{-- <a class="nav-item nav-link" data-toggle="tab" name="teacher_tab" data-id="{{ $item->id }}" data-target="{{ $item->name }}" role="tab">{{ $item['name'] }}</a> --}}
              @endif
            @endforeach
            </ul>
          </nav>
          <hr>
          {{-- <div class="col text-right">
            <a href="#" role="button" class="btn btn-secondary">匯出</a>
          </div> --}}
          @component('components.datatable')
            @slot('thead')
              <tr>
                <th>傳送時間</th>
                <th>訊息名稱</th>
                <th>內容</th>
                <th>媒介</th>
                <th>傳送人數</th>
                <th>簡訊費用</th>
                <th>報名人數</th>
                <th>報名成本</th>
                <th>報名率</th>
                <th class="d-none search_teacher"></th>
              </tr>
            @endslot
            @slot('tbody')
              @foreach($msg as $key => $data )
              <tr href="{{ route('message_data', ['id' => $data['id']]) }}">
                <td>{{ $data['send_at'] }}</td>
                <td>{{ $data['name'] }}</td>
                <td class="ellipsis">{{ $data['content'] }}</td>
                <td>{{ $data['type'] }}</td>
                <td>{{ $data['count_receiver'] }}</td>
                <td>{{ $data['cost_sms'] }}</td>
                <td>{{ $data['count_apply'] }}</td>
                <td>{{ $data['cost_apply'] }}</td>
                <td>{{ $data['rate_apply'] }}%</td>
                <td class="d-none">{{ $data['id_teacher'] }}</td>
              </tr>
              @endforeach
            @endslot
          @endcomponent
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

  table tr {
      cursor: pointer;
  }
  /* datatable內容欄位的... */
  .ellipsis {
    max-width: 100px;
    overflow:hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }

  /* #nav-tab{
    overflow-x: scroll;
    overflow-y: hidden;
    white-space: nowrap;
  } */
  #nav-tab .nav-item{
    cursor: pointer;
    /* float: left;
    display: inline;   
    zoom: 1; */
  }

  div.dt-buttons {
    float: right;
  }
</style>

<script>
  var table;
  var today = moment(new Date()).format("YYYYMMDD");
  var title = today + '_推播成效_' + $('a[name="teacher_tab"].active').text();

  $("document").ready(function() {

    // $('input[name="daterange"]').daterangepicker({
    //   opens: 'left'
    // }, function(start, end, label) {
    //   console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    // });

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

          var startDate = data[0];
          
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


    //datatable
    table = $('#table_list').DataTable({
        "dom": '<Bl<t>p>',
        // "ordering": false,
        "order": [ 0 , 'desc'],      
        buttons: [{
          extend: 'excel',
          text: '匯出Excel',
          exportOptions: {
              columns: ':visible'
          },
          title: title,
          // messageTop: $('#h3_title').text(),
        }],
    });
    
    //分頁
    table
      .columns( '.search_teacher' )
      .search("(^"+ $('a.active[name="teacher_tab"]').eq( 0 ).data('id') +"$)",true,false)
      .draw();




    // $('.nav-item').on('click', function() {
    //   var target = $(this).attr('data-target');
    //   $('.show_row').removeClass('show_row')
    //   $(`.${target}`).addClass('show_row');
    // });



  })

  $('body').on('click','table tbody tr',function(){
      window.location = $(this).attr('href');
  });

  $('a[name="teacher_tab"]').on('click', function(e) {
    e.preventDefault();

    $('a[name="teacher_tab"]').removeClass('active');
    $(this).addClass('active');

    table
      .columns( '.search_teacher' )
      .search("(^"+ $(this).data('id') +"$)",true,false)
      .draw();
  });
</script>


@endsection