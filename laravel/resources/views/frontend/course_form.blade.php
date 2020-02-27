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
  
{{-- <div class="container-fluid"> --}}
  <main role="main" class="mw-100">
    {{-- <form id=""> --}}
      <img src="./img/logo.png" width="150" alt="logo" class="d-block mx-auto mt-5">
      <h3 class="text-center text-white m-4">無極限國際有限公司</h3>
      <div class="card m-auto w-50">
        <div class="card-body container px-4 p-3">
          <form id="course_form" class="form" action="{{ url('course_form_insert') }}" method="POST">
            @csrf
            {{-- <div style="list-style:none;padding: 0; " id="firstpage"> --}}
            {{-- <div id="firstpage">
              <form class="form" action="{{ url('course_form_show') }}" method="POST">
                @csrf
                  <div class="form-group mb-5">
                    <label for="rphone">
                      <b>手機號碼</b>
                    </label>
                    <input type="text" id="rphone_firstpage" name="rphone" class="form-control" required>
                  </div>
                  <button type="submit" class="btn btn-dark w-25 mt-3 float-right" id="page1_next" onclick="firstnext(),topFunction()">下一步</button>
              </form>
            </div> --}}
            <div id="secondpage">
              <div class="form-group mb-5">
                <label for="idate">
                  <b>報名日期</b>
                </label>
                <input type="text" id="idate" name="idate" class="form-control" disabled readonly>
              </div>
              <div class="form-group mb-5">
                <label for="iname">
                  <b>姓名</b>
                </label>
                <input type="text" id="iname" name="iname" class="form-control" value="" required>
              </div>
              <div class="form-group mb-5">
                <label for="isex">
                  <b>性別</b>
                </label>
                <div class="d-block my-2">
                  {{-- <input type="radio" name="male" value="0"/>
                  <input type="radio" name="female" value="1"/> --}}
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
                <label for="iid">
                  <b>身分證字號</b>
                </label>
                <input type="text" id="iid" name="iid" class="form-control" required>
              </div>
              <div class="form-group mb-5">
                <label for="iphone">
                  <b>聯絡電話</b>
                </label>
                <input type="text" id="iphone" name="iphone" class="form-control" required>
              </div>
              <div class="form-group mb-5">
                <label for="iemail">
                  <b>電子郵件</b>
                </label>
                <input type="text" id="iemail" name="iemail" class="form-control" required>
              </div>
              <div class="form-group mb-5">
                <label for="ibirthday">
                  <b>出生日期</b>
                </label>           
                <input type="date" id="ibirthday" name="ibirthday" class="form-control" required>                     
              </div>
              <div class="form-group mb-5">
                <label for="icompany">
                  <b>公司名稱</b>
                </label>
                <input type="text" id="icompany" name="icompany" class="form-control" required>
              </div>
              <div class="form-group mb-5">
                <label for="iprofession">
                  <b>職業</b>
                </label>
                <input type="text" id="iprofession" name="iprofession" class="form-control" value="資訊業" required>
              </div>
              <div class="form-group mb-5">
                <label for="iaddress">
                  <b>聯絡地址</b>
                </label>
                <input type="text" id="iaddress" name="iaddress" class="form-control" required>
              </div>
              {{-- <button type="button" class="btn btn-dark w-25 mt-3 float-left" onclick="secondlast(),topFunction()">上一步</button>
              <button type="button" class="btn btn-dark w-25 mt-3 float-right" onclick="secondnext(),topFunction()">下一步</button> --}}
            {{-- </div>
            <div style="display:none;" id="thirdpage"> --}}
              <div class="form-group mb-5">
                <p style="text-align: center;"><span style="font-size: 14pt;"><strong>參加課程服務</strong></span></p>
                <div>
                  <div style="text-align: left;">
                    <span style="font-size: 14pt;">
                      四組專屬交易策略
                    </span>
                  </div>
                  <div style="text-align: left;">
                    <span style="font-size: 14pt;">
                      超過10組季節性交易資訊＜勝率超過7成＞
                    </span>
                  </div>
                  <div style="text-align: left;">
                    <span style="font-size: 14pt;">
                      三項每日操盤策略＜每日20分鐘＞
                    </span>
                  </div>
                  <div style="text-align: left;">
                    <span style="font-size: 14pt;">
                      操盤交易心理，風險控管
                    </span>
                  </div>
                </div>
                <hr>
                <div>
                  <div style="text-align: left;">
                    <span style="font-size: 14pt;">
                      兩整天實體課程培訓/六個月諮詢輔導教練
                    </span>
                  </div>
                  <div style="text-align: left;">
                    <span style="font-size: 14pt;">
                      終身免學費複訓(須酌收場地費)
                    </span>
                  </div>
                  <div style="text-align: left;">
                    <span style="font-size: 14pt;">
                      刷卡零利率分期(限配合之銀行)
                    </span>
                  </div>
                  <div style="text-align: left;">
                    <span style="font-size: 14pt;">
                      三天內完款-贈最少100支線上課程＜含：前導、課前、課後＞
                    </span>
                  </div>
                </div>
                <hr>
                <p style="text-align: center;"> <strong><span style="font-size: 18pt;">自在交易工作坊</span></strong></p>
                <p style="text-align: center;"><strong><span style="font-size: 18pt;">一般方案：998,00</span></strong></p>                    
              </div>
              <div class="form-group mb-5">
                <label for="ijoin">
                  <b>我想參加課程</b>
                </label>
                <div class="d-block my-2">
                  <div class="custom-control custom-radio my-1">
                    <input type="radio" id="ijoin1" name="ijoin" class="custom-control-input" checked>
                    <label class="custom-control-label" for="ijoin1">現場最優惠價格</label>
                  </div>
                  <div class="custom-control custom-radio my-1">
                    <input type="radio" id="ijoin2" name="ijoin" class="custom-control-input">
                    <label class="custom-control-label" for="ijoin2">五日內優惠價格</label>
                  </div>
                </div>
                {{-- <div style="margin: 8px 0;">
                  <input type="radio"  name="preferential" >現場最優惠價格<br>
                  <input type="radio"  name="five" >五日內優惠價格
                </div> --}}
              </div>
              {{-- <button type="button" class="btn btn-dark w-25 mt-3 float-left" onclick="thirdlast(),topFunction()">上一步</button>
              <button type="button" class="btn btn-dark w-25 mt-3 float-right" onclick="thirdnext(),topFunction()">下一步</button>
            </div>
            <div style="display:none;" id="forthpage"> --}}
              <div class="form-group mb-5">
                <label for="ipay_model">
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
                {{-- <div style="margin: 8px 0;">
                  <input type="radio"  name="pay1" >現金<br>
                  <input type="radio"  name="pay2" >匯款<br>
                  <input type="radio"  name="pay3" >刷卡:輕鬆付<br>
                  <input type="radio"  name="pay4" >刷卡:一次付
                </div> --}}
              </div>
              <div class="form-group mb-5">
                <label for="ievent">
                  <b>60天財富計畫 的場次</b>
                </label>
                <div class="d-block my-2">
                  <div class="custom-control custom-radio my-1">
                    <input type="radio" id="ievent1" name="ievent" class="custom-control-input" checked>
                    <label class="custom-control-label" for="ievent1">2020/01/14（二）0900-1700 台北場(台北市中山區松江路131號7樓)</label>
                  </div>
                </div>
              </div>
              <div class="form-group mb-5">
                <label for="icash">
                  <b>付款金額</b>
                </label>
                <input type="text" id="icash" name="icash" class="form-control" required>
                <label class="text-secondary px-2 py-1"><small>（實際金額以財務確認為準）</small></label>
              </div>
              <hr>
              <div style="margin:20px auto;">
                <p style="text-align: center;"><span style="font-size: 18pt;">匯款資訊</span></p>
                <p>中國信託商業銀行中壢分行(代碼822)</p>
                <p>戶名：無極限國際有限公司</p>
                <p>帳號：129541438753</p>
                <p style="text-align: center;"><span style="font-size: 18pt;">刷卡連結(會再附上連結)</span></p>
              </div>
              <hr>
              <div class="form-group mb-5">
                <label for="inumber">
                  <b>匯款帳號/卡號後五碼</b>
                </label>
                <input type="text" id="inumber" name="inumber" class="form-control" required>(付款完成請「截圖」回傳LINE@，謝謝)
              </div>
              <hr style="border: 0;">
              <div class="form-group mb-5">
                <label for="iinvoice">
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
                {{-- <div style="margin: 8px 0;">
                  <input type="radio"  name="invoice1" >捐贈社會福利機構(由無極限國際公司另行辦理)<br>
                  <input type="radio"  name="invoice2" >二聯式<br>
                  <input type="radio"  name="invoice3" >三聯式
                </div> --}}
              </div>
              <div class="form-group mb-5">
                <label for="inum">
                  <b>統編</b>
                </label>
                <input type="text" id="inum" name="inum" class="form-control" required>
              </div>
              <div class="form-group mb-5">
                <label for="icompanytitle">
                  <b>抬頭</b>
                </label>
                <input type="text" id="icompanytitle" name="icompanytitle" required class="form-control">
              </div>
              {{-- <button type="button" class="btn btn-dark w-25 mt-3 float-left" onclick="forthlast(),topFunction()">上一步</button>
              <button type="button" class="btn btn-dark w-25 mt-3 float-right" onclick="forthnext(),topFunction()">下一步</button>
            </div>
            <div style="display:none;" id="fifthpage"> --}}
              <div >
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
              </div>
              <div class="form-group mb-5">
                <p>
                  <input type="checkbox" name="agree" id="agree_check1" onchange="check()" />
                  我同意
                </p>
                <textarea readonly style="width: 100%; font-size: 18px;">
                  課程服務限本人使用，不得轉讓他人使用。
                </textarea>
              </div>
              <hr>
              <div class="form-group mb-5">
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
              </div>
              <hr>      
              <div class="form-group mb-5">
                <p>
                  <input type="checkbox" name="agree" id="agree_check3" onchange="check()" />
                  我同意
                </p>
                <textarea readonly style="width: 100%; font-size: 18px;">
                  報名完成後1年內須參加課程服務，逾期則不得參加課程服務，亦不得要求退還已繳交之費用。
                </textarea>
              </div>
              <hr>
              <div class="form-group mb-5">
                <p>
                  本人保證上述資料之真實性並願遵守本「課程服務合約」之內容(請簽中文正楷)
                </p>
                <textarea readonly style="width: 100%; height: 200px; font-size: 18px;">
                </textarea>
              </div>
              {{-- <button type="button" class="btn btn-dark w-25 mt-3 float-left" onclick="fifthlast(),topFunction()">上一步</button>
              <button type="button" class="btn btn-dark w-25 mt-3 float-right" onclick="fifthnext(),topFunction()">預覽確認</button> --}}
            </div>
            <button type="submit" class="btn btn-dark w-25 mt-3 float-right" >確認報名</button>
            {{-- <div style="display:none;" id="sixthpage">
              <div class="form-group mb-5">
                <label for="rdate">
                  <b>報名日期</b>
                </label>
                <br/>
                <label id="rdate" name="rdate" readonly>2020-1-3</label>
              </div>
              <div class="form-group mb-5">
                <label for="rname">
                  <b>姓名</b>
                </label>
                <br/>
                <label id="rname" name="rname" readonly>王阿明</label>
              </div>
              <div class="form-group mb-5">
                <label for="rsex">
                  <b>性別</b>
                </label>
                <br/>
                <label id="rsex" name="rsex" readonly>男</label>
              </div>
              <div class="form-group mb-5">
                <label for="rid">
                  <b>身分證字號</b>
                </label>
                <br/>
                <label id="rid" name="rid" readonly>S123456789</label>
              </div>
              <div class="form-group mb-5">
                <label for="rphone">
                  <b>聯絡電話</b>
                </label>
                <br/>
                <label id="rphone" name="rphone" readonly>0912345678</label>
              </div>
              <div class="form-group mb-5">
                <label for="remail">
                  <b>電子郵件</b>
                </label>
                <br/>
                <label id="remail" name="remail" readonly>abc@gmail.com</label>
              </div>
              <div class="form-group mb-5">
                <label for="rbirthday">
                  <b>出生日期</b>
                </label>
                <br/>
                <label id="rbirthday" name="rbirthday" readonly>1980-1-1</label>                         
              </div>
              <div class="form-group mb-5">
                <label for="rcompany">
                  <b>公司名稱</b>
                </label>
                <br/>
                <label id="rcompany" name="rcompany" readonly>無極限</label> 
              </div>
              <div class="form-group mb-5">
                <label for="rprofession">
                  <b>職業</b>
                </label>
                <br/>
                <label id="rprofession" name="rprofession" readonly>資訊業</label> 
              </div>
              <div class="form-group mb-5">
                <label for="raddress">
                  <b>聯絡地址</b>
                </label>
                <br/>
                <label id="raddress" name="raddress" readonly>中壢</label> 
              </div>
              <div class="form-group mb-5">
                <label for="rjoin">
                  <b>我想參加課程</b>
                </label>
                <br/>
                <label id="rjoin" name="rjoin" readonly>現場最優惠價格</label> 
              </div>
              <div class="form-group mb-5">
                <label for="rpay">
                  <b>付款方式</b>
                </label>
                <br/>
                <label id="rpay" name="rpay" readonly>現金</label> 
              </div>
              <div class="form-group mb-5">
                <label for="rcash">
                  <b>付款金額</b>
                </label>
                <br/>
                <label id="rcash" name="rcash" readonly>1000</label> 
              </div>
              <div class="form-group mb-5">
                <label for="rnumber">
                  <b>匯款帳號/卡號後五碼</b>
                </label>
                <br/>
                <label id="rnumber" name="rnumber" readonly>55332</label> 
              </div>
              <div class="form-group mb-5">
                <label for="rinvoice">
                  <b>統一發票</b>
                </label>
                <br/>
                <label id="rinvoice" name="rinvoice" readonly>
                  二聯式
                </label> 
              </div>
              <div class="form-group mb-5">
                <label for="num">
                  <b>統編</b>
                </label>
                <br/>
                <label id="num" name="num" readonly>38424596</label> 
              </div>
              <div class="form-group mb-5">
                <label for="rcompanytitle">
                  <b>抬頭</b>
                </label>
                <br/>
                <label id="rcompanytitle" name="rcompanytitle" readonly>無極限</label> 
              </div>
              <button type="button" class="btn btn-dark w-25 mt-3 float-left" onclick="sixthlast(),topFunction()">上一步</button>
              <button type="submit" class="btn btn-dark w-25 mt-3 float-right" >確認報名</button>
            </div>   --}}
          </div>
        </form>
      </div>
    {{-- </form> --}}
  </main>

  <!-- Rocky(2020/01/11) -->
  @if (session('status') == "匯入成功")
  <div class="alert alert-success alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">
    {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @elseif (session('status') == "匯入失敗" || session('status') == "請選檔案/填講師姓名")  
  <div class="alert alert-danger alert-dismissible fade show m-3 alert_fadeout position-absolute fixed-bottom" role="alert">
    {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
</body>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/feather.min.js') }}"></script>
<script src="{{ asset('js/form.js') }}"></script>
</html>