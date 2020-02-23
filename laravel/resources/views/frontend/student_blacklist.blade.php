@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '黑名單')

@section('content')
<!-- Content Start -->
        <!--黑名單內容-->
        <div class="card m-3">
          <div class="card-body">
            <div class="row mb-3">
            <div class="col-4"></div>
              <div class="col-3">
                <input type="search" class="form-control" placeholder="輸入電話或email" aria-label="Student's Phone or Email"
                    id="search_input" onkeyup="value=value.replace(/[^\w_.@]/g,'')">
              </div>
              <div class="col-2">
                <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button> 
              </div>
                <!-- <div class="col-5 mx-auto">
                  <div class="input-group">
                    <input type="search" class="form-control" placeholder="輸入電話或email" aria-label="Phone or Email">
                  </div>
                </div> -->
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm text-center">
                <thead>
                  <tr>
                    <th>姓名</th>
                    <th>連絡電話</th>
                    <th>電子郵件</th>
                    <th>原因</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                @foreach($blacklists as $blacklist)
                <tr>
                    <td>{{ $blacklist->name }}</td>
                    <td>{{$blacklist->phone}}</td>
                    <td>{{$blacklist->email}}</td>
                    <td>{{$blacklist->reason}}</td>

                    <td>
                        <a href="#"><button type="button" class="btn btn-secondary btn-sm mx-1">完整內容</button></a>
                        <button id="{{ $blacklist->blacklist_id }}" class="btn btn-dark btn-sm mx-1" onclick="btn_blacklist({{ $blacklist->blacklist_id }});" value="{{ $blacklist->blacklist_id }}" ><i class="fa fa-ban"></i>取消黑名單</button>
                    </td>
                </tr>
                @endforeach                 
                </tbody>
              </table>
            </div>
            <div class="row">
              <div class="col-md-5"></div>
              <div class="col-md-4">
                <div class="pull-right">
                  {!! $blacklists->appends(Request::except('page'))->render() !!} 
                </div>
              </div>
            </div>
          </div>
        </div>
<!-- Content End -->


<script>
  $("document").ready(function(){
  // 學員管理搜尋 (只能輸入數字、字母、_、.、@)
  $('#search_input').on('blur', function() {
      // console.log(`search_input: ${$(this).val()}`);
  });
});

// 輸入框
$('#search_input').on('keyup', function(e) {
  if (e.keyCode === 13) {
      $('#btn_search').click();
  }
});

/*搜尋 Rocky(2020/02/23)*/
$("#btn_search").click(function(e){
  var search_data = $("#search_input").val();
  $.ajax({
      type : 'GET',
      url:'blacklist_search',    
      data:{
        search_data: search_data,
      },
      success:function(data){
        $('body').html(data);
      },
      error: function(jqXHR){
          console.log('error: ' + JSON.stringify(jqXHR));
      }
  });
});

/*加入黑名單 Rocky(2020/02/23)*/
function btn_blacklist(id_blacklist){
  $.ajax({
      type : 'GET',
      url:'blacklist_cancel', 
      dataType: 'json',    
      data:{
        id_blacklist: id_blacklist
      },
      success:function(data){
        console.log(data)
        if (data['data'] == "ok") {                           
          /** alert **/
          $("#success_alert_text").html("取消成功");
          fade($("#success_alert"));

          location.reload();
        }　else {
          /** alert **/ 
          $("#error_alert_text").html("取消失敗");
          fade($("#error_alert"));       
        }           
      },
      error: function(error){
        console.log(JSON.stringify(error));   

        /** alert **/ 
        $("#error_alert_text").html("刪除資料失敗");
        fade($("#error_alert"));       
      }
  });
}
</script>
@endsection
     