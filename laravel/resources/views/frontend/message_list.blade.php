@extends('frontend.layouts.master')

@section('title', '訊息推播')
@section('header', '訊息推播')
{{-- 
@section('content')
<!-- Content Start -->
       <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">

            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>寄信日期</th>
                    <th>發送方式</th>
                    <th>內容</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="table_list">
                  <tr>
                    <td>2020-02-18 23:49:19</td>
                    <td>簡訊、E-mail</td>
                    <td>
                      想更了解外匯交易.........
                    </td>
                    <td>
                      <a href="{{ route("message_data")}}"><button type="button" class="btn btn-secondary btn-sm mx-1">詳細內容</button></a>
                      <a href="{{ route("message")}}"><button type="button" class="btn btn-secondary btn-sm mx-1">Clone</button></a>
                    </td>
                  </tr>
                  <tr>
                    <td>2020-02-15 20:10:10</td>
                    <td>簡訊</td>
                    <td>
                      黑心直播開始囉!!!......
                    </td>
                    <td>
                      <a href="{{ route("message_data")}}"><button type="button" class="btn btn-secondary btn-sm mx-1">詳細內容</button></a>
                      <a href="{{ route("message")}}"><button type="button" class="btn btn-secondary btn-sm mx-1">Clone</button></a>
                    </td>
                  </tr>
                  <tr>
                    <td>2020-02-10 11:00:34</td>
                    <td>E-mail</td>
                    <td>
                      [找到瘦到停不下來的動力]......
                    </td>
                    <td>
                      <a href="{{ route("message_data")}}"><button type="button" class="btn btn-secondary btn-sm mx-1">詳細內容</button></a>
                      <a href="{{ route("message")}}"><button type="button" class="btn btn-secondary btn-sm mx-1">Clone</button></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

<!-- Content End -->

@endsection --}}


@section('content')
<!-- Content Start -->
       <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            
            <div class="container">
            <div class="row mb-5">
              <div class="col-5">
                <div class="input-group date" data-target-input="nearest">
                  {{-- <div class="input-group-prepend">
                    <span class="input-group-text">日期區間</span>
                  </div> --}}
                  <input type="text" class="form-control px-3" name="daterange" id="daterange"  placeholder="搜尋日期區間"> 
                  <div class="input-group-append" data-target="#daterange" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>  
                </div>
              </div>
              <div class="col text-right">
                <a href="{{ route('message') }}" role="button" class="btn btn-primary">建立訊息</a>
              </div>
            </div>
            {{-- <div class="row mb-3">
            </div> --}}
            {{-- <div class="row mb-2" style="align-items: baseline;">
              <h4 class="mr-2">選擇日期</h4>
              <div class="form-group">
                <div class='input-group date' style="width: 275px;">
                  <input type="text" class="m-1 w-100 form-control p-0" name="daterange"/>
                  <button type="button" class="btn btn-primary ml-2">查詢</button>
                </div>
              </div>
            </div> --}}
              {{-- <div class="row">
                <div class="col-xs-12" style="width: 100%;"> --}}
                  <nav class="message_nav mb-3">
                    {{-- <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist"> --}}
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link active" data-toggle="tab" data-target="booked" role="tab">已預約</a>
                      <a class="nav-item nav-link" data-toggle="tab" data-target="draft" role="tab">草稿</a>
                      <a class="nav-item nav-link" data-toggle="tab" data-target="sent" role="tab">已傳送</a>
                      <a class="nav-item nav-link" data-toggle="tab" data-target="fail" role="tab">無法傳送</a>
                    {{-- @foreach($teachers as $key => $item )
                      @if($loop->index == 0)
                        <a class="nav-item nav-link active" data-toggle="tab" data-target="{{ $item->name }}" role="tab">{{ $item['name'] }}</a>
                      @else
                      <a class="nav-item nav-link" data-toggle="tab" data-target="{{ $item->name }}" role="tab">{{ $item['name'] }}</a>
                      @endif
                    @endforeach --}}
                      <!-- <a class="nav-item nav-link active" data-toggle="tab" data-target="Jack" role="tab"></a>
                      <a class="nav-item nav-link" data-toggle="tab" data-target="Juila" role="tab"></a>
                      <a class="nav-item nav-link" data-toggle="tab" data-target="順昌" role="tab"></a>
                      <a class="nav-item nav-link" data-toggle="tab" data-target="北極熊" role="tab"></a> -->
                    </div>
                  </nav>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                  </div>
                  {{-- @component('components.datatable')
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
                      </tr>
                    @endslot
                    @slot('tbody')
                      @foreach($data as $key => $item )
                      <tr>
                        <td> {{ $item['send_at'] }}</td>
                        <td> {{ $item['title'] }}</td>
                        <td> {{ $item['content'] }}</td>
                        <td> {{ $item['type'] }}</td>
                        <td> 100 </td>
                        <td> 100 </td>
                        <td> 100 </td>
                        <td> 100 </td>
                        <td> 100 </td>
                      </tr>
                      @endforeach
                    @endslot
                  @endcomponent --}}
                {{-- </div>
              </div> --}}
            </div>
          </div>
        </div>

        <!-- 排成設定Modal -->
        <div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">排成傳送</h5>
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

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<style>
  .fade_row {
    display: none;
  }
  .show_row {
    display: table-row;
  }

</style>

<script>
  // var fakeData = [
  //   {
  //     name: 'Jack',
  //     data:[
  //       {
  //         sendTime: '2020/02/05 12:32',
  //         msgTitle: 'Jack黑心台北',
  //         contents: '有危機才有機...',
  //         sendType: 'email',
  //         sendPeople: 1456,
  //         msgFee: 1000,
  //         registerTotal: 250,
  //         registrationCost: 700,
  //         registerRate: '25%'
  //       },
  //       {
  //         sendTime: '2020/02/04 20:54',
  //         msgTitle: 'Jack黑心台北2',
  //         contents: '有危機才有機2...',
  //         sendType: 'email',
  //         sendPeople: 1456,
  //         msgFee: 1000,
  //         registerTotal: 250,
  //         registrationCost: 700,
  //         registerRate: '25%'
  //       }
  //     ]
  //   },
  //   {
  //     name: 'Juila',
  //     data:[
  //       {
  //         sendTime: '2020/02/05 12:32',
  //         msgTitle: 'Juila黑心台北',
  //         contents: '有危機才有機...',
  //         sendType: 'email',
  //         sendPeople: 1456,
  //         msgFee: 1000,
  //         registerTotal: 250,
  //         registrationCost: 700,
  //         registerRate: '25%'
  //       },
  //       {
  //         sendTime: '2020/02/04 20:54',
  //         msgTitle: 'Juila黑心台北2',
  //         contents: '有危機才有機2...',
  //         sendType: 'email',
  //         sendPeople: 1456,
  //         msgFee: 1000,
  //         registerTotal: 250,
  //         registrationCost: 700,
  //         registerRate: '25%'
  //       }
  //     ]
  //   },
  //   {
  //     name: '順昌',
  //     data:[
  //       {
  //         sendTime: '2020/02/05 12:32',
  //         msgTitle: '順昌黑心台北',
  //         contents: '順昌有危機才有機...',
  //         sendType: 'email',
  //         sendPeople: 1456,
  //         msgFee: 1000,
  //         registerTotal: 250,
  //         registrationCost: 700,
  //         registerRate: '25%'
  //       },
  //       {
  //         sendTime: '2020/02/04 20:54',
  //         msgTitle: '順昌黑心台北2',
  //         contents: '順昌有危機才有機2...',
  //         sendType: 'email',
  //         sendPeople: 1456,
  //         msgFee: 1000,
  //         registerTotal: 250,
  //         registrationCost: 700,
  //         registerRate: '25%'
  //       }
  //     ]
  //   },
  //   {
  //     name: '北極熊',
  //     data:[
  //       {
  //         sendTime: '2020/02/05 12:32',
  //         msgTitle: '北極熊黑心台北',
  //         contents: '北極熊有危機才有機...',
  //         sendType: 'email',
  //         sendPeople: 1456,
  //         msgFee: 1000,
  //         registerTotal: 250,
  //         registrationCost: 700,
  //         registerRate: '25%'
  //       },
  //       {
  //         sendTime: '2020/02/04 20:54',
  //         msgTitle: '北極熊黑心台北2',
  //         contents: 'v有危機才有機2...',
  //         sendType: 'email',
  //         sendPeople: 1456,
  //         msgFee: 1000,
  //         registerTotal: 250,
  //         registrationCost: 700,
  //         registerRate: '25%'
  //       }
  //     ]
  //   }
  // ];

  // $('tbody').addClass('tab-content');

  var daterange = $('#daterange').val();

  $("document").ready(function() {

    // $('input[name="daterange"]').daterangepicker({
    //   opens: 'left'
    // }, function(start, end, label) {
    //   console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    // });

    //日期區間
    $('input[name="daterange"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
        format: 'YYYY-MM-DD',
        separator: ' ~ '
      }
    });

    //日期區間搜尋
    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
      $.fn.dataTable.ext.search.push(
      function (settings, data, dataIndex) {

          var min = picker.startDate.format('YYYY-MM-DD');
          var max = picker.endDate.format('YYYY-MM-DD');
          
          var startDate = data[0];
          if (startDate <= max && startDate >= min) { return true; }
          return false;
      });

      table.draw();
    });


    table = $('#table_list').DataTable({
        "dom": '<l<t>p>',
        "ordering": false
    });


    // $('.nav-item').on('click', function() {
    //   var target = $(this).attr('data-target');
    //   $('.show_row').removeClass('show_row')
    //   $(`.${target}`).addClass('show_row');
    // });


    fakeData.forEach((data, idx) => {
      // $('#nav-tab a').eq(idx).text(data.name);

      var dataLen = fakeData[idx].data.length;


      var tdData = ``;

      for (let index = 0; index < dataLen; index++) {
        tdData += `<tr ${ idx != 0 ? `class='fade_row ${ fakeData[idx].name }'` : `class='fade_row show_row ${ fakeData[idx].name }'` }>
        <td>${ fakeData[idx].data[index].sendTime }</td>
        <td>${ fakeData[idx].data[index].msgTitle }</td>
        <td>${ fakeData[idx].data[index].contents }</td>
        <td>${ fakeData[idx].data[index].sendType }</td>
        <td>${ fakeData[idx].data[index].sendPeople }</td>
        <td>${ fakeData[idx].data[index].msgFee }</td>
        <td>${ fakeData[idx].data[index].registerTotal }</td>
        <td>${ fakeData[idx].data[index].registrationCost }</td>
        <td>${ fakeData[idx].data[index].registerRate }</td>
        </tr>`;
      }


      //  $('tbody').append(tdData);

    });


  })
</script>


@endsection