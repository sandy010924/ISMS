@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '細分組修改')

@section('content')

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
      <form id="form_condition1">
        <div class="row">
          <div class="col-3">
              <select  class="form-control" id="select_type">
                <option value="0">請選擇</option>
                <option value="1">銷講</option>
                <option value="2">正課</option>
                <option value="3">活動</option>
              </select>
          </div>
          <div class="col-3">
              <select multiple class="selectpicker form-control" data-actions-box="true" id="select_course"></select>
          </div>
          <div class="col-3">
            <input type="text" class="w-100 form-control p-0" name="daterange" id="input_date">
          </div>
          <div class="col-3">
            <select class="form-control" id="condition">
              <option value="information">名單資料</option>
              <option value="action">名單動作</option>
              <option value="tag">標籤</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-3">
            <select class="form-control mt-2" id="condition_option1">
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
          <div class="col-3">
            <select class="form-control mt-2" id="condition_option2">
              <option value="">請選擇</option>
              <option value="yes">是</option>
              <option value="no">未</option>
              <option value="like">包含</option>
              <option value="notlike">不包含</option>
            </select>
          </div>
          <div class="col-3">
            <input type="text" class="form-control mt-2" style="display:block;" id="condition_input3">
            <!-- <select class="form-control m-1" id="condition_option3" style="display:none;">
              <option value="">請選擇</option>

            </select> -->
          </div>
        </div>
      </form>
      <!-- 添加另一條件 Rocky (2020/04/04) -->
      <div class="row">
        <div class="col-3 mt-2">
          <button class="btn btn-primary" type="button" onclick="condition2();" data-toggle="collapse" data-target="#dev_condition2" aria-expanded="false" aria-controls="dev_condition2">
            <i class="fa fa-toggle-on" aria-hidden="true">添加條件</i>
          </button>
        </div>
      </div>
    </div>
  </div>
    <!-- 條件篩選器2 -->
  <div class="collapse" id="dev_condition2">
      <div class="card m-3">
        <div class="card-body">
          <form id="form_condition2">
            <div class="row">
              <div class="col-3">
                  <select  class="form-control" id="select_type2">
                    <option value="0">請選擇</option>
                    <option value="1">銷講</option>
                    <option value="2">正課</option>
                    <option value="3">活動</option>
                  </select>
              </div>
              <div class="col-3">
                  <select multiple class="selectpicker form-control" data-actions-box="true" id="select_course2"></select>
              </div>
              <div class="col-3">
                <input type="text" class="w-100 form-control p-0" name="daterange" id="input_date2">
              </div>
                <div class="col-3">
                  <select class="form-control" id="condition2">
                    <option value="information">名單資料</option>
                    <option value="action">名單動作</option>
                    <option value="tag">標籤</option>
                  </select>
                </div>
            </div>
            <div class="row">
              <div class="col-3">
                <select class="form-control mt-2" id="condition_option1_2">
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
              <div class="col-3">
                <select class="form-control mt-2" id="condition_option2_2">
                  <option value="">請選擇</option>
                  <option value="yes">是</option>
                  <option value="no">未</option>
                  <option value="like">包含</option>
                  <option value="notlike">不包含</option>
                </select>
              </div>
              <div class="col-3">
                <input type="text" class="form-control mt-2" style="display:block;" id="condition_input3_2">
              </div>
            </div>
          </form>
          <!-- 添加另一條件 Rocky (2020/04/04) -->
          <div class="row">
            <div class="col-3  mt-2">
              <button class="btn btn-primary" type="button" onclick="condition3();" data-toggle="collapse" data-target="#dev_condition3" aria-expanded="false" aria-controls="dev_condition3">
                <i class="fa fa-toggle-on" aria-hidden="true">添加條件</i>
              </button>
              </i>
            </div>
          </div>
        </div>
      </div>
  </div>
  <!-- 條件篩選器3 -->
  <div class="collapse" id="dev_condition3">
    <div class="card m-3">
      <div class="card-body">
        <form id="form_condition3">
          <div class="row">
            <div class="col-3">
                <select  class="form-control" id="select_type3">
                  <option value="0">請選擇</option>
                  <option value="1">銷講</option>
                  <option value="2">正課</option>
                  <option value="3">活動</option>
                </select>
            </div>
            <div class="col-3">
                <select multiple class="selectpicker form-control" data-actions-box="true" id="select_course3"></select>
            </div>
            <div class="col-3">
              <input type="text" class="w-100 form-control p-0" name="daterange" id="input_date3">
            </div>
              <div class="col-3">
                <select class="form-control" id="condition3">
                  <option value="information">名單資料</option>
                  <option value="action">名單動作</option>
                  <option value="tag">標籤</option>
                </select>
              </div>
          </div>
          <div class="row">
            <div class="col-3">
              <select class="form-control mt-2" id="condition_option1_3">
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
            <div class="col-3">
              <select class="form-control mt-2" id="condition_option2_3">
                <option value="">請選擇</option>
                <option value="yes">是</option>
                <option value="no">未</option>
                <option value="like">包含</option>
                <option value="notlike">不包含</option>
              </select>
            </div>
            <div class="col-3">
              <input type="text" class="form-control mt-2" style="display:block;" id="condition_input3_3">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="card m-3">
    <div class="card-body">
      <div class="row">
          <div class="col-4">
            <button type="button" class="btn btn-primary mr-2" onclick="search();">搜尋</button>
            <button class="btn btn-dark" type="button" data-toggle="collapse" data-target="#model_show_log" aria-expanded="false" aria-controls="model_show_log" onclick="show_log();">
            <i class="fa fa-search" aria-hidden="true"></i>查看條件
            </button>
          </div>
          <div class="col-3">
            <input type="text" id="name_group" class="m-2 form-control"  value="{{$datas[0]['name_group']}}">
          </div>
          <div class="col-2">
            <button class="btn btn-outline-secondary m-2" type="button" id="btn_update"  onclick="update();">儲存</button>
          </div>
      </div>
      <div class="row">
        <div class="col-12">
            <div class="collapse" id="model_show_log" style="padding-top:15px;">
              <div class="card card-body" id="show_log">
              </div>
            </div>
          </div>
      </div>
      <div class="table-responsive">
        <input type="hidden" id="id_group"  value="{{$id}}">
        <input type="hidden" id="data_groupdetail"  value="{{$datas}}">
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
          <tbody id= "data_student">
          </tbody>
        </table>
      </div>
    </div>
  </div>
    <!-- alert Start-->
    <div class="alert alert-success alert-dismissible m-3 position-fixed fixed-bottom" role="alert" id="success_alert">
    <span id="success_alert_text"></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="alert alert-danger alert-dismissible m-3 position-fixed fixed-bottom" role="alert" id="error_alert">
    <span id="error_alert_text"></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <!-- alert End -->
