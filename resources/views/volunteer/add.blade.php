@extends('layouts.master')



@section('contents')
<h2>Add Volunteer</h2>
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <form method='POST' action="/addVolunteer" id='form'>
      <div class = 'form-group'>
        <label for='FirstName'>FirstName:</label>
        <input type='text' class='form-control' id='FirstName' name='FirstName' > <br>
      </div>
      <div class = 'form-group'>
        <label for='LastName'>LastName:</label>
        <input type='text' class='form-control' id='LastName'name='LastName' > <br>
      </div>
      <div class = 'form-group'>
        <label for='Email'>Email:</label>
        <input type='text' class='form-control' id='Email' name='Email' value='{{$email}}'> <br>
      </div>
      <div class = 'form-group'>
        <label for='Phone'>Phone (no dashes):</label>
        <input type='text' class='form-control' id='Phone' name='Phone'> <br>
      </div>
      <div class = 'form-group'>
        <label for='Neighborhood'>Neighborhood:</label>
        <input type='text' class='form-control' id='Neighborhood' name='Neighborhood'> <br>
      </div>
      <div class = 'form-group'>
        <label for='Street'>Street:</label>
        <input type='text' class='form-control' id='Street' name='Street'> <br>
      <div>
      <div class = 'form-group'>
        <label for='Zip'>Zip:</label>
        <input type='text' class='form-control' id='Zip' name='Zip' > <br>
      </div>
      <div class = 'form-group'>
        <label for='Borough'>Borough:</label>
        <input type='text' class='form-control' id='Borough' name='City'> <br>
      </div>
      <button class="btn btn-success" type="submit"  >Add</button>
      <input type='hidden' name='_token' value='{{ csrf_token() }}'>
      <input type='hidden' name = 'type' value='Add'>
    </form>
  </div>
</div>
@stop
