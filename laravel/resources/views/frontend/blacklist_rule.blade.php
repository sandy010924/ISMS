@extends('frontend.layouts.master')

@section('title', '學員管理')
@section('header', '黑名單規則')

@section('content')
<!-- Content Start -->
        <!--黑名單規則內容-->
        <div class="card m-3">
          <div class="card-body m-3">
            <h5><b>單一課程累積</b></h5>
            <div class="form-group row mb-3">
                <div class="col-3">
                    <div class="form-check w-50">
                        <input class="form-check-input" type="checkbox" value="" id="c_0">
                        <label class="form-check-label w-75" for="defaultCheck1">
                            <h6>未到<input type="text" id="t_0" class="border-top-0 border-right-0 border-left-0 mx-1 w-25 text-center">次</h6>
                        </label>    
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check w-50">
                        <input class="form-check-input" type="checkbox" value="" id="c_1">
                        <label class="form-check-label w-75" for="defaultCheck1">
                            <h6>取消<input type="text" id="t_1" class="border-top-0 border-right-0 border-left-0 mx-1 w-25 text-center">次</h6>
                        </label>    
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check w-75">
                        <input class="form-check-input" type="checkbox" value="" id="c_2">
                        <label class="form-check-label w-80" for="defaultCheck1">
                            <h6>未到+取消<input type="text" id="t_2" class="border-top-0 border-right-0 border-left-0 mx-1 w-25 text-center">次</h6>
                        </label>    
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check w-75">
                        <input class="form-check-input" type="checkbox" value="" id="c_3">
                        <label class="form-check-label " for="defaultCheck1">
                            <h6>出席<input type="text" id="t_3" class="border-top-0 border-right-0 border-left-0 mx-1 w-25 text-center">次但未留單</h6>
                        </label>    
                    </div>
                </div>
            </div>
            <h5><b>所有課程累積</b></h5>
            <div class="row mb-3">
                <div class="col-3">
                    <div class="form-check w-50">
                        <input class="form-check-input" type="checkbox" value="" id="c_4">
                        <label class="form-check-label w-75" for="defaultCheck1">
                            <h6>未到<input type="text" id="t_4" class="border-top-0 border-right-0 border-left-0 mx-1 w-25 text-center">次</h6>
                        </label>    
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check w-50">
                        <input class="form-check-input" type="checkbox" value="" id="c_5">
                        <label class="form-check-label w-75" for="defaultCheck1">
                            <h6>取消<input type="text" id="t_5" class="border-top-0 border-right-0 border-left-0 mx-1 w-25 text-center">次</h6>
                        </label>    
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check w-75">
                        <input class="form-check-input" type="checkbox" value="" id="c_6">
                        <label class="form-check-label w-80" for="defaultCheck1">
                            <h6>未到+取消<input type="text" id="t_6" class="border-top-0 border-right-0 border-left-0 mx-1 w-25 text-center">次</h6>
                        </label>    
                    </div>
                </div>
                <div class="col-3">
                    
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="update();">儲存</button>
          </div>
        </div>
<!-- Content End -->

<script>
    $("document").ready(function(){
        show();
    });

    // 顯示資料 Rocky (2020/03/01)
    function show(){
        $.ajax({
            type : 'POST',
            url:'blacklist_rule', 
            dataType: 'json',                    
            success:function(data){        
                $.each(data, function(index,val) {     
                    // 勾選狀態        
                    if (val['rule_status'] == '1') {
                        $('input[id=c_' + val['rule_value'] + ']').prop("checked", true);
                        $('input[id=c_' + val['rule_value'] + ']').val('1');
                    } else {
                        $('input[id=c_' + val['rule_value'] + ']').prop("checked", false);
                        $('input[id=c_' + val['rule_value'] + ']').val('0');
                    }

                    // 規則
                    $('input[id=t_' + val['rule_value'] + ']').val(val['regulation']);;                    
                }); 
            },
            error: function(error){
                console.log(JSON.stringify(error));     
            }
        });
    }

    // 更新資料 Rocky (2020/03/01) 
    function update(){
        var checkboxlist = '',textlist = '';        
        // 勾選
        $( "input[type=checkbox]" ).each(function( index ) {
            if (this.checked) {
                checkboxlist +=  "1,";
            } else {
                checkboxlist +=  "0,";
            }            
        });
        if (checkboxlist.length > 0) {
            checkboxlist = checkboxlist.substring(0, checkboxlist.length - 1);
        }

        // 輸入框
        $( "input[type=text]" ).each(function( index ) {
            if (this.val != '') {
                textlist +=  $(this).val() + ",";
            } else {
                textlist +=  "0,";
            }            
        });
        if (textlist.length > 0) {
            textlist = textlist.substring(0, textlist.length - 1);
        }

        $.ajax({
            type : 'POST',
            url:'blacklist_rule_update', 
            data:{
                checkboxlist:checkboxlist,
                textlist:textlist                
            },
            success:function(data){
                alert(data)
                show();
            },
            error: function(error){
                console.log(JSON.stringify(error));     
            }
        });
    }
</script>

@endsection
     