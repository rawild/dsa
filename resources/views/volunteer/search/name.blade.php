@extends('layouts.master')


@section('contents')
<h1>Search for a Volunteer</h1>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
    <form class="form" method='POST' action="/volSearchName">
      <h2>Search by Name</h2>
      <div class="form-group">
        <label for="FirstName">First Name</label>
        <input type="text" class="form-control" id="FirstName" name="FirstName"> <br>
      </div>
      <div class = "form-group">
      <label for="LastName">Last Name</label>
      <input type="text" class="form-control" id="LastName" name="LastName"> <br>
    </div>
    <div class = "form-group">
      <button class="btn btn-success" type="submit"  >Search</button>
      <input type='hidden' name='_token' value='{{ csrf_token() }}'>
      <input type='hidden' name='type' value='Name'>
      <input type='hidden' name='user_id' value='{{Auth::user()->id}}'>
    </div>
    </form>
    <form class="form" method='POST' action="/volSearchName">
        <h2>Search by Email</h2>
        <div class = "form-group">
          <label for="Email">Email</label>
          <input type="text" class="form-control" id="Email" name="Email"> <br>
        </div>
        <div class="form-group">
          <button class="btn btn-success" type="submit"  >Search </button>
          <input type='hidden' name='_token' value='{{ csrf_token() }}'>
          <input type='hidden' name='type' value='Email'>
          <input type='hidden' name='user_id' value='{{Auth::user()->id}}'>
        </div>
      </form>
      <form class="form" method='POST' action="/volSearchName">
        <h2>Search by Phone</h2>
        <div class="form-group">
          <label for="Phone">Phone</label>
          <input type="text" class="form-control" id="Phone" name="Phone"> <br>
        </div>
        <div>
          <button class="btn btn-success" type="submit"  >Search</button>
          <input type='hidden' name='_token' value='{{ csrf_token() }}'>
          <input type='hidden' name='type' value='Phone'>
          <input type='hidden' name='user_id' value='{{Auth::user()->id}}'>
        </div>
      </form>
  </div>
</div>
@stop
