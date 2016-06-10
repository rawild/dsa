@extends('layouts.master')


@section('contents')
<h1>Search Events By Neighborhood</h1>
<form class='form' method='post' action='/searchEventNeighborhood'>
  <div class='row'>
    <h2>Neighborhoods</h2>
    <div class='list'>
    <div class='col-md-2'>
      <h3>Bronx</h3>
      @foreach ($bronx as $neighborhood)
      <input type='checkbox' name='neighborhoods[]' value='{{$neighborhood->id}}'> {{ $neighborhood->Name }}, {{$neighborhood->Borough}}<br>
      @endforeach
    </div>
    <div class='col-md-2'>
      <h3>Brooklyn</h3>
      @foreach ($brooklyn as $neighborhood)
      <input type='checkbox' name='neighborhoods[]' value='{{$neighborhood->id}}'> {{ $neighborhood->Name }}, {{$neighborhood->Borough}}<br>
      @endforeach
    </div>
    <div class='col-md-2'>
      <h3>Manhattan</h3>
      @foreach ($manhattan as $neighborhood)
      <input type='checkbox' name='neighborhoods[]' value='{{$neighborhood->id}}'> {{ $neighborhood->Name }}, {{$neighborhood->Borough}}<br>
      @endforeach
    </div>
    <div class='col-md-2'>
      <h3>Queens</h3>
      @foreach ($queens as $neighborhood)
      <input type='checkbox' name='neighborhoods[]' value='{{$neighborhood->id}}'> {{ $neighborhood->Name }}, {{$neighborhood->Borough}}<br>
      @endforeach
    </div>
    <div class='col-md-2'>
      <h3>Staten Island</h3>
      @foreach ($statenisland as $neighborhood)
      <input type='checkbox' name='neighborhoods[]' value='{{$neighborhood->id}}'> {{ $neighborhood->Name }}, {{$neighborhood->Borough}}<br>
      @endforeach
    </div>
    <div class='col-md-2'>
      <h3>Other</h3>
      @foreach ($other as $neighborhood)
      <input type='checkbox' name='neighborhoods[]' value='{{$neighborhood->id}}'> {{ $neighborhood->Name }}, {{$neighborhood->Borough}}<br>
      @endforeach
    </div>
  </div>
  <div class='row'>
    <input type='hidden' name='_token' value='{{ csrf_token() }}'>
    <button class="btn btn-success" type="submit" >Get List</button>
  </div>
</div>
</form>
@stop
