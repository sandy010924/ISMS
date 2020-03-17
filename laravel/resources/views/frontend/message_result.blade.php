@extends('frontend.layouts.master')

@section('title', '推播成效')
@section('header', '推播成效')

@section('content')
<!-- Content Start -->
       <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">

            </div>
            <div class="container">

            <div class="row mb-2" style="align-items: baseline;">
              <h4 class="mr-2">選擇日期</h4>
              <div class="form-group">
                <div class='input-group date' id='datepicker' data-target-input='nearest' style="width: 275px;">
                  <input type="text" class="m-1 w-100 form-control p-0" name="daterange"/>
                  <button type="button" class="btn btn-primary ml-2">查詢</button>
                </div>
              </div>


            </div>


              <div class="row">
                <div class="col-xs-12" style="width: 100%;">

                <nav>
                  <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" data-toggle="tab" data-target="Jack" role="tab"></a>
                    <a class="nav-item nav-link" data-toggle="tab" data-target="Juila" role="tab"></a>
                    <a class="nav-item nav-link" data-toggle="tab" data-target="順昌" role="tab"></a>
                    <a class="nav-item nav-link" data-toggle="tab" data-target="北極熊" role="tab"></a>
                  </div>
                </nav>

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
                    </tr>
                  @endslot
                  @slot('tbody')


                  @endslot
                @endcomponent

                </div>
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
  var fakeData = [
    {
      name: 'Jack',
      data:[
        {
          sendTime: '2020/02/05 12:32',
          msgTitle: 'Jack黑心台北',
          contents: '有危機才有機...',
          sendType: 'email',
          sendPeople: 1456,
          msgFee: 1000,
          registerTotal: 250,
          registrationCost: 700,
          registerRate: '25%'
        },
        {
          sendTime: '2020/02/04 20:54',
          msgTitle: 'Jack黑心台北2',
          contents: '有危機才有機2...',
          sendType: 'email',
          sendPeople: 1456,
          msgFee: 1000,
          registerTotal: 250,
          registrationCost: 700,
          registerRate: '25%'
        }
      ]
    },
    {
      name: 'Juila',
      data:[
        {
          sendTime: '2020/02/05 12:32',
          msgTitle: 'Juila黑心台北',
          contents: '有危機才有機...',
          sendType: 'email',
          sendPeople: 1456,
          msgFee: 1000,
          registerTotal: 250,
          registrationCost: 700,
          registerRate: '25%'
        },
        {
          sendTime: '2020/02/04 20:54',
          msgTitle: 'Juila黑心台北2',
          contents: '有危機才有機2...',
          sendType: 'email',
          sendPeople: 1456,
          msgFee: 1000,
          registerTotal: 250,
          registrationCost: 700,
          registerRate: '25%'
        }
      ]
    },
    {
      name: '順昌',
      data:[
        {
          sendTime: '2020/02/05 12:32',
          msgTitle: '順昌黑心台北',
          contents: '順昌有危機才有機...',
          sendType: 'email',
          sendPeople: 1456,
          msgFee: 1000,
          registerTotal: 250,
          registrationCost: 700,
          registerRate: '25%'
        },
        {
          sendTime: '2020/02/04 20:54',
          msgTitle: '順昌黑心台北2',
          contents: '順昌有危機才有機2...',
          sendType: 'email',
          sendPeople: 1456,
          msgFee: 1000,
          registerTotal: 250,
          registrationCost: 700,
          registerRate: '25%'
        }
      ]
    },
    {
      name: '北極熊',
      data:[
        {
          sendTime: '2020/02/05 12:32',
          msgTitle: '北極熊黑心台北',
          contents: '北極熊有危機才有機...',
          sendType: 'email',
          sendPeople: 1456,
          msgFee: 1000,
          registerTotal: 250,
          registrationCost: 700,
          registerRate: '25%'
        },
        {
          sendTime: '2020/02/04 20:54',
          msgTitle: '北極熊黑心台北2',
          contents: 'v有危機才有機2...',
          sendType: 'email',
          sendPeople: 1456,
          msgFee: 1000,
          registerTotal: 250,
          registrationCost: 700,
          registerRate: '25%'
        }
      ]
    }
  ];

  // $('tbody').addClass('tab-content');

  $("document").ready(function() {

    $('input[name="daterange"]').daterangepicker({
      opens: 'left'
    }, function(start, end, label) {
      console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

    table = $('#table_list').DataTable({
        "dom": '<l<t>p>',
        "ordering": false
    });

    $('.nav-item').on('click', function() {
      var target = $(this).attr('data-target');
      $('.show_row').removeClass('show_row')
      $(`.${target}`).addClass('show_row');
    });



    fakeData.forEach((data, idx) => {
      $('#nav-tab a').eq(idx).text(data.name);

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


       $('tbody').append(tdData);

    });


  })
</script>


@endsection