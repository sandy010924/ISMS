@extends('frontend.layouts.master')

@section('title', '訊息推播')
@section('header', '訊息推播')

@section('content')

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" /> --}}
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<!-- Content Start -->
       <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            <form style="padding: 10px 50px;">

              <div class="form-group">
                <label>發送方式</label>
                <div class="d-block">
                  <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="messageCheckBox">
                    <label class="custom-control-label" for="messageCheckBox">簡訊</label>
                    {{-- <input type="checkbox" id="messageCheckBox">
                    <label class="form-check-label" for="messageCheckBox">簡訊</label> --}}
                  </div>
                  <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="mailCheckBox">
                    <label class="custom-control-label" for="mailCheckBox">E-mail</label>
                    {{-- <input type="checkbox" id="mailCheckBox">
                    <label class="form-check-label" for="mailCheckBox">E-mail</label> --}}
                  </div>
                </div>
                <small id="emailHelp" class="form-text " style="color:red;">若選擇簡訊發送、簡訊及Email發送皆只能輸入純文字(不可包含圖片及表格)。只有選擇Email發送才可使用圖片及表格。</small>
              </div>

              <div class="form-group">
                <label for="receiverPhone">訊息名稱</label>
                <input type="text" class="form-control" id="msgTitle" placeholder="請輸入訊息名稱 ...">
              </div>

              <div class="form-group">
                <label for="">發送對象</label>
                <div>
                  <input id="groupDetailBtn" type="button" value="細分組搜尋" data-toggle="modal" data-target="#messageModal">
                </div>
              </div>

              <div class="form-group">
                <label for="receiverPhone">收件者手機號碼</label>
                <!-- <input id="receiverPhoneMultiBtn" type="button" value="多選" data-toggle="modal" data-target="#messageModal"> -->
                <input type="text" class="form-control" id="receiverPhone" placeholder="請輸入收件者手機號碼 ..." >
                <small id="phoneNumber" class="form-text " style="color:red;">手動輸入請以 , 隔開(中間不空白)</small>
              </div>

              <div class="form-group">
                <label for="receiverEmail">收件者 E-mail</label>
                <!-- <input id="receiverEmailMultiBtn" type="button" value="多選" data-toggle="modal" data-target="#mailModal"> -->
                <input type="email" class="form-control" id="receiverEmail" placeholder="請輸入收件者 E-mail ...">
                <small id="" class="form-text " style="color:red;">手動輸入請以 , 隔開(中間不空白)</small>
              </div>


              <div class="form-group">
                <label for="emailTitle">E-mail 標題</label>
                <input type="text" class="form-control" id="emailTitle" placeholder="請輸入E-mail標題 ...">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
              </div>

              <!-- ckeditor -->
              <div class="form-group">
                <label for="emailTitle">內容</label>
                <textarea name="transfer" id="content" rows="10" cols="80"></textarea>
              </div>

              <div class="d-flex mt-5">
                <button id="sendMessageBtn" class="btn btn-primary mr-2">立即傳送</button>
                <input type="button" class="btn btn-primary mr-2" value="排程設定" data-toggle="modal" data-target="#scheduleModal">
                <input type="button" class="btn btn-primary mr-2" value="儲存為草稿">
                <span id="displaySchedule"></span>
              </div>

            </form>
            </div>
          </div>
        </div>

        <!-- 排成設定Modal -->
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
               <h4>選擇日期和時間</h4>

                <div class="form-group">
                  <div class='input-group date' id='datetimepicker1' data-target-input='nearest'>
                    <input type='text' id="scheduleTime" class="form-control datetimepicker-input" data-target="#datetimepicker1" name="params['start_time']" />
                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" id="saveScheduleBtn" class="btn btn-secondary" data-dismiss="modal">確定排程</button>
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

