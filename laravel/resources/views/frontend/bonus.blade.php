@extends('frontend.layouts.master')

@section('title', '財務管理')
@section('header', '獎金名單')

@section('content')
<!-- Content Start -->
<!--搜尋課程頁面內容-->
<div class="card m-3">
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-2">
      </div>
      <div class="col-2">
        <!-- <div class="input-group date" data-target-input="nearest">
          <input type="text" id="search_date" name="search_date" class="form-control datetimepicker-input" data-target="#search_date" placeholder="日期" data-toggle="datetimepicker" autocomplete="off">
          <div class="input-group-append" data-target="#search_date" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
          </div>
        </div> -->
      </div>
      <div class="col-3">
        <input type="search" class="form-control" placeholder="搜尋姓名" aria-label="Class's name" id="search_name">
      </div>
      <div class="col-3">
        <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
        @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' ))
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#bonus_add">新增獎金</button>
        @endif
      </div>
    </div>
    <div class="table-responsive">
      @component('components.datatable')
      @slot('thead')
      <tr>
        <th>姓名</th>
        <th>狀態</th>
        <th>獎金條件</th>
        <th>建立時間</th>
        <th></th>
      </tr>
      @endslot
      @slot('tbody')
      @foreach($bonus as $key => $data )
      <tr>
        <td>{{ $data['bonus_name']  }}</td>
        <td>{{ ($data['bonus_status'] == '1') ? '啟用' : '暫停'  }}</td>
        <td>
          @foreach($data['bonus_rule'] as $key => $data_rule )
          <span>{{$data_rule['name']}}<b style="color:#d21b1b">{{$data_rule['value']}}</b></span> <br>
          @endforeach
        </td>
        <td>{{ $data['created_at'] }}</td>
        <td>
          @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'accountant'|| Auth::user()->role == 'saleser' || Auth::user()->role == 'msaleser')))
          <a role="button" class="btn btn-secondary btn-sm mx-1" href="{{ route('show_bonus_detail', [ 'id' => $data['id'] ] ) }}">完整內容</a>
          @endif
          @if (isset(Auth::user()->role) != '' && (Auth::user()->role == 'admin' || Auth::user()->role == 'accountant'))
          <button type="button" class="btn btn-secondary btn-sm mx-1" data-toggle="modal" data-target="#bonus_edite" onclick="show_bonus({{ $data['id']}})">編輯</button>
          <button type="button" class="btn btn-danger btn-sm mx-1" onclick="bonus_delete({{ $data['id']}})">刪除</button>
          @endif

        </td>
      </tr>
      @endforeach
      @endslot
      @endcomponent
    </div>

    <!-- 新增獎金 Rocky (2002/04/24) - S -->
    <div class="modal fade text-left " id="bonus_add" tabindex="-1" role="dialog" aria-labelledby="bonus_addLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">新增獎金</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group required">
              <label for="new_name" class="col-form-label">姓名</label>
              <input type="text" id="bonus_add_name" name="new_name" class="form-control" required>
            </div>
            <div class="form-group required">
              <label for="new_condition">條件</label>
              <b style="color:#d03939">(輸入框請用小寫逗號區隔，Ex: fb,line)</b>
              <div class="form-group row mb-3">
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="c_add" value="" id="c_add_0">
                    <label class="form-check-label" for="c_add_0">
                      <h6 name="rule_add_name">名單來源包含<input id="t_add_0" type="text" name="rule_add" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="c_add" value="" id="c_add_1">
                    <label class="form-check-label" for="c_add_1">
                      <h6 name="rule_add_name">工作人員包含<input id="t_add_1" type="text" name="rule_add" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="c_add" value="" id="c_add_2">
                    <label class="form-check-label" for="c_add_2">
                      <h6 name="rule_add_name">主持開場包含<input id="t_add_2" type="text" name="rule_add" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group row mb-3">
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="c_add" value="" id="c_add_3">
                    <label class="form-check-label" for="c_add_3">
                      <h6 name="rule_add_name">結束收單包含<input id="t_add_3" type="text" name="rule_add" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="c_add" value="" id="c_add_4">
                    <label class="form-check-label" for="c_add_4">
                      <h6 name="rule_add_name">服務人員包含<input id="t_add_4" type="text" name="rule_add" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="c_add" value="" id="c_add_5">
                    <label class="form-check-label" for="c_add_5">
                      <h6 name="rule_add_name">追單人員包含<input id="t_add_5" type="text" name="rule_add" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group required">
              <label for="new_mode" class="col-form-label">狀態</label>
              <div class="form-check">
                <input id="status_add_1" type="radio" name="status_add" value="1">
                <label for="status_add_1">啟用</label>&nbsp; &nbsp;
                <input id="status_add_0" type="radio" name="status_add" value="0">
                <label for="status_add_0">暫停</label>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary" onclick="add_bonus();">確認</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- 新增獎金 Rocky (2002/04/24) - E -->

    <!-- 編輯獎金 Rocky (2002/04/26) - S -->
    <div class="modal fade text-left " id="bonus_edite" tabindex="-1" role="dialog" aria-labelledby="bonus_editeLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">編輯獎金</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="input_id">
            <div class="form-group required">
              <label for="new_name" class="col-form-label">姓名</label>
              <input type="text" id="bonus_name" name="new_name" class="form-control" required>
            </div>
            <div class="form-group required">
              <label for="new_condition">條件</label>
              <b style="color:#d03939">(輸入框請用小寫逗號區隔，Ex: fb,line)</b>
              <div class="form-group row mb-3">
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="c_edite" value="" id="c_0">
                    <label class="form-check-label" for="c_0">
                      <h6 name="rule_name">名單來源包含<input id="t_0" type="text" name="rule" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="c_edite" value="" id="c_1">
                    <label class="form-check-label" for="c_1">
                      <h6 name="rule_name">工作人員包含<input id="t_1" type="text" name="rule" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="c_edite" value="" id="c_2">
                    <label class="form-check-label" for="c_2">
                      <h6 name="rule_name">主持開場包含<input id="t_2" type="text" name="rule" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group row mb-3">
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="c_edite" value="" id="c_3">
                    <label class="form-check-label" for="c_3">
                      <h6 name="rule_name">結束收單包含<input id="t_3" type="text" name="rule" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="c_edite" value="" id="c_4">
                    <label class="form-check-label" for="c_4">
                      <h6 name="rule_name">服務人員包含<input id="t_4" type="text" name="rule" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="c_edite" value="" id="c_5">
                    <label class="form-check-label" for="c_5">
                      <h6 name="rule_name">追單人員包含<input id="t_5" type="text" name="rule" class="border-top-0 border-right-0 border-left-0 mx-1 w-50 text-center"></h6>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group required">
              <label for="new_mode" class="col-form-label">狀態</label>
              <div class="form-check">
                <input id="status_1" type="radio" name="status" value="1">
                <label for="status_1">啟用</label>&nbsp; &nbsp;
                <input id="status_0" type="radio" name="status" value="0">
                <label for="status_0">暫停</label>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary" onclick="update_bonus();">儲存</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- 編輯獎金 Rocky (2002/04/26) - E -->
  </div>
