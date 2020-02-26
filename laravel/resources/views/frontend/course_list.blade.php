@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '課程管理')

@section('content')
  <!-- Content Start -->
    <!--課程管理內容-->
    <div class="card m-3">
      <div class="card-body">
        <div class="row mb-3">
        <div class="col-4 mx-3">
            <button type="button" class="btn btn-outline-secondary mr-3" data-toggle="modal" data-target="#listform_newclass">新增課程</button>
            <div class="modal fade" id="listform_newclass" tabindex="-1" role="dialog" aria-labelledby="listform_newclassLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">新增課程</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form>
                      @csrf
                        <div class="form-group">
                          <label for="newclass_teacher" class="col-form-label">講師名稱</label>
                          <input type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                          <label for="newclass_name" class="col-form-label">課程名稱</label>
                          <input type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                          <label for="newclass_days" class="col-form-label">課程天數</label><br/>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="newclass_oneday" name="newclass_days">
                            <label class="custom-control-label" for="newclass_oneday">一天</label>
                          </div>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="newclass_twodays" name="newclass_days">
                            <label class="custom-control-label" for="newclass_twodays">兩天</label>
                          </div>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="newclass_threedays" name="newclass_days">
                            <label class="custom-control-label" for="newclass_threedays">三天</label>
                          </div>
                        </div>  
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary">確認</button>
                  </div>
                </div>
              </div>
            </div>
            <button type="button" class="btn btn-outline-secondary mr-3" data-toggle="modal" data-target="#form_newclass">新增報名表</button>
          </div>
          <div class="col-6 mx-3">
            <div class="input-group">
              <input type="search" class="form-control" placeholder="搜尋課程" aria-describedby="btn_search" id="search_name">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button>
              </div>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table id="table_list" class="table table-striped table-sm text-center">
            <thead>
                <tr>
                    <th>講師姓名</th>
                    <th>類別</th>
                    <th>課程名稱</th>
                    <th class="no-sort">表單上場次數</th>
                    <th class="no-sort">總場次數</th>
                    <th class="no-sort">累計名單</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
            <tbody>
              @foreach($courses as $key => $course )
              <tr>
                <td>{{ $course['teacher'] }}</td>
                <td>{{ $course['type'] }}</td>
                <td>{{ $course['course'] }}</td>
                <td>{{ $course['count_form'] }}</td>
                <td>{{ $course['count_events'] }}</td>
                <td>{{ $course['count_list'] }}</td>
                <td>
                    <a role="button" class="btn btn-secondary btn-sm mx-1 text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      名單
                    </a>
                    <div class="dropdown-menu dropdown_status" aria-labelledby="dropdownMenu2">
                      <a role="button" class="dropdown-item" href="{{ route('course_list_apply') }}">報名名單</a>
                      <a role="button" class="dropdown-item" href="{{ route('course_list_refund') }}">退費名單</a>
                    </div>
                    <a role="button" class="btn btn-secondary btn-sm mx-1" href="{{ route('course_list_data') }}">場次數據</a>
                    <a role="button" class="btn btn-secondary btn-sm mx-1" href="{{ route('course_list_edit') }}">編輯</a>
                    <a role="button" class="btn btn-danger btn-sm mx-1 text-white" onclick="btn_delete({{ $course['all_id'] }});" value="{{ $course['all_id'] }}" >刪除</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {{-- <table class="table table-striped table-sm text-center">
            <thead>
              <tr>
                <th>講師姓名</th>
                <th>類別</th>
                <th>課程名稱</th>
                <th>表單上場次數</th>
                <th>總場次數</th>
                <th>累計名單</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="table_list">
              @foreach($courses as $key => $course )
              <tr>
                <td>{{ $course['teacher'] }}</td>
                <td>{{ $course['type'] }}</td>
                <td>{{ $course['course'] }}</td>
                <td>{{ $course['count_form'] }}</td>
                <td>{{ $course['count_events'] }}</td>
                <td>{{ $course['count_list'] }}</td>
                <td>
                    <a role="button" class="btn btn-secondary btn-sm mx-1 text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      名單
                    </a>
                    <div class="dropdown-menu dropdown_status" aria-labelledby="dropdownMenu2">
                      <a role="button" class="dropdown-item" href="{{ route('course_list_apply') }}">報名名單</a>
                      <a role="button" class="dropdown-item" href="{{ route('course_list_refund') }}">退費名單</a>
                    </div>
                    <a role="button" class="btn btn-secondary btn-sm mx-1" href="{{ route('course_list_data') }}">場次數據</a>
                    <a role="button" class="btn btn-secondary btn-sm mx-1" href="{{ route('course_list_edit') }}">編輯</a>
                    <a role="button" class="btn btn-danger btn-sm mx-1 text-white" onclick="btn_delete({{ $course['all_id'] }});" value="{{ $course['all_id'] }}" >刪除</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table> --}}
        </div>
      </div>
    </div>
  <!-- Content End -->

  <script>

    // Sandy(2020/02/26) dt列表搜尋 S
    var table;

    $(document).ready(function() {
         table=$('#table_list').DataTable({
          "dom": '<l<t>p>',
          "columnDefs": [ {
            "targets": 'no-sort',
            "orderable": false,
          } ]
      });
    });

    $('#search_name').on('keyup', function(e) {
      if (e.keyCode === 13) {
        $('#btn_search').click();
      }
    });

    $("#btn_search").click(function(){
      table.columns(2).search($("#search_name").val()).draw();
    });
    // Sandy(2020/02/26) dt列表搜尋 E

    // Sandy(2020/02/25) 列表搜尋start
    // $("#btn_search").click(function(){
    //   var search_name = $("#search_name").val();
    //   $.ajax({
    //       type : 'GET',
    //       url:'course_list_search', 
    //       dataType: 'json',    
    //       data:{
    //         search_name: search_name
    //       },
    //       success:function(data){
    //         // console.log(data);
            
    //         $('#table_list').children().remove();
    //         var res = ``;
    //         $.each (data, function (key, value) {
    //           res +=`
    //           <tr>
    //             <td>${ value.teacher }</td>
    //             <td>${ value.type }</td>
    //             <td>${ value.course }</td>
    //             <td>${ value.count_form }</td>
    //             <td>${ value.count_events }</td>
    //             <td>${ value.count_list }</td>
    //             <td>
    //                 <a role="button" class="btn btn-secondary btn-sm mx-1 text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    //                   名單
    //                 </a>
    //                 <div class="dropdown-menu dropdown_status" aria-labelledby="dropdownMenu2">
    //                   <a role="button" class="dropdown-item" href="{{ route('course_list_apply') }}">報名名單</a>
    //                   <a role="button" class="dropdown-item" href="{{ route('course_list_refund') }}">退費名單</a>
    //                 </div>
    //                 <a role="button" class="btn btn-secondary btn-sm mx-1" href="{{ route('course_list_data') }}">場次數據</a>
    //                 <a role="button" class="btn btn-secondary btn-sm mx-1" href="{{ route('course_list_edit') }}">編輯</a>
    //                 <a role="button" id="${ value.course_id }" class="btn btn-danger btn-sm mx-1 text-white" onclick="btn_delete(${ value.course_id });" value="${ value.course_id }" >刪除</a>
    //             </td>
    //           </tr>`
    //         });

    //         $('#table_list').html(res);

    //       },
    //       error: function(jqXHR){
    //          console.log('error: ' + JSON.stringify(jqXHR));
    //       }
    //     });
    //   });
    // Sandy 列表搜尋end

    // 刪除 Sandy(2020/02/25) start
    function btn_delete(id_course){
      var msg = "是否刪除此課程?";
      if (confirm(msg)==true){
        $.ajax({
            type : 'POST',
            url:'course_list_delete', 
            dataType: 'json',    
            data:{
              id_course: id_course
            },
            success:function(data){
              console.log(data);
              if (data['data'] == "ok") {                           
                alert('刪除成功！！')
                /** alert **/
                // $("#success_alert_text").html("刪除課程成功");
                // fade($("#success_alert"));

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
    // 刪除 Sandy(2020/02/25) end

  </script>
  
@endsection
