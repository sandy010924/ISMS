@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '退費名單')

@section('content')
<!-- Content Start -->

  
  <!-- 同電話學員選項 -->
  <div id="student_option" class="modal fade" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">請選擇自動填入的學員資料</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        </div>
      </div>
    </div>
  </div>
  <!-- 同電話學員選項 -->


  <!--查看退費名單-->
  <div class="card m-3">
    <div class="card-body">
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
            <input type="text" class="form-control bg-white" aria-label="Course name" id="course_name" value="{{ $course->name }}" disabled readonly>
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
            <input type="search" class="form-control px-3" name="daterange" id="daterange" autocomplete="off"> 
          </div>
        </div>
        <div class="col-3 text-right">
          <a role="button" href="{{ route('refund_form',['id_course'=>$course->id]) }}" target="_blank" class="btn btn-outline-secondary mr-3">退費表單連結</a>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#listform_new">新增退費</button>
          <div class="modal fade" id="listform_new" tabindex="-1" role="dialog" aria-labelledby="listform_newLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="form" action="{{ url('course_list_refund_insert') }}" id="form" method="POST">
                  @csrf
                  <input type="hidden" id="course_id" name="course_id" value="{{ $course->id }}">
                  <div class="modal-header">
                    <h5 class="modal-title">新增退費</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-left">
                    <div class="form-group required">
                      <label for="form_date" class="col-form-label">申請退款日期</label>
                      <br/>
                      <div class="input-group date" data-target-input="nearest">
                          <input type="text" id="form_date" name="form_date" class="form-control datetimepicker-input" data-target="#form_date" data-toggle="datetimepicker" autocomplete="off" required/>
                          {{-- <div class="input-group-append" data-target="#form_date" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div> --}}
                      </div>
                    </div>
                    <div class="form-group required">
                      <label for="form_phone" class="col-form-label">聯絡電話</label>
                      <label class="text-secondary px-2 py-1"><small>(填入學員聯絡電話自動帶入姓名、電子郵件)</small></label>
                      {{-- <input type="text" class="form-control" id="form_phone" name="form_phone" required> --}}
                      {{-- <select class="custom-select" id="form_student" name="form_student" required>
                        <option selected disabled value="">選擇學員</option> --}}
                        {{-- @foreach($events as $data)
                          <option value="{{ $data['id_group'] }}">{{ $data['events'] }}</option>
                        @endforeach --}}
                      {{-- </select> --}}
                      <input type="text" class="form-control" id="form_phone" required>
                      {{-- <div class="invalid-feedback">
                        學員尚未報名此課程
                      </div> --}}
                    </div>
                    <div class="form-group">
                      <label for="form_name" class="col-form-label">姓名</label>
                      <input type="hidden" class="form-control" id="form_student" name="form_student">
                      <input type="text" class="form-control" id="form_name" name="form_stuform_namedent" readonly>
                    </div>
                    <div class="form-group">
                      <label for="form_email" class="col-form-label">電子郵件</label>
                      <input type="text" class="form-control" id="form_email" name="form_email" readonly>
                    </div>
                    {{-- <div class="form-group required">
                      <label for="form_events" class="col-form-label">退費場次選擇</label>
                      <select class="custom-select" id="form_events" name="form_events" disabled required>
                        <option selected disabled value="">選擇場次</option>
                        @foreach($events as $data)
                          <option value="{{ $data['id_group'] }}">{{ $data['events'] }}</option>
                        @endforeach
                      </select>
                    </div> --}}
                    {{-- <div class="form-group required">
                      <label for="form_course" class="col-form-label">申請退款課程</label>
                      <input type="text" class="form-control" id="form_student" name="form_student" required>
                      <select class="custom-select" id="form_course" name="form_course" required>
                        <option selected disabled value="">選擇課程</option>
                        @foreach($events as $data)
                          <option value="{{ $data['id_group'] }}">{{ $data['events'] }}</option>
                        @endforeach
                      </select>
                    </div> --}}
                    {{-- <div class="form-group required">
                      <label for="form_course" class="col-form-label">申請退款課程</label>
                      <select class="custom-select" id="form_course" name="form_course" required>
                        <option selected disabled value="">選擇課程</option>
                      </select>
                    </div> --}}
                    <div class="form-group required">
                      <label for="form_reason" class="col-form-label">退費原因</label>
                      <div class="custom-control custom-radio my-1">
                        <input type="radio" class="custom-control-input" id="form_reason1" name="form_reason" value="課程時間無法配合">
                        <label class="custom-control-label" for="form_reason1">課程時間無法配合</label>
                      </div>
                      <div class="custom-control custom-radio my-1">
                        <input type="radio" class="custom-control-input" id="form_reason2" name="form_reason" value="預算不足">
                        <label class="custom-control-label" for="form_reason2">預算不足</label>
                      </div>
                      <div class="custom-control custom-radio my-1">
                        <input type="radio" class="custom-control-input" id="form_reason3" name="form_reason" value="已購買其他相關課程">
                        <label class="custom-control-label" for="form_reason3">已購買其他相關課程</label>
                      </div>
                      <div class="custom-control custom-radio my-1">
                        <input type="radio" class="custom-control-input" id="form_reason4" name="form_reason" value="目前沒有需求">
                        <label class="custom-control-label" for="form_reason4">目前沒有需求</label>
                      </div>
                      <div class="custom-control custom-radio my-1">
                        <input type="radio" class="custom-control-input" id="form_reason5" name="form_reason" value="其他">
                        <label class="custom-control-label" for="form_reason5">其他</label>
                        <input type="text" id="form_reason_other" name="form_reason_other" class="form-control form-control-sm" disabled>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary" id="btn_refund" disabled>確認</button>
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
            <th class="colExcel">當時報名日期</th>
            <th class="colExcel">申請退費日期</th>
            <th class="colExcel">姓名</th>
            <th class="colExcel">聯絡電話</th>
            <th class="colExcel">電子郵件</th>
            <th class="colExcel">申請退款課程</th>
            <th class="colExcel">退費原因</th>
            <th class="colExcel">當時付款方式</th>
            <th class="colExcel">帳號/卡號後五碼</th>
            <th class="colExcel">當時付款金額</th>
            <th class="colExcel" width="10%">審核狀態</th>
            <th></th>
          </tr>
        @endslot
        @slot('tbody')
          @foreach($refund as $key => $data )
            <tr>
              <td>{{ $data['date'] }}</td>
              <td>{{ $data['refund_date'] }}</td>
              <td>{{ $data['name'] }}</td>
              <td>{{ $data['phone'] }}</td>
              <td>{{ $data['email'] }}</td>
              <td>{{ $data['event'] }}</td>
              <td>{{ $data['refund_reason'] }}</td>
              <td>{{ $data['pay_model'] }}</td>
              <td>{{ $data['number'] }}</td>
              <td>{{ $data['refund_cash'] }}</td>
              <td>
                @if( $data['review'] == '0' )
                  <a role="button" class="btn btn-sm btn-secondary text-white btn_review" id="{{ $data['id'] }}" data-val="{{ $data['review'] }}">審核中</a>       
                @else
                  <a role="button" class="btn btn-sm btn-success text-white btn_review" id="{{ $data['id'] }}" data-val="{{ $data['review'] }}">通過</a>
                @endif
              </td>
              <td><a role="button" class="btn btn-danger btn-sm mx-1 text-white" onclick="btn_delete({{ $data['id'] }});">刪除</a></td>
            </tr>
          @endforeach
        @endslot
      @endcomponent
    </div>
  </div>
  <!-- Content End -->
  <style>    
    /* modal層級 */
    .modal:nth-of-type(even) {
      z-index: 1052 !important;
    }

    /* .modal-backdrop.show:nth-of-type(even) {
      z-index: 1051 !important;
    } */

    .modal {
      overflow-y: auto !important;
    }
  </style>

  <script>
    //DataTable
    var table;
    var today = moment(new Date()).format("YYYYMMDD");
    var title = today + '_退費名單' + '_' + $('#course_name').val();
    
    $(document).ready(function() {

      //日期選擇器 Sandy (2020/03/19)
      $('#form_date').datetimepicker({ 
        format: 'YYYY-MM-DD',
        // icons: iconlist,
        defaultDate: moment().format('YYYY-MM-DD'), 
      });


      //select2 場次下拉式搜尋 Sandy(2020/03/19)
      // $("#form_events").select2({
      //     width: 'resolve', // need to override the changed default
      //     theme: 'bootstrap'
      // });

      // $("#form_student").select2({
      //     width: 'resolve', // need to override the changed default
      //     theme: 'bootstrap'
      // });
      // $("#form_course").select2({
      //     width: 'resolve', // need to override the changed default
      //     theme: 'bootstrap'
      // });
      // $.fn.select2.defaults.set( "theme", "bootstrap" );


      //datatable
      table_load();


      /* 日期區間 */
      if ('<?php echo $start ?>' == '' && '<?php echo $end ?>' == '') {
        //沒有資料則關閉區間搜尋
        $('#daterange').prop('disabled', true);;
      } else {
        //有資料設定日期區間
        $('input[name="daterange"]').daterangepicker({
          startDate: '<?php echo $start ?>',
          endDate: '<?php echo $end ?>',
          locale: {
            format: 'YYYY-MM-DD',
            separator: ' ~ ',
            applyLabel: '搜尋',
            cancelLabel: '取消',
          }
        });
      }

      /* 日期區間搜尋 */
      $('#daterange').on('apply.daterangepicker', function(ev, picker) {
        $.fn.dataTable.ext.search.push(
          function(settings, data, dataIndex) {

            var min = picker.startDate.format('YYYY-MM-DD');
            var max = picker.endDate.format('YYYY-MM-DD');

            var startDate = data[0];
            if (startDate <= max && startDate >= min) {
              return true;
            }
            return false;
          });

        table.draw();
      });

      /* 取消日期區間搜尋 */
      $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
        //重設定日期區間(回到預設)
        $('#daterange').data('daterangepicker').setStartDate('<?php echo $start ?>');
        $('#daterange').data('daterangepicker').setEndDate('<?php echo $end ?>');
        
        //取消搜尋
        $.fn.dataTable.ext.search.pop();
        table.draw();
      });

    });


    function table_load(){
      //DataTable
      table=$('#table_list').DataTable({
        "dom": '<Bl<t>p>',
        // columnDefs: [ {
        //   "targets": 'no-sort',
        //   "orderable": false,
        // } ],
        "ordering": false,
        buttons: [{
            extend: 'excel',
            text: '匯出Excel',
            exportOptions: {
                // columns: ':visible',
                columns: '.colExcel'
            },
            title: title,
            // messageTop: $('#course_name').val() + ' 退費名單',
        }]
      });
    }

    $('input[name="form_reason"]').on( "change", function() {
      if($('#form_reason5').prop('checked')){
        $('#form_reason_other').prop("disabled", false);
        $('#form_reason_other').prop("required", true);
      }else{
        $('#form_reason_other').prop("disabled", true);
        $('#form_reason_other').prop("required", false);
      }
    });

    // $('#form_phone').on('blur', function() {
    //   // if (form.checkValidity() === false) {
    //   //     event.preventDefault();
    //   //     event.stopPropagation();
    //   //   }
    //   //   form.classList.add('was-validated');
    //   fill_data($(this).val());
    // });
    $('body').on('blur', '#form_phone', function() {
      var phone = $(this).val();
      fill_data(phone);
    });
    // $('body').on('keyup', '#form_phone', function(e) {
    //   if (e.keyCode === 13) {
    //     var phone = $(this).val();
    //     fill_data(phone);
    //   }
    // });
    // $('#form_phone').on('keyup', function(e) {
    //   // if (form.checkValidity() === false) {
    //   //     event.preventDefault();
    //   //     event.stopPropagation();
    //   //   }
    //   //   form.classList.add('was-validated');
    //   if (e.keyCode === 13) {
    //     fill($(this).val());
    //   }
    // });
    
    //填入資料
    function fill_data(phone){
      var course_id = $("#course_id").val();
      $.ajax({
        type : 'GET',
        url:'course_list_refund_form', 
        // dataType: 'json',    
        data:{
          phone: phone,
          course_id: course_id
        },
        success:function(data){
          // console.log(data);
          
          if( data != 'nodata'){
            if (data.length > 1) {
              $('#student_option').modal('show');
              var option;
              option = `<table class="table table-striped table-sm text-center border rounded-lg dataTable no-footer">
                          <thead>
                            <tr>
                              <th>姓名</th>
                              <th>電話</th>
                              <th>信箱</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                        `;
              for (var i = 0; i < data.length; i++) {
                option += `<tr>
                            <td class="align-middle">${data[i].name}</td>
                            <td class="align-middle">${data[i].phone}</td>
                            <td class="align-middle">${data[i].email}</td>
                            <td class="align-middle">
                              <button id="option_${i}" type="button" class="btn btn-sm btn-primary">選擇</button>
                            </td>
                          </tr>`;
              }

              option += `</tbody></table>`;
              $('#student_option .modal-body').html(option).on('click', 'button', function() {
                //點選按鈕填入學員資料
                // console.log($(this).closest('tr').index());
                option_click(data[$(this).closest('tr').index()]);
              });;

            } else {
              //針對空格做填入 
              $('#form_student').val(data[0].id);
              $('#form_name').val(data[0].name);
              $('#form_email').val(data[0].email);
              $('#btn_refund').prop("disabled", false);              
            }
          }else{
            alert('此學員未報名此課程！');
            $('#btn_refund').prop("disabled", true);
          }

          // $('#form_course').children().remove();

          // if( data['course'].length !=0 ){
          //   var res = '';
          //   $.each (data['course'], function (key, value) {
          //     res +=`'<option id="${value['id']}" value="${value['name']}">${value['name']}</option>'`
          //   });

          //   $('#form_course').html(res);
          //   $('#form_course').attr('disabled', false);   
          // }      
          
        },
        error: function(error){
          console.log(JSON.stringify(error));    
        }
      });
    }

    function option_click(student) {
      $('#form_student').val(student.id);
      $('#form_name').val(student.name);
      $('#form_email').val(student.email);
      $('#btn_refund').prop("disabled", false);

      $('#student_option').modal('hide');
    }


    //form 選擇場次後跳出學員
    // $("#form_events").change(function() {
    //   var id_group = $(this).val();
    //   $.ajax({
    //     type : 'GET',
    //     url:'course_list_refund_form', 
    //     dataType: 'json',    
    //     data:{
    //       id_group: id_group
    //     },
    //     success:function(data){
    //       // console.log(data);
          
    //       $('#form_name').val(value['student']['name']);
    //       $('#form_email').val(value['student']['email']);

    //       $('#form_course').children().remove();

    //       var res = '';
    //       $.each (data, function (key, value) {
    //         res +=`'<option value="${value['course'].id}">${value['course'].name}</option>'`
    //       });

    //       $('#form_course').html(res);
    //       $('#form_course').attr('disabled', false);         
    //     },
    //     error: function(error){
    //       console.log(JSON.stringify(error));    
    //     }
    //   });
    // });
    
    // 刪除 Sandy(2020/03/20) start
    function btn_delete(id_refund){
      var msg = "是否刪除此退費?";
      if (confirm(msg)==true){
        $.ajax({
            type : 'POST',
            url:'course_list_refund_delete', 
            dataType: 'json',    
            data:{
              id_refund: id_refund
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
                $("#error_alert_text").html("刪除失敗");
                fade($("#error_alert"));       
              }           
            },
            error: function(error){
              console.log(JSON.stringify(error));   

              /** alert **/ 
              $("#error_alert_text").html("刪除失敗");
              fade($("#error_alert"));       
            }
        });
      }else{
        return false;
      }    
    }
    // 刪除 Sandy(2020/03/20) end


    /* 審核按鈕 Sandy(2020/06/30) */
    $('body').on('click', '.btn_review', function() {
      var msg = "是否確定更改審核狀態?";
      if (confirm(msg)==true){
        var id = $(this).attr('id');
        var val = $(this).data(val)['val'];
        $.ajax({
          type: 'POST',
          url: 'course_list_refund_review',
          data: {
            id: id,
            val: val
          },
          success: function(data) {
            console.log(data);  

            if( data == 'success' ){
              /** alert **/
              $("#success_alert_text").html("審核狀態修改成功");
              fade($("#success_alert"));
              
              //重整datatable區塊
              $("#datatableDiv").load(window.location.href + " #datatableDiv", function(){
                table_load();
              });
            }else{
              /** alert **/
              $("#error_alert_text").html("審核狀態修改失敗");
              fade($("#error_alert"));
            }
          },
          error: function(jqXHR) {
            console.log("error: " + JSON.stringify(jqXHR));

            /** alert **/
            $("#error_alert_text").html("審核狀態修改失敗");
            fade($("#error_alert"));
          }
        });
      }
    });
    
  </script>
@endsection