<!-- Header Start -->
<div class="header shadow px-4 py-3 bg-white">
  <div class="row">
    <div class="col d-flex align-content-lg-center flex-wrap" id="header_title">
      {{-- <a href="javascript:history.go(-1)"><span class="fas fa-2x fa-angle-left"></span></a>&nbsp; --}}
      <span class="h5 font-weight-bold" id="header_text">@yield('header')</span>
    </div>
    <div class="col text-right">
      <span id="user_name" class="h6 mr-3 align-middle"></span>   
      <a href="{{ route('logout') }}" class="logout"><span class="h6 align-middle"><li class="fas fa-sign-out-alt"></li> 登出</span></a>
    </div>
  </div>
</div>
<!-- Header End -->

<script>
  var index = [ '課程管理', '學員管理', '財務管理', '訊息推播', '數據報表', '系統設定' ];
  var back = 0;
  for( var i = 0 ; i < index.length ; i++ ){
    if( $("#header_title").text().indexOf(index[i]) >= 0 ){
        back++;
        break;
    }
  }
  if( back == 0 ){
    $("#header_title").prepend('<a href="javascript:history.go(-1)"><span class="fas fa-2x fa-angle-left text-black-50"></span></a>&nbsp;&nbsp;');
  }
  
  //  Rocky (2020/02/17)     
    $("document").ready(function(){
      $.ajax({
           type:'POST',
           url:'user',                
           data:{'_token':"{{ csrf_token() }}"},
           success:function(data){
             $("#user_name").html("<li class='far fa-user'></li>" + data)
           },
           error: function(data){ 
             console.log(data)
           }
        });    
    });
</script>