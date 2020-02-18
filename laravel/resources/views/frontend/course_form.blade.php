<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="csrf-token"  content="{{ csrf_token() }}">
  <title>報名表單 | 無極限學員系統</title>

  {{-- <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/dashboard/"> --}}
  
  <!-- Bootstrap core CSS -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  {{-- <link href="https://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> --}}
  
    <!-- Fontawesome Icon -->
  {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
    integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"> --}}
  <link href="{{ asset('font-awesome/css/all.css') }}" rel="stylesheet">

  <!-- Custom styles -->
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
  <link href="{{ asset('css/web.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
  
{{-- <div class="container-fluid"> --}}
  <main role="main" class="mw-100">
    <form id="course_form">
      <img src="./img/logo.png" width="150" alt="logo" class="d-block mx-auto mt-5">
      <h3 class="text-center text-white m-4">無極限國際有限公司</h3>
      <div class="card m-auto w-50">
        <div class="card-body container px-4 p-3">
          {{-- <ul style="list-style:none;padding: 0; " id="firstpage"> --}}
          <ul id="firstpage">
            <li class="form-group">
              <label for="rphone">
                <b>手機號碼</b>
              </label>
              <input type="text" name="rphone" required class="form-control" id="phone_num">
            </li>
            <button type="button" class="step_btn float-right" id="page1_next" onclick="firstnext(),topFunction()">下一步</button>
          </ul>
          {{-- <ul style="list-style:none;padding: 0; display:none; " id="secondpage">
            <li><label for="rname"><b>姓名</b></label><br/>
                <label name="rname" required readonly>王阿明</label>
            </li>
            <li><label for="rphone"><b>聯絡電話</b></label><br/>
                <label name="rphone" required readonly>0912345678</label>
            </li>
            <li><label for="remail"><b>電子郵件</b></label><br/>
                <label name="remail" required readonly>abc@gmail.com</label>
            </li>
            <li><label for="rwork"><b>職業</b></label><br/>
                <label name="rwork" required readonly>資訊業</label>
            </li>
            <button type="button" class="step_btn" onclick="secondnext(),topFunction(),ShowData()">非本人資料</button>
            <button type="button" class="step_btn" onclick="thirdnext(),topFunction()">確認資料</button>
          </ul> --}}
          <ul style="display:none;" id="secondpage">
            <li class="form-group">
              <label for="rdate">
                <b>報名日期</b>
              </label>
              <input type="date" name="rdate" id="rdate" class="form-control" disabled readonly>
            </li>
            <li class="form-group">
              <label for="rname">
                <b>姓名</b>
              </label>
              <input type="text" name="rname" class="form-control" value="王阿明" required>
            </li>
            <li class="form-group">
              <label for="sex">
                <b>性別</b>
              </label>
              <div class="my-8">
                <input type="radio" name="male" value="男"/>
                <input type="radio" name="female" value="女"/>
              </div>
            </li>
            <li class="form-group">
              <label for="rid">
                <b>身分證字號</b>
              </label>
              <input type="text" name="rid" class="form-control" required>
            </li>
            <li class="form-group">
              <label for="rphone">
                <b>聯絡電話</b>
              </label>
              <input type="text" name="rphone" class="form-control" id="contact_num" value="0912345678" required>
            </li>
            <li class="form-group">
              <label for="remail">
                <b>電子郵件</b>
              </label>
              <input type="text" name="remail" class="form-control" value="abc@gmail.com" required>
            </li>
            <li class="form-group">
              <label for="born">
                <b>出生日期</b>
              </label>           
              <input type="date" name="born" class="form-control" required>                     
            </li>
            <li class="form-group">
              <label for="rcompany">
                <b>公司名稱</b>
              </label>
              <input type="text" name="rcompany" class="form-control" required>
            </li>
            <li class="form-group">
              <label for="rwork">
                <b>職業</b>
              </label>
              <input type="text" name="rwork" class="form-control" value="資訊業" required>
            </li>
            <li class="form-group">
              <label for="raddress">
                <b>聯絡地址</b>
              </label>
              <input type="text" name="raddress" class="form-control" required>
            </li>
            <button type="button" class="step_btn float-left" onclick="secondlast(),topFunction()">上一步</button>
            <button type="button" class="step_btn float-right" onclick="secondnext(),topFunction()">下一步</button>
          </ul>
          <ul style="display:none; " id="thirdpage">
            <li class="form-group">
              <p style="text-align: center;"><span style="font-size: 14pt;"><strong>參加課程服務</strong></span></p>
              <ul>
                <li style="text-align: left;">
                  <span style="font-size: 14pt;">
                    四組專屬交易策略
                  </span>
                </li>
                <li style="text-align: left;">
                  <span style="font-size: 14pt;">
                    超過10組季節性交易資訊＜勝率超過7成＞
                  </span>
                </li>
                <li style="text-align: left;">
                  <span style="font-size: 14pt;">
                    三項每日操盤策略＜每日20分鐘＞
                  </span>
                </li>
                <li style="text-align: left;">
                  <span style="font-size: 14pt;">
                    操盤交易心理，風險控管
                  </span>
                </li>
              </ul>
              <hr>
              <ul>
                <li style="text-align: left;">
                  <span style="font-size: 14pt;">
                    兩整天實體課程培訓/六個月諮詢輔導教練
                  </span>
                </li>
                <li style="text-align: left;">
                  <span style="font-size: 14pt;">
                    終身免學費複訓(須酌收場地費)
                  </span>
                </li>
                <li style="text-align: left;">
                  <span style="font-size: 14pt;">
                    刷卡零利率分期(限配合之銀行)
                  </span>
                </li>
                <li style="text-align: left;">
                  <span style="font-size: 14pt;">
                    三天內完款-贈最少100支線上課程＜含：前導、課前、課後＞
                  </span>
                </li>
              </ul>
              <hr>
              <p style="text-align: center;"> <strong><span style="font-size: 18pt;">自在交易工作坊</span></strong></p>
              <p style="text-align: center;"><strong><span style="font-size: 18pt;">一般方案：998,00</span></strong></p>                    
            </li>
            <li class="form-group">
              <label for="join">
                <b>我想參加課程</b>
              </label>
              <div style="margin: 8px 0;">
                <input type="radio"  name="preferential" >現場最優惠價格<br>
                <input type="radio"  name="five" >五日內優惠價格
              </div>
            </li>
            <button type="button" class="step_btn float-left" onclick="thirdlast(),topFunction()">上一步</button>
            <button type="button" class="step_btn float-right" onclick="thirdnext(),topFunction()">下一步</button>
          </ul>
          <ul style="display:none;" id="forthpage">
            <li class="form-group">
              <label for="pay">
                <b>付款方式</b>
              </label>
              <div style="margin: 8px 0;">
                <input type="radio"  name="pay1" >現金<br>
                <input type="radio"  name="pay2" >匯款<br>
                <input type="radio"  name="pay3" >刷卡:輕鬆付<br>
                <input type="radio"  name="pay4" >刷卡:一次付
              </div>
            </li>
            <li class="form-group">
              <label for="price">
                <b>付款金額</b>
              </label>
              <input type="text" name="price" required class="form-control">(實際金額以財務確認為準)
            </li>
            <hr>
            <div style="margin:20px auto;">
              <p style="text-align: center;"><span style="font-size: 18pt;">匯款資訊</span></p>
              <p>中國信託商業銀行中壢分行(代碼822)</p>
              <p>戶名：無極限國際有限公司</p>
              <p>帳號：129541438753</p>
              <p style="text-align: center;"><span style="font-size: 18pt;">刷卡連結(會再附上連結)</span></p>
            </div>
            <hr>
            <li class="form-group">
              <label for="num">
                <b>匯款帳號/卡號後五碼</b>
              </label>
              <input type="text" name="num" required class="form-control">(付款完成請「截圖」回傳LINE@，謝謝)
            </li>
            <hr style="border: 0;">
            <li class="form-group">
              <label for="invoice">
                <b>統一發票</b>
              </label>
              <div style="margin: 8px 0;">
                <input type="radio"  name="invoice1" >捐贈社會福利機構(由無極限國際公司另行辦理)<br>
                <input type="radio"  name="invoice2" >二聯式<br>
                <input type="radio"  name="invoice3" >三聯式
              </div>
            </li>
            <li class="form-group">
              <label for="num">
                <b>統編</b>
              </label>
              <input type="text" name="num" required class="form-control">
            </li>
            <li class="form-group">
              <label for="num">
                <b>抬頭</b>
              </label>
              <input type="text" name="num" required class="form-control">
            </li>
            <button type="button" class="step_btn float-left" onclick="forthlast(),topFunction()">上一步</button>
            <button type="button" class="step_btn float-right" onclick="forthnext(),topFunction()">下一步</button>
          </ul>
          <ul style="display:none;" id="fifthpage">
            <li >
              <p style="text-align: center;">
                <span style="font-size: 24pt;">
                  <strong>課程服務須知</strong>
                </span>
              </p>
              <p style="text-align: center;">
                <span style="font-size: 14pt;">
                  <strong>請詳讀後勾選</strong>
                </span>
              </p>
            </li>
            <li class="form-group">
              <p>
                <input type="checkbox" name="agree" id="agree_check1" onchange="check()" />
                我同意
              </p>
              <textarea readonly style="width: 100%; font-size: 18px;">
                課程服務限本人使用，不得轉讓他人使用。
              </textarea>
            </li>
            <hr>
            <li class="form-group">
              <p>
                <input type="checkbox" name="agree" id="agree_check2" onchange="check()" />
                我同意
              </p>
              <textarea readonly style="width: 100%; height: 200px; font-size: 18px;">
                如您於繳交費用後無法參加課程，請保留此表單備分內容。(報名完成會寄到您填寫的email)
                申請之退費方式、款項如下：
                ★5日內全額退費(繳費後隔日起算)  
                ★第6日起：課程費用80%(繳交費用未達20%者，恕不辦理退費) 
                ★第31日起或開課後：恕不辦理退費。
              </textarea>
            </li>
            <hr>      
            <li class="form-group">
              <p>
                <input type="checkbox" name="agree" id="agree_check3" onchange="check()" />
                我同意
              </p>
              <textarea readonly style="width: 100%; font-size: 18px;">
                報名完成後1年內須參加課程服務，逾期則不得參加課程服務，亦不得要求退還已繳交之費用。
              </textarea>
            </li>
            <hr>
            <li class="form-group">
              <p>
                本人保證上述資料之真實性並願遵守本「課程服務合約」之內容(請簽中文正楷)
              </p>
              <textarea readonly style="width: 100%; height: 200px; font-size: 18px;">
              </textarea>
            </li>
            <button type="button" class="step_btn float-left" onclick="fifthlast(),topFunction()">上一步</button>
            <button type="button" class="step_btn float-right" onclick="fifthnext(),topFunction()">預覽確認</button>
          </ul>
          <ul style="display:none; " id="sixthpage">
            <li class="form-group">
              <label for="rdate">
                <b>報名日期</b>
              </label>
              <br/>
              <label name="rdate" readonly>2020-1-3</label>
            </li>
            <li class="form-group">
              <label for="rname">
                <b>姓名</b>
              </label>
              <br/>
              <label name="rname" readonly>王阿明</label>
            </li>
            <li class="form-group">
              <label for="sex">
                <b>性別</b>
              </label>
              <br/>
              <label name="sex" readonly>男</label>
            </li>
            <li class="form-group">
              <label for="rid">
                <b>身分證字號</b>
              </label>
              <br/>
              <label name="sex" readonly>S123456789</label>
            </li>
            <li class="form-group">
              <label for="rphone">
                <b>聯絡電話</b>
              </label>
              <br/>
              <label name="rphone" readonly>0912345678</label>
            </li>
            <li class="form-group">
              <label for="remail">
                <b>電子郵件</b>
              </label>
              <br/>
              <label name="remail" readonly>abc@gmail.com</label>
            </li>
            <li class="form-group">
              <label for="born">
                <b>出生日期</b>
              </label>
              <br/>
              <label name="born" readonly>1980-1-1</label>                         
            </li>
            <li class="form-group">
              <label for="rcompany">
                <b>公司名稱</b>
              </label>
              <br/>
              <label name="rcompany" readonly>無極限</label> 
            </li>
            <li class="form-group">
              <label for="rwork">
                <b>職業</b>
              </label>
              <br/>
              <label name="rwork" readonly>資訊業</label> 
            </li>
            <li class="form-group">
              <label for="raddress">
                <b>聯絡地址</b>
              </label>
              <br/>
              <label name="raddress" readonly>中壢</label> 
            </li>
            <li class="form-group">
              <label for="join">
                <b>我想參加課程</b>
              </label>
              <br/>
              <label name="join" readonly>現場最優惠價格</label> 
            </li>
            <li class="form-group">
              <label for="pay">
                <b>付款方式</b>
              </label>
              <br/>
              <label name="pay" readonly>現金</label> 
            </li>
            <li class="form-group">
              <label for="price">
                <b>付款金額</b>
              </label>
              <br/>
              <label name="price" readonly>1000</label> 
            </li>
            <li class="form-group">
              <label for="num">
                <b>匯款帳號/卡號後五碼</b>
              </label>
              <br/>
              <label name="num" readonly>55332</label> 
            </li>
            <li class="form-group">
              <label for="invoice">
                <b>統一發票</b>
              </label>
              <br/>
              <label name="invoice" readonly>
                二聯式
              </label> 
            </li>
            <li class="form-group">
              <label for="num2">
                <b>統編</b>
              </label>
              <br/>
              <label name="num2" readonly>38424596</label> 
            </li>
            <li class="form-group">
              <label for="num3">
                <b>抬頭</b>
              </label>
              <br/>
              <label name="num3" readonly>無極限</label> 
            </li>
            <button type="button" class="step_btn float-left" onclick="sixthlast(),topFunction()">上一步</button>
            <button type="submit" class="step_btn float-right" >確認報名</button>
          </ul>  
        </div>
      </div>
    </form>
  </main>
{{-- </div> --}}

  {{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script> --}}
  {{-- <script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
  <script src="https://getbootstrap.com/docs/4.4/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
    crossorigin="anonymous"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script> --}}
  <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/feather.min.js') }}"></script>
  {{-- <script src="{{ asset('js/dashboard.js') }}"></script> --}}
  <script src="{{ asset('js/form.js') }}"></script>

</body>

</html>