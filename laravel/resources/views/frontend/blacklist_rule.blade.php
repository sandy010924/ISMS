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
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label w-75" for="defaultCheck1">
                            <h6>未到<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-25 text-center">次</h6>
                        </label>    
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check w-50">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label w-75" for="defaultCheck1">
                            <h6>取消<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-25 text-center">次</h6>
                        </label>    
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check w-75">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label w-75" for="defaultCheck1">
                            <h6>未到+取消<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-25 text-center">次</h6>
                        </label>    
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check w-75">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label " for="defaultCheck1">
                            <h6>出席<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-25 text-center">次但未留單</h6>
                        </label>    
                    </div>
                </div>
            </div>
            <h5><b>所有課程累積</b></h5>
            <div class="row mb-3">
                <div class="col-3">
                    <div class="form-check w-50">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label w-75" for="defaultCheck1">
                            <h6>未到<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-25 text-center">次</h6>
                        </label>    
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check w-50">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label w-75" for="defaultCheck1">
                            <h6>取消<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-25 text-center">次</h6>
                        </label>    
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check w-75">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label w-75" for="defaultCheck1">
                            <h6>未到+取消<input type="text" class="border-top-0 border-right-0 border-left-0 mx-1 w-25 text-center">次</h6>
                        </label>    
                    </div>
                </div>
                <div class="col-3">
                    
                </div>
            </div>
            <button type="button" class="btn btn-primary">儲存</button>
          </div>
        </div>
<!-- Content End -->
@endsection
     