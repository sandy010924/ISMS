@if ( $status == "匯入成功")
<div class="alert alert-success alert-dismissible m-3 position-fixed fixed-bottom" role="alert">
  {{ $status }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@elseif ( $status == "匯入失敗" || $status == "請選檔案/填講師姓名")  
<div class="alert alert-danger alert-dismissible m-3 position-fixed fixed-bottom" role="alert">
  {{ $status }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif