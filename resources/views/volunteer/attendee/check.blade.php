@extends('layouts.sidebar')
@extends('volunteer.attendance.base')

@section('contents')
  <div class="col-md-4 col-md-offset-1">
      @if($message != "")
        <h2>{{$message}}</h2>
      @endif
  <h2>Find Volunteer</h2>
  <form class="form" method='POST' action="/checkAttendee" id='form'>
    <label for='Email'>Email:</label>
    <input class='form-control' id='Email' type='text' name='Email'> <br>
    <button class="btn btn-success" type="submit"  >Find</button>
    <input type='hidden' name='_token' value='{{ csrf_token() }}'>
    <input type='hidden' name='event_id' value='{{ $event->id }}'>
    <input type='hidden' name ='type' value='Email'>
  </form>
  <h3>OR</h3>
  <form class="form" method='POST' action="/checkAttendee" id='form'>
    <label for='Phone'>Phone:</label>
    <input class='form-control' id='Phone' type='text' name='Phone'> <br>
    <button class="btn btn-success" type="submit"  >Find</button>
    <input type='hidden' name ='_token' value='{{ csrf_token() }}'>
    <input type='hidden' name ='event_id' value='{{ $event->id }}'>
    <input type='hidden' name ='type' value='Phone'>
  </form>
</div>

@stop
