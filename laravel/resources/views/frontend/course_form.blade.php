<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="csrf-token"  content="{{ csrf_token() }}">
  <title>報名表單 | 無極限學員系統</title>

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Fontawesome Icon -->
  <link href="{{ asset('font-awesome/css/all.css') }}" rel="stylesheet">

  <!-- Custom styles -->
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
  <link href="{{ asset('css/web.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>

  <main role="main" class="mw-100">
    <img src="{{ asset('img/logo.png') }}" width="100" alt="logo" class="d-block mx-auto mt-5">
    <h4 class="text-center text-white font-weight-bold m-4">無極限國際有限公司</h4>
    <div class="card mx-auto my-3 w-50">
      <div id="course_form" class="card-body container px-4 p-3">
        {{-- <div id="firstpage"> --}}
        <div id="step1">
          <form id="form1" name="verify">
            @csrf
            <div class="form-group mb-5">
                <h5 class="font-weight-bold text-center my-3">課程服務報名表</h5>
            </div>
            <div class="form-group mb-5 required">
              <label class="col-form-label" for="iphone_verify">
                <b>聯絡電話</b>
              </label>
              <input type="text" id="iphone_verify" name="iphone_verify" class="form-control" required>
            </div>
            {{-- <button type="button" id="page1_next" class="btn btn-dark w-25 mt-3 float-right" onclick="firstnext(),topFunction()">下一步</button> --}}
            <button type="submit" class="btn btn-dark w-25 mt-3 float-right">下一步</button>
            {{-- <button type="submit" id="btn_verify" class="btn btn-dark w-25 mt-3 float-right">下一步</button> --}}
          </form>
        </div>
        <div id="step2" style="display:none;">
          <form id="form2">
            @csrf
            <div class="form-group mb-5">
                <h5 class="font-weight-bold text-center my-3">課程服務報名表</h5>
            </div>
            <div class="form-group mb-5">
              <label class="col-form-label" for="idate">
                <b>報名日期</b>
              </label>
              <input type="text" id="idate" name="idate" class="form-control" disabled readonly>
            </div>
            <div class="form-group mb-5">
              <label class="col-form-label" for="iname">
                <b>姓名</b>
              </label>
              <input type="text" id="iname" name="iname" class="form-control" value="">
            </div>
            <div class="form-group mb-5">
              <label class="col-form-label" for="isex">
                <b>性別</b>
              </label>
              <div class="d-block my-2">
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="isex1" name="isex" class="custom-control-input" value="男" checked>
                  <label class="custom-control-label" for="isex1">男</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="isex2" name="isex" class="custom-control-input" value="女">
                  <label class="custom-control-label" for="isex2">女</label>
                </div>
              </div>
            </div>
            <div class="form-group mb-5">
              <label class="col-form-label" for="iid">
                <b>身分證字號</b>
              </label>
              <input type="text" id="iid" name="iid" class="form-control">
            </div>
            <div class="form-group mb-5">
              <label class="col-form-label" for="iphone">
                <b>聯絡電話</b>
              </label>
              <input type="text" id="iphone" name="iphone" class="form-control">
            </div>
            <div class="form-group mb-5">
              <label class="col-form-label" for="iemail">
                <b>電子郵件</b>
              </label>
              <input type="text" id="iemail" name="iemail" class="form-control">
            </div>
            <div class="form-group mb-5">
              <label class="col-form-label" for="ibirthday">
                <b>出生日期</b>
              </label>           
              <input type="date" id="ibirthday" name="ibirthday" class="form-control"> 
            </div>
            <div class="form-group mb-5">
              <label class="col-form-label" for="icompany">
                <b>公司名稱</b>
              </label>
              <input type="text" id="icompany" name="icompany" class="form-control">
            </div>
            <div class="form-group mb-5">
              <label class="col-form-label" for="iprofession">
                <b>職業</b>
              </label>
              <input type="text" id="iprofession" name="iprofession" class="form-control">
            </div>
            <div class="form-group mb-5">
              <label class="col-form-label" for="iaddress">
                <b>聯絡地址</b>
              </label>
              <input type="text" id="iaddress" name="iaddress" class="form-control">
            </div>
            <button type="button" name="last" class="btn btn-dark w-25 mt-3 float-left">上一步</button>
            <button type="button" name="next" class="btn btn-dark w-25 mt-3 float-right">下一步</button>
          </form>
            {{-- <button type="button" class="btn btn-dark w-25 mt-3 float-left" onclick="secondlast(),topFunction()">上一步</button>
          <button type="submit" class="btn btn-dark w-25 mt-3 float-right" onclick="secondnext(),topFunction()">下一步</button> --}}
        </div>
        <div id="step3" style="display:none;">
          <form id="form3">
            @csrf
            <div class="form-group mb-5">
                <h5 class="font-weight-bold text-center my-3">參加課程服務</h5>
              <div>
                {{ $course->courseservices }}
              </div>
              <hr>
              <h3 class="font-weight-bold text-center my-3">{{ $course->name }}</h3>
              <h4 class="font-weight-bold text-center my-3">一般方案：{{ $course->money }}</h4> 
            </div>
            <div class="form-group mb-5 required">
              <label class="col-form-label" for="ijoin">
                <b>我想參加課程</b>
              </label>
              <div class="d-block my-2">
                <div class="custom-control custom-radio my-1">
                  <input type="radio" id="ijoin1" name="ijoin" class="custom-control-input" value="0" checked>
                  <label class="custom-control-label" for="ijoin1">現場最優惠價格</label>
                </div>
                <div class="custom-control custom-radio my-1">
                  <input type="radio" id="ijoin2" name="ijoin" class="custom-control-input" value="1">
                  <label class="custom-control-label" for="ijoin2">五日內優惠價格</label>
                </div>
              </div>
            </div>
            {{-- <button type="button" class="btn btn-dark w-25 mt-3 float-left" onclick="thirdlast(),topFunction()">上一步</button>
            <button type="button" class="btn btn-dark w-25 mt-3 float-right" onclick="thirdnext(),topFunction()">下一步</button> --}}
            <button type="button" name="last" class="btn btn-dark w-25 mt-3 float-left">上一步</button>
            <button type="button" name="next" class="btn btn-dark w-25 mt-3 float-right">下一步</button>
          </form>
        </div>
        <div id="step4" style="display:none;">
          <form id="form4">
            @csrf
            <div class="form-group mb-5">
              <label class="col-form-label" for="ievent">
                <b>{{ $course->name }} 的場次</b>
              </label>
              <div class="d-block my-2">
                @foreach( $events as $data )
                  <div class="custom-control custom-checkbox my-3">
                    <input type="checkbox" id="ievent1" name="ievent" class="custom-control-input">
                    <label class="custom-control-label h6" for="ievent1">{{$data}}</label>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="form-group mb-5 required">
              <label class="col-form-label" for="ipay_model">
                <b>付款方式</b>
              </label>
              <div class="d-block my-2">
                <div class="custom-control custom-radio my-1">
                  <input type="radio" id="ipay_model1" name="ipay_model" class="custom-control-input" value="0" checked>
                  <label class="custom-control-label" for="ipay_model1">現金</label>
                </div>
                <div class="custom-control custom-radio my-1">
                  <input type="radio" id="ipay_model2" name="ipay_model" class="custom-control-input" value="1">
                  <label class="custom-control-label" for="ipay_model2">匯款</label>
                </div>
                <div class="custom-control custom-radio my-1">
                  <input type="radio" id="ipay_model3" name="ipay_model" class="custom-control-input" value="2">
                  <label class="custom-control-label" for="ipay_model3">刷卡：輕鬆付</label>
                </div>
                <div class="custom-control custom-radio my-1">
                  <input type="radio" id="ipay_model4" name="ipay_model" class="custom-control-input" value="3">
                  <label class="custom-control-label" for="ipay_model4">刷卡：一次付</label>
                </div>
              </div>
            </div>
            <div class="form-group mb-5 required">
              <label class="col-form-label" for="icash">
                <b>付款金額</b>
              </label>
              <input type="text" id="icash" name="icash" class="form-control" required>
              <label class="text-secondary px-2 py-1"><small>（實際金額以財務確認為準）</small></label>
            </div>
            <hr>
            <div class="form-group mb-5">
              <h5 class="font-weight-bold text-center my-5">匯款資訊</h5>
              <p>中國信託商業銀行中壢分行(代碼822)</p>
              <p>戶名：無極限國際有限公司</p>
              <p>帳號：129541438753</p>
              <h5 class="font-weight-bold text-center my-5">刷卡連結（會再附上連結）</h5>
            </div>
            <hr>
            <div class="form-group mb-5 required">
              <label class="col-form-label" for="inumber">
                <b>匯款帳號/卡號後五碼</b>
              </label>
              <input type="text" id="inumber" name="inumber" class="form-control" required>
              <label class="text-secondary px-2 py-1"><small>（付款完成請「截圖」回傳LINE@，謝謝）</small></label>
            </div>
            <hr style="border: 0;">
            <div class="form-group mb-5 required">
              <label class="col-form-label" for="iinvoice">
                <b>統一發票</b>
              </label>
              <div class="d-block my-2">
                <div class="custom-control custom-radio my-1">
                  <input type="radio" id="iinvoice1" name="iinvoice" class="custom-control-input" value="0" checked>
                  <label class="custom-control-label" for="iinvoice1">捐贈社會福利機構（由無極限國際公司另行辦理）</label>
                </div>
                <div class="custom-control custom-radio my-1">
                  <input type="radio" id="iinvoice2" name="iinvoice" class="custom-control-input" value="1">
                  <label class="custom-control-label" for="iinvoice2">二聯式</label>
                </div>
                <div class="custom-control custom-radio my-1">
                  <input type="radio" id="iinvoice3" name="iinvoice" class="custom-control-input" value="2">
                  <label class="custom-control-label" for="iinvoice3">三聯式</label>
                </div>
              </div>
            </div>
            <div class="form-group mb-5">
              <label class="col-form-label" for="inum">
                <b>統編</b>
              </label>
              <input type="text" id="inum" name="inum" class="form-control">
            </div>
            <div class="form-group mb-5">
              <label class="col-form-label" for="icompanytitle">
                <b>抬頭</b>
              </label>
              <input type="text" id="icompanytitle" name="icompanytitle" class="form-control">
            </div>
            <button type="button" name="last" class="btn btn-dark w-25 mt-3 float-left">上一步</button>
            <button type="button" name="next" id="events_check" class="btn btn-dark w-25 mt-3 float-right">下一步</button>
          </form>
        </div>
        <div id="step5" style="display:none;">
          <form id="form5" name="preview">
            @csrf
            <div class="form-group">
                <h3 class="font-weight-bold text-center my-3">課程服務須知</h3>
                <h5 class="font-weight-bold text-center my-3">請詳讀後勾選</h5>
            </div>
            <div class="form-group my-5 required">
              <div class="custom-control custom-checkbox my-3">
                <input type="checkbox" class="custom-control-input" id="agree_check1" name="agree" required>
                <label class="custom-control-label" for="agree_check1">我同意</label>
              </div>
              <textarea class="form-control bg-white" disabled readonly>課程服務限本人使用，不得轉讓他人使用。</textarea>
            </div>
            <hr>
            <div class="form-group my-5 required">
              <div class="custom-control custom-checkbox my-3">
                <input type="checkbox" class="custom-control-input" id="agree_check2" name="agree" required>
                <label class="custom-control-label" for="agree_check2">我同意</label>
              </div>
              <textarea rows="5" class="form-control bg-white" disabled readonly>如您於繳交費用後無法參加課程，請保留此表單備分內容。（報名完成會寄到您填寫的email）&#13;&#10;申請之退費方式、款項如下： &#13;&#10; 5日內全額退費（繳費後隔日起算）&#13;&#10;★第6日起：課程費用80%（繳交費用未達20%者，恕不辦理退費）&#13;&#10;★第31日起或開課後：恕不辦理退費。</textarea>
            </div>
            <hr>      
            <div class="form-group my-5 required">
              <div class="custom-control custom-checkbox my-3">
                <input type="checkbox" class="custom-control-input" id="agree_check3" name="agree" required>
                <label class="custom-control-label" for="agree_check3">我同意</label>
              </div>
              <textarea class="form-control bg-white" disabled readonly>報名完成後1年內須參加課程服務，逾期則不得參加課程服務，亦不得要求退還已繳交之費用。</textarea>
            </div>
            <hr>
            <div class="form-group my-5">
              <p>本人保證上述資料之真實性並願遵守本「課程服務合約」之內容（請簽中文正楷）</p>
              <!-- 電子簽章 -->
              {{-- <div> --}}
                <canvas id="signature_pad" class="signature_pad border border-secondary" width="600" height="300"></canvas>
              {{-- </div>
              <div> --}}
                <button type="button" id="signature_pad_clear" class="btn btn-secondary my-2">清除簽名</button>
              {{-- </div> --}}
            </div>
            {{-- <div class="form-group my-5"> --}}
              <button type="button" name="last" class="btn btn-dark w-25 mt-3 float-left">上一步</button>
              <button type="button" id="preview" class="btn btn-dark w-25 mt-3 float-right">預覽後完成報名</button>
            {{-- </div> --}}
          </form>
        </div>
        <div id="step6" style="display:none;">
          <button type="button" id="edit" class="btn btn-dark w-25 mt-3 float-left">編輯</button>
          <button type="button" id="submit" class="btn btn-dark w-25 mt-3 float-right">確定報名</button>
          {{-- <button id="confirmRegistration" type="submit" class="btn btn-dark w-25 mt-3 float-right" >確認報名</button> --}}
        </div>
        <div id="complete" style="display:none;">
          <div class="text-center">
            <h1>報名完成！</h1>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/feather.min.js') }}"></script>
