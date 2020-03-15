@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '場次數據圖表')

@section('content')

  @component('components.course_list_chart')
    @slot('date') {{ $events_data['date']}} @endslot
    @slot('course') {{ $events['course']}} @endslot
    @slot('event') {{ $events['name']}} @endslot
    @slot('location') {{ $events['location']}} @endslot
    @slot('closeorder') {{ $events['closeorder']}} @endslot
    @slot('host') {{ $events['host']}} @endslot
    @slot('staff') {{ $events['staff']}} @endslot
    @slot('weather') {{ $events['weather']}} @endslot
    @slot('memo') {{ $events['memo']}} @endslot
    @slot('money') {{ $events['money']}} @endslot
    @slot('money_fivedays') {{ $events['money_fivedays']}} @endslot
    @slot('money_installment') {{ $events['money_installment']}} @endslot
    @slot('settle') {{ $events_data['settle']}} @endslot
    @slot('deposit') {{ $events_data['deposit']}} @endslot
    @slot('order') {{ $events_data['order']}} @endslot
    @slot('count_check') {{ $events_data['count_check']}} @endslot
    @slot('count_cancel') {{ $events_data['count_cancel']}} @endslot
  @endcomponent

@endsection