</div>

<!-- Content End -->
<script>
  var table;

  $("document").ready(function() {
    // 日期選擇器 Rocky(2020/04/24)
    // $('#search_date').datetimepicker({
    //   format: 'YYYY-MM-DD'
    // });

    /* Datatable.js Rocky(2020/04/24) - S */
    table = $('#table_list').DataTable({
      "dom": '<l<t>p>',
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }]
    });

    $('#table_list_history').DataTable({
      "dom": '<l<td>p>',
      "destroy": true,
      "ordering": true,
      "columnDefs": [{
        "targets": 'no-sort',
      }]
    });
    /* Datatable.js Rocky(2020/04/24) - E */

    /* 輸入框 Rocky(2020/04/24) - S */
    $('#search_date').on('keyup', function(e) {
      if (e.keyCode === 13) {
        $("#btn_search").click();
      }
    });
    $('#search_name').on('keyup', function(e) {
      if (e.keyCode === 13) {
        $("#btn_search").click();
      }
    });
  });


  /* 刪除獎金資料 - S Rocky(2020/04/26) */
  function bonus_delete(id) {
    var msg = "是否刪除此筆資料?";
    if (confirm(msg) == true) {
      $.ajax({
        type: 'POST',
        url: 'delete_bonus',
        data: {
          id: id
        },
        success: function(data) {
          if (data = "刪除成功") {
            $("#success_alert_text").html("刪除成功");
            fade($("#success_alert"));
            location.reload();
          } else {
            $("#error_alert_text").html("刪除失敗");
            fade($("#error_alert"));
          }
        },
        error: function(error) {
          console.log(JSON.stringify(error));
        }
      });
    } else {
      return false;
    }
  }
  /* 刪除獎金資料 - E Rocky(2020/04/26) */

  /* 顯示獎金資料 - S Rocky(2020/04/26) */
  function show_bonus(id) {
    $('#input_id').val(id)
    $.ajax({
      type: 'POST',
      url: 'show_bonusrule',
      data: {
        id: id
      },
      dataType: 'json',
      success: function(data) {
        $("#bonus_name").val(data[0]['bonus_name']) // 姓名
        // 狀態
        if (data[0]['bonus_status'] == "1") {
          $('#status_1').attr('checked', 'checked');
        } else if (data[0]['bonus_status'] == "0") {
          $('#status_0').attr('checked', 'checked');
        }


        $.each(data[0]['bonus_rule'], function(index, val) {
          // 勾選狀態        
          if (val['status'] == '1') {
            $('input[id=c_' + val['name_id'] + ']').prop("checked", true);
            $('input[id=c_' + val['name_id'] + ']').val('1');
            $('input[id=t_' + val['name_id'] + ']').val(val['value']);
          } else {
            $('input[id=c_' + val['name_id'] + ']').prop("checked", false);
            $('input[id=c_' + val['name_id'] + ']').val('0');
          }

          // 規則
          // $('input[id=t_' + val['rule_value'] + ']').val(val['regulation']);;
        });
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }
  /* 顯示獎金資料 - E Rocky(2020/04/26) */

  /* 新增獎金資料 - ESRocky(2020/04/27) */
  function add_bonus() {
    var checkboxlist = '',
      namelist = '',
      nameidlist = '',
      textlist = '';

    // 名稱
    $("h6[name='rule_add_name']").each(function(index) {
      if (this.text != '') {
        namelist += $(this).text() + ",";
      }
    });
    if (namelist.length > 0) {
      namelist = namelist.substring(0, namelist.length - 1);
    }

    // 勾選
    $("input[name='c_add']").each(function(index) {
      if (this.checked) {
        checkboxlist += "1,";
      } else {
        checkboxlist += "0,";
      }
    });
    if (checkboxlist.length > 0) {
      checkboxlist = checkboxlist.substring(0, checkboxlist.length - 1);
    }

    // 輸入框
    $("input[name='rule_add']").each(function(index) {
      if (this.val != '') {
        textlist += $(this).val() + "|";
      } else {
        textlist += "0|";
      }
    });
    if (textlist.length > 0) {
      textlist = textlist.substring(0, textlist.length - 1);
    }
    nameidlist = '0,1,2,3,4,5';
    // console.log(namelist + '\n' + nameidlist + '\n' + checkboxlist + '\n' + textlist)
    if ($('input[name="status_add"]:checked').val() == null || $('#bonus_add_name').val() == null) {
      alert('請選擇姓名 / 狀態！！')
      return false;
    }
    $.ajax({
      type: 'POST',
      url: 'add_bonus',
      data: {
        name: $('#bonus_add_name').val(),
        bonus_status: $('input[name="status_add"]:checked').val(),
        namelist: namelist,
        nameidlist: nameidlist,
        checkboxlist: checkboxlist,
        textlist: textlist
      },
      success: function(data) {
        /** alert **/
        $("#success_alert_text").html("資料儲存成功");
        fade($("#success_alert"));
        location.reload();
      },
      error: function(jqXHR) {
        console.log(JSON.stringify(jqXHR));

        /** alert **/
        $("#error_alert_text").html("資料儲存失敗");
        fade($("#error_alert"));
      }
    });
  }
  /* 新增獎金資料 - E Rocky(2020/04/27) */

  /* 更新獎金資料 - S Rocky(2020/04/26) */
  function update_bonus() {
    var checkboxlist = '',
      namelist = '',
      nameidlist = '',
      textlist = '';

    // 名稱
    $("h6[name='rule_name']").each(function(index) {
      if (this.text != '') {
        namelist += $(this).text() + ",";
      }
    });
    if (namelist.length > 0) {
      namelist = namelist.substring(0, namelist.length - 1);
    }

    // 勾選
    $("input[name='c_edite']").each(function(index) {
      if (this.checked) {
        checkboxlist += "1,";
      } else {
        checkboxlist += "0,";
      }
    });
    if (checkboxlist.length > 0) {
      checkboxlist = checkboxlist.substring(0, checkboxlist.length - 1);
    }

    // 輸入框
    $("input[name='rule']").each(function(index) {
      if (this.val != '') {
        textlist += $(this).val() + "|";
      } else {
        textlist += "0|";
      }
    });
    if (textlist.length > 0) {
      textlist = textlist.substring(0, textlist.length - 1);
    }
    nameidlist = '0,1,2,3,4,5';
    // console.log(namelist + '\n' + nameidlist + '\n' + checkboxlist + '\n' + textlist)

    if ($('input[name="status"]:checked').val() == null || $('#bonus_name').val() == '') {
      alert('請選擇姓名 / 狀態！！')
      return false;
    }

    $.ajax({
      type: 'POST',
      url: 'update_bonus',
      data: {
        id: $('#input_id').val(),
        name: $('#bonus_name').val(),
        bonus_status: $('input[name="status"]:checked').val(),
        namelist: namelist,
        nameidlist: nameidlist,
        checkboxlist: checkboxlist,
        textlist: textlist
      },
      success: function(data) {
        /** alert **/
        $("#success_alert_text").html("資料更新成功");
        fade($("#success_alert"));
        location.reload();
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