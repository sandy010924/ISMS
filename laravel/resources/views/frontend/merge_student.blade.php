@extends('frontend.layouts.master')

@section('content')
<!-- Content Start -->
<!--搜尋課程頁面內容-->

<div class="card m-3 ">
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
          <button type="submit" class="btn btn-primary" onclick="edite_student();">合併</button>
          <!-- <button type="submit" class="btn btn-primary" onclick="test();">測試</button> -->
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
          <button id="search" type="submit" class="btn btn-primary">搜尋</button>
          <button id="view" type="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">顯示</button>
        </div>
      </div>
    </div>
    <div class="row">
      <div id="search_content" class="col">
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="show_data" class="modal-body">
        點屁喔(#`Д´)ﾉ 你又沒查資料
      </div>
    </div>
  </div>
</div>

<style>
  table td {
    background-color: #fff;
  }

  table {
    white-space: nowrap;
    overflow-x: scroll;
  }
</style>
<!-- Content End -->
<script>
  $('#search').click(function() {
    $('#show_data').html('')
    $.ajax({
      type: 'GET',
      url: 'merge_student_search',
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

        for (var i = 0; i < data.length; i++) {
          td += "<tr><td>" + data[i]['name'] + "</td>";
          td += "<td>" + data[i]['id'] + "</td>";
          td += "<td>" + data[i]['memo'] + "</td>";
          td += "<td><table>";
          for (var j = 0; j < data[i]['student'].length; j++) {
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


  $('#view').click(function() {
    var table_length = document.getElementById("search_table").rows.length;
    var s_data = '<table>'
    for (var i = 4; i < table_length; i++) {

      s_data += "<tr>";
      s_data += "<td>" + document.getElementById("search_table").rows[i].cells[1].innerHTML + "</td>"
      s_data += "<td>" + document.getElementById("search_table").rows[i].cells[2].innerHTML + "</td>"
      s_data += "</tr>";
    }
    s_data += "</table>";

    $('#show_data').html(s_data)

  });
  /* 合併資料 - S Rocky(2020/08/29) */
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


    $.ajax({
      type: 'POST',
      url: 'merge_student_student',
      data: {
        idlist: textlist,
        change_id_student: change_id_student
      },
      success: function(data) {

        if (data.length > 0) {
          /** alert **/
          $("#success_alert_text").html(data[0]['name'] +
            "&nbsp;&nbsp; 合併成功");
          fade($("#success_alert"));
          $('#t_0').val('')
          $('#change_id_student').val('')
        } else {
          $("#error_alert_text").html("合併失敗");
          fade($("#error_alert"));
        }

      },
      error: function(jqXHR) {
        console.log(JSON.stringify(jqXHR));

        /** alert **/
        $("#error_alert_text").html("合併失敗");
        fade($("#error_alert"));
      }
    });
  }
  /* 合併資料 - E Rocky(2020/08/29) */


  function test() {

    $.ajax({
      type: 'POST',
      url: 'merge_test',
      success: function(data) {

        console.log(data);

      },
      error: function(jqXHR) {
        console.log(JSON.stringify(jqXHR));
      }
    });
  }
</script>
@endsection