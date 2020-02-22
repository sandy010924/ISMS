@extends('frontend.layouts.master')

@section('title', '訊息推播')
@section('header', '訊息推播')

@section('content')
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
                  <input type="checkbox" id="mailCheckBox">
                  <label class="form-check-label" for="mailCheckBox">E-mail</label>
                  <input type="checkbox" id="messageCheckBox">
                  <label class="form-check-label" for="messageCheckBox">簡訊</label>
                </div>
                <small id="emailHelp" class="form-text " style="color:red;">若選擇簡訊發送、簡訊及Email發送皆只能輸入純文字(不可包含圖片及表格)。只有選擇Email發送才可使用圖片及表格。</small>
              </div>
              <!-- <div class="form-group">
                <label for="sender">寄件者 E-mail</label>
                <input type="email" class="form-control" id="sender" placeholder="請輸入寄件者 E-mail ...">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div> -->

              <div class="form-group">
                <label for="">發送對象</label>
                <input id="" type="button" value="細分組搜尋" data-toggle="modal" data-target="#messageModal">
              </div>

              <div class="form-group">
                <label for="emailTitle">標題</label>
                <input type="text" class="form-control" id="emailTitle" placeholder="請輸入標題 ...">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
              </div>
              <div class="form-group">
                <label for="receiverEmail">收件者 E-mail</label>
                <!-- <input id="receiverEmailMultiBtn" type="button" value="多選" data-toggle="modal" data-target="#mailModal"> -->
                <input type="email" class="form-control" id="receiverEmail" placeholder="請輸入收件者 E-mail ...">
                <small id="" class="form-text " style="color:red;">手動輸入請以 , 隔開(中間不空白)</small>
              </div>
              <div class="form-group">
                <label for="receiverPhone">收件者手機號碼</label>
                <!-- <input id="receiverPhoneMultiBtn" type="button" value="多選" data-toggle="modal" data-target="#messageModal"> -->
                <input type="text" class="form-control" id="receiverPhone" placeholder="請輸入收件者手機號碼 ..." >
                <small id="" class="form-text " style="color:red;">手動輸入請以 , 隔開(中間不空白)</small>
              </div>
              <!-- ckeditor -->
              <textarea name="content" id="content" rows="10" cols="80"></textarea>
              <button id="sendMessageBtn" type="submit" class="btn btn-primary mt-5">立即傳送</button>
              <button type="submit" class="btn btn-primary mt-5">排成設定</button>
            </form>
            </div>
          </div>
        </div>

        <!-- mailModal -->
        <div class="modal fade" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                mailModal
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>

        <!-- messageModal -->
        <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">細分組名單</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">

                <div id="Group" style="display: flex;  justify-content: space-around;">
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
                <button type="button" class="btn btn-primary" id="wndSaveChecked" data-dismiss="modal">Save changes</button>
              </div>

            </div>
          </div>
        </div>

<!-- Content End -->

<script src="/js/ckeditor.js"></script>
<style>
.ck-editor__editable {
    min-height: 350px;
}
</style>
<script>
ClassicEditor.create(document.querySelector("#content"), {
		// config
	})
		.then(editor => {
			window.editor = editor;
		})
		.catch(err => {
			console.error(err.stack);
    });


$("document").ready(function() {

  $('#receiverEmail').attr('disabled', 'disabled');
  $('#receiverPhone').attr('disabled', 'disabled');
  $('#emailTitle').attr('disabled', 'disabled');

      // 簡訊寄送方式被觸發時
    $('#messageCheckBox').on('click', function() {
      if( $(this).is(':checked')) {
        // 簡訊方式開始
        $('#receiverPhone').attr('disabled', false);
      } else {
        // 簡訊方式隱藏
        $('#receiverPhone').attr('disabled', 'disabled');
      }
    });

    // Email寄送方式被觸發時
    $('#mailCheckBox').on('click', function() {
      if( $(this).is(':checked')) {
        // Email方式開始
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
      });

    // 立即傳送
    $('#sendMessageBtn').on('click', function() {
      // 發ajax to send mail、message
      console.log(`標題 : ${$('#emailTitle').val()}`);
      console.log(`Email : ${$('#receiverEmail').val()}`);
      console.log(`Phone : ${$('#receiverPhone').val()}`);
    });

  });








</script>

@endsection