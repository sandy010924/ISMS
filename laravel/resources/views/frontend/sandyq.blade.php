@extends('frontend.layouts.master')

@section('content')
<!-- Content Start -->
<!--搜尋課程頁面內容-->

<div class="card m-3 d-none">
  <div class="card-body">
    <div class="row mb-3">
      <div class="=col-12 ml-3">
        <div class="form-group required">
          <label for="new_condition">學員ID</label>
          <b style="color:#d03939">(輸入框請用小寫逗號區隔，Ex: 9111,9108)</b>
          <input id="t_0" type="text" name="id_student" class="border-top-0 border-right-0 border-left-0 mx-1 w-100 p-3 text-center">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="=col-12 ml-3">
        <b style="color:#d03939">(要取代成? Ex:9111)</b>
        <input id="change_id_student" type="text">
      </div>
    </div>
    <div class="row mb-3">
      <div class="=col-sm-3">
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" onclick="edite_student();">儲存</button>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="card m-3">
  <div class="card-body">
    <div class="row mb-3">
      <div class="=col-12 ml-3">
        <div class="form-group required">
          <label for="search">快速搜尋小工具</label>
          <b style="color:#d03939">(輸入姓名，已半形空白為分割)</b>
          <input id="textlist" type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-100 p-3 text-center">
          <button id="search" type="submit" class="btn btn-primary">儲存</button>
        </div>
      </div>
    </div>
    <div class="row">
      <div id="search_content" class="col">
      </div>
    </div>
  </div>
</div>

<style>
  table td{
    background-color: #fff;
  }
  table{
    white-space: nowrap;
    overflow-x: scroll;
  }
