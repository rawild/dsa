@extends('layouts.master')


@section('contents')
<h1>All Volunteers</h1>
<div id=dvData>
  <table class="table table-bordered table-condensed">
  <tr class = 'header'>
    <td>Id</td><td>FirstName</td><td>LastName</td><td>Email</td><td>Phone</td><td>Zip</td><td>Neighborhood</td><td>BadPhone</td><td>BadEmail</td><td>DoNotContact</td><td>ContactEvents</td>
  </tr>
  @foreach($volunteers as $volunteer)
  <tr>
    <td>{{$volunteer->id}}</td><td>{{$volunteer->FirstName}} </td><td>{{$volunteer->LastName}} </td><td>{{$volunteer->Email}} </td><td>{{$volunteer->Phone}} </td> <td>{{$volunteer->Zip}} </td><td>{{$volunteer->neighborhood->Name}} </td><td>{{$volunteer->BadPhone}} </td><td>{{$volunteer->BadEmail}} </td><td>{{$volunteer->DoNotContact}} </td><td>{{sizeof($volunteer->contactevents)}}</td>
    <td>
    <form method='POST' action='/addVolunteer'>
      <button class="btn btn-link" id="editlink" type="submit">Edit</button>
      <input type='hidden' name='_token' value='{{ csrf_token() }}'>
      <input type='hidden' name='Email' value='{{$volunteer->Email}}'>
      <input type='hidden' name='type' value='Check'>
    </form>
    </td>
  </tr>
  @endforeach
</table>
</div>
@stop
