@extends('frontend.layouts.master')

@section('title', '訊息推播')
@section('header', '建立訊息')

@section('content')

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" /> --}}
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<!-- Content Start -->
       <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <form style="padding: 10px 50px;">
              <input type="hidden" id="id_message" value="{{ $message['id'] }}">
              <div class="form-group required">
                <label class="col-form-label">發送方式</label>
                <div class="d-block" id="sendCheckBox">
                  <div class="custom-control custom-checkbox custom-control-inline">
                    @if( $message['type'] != "" && $message['type'] == 0 || $message['type'] == 2)
                      <input type="checkbox" class="custom-control-input" id="messageCheckBox" name="sendCheckBox" value="sms" checked>
                    @else
                      <input type="checkbox" class="custom-control-input" id="messageCheckBox" name="sendCheckBox" value="sms">
                    @endif
                    <label class="custom-control-label" for="messageCheckBox">簡訊</label>
                    {{-- <input type="checkbox" id="messageCheckBox">
                    <label class="form-check-label" for="messageCheckBox">簡訊</label> --}}
                  </div>
                  <div class="custom-control custom-checkbox custom-control-inline">
                    @if($message['type'] == 1 || $message['type'] == 2)
                      <input type="checkbox" class="custom-control-input" id="mailCheckBox" name="sendCheckBox" value="email" checked>
                    @else
                      <input type="checkbox" class="custom-control-input" id="mailCheckBox" name="sendCheckBox" value="email">
                    @endif
                    <label class="custom-control-label" for="mailCheckBox">E-mail</label>
                    {{-- <input type="checkbox" id="mailCheckBox">
                    <label class="form-check-label" for="mailCheckBox">E-mail</label> --}}
                  </div>
                </div>
                <div class="invalid-feedback">
                  請選擇至少一項發送方式
                </div>
                <small id="emailHelp" class="form-text " style="color:#888;">若選擇簡訊發送、簡訊及Email發送皆只能輸入純文字(不可包含圖片及表格)。只有選擇Email發送才可使用圖片及表格。</small>
              </div>

              <div class="form-group required">
                <label class="col-form-label" for="receiverPhone">訊息名稱</label>
                <input type="text" class="form-control" id="msgTitle" name="msgTitle" placeholder="請輸入訊息名稱 ..." value="{{ $message['name'] }}">
                <div class="invalid-feedback">
                  請輸入訊息名稱
                </div>
              </div>

              <div class="form-group">
                <label class="col-form-label" for="receiverPhone">講師選擇</label>
                <select class="custom-select" id="msgTeacher" name="msgTeacher">
                  <option selected value="">選擇講師</option>
                  @foreach($teacher as $data)
                    @if( $message['id_teacher'] == $data['id'] )
                      <option value="{{ $data['id'] }}" selected>{{ $data['name'] }}</option>
                    @else
                      <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
                    @endif
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label class="col-form-label" for="receiverPhone">課程選擇</label>
                <select class="custom-select" id="msgCourse" name="msgCourse">
                  <option selected value="">選擇課程</option>
                  @foreach($course as $data)
                    @if( $message['id_course'] == $data['id'] )
                      <option value="{{ $data['id'] }}" selected>{{ $data['name'] }}</option>
                    @else
                      <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
                    @endif
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label class="col-form-label" for="">發送對象</label>
                <div>
                  <input id="groupDetailBtn" type="button" class="btn btn-sm btn-secondary" value="細分組搜尋" data-toggle="modal" data-target="#messageModal">
                </div>
              </div>

              <div class="form-group">
                <label class="col-form-label" for="receiverPhone">收件者手機號碼</label>
                <!-- <input id="receiverPhoneMultiBtn" type="button" value="多選" data-toggle="modal" data-target="#messageModal"> -->
                <input type="text" class="form-control" id="receiverPhone" name="receiverPhone" placeholder="請輸入收件者手機號碼 ..." value="{{ $receiver_phone }}">
                <div class="invalid-feedback">
                  請輸入收件者手機號碼
                </div>
                <small id="phoneNumber" class="form-text " style="color:#888;">手動輸入請以 , 隔開(中間不空白)</small>
              </div>

              <div class="form-group">
                <label class="col-form-label" for="receiverEmail">收件者 E-mail</label>
                <!-- <input id="receiverEmailMultiBtn" type="button" value="多選" data-toggle="modal" data-target="#mailModal"> -->
                <input type="email" class="form-control" id="receiverEmail" name="receiverEmail" placeholder="請輸入收件者 E-mail ..." value="{{ $receiver_email }}">
                <div class="invalid-feedback">
                  請輸入正確格式的收件者 E-mail
                </div>
                <small class="form-text " style="color:#888;">手動輸入請以 , 隔開(中間不空白)</small>
              </div>


              <div class="form-group">
                <label class="col-form-label" for="emailTitle">E-mail 標題</label>
                <input type="text" class="form-control" id="emailTitle" name="emailTitle" placeholder="請輸入E-mail標題 ..." value="{{ $message['title'] }}">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
              </div>

              <!-- ckeditor -->
              <div class="form-group required">
                <label class="col-form-label" for="content">內容</label>&nbsp;<small style="color:#888;">（簡訊只能傳送無格式之純文字及連結）</small>
                <textarea name="transfer" id="content" rows="10" cols="80" value=""></textarea>
                <div class="invalid-feedback">
                  請輸入內容
                </div>
              </div>

              <div class="d-flex mt-5">
                <input type="button" class="btn btn-secondary mr-3 float-left" value="排程設定" data-toggle="modal" data-target="#scheduleModal">
                <input type="button" id="draftBtn" class="btn btn-secondary mr-2" value="儲存為草稿">
                {{-- <button id="saveDraftBtn" class="btn btn-secondary">儲存為草稿</button> --}}
                <input type="button" id="sendMessageBtn" class="btn btn-primary ml-auto" value="立即傳送">
                  {{-- <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:hidden"></span> --}}
                <span id="displaySchedule"></span>
              </div>

            </form>
            </div>
          </div>
        </div>

        <!-- 排程設定Modal -->
        <div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">排程傳送</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
               <h6>選擇日期和時間</h6>

                <div class="form-group">
                  <div class='input-group date' data-target-input='nearest'>
                    <input type='text' id="scheduleTime" class="form-control datetimepicker-input" data-target="#scheduleTime" name="params['start_time']" data-toggle="datetimepicker" autocomplete="off"/>
                    <div class="input-group-append" data-target="#scheduleTime" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" id="saveScheduleBtn" class="btn btn-primary" data-dismiss="modal">確定排程</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
              </div>
            </div>
          </div>
        </div>

        <!-- mail、手機Modal -->
        <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document" style="max-width: 45%;">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">細分組名單</h5>
                <button class="btn btn-sm btn-outline-secondary ml-3" type="button" onclick="javascript:location.href='{{ route('student_group') }}'">新增細分組</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="container">
                <div class="transfer" style="margin: 20px auto;">
                  <!-- ListBox -->
                </div>
              </div>
              <!-- <div class="modal-body">

                <div id="Group" style="display: flex;  justify-content: space-around;;">
                  <input type="search"  id="wndSearchGroup" class="form-control" placeholder="輸入細分組名稱" aria-label="Group's name" aria-describedby="btn_search" style="width: 80%;">
                  <button class="btn btn-outline-secondary" type="button" id="wndSearchGroupBtn" style="width: 15%;">搜尋</button>
                </div>


                <div id="wndGroupList">
                  <div class="table-responsive">
                    <table class="table table-striped table-sm text-center" style="margin: 10px 0px;">
                      <thead>
                        <tr>
                          <th>細分組名稱</th>
                          <th>創建日期</th>
                          <th>名單筆數</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody id="GroupData">
                        <tr>
                          <td class="align-middle">JC-1學員</td>
                          <td class="align-middle">2019年12月18日</td>
                          <td class="align-middle">95</td>
                          <td><input type="checkbox" id="jc-1"></td>
                        </tr>
                        <tr>
                          <td class="align-middle">JC-2學員</td>
                          <td class="align-middle">2019年12月18日</td>
                          <td class="align-middle">95</td>
                          <td><input type="checkbox" id="jc-2"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

              </div> -->

              <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-primary" id="wndSaveChecked" data-dismiss="modal">確定</button>
              </div>



            </div>
          </div>
        </div>

<!-- Content End -->

<script src="{{ asset('js/ckeditor.js') }}"></script>
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.min.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.min.js/2.10.6/locale/zh-tw.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script> --}}