</style>
<!-- Content End -->
<script>

  $('#search').click(function() {
    $.ajax({
      type: 'GET',
      url: 'sandyq_search',
      data: {
        list: $('#textlist').val()
      },
      success: function(data) {
        console.log(data)

        //datatable Layout
        var tableLayout = `
            <table id="search_table" name="search_table" class="table table-striped table-sm border rounded-lg bg-withe">
              <thead id="tableHead">
                <tr>姓名</tr>
                <tr>資料</tr>
                <tr>id</tr>
                <tr>備注</tr>
              </thead>
              <tbody id="tableBody">
              </tbody>
            </table>`;

        $('#search_content').html(tableLayout);

        var td = '';

        for( var i = 0 ; i < data.length ; i++ ){
            td += "<tr><td>" + data[i]['name'] + "</td>";
            td += "<td>" + data[i]['id'] + "</td>";
            td += "<td>" + data[i]['memo'] + "</td>";
            td += "<td><table>";
            for( var j = 0 ; j < data[i]['student'].length ; j++ ){
              td += "<tr>";
              td += "<td>" + data[i]['student'][j]['id'] + "</td>";
              td += "<td>" + data[i]['student'][j]['name'] + "</td>";
              td += "<td>" + data[i]['student'][j]['phone'] + "</td>";
              td += "<td>" + data[i]['student'][j]['email'] + "</td>";
              td += "<td>" + data[i]['student'][j]['sex'] + "</td>";
              td += "<td>" + data[i]['student'][j]['id_identity'] + "</td>";
              td += "<td>" + data[i]['student'][j]['birthday'] + "</td>";
              td += "<td>" + data[i]['student'][j]['profession'] + "</td>";
              td += "</tr>";
            }
            td += "<tr/></table>";
        }


        $('#search_content #search_table #tableBody').html(td);

        /** alert **/
        // $("#success_alert_text").html("資料更新成功");
        // fade($("#success_alert"));
        // location.reload();
      },
      error: function(jqXHR) {
        console.log(JSON.stringify(jqXHR));

        /** alert **/
        $("#error_alert_text").html("搜尋失敗");
        fade($("#error_alert"));
      }
    });
  });


















  var table;

  $("document").ready(function() {

  });

  /* 更新獎金資料 - S Rocky(2020/04/26) */
  function edite_student() {
    var textlist = '',
      change_id_student = '',
      delete_id_student = '';

    // student.id
    $("input[name='id_student']").each(function(index) {
      if (this.val != '') {
        textlist += $(this).val() + ",";
      }
    });
    if (textlist.length > 0) {
      textlist = textlist.substring(0, textlist.length - 1);
    }

    change_id_student = $('#change_id_student').val()
    // console.log(change_id_student)

    $.ajax({
      type: 'POST',
      url: 'sandyq_student',
      data: {
        idlist: textlist,
        change_id_student: change_id_student
      },
      success: function(data) {
        console.log(data)
        /** alert **/
        // $("#success_alert_text").html("資料更新成功");
        // fade($("#success_alert"));
        // location.reload();
      },
      error: function(jqXHR) {
        console.log(JSON.stringify(jqXHR));

        /** alert **/
        $("#error_alert_text").html("資料更新失敗");
        fade($("#error_alert"));
      }
    });
  }
  /* 更新獎金資料 - E Rocky(2020/04/26) */

  /* 顯示學員資料 - S Rocky(2020/04/25) */
  function show_invoice(id_group) {
    $("#invoice").modal('show');

    $.ajax({
      type: 'POST',
      url: 'show_student',
      data: {
        id_group: id_group
      },
      success: function(data) {
        // console.log(data)
        var updatetime = ''
        $('#history_data_detail').html('');
        $.each(data, function(index, val) {
          var type_invoice = ''
          if (val['type_invoice'] == '0') {
            type_invoice = '捐贈社會福利機構（ 由無極限國際公司另行辦理）'
          } else if (val['type_invoice'] == '1') {
            type_invoice = '二聯式'
          } else if (val['type_invoice'] == '2') {
            type_invoice = '三聯式'
          }
          updatetime += "#new_starttime" + val['id'] + ','
          data +=
            '<tr>' +
            '<td>' + val['created_at'] + '</td>' +
            '<td>' + val['name'] + '</td>' +
            '<td>' + type_invoice + '</td>' +
            '<td> ' +
            '<div class="input-group date show_datetime" id="new_starttime' + val['id'] + '" data-target-input="nearest"> ' +
            ' <input type="text" onblur="auto_update_invoice($(this),' + val['id'] + ',0);" value="' + val['invoice_created_at'] + '" class="form-control datetimepicker-input datepicker" data-target="#new_starttime' + val['id'] + '" /> ' +
            ' <div class="input-group-append" data-target="#new_starttime' + val['id'] + '" data-toggle="datetimepicker"> ' +
            ' <div class="input-group-text"><i class="fa fa-calendar"></i></div> ' +
            '</div> ' +
            '</div>' +
            '</td>' +
            '<td><input type="number" class="form-control form-control-sm"  onblur="auto_update_invoice($(this),' + val['id'] + ',1);"  value="' + val['invoice'] + '"></td>' +
            '<td>' + val['companytitle'] + '</td>' +
            '<td>' + val['number_taxid'] + '</td>' +
            '<td>' + val['address'] + '</td>' +
            '</tr>'
        });
        $('#history_data_detail').html(data);
        // 日期
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
        $(updatetime.substring(0, updatetime.length - 1)).datetimepicker({
          format: "YYYY-MM-DD",
          icons: iconlist,
          defaultDate: new Date(),
          pickerPosition: "bottom-left"
        });
      },
      error: function(jqXHR) {
        console.log(JSON.stringify(jqXHR));
      }
    });
  }
  /* 顯示學員資料 - E Rocky(2020/04/25) */

  /* 搜尋 Rocky(2020/04/24) - S */
  $.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
      var seatch_date = $('#search_date').val();
      var search_name = $('#search_name').val();
      var date = data[3];
      var course = data[0];

      if ((isNaN(seatch_date) && isNaN(search_name)) || (date.includes(seatch_date) && isNaN(search_name)) || (course.includes(search_name) && isNaN(seatch_date)) || (course.includes(search_name) && date.includes(seatch_date))) {
        return true;
      }
      return false;
    }
  );

  $("#btn_search").click(function() {
    table.columns(3).search($('#search_date').val()).columns(0).search($("#search_name").val()).draw();
  });
  /* 搜尋 Rocky(2020/04/24) - E */
</script>
@endsection