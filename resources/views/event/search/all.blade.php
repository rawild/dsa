@extends('layouts.master')


@section('contents')
<h1>All Events</h1>

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
      <input type='hidden' name='event_id' value='{{$event->id}}'>
    </form>
    </td>
  </tr>
  @endforeach
</table>
</div>
@stop
