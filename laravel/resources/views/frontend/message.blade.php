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
                <label for="emailTitle">標題</label>
                <input type="text" class="form-control" id="emailTitle" placeholder="請輸入標題 ...">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
              </div>
              <div class="form-group">
                <label for="receiverEmail">收件者 E-mail</label>
                <input id="receiverEmailMultiBtn" type="button" value="多選" data-toggle="modal" data-target="#mailModal">
                <input type="email" class="form-control" id="receiverEmail" placeholder="請輸入收件者 E-mail ...">
              </div>
              <div class="form-group">
                <label for="receiverPhone">收件者手機號碼</label>
                <input id="receiverPhoneMultiBtn" type="button" value="多選" data-toggle="modal" data-target="#messageModal">
                <input type="text" class="form-control" id="receiverPhone" placeholder="請輸入收件者手機號碼 ..." >
              </div>
              <!-- ckeditor -->
              <textarea name="content" id="content" rows="10" cols="80"></textarea>
              <button type="submit" class="btn btn-primary mt-5">立即傳送</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                messageModal
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
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


$("document").ready(function(){
  $('#receiverEmail').attr('disabled', 'disabled');
  $('#receiverPhone').attr('disabled', 'disabled');
  $('#emailTitle').attr('disabled', 'disabled');
  // 多選wndBtn
  $('#receiverEmailMultiBtn').attr('disabled', 'disabled');
  $('#receiverPhoneMultiBtn').attr('disabled', 'disabled')

  // 簡訊寄送方式被觸發時
  $('#messageCheckBox').on('click', function() {
    if( $(this).is(':checked')) {
      // 簡訊方式開始
      $('#receiverPhone').attr('disabled', false);
      $('#receiverPhoneMultiBtn').attr('disabled', false)
    } else {
      // 簡訊方式隱藏
      $('#receiverPhone').attr('disabled', 'disabled');
      $('#receiverPhoneMultiBtn').attr('disabled', 'disabled')
    }
  });

  // Email寄送方式被觸發時
  $('#mailCheckBox').on('click', function() {
    if( $(this).is(':checked')) {
      // Email方式開始
      $('#receiverEmail').attr('disabled', false);
      $('#emailTitle').attr('disabled', false);
      $('#receiverEmailMultiBtn').attr('disabled', false);
    } else {
      // Email方式隱藏
      $('#receiverEmail').attr('disabled', 'disabled');
      $('#emailTitle').attr('disabled', 'disabled');
      $('#receiverEmailMultiBtn').attr('disabled', 'disabled');
    }
  });

});
</script>

@endsection