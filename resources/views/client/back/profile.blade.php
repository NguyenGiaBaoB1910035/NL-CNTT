@extends('client.template.master')

@section('title', "Hồ sơ | Benjamin Shop")

@section('content')
<!-- breadcrumb -->
<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="/home" class="stext-109 cl8 hov-cl1 trans-04">
            Trang chủ
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            Hồ sơ
        </span>
    </div>

    @livewire('profile', ['id' => Auth::id()])

</div>

@stop
