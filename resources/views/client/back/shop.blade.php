@extends('client.template.master')

@section('title', "Shop | Benjamin Shop")

@section('content')

<div class="bg0 m-t-23 p-b-140">
    @livewire('product-filter')
</div>

@stop
