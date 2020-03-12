@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '課程管理')

@section('content')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" /> --}}
{{-- <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> --}}

  <!-- Content Start -->
    <!--課程管理內容-->
    <div class="card m-3">
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-4">
              <button type="button" class="btn btn-outline-secondary mr-3" data-toggle="modal" data-target="#listform_new">新增課程</button>
              <div class="modal fade" id="listform_new" tabindex="-1" role="dialog" aria-labelledby="listform_newLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <form class="form" action="{{ url('course_list_insert') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="modal-header">
                        <h5 class="modal-title">新增課程</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group required">
                          <label for="new_name" class="col-form-label">課程名稱</label>
                          <input type="text" id="new_name" name="new_name" class="form-control" required>
                        </div>
                        <div class="form-group required">
                          <label for="new_teacher" class="col-form-label">講師名稱</label>
                          <select class="custom-select" id="new_teacher" name="new_teacher" required>
                            <option selected disabled value="">選擇講師</option>
                            @foreach($teachers as $teacher)
                              <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group required">
                          <label for="new_type" class="col-form-label">類型</label>
                          <select class="custom-select" id="new_type" name="new_type" required>
                            <option selected disabled value="">選擇類型</option>
                            <option value="1">銷講</option>
                            <option value="2">二階課程</option>
                            <option value="3">三階課程</option>
                            <option value="4">活動</option>
                          </select>
                        </div>
                        <div id="sales" style="display:none">
                          <div class="form-group required">
                            <label for="new_flie" class="col-form-label">上傳檔案</label>
                            <div class="custom-file">
                              <label class="custom-file-label" for="new_flie">瀏覽檔案</label>
                              <input type="file" class="custom-file-input" id="new_flie" name="new_flie" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required/>
                            </div>
                          </div>
                        </div>
                        <div id="formal" style="display:none">
                          <div class="form-group required">
                            <label for="new_location" class="col-form-label">地點</label>
                            <input type="text" id="new_location" name="new_location" class="form-control" required />
                          </div>
                          <div class="form-group required">
                            <label for="new_date" class="col-form-label">課程日期</label>
                            <label class="text-secondary px-2 py-1"><small>(可多選)</small></label>
                            <br/>
                            <div class="input-group date" id="new_date" data-target-input="nearest">
                                <input type="text" name="new_date" class="form-control datetimepicker-input" data-target="#new_date" required/>
                                <div class="input-group-append" data-target="#new_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="col-md-6 mb-3 required">
                              <label for="new_starttime" class="col-form-label">課程開始時間</label><br/>
                              <div class="input-group date" id="new_starttime" data-target-input="nearest">
                                  <input type="text" name="new_starttime" class="form-control datetimepicker-input" data-target="#new_starttime" required/>
                                  <div class="input-group-append" data-target="#new_starttime" data-toggle="datetimepicker">
                                      <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                  </div>
                              </div>
                            </div>
                            <div class="col-md-6 mb-3 required">
                              <label for="new_endtime" class="col-form-label">課程結束時間</label><br/>
                              <div class="input-group date" id="new_endtime" data-target-input="nearest">
                                  <input type="text" name="new_endtime" class="form-control datetimepicker-input" data-target="#new_endtime" required/>
                                  <div class="input-group-append" data-target="#new_endtime" data-toggle="datetimepicker">
                                      <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group required">
                            <label for="new_event" class="col-form-label">場次</label><br/>
                            <input type="search" list="events" id="new_event" name="new_event" class="form-control" required />
                            <datalist class="w-100" id="events">
                              <option value="台北場"></option>
                              <option value="台北上午場"></option>
                              <option value="台北下午場"></option>
                              <option value="台北晚上場"></option>
                              <option value="台中場"></option>
                              <option value="台中上午場"></option>
                              <option value="台中下午場"></option>
                              <option value="台中晚上場"></option>
                              <option value="高雄場"></option>
                              <option value="高雄上午場"></option>
                              <option value="高雄下午場"></option>
                              <option value="高雄晚上場"></option>
                            </datalist>
                          </div>
                        </div> 
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary">確認</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
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
          @component('components.datatable')
            @slot('thead')
              <tr>
                <th>講師姓名</th>
                <th>類別</th>
                <th>課程名稱</th>
                <th class="no-sort">表單上場次數</th>
                <th class="no-sort">總場次數</th>
                <th class="no-sort">累計名單</th>
                <th class="no-sort"></th>
              </tr>
            @endslot
            @slot('tbody')
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
                        <a role="button" class="dropdown-item" href="{{ route('course_list_apply', [ 'id' => $course['id'] ]) }}">報名名單</a>
                        <a role="button" class="dropdown-item" href="{{ route('course_list_refund') }}">退費名單</a>
                      </div>
                      <a role="button" class="btn btn-secondary btn-sm mx-1" href="{{ route('course_list_data', [ 'id' => $course['id'] ] ) }}">場次數據</a>
                      <a role="button" class="btn btn-secondary btn-sm mx-1" href="{{ route('course_list_edit', [ 'id' => $course['id'] ] ) }}">編輯</a>
                      {{-- <a role="button" class="btn btn-danger btn-sm mx-1 text-white" onclick="btn_delete({{ $course['all_id'] }});" value="{{ $course['all_id'] }}" >刪除</a> --}}
                      <a role="button" class="btn btn-danger btn-sm mx-1 text-white" onclick="btn_delete({{ $course['id'] }});">刪除</a>
                  </td>
                </tr>
              @endforeach
            @endslot
          @endcomponent
      </div>
    </div>

    <!-- alert Start-->
    <div class="alert alert-success alert-dismissible m-3 position-fixed fixed-bottom" role="alert" id="success_alert">
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

  <!-- Content End -->
  <script>
    var table;
    $(document).ready(function() {
      // Rocky(2020/01/06)
      $("#new_flie").change(function(){
        var i = $(this).prev('label').clone();
        var file = $('#new_flie')[0].files[0].name;
        $(this).prev('label').text(file);
      });

      //新增課程 選擇銷講/正課 Sandy (2020/02/26)
      $("select#new_type"). change(function(){
        if( $("#new_type").val() == 1 ){
          $('#sales').show();
          $('#formal').hide();
          $("#sales").find("input").prop('required',true);
          $("#formal").find("input").removeAttr('required');
        }else if( $("#new_type").val() == 2 || $("#new_type").val() == 3 ){
          $('#sales').hide();
          $('#formal').show();
          $("#sales").find("input").removeAttr('required');
          $("#formal").find("input").prop('required',true);
        }
      });

      //日期&g時間選擇器 Sandy (2020/02/27)
       var iconlist = {  time: 'fas fa-clock',
                      date: 'fas fa-calendar',
                      up: 'fas fa-arrow-up',
                      down: 'fas fa-arrow-down',
                      previous: 'fas fa-arrow-circle-left',
                      next: 'fas fa-arrow-circle-right',
                      today: 'far fa-calendar-check-o',
                      clear: 'fas fa-trash',
                      close: 'far fa-times' } 
      $('#new_date').datetimepicker({ 
        format: 'YYYY-MM-DD',
        icons: iconlist, 
        allowMultidate: true, 
        multidateSeparator: ','
      });
      $('#new_starttime').datetimepicker({ 
        format: 'HH:mm',
        icons: iconlist
      });
      $('#new_endtime').datetimepicker({ 
        format: 'HH:mm',
        icons: iconlist
      });

      //DataTable
      table=$('#table_list').DataTable({
        "dom": '<l<t>p>',
        "columnDefs": [ {
          "targets": 'no-sort',
          "orderable": false,
        } ]
      });
    });

    // Sandy(2020/02/26) dt列表搜尋 S
    $('#search_name').on('keyup', function(e) {
      if (e.keyCode === 13) {
        $('#btn_search').click();
      }
    });
    $("#btn_search").click(function(){
      table.columns(2).search($("#search_name").val()).draw();
    });
    // Sandy(2020/02/26) dt列表搜尋 E

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
