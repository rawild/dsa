@extends('layouts.master')


@section('contents')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
      @if($message != "")
        <h2>{{$message}}</h2>

      @endif
      <h2>Find Volunteer</h2>
      <form class="form" method='POST' action="/checkVolunteer" id='form'>
        <label for='Email'>Email:</label>
        <input class='form-control' id='Email' type='text' name='Email'> <br>
        <button class="btn btn-success" type="submit"  >Find</button>
        <input type='hidden' name='_token' value='{{ csrf_token() }}'>

      </form>
  </div>
</div>
@stop
