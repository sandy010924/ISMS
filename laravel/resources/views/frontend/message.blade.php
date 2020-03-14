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
            <div class="row mb-3">

            </div>
            <form style="padding: 10px 50px;">

              <div class="form-group">
                <label>發送方式</label>
                <div>
                  <input type="checkbox" id="messageCheckBox">
                  <label class="form-check-label" for="messageCheckBox">簡訊</label>
                  <input type="checkbox" id="mailCheckBox">
                  <label class="form-check-label" for="mailCheckBox">E-mail</label>
                </div>
                <small id="emailHelp" class="form-text " style="color:red;">若選擇簡訊發送、簡訊及Email發送皆只能輸入純文字(不可包含圖片及表格)。只有選擇Email發送才可使用圖片及表格。</small>
              </div>

              <div class="form-group">
                <label for="">發送對象</label>
                <div>
                  <input id="aa" type="button" value="細分組搜尋" data-toggle="modal" data-target="#messageModal">
                </div>
              </div>

              <div class="form-group">
                <label for="receiverPhone">訊息名稱</label>
                <input type="text" class="form-control" id="msgTitle">
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
                <input type="text" class="form-control" id="emailTitle" placeholder="請輸入標題 ...">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
              </div>

              <!-- ckeditor -->
              <div class="form-group">
                <label for="emailTitle">內容</label>
                <textarea name="content" id="content" rows="10" cols="80"></textarea>
              </div>

              <div style="display:flex;" class=" mt-5">
                <button id="sendMessageBtn"  class="btn btn-primary mr-2">立即傳送</button>
                <input type="button" class="btn btn-primary mr-2"  value="排程設定" data-toggle="modal" data-target="#scheduleModal">
                <input type="button" class="btn btn-primary mr-2"  value="儲存為草稿">
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
                <h5 class="modal-title" id="exampleModalLabel">排成傳送</h5>
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
          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">細分組名單</h5>
                <button class="btn btn-outline-secondary ml-2" type="button" onclick="javascript:location.href='{{ route('student_group') }}'">新增細分組</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">

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

              </div>

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
<script crossorigin="anonymous">
ClassicEditor.create(document.querySelector("#content"), {
		// config
	})
		.then( newEditor => {
        editor = newEditor;
    })
		.catch(err => {
			console.error(err.stack);
    });


$("document").ready(function() {

  $('#receiverEmail').attr('disabled', 'disabled');
  $('#receiverPhone').attr('disabled', 'disabled');
  $('#emailTitle').attr('disabled', 'disabled');

  $('#datetimepicker1').datetimepicker({
    format: "YYYY-MM-DD HH:mm",
    defaultDate:new Date(),
    locale:"zh-tw"
  });

      // 簡訊寄送方式被觸發時
    $('#messageCheckBox').on('click', function() {
      if( $(this).is(':checked') ) {
        // 簡訊方式開始
        $('#receiverPhone').attr('disabled', false);
        $('#emailTitle').attr('disabled', 'disabled');
      } else if ( $('#mailCheckBox').is(':checked') && ( $(this).prop('checked') == false)) {
          $('#receiverPhone').attr('disabled', 'disabled');
          $('#receiverEmail').attr('disabled', false);
          $('#emailTitle').attr('disabled', false);
      } else {
        // 簡訊方式隱藏
        $('#receiverPhone').attr('disabled', 'disabled');
        $('#emailTitle').attr('disabled', 'disabled');
      }
    });

    // Email寄送方式被觸發時
    $('#mailCheckBox').on('click', function() {
      if( $(this).is(':checked') && $('#messageCheckBox').is(':checked') ) {
        // Email方式開始，title隱藏
        $('#receiverEmail').attr('disabled', false);
        $('#emailTitle').attr('disabled', 'disabled');
      } else if ( $(this).is(':checked') && ( $('#messageCheckBox').prop('checked') == false) ) {
        // Email方式開始、title開啟
        $('#receiverEmail').attr('disabled', false);
        $('#emailTitle').attr('disabled', false);
      } else {
        // Email方式隱藏
        $('#receiverEmail').attr('disabled', 'disabled');
        $('#emailTitle').attr('disabled', 'disabled');
      }
    });

    // 細分組搜尋框
  $('#wndSearchGroupBtn').on('click', function() {
    var wndSearchGroupData = $('#wndSearchGroup').val();
    console.log(wndSearchGroupData);
    // 發ajax 搜尋細分組成員

  });

  // 暫時假資料代替搜尋完的結果render上頁面
  var fakeData = [{
      id: 'jc-1',
      email: 'jc-1@gmail.com',
      phone: '0989555555'
    },
    {
      id: 'jc-2',
      email: 'jc-2@gmail.com',
      phone: '0989666666'
    }]

    // wnd細分組成員被勾選起來後顯示在input中
     $('#wndSaveChecked').on('click', function() {
      // 防呆
      if ( $('#messageCheckBox').prop('checked') || $('#mailCheckBox').prop('checked' ) ) {
        var checkedMail = [], checkedPhone = [];
        for (let index = 0; index <= fakeData.length; index++) {

          if ($('#GroupData input').eq(index).prop('checked')) {
            checkedMail.push(fakeData[index].email);
            checkedPhone.push(fakeData[index].phone);
            console.log( $('#GroupData input').eq(index).attr('id') ) ;
          }

        }

        console.log(checkedMail);
        console.log(checkedPhone);

        if ( $('#mailCheckBox').prop('checked') ) {
          $('#receiverEmail').val(checkedMail);
        }

        if ( $('#messageCheckBox').prop('checked') ) {
          $('#receiverPhone').val(checkedPhone);
        }
      } else {
        alert('請先勾選發送方式!');
        return false;
      }
      });


    $('#saveScheduleBtn').on('click', function() {

      $('#displaySchedule').text(`排程時間 : ${ $('#scheduleTime').val() }`);
    });


    // 立即傳送
    $('#sendMessageBtn').on('click', function(e) {
      e.preventDefault();
      // 發ajax to send mail、message
      // console.log(`標題 : ${$('#emailTitle').val()}`);
      // console.log(`Email : ${$('#receiverEmail').val()}`);
      // console.log(`Phone : ${$('#receiverPhone').val()}`);

      // console.log($(editor.getData()).text());

      var msgContent = editor.getData().replace(new RegExp("<p>", "g"),"");
      msgContent = msgContent.replace(new RegExp("</p>", "g"), "\n");
      msgContent = msgContent.replace(new RegExp("&nbsp;", "g"), " ");
      $.ajax({
        type: "POST",
        url: "message_api",
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

    });

  });


</script>

@endsection