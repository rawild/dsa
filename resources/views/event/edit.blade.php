@extends('layouts.master')


@section('contents')

<h4>Edit Event</h4>
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <form method='POST' action="/editEvent" id='form'>
      <div class = 'form-group'>
        <label for='EventName'>Event Name:</label>
        <input type='text' class='form-control' id='Name' name='EventName' value='{{$event->Name}}'> <br>
      </div>
      <div class = 'form-group'>
        <label for='EventDate'>Event Date:</label>
        <input type='text' class='form-control' id='EventDate' name='EventDate' value='{{$event->Date}}'> <br>
      </div>
      <div class = 'form-group'>
        <label for='Neighborhood'>Neighborhood:</label>
        <input type='text' class='form-control' id='Neighborhood' name='Neighborhood' value ='{{$event->neighborhood->Name}}'> <br>
      </div>
      <div class='form-group'>
          <label for='EventType'>Event Type:</label>
          <select name='EventType' id='EventType'>
              @foreach($event_types as $event_type)
                {{ $selected = ($event_type == $event->Type) ? 'selected' : '' }}
                <option {{$selected}}> {{ $event_type}} </option>
              @endforeach
          </select>
      </div>
      <button class="btn btn-success" type="submit"  >Edit</button>
      <input type='hidden' name='_token' value='{{ csrf_token() }}'>
      <input type='hidden' name='event_id' value='{{$event->id}}'>
    </form>
  </div>
</div>
@stop
