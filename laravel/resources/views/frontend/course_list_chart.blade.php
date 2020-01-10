@extends('frontend.layouts.master')

@section('title', '課程管理')
@section('header', '場次數據圖表')

@section('content')

  @include('components.course_list_chart')

@endsection