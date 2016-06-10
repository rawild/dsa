@extends('layouts.app')
@section('body')
<div class="container theme-showcase" role="main">
  <div class='row'>
    @yield('header')
  </div>
  <div class='row'>
    @yield('sidebar')
    @yield('contents')
  </div>
</div>
@stop