<style>
.ck-editor__editable {
    min-height: 350px;
}
</style>


<!-- crossorigin="anonymous" -->
<script>
  $(document).ready(function () {
    init();
    var groupData;
    var allDataPhone = [];
    var allDataEmail = [];
    var selectedDataId = [];

    var schedule = moment(new Date()).add(11, 'minute');

    //預約日期選擇器
    $('#scheduleTime').datetimepicker({
      format: "YYYY-MM-DD HH:mm",
      defaultDate: schedule,
      minDate : schedule,
      // locale:"zh-tw"
    });

    $.ajax({
      type: "post",
      url: "messageDetailGroup"
    }).done(function(res) {
      groupData = res;

      var settings = {
      "groupDataArray": groupData,
      "groupItemName": "groupName",
      "groupArrayName": "groupData",
      "itemName": "name",
      "valueName": "id",
      tabNameText: "細分組成員",
      rightTabNameText: "已選擇細分組成員",
      searchPlaceholderText: "搜尋細分組成員",
      "callable": function (data, names) {
        selectedDataId = [];
        data.forEach(item => {
          selectedDataId.push(parseInt(item.id,10))
        });
        // console.log(selectedDataId);
      }
    };

      var transfer = $(".transfer").transfer(settings);
        // get selected items
      var items = transfer.getSelectedItems();
      // console.log(items);

    }).fail(function(err) {
      console.log(err);
    });


    // 防呆
    $('#groupDetailBtn').on('click', function() {
      if ( !($('#messageCheckBox').prop('checked') || $('#mailCheckBox').prop('checked' ) )) {
        alert('請先勾選發送方式!');
          return false;
      }
    });


    // 細分組搜尋確定Btn
    $('#wndSaveChecked').on('click', function() {
      // 清空data
      allDataPhone = [];
      allDataEmail = [];

      // 比對id 撈出phone、email
      for( var i = 0; i<groupData.length;i++) {
        for( var j = 0; j<groupData[i].groupData.length; j++) {
          for( var z = 0; z<selectedDataId.length; z++) {
            if (selectedDataId[z] == groupData[i].groupData[j].id) {
              // console.log(groupData[i].groupData[j].phone);
              allDataPhone.push(groupData[i].groupData[j].phone);
              allDataEmail.push(groupData[i].groupData[j].email);
            }

          }
        }
      }
      // console.log(allDataPhone);
      // console.log(allDataEmail);

      if ( $('#mailCheckBox').prop('checked') ) {
        $('#receiverEmail').val(allDataEmail);
      }

      if ( $('#messageCheckBox').prop('checked') ) {
        $('#receiverPhone').val(allDataPhone);
      }

      // 找傳送給哪一個細分組，後端做紀錄
      // for (var i = 0; i< $(".group-select-all-1e5364e841u5i1m541urm1b0tblg0").length; i++) {
      //   if ($(".group-select-all-1e5364e841u5i1m541urm1b0tblg0").eq(i).prop("checked")) {
      //     console.log($(this).id);

      //   }
      // }


    });

    // 簡訊寄送方式被觸發時
    $('#messageCheckBox').on('click', function() {
      if( $(this).is(':checked') && $('#mailCheckBox').prop('checked') == false) {
        // 簡訊方式開始
        // $('#msgTitle').prop('disabled', false);
        $('#receiverPhone').prop('disabled', false);
        $('#receiverEmail').prop('disabled', 'disabled');
        $('#emailTitle').prop('disabled', 'disabled');
      } else if ( $('#mailCheckBox').is(':checked') && ( $(this).prop('checked') == false)) {
          // $('#msgTitle').prop('disabled', 'disabled');
          $('#receiverPhone').prop('disabled', 'disabled');
          $('#receiverEmail').prop('disabled', false);
          $('#emailTitle').prop('disabled', false);
      } else if($('#mailCheckBox').is(':checked') && ( $(this).prop('checked') == true)) {
        // $('#msgTitle').prop('disabled', false);
        $('#receiverPhone').prop('disabled', false);
        $('#receiverEmail').prop('disabled', false);
        $('#emailTitle').prop('disabled', false);
      }else {
        // 簡訊方式隱藏
        // $('#msgTitle').prop('disabled', 'disabled');
        $('#receiverPhone').prop('disabled', 'disabled');
        $('#receiverEmail').prop('disabled', 'disabled');
        $('#emailTitle').prop('disabled', 'disabled');
      }
    });

    // Email寄送方式被觸發時
    $('#mailCheckBox').on('click', function() {
      if( $(this).is(':checked') && $('#messageCheckBox').prop('checked') == false ) {
        // Email方式開始，title隱藏
        // $('#msgTitle').prop('disabled', 'disabled');
        $('#receiverPhone').prop('disabled', 'disabled');
        $('#receiverEmail').prop('disabled', false);
        $('#emailTitle').prop('disabled', false);
      } else if ( $('#messageCheckBox').is(':checked') && ( $(this).prop('checked') == false) ) {
        // Email方式開始、title開啟
        // $('#msgTitle').prop('disabled', false);
        $('#receiverPhone').prop('disabled', false);
        $('#receiverEmail').prop('disabled', 'disabled');
        $('#emailTitle').prop('disabled', 'disabled');

      } else if( $('#messageCheckBox').is(':checked') && ( $(this).prop('checked') == true) ) {
        // $('#msgTitle').prop('disabled', false);
        $('#receiverPhone').prop('disabled', false);
        $('#receiverEmail').prop('disabled', false);
        $('#emailTitle').prop('disabled', false);
      }else {
        // Email方式隱藏
        // $('#msgTitle').prop('disabled', 'disabled');
        $('#receiverPhone').prop('disabled', 'disabled');
        $('#receiverEmail').prop('disabled', 'disabled');
        $('#emailTitle').prop('disabled', 'disabled');
      }
    });


    /* 立即傳送 */
    $('#sendMessageBtn').on('click', function(e) {
      e.preventDefault();

      var empty = verifyEmpty();
      
      if( empty > 0 ){
        return false;
      }

      var form = getFormData();
      var phoneAddr = $('#receiverPhone').val();
      var emailAddr = $('#receiverEmail').val();

      //判斷簡訊發送人數超過500 (API上限為500筆)
      if($('#messageCheckBox').prop('checked')){
        if( phoneAddr.split(",").length > 500 ){
          alert('發送人數超過500筆，簡訊寄送一次以500筆為上限。');
          return false;
        }
      }

      $(this).html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>立即傳送');
      $(this).prop('disabled', 'disabled');
      
      $.ajax({
          type:'POST',
          url:'message_insert',
          // dataType:"json",
          data:{
            form:form,
            phoneNumber: phoneAddr.split(","),
            emailAddr: emailAddr.split(","),
          },
          success:function(res){
            console.log(res);  
            
            if( res['status'] == 'success' && res['AccountPoint'] != null){
              /** alert **/
              $("#success_alert_text").html("寄送成功，簡訊餘額尚有" + res['AccountPoint'] + "，發送人數為" + res['count'] + "人。");
              fade($("#success_alert"));

              $('input[type="button"]').prop('disabled', 'disabled');
              setTimeout( function(){location.href="{{URL::to('message')}}"}, 3000);
            }else if( res['status'] == 'success' ){
              /** alert **/ 
              $("#success_alert_text").html("寄送成功。");
              fade($("#success_alert"));    
              
              $('input[type="button"]').prop('disabled', 'disabled');
              setTimeout( function(){location.href="{{URL::to('message')}}"}, 3000);
            }else if( res['status'] == 'error' && typeof(res['msg']) != "undefined"){
              /** alert **/ 
              $("#error_alert_text").html("寄送失敗，" + res['msg'] + "。");
              fade($("#error_alert"));    
              
              $('#sendMessageBtn').html('立即傳送');
              $('#sendMessageBtn').prop('disabled', false);
            }else if( res['status'] == 'error' ){
              /** alert **/ 
              $("#error_alert_text").html("寄送失敗。");
              fade($("#error_alert"));   

              $('#sendMessageBtn').html('立即傳送');
              $('#sendMessageBtn').prop('disabled', false); 
            }else{
              /** alert **/ 
              $("#error_alert_text").html("寄送失敗。");
              fade($("#error_alert"));   

              $('#sendMessageBtn').html('立即傳送');
              $('#sendMessageBtn').prop('disabled', false); 
            }

          },
          error: function(jqXHR, textStatus, errorMessage){
              console.log("error: "+ errorMessage);    
              console.log(jqXHR);
              $(this).html('立即傳送');
              $(this).prop('disabled', false);
          }
        });
    });


    /* 儲存草稿 */
    $('#draftBtn').on('click', function(e) {
      
      e.preventDefault();

      var empty = verifyEmpty();
      
      if( empty > 0 ){
        return false;
      }

      $(this).html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>儲存為草稿');
      $(this).prop('disabled', 'disabled');

      var form = getFormData();

      var phoneAddr = $('#receiverPhone').val();
      var emailAddr = $('#receiverEmail').val();
      
      $.ajax({
        type: "POST",
        url: "draftInsert",
        data: {
          form:form,
          phoneNumber: phoneAddr.split(","),
          emailAddr: emailAddr.split(","),
        }
      }).done(function(res) {
        console.log(res);

        if( res['status'] == 'success' ){
          /** alert **/
          $("#success_alert_text").html("儲存草稿成功");
          fade($("#success_alert"));

          setTimeout( function(){location.href="{{URL::to('message')}}"}, 3000);
          
        }else{
          /** alert **/ 
          $("#error_alert_text").html("儲存草稿失敗");
          fade($("#error_alert")); 
          $('#draftBtn').prop('disabled', false);     
        }

      }).fail(function(err) {
        console.log(err);
        
        /** alert **/ 
        $("#error_alert_text").html("儲存草稿失敗");
        fade($("#error_alert"));     
        $('#draftBtn').prop('disabled', false);   

      });
    });


    /* 排程設定 */
    $('#saveScheduleBtn').on('click', function(e) {

      // $('#displaySchedule').text(`排程時間 : ${ $('#scheduleTime').val() }`);

      e.preventDefault();

      var empty = verifyEmpty();
      
      if( empty > 0 ){
        $('#scheduleModal').modal('hide');
        return false;
      }
      
      if( $('#scheduleTime').val() == "" ){
        alert('請輸入排程時間');
        return false;
      }

      /* 排程防呆，不得排今日訊息 */
      var d = new Date($('#scheduleTime').val());

      var month = d.getMonth()+1;
      var day = d.getDate();
      var h = d.getHours();
      var n = d.getMinutes();

      var scheduleDate = d.getFullYear() + '-' +
      (month<10 ? '0' : '') + month + '-' +
      (day<10 ? '0' : '') + day + ' ' +
      (h<10 ? '0' : '') + h + ':' +
      (n<10 ? '0' : '') + n;
      
      var rule = moment().add(10, 'minutes').format("YYYY-MM-DD HH:mm");

      // if( today == scheduleDate ){
      //   alert('無法排程當日訊息，請選擇今天以後的日期。');
      //   return false;
      // }

      if( rule >= scheduleDate ){
        alert('輸入的預約時間必須⼤於系統時間10分鐘。');
        return false;
      }
      
      $(this).html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>預約排程');
      $(this).prop('disabled', 'disabled');


      var form = getFormData();
      var send_at = $('#scheduleTime').val();

      var phoneAddr = $('#receiverPhone').val();
      var emailAddr = $('#receiverEmail').val();
      

      $.ajax({
          type:'POST',
          url:'scheduleInsert',
          data:{
            form:form,
            phoneNumber: phoneAddr.split(","),
            emailAddr: emailAddr.split(","),
            send_at: send_at,
          },
          success:function(res){
            console.log(res);  

            if( res['status'] == 'success' && res['AccountPoint'] != null){
              $('#scheduleModal').modal('hide');

              /** alert **/
              $("#success_alert_text").html("訊息預約成功，簡訊餘額尚有" + res['AccountPoint'] + "，預約發送人數為" + res['count'] + "人。");
              fade($("#success_alert"));

              $('input[type="button"]').prop('disabled', 'disabled');
              setTimeout( function(){location.href="{{URL::to('message')}}"}, 3000);
            }else if( res['status'] == 'success' ){
              $('#scheduleModal').modal('hide');

              /** alert **/ 
              $("#success_alert_text").html("訊息預約成功。");
              fade($("#success_alert"));    
              
              $('input[type="button"]').prop('disabled', 'disabled');
              setTimeout( function(){location.href="{{URL::to('message')}}"}, 3000);
            }else if( res['status'] == 'error' && typeof(res['msg']) != "undefined"){
              /** alert **/ 
              $("#error_alert_text").html("訊息預約失敗，" + res['msg'] + "。");
              fade($("#error_alert"));    
              
              $('#saveScheduleBtn').html('排程設定');
              $('#saveScheduleBtn').prop('disabled', false);
            }else if( res['status'] == 'error' ){
              /** alert **/ 
              $("#error_alert_text").html("訊息預約失敗。");
              fade($("#error_alert"));   

              $('#saveScheduleBtn').html('排程設定');
              $('#saveScheduleBtn').prop('disabled', false); 
            }

          },
          error: function(jqXHR, textStatus, errorMessage){
              console.log("error: "+ errorMessage);  

              /** alert **/ 
              $("#error_alert_text").html("訊息預約失敗。");
              fade($("#error_alert"));   

              $('#saveScheduleBtn').html('排程設定');
              $('#saveScheduleBtn').prop('disabled', false); 
              // $(this).html('立即傳送');
              // $(this).prop('disabled', false);
          }
        });
      
    });

    
    //select2 講師及課程下拉式搜尋 Sandy(2020/04/14)
    $("#msgTeacher, #msgCourse").select2({
        width: 'resolve', // need to override the changed default
        theme: 'bootstrap'
    });
    $.fn.select2.defaults.set( "theme", "bootstrap" );

  });


  /* 初始化 */
  function init() {
    // $('#msgTitle').prop('disabled', 'disabled');
    // 判斷類型決定是否開啟電話跟信箱input(草稿用)
    var type = '<?php echo $message["type"]; ?>'

    if( type != "" && type == 0 || type == 2){
      $('#receiverPhone').prop('disabled', false);
    }else{
      $('#receiverPhone').prop('disabled', 'disabled');
    }
    
    if( type != "" && type == 1 || type == 2){
      $('#receiverEmail').prop('disabled', false);
    }else{
      $('#receiverEmail').prop('disabled', 'disabled');
    }

    $('#emailTitle').prop('disabled', 'disabled');

    ClassicEditor.create(document.querySelector("#content"), {
      // config
      toolbar:['Heading','|','bold','italic']
    })
    .then( newEditor => {
        editor = newEditor;
    })
    .catch(err => {
      console.error(err.stack);
    });

    var content = '<?php echo str_replace("\n","<br>", $message["content"]); ?>';
    $('#content').val(content);
  }


  /* 取得Data */
  function getFormData(){
    var id_message = $('#id_message').val();
    var type ="";
    var name =$('#msgTitle').val();
    var id_teacher = $('#msgTeacher').val();
    var id_course = $('#msgCourse').val();
    var phoneAddr = $('#receiverPhone').val();
    var emailAddr = $('#receiverEmail').val();
    var emailTitle = $('#emailTitle').val()
    var content = editor.getData().replace(new RegExp("<p>", "g"),"");
    content = content.replace(new RegExp("</p>", "g"), "\n");
    content = content.replace(new RegExp("&nbsp;", "g"), " ");
    var send_at = ""; 

    //寄送方式
    if( $('#messageCheckBox').prop('checked') && !$('#mailCheckBox').prop('checked') ){
      type = 0;
    }else if( !$('#messageCheckBox').prop('checked') && $('#mailCheckBox').prop('checked') ){
      type = 1;
    }else if( $('#messageCheckBox').prop('checked') && $('#mailCheckBox').prop('checked') ){
      type = 2;
    }

    var form = {
      id : id_message,
      type : type,
      name : name,
      id_teacher : id_teacher,
      id_course : id_course,
      mailTitle : emailTitle,
      contentStr : content,
      content : content.replace("\n", "<br>"),
      send_at : send_at,
    }

    return(form);
  }


  /* 驗證格式及是否空值 */
  function verifyEmpty(){
    var empty = 0;
 
    //發送方式
    var sendCheckBox = $('input[name="sendCheckBox"]:checked').length;
    if( sendCheckBox == 0 ){
      $("#sendCheckBox").addClass("is-invalid");
      empty++;
    }
    else{
      $("#sendCheckBox").removeClass("is-invalid");
    }

    //訊息名稱
    if($('#msgTitle').val()==""){
      $("#msgTitle").addClass("is-invalid");
      empty++;
    }
    else{
      $("#msgTitle").removeClass("is-invalid");
    }

    //email收件人
    if($('#mailCheckBox').prop('checked')){
      if( $("#receiverEmail").val() == "" ){
        $("#receiverEmail").addClass("is-invalid");
        empty++;
      }else{
        //驗證email格式
        $email = $('#receiverEmail').val().split(",");
        var rule=/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        for( var i = 0; i < $email.length ; i++ ){
          if(!rule.test($email[i])){
            $("#receiverEmail").addClass("is-invalid");
            empty++;
            break;
          }
          else{
            $("#receiverEmail").removeClass("is-invalid");
          }
        }
      }
    }else{
      $("#receiverEmail").removeClass("is-invalid");
    }
    
    //簡訊收件人
    if($('#messageCheckBox').prop('checked')){
      if( $("#receiverPhone").val() == "" ){
        $("#receiverPhone").addClass("is-invalid");
        empty++;
      }else{
        $("#receiverPhone").removeClass("is-invalid");
      }
    }else{
      $("#receiverPhone").removeClass("is-invalid");
    }
    
    //訊息內容
    if(editor.getData()==""){
      $("#content").addClass("is-invalid");
      empty++;
    }
    else{
      $("#content").removeClass("is-invalid");
    }

    return empty;
  }

</script>

@endsection