@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '創建細分組')

@section('content')

<!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css"> -->

<!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script> -->

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script> -->




<link rel="stylesheet "type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>


<!-- Content Start -->
        <!--學員細分組內容-->
        <div class="card m-3">
          <div class="card-body">
            <!-- <div class="row">
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
            </div> -->
            <div class="row">
            <div class="col-2">
                  <select  class="form-control" id="select_type">
                    <option value="0">請選擇</option>
                    <option value="1">銷講</option>
                    <option value="2">正課</option>
                    <option value="3">活動</option>
                  </select> 
              </div>
              <div class="col-2 ">
                  <select multiple class="selectpicker form-control" data-actions-box="true" id="select_course"></select> 
              </div>
              <div class="col-2 px-1">
                <input type="text" class="m-1 w-100 form-control p-0" name="daterange" id="input_date">                
              </div>
             
                <div class="col-2 pr-1">
                  <select class="form-control m-1" id="condition">
                    <option value="information">名單資料</option>
                    <option value="action">名單動作</option>
                    <option value="tag">標籤</option>
                  </select>                
                </div>
                <div class="col-2 pr-1">
                  <select class="form-control m-1" id="condition_option1">
                    <option value="">請選擇</option>
                    <option value="datasource_old">原始來源</option>
                    <option value="datasource_new">最新來源</option>
                    <option value="id_events">報名場次</option>
                    <option value="profession">目前職業</option>
                    <option value="address">居住地址</option>
                    <option>銷講後最新狀態</option>
                    <option value="course_content">想了解的內容</option>
                  </select>                
                </div>
                <div class="col-2 pr-1">
                  <select class="form-control m-1" id="condition_option2">
                    <option value="">請選擇</option>
                    <option value="yes">是</option>
                    <option value="no">未</option>
                    <option value="like">包含</option>
                    <option value="notlike">不包含</option>
                  </select>                
                </div>
                <div class="col-2 pr-3">
                  <input type="text" class="m-1 form-control" style="display:blick;" id="condition_input3">
                  <select class="form-control m-1" id="condition_option3" style="display:none;">
                    <option value="">請選擇</option>
                    
                  </select>
                  <button type="button" class="btn btn-primary btn-sm mt-2 float-right" onclick="search();">確定</button>                
                </div>
            </div>
            <!-- <h7 class="ml-1">添加另一條件+</h7> -->
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
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



<script>  
//  $('select').selectpicker();
$("document").ready(function(){
  //  // 顯示細分條件資料 Rocky(2020/03/14)
  //  show_requirement();

  // 課程多選 Rocky(2020/03/14)
  $("#select_course").selectpicker({
		noneSelectedText : '請選擇'//預設顯示內容
  });
});

//時間範圍
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left',
    locale: {
      format: "YYYY-MM-DD"
    }
    
  }, function(start, end, label) {
    // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});

//條件類別判斷
document.getElementById('condition').onchange=function(){
  var condition_option1=document.getElementById('condition_option1')
  ,condition_option2=document.getElementById('condition_option2')
  ,condition_option3=document.getElementById('condition_option3')
  ,condition_input3=document.getElementById('condition_input3');
	
	if(this.value=='information'){
    // 選項一
    $('#condition_option1').append(new Option('請選擇', ''));
    $('#condition_option1').append(new Option('原始來源', 'datasource_old'));
    $('#condition_option1').append(new Option('最新來源', 'datasource_new'));
    $('#condition_option1').append(new Option('報名場次', 'id_events'));
    $('#condition_option1').append(new Option('目前職業', 'profession'));
    $('#condition_option1').append(new Option('居住地址', 'address'));
    $('#condition_option1').append(new Option('銷講後最新狀態', ''));
    $('#condition_option1').append(new Option('想了解的內容', 'course_content'));

    // 選項二
    $('#condition_option2').append(new Option('是', 'yes'));
    $('#condition_option2').append(new Option('未', 'no'));
    $('#condition_option2').append(new Option('包含', 'like'));
    $('#condition_option2').append(new Option('不包含', 'notlike'));

    // <option value="yes">是</option>
    //                 <option value="no">未</option>
    //                 <option value="like">包含</option>
    //                 <option value="notlike">不包含</option>
		// condition_option1.innerHTML='<option value="">請選擇</option><option>原始來源</option><option>最新來源</option><option>報名場次</option><option>目前職業</option><option>居住地址</option><option>銷講後最新狀態</option><option>想了解的內容</option>';
    // condition_option2.innerHTML='<option value="">請選擇</option><option>是</option><option>未</option><option>包含</option><option>不包含</option>';
    condition_input3.style.display='block';
    condition_option3.style.display='none';
  }
  else if(this.value=='action'){
		condition_option1.innerHTML='<option value="">請選擇</option><option>是</option><option>未</option>';
    condition_option2.innerHTML='<option value="">請選擇</option><option value="present">報到</option><option value="cancel">取消</option><option value="absent">未到</option><option value="pay">交付</option><option value="participate">參與</option><option value="open-mail">打開郵件</option><option value="open-sms">打開簡訊</option>';
    condition_option3.style.display='block';
    condition_input3.style.display='none';
	}
  else if(this.value=='tag'){
    condition_option1.innerHTML='<option value="">請選擇</option><option>已分配</option><option>未分配</option>';
    // 選項二
    $('#condition_option2').append(new Option('是', 'yes'));
    $('#condition_option2').append(new Option('未', 'no'));
    $('#condition_option2').append(new Option('包含', 'like'));
    $('#condition_option2').append(new Option('不包含', 'notlike'));

    // condition_option2.innerHTML='<option value="">請選擇</option><option>是</option><option>未</option><option>包含</option><option>不包含</option>';
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

// 顯示細分條件資料 Rocky(2020/03/14)
$( "#select_type" ).change(function() {
  show_requirement_course($('#select_type').val());
});

function show_requirement_course(type){
$.ajax({
      type : 'POST',
      url:'show_requirement_course', 
      dataType: 'json',    
      data:{
        type:type
      },
      success:function(data){
        // console.log(data);
        $('#select_course').find('option').remove();
        $.each(data, function(index,val) {           
          $('#select_course').append(new Option(val['name'], val['id']))
        }); 

        $('#select_course').selectpicker('refresh');
                 
      },
      error: function(error){
        console.log(JSON.stringify(error));     
      }
  });  
}

// 尋找資料 Rocky(2020/03/14)
function search(){
  // 課程類型
  type_course = $('#select_type').val()
  // 課程選擇
  id_course = $('#select_course').val()
  // 日期選擇
  date = $('#input_date').val()  
  // 類別
  type_condition = $('#condition').val()  
  // 選項一
  opt1 = $('#condition_option1').val()
  // 選項二
  opt2 = $('#condition_option2').val()
  // 內容
  value = $('#condition_input3').val()
  // console.log(id_course)
  $.ajax({
    type:'POST',
    url:'search_students',
    dataType:'json',
    data:{
      type_course:type_course,
      id_course:id_course,
      date:date,
      type_condition:type_condition,
      opt1:opt1,
      opt2:opt2,
      value:value
    },
    success:function(data){
      console.log(data)
    },
    error:function(error){
      console.log(JSON.stringify(error))
    }
  })
  // // 課程類型
  // console.log($('#select_type').val());

  // // 課程選擇
  // console.log($('#select_course').val());

  // // 日期選擇
  // console.log($('#input_date').val());

  // // 類別
  // console.log($('#condition').val());
  
  // // 選項一
  // console.log($('#condition_option1').val());

  // // 選項二
  // console.log($('#condition_option2').val());
  
  
}
</script>



@endsection

     