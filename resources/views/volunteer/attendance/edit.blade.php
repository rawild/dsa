@extends('layouts.sidebar')
@extends('volunteer.attendance.base')
@section('contents')
  <h2>Edit Attendance</h2>
  <div class="col-md-4 col-md-offset-1">
    <form method='POST' action="/editAttendance" id='form'>
      <div class = 'form-group'>
        <label for='FirstName'>FirstName:</label>
        <input type='text' class='form-control' id='FirstName' name='FirstName' value="{{$attendance->volunteer->FirstName}}"> <br>
      </div>
      <div class = 'form-group'>
        <label for='LastName'>LastName:</label>
        <input type='text' class='form-control' id='LastName'name='LastName' value="{{$attendance->volunteer->LastName}}"> <br>
      </div>
      <div class = 'form-group'>
        <label for='Email'>Email:</label>
        <input type='text' class='form-control' id='Email' name='Email' value="{{$attendance->volunteer->Email}}"> <br>
      </div>
      <div class = 'form-group'>
        <label for='Phone'>Phone:</label>
        <input type='text' class='form-control' id='Phone' name='Phone' value="{{$attendance->volunteer->Phone}}"> <br>
      </div>
      <div class = 'form-group'>
        <label for='Neighborhood'>Neighborhood:</label>
        <input type='text' class='form-control' id='Neighborhood' name='Neighborhood' value="{{$attendance->volunteer->Neighborhood->Name}}"> <br>
      </div>
      <div class = 'form-group'>
        <label for='Street'>Street:</label>
        <input type='text' class='form-control' id='Street' name='Street' value="{{$attendance->volunteer->Street}}"> <br>
      </div>
      <div class = 'form-group'>
        <label for='Zip'>Zip:</label>
        <input type='text' class='form-control' id='Zip' name='Zip' value="{{$attendance->volunteer->Zip}}"> <br>
      </div>
      <div class = 'form-group'>
        <label for='Borough'>Borough:</label>
        <input type='text' class='form-control' id='Borough' name='City' value="{{$attendance->volunteer->City}}"> <br>
      </div>
      <div class = 'form-group'>
        <h3>Event Commitments from {{$attendance->event->Name}}:</h3>
        <label for='Host'>Host   </label>
        <input {{$host}} type='checkbox'  id='Host' name='commitments[]' value='Host'> <br>
        <label for='Attend'>Attend   </label>
        <input {{$attend}} type='checkbox'  id='Attend' name='commitments[]' value='Attend'> <br>
      </div>
      <button class="btn btn-success" type="submit"  >Edit Attendance</button>
      <input type='hidden' name ='_token' value='{{ csrf_token() }}'>
      <input type='hidden' name = 'attendance' value='{{$attendance->id}}'>
      <input type='hidden' name = 'event_id' value = '{{$event->id}}'>
      
    </form>
  </div>

@stop
