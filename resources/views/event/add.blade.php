@extends('layouts.master')


@section('contents')

<h4>Add Event</h4>
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <form method='POST' action="/addEvent" id='form'>
      <div class = 'form-group'>
        <label for='EventName'>Event Name:</label>
        <input type='text' class='form-control' id='Name' name='EventName' > <br>
      </div>
      <div class = 'form-group'>
        <label for='EventDate'>Event Date: (YYYY-MM-DD)</label>
        <input type='text' class='form-control' id='EventDate' name='EventDate'> <br>
      </div>
      <div class = 'form-group'>
        <label for='Neighborhood'>Neighborhood:</label>
        <input type='text' class='form-control' id='Neighborhood' name='Neighborhood'> <br>
      </div>
      <div class='form-group'>
          <label for='EventType'>Event Type:</label>
          <select name='EventType' id='EventType'>
              @foreach($event_types as $event_type)
                <option> {{ $event_type}} </option>
              @endforeach
          </select>
      </div>
      <button class="btn btn-success" type="submit"  >Add</button>
      <input type='hidden' name='_token' value='{{ csrf_token() }}'>
      <input type='hidden' name = 'type' value='Add'>
    </form>
  </div>
</div>
@stop
