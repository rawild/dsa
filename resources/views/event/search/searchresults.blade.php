@extends('layouts.master')


@section('contents')
<h1>Events from Search</h1>
@if(sizeof($events) == '0')
<div>
  :( Sorry no events match that result
</div>
@else


<div id=dvData>
  <table class="table table-bordered table-condensed">
  <tr class = 'header'>
    <td>Id</td><td>Name</td><td>Date</td><td>Neighborhood</td><td>Type</td>
  </tr>
  @foreach($events as $event)
  <tr>
    <td>{{$event->id}}</td><td>{{$event->Name}} </td><td>{{$event->Date}} </td><td>{{$event->neighborhood->Name}} </td><td>{{$event->Type}} </td>
    <td>
    <form method='GET' action='/editEvent'>
      <button class="btn btn-link" id="editlink" type="submit">Edit</button>
      <input type='hidden' name='_token' value='{{ csrf_token() }}'>
      <input type='hidden' name='Event' value='{{$event->id}}'>
    </form>
    </td>
  </tr>
  @endforeach
  </table>
</div>
@endif
@stop
