@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '課程管理')

@section('content')
<!-- Content Start -->
       <!--搜尋課程頁面內容-->
        <div class="card m-3">
          <div class="card-body">
            {{-- <div class="row menu_search"> --}}
            <div class="row mb-3">
              <div class="col-3 mx-3">
                <button type="button" class="btn btn-outline-secondary btn_date float-left mr-3" data-toggle="modal" data-target="#form_import">匯入表單</button>              
                <div class="modal fade" id="form_import" tabindex="-1" role="dialog" aria-labelledby="form_importLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="form_importLabel">匯入表單</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                      <form class="form" action="{{url('course')}}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                            <label for="import_teacher" class="col-form-label">講師</label>
                            <select class="custom-select" name="import_teacher" id="import_teacher">
                              <option selected>選擇講師</option>
                              <option value="1">Julia</option>
                              <option value="2">Jack</option>
                              <option value="3">Mark</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="import_flie" class="col-form-label">上傳檔案</label>
                            {{-- <textarea class="form-control" id="message-text"></textarea> --}}
                            <div class="custom-file">
                              <label class="custom-file-label" for="import_flie">瀏覽檔案</label>
                              <input type="file" class="custom-file-input" id="import_flie" name="import_flie" aria-describedby="inputGroupFileAddon01"  accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <!-- <button type="button" id="import_check" class="btn btn-primary">確認</button> -->
                            <button type="submit"  class="btn btn-primary" >確認</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                <button type="button" class="btn btn-outline-secondary btn_date mr-3" data-toggle="modal" data-target="#form_newclass">新增課程</button>
                <div class="modal fade" id="form_newclass" tabindex="-1" role="dialog" aria-labelledby="form_newclassLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="form_newclassLabel">新增課程</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="form-group">
                            <label for="newclass_name" class="col-form-label">課程名稱</label>
                            <input type="text" class="form-control" id="newclass_name">
                          </div>
                          <div class="form-group">
                            <label for="newclass_teacher" class="col-form-label">講師</label>
                            <select class="custom-select" id="newclass_teacher">
                              <option selected>選擇講師</option>
                              <option value="1">Julia</option>
                              <option value="2">Jack</option>
                              <option value="3">Mark</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="newclass_date" class="col-form-label">日期</label>
                            <input type="date" class="form-control" id="newclass_date">
                          </div>
                          <div class="form-group">
                            <label for="newclass_session" class="col-form-label">場次</label>
                            <select class="custom-select form-control" id="newclass_session">
                              <option selected>選擇場次</option>
                              <option value="1">台北上午場</option>
                              <option value="2">台北下午場</option>
                              <option value="3">台北晚上場</option>
                              <option value="4">台中上午場</option>
                              <option value="5">台中下午場</option>
                              <option value="6">台中晚上場</option>
                              <option value="7">高雄上午場</option>
                              <option value="8">高雄下午場</option>
                              <option value="9">高雄晚上場</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="newclass_location" class="col-form-label">地點</label>
                            <input type="text" class="form-control" id="newclass_location">
                          </div>
                          <div class="form-group">
                            <label for="newclass_timestart" class="col-form-label">開始時間</label>
                            <input type="time" class="form-control" id="newclass_timestart">
                          </div>
                          <div class="form-group">
                            <label for="newclass_timeend" class="col-form-label">結束時間</label>
                            <input type="time" class="form-control" id="newclass_timeend">
                          </div>
                          
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="button" id="import_check" class="btn btn-primary">確認</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col"></div>
              <div class="col-3">
                <input type="date" class="form-control" id="newclass_date">
              </div>
              <div class="col-3">
                <input type="search" class="form-control" placeholder="搜尋課程" aria-label="Class's name" aria-describedby="btn_search">
              </div>
              <div class="col-2">
                <button class="btn btn-outline-secondary" type="button" id="btn_search">搜尋</button> 
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-sm class_table">
                <thead>
                  <tr>
                    <th>日期</th>
                    <th>課程名稱</th>
                    <th>場次</th>
                    <th>報名筆數</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>2019/11/20(三)</td>
                    <td>零秒成交數</td>
                    <td>台北下午場</td>
                    <td>56/3</td>
                    <td>
                      <a href="{{ route('course_apply') }}"><button type="button" class="btn btn-secondary btn-sm mr-3">查看名單</button></a>
                    <a href="{{ route('course_form') }}">
                      <button type="button" class="btn btn-secondary btn-sm mr-3">產生表單</button>
                    </a>
                    </td>
                  </tr>
                  <tr>
                    <td>2019/11/20(三)</td>
                    <td>零秒成交數</td>
                    <td>台北晚上場</td>
                    <td>98/5</td>
                    <td>
                      <button type="button" class="btn btn-secondary btn-sm mr-3">查看名單</button>
                      <button type="button" class="btn btn-secondary btn-sm mr-3">產生表單</button>
                    </td>
                  </tr>
                  <tr>
                    <td>2019/11/26(二)</td>
                    <td>零秒成交數</td>
                    <td>台北晚上場</td>
                    <td>47</td>
                    <td><button type="button" class="btn btn-secondary btn-sm mr-3">查看名單</button>
                      <button type="button" class="btn btn-secondary btn-sm mr-3">產生表單</button></td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- Rocky(2020/01/11) -->
        @if (session('status') == "匯入成功")
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('status') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @elseif (session('status') == "匯入失敗" || session('status') == "請選檔案/填講師姓名")  
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('status') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
<!-- Content End -->

<script>
  // Rocky(2020/01/06)
$("document").ready(function(){
  $("#import_flie").change(function(){
    var i = $(this).prev('label').clone();
    var file = $('#import_flie')[0].files[0].name;
    $(this).prev('label').text(file);
  }); 
});
</script>
@endsection