<!-- Content End -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



<script>
// 宣告
var array_studentid = new Array();
var search_log = '',count_log = 0,old_count_log = 0
var check_condition2 = 0,check_condition3 = 0;

var array_old_studentid = new Array();
var array_upate_studentid = new Array();
//  $('select').selectpicker();
$("document").ready(function(){
  array_old_studentid = JSON.parse($('#data_groupdetail').val())
  // 顯示資料
  show(JSON.parse($('#data_groupdetail').val()),'show')

  // console.log($('#data_groupdetail').val())
  //  // 顯示細分條件資料 Rocky(2020/03/14)
  //  show_requirement();

  // 課程多選 Rocky(2020/03/14)
  $("#select_course").selectpicker({
		noneSelectedText : '請選擇'//預設顯示內容
  });
  $("#select_course2").selectpicker({
		noneSelectedText : '請選擇'//預設顯示內容
  });
  $("#select_course3").selectpicker({
		noneSelectedText : '請選擇'//預設顯示內容
  });
});

/*增加條件*/
function condition2 (){
  check_condition2++;
  if(check_condition2 > 1){
    check_condition2 = 0
  }
}
function condition3 (){
  check_condition3++;
  if(check_condition3 > 1){
    check_condition3 = 0
  }
}

//時間範圍
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left',
    locale: {
      format: "YYYY/MM/DD"
    }

  }, function(start, end, label) {
    // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});

/*條件判斷 - S Rocky(2020/04/05)*/
show_condition1();
show_condition2();
show_condition3();
/*條件判斷 - E Rocky(2020/04/05)*/

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

/*條件顯示 - S Rocky(2020/04/05)*/
function write_log(){
  var log_id = []
  // 抓取條件篩選器1
  $("#form_condition1 :input").each(function(){
    if ($(this).attr('id') != undefined) {
      if($(this).val() != "" || $(this).val() != "請選擇") {
        if ($(this).attr('id') == "input_date" || $(this).attr('id') == "condition_input3") {
          id = '#' + $(this).attr('id')
        } else{
          id = '#' + $(this).attr('id') + ' :selected'
        }
        log_id.push(id)
      }
    }
  });

  get_log(log_id,"篩選器1",1)

  // 抓取條件篩選器2
  if(check_condition2 == 1){
    log_id = []
    $("#form_condition2 :input").each(function(){
    if ($(this).attr('id') != undefined) {
      if($(this).val() != "" || $(this).val() != "請選擇") {
        if ($(this).attr('id') == "input_date2" || $(this).attr('id') == "condition_input3_2") {
          id = '#' + $(this).attr('id')
        } else{
          id = '#' + $(this).attr('id') + ' :selected'
        }
        log_id.push(id)
      }
    }
    });
    get_log(log_id,"篩選器2",2)
  }

  // 抓取條件篩選器3
  if(check_condition3 == 1){
    log_id = []
    $("#form_condition3 :input").each(function(){
    if ($(this).attr('id') != undefined) {
      if($(this).val() != "" || $(this).val() != "請選擇") {
        if ($(this).attr('id') == "input_date3" || $(this).attr('id') == "condition_input3_3") {
          id = '#' + $(this).attr('id')
        } else{
          id = '#' + $(this).attr('id') + ' :selected'
        }
        log_id.push(id)
      }
    }
    });
    get_log(log_id,"篩選器3",3)
  }
}

function get_log(log_id,condition_name,condition_id){

  var log = '';

  type = $(log_id[0]).text()
  course = $(log_id[1]).text()
  date = $(log_id[2]).val()
  type_condition = $(log_id[3]).text()
  opt1 = $(log_id[4]).text()
  opt2 = $(log_id[5]).text()
  value = $(log_id[6]).val()

  // log += count_log + '. '
  if(type != "") {
    log += type + '/'
  }
  if(course != "") {
    log += course + '/'
  }
  if(date != "") {
    log += date + '/'
  }
  if(type_condition != "") {
    log += type_condition + '/'
  }
  if(opt1 != "請選擇") {
    log += opt1 + '/'
  }
  if(opt2 != "請選擇") {
    log += opt2 + '/'
  }
  if(value != "") {
    log += value + '/'
  }

  if (check_condition3 == 1 && condition_id == 1) {
    tag = "<hr>"
  } else if(check_condition2 == 1 && condition_id == 1){
    tag = "<hr>"
  } else if (condition_id == 1){
    tag = "<hr>"
  } else{
    tag = ""
  }
  // log = tag + count_log + " - " + condition_name + ":" + log.slice(0,-1) + "<br>"
  log = tag + condition_name + ":" + log.slice(0,-1) + "<br>"
  search_log += log
}

function show_log(){
  if(count_log != 0){
    $("#show_log").html('');
    $("#show_log").html(search_log);
  }
}
/*條件顯示 - E */

// 尋找資料 Rocky(2020/03/14)
function search(){
  var array_search = [],array_condition1 = [],array_condition2 = [],array_condition3 = [];

  // 抓取條件篩選器1
  $("#form_condition1 :input").each(function(){
    if ($(this).attr('id') != undefined) {
      array_condition1.push($(this).val())
    }
  });

  // 抓取條件篩選器2
  if(check_condition2 == 1){
    $("#form_condition2 :input").each(function(){
      if ($(this).attr('id') != undefined) {
        array_condition2.push($(this).val())
      }
    });
  }

  // 抓取條件篩選器3
  if(check_condition3 == 1){
    $("#form_condition3 :input").each(function(){
      if ($(this).attr('id') != undefined) {
        array_condition3.push($(this).val())
      }
    });
  }

  // 將資料push到array
  if(array_condition1[1].length == 0){
    array_condition1[1] = ['']
  }

  array_search.push({
    type_course: array_condition1[0],
    id_course:  array_condition1[1],
    date:array_condition1[2],
    type_condition:array_condition1[3],
    opt1:array_condition1[4],
    opt2:array_condition1[5],
    value:array_condition1[6]
  });

  if(check_condition2 == 1){
    if(array_condition2[1].length == 0){
      array_condition2[1] = ['']
    }
    array_search.push({
      type_course: array_condition2[0],
      id_course:  array_condition2[1],
      date:array_condition2[2],
      type_condition:array_condition2[3],
      opt1:array_condition2[4],
      opt2:array_condition2[5],
      value:array_condition2[6]
    });
  }

  if(check_condition3 == 1){
    if(array_condition3[1].length == 0){
      array_condition3[1] = ['']
    }
    array_search.push({
      type_course: array_condition3[0],
      id_course:  array_condition3[1],
      date:array_condition3[2],
      type_condition:array_condition3[3],
      opt1:array_condition3[4],
      opt2:array_condition3[5],
      value:array_condition3[6]
    });
  }

  $.ajax({
    type:'POST',
    url:'search_students',
    dataType:'json',
    data:{
      array_search:array_search
    },
    success:function(data){
      // console.log(data)
      show(data,"search");
      /*log Rocky(2020/04/04)*/
      count_log++;
      write_log()
      show_log()
    },
    error:function(error){
      console.log(JSON.stringify(error))
    }
  })
}

// 顯示資料 Rocky(2020/03/19)
function show(data,type_show){
  
  if(type_show == "show") {    
    if(data[0]['condition'] != null) {
      search_log = data[0]['condition']
      $("#show_log").html('');
      $("#show_log").html(search_log);
    }
    
  }
  
  
  if (data.length > 0)
  {
    $.each(data, function(index,val) {
      // 檢查陣列有沒有重複資料
      var check_array_student = array_old_studentid.filter(function(item, index, array){
        return item.id == val['id']
      });
      if(check_array_student.length == 0 ){
        array_old_studentid.push(data[index]);
        array_upate_studentid.push(data[index]);
      }
    });
  }
  if (array_old_studentid.length != 0) {
    $.each(array_old_studentid, function(index,val) {
      if (val['name'] != null) {
        data +=
          '<tr>' +
          '<td>' + val['name'] + '</td>' +
          '<td>' + val['phone'] + '</td>' +
          '<td>' + val['email'] + '</td>' +
          '<td>' + val['datasource'] + '</td>' +
          '<td>' + val['submissiondate'] + '</td>' +
          '</tr>'
      }
    });
    $('#data_student').html(data);
  }
}

// 儲存資料 Rocky(2020/03/19)
function update(){
  var name_group = $('#name_group').val()
  var id = $('#id_group').val()
  var condition = search_log
  $.ajax({
    type:'POST',
    url:'update',
    // dataType:'json',
    data:{
      id:id,
      name_group:name_group,
      condition:condition,
      array_upate_studentid:array_upate_studentid
    },
    success:function(data){
      if (data = "儲存成功") {
          $("#success_alert_text").html("儲存成功");
          fade($("#success_alert"));
      } else {
        $("#error_alert_text").html("儲存失敗");
        fade($("#error_alert"));
      }
    },
    error:function(error){
      console.log(JSON.stringify(error))
    }
  })
}



function show_condition1(){
  //條件類別判斷
  document.getElementById('condition').onchange=function(){
    var condition_option1=document.getElementById('condition_option1')
    ,condition_option2=document.getElementById('condition_option2')
    // ,condition_option3=document.getElementById('condition_option3')
    ,condition_input3=document.getElementById('condition_input3');

    if(this.value=='information'){
      // 選項一
      $('#condition_option1').empty();
      $('#condition_option1').append(new Option('請選擇', ''));
      $('#condition_option1').append(new Option('原始來源', 'datasource_old'));
      $('#condition_option1').append(new Option('最新來源', 'datasource_new'));
      $('#condition_option1').append(new Option('報名場次', 'id_events'));
      $('#condition_option1').append(new Option('目前職業', 'profession'));
      $('#condition_option1').append(new Option('居住地址', 'address'));
      $('#condition_option1').append(new Option('銷講後最新狀態', ''));
      $('#condition_option1').append(new Option('想了解的內容', 'course_content'));

      // 選項二
      $('#condition_option2').empty();
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
      // condition_option3.style.display='none';
    }
    else if(this.value=='action'){
      // 選項一
      $('#condition_option1').empty();
      $('#condition_option1').append(new Option('請選擇', ''));
      $('#condition_option1').append(new Option('是', 'yes'));
      $('#condition_option1').append(new Option('未', 'no'));
      // condition_option1.innerHTML='<option value="">請選擇</option><option>是</option><option>未</option>';
      // 選項二
      $('#condition_option2').empty();
      $('#condition_option2').append(new Option('請選擇', ''));
      $('#condition_option2').append(new Option('報到', '4'));
      $('#condition_option2').append(new Option('取消', '5'));
      $('#condition_option2').append(new Option('未到', '3'));
      $('#condition_option2').append(new Option('交付', ''));
      $('#condition_option2').append(new Option('完款', '7'));
      $('#condition_option2').append(new Option('付訂', '8'));
      $('#condition_option2').append(new Option('參與', ''));
      $('#condition_option2').append(new Option('打開郵件', ''));
      $('#condition_option2').append(new Option('打開簡訊', ''));

      // condition_option2.innerHTML='<option value="">請選擇</option><option value="present">報到</option><option value="cancel">取消</option><option value="absent">未到</option><option value="pay">交付</option><option value="participate">參與</option><option value="open-mail">打開郵件</option><option value="open-sms">打開簡訊</option>';
      // condition_option3.style.display='block';
      condition_input3.style.display='none';
    }
    else if(this.value=='tag'){
      // 選項一
      $('#condition_option1').empty();
      $('#condition_option1').append(new Option('請選擇', ''));
      $('#condition_option1').append(new Option('已分配', 'yes'));
      $('#condition_option1').append(new Option('未分配', 'no'));
      // condition_option1.innerHTML='<option value="">請選擇</option><option>已分配</option><option>未分配</option>';
      // 選項二
      $('#condition_option2').empty();
      $('#condition_option2').append(new Option('請選擇', ''));
      $('#condition_option2').append(new Option('是', 'yes'));
      $('#condition_option2').append(new Option('未', 'no'));
      $('#condition_option2').append(new Option('包含', 'like'));
      $('#condition_option2').append(new Option('不包含', 'notlike'));

      // condition_option2.innerHTML='<option value="">請選擇</option><option>是</option><option>未</option><option>包含</option><option>不包含</option>';
      condition_input3.style.display='block';
      // condition_option3.style.display='none';
    }
  };
  // 類型 Rocky(2020/03/20)
  document.getElementById('select_type').onchange=function(){
    if(this.value=='1'){
      // 銷講
      if ($('#condition').val() == "information") {
        // 選項一
        $('#condition_option1').empty();
        $('#condition_option1').append(new Option('請選擇', ''));
        $('#condition_option1').append(new Option('原始來源', 'datasource_old'));
        $('#condition_option1').append(new Option('最新來源', 'datasource_new'));
        $('#condition_option1').append(new Option('報名場次', 'id_events'));
        $('#condition_option1').append(new Option('目前職業', 'profession'));
        $('#condition_option1').append(new Option('居住地址', 'address'));
        $('#condition_option1').append(new Option('銷講後最新狀態', ''));
        $('#condition_option1').append(new Option('想了解的內容', 'course_content'));
      }
      } else if(this.value=='2') {
        // 正課
        // 選項一
        if ($('#condition').val() == "information") {
          $('#condition_option1').empty();
          $('#condition_option1').append(new Option('請選擇', ''));
          $('#condition_option1').append(new Option('應付金額', 'amount_payable'));
          $('#condition_option1').append(new Option('已付金額', 'amount_paid'));
          $('#condition_option1').append(new Option('服務人員', 'person'));
          $('#condition_option1').append(new Option('統一發票', 'type_invoice'));
          $('#condition_option1').append(new Option('統編', 'number_taxid'));
          $('#condition_option1').append(new Option('抬頭', 'companytitle'));
          $('#condition_option1').append(new Option('報名場次', 'id_events'));
          $('#condition_option1').append(new Option('目前職業', 'profession'));
          $('#condition_option1').append(new Option('居住地址', 'address'));
        }
      } else if(this.value=='3') {
        // 活動
        // 選項一
        $('#condition_option1').empty();
        $('#condition_option1').append(new Option('請選擇', ''));
        $('#condition_option1').append(new Option('原始來源', 'datasource_old'));
        $('#condition_option1').append(new Option('最新來源', 'datasource_new'));
        $('#condition_option1').append(new Option('報名場次', 'id_events'));
        $('#condition_option1').append(new Option('目前職業', 'profession'));
        $('#condition_option1').append(new Option('居住地址', 'address'));
        $('#condition_option1').append(new Option('銷講後最新狀態', ''));
        $('#condition_option1').append(new Option('想了解的內容', 'course_content'));
      }
  }

  // 選項一 Rocky(2020/03/20)
  document.getElementById('condition_option1').onchange=function(){
    if(this.value=='yes'){
      condition_option2.style.display='block';
    } else if(this.value=='no') {
      condition_option2.style.display='none';
      condition_input3.style.display='none';
    }
  }

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
    show_requirement_course($('#select_type').val(),"#select_course");
  });
}


function show_condition2(){
  //條件類別判斷
  document.getElementById('condition2').onchange=function(){
    var condition_option1=document.getElementById('condition_option1_2')
    ,condition_option2_2=document.getElementById('condition_option2_2')
    ,condition_input3_2=document.getElementById('condition_input3_2');

    if(this.value=='information'){
      // 選項一
      $('#condition_option1_2').empty();
      $('#condition_option1_2').append(new Option('請選擇', ''));
      $('#condition_option1_2').append(new Option('原始來源', 'datasource_old'));
      $('#condition_option1_2').append(new Option('最新來源', 'datasource_new'));
      $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
      $('#condition_option1_2').append(new Option('目前職業', 'profession'));
      $('#condition_option1_2').append(new Option('居住地址', 'address'));
      $('#condition_option1_2').append(new Option('銷講後最新狀態', ''));
      $('#condition_option1_2').append(new Option('想了解的內容', 'course_content'));

      // 選項二
      $('#condition_option2_2').empty();
      $('#condition_option2_2').append(new Option('是', 'yes'));
      $('#condition_option2_2').append(new Option('未', 'no'));
      $('#condition_option2_2').append(new Option('包含', 'like'));
      $('#condition_option2_2').append(new Option('不包含', 'notlike'));

      condition_input3_2.style.display='block';
    }
    else if(this.value=='action'){
      // 選項一
      $('#condition_option1_2').empty();
      $('#condition_option1_2').append(new Option('請選擇', ''));
      $('#condition_option1_2').append(new Option('是', 'yes'));
      $('#condition_option1_2').append(new Option('未', 'no'));

      // 選項二
      $('#condition_option2_2').empty();
      $('#condition_option2_2').append(new Option('請選擇', ''));
      $('#condition_option2_2').append(new Option('報到', '4'));
      $('#condition_option2_2').append(new Option('取消', '5'));
      $('#condition_option2_2').append(new Option('未到', '3'));
      $('#condition_option2_2').append(new Option('交付', ''));
      $('#condition_option2_2').append(new Option('完款', '7'));
      $('#condition_option2_2').append(new Option('付訂', '8'));
      $('#condition_option2_2').append(new Option('參與', ''));
      $('#condition_option2_2').append(new Option('打開郵件', ''));
      $('#condition_option2_2').append(new Option('打開簡訊', ''));

      condition_input3_2.style.display='none';
    }
    else if(this.value=='tag'){
      // 選項一
      $('#condition_option1_2').empty();
      $('#condition_option1_2').append(new Option('請選擇', ''));
      $('#condition_option1_2').append(new Option('已分配', 'yes'));
      $('#condition_option1_2').append(new Option('未分配', 'no'));

      // 選項二
      $('#condition_option2_2').empty();
      $('#condition_option2_2').append(new Option('請選擇', ''));
      $('#condition_option2_2').append(new Option('是', 'yes'));
      $('#condition_option2_2').append(new Option('未', 'no'));
      $('#condition_option2_2').append(new Option('包含', 'like'));
      $('#condition_option2_2').append(new Option('不包含', 'notlike'));

      condition_input3_2.style.display='block';
    }
  };
  // 類型 Rocky(2020/03/20)
  document.getElementById('select_type2').onchange=function(){
    if(this.value=='1'){
      // 銷講
      if ($('#condition2').val() == "information") {
        // 選項一
        $('#condition_option1_2').empty();
        $('#condition_option1_2').append(new Option('請選擇', ''));
        $('#condition_option1_2').append(new Option('原始來源', 'datasource_old'));
        $('#condition_option1_2').append(new Option('最新來源', 'datasource_new'));
        $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
        $('#condition_option1_2').append(new Option('目前職業', 'profession'));
        $('#condition_option1_2').append(new Option('居住地址', 'address'));
        $('#condition_option1_2').append(new Option('銷講後最新狀態', ''));
        $('#condition_option1_2').append(new Option('想了解的內容', 'course_content'));
      }
      } else if(this.value=='2') {
        // 正課
        // 選項一
        if ($('#condition2').val() == "information") {
          $('#condition_option1_2').empty();
          $('#condition_option1_2').append(new Option('請選擇', ''));
          $('#condition_option1_2').append(new Option('應付金額', 'amount_payable'));
          $('#condition_option1_2').append(new Option('已付金額', 'amount_paid'));
          $('#condition_option1_2').append(new Option('服務人員', 'person'));
          $('#condition_option1_2').append(new Option('統一發票', 'type_invoice'));
          $('#condition_option1_2').append(new Option('統編', 'number_taxid'));
          $('#condition_option1_2').append(new Option('抬頭', 'companytitle'));
          $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
          $('#condition_option1_2').append(new Option('目前職業', 'profession'));
          $('#condition_option1_2').append(new Option('居住地址', 'address'));
        }
      } else if(this.value=='3') {
        // 活動
        // 選項一
        $('#condition_option1_2').empty();
        $('#condition_option1_2').append(new Option('請選擇', ''));
        $('#condition_option1_2').append(new Option('原始來源', 'datasource_old'));
        $('#condition_option1_2').append(new Option('最新來源', 'datasource_new'));
        $('#condition_option1_2').append(new Option('報名場次', 'id_events'));
        $('#condition_option1_2').append(new Option('目前職業', 'profession'));
        $('#condition_option1_2').append(new Option('居住地址', 'address'));
        $('#condition_option1_2').append(new Option('銷講後最新狀態', ''));
        $('#condition_option1_2').append(new Option('想了解的內容', 'course_content'));
      }
  }

  // 選項一 Rocky(2020/03/20)
  document.getElementById('condition_option1_2').onchange=function(){
    if(this.value=='yes'){
      condition_option2_2.style.display='block';
    } else if(this.value=='no') {
      condition_option2_2.style.display='none';
      condition_input3_2.style.display='none';
    }
  }

  document.getElementById('condition_option2_2').onchange=function(){
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
  $( "#select_type2" ).change(function() {
    show_requirement_course($('#select_type2').val(),'#select_course2');
  });
}

function show_condition3(){
  //條件類別判斷
  document.getElementById('condition3').onchange=function(){
    var condition_option3=document.getElementById('condition_option1_3')
    ,condition_option2_3=document.getElementById('condition_option2_3')
    ,condition_input3_3=document.getElementById('condition_input3_3');

    if(this.value=='information'){
      // 選項一
      $('#condition_option1_3').empty();
      $('#condition_option1_3').append(new Option('請選擇', ''));
      $('#condition_option1_3').append(new Option('原始來源', 'datasource_old'));
      $('#condition_option1_3').append(new Option('最新來源', 'datasource_new'));
      $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
      $('#condition_option1_3').append(new Option('目前職業', 'profession'));
      $('#condition_option1_3').append(new Option('居住地址', 'address'));
      $('#condition_option1_3').append(new Option('銷講後最新狀態', ''));
      $('#condition_option1_3').append(new Option('想了解的內容', 'course_content'));

      // 選項二
      $('#condition_option2_3').empty();
      $('#condition_option2_3').append(new Option('是', 'yes'));
      $('#condition_option2_3').append(new Option('未', 'no'));
      $('#condition_option2_3').append(new Option('包含', 'like'));
      $('#condition_option2_3').append(new Option('不包含', 'notlike'));

      condition_input3_3.style.display='block';
    }
    else if(this.value=='action'){
      // 選項一
      $('#condition_option1_3').empty();
      $('#condition_option1_3').append(new Option('請選擇', ''));
      $('#condition_option1_3').append(new Option('是', 'yes'));
      $('#condition_option1_3').append(new Option('未', 'no'));

      // 選項二
      $('#condition_option2_3').empty();
      $('#condition_option2_3').append(new Option('請選擇', ''));
      $('#condition_option2_3').append(new Option('報到', '4'));
      $('#condition_option2_3').append(new Option('取消', '5'));
      $('#condition_option2_3').append(new Option('未到', '3'));
      $('#condition_option2_3').append(new Option('交付', ''));
      $('#condition_option2_3').append(new Option('完款', '7'));
      $('#condition_option2_3').append(new Option('付訂', '8'));
      $('#condition_option2_3').append(new Option('參與', ''));
      $('#condition_option2_3').append(new Option('打開郵件', ''));
      $('#condition_option2_3').append(new Option('打開簡訊', ''));

      condition_input3_3.style.display='none';
    }
    else if(this.value=='tag'){
      // 選項一
      $('#condition_option1_3').empty();
      $('#condition_option1_3').append(new Option('請選擇', ''));
      $('#condition_option1_3').append(new Option('已分配', 'yes'));
      $('#condition_option1_3').append(new Option('未分配', 'no'));

      // 選項二
      $('#condition_option2_3').empty();
      $('#condition_option2_3').append(new Option('請選擇', ''));
      $('#condition_option2_3').append(new Option('是', 'yes'));
      $('#condition_option2_3').append(new Option('未', 'no'));
      $('#condition_option2_3').append(new Option('包含', 'like'));
      $('#condition_option2_3').append(new Option('不包含', 'notlike'));

      condition_input3_3.style.display='block';
    }
  };
  // 類型 Rocky(2020/03/20)
  document.getElementById('select_type3').onchange=function(){
    if(this.value=='1'){
      // 銷講
      if ($('#condition3').val() == "information") {
        // 選項一
        $('#condition_option1_3').empty();
        $('#condition_option1_3').append(new Option('請選擇', ''));
        $('#condition_option1_3').append(new Option('原始來源', 'datasource_old'));
        $('#condition_option1_3').append(new Option('最新來源', 'datasource_new'));
        $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
        $('#condition_option1_3').append(new Option('目前職業', 'profession'));
        $('#condition_option1_3').append(new Option('居住地址', 'address'));
        $('#condition_option1_3').append(new Option('銷講後最新狀態', ''));
        $('#condition_option1_3').append(new Option('想了解的內容', 'course_content'));
      }
      } else if(this.value=='2') {
        // 正課
        // 選項一
        if ($('#condition3').val() == "information") {
          $('#condition_option1_3').empty();
          $('#condition_option1_3').append(new Option('請選擇', ''));
          $('#condition_option1_3').append(new Option('應付金額', 'amount_payable'));
          $('#condition_option1_3').append(new Option('已付金額', 'amount_paid'));
          $('#condition_option1_3').append(new Option('服務人員', 'person'));
          $('#condition_option1_3').append(new Option('統一發票', 'type_invoice'));
          $('#condition_option1_3').append(new Option('統編', 'number_taxid'));
          $('#condition_option1_3').append(new Option('抬頭', 'companytitle'));
          $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
          $('#condition_option1_3').append(new Option('目前職業', 'profession'));
          $('#condition_option1_3').append(new Option('居住地址', 'address'));
        }
      } else if(this.value=='3') {
        // 活動
        // 選項一
        $('#condition_option1_3').empty();
        $('#condition_option1_3').append(new Option('請選擇', ''));
        $('#condition_option1_3').append(new Option('原始來源', 'datasource_old'));
        $('#condition_option1_3').append(new Option('最新來源', 'datasource_new'));
        $('#condition_option1_3').append(new Option('報名場次', 'id_events'));
        $('#condition_option1_3').append(new Option('目前職業', 'profession'));
        $('#condition_option1_3').append(new Option('居住地址', 'address'));
        $('#condition_option1_3').append(new Option('銷講後最新狀態', ''));
        $('#condition_option1_3').append(new Option('想了解的內容', 'course_content'));
      }
  }

  // 選項一 Rocky(2020/03/20)
  document.getElementById('condition_option1_3').onchange=function(){
    if(this.value=='yes'){
      condition_option2_3.style.display='block';
    } else if(this.value=='no') {
      condition_option2_3.style.display='none';
      condition_input3_3.style.display='none';
    }
  }

  document.getElementById('condition_option2_3').onchange=function(){
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
  $( "#select_type3" ).change(function() {
    show_requirement_course($('#select_type3').val(),'#select_course3');
  });
}
</script>



@endsection

