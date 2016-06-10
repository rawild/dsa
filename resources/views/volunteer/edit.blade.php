@extends('layouts.master')


@section('contents')
<h2>Edit Volunteer</h2>
<div class="row">

    <form class="form-inline" method='POST' action="/editVolunteer" id='form'>
    <table class="table table-bordered table-condensed">
      <tr class="header">
        <td>First Name</td><td>Last Name</td><td class='emailwidth'>Email</td><td>Phone</td><td>Neighborhood</td><td>Street</td><td>Zip</td><td>Borough</td><td>Bad Email</td><td>Bad Phone</td><td>Do Not Contact</td>
      </tr>
      <tr>
      <td>
        <input type='text' class='form-control' id='table' name='FirstName' value="{{$volunteer->FirstName}}">
      </td>
      <td >
        <input type='text' class='form-control' id='table'  name='LastName' value="{{$volunteer->LastName}}">
      </td>
      <td class='emailwidth'>
        <input type='text' class='form-control' id='table'  name='Email' value="{{$volunteer->Email}}">
      </td>
      <td>
        <input type='text' class='form-control' id='table'  name='Phone' value="{{$volunteer->Phone}}">
      </td>
      <td>
        <input type='text' class='form-control' id='table'  name='Neighborhood' value="{{$volunteer->Neighborhood->Name}}">
      </td>
      <td>
        <input type='text' class='form-control' id='table'  name='Street' value="{{$volunteer->Street}}">
      </td>
      <td>
        <input type='text' class='form-control' id='table'  name='Zip' value="{{$volunteer->Zip}}">
      </td>
      <td>
        <input type='text' class='form-control' id='table'  name='City' value="{{$volunteer->City}}">
      </td>
      <td>
        <?php $checked = ($volunteer->BadEmail == "1") ? 'checked' : ''?>
        <input type='checkbox' class='form-control'  name='BadEmail' value="true" {{$checked}}>
      </td>
      <td>
        <?php $checked = ($volunteer->BadPhone == "1") ? 'checked' : '' ?>
        <input type='checkbox' class='form-control' id='BadPhone' name='BadPhone' value="true" {{$checked}}>
      </td>
      <td>
        <?php $checked = ($volunteer->DoNotContact == "1") ? 'checked' : '' ?>
        <input type='checkbox' class='form-control' id='DoNotContact' name='DoNotContact' value="true" {{$checked}}>
      </td>
      <td>
        <button class="btn btn-success" type="submit"  >Submit</button>
        <input type='hidden' name='_token' value='{{ csrf_token() }}'>
        <input type='hidden' name = 'volunteer_id' value="{{$volunteer->id}}">
        <input type='hidden' name = 'search_id' value='{{$search_id}}'>
      </td>
    </tr>
  </table>
    </form>

</div>
<div class='row'>
  <div class='col-md-4'>
    <h2>Contact Events</h2>
  </div>
  <div class='col-md-9 col-md-offset-1'>
      <table class="table table-bordered table-condensed">
        <tr class='header'>
          <td>Date</td><td>Caller</td><td>Purpose</td><td>RSVP</td><td>Call</td><td>VoiceMail</td><td>Text</td><td>Email</td><td>Comment</td>
        </tr>
        @foreach($volunteer->contactevents as $contactevent)
        <tr class='active'>
          <td>{{$contactevent->Date}}</td><td>{{$contactevent->Caller}}</td><td>{{$contactevent->Purpose}}</td><td>{{$contactevent->RSVP}}</td><td>{{$contactevent->Call}}</td><td>{{$contactevent->VoiceMail}}</td><td>{{$contactevent->Text}}</td><td>{{$contactevent->Email}}</td><td>{{$contactevent->Comment}}</td>
        </tr>
        @endforeach
      </table>
  </div>
</div>
@stop
