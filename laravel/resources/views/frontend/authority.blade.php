@extends('frontend.layouts.master')

@section('title', '系統設定')
@section('header', '權限管理')

@section('content')
<!-- Content Start -->
<!--權限管理頁面內容-->
<div class="card m-3">
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-3"></div>
      <div class="col-7">
        <div class="input-group">
          <div class="col-md-4">
            <input type="search" class="form-control" name="name" placeholder="搜尋姓名" aria-describedby="btn_search" id="search_keyword">
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <select class="custom-select form-control" id="search_role" name="search_role">
                <option value="">請選擇</option>
                <option value="講師">講師</option>
                <option value="業務人員">業務人員</option>
                <option value="業務主管 ">業務主管</option>
                <option value="行政人員">行政人員</option>
                <option value="臨時人員">臨時人員</option>
                <option value="財務人員">財務人員</option>
                <option value="行銷人員">行銷人員</option>
                <option value="管理員">管理員</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <button type="button" class="btn btn-outline-secondary" id="btn_search">搜尋</button>
            <button type="button" class="btn btn-primary btn_date mx-1" data-toggle="modal" data-target="#form_newuser"><i class="fa fa-plus-square"></i> 新增</button>
            <!-- <button type="button" class="btn btn-outline-secondary" onclick="btn_email();">email test</button> -->
          </div>
        </div>
      </div>
    </div>
    <!-- 列表 -S Rocky(2020/05/01) -->
    @component('components.datatable')
    @slot('thead')
    <tr>
      <th>帳號</th>
      <th>姓名</th>
      <th>狀態</th>
      <th>角色</th>
      <th>建立時間</th>
      <th class="no-sort"></th>
    </tr>
    @endslot
    @slot('tbody')
    @foreach($datas as $key => $data )
    <tr>
      <td>{{ $data['account'] }}</td>
      <td>{{ $data['name'] }}</td>
      <td>{{ $data['status'] }}</td>
      <td>{{ $data['role_name'] }}</td>
      <td>{{ $data['created_at'] }}</td>
      <td>
        <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" onclick="show_edite({{ $data['id']}})">修改</button>
        <button id="{{ $data['id'] }}" class="btn btn-danger btn-sm mx-1" onclick="btn_delete({{ $data['id'] }});" value="{{ $data['id'] }}">刪除</button>
      </td>
    </tr>
    @endforeach
    @endslot
    @endcomponent
    <!-- 列表 -E Rocky(2020/05/01) -->

    <!-- 新增 -S Rocky(2020/05/01) -->
    <div class="modal fade" id="form_newuser" tabindex="-1" role="dialog" aria-labelledby="form_newuserLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="form_newclassLabel">新增</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              @csrf
              <div class="form-group required">
                <label for="new_mode">狀態</label>
                <div class="form-check">
                  <input id="status_add_1" type="radio" name="status_add" value="1" checked>
                  <label for="status_add_1">啟用</label>&nbsp; &nbsp;
                  <input id="status_add_0" type="radio" name="status_add" value="0">
                  <label for="status_add_0">暫停</label>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-form-label">帳號</label>
                <input type="text" class="form-control" id="newuser_account" name="account" required>
              </div>
              <div class="form-group required">
                <label for="newuser_password" class="col-form-label">密碼</label>
                <input type="password" class="form-control" id="newuser_password" name="password" required>
              </div>
              <div class="form-group required">
                <label for="newuser_password2" class="col-form-label">確認密碼</label>
                <input type="password" class="form-control" id="newuser_password2" name="password_check" data-match="#newuser_password" required>
              </div>
              <div class="form-group required">
                <label for="input_email" class="col-form-label">Email</label>
                <input type="text" class="form-control" id="input_email" name="input_email" required>
              </div>
              <div class="form-group required">
                <label for="newuser_name" class="col-form-label">姓名</label>
                <input type="text" class="form-control" id="newuser_name" name="name" required>
              </div>
              <div class="form-group">
                <label for="newuser_persona" class="col-form-label">角色</label>
                <select class="custom-select form-control" id="newuser_persona" name="newuser_persona" required>
                  <option value="teacher">講師</option>
                  <option value="saleser">業務人員</option>
                  <option value="msaleser ">業務主管</option>
                  <option value="officestaff">行政人員</option>
                  <option value="staff">臨時人員</option>
                  <option value="accountant">財務人員</option>
                  <option value="marketer">行銷人員</option>
                  <option value="admin">管理員</option>
                </select>
              </div>
              <div class="form-group">
                <label for="select_teacher" class="col-form-label">講師</label>
                <select class="custom-select form-control" id="select_teacher" name="select_teacher">
                </select>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="button" id="btn_id_add" class="btn btn-primary" onclick="btn_add()">確認</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- 新增 -E Rocky(2020/05/01) -->

    <!-- 編輯 -S Rocky(2020/05/01) -->
    <div class="modal fade text-left" id="model_edite" tabindex="-1" role="dialog" aria-labelledby="form_updateuserLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="form_newclassLabel">修改資料</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              @csrf
              <input type="hidden" id="id_edite" name="id_edite">
              <div class="form-group required">
                <label for="new_mode" class="col-form-label">狀態</label>
                <div class="form-check">
                  <input id="status_1" type="radio" name="edite_status" value="1">
                  <label for="status_1">啟用</label>&nbsp; &nbsp;
                  <input id="status_0" type="radio" name="edite_status" value="0">
                  <label for="status_0">暫停</label>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-form-label">帳號</label>
                <input type="text" id="edite_account" class="form-control" name="account">
              </div>
              <div class="form-group">
                <label for="updateuser_password" class="col-form-label">密碼</label>
                <input type="password" id="edite_password" class="form-control" name="password">
              </div>
              <div class="form-group">
                <label class="col-form-label">確認密碼</label>
                <input type="password" id="edite_password_check" class="form-control" name="password_check" data-match="#updateuser_password">
              </div>
              <div class="form-group required">
                <label class="col-form-label">Email</label>
                <input type="text" id="edite_email" class="form-control" name="input_email">
              </div>
              <div class="form-group required">
                <label for="updateuser_name" class="col-form-label">姓名</label>
                <input type="text" id="edite_name" class="form-control">
              </div>
              <div class="form-group">
                <label class="col-form-label">角色</label>
                <select class="custom-select form-control" id="edite_role">
                </select>
              </div>
              <div class="form-group">
                <label class="col-form-label">講師</label>
                <select class="custom-select form-control" id="edite_teacher">
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" id="btn_id_edite" class="btn btn-primary" onclick="btn_edite();">確認</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- 編輯 -E Rocky(2020/05/01) -->
  </div>