<script src="/js/ckeditor.js"></script>
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
            console.log(groupData[i].groupData[j].phone);
            allDataPhone.push(groupData[i].groupData[j].phone);
            allDataEmail.push(groupData[i].groupData[j].email);
          }

        }
      }
    }
    console.log(allDataPhone);
    console.log(allDataEmail);

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
      $('#msgTitle').attr('disabled', false);
      $('#receiverPhone').attr('disabled', false);
      $('#receiverEmail').attr('disabled', 'disabled');
      $('#emailTitle').attr('disabled', 'disabled');
    } else if ( $('#mailCheckBox').is(':checked') && ( $(this).prop('checked') == false)) {
        $('#msgTitle').attr('disabled', 'disabled');
        $('#receiverPhone').attr('disabled', 'disabled');
        $('#receiverEmail').attr('disabled', false);
        $('#emailTitle').attr('disabled', false);
    } else if($('#mailCheckBox').is(':checked') && ( $(this).prop('checked') == true)) {
      $('#msgTitle').attr('disabled', false);
      $('#receiverPhone').attr('disabled', false);
      $('#receiverEmail').attr('disabled', false);
      $('#emailTitle').attr('disabled', false);
    }else {
      // 簡訊方式隱藏
      $('#msgTitle').attr('disabled', 'disabled');
      $('#receiverPhone').attr('disabled', 'disabled');
      $('#receiverEmail').attr('disabled', 'disabled');
      $('#emailTitle').attr('disabled', 'disabled');
    }
  });

  // Email寄送方式被觸發時
  $('#mailCheckBox').on('click', function() {
    if( $(this).is(':checked') && $('#messageCheckBox').prop('checked') == false ) {
      // Email方式開始，title隱藏
      $('#msgTitle').attr('disabled', 'disabled');
      $('#receiverPhone').attr('disabled', 'disabled');
      $('#receiverEmail').attr('disabled', false);
      $('#emailTitle').attr('disabled', false);
    } else if ( $('#messageCheckBox').is(':checked') && ( $(this).prop('checked') == false) ) {
      // Email方式開始、title開啟
      $('#msgTitle').attr('disabled', false);
      $('#receiverPhone').attr('disabled', false);
      $('#receiverEmail').attr('disabled', 'disabled');
      $('#emailTitle').attr('disabled', 'disabled');

    } else if( $('#messageCheckBox').is(':checked') && ( $(this).prop('checked') == true) ) {
      $('#msgTitle').attr('disabled', false);
      $('#receiverPhone').attr('disabled', false);
      $('#receiverEmail').attr('disabled', false);
      $('#emailTitle').attr('disabled', false);
    }else {
      // Email方式隱藏
      $('#msgTitle').attr('disabled', 'disabled');
      $('#receiverPhone').attr('disabled', 'disabled');
      $('#receiverEmail').attr('disabled', 'disabled');
      $('#emailTitle').attr('disabled', 'disabled');
    }
  });


  // 立即傳送
  $('#sendMessageBtn').on('click', function(e) {
    e.preventDefault();
    if ($('#messageCheckBox').prop('checked') && $('#mailCheckBox').prop('checked')) {
      // 兩者都發送
      messageApiType();
      mailApi();
    } else if( ($('#messageCheckBox').prop('checked') == true) && ($('#mailCheckBox').prop('checked') == false) ) {
      // 只發送簡訊
      messageApiType();
    } else if( ($('#messageCheckBox').prop('checked') == false) && ($('#mailCheckBox').prop('checked') == true) ) {
      // 只發送mail
      mailApi();
    }




  });

});

 /* 判斷簡訊是單筆、多筆 */
  function messageApiType() {
    var msgContent = editor.getData().replace(new RegExp("<p>", "g"),"");
    msgContent = msgContent.replace(new RegExp("</p>", "g"), "\n");
    msgContent = msgContent.replace(new RegExp("&nbsp;", "g"), " ");


    // 單筆 & 多筆 簡訊判斷
    $('#receiverPhone').val().indexOf(",") == -1 ? messageApi(msgContent) : messageBulkApi(msgContent);
  }

  /* 單筆簡訊發送 */
  function messageApi(msgContent) {
    $.ajax({
      type: "POST",
      url: "messageApi",
      data: {
        // messageTitle: '訊息名稱',
        messageContents: msgContent,
        phoneNumber: $('#receiverPhone').val()
      }
    }).done(function(res) {
      console.log(res);

    }).fail(function(err) {
      console.log(err);

    });
  }

  /* 多筆簡訊發送 */
  function messageBulkApi(msgContent) {
    $.ajax({
      type: "POST",
      url: "messageBulkApi",
      data: {
        // messageTitle: '訊息名稱',
        messageContents: msgContent,
        phoneNumber: $('#receiverPhone').val().split(","),
        msgLen: $('#receiverPhone').val().split(",").length,
      }
    }).done(function(res) {
      console.log(res);
    }).fail(function(err) {
      console.log(err);
    });
  }

  /* Email發送 */
  function mailApi() {
    var emailAddr = $('#receiverEmail').val();
    var emailContent = editor.getData().replace(new RegExp("<p>", "g"),"");
    emailContent = emailContent.replace(new RegExp("</p>", "g"), "\n");
    emailContent = emailContent.replace(new RegExp("&nbsp;", "g"), " ");

    $.ajax({
      type: "post",
      url: "sendMail",
      data: {
        emailTitle: $('#emailTitle').val(),
        emailAddr: emailAddr.split(","),
        emailAddrLen: emailAddr.split(",").length,
        emailContent: emailContent

      }
    }).done(function(res) {
      console.log(res);
    }).fail(function(err) {
      console.log(err);
    });
  }

  /* 初始化 */
  function init() {
    $('#msgTitle').attr('disabled', 'disabled');
    $('#receiverPhone').attr('disabled', 'disabled');
    $('#receiverEmail').attr('disabled', 'disabled');
    $('#emailTitle').attr('disabled', 'disabled');

    ClassicEditor.create(document.querySelector("#content"), {
      // config
    })
    .then( newEditor => {
        editor = newEditor;
    })
    .catch(err => {
      console.error(err.stack);
    });
  }



  // /* 以下均待改 */
  // $('#datetimepicker1').datetimepicker({
  //   format: "YYYY-MM-DD HH:mm",
  //   defaultDate:new Date(),
  //   locale:"zh-tw"
  // });


  //   $('#saveScheduleBtn').on('click', function() {

  //     $('#displaySchedule').text(`排程時間 : ${ $('#scheduleTime').val() }`);
  //   });

  // });


</script>

@endsection