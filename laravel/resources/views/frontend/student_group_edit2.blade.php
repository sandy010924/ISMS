@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '創建細分組')

@section('content')
<!-- Content Start -->
        <!--學員細分組內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row">
              <div class="col form-inline">
                <span class="p-1 border border-secondary rounded-pill ">
                  <small class="text-secondary">篩選器1</small>
                </span>
                <h5 class="mx-2 mb-0">符合下列</h5>
                <div class="form-group m-0">
                  <select class="custom-select border-0 bg-transparent" name="filter">
                    <option value="1">全部</option>
                    <option value="2">姓名</option>
                    <option value="3">聯絡電話</option>
                    <option value="4">電子郵件</option>
                    <option value="5">來源</option>
                    <option value="6">加入日期</option>
                  </select>
                 </div>                
              </div>
            </div>
            <div class="row">
              <div class="col-2 ">
                  <select multiple class="form-control m-1" id="">
                    <option>60天財富計畫</option>
                    <option>順勢成交數</option>
                    <option>零秒成交數</option>
                  </select>            
              </div>
              <div class="col-2 px-1">
                <input type="text" class="m-1 w-100 form-control p-0" name="daterange">                
              </div>
             
                <div class="col-2 pr-1">
                  <select class="form-control m-1" id="condition">
                    <option value="list-information">名單資料</option>
                    <option value="list-action">名單動作</option>
                    <option value="tag">標籤</option>
                  </select>                
                </div>
                <div class="col-2 pr-1">
                  <select class="form-control m-1" id="condition_option1">
                    <option value="">請選擇</option>
                    <option>原始來源</option>
                    <option>最新來源</option>
                    <option>報名場次</option>
                    <option>目前職業</option>
                    <option>居住地址</option>
                    <option>銷講後最新狀態</option>
                    <option>想了解的內容</option>
                  </select>                
                </div>
                <div class="col-2 pr-1">
                  <select class="form-control m-1" id="condition_option2">
                    <option value="">請選擇</option>
                    <option>是</option>
                    <option>未</option>
                    <option>包含</option>
                    <option>不包含</option>
                  </select>                
                </div>
                <div class="col-2 pr-3">
                  <input type="text" class="m-1 form-control" style="display:none;" id="condition_input3">
                  <select class="form-control m-1" id="condition_option3" style="display:none;">
                    <option value="">請選擇</option>
                    
                  </select>
                  <button type="button" class="btn btn-primary btn-sm mt-2 float-right ">確定</button>                
                </div>
            </div>
            <h7 class="ml-1">添加另一條件+</h7>
          </div>
        </div>
        <div class="card m-3">
          <div class="card-body">
            <div class="row mt-2 mb-3">
              <div class="col">
                <button class="btn btn-outline-secondary mr-2 " type="button" id="btn_newgroup" data-toggle="modal" data-target="#save_newgroup">保存為細分組</button>
                <div class="modal fade" id="save_newgroup" tabindex="-1" role="dialog" aria-labelledby="save_newgroupTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">細分組名稱</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <input type="text" class="input_width">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary">保存</button>
                      </div>
                    </div>
                  </div>
                </div>
                <button class="btn btn-outline-secondary" type="button" id="btn_newgroup">添加條件組</button>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>姓名</th>
                    <th>聯絡電話</th>
                    <th>電子郵件</th>
                    <th>來源</th>
                    <th>加入日期</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="align-middle">王小名</td>
                    <td class="align-middle">0912345678</td>
                    <td class="align-middle">a123@gmail.com</td>
                    <td class="align-middle">ad</td>
                    <td class="align-middle">2019年12月31日</td>
                  </tr>
                  <tr>
                    <td class="align-middle">陳小美</td>
                    <td class="align-middle">0987654321</td>
                    <td class="align-middle">fd546@gmail.com</td>
                    <td class="align-middle">ellen</td>
                    <td class="align-middle">2019年08月17日</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
<!-- Content End -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
//時間範圍
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});

//條件類別判斷
document.getElementById('condition').onchange=function(){
  var condition_option1=document.getElementById('condition_option1')
  ,condition_option2=document.getElementById('condition_option2')
  ,condition_option3=document.getElementById('condition_option3')
  ,condition_input3=document.getElementById('condition_input3');
	
	if(this.value=='list-information'){
		condition_option1.innerHTML='<option value="">請選擇</option><option>原始來源</option><option>最新來源</option><option>報名場次</option><option>目前職業</option><option>居住地址</option><option>銷講後最新狀態</option><option>想了解的內容</option>';
    condition_option2.innerHTML='<option value="">請選擇</option><option>是</option><option>未</option><option>包含</option><option>不包含</option>';
    condition_input3.style.display='block';
    condition_option3.style.display='none';
  }
  else if(this.value=='list-action'){
		condition_option1.innerHTML='<option value="">請選擇</option><option>是</option><option>未</option>';
    condition_option2.innerHTML='<option value="">請選擇</option><option value="present">報到</option><option value="cancel">取消</option><option value="absent">未到</option><option value="pay">交付</option><option value="participate">參與</option><option value="open-mail">打開郵件</option><option value="open-sms">打開簡訊</option>';
    condition_option3.style.display='block';
    condition_input3.style.display='none';
	}
  else if(this.value=='tag'){
		condition_option1.innerHTML='<option value="">請選擇</option><option>已分配</option><option>未分配</option>';
    condition_option2.innerHTML='<option value="">請選擇</option><option>是</option><option>未</option><option>包含</option><option>不包含</option>';
    condition_input3.style.display='block';
    condition_option3.style.display='none';
	}
};

document.getElementById('condition_option2').onchange=function(){
if(this.value=='present'||this.value=='cancel'||this.value=='absent'||this.value=='pay'){
      condition_option3.innerHTML='<option value="">請選擇</option><option>課程選項</option>';
    }
    else if(this.value=='participate'){
      condition_option3.innerHTML='<option value="">請選擇</option><option>課程活動</option>';
    }
    else if(this.value=='open-mail'){
      condition_option3.innerHTML='<option value="">請選擇</option><option>郵件名稱</option>';
    }
    else if(this.value=='open-sms'){
      condition_option3.innerHTML='<option value="">請選擇</option><option>簡訊名稱</option>';
    }
}
</script>

@endsection

     