</div>
<!-- Content End -->

<!-- alert Start-->
<div class="alert alert-success alert-dismissible  m-3 position-fixed fixed-bottom" role="alert" id="success_alert">
  <span id="success_alert_text"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="alert alert-danger alert-dismissible m-3 position-fixed fixed-bottom" role="alert" id="error_alert">
  <span id="error_alert_text"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<!-- alert End -->

<script>
  // Sandy(2020/02/26) dt列表搜尋 S
  var table, old_account;
  //針對姓名與角色搜尋 Sandy(2020/02/26)
  $.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
      var keyword = $('#search_keyword').val();
      var role = $('#search_role').val();
      var tname = data[1];
      var trole = data[2];

      if ((isNaN(keyword) && isNaN(role)) || (tname.includes(keyword) && isNaN(role)) || (trole.includes(role) && isNaN(keyword)) || (trole.includes(role) && tname.includes(keyword))) {
        return true;
      }

      return false;
    }
  );

  $("document").ready(function() {
    // 講師下拉選單 Rocky(2020/05/01)
    select_teacher();

    // 角色下拉選單 Rocky(2020/05/01)
    select_role();

    // Sandy (2020/02/26)
    table = $('#table_list').DataTable({
      "dom": '<l<t>p>',
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }]
      // "ordering": false,
    });
  });

  // 輸入框 Sandy(2020/02/25)
  $('#search_keyword').on('keyup', function(e) {
    if (e.keyCode === 13) {
      $('#btn_search').click();
    }
  });
  $('#search_role').on('keyup', function(e) {
    if (e.keyCode === 13) {
      $('#btn_search').click();
    }
  });

  $("#btn_search").click(function() {
    table.columns(1).search($('#search_keyword').val()).columns(2).search($("#search_role").val()).draw();
  });
  // Sandy(2020/02/26) dt列表搜尋 E

  // 測試 email Rocky(2020/05/11)
  function btn_email() {
    $.ajax({
      type: 'POST',
      url: 'authority_email',
      dataType: 'json',
      data: {
        emailAddr: 'g10894007@cycu.edu.tw',
        mailTitle: '無極限學員系統 - 帳號權限通知',
        mailContents: '您好，余佩珊 您的帳號：admin / 密碼：123 系統網址：https://www.google.com.tw/',
      },
      success: function(data) {
        console.log(data)
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });


  }
  // 新增 Rocky(2020/05/08)
  function btn_add() {

    var account, status, password, password_check, email, name, role, id_teacher

    account = $('#newuser_account').val()
    status = $('input[name="status_add"]:checked').val()
    password = $('#newuser_password').val()
    password_check = $('#newuser_password2').val()
    email = $('#input_email').val()
    name = $('#newuser_name').val()
    role = $('#newuser_persona').val()
    id_teacher = $('#select_teacher').val()
    if (CheckPassword(password, password_check) && check_data(account, password, email, name)) {
      $.ajax({
        type: 'POST',
        url: 'authority_insert',
        dataType: 'json',
        data: {
          account: account,
          status: status,
          password: password,
          password_check: password_check,
          email: email,
          name: name,
          role: role,
          id_teacher: id_teacher
        },
        success: function(data) {
          // console.log(data)
          if (data['data'] == 'repeat account') {
            alert('此帳號有人使用過囉！！')
          } else if (data['data'] == 'ok') {
            $('#btn_id_add').prop('disabled', 'disabled');
            setTimeout(function() {
              $("#success_alert_text").html("新增成功");
              fade($("#success_alert"));
              location.reload();
            }, 2000);
          } else if (data['data'] == 'error') {
            $("#error_alert_text").html("新增失敗");
            fade($("#error_alert"));
          }
        },
        error: function(error) {
          console.log(JSON.stringify(error));
          /** alert **/
          $("#error_alert_text").html("新增失敗");
          fade($("#error_alert"));
        }
      });
    }
  }

  // 修改 Rocky(2020/05/09)
  function btn_edite() {
    var id, account, status, password, password_check, email, name, role, id_teacher

    id = $('#id_edite').val()
    account = $('#edite_account').val()
    status = $('input[name="edite_status"]:checked').val()
    password = $('#edite_password').val()
    password_check = $('#edite_password_check').val()
    email = $('#edite_email').val()
    name = $('#edite_name').val()
    role = $('#edite_role').val()
    id_teacher = $('#edite_teacher').val()

    if (old_account == account) {
      // 沒有更改帳號
      account = "old_account"
    }
    if (CheckPassword(password, password_check) && check_data(account, password, email, name)) {

      $.ajax({
        type: 'POST',
        url: 'authority_update',
        dataType: 'json',
        data: {
          id: id,
          account: account,
          old_account: old_account,
          status: status,
          password: password,
          password_check: password_check,
          email: email,
          name: name,
          role: role,
          id_teacher: id_teacher
        },
        success: function(data) {
          if (data['data'] == 'repeat account') {
            alert('此帳號有人使用過囉！！')
          } else if (data['data'] == 'ok') {
            $('#btn_id_edite').prop('disabled', 'disabled');
            setTimeout(function() {
              $("#success_alert_text").html("修改成功");
              fade($("#success_alert"));
              location.reload();
            }, 2000);

          }
        },
        error: function(error) {
          console.log(JSON.stringify(error));
          /** alert **/
          $("#error_alert_text").html("修改失敗");
          fade($("#error_alert"));
        }
      });
    }
  }

  // 顯示修改資料 Rocky(2020/05/01)
  function show_edite(id) {
    $("#model_edite").modal('show');
    $('#id_edite').val(id)
    $.ajax({
      type: 'POST',
      url: 'show_edite',
      data: {
        id: id
      },
      dataType: 'json',
      success: function(data) {
        $.each(data, function(index, item) {
          old_account = data[index].account
          $("#edite_account").val(data[index].account) // 帳號
          $("#edite_email").val(data[index].email) // email
          $("#edite_name").val(data[index].name) // 姓名
          $("#edite_role").val(data[index].role) // 角色
          $("#edite_teacher").val(data[index].id_teacher) // 講師
          // 狀態 Rocky (2020/05/07)
          if (data[index].status == "1") {
            $('#status_1').attr('checked', 'checked');
          } else if (data[0]['bonus_status'] == "0") {
            $('#status_0').attr('checked', 'checked');
          }
        })
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }

  // 檢查空值 Rocky(2020/05/08)
  function check_data(account, pwd, email, name) {
    if (pwd != "") {
      if (account == "" || pwd == "" || email == "" || name == "") {
        alert('請填寫帳號 / 密碼 / email / 姓名');
        return false;
      } else {
        if (email != "") {
          //驗證email格式
          var rule = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

          if (!rule.test(email)) {
            alert('email 格式錯誤囉～～');
            return false;
          }
        }

        return true;
      }
    } else {
      if (account == "" || email == "" || name == "") {
        alert('請填寫帳號 / email / 姓名');
        return false;
      } else {
        if (email != "") {
          //驗證email格式
          var rule = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

          if (!rule.test(email)) {
            alert('email 格式錯誤囉～～');
            return false;
          }
        }
        return true;
      }
    }
  }
  // 確認密碼 Rocky(2020/02/18)
  function CheckPassword(pwd, pwd_check) {
    if (pwd != "" && pwd_check != "") {
      if (pwd != pwd_check) {
        alert('請確認密碼！！！');
        return false;
      } else {
        return true;
      }
    } else {
      return true;
    }
  }
  // 刪除 Rocky(2020/02/18)
  function btn_delete(id) {
    var msg = "是否刪除此筆資料?";
    if (confirm(msg) == true) {
      $.ajax({
        type: 'POST',
        url: 'authority_delete',
        dataType: 'json',
        data: {
          id: id
        },
        success: function(data) {
          if (data['data'] == "ok") {
            // alert('刪除成功！！')
            /** alert **/
            $("#success_alert_text").html("刪除課程成功");
            fade($("#success_alert"));

            location.reload();
          } else {
            // alert('刪除失敗！！')

            /** alert **/
            $("#error_alert_text").html("刪除課程失敗");
            fade($("#error_alert"));
          }
        },
        error: function(error) {
          console.log(JSON.stringify(error));

          /** alert **/
          $("#error_alert_text").html("刪除課程失敗");
          fade($("#error_alert"));
        }
      });
    } else {
      return false;
    }
  }

  // 講師下拉選單 Rocky(2020/05/01)
  function select_teacher() {
    $.ajax({
      type: 'POST',
      url: 'show_teacher',
      dataType: 'json',
      success: function(data) {
        $("#select_teacher").append("<option value=''>請選擇</option>");
        $("#edite_teacher").append("<option value=''>請選擇</option>");
        $.each(data, function(index, item) {
          var id = data[index].id;
          var name = data[index].name;
          $("#select_teacher").append("<option value='" + id + "'>" + name + "</option>");
          $("#edite_teacher").append("<option value='" + id + "'>" + name + "</option>");
        });
      },
      error: function(error) {
        console.log(JSON.stringify(error));
      }
    });
  }

  // 角色下拉選單 Rocky(2020/05/01)
  function select_role() {
    var data_role = [{
        "id": 1,
        "value": "teacher",
        "name": "講師"
      },
      {
        "id": 2,
        "value": "saleser",
        "name": "業務人員"
      },
      {
        "id": 3,
        "value": "msaleser",
        "name": "業務主管"
      },
      {
        "id": 4,
        "value": "officestaff",
        "name": "行政人員"
      },
      {
        "id": 5,
        "value": "staff",
        "name": "臨時人員"
      },
      {
        "id": 6,
        "value": "accountant",
        "name": "財務人員"
      },
      {
        "id": 7,
        "value": "marketer",
        "name": "行銷人員"
      },
      {
        "id": 8,
        "value": "admin",
        "name": "管理員"
      }
    ]

    $("#edite_role").append("<option value=''>請選擇</option>");
    $.each(data_role, function(index, item) {
      var id = data_role[index].value;
      var name = data_role[index].name;

      $("#edite_role").append("<option value='" + id + "'>" + name + "</option>");
    });
  }
</script>
@endsection