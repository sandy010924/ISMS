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
<style>
    /* 日期選擇器位置調整 */
    .table-responsive{
      /* z-index: 0; */
      overflow: visible;
    }
    table td{
      position: relative;
    }
    .bootstrap-datetimepicker-widget{
      bottom: 0;
      z-index: 9999 !important;
    }
    button{
      font-weight: bold !important;
    }
</style>

<body>
  <main role="main" class="mw-100 container">
    <input type="hidden" id="source_course" value="{{ $source_course }}">
    <input type="hidden" id="source_events" value="{{ $source_events }}">
    <img src="{{ asset('img/logo.png') }}" width="100" alt="logo" class="d-block mx-auto mt-5">
    <h4 class="text-center text-white font-weight-bold m-4">無極限國際有限公司</h4>
    <div div="row">
      <div class="col-md-6 mx-auto my-3">
        <div id="course_form" class="card p-3">
          {{-- <div id="firstpage"> --}}
          <div id="step1">
            <form id="form1" name="verify" >
              @csrf
              <div class="form-group mb-5">
                  <h5 class="font-weight-bold text-center my-3">課程服務報名表</h5>
              </div>
              <div class="form-group mb-5 required">
                <label class="col-form-label" for="iphone_verify">
                  <b>聯絡電話</b>
                </label>
                <input type="number" id="iphone_verify" name="iphone_verify" class="form-control" required>
              </div>
              {{-- <button type="button" id="page1_next" class="btn btn-dark px-4 mt-3 mx-3" onclick="firstnext(),topFunction()">下一步</button> --}}
              <button type="submit" class="btn btn-primary mt-3 px-4 float-right" data-form="form1">下一步</button>
              {{-- <button type="submit" id="btn_verify" class="btn btn-dark px-4 mt-3 mx-3">下一步</button> --}}
            </form>
          </div>
          <div id="step2" style="display:none;">
            <form id="form2" class="needs-validation" novalidate>
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
              <div class="form-group mb-5 required">
                <label class="col-form-label" for="iname">
                  <b>姓名</b>
                </label>
                <input type="text" id="iname" name="iname" class="form-control" required>
                <div class="invalid-feedback">
                  請輸入姓名
                </div>
              </div>
              <div class="form-group mb-5">
                <label class="col-form-label" for="isex">
                  <b>性別</b>
                </label>
                <div class="d-block my-2">
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="isex1" name="isex" class="custom-control-input" value="男">
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
                <div class="invalid-feedback">
                  身分證字號格式有誤
                </div>
              </div>
              <div class="form-group mb-5 required">
                <label class="col-form-label" for="iphone">
                  <b>聯絡電話</b>
                </label>
                <input type="text" id="iphone" name="iphone" class="form-control" required>
                <div class="invalid-feedback">
                  請輸入正確的聯絡電話
                </div>
              </div>
              <div class="form-group mb-5">
                <label class="col-form-label" for="iemail">
                  <b>電子郵件</b>
                </label>
                <input type="text" id="iemail" name="iemail" class="form-control">
                <div class="invalid-feedback">
                電子信箱格式有誤
                </div>
              </div>
              <div class="form-group mb-5">
                <label class="col-form-label" for="ibirthday2">
                  <b>出生日期</b>
                </label>     
                <input type="date" class="form-control" name="ibirthday" id="ibirthday">      
                {{--<div class="input-group date" id="ibirthday" data-target-input="nearest">
                  <input type="text" name="ibirthday" class="form-control datetimepicker-input" data-target="#ibirthday"/>
                  <div class="input-group-append" data-target="#ibirthday" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div> --}}
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
              <div class="text-center">
                <button type="button" name="last" class="btn btn-dark px-4 mt-3 mx-3 mx-2" data-form="form2">上一步</button>
                <button type="button" name="check_next" id="second_next" class="btn btn-primary px-4 mt-3 mx-3 mx-2" data-form="form2">下一步，查看課程說明及場次</button>
              </div>
              <div class="text-center">
                <button type="button" id="submit_fast" class="btn btn-danger px-4 mt-3 mx-auto">直接報名</button>
              </div>
            </form>
              {{-- <button type="button" class="btn btn-dark px-4 mt-3 mx-3" onclick="secondlast(),topFunction()">上一步</button>
            <button type="button" class="btn btn-dark px-4 mt-3 mx-3" onclick="secondnext(),topFunction()">下一步</button> --}}
          </div>
          <div id="step3" style="display:none;">
            <form id="form3">
              @csrf
              @foreach( $course as $data)
              <div class="form-group mb-5">
                  <h5 class="font-weight-bold text-center my-3">參加課程服務</h5>
                  <textarea class="form-control border-0 bg-white" rows="8" disabled readonly>{{$data->courseservices}}</textarea>
                <hr>
                <h4 class="font-weight-bold text-center my-3">{{ $data->name }}</h4>
                <h4 class="font-weight-bold text-center my-3 text-secondary">一般方案：{{ $data->money }}</h4> 
              </div>

                @if( count($course) > 1)
                  <div class="d-flex" style="margin:5rem auto;"></div>
                @endif
              @endforeach
              <div class="form-group mb-5">
                <label class="col-form-label" for="ijoin">
                  <b>我想參加課程</b>
                </label>
                <div class="d-block my-2">
                  <div class="custom-control custom-radio my-1">
                    <input type="radio" id="ijoin1" name="ijoin" class="custom-control-input" value="0">
                    <label class="custom-control-label" for="ijoin1">現場最優惠價格</label>
                  </div>
                  <div class="custom-control custom-radio my-1">
                    <input type="radio" id="ijoin2" name="ijoin" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="ijoin2">五日內優惠價格</label>
                  </div>
                </div>
              </div>
              {{-- <button type="button" class="btn btn-dark px-4 mt-3 mx-3" onclick="thirdlast(),topFunction()">上一步</button>
              <button type="button" class="btn btn-dark px-4 mt-3 mx-3" onclick="thirdnext(),topFunction()">下一步</button> --}}
              
              <div class="text-center">
                <button type="button" name="last" class="btn btn-dark px-4 mt-3 mx-3" data-form="form3">上一步</button>
                <button type="button" name="next" class="btn btn-primary px-4 mt-3 mx-3" data-form="form3">下一步</button>
              </div>
            </form>
          </div>
          <div id="step4" style="display:none;">
            <form id="form4">
              @csrf
              {{-- <input type="hidden" id="events_len" name="events_len" value="{{ count($events) }}"> --}}
              @foreach( $events as $key => $data )
                <div class="form-group mb-5">
                  <label class="col-form-label" for="ievent">
                    <b>{{ $data['course_name'] }} 的場次</b>
                  </label>
                  @foreach( $data['events'] as $data_events )
                    <div class="d-block my-2">
                      <div class="custom-control custom-radio my-3">
                        <input type="radio" id="{{ $data_events['id_group'] }}" value="{{ $data_events['id_group'] }}" name="ievent{{ $key }}" class="custom-control-input ievent" data-idcourse="{{ $data['id_course'] }}">
                        <label class="custom-control-label h6" for="{{ $data_events['id_group'] }}">{{ $data_events['events'] }}</label>
                      </div>
                    </div>
                  @endforeach
                  <div class="d-block my-2">
                    <div class="custom-control custom-radio my-3">
                      <input type="radio" id="other{{ $key }}" value="other_val{{ $key }}" name="ievent{{ $key }}" class="custom-control-input ievent" data-idcourse="{{ $data['id_course'] }}">
                      {{-- <input type="hidden" id="other_val{{ $key }}" name="other_val{{ $key }}" value="{{ $data['id_course'] }}"> --}}
                      <label class="custom-control-label" for="other{{ $key }}">我要選擇其他場次</label>
                    </div>
                  </div>
                </div>
              @endforeach
              <div class="form-group mb-5">
                <label class="col-form-label" for="ipay_model">
                  <b>付款方式</b>
                </label>
                <div class="d-block my-2">
                  <div class="custom-control custom-radio my-1">
                    <input type="radio" id="ipay_model1" name="ipay_model" class="custom-control-input" value="0">
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
              <div class="form-group mb-5">
                <label class="col-form-label" for="icash">
                  <b>付款金額</b>
                </label>
                <input type="number" id="icash" name="icash" class="form-control">
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
              <div class="form-group mb-5">
                <label class="col-form-label" for="inumber">
                  <b>匯款帳號/卡號後五碼</b>
                </label>
                <input type="number" id="inumber" name="inumber" class="form-control">
                <label class="text-secondary px-2 py-1"><small>（付款完成請「截圖」回傳LINE@，謝謝）</small></label>
                <div class="invalid-feedback">
                  請輸入正確的匯款帳號/卡號後五碼
                </div>
              </div>
              <hr style="border: 0;">
              <div class="form-group mb-5">
                <label class="col-form-label" for="iinvoice">
                  <b>統一發票</b>
                </label>
                <div class="d-block my-2">
                  <div class="custom-control custom-radio my-1">
                    <input type="radio" id="iinvoice1" name="iinvoice" class="custom-control-input" value="0">
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
                <input type="number" id="inum" name="inum" class="form-control">
              </div>
              <div class="form-group mb-5">
                <label class="col-form-label" for="icompanytitle">
                  <b>抬頭</b>
                </label>
                <input type="text" id="icompanytitle" name="icompanytitle" class="form-control">
              </div>
              <div class="text-center">
                <button type="button" name="last" class="btn btn-dark px-4 mt-3 mx-3" data-form="form4">上一步</button>
                <button type="button" id="events_check" class="btn btn-primary px-4 mt-3 mx-3" data-form="form4">下一步</button>
              </div>
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
                  <label class="custom-control-label" for="agree_check1">我同意</label><span class="required_span"></span>
                </div>
                <textarea class="form-control bg-white" disabled readonly>課程服務限本人使用，不得轉讓他人使用。</textarea>
              </div>
              <hr>
              <div class="form-group my-5 required">
                <div class="custom-control custom-checkbox my-3">
                  <input type="checkbox" class="custom-control-input" id="agree_check2" name="agree" required>
                  <label class="custom-control-label" for="agree_check2">我同意</label><span class="required_span"></span>
                </div>
                <textarea rows="5" class="form-control bg-white" disabled readonly>如您於繳交費用後無法參加課程，請保留此表單備分內容。（報名完成會寄到您填寫的email）&#13;&#10;申請之退費方式、款項如下： &#13;&#10; 5日內全額退費（繳費後隔日起算）&#13;&#10;★第6日起：課程費用80%（繳交費用未達20%者，恕不辦理退費）&#13;&#10;★第31日起或開課後：恕不辦理退費。</textarea>
              </div>
              <hr>      
              <div class="form-group my-5 required">
                <div class="custom-control custom-checkbox my-3">
                  <input type="checkbox" class="custom-control-input" id="agree_check3" name="agree" required>
                  <label class="custom-control-label" for="agree_check3">我同意</label><span class="required_span"></span>
                </div>
                <textarea class="form-control bg-white" disabled readonly>報名完成後1年內須參加課程服務，逾期則不得參加課程服務，亦不得要求退還已繳交之費用。</textarea>
              </div>
              <hr>
              <div class="form-group my-5 required">
                <p>本人保證上述資料之真實性並願遵守本「課程服務合約」之內容（請簽中文正楷）<span class="required_span"></span></p>
                <!-- 電子簽章 -->
                {{-- <div> --}}
                  <canvas id="signature_pad" class="signature_pad border border-secondary" width="600" height="300"></canvas>
                {{-- </div>
                <div> --}}
                  <button type="button" id="signature_pad_clear" class="btn btn-secondary my-2">清除簽名</button>
                {{-- </div> --}}
              </div>
              <div class="text-center">
                <button type="button" name="last" class="btn btn-dark px-4 mt-3 mx-3" data-form="form5">上一步</button>
                <button type="button" id="preview" class="btn btn-primary px-4 mt-3 mx-3" data-form="form5">預覽後完成報名</button>
              </div>
            </form>
          </div>
          <div id="step6" style="display:none;">
              <div class="text-center">
                <button type="button" id="edit" class="btn btn-dark px-4 mt-3 mx-3" data-form="form6">編輯</button>
                <button type="button" id="submit" class="btn btn-danger px-4 mt-3" data-form="form6">確定報名</button>
              </div>
            {{-- <button id="confirmRegistration" type="submit" class="btn btn-dark px-4 mt-3 mx-3" >確認報名</button> --}}
          </div>
          <div id="complete" style="display:none;">
            <div class="text-center">
              <h1>報名完成！</h1>
            </div>
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
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

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
          $("#iname").val('');
          $("#isex1").click();
          $("#iid").val('');
          $("#iphone").val($('#iphone_verify').val());
          $("#iemail").val('');
          $("#ibirthday").val('');
          $("#icompany").val('');
          $("#iprofession").val('');
          $("#iaddress").val('');
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
        // var now = parseInt($(this).parent().attr("id").split("form").pop());
        var now = parseInt($(this).data("form").split("form").pop());
        next(now);
        

        // alert($("#step" + now + " input[required='required']")[0]].val());
        // if( $("#step" + now + " input[required='required']").val() == ""){
        //   alert("請輸入完整內容")
        //   return false;
        // }else{
        //   next(now);
        // }
      });



      //第二頁必填及輸入規則防呆
      $(function(){
          var forms = document.getElementsByClassName('needs-validation');
          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            document.getElementById("second_next").addEventListener("click", function(event) {
              var btn_next=this
              second_judge(btn_next,true)
              $("#form2 input").blur(function(){
                second_judge(btn_next,false)
              })
            
          });
        }, false);

      })

      function second_judge(x,send){
        // console.log(x)
        var successful=true
        if($('#iname').val()==""){
            // console.log("NR");
            $("#iname").addClass("is-invalid");
            successful=false
        }
        else{
          $("#iname").removeClass("is-invalid");
    
        }
        
        if($('#iphone').val()==""){
            // console.log("NR");
            $("#iphone").addClass("is-invalid");
            successful=false
        }
        else{
          var rule1=/^\d*$/
          if(!rule1.test($('#iphone').val())){
            $("#iphone").addClass("is-invalid");
            successful=false
          }
          else{
            $("#iphone").removeClass("is-invalid");
            
          }
        }

        
          if($('#iid').val()!=""){
              
              var rule1=/^[A-Z]1|2\d{8}/
              if(!rule1.test($('#iid').val())){
                $("#iid").addClass("is-invalid");
                successful=false
              }
              else{
                $("#iid").removeClass("is-invalid");
              }
          }
          else{
            $("#iid").removeClass("is-invalid");
          }

          if($('#iemail').val()!=""){
              
              var rule1=/^([a-zA-Z0-9]+[-_\.]?)+@[a-zA-Z0-9]+\.[a-z]+$/
              if(!rule1.test($('#iemail').val())){
                $("#iemail").addClass("is-invalid");
                successful=false
              }
              else{
                $("#iemail").removeClass("is-invalid");
              }
          }
          else{
            $("#iemail").removeClass("is-invalid");
          }
          
          if(successful && send){
            // console.log("IR");
            
            // var now = parseInt($(x).parent().attr("id").split("form").pop());
            
            var now = parseInt($(x).data("form").split("form").pop());
            // console.log(now)
            next(now);
          }
        
        }
        //匯款帳號/卡號後五碼規則防呆
        $("#events_check").click(function(){
          // var now = parseInt($(this).parent().attr("id").split("form").pop());
          var now = parseInt($(this).data("form").split("form").pop());
          if($('#inumber').val()!=""){
              
              var rule1=/^\d{5}$/
              if(!rule1.test($('#inumber').val())){
                $("#inumber").addClass("is-invalid");
                
              }
              else{
                $("#inumber").removeClass("is-invalid");
                // console.log("IR");   
                next(now);
              }
          }
          else{
            $("#inumber").removeClass("is-invalid");
            // console.log("IR"); 
            next(now);
          }
	});

  //我同意checkbox防呆
  $("#preview").click(function(){
    
    //電子簽名驗證
    if(signaturePad.isEmpty()) {
      alert("請中文正楷簽章!");
      return false ;
    }

			var check2=$("input[name='agree']:checked").length;//判斷有多少個方框被勾選
			if(check2==0){
        // console.log("NR");
				alert("請詳細閱讀三項課程服務須知，完成請勾選我同意。");
				
			}else if(check2==1){
        // console.log("NR");
				alert("請詳細閱讀三項課程服務須知，完成請勾選我同意，您只勾選一項。");
				
      }else if(check2==2){
        // console.log("NR");
				alert("請詳細閱讀三項課程服務須知，完成請勾選我同意，您只勾選兩項。");
				
			}else{
          //預覽 Sandy (2020/03/05)
            $("form").parent().show()
            $("form").parent().find("button").hide()
            $("input").prop( "disabled" , true );
            $("#step1").hide();
            $("#step6").show();
            $("body").scrollTop(0);
			}
	});

  
  //下一步跳頁 Sandy (2020/03/05)
  function next(now){ 
    $("#step" + now).hide()
    $("#step" + (now + 1)).show()
    $("body").scrollTop(0);
  }

  //上一步按鈕 Sandy (2020/03/05)
  $("button[name='last']").click(function(){
    // var now = parseInt($(this).parent().attr("id").split("form").pop());
    var now = parseInt($(this).data("form").split("form").pop());
    
    $("#step" + now).hide()
    $("#step" + (now - 1)).show()
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

    //電子簽名驗證
    if(signaturePad.isEmpty()) {
      alert("請中文正楷簽章!");
      return false ;
    }

    //get data
    var source_course = $('#course_id').val();
    var source_events = $('#events_id').val();
    // var idate = new Date();
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
    var id_group = $('#form4 .ievent:radio:checked').map(function(){
      return $(this).val();
    }).get();
    var array_course = $('#form4 .ievent:radio:checked').map(function(){
      return $(this).data('idcourse');
    }).get();
    // var events_len = $('#events_len').val();
    var source_events = $('#source_events').val();

    //電子簽名
    var canvas = document.getElementById('signature_pad');
    var dataURL = canvas.toDataURL();
    

    $.ajax({
      type:'POST',
      url:'course_form_insert',
      data:{
        '_token':"{{ csrf_token() }}",
        // idate : idate,
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
        icompanytitle : icompanytitle,
        id_group : id_group,
        source_events : source_events,
        array_course: array_course,
        imgBase64: dataURL
      },
      success:function(data){
        console.log(data);  

        if( data == 'success' ){
          alert('恭喜報名成功 ！');
          location.reload();
        }else if( data == 'error : sign'){
          alert('報名失敗，電子簽章有誤。');
          location.reload();
        }else{
          alert('報名失敗');
          location.reload();
        }

      },
      error: function(jqXHR, textStatus, errorMessage){
          console.log("error: "+ errorMessage);    
            console.log(JSON.stringify(jqXHR)); 
      }
    });
  });

  
  //快速報名 Sandy (2020/04/18)
  $("#submit_fast").click(function(){

    //get data
    var source_course = $('#course_id').val();
    var source_events = $('#events_id').val();
    // var idate = new Date();
    var iname = $('#iname').val();
    var isex = $('input[name="isex"]:checked').val();
    var iid = $('#iid').val();
    var iphone = $('#iphone').val();
    var iemail = $('#iemail').val();
    var ibirthday = $('#ibirthday').val();
    var icompany = $('#icompany').val();
    var iprofession = $('#iprofession').val();
    var iaddress = $('#iaddress').val();    

    $.ajax({
      type:'POST',
      url:'course_form_insert',
      data:{
        '_token':"{{ csrf_token() }}",
        // idate : idate,
        iname : iname,
        isex : isex,
        iid : iid,
        iphone : iphone,
        iemail : iemail,
        ibirthday : ibirthday,
        icompany : icompany,
        iprofession : iprofession,
        iaddress : iaddress,        
      },
      success:function(data){
        console.log(data);  

        if( data == 'success' ){
          alert('報名成功！');
          location.reload();
        }else if( data == 'error : sign'){
          alert('報名失敗，電子簽章有誤。');
          location.reload();
        }else{
          alert('報名失敗');
          location.reload();
        }

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

  // $('#confirmRegistration').on('click', function() {
    // 驗證有無簽章
  //   if(signaturePad.isEmpty()) {
  //     alert("請中文正楷簽章!");
  //     return false ;
  //   } else {
  //     var canvas = document.getElementById('signature_pad');
  //     var dataURL = canvas.toDataURL();
  //     $.ajax({
  //       type: "POST",
  //       headers: {
  //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //       },
  //       url: "signature",
  //       data: {
  //         imgBase64: dataURL
  //       }
  //     }).done(function(res) {
  //       console.log(res);
  //     });
  //   }
  // });


</script>

</html>
