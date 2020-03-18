@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '退費名單')

@section('content')
<!-- Content Start -->
  <!--查看退費名單-->
  <div class="card m-3">
    <div class="card-body">
      {{-- <div class="row">
        <div class="col-3 align-middle">
          <h6>
            講師名稱<input type="text" class="mt-2" readonly>
          </h6>
        </div>
        <div class="col-3 align-middle">
          <h6>
            課程名稱<input type="text" class="mt-2" readonly>
          </h6>
        </div>
        <div class="col-3 text-right">
          <h6>累計名單 : <input type="text" class="mt-2" style="border:0;"readonly></h6>
        </div>
        <hr/>
      </div>  --}}
      <div class="row">
        <div class="col-3">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">講師名稱</span>
            </div>
            <input type="text" class="form-control bg-white" aria-label="Teacher name" value="{{ $course->teacher }}" disabled readonly>
          </div>
        </div>
        <div class="col-5">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">課程名稱</span>
            </div>
            <input type="text" class="form-control bg-white" aria-label="Course name" value="{{ $course->name }}" disabled readonly>
          </div>
        </div>
        <div class="col px-5 text-right align-self-center">
          <h6 class="mb-0">累積筆數 : {{ count($refund) }} </h6>
        </div>
      </div>
    </div>
  </div>
  <div class="card m-3">
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-3"></div>
        <div class="col-5 mx-auto">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">日期區間</span>
            </div>
            <input type="text" class="form-control px-3" name="daterange"> 
          </div>
        </div>
        <div class="col-3 text-right">
          <button type="button" class="btn btn-outline-secondary mr-3" data-toggle="modal" data-target="#listform_new">新增退費</button>
          <div class="modal fade" id="listform_new" tabindex="-1" role="dialog" aria-labelledby="listform_newLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="form" action="{{ url('course_list_insert') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title">新增退費</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-left">
                    <div class="form-group required">
                      <label for="form_date" class="col-form-label">申請退費日期</label>
                      <br/>
                      <div class="input-group date" id="form_date" data-target-input="nearest">
                          <input type="text" name="form_date" class="form-control datetimepicker-input" data-target="#form_date" required/>
                          <div class="input-group-append" data-target="#form_date" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
                    </div>
                    <div class="form-group required">
                      <label for="form_events" class="col-form-label">退費場次選擇</label>
                      <select class="custom-select" id="form_events" name="form_events" required>
                        <option selected disabled value="">選擇場次</option>
                        @foreach($events as $data)
                          <option value="{{ $data['id_group'] }}">{{ $data['events'] }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group required">
                      <label for="form_student" class="col-form-label">退費學員選擇</label>
                      <label class="text-secondary px-2 py-1"><small>(請先選擇退費場次)</small></label>
                      <select class="custom-select" id="form_student" name="form_student" disabled required>
                        <option selected disabled value="">選擇學員</option>
                        {{-- @foreach($events as $data)
                          <option value="{{ $data['id_group'] }}">{{ $data['events'] }}</option>
                        @endforeach --}}
                      </select>
                    </div>
                    <div class="form-group required">
                      <label for="form_reason" class="col-form-label">退費原因</label>
                      <input type="text" id="form_reason" name="form_reason" class="form-control" required>
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
      </div>
      @component('components.datatable')
        @slot('thead')
          <tr>
            <th>Submission Date</th>
            <th>申請退費日期</th>
            <th>姓名</th>
            <th>聯絡電話</th>
            <th>電子郵件</th>
            <th>申請退款課程</th>
            <th>退費原因</th>
            <th>當時付款方式</th>
            <th>帳號/卡號後五碼</th>
            <th class="no-sort"></th>
          </tr>
        @endslot
        @slot('tbody')
          @foreach($refund as $key => $data )
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td><a href="#"><button type="button" class="btn btn-danger btn-sm mx-1">刪除</button></a></td>
            </tr>
          @endforeach
        @endslot
      @endcomponent
      {{-- <div class="table-responsive">
        <table class="table table-striped table-sm text-center" id="table_apply">
        <thead>
            <tr>
              <th>Submission Date</th>
              <th>申請退費日期</th>
              <th>姓名</th>
              <th>聯絡電話</th>
              <th>電子郵件</th>
              <th>申請退款課程</th>
              <th>退費原因</th>
              <th>當時付款方式</th>
              <th>帳號/卡號後五碼</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td><a href="#"><button type="button" class="btn btn-secondary btn-sm">刪除</button></a></td>
            </tr>
          </tbody>
        </table>
      </div> --}}
    </div>
  </div>
  <!-- Content End -->
  <script>
    //DataTable
    var table;
    
    $(document).ready(function() {
      //日期區間
      $('input[name="daterange"]').daterangepicker({
        locale: {
          format: 'YYYY-MM-DD',
          separator: ' 至 '
        }
      }, function(start, end, label) {
        console.log(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
      });

      //日期選擇器 Sandy (2020/03/19)
      $('#form_date').datetimepicker({ 
        format: 'YYYY-MM-DD',
        // icons: iconlist, 
      });

      //DataTable
      table=$('#table_list').DataTable({
        "dom": '<l<t>p>',
        columnDefs: [ {
          "targets": 'no-sort',
          "orderable": false,
        } ]
      });

      //select2 場次下拉式搜尋 Sandy(2020/03/19)
      $("#form_events").select2({
          width: 'resolve', // need to override the changed default
          theme: 'bootstrap'
      });

      $("#form_student").select2({
          width: 'resolve', // need to override the changed default
          theme: 'bootstrap'
      });
      $.fn.select2.defaults.set( "theme", "bootstrap" );

      //form 選擇場次後跳出學員
      $("#form_events").change(function() {
        var id_group = $(this).val();
        $.ajax({
          type : 'GET',
          url:'course_list_refund_form', 
          dataType: 'json',    
          data:{
            id_group: id_group
          },
          success:function(data){
            // console.log(data);

            $('#form_student').children().remove();

            var res = '';
            $.each (data, function (key, value) {
              res +=`'<option value="${value.id_group}">${value.name}</option>'`
            });

            $('#form_student').html(res);
            $('#form_student').attr('disabled', false);         
          },
          error: function(error){
            console.log(JSON.stringify(error));    
          }
        });
          


      });


    });
  </script>
@endsection