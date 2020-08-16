<!-- Header Start -->
<div class="header shadow px-4 py-3 bg-white">
  <div class="row">
    <div class="col d-flex align-content-lg-center flex-wrap" id="header_title">
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
  // var currentlyURL = window.location.href;
  // var lastURL =  document.referrer;
  
  // console.log( 'currentlyURL:' + currentlyURL);
  // console.log( 'lastURL:' + lastURL);

  // function GoBackWithRefresh(event) {
  //   if ( currentlyURL.includes('course_check') ) {
  //       window.location = document.referrer;
  //       /* OR */
  //       //location.replace(document.referrer);
  //   } else {
  //       window.history.back();
  //   }
  // }
  

  //回上一頁按鈕，主頁不會出現按鈕
  var nav_text = $("#sidebarMenu").text().replace(/\s+/g, "");
  var header_text = $("#header_title").text().replace(/\s+/g, "");
  var back = 0;
  for( var i = 0 ; i < nav_text.length ; i++ ){
    if( nav_text.includes(header_text) ){
        back++;
        break;
    }
  }
  if( back == 0 ){
    // $("#header_title").prepend('<a href="javascript:Self.location=document.referrer;;"><span class="fas fa-2x fa-angle-left text-black-50"></span></a>&nbsp;&nbsp;');
    $("#header_title").prepend('<a href="javascript:history.back();"><span class="fas fa-2x fa-angle-left text-black-50"></span></a>&nbsp;&nbsp;');
  }
  
  //  Rocky (2020/02/17)     
    $("document").ready(function(){
      $.ajax({
           type:'POST',
           url:'user',                
           data:{'_token':"{{ csrf_token() }}"},
           success:function(data){
             if (data == "error") {
              window.location.href = "./error_authority";
             } else {
              $("#user_name").html("<li class='far fa-user'></li> " + data)
             }
           },
           error: function(data){ 
             console.log(data)
           }
        });    
    });
</script>