<script src="{{ asset('js/form.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="{{ asset('js/signature.js') }}"></script>

<script>
  //手機號碼查詢既有學員資料並填入 Sandy (2020/03/05)
  $("form[name='verify']").submit(function(event){
    event.preventDefault();
    var phone = $('#iphone_verify').val();
    var now = parseInt($(this).attr("id").split("form").pop());
    // var now = parseInt($(this).parent().attr("id").split("form").pop());

    $.ajax({
      type:'GET',
      url:'course_form_fill',
      data:{
        phone:phone
      },
      success:function(data){
        // console.log(data);  

        if( data == "nodata" ){          
          $("#iphone").val($('#iphone_verify').val());
        }else{
          $("#iname").val(data[0].name);
          if( data[0].sex == '男'){
            $("#isex1").click();
          }else{
            $("#isex2").click();
          }

          $("#iid").val(data[0].id_identity);
          $("#iphone").val(data[0].phone);
          $("#iemail").val(data[0].email);
          $("#ibirthday").val(data[0].birthday);
          $("#icompany").val(data[0].company);
          $("#iprofession").val(data[0].profession);
          $("#iaddress").val(data[0].address);
        }
        
        next(now);
        // $("#step" + now).hide()
        // $("#step" + (now + 1)).show()
        // $("body").scrollTop(0);
      },
      error: function(jqXHR, textStatus, errorMessage){
          console.log("error: "+ errorMessage);    
      }
    });
  });

  // $("#events_check").submit(function(event){
  //   event.preventDefault();
  //   if($('.roles:checkbox:checked').length == 0){
  //     alert("");
  //     return false;
  //   }
  //     return true;
  // });
  

  //下一步按鈕觸發 Sandy (2020/03/05)
  $("button[name='next']").click(function(){
    var now = parseInt($(this).parent().attr("id").split("form").pop());
    next(now);
  });

  //下一步跳頁 Sandy (2020/03/05)
  function next(now){ 
    $("#step" + now).hide()
    $("#step" + (now + 1)).show()
    $("body").scrollTop(0);
  }

  //上一步按鈕 Sandy (2020/03/05)
  $("button[name='last']").click(function(){
    var now = parseInt($(this).parent().attr("id").split("form").pop());
    
    $("#step" + now).hide()
    $("#step" + (now - 1)).show()
  });
  
  //預覽 Sandy (2020/03/05)
  $("#preview").click(function(){
    $("form").parent().show()
    $("form").parent().find("button").hide()
    $("input").prop( "disabled" , true );
    $("#step1").hide();
    $("#step6").show();
    $("body").scrollTop(0);
  });
  
  //編輯 Sandy (2020/03/05)
  $("#edit").click(function(){
    $("form").parent().find("button").show()
    $("form").parent().hide()
    $("input").prop( "disabled" , false );
    $("#step5").show();
    $("#step6").hide();
    $("body").scrollTop(0);
  });
  
  //送出報名 Sandy (2020/03/05)
  $("#submit").click(function(){
    // var phone = $('#idate').val();
    var iname = $('#iname').val();
    var isex = $('input[name="isex"]:checked').val();
    var iid = $('#iid').val();
    var iphone = $('#iphone').val();
    var iemail = $('#iemail').val();
    var ibirthday = $('#ibirthday').val();
    var icompany = $('#icompany').val();
    var iprofession = $('#iprofession').val();
    var iaddress = $('#iaddress').val();
    var ijoin = $('input[name="ijoin"]:checked').val();
    var ipay_model = $('input[name="ipay_model"]:checked').val();
    var icash = $('#icash').val();
    var inumber = $('#inumber').val();
    var iinvoice = $('input[name="iinvoice"]:checked').val();
    var inum = $('#inum').val();
    var icompanytitle = $('#icompanytitle').val();

    $.ajax({
      type:'POST',
      url:'course_form_insert',
      data:{
        '_token':"{{ csrf_token() }}",
        iname : iname,
        isex : isex,
        iid : iid,
        iphone : iphone,
        iemail : iemail,
        ibirthday : ibirthday,
        icompany : icompany,
        iprofession : iprofession,
        iaddress : iaddress,
        ijoin : ijoin,
        ipay_model : ipay_model,
        icash : icash,
        inumber : inumber,
        iinvoice : iinvoice,
        inum : inum,
        icompanytitle : icompanytitle
      },
      success:function(data){
        console.log(data);  

        // if( data == 'success' ){
          
        // }else{

        // }
        // if( data == "nodata" ){          
        //   $("#iphone").val($('#iphone_verify').val());
        // }else{
        //   $("#iname").val(data[0].name);
        //   if( data[0].sex == '男'){
        //     $("#isex1").click();
        //   }else{
        //     $("#isex2").click();
        //   }

        //   $("#iid").val(data[0].id_identity);
        //   $("#iphone").val(data[0].phone);
        //   $("#iemail").val(data[0].email);
        //   $("#ibirthday").val(data[0].birthday);
        //   $("#icompany").val(data[0].company);
        //   $("#iprofession").val(data[0].profession);
        //   $("#iaddress").val(data[0].address);
        // }
        
        // next(now);
        // $("#step" + now).hide()
        // $("#step" + (now + 1)).show()
        // $("body").scrollTop(0);
      },
      error: function(jqXHR, textStatus, errorMessage){
          console.log("error: "+ errorMessage);    
            console.log(JSON.stringify(jqXHR)); 
      }
    });
  });


  /**
   * 待改寫，submit會驗證require，然後不要直接送出!!
   * 要驗證有無簽名 才可以送出
   */

  $('#confirmRegistration').on('click', function() {
    // 驗證有無簽章
    if(signaturePad.isEmpty()) {
      alert("請中文正楷簽章!");
      return false ;
    } else {
      var canvas = document.getElementById('signature_pad');
      var dataURL = canvas.toDataURL();
      $.ajax({
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "signature",
        data: {
          imgBase64: dataURL
        }
      }).done(function(res) {
        console.log(res);
      });
    }


  });

</script>

</html>
