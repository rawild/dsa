@extends('layouts.master')


@section('contents')
<h1>Search Events By Date</h1>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
    <form class="form" method='POST' action="/searchEventDate">
      From Date (YYYY-MM-DD):
      <input type="text" name="FromDate"> <br>
      <br>
      To Date (YYYY-MM-DD):
      <input type="text" name="ToDate"> <br>
      <br>
      <button class="btn btn-success" type="submit"  >Search</button>
      <input type='hidden' name='_token' value='{{ csrf_token() }}'>
    </form>
  </div>
</div>
@stop
