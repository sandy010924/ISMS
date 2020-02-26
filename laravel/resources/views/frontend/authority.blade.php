@extends('frontend.layouts.master')

@section('title', '系統設定')
@section('header', '權限管理')

@section('content')
<!-- Content Start -->
       <!--權限管理頁面內容-->
        <div class="card m-3">
          <div class="card-body">            
            <div class="row mb-4">
              <div class="col-4">
                <button type="button" class="btn btn-outline-secondary btn_date mx-1" data-toggle="modal" data-target="#form_newuser">新增</button>
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
                        <form action="{{url('authority_insert')}}" name="insert" method="POST" >
                          @csrf
                          <div class="form-group">
                            <label for="newuser_account" class="col-form-label">帳號</label>
                            <input type="text" class="form-control" id="newuser_account" name="account" required>
                          </div>
                          <div class="form-group">
                                <label for="newuser_password" class="col-form-label">密碼</label>
                                <input type="password" class="form-control" id="newuser_password" name="password" required>
                              </div>
                              <div class="form-group">
                                <label for="newuser_password2" class="col-form-label">確認密碼</label>
                                <input type="password" class="form-control" id="newuser_password2" name="password_check" data-match="#newuser_password" required>
                              </div>
                          <div class="form-group">
                            <label for="newuser_name" class="col-form-label">姓名</label>
                            <input type="text" class="form-control" id="newuser_name" name="name" required>
                          </div>
                          <div class="form-group">
                            <label for="newuser_persona" class="col-form-label">角色</label>
                            <select class="custom-select form-control" id="newuser_persona" name="newuser_persona" required>
                              <option value="teacher">講師</option>
                              <option value="staff">現場人員</option>
                              <option value="accountant">財會人員</option>
                              <option value="marketer">行銷人員</option>
                              <option value="dataanalysis">數據分析人員</option>
                              <option value="admin">管理員</option>
                            </select>
                          </div>                          
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                          <button type="submit" id="import_check" class="btn btn-primary" onclick="CheckPassword(document.insert.password,document.insert.password_check)">確認</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-7">
                {{-- <form action="{{url('authority_search')}}" method="GET" role="search">
                  @csrf --}}
                  <div class="input-group">
                    <div class="col-md-4">
                      <input type="search" class="form-control" name="name" placeholder="搜尋姓名" aria-describedby="btn_search" id="search_keyword">
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <select class="custom-select form-control" id="search_role" name="search_role">
                          <option value="">請選擇</option>
                          <option value="講師">講師</option>
                          <option value="現場人員">現場人員</option>
                          <option value="財會人員">財會人員</option>
                          <option value="行銷人員">行銷人員</option>
                          <option value="數據分析人員">數據分析人員</option>
                          <option value="管理員">管理員</option>
                        </select>
                      </div> 
                    </div>
                    <div class="col-md-3">
                      <button type="button" class="btn btn-outline-secondary" id="btn_search">搜尋</button>
                    </div>
                  </div>
                {{-- </form> --}}
              </div>
            </div>
            @component('components.datatable')
              @slot('thead')
                <tr>
                  <th>帳號</th>
                  <th>姓名</th>
                  <th>角色</th>
                  <th class="no-sort"></th>
                </tr>
              @endslot
              @slot('tbody')
                @foreach($datas as $key => $data )
                  <tr>
                    <td>{{ $data['account'] }}</td> 
                    <td>{{ $data['name'] }}</td>
                    <td>{{ $data['role_name'] }}</td>
                    <td>
                      <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#e{{ $data['id'] }}">修改</button>
                      <div class="modal fade text-left" id="e{{ $data['id'] }}" tabindex="-1" role="dialog" aria-labelledby="form_updateuserLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="form_newclassLabel">修改資料</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('authority_update')}}" method="POST" role="update" data-toggle="validator">
                                @csrf
                                  <input type="hidden" name="id" value="{{ $data['id'] }}">
                                  <div class="form-group">
                                    <label for="updateuser_account" class="col-form-label">帳號</label>
                                    <input type="text" class="form-control" name="account" value="{{ $data['account'] }}" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="updateuser_password" class="col-form-label">密碼</label>
                                    <input type="password" class="form-control"  name="password">
                                  </div>
                                  <div class="form-group">
                                    <label for="updateuser_password2" class="col-form-label">確認密碼</label>
                                    <input type="password" class="form-control"  name="password_check"  data-match="#updateuser_password" >
                                  </div>
                                  <div class="form-group">
                                    <label for="updateuser_name" class="col-form-label">姓名</label>
                                    <input type="text" class="form-control"  name="name" value="{{ $data['name'] }}" required>
                                  </div>
                                  <div class="form-group">
                                    <label  class="col-form-label">角色</label>    
                                                                  
                                    <select class="custom-select form-control"  name="updateuser_persona" required="required">
                                      <option @if($data['role'] == 'teacher') selected  @endif value="teacher">講師</option>
                                      <option @if($data['role'] == 'staff') selected  @endif value="staff">現場人員</option>
                                      <option @if($data['role'] == 'accountant') selected  @endif value="accountant">財會人員</option>
                                      <option @if($data['role'] == 'marketer') selected  @endif value="marketer">行銷人員</option>
                                      <option @if($data['role'] == 'dataanalysis') selected  @endif value="dataanalysis">數據分析人員</option>
                                      <option @if($data['role'] == 'admin') selected  @endif value="admin" >管理員</option>
                                    </select>
                                  </div>  
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                                    <button type="submit"  class="btn btn-primary">確認</button>
                                  </div>
                                </form>
                              </div>
                          </div>
                        </div>
                      </div>
                      <!-- <button type="button" class="btn btn-secondary btn-sm">刪除</button> -->
                      <button id="{{ $data['id'] }}" class="btn btn-danger btn-sm mx-1" onclick="btn_delete({{ $data['id'] }});" value="{{ $data['id'] }}" >刪除</button>
                    </td>
                  </tr>
                @endforeach
              @endslot
            @endcomponent                          
            {{-- <div class="table-responsive">
              <table id="table_list" class="table table-striped table-sm text-center border rounded-lg">
                <thead>
                  <tr>
                    <th>帳號</th>
                    <th>姓名</th>
                    <th>角色</th>
                    <th class="no-sort"></th>
                  </tr>
                </thead>
                <tbody>                  
                @foreach($datas as $key => $data )
                  <tr>
                    <td>{{ $data['account'] }}</td> 
                    <td>{{ $data['name'] }}</td>
                    <td>{{ $data['role_name'] }}</td>
                    <td>
                      <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#e{{ $data['id'] }}">修改</button>
                      <div class="modal fade text-left" id="e{{ $data['id'] }}" tabindex="-1" role="dialog" aria-labelledby="form_updateuserLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="form_newclassLabel">修改資料</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('authority_update')}}" method="POST" role="update" data-toggle="validator">
                                @csrf
                                  <input type="hidden" name="id" value="{{ $data['id'] }}">
                                  <div class="form-group">
                                    <label for="updateuser_account" class="col-form-label">帳號</label>
                                    <input type="text" class="form-control" name="account" value="{{ $data['account'] }}" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="updateuser_password" class="col-form-label">密碼</label>
                                    <input type="password" class="form-control"  name="password">
                                  </div>
                                  <div class="form-group">
                                    <label for="updateuser_password2" class="col-form-label">確認密碼</label>
                                    <input type="password" class="form-control"  name="password_check"  data-match="#updateuser_password" >
                                  </div>
                                  <div class="form-group">
                                    <label for="updateuser_name" class="col-form-label">姓名</label>
                                    <input type="text" class="form-control"  name="name" value="{{ $data['name'] }}" required>
                                  </div>
                                  <div class="form-group">
                                    <label  class="col-form-label">角色</label>    
                                                                  
                                    <select class="custom-select form-control"  name="updateuser_persona" required="required">
                                      <option @if($data['role'] == 'teacher') selected  @endif value="teacher">講師</option>
                                      <option @if($data['role'] == 'staff') selected  @endif value="staff">現場人員</option>
                                      <option @if($data['role'] == 'accountant') selected  @endif value="accountant">財會人員</option>
                                      <option @if($data['role'] == 'marketer') selected  @endif value="marketer">行銷人員</option>
                                      <option @if($data['role'] == 'dataanalysis') selected  @endif value="dataanalysis">數據分析人員</option>
                                      <option @if($data['role'] == 'admin') selected  @endif value="admin" >管理員</option>
                                    </select>
                                  </div>  
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                                    <button type="submit"  class="btn btn-primary">確認</button>
                                  </div>
                                </form>
                              </div>
                            
                          </div>
                        </div>
                      </div>
                      <!-- <button type="button" class="btn btn-secondary btn-sm">刪除</button> -->
                      <button id="{{ $data['id'] }}" class="btn btn-danger btn-sm mx-1" onclick="btn_delete({{ $data['id'] }});" value="{{ $data['id'] }}" >刪除</button>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div> --}}
            <div class="row">
              <div class="col-md-5">
              </div>
              <div class="col-md-4">
                <div class="pull-right">
                  {!! $datas->appends(Request::except('page'))->render() !!} 
                </div>
              </div>
            </div>  
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
  var table;
  //針對姓名與角色搜尋 Sandy(2020/02/26)
  $.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
      var keyword = $('#search_keyword').val();
      var role = $('#search_role').val();
      var tname = data[1]; 
      var trole = data[2]; 

      if ( (isNaN( keyword ) && isNaN( role )) || ( tname.includes(keyword) && isNaN( role ) ) || ( trole.includes(role) && isNaN( keyword ) ) || ( trole.includes(role) && tname.includes(keyword) ) ){
        return true;
      }

      return false;
    }
  );

  $("document").ready(function(){
    // Sandy (2020/02/26)
    table = $('#table_list').DataTable({
        "dom": '<l<t>p>',
        "columnDefs": [ {
          "targets": 'no-sort',
          "orderable": false,
        } ]
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
  
  $("#btn_search").click(function(){
    table.columns(1).search($('#search_keyword').val()).columns(2).search($("#search_role").val()).draw();
  });
  // Sandy(2020/02/26) dt列表搜尋 E


  // 確認密碼 Rocky(2020/02/18)
  function CheckPassword(pwd,pwd_check) 
  { 
    console.log(pwd.value + "\n") 
    console.log(pwd_check.value)
    if (pwd.value != pwd_check.value) {
      alert('請確認密碼！！！');
      window.event.returnValue = false
    } else {
      window.event.returnValue = true
    }
  }
  // 刪除 Rocky(2020/02/18)
  function btn_delete(id){
    var msg = "是否刪除此筆資料?";
    if (confirm(msg)==true){
      $.ajax({
          type : 'POST',
          url:'authority_delete', 
          dataType: 'json',    
          data:{
            id: id
          },
          success:function(data){
            if (data['data'] == "ok") {                           
              // alert('刪除成功！！')
              /** alert **/
              $("#success_alert_text").html("刪除課程成功");
              fade($("#success_alert"));

              location.reload();
            }　else {
              // alert('刪除失敗！！')

              /** alert **/ 
              $("#error_alert_text").html("刪除課程失敗");
              fade($("#error_alert"));       
            }           
          },
          error: function(error){
            console.log(JSON.stringify(error));   

            /** alert **/ 
            $("#error_alert_text").html("刪除課程失敗");
            fade($("#error_alert"));       
          }
      });
    }else{
    return false;
    }    
  }
</script>
@endsection