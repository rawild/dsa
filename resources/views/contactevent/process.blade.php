@extends('layouts.master')


@section('contents')
<h1>Enter a file of Contact Events to process</h1>
File format (with header row) should be: <br>
<div class="row">
  <div class="col-md-9 ">
    <table class='table-bordered table-condensed'>
      <tr>
        <th>FirstName</th> <th>LastName</th><th>Zip</th><th>Phone</th><th>County</th><th>Email</th><th>Caller</th><th>Called</th><th>PickedUp</th><th>Texted</th><th>VM</th>
        <th>RSVP</th><th>Event</th><th>Date</th><th>DoNotContact</th><th>BadPhone</th><th>Comment</th>
      </tr>
      <tr>
        <td>Bernie</td> <td>Sanders</td><td>05342</td><td>1234567890</td><td>Burlington</td><td>wecometowin@gmail.com</td><td>Ella</td><td>Y</td><td>Y</td><td>N</td><td>N</td>
        <td>Y</td><td>Iowa Victory Celebration</td><td>02/01/2016</td><td></td><td></td><td>Will bring wife, Jane.</td>
      </tr>
    </table>
  </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
      <h4 id="message">{{ $message }}</h4>
      <form class="form" method='POST' action="/processContactEvents">
        <div class="form-group">
          <label for="FileName">File Name</label>
          <input type="text" class="form-control" id="FileName" name="FileName"> <br>
        </div>
        <div class="form-group">
          <label for="CDistrict">Congressional District (if any)</label>
          <input type="integer" class="form-control" id="CDistrict" name="CDistrict"> <br>
        </div>
        <div>
          <button class="btn btn-success" type="submit"  >Process</button>
          <input type='hidden' name='_token' value='{{ csrf_token() }}'>
        </div>
      </form>
  </div>
</div>
<h1>For older files</h1>
<div class="row">
  <div class="col-md-9 ">
    <table class='table-bordered table-condensed'>
      <tr>
        <th>FirstName</th> <th>LastName</th><<th>Phone</th><th>Neighborhood</th><th>Borough</th><th>Caller</th><th>Called</th><th>VM</th><th>Texted</th>
        <th>RSVP</th><th>Event</th><th>Date</th><th>DoNotContact</th><th>BadPhone</th><th>Comment</th>
      </tr>
      <tr>
        <td>Bernie</td> <td>Sanders</td><td>1234567890</td><td>Flatbush</td><td>Brooklyn</td><td>Joan</td><td>Y</td><td>Y</td><td>N</td>
        <td>Y</td><td>Team Bernie General Meeting</td><td>02/01/2016</td><td></td><td></td><td>Will bring wife, Jane.</td>
      </tr>
    </table>
  </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
      <h4 id="message">{{ $message }}</h4>
      <form class="form" method='POST' action="/processCityContactEvents">
        <div class="form-group">
          <label for="FileName">File Name</label>
          <input type="text" class="form-control" id="FileName" name="FileName"> <br>
        </div>
        <div class="form-group">
          <label for="CDistrict">Congressional District (if any)</label>
          <input type="integer" class="form-control" id="CDistrict" name="CDistrict"> <br>
        </div>
        <div>
          <button class="btn btn-success" type="submit"  >Process</button>
          <input type='hidden' name='_token' value='{{ csrf_token() }}'>
        </div>
      </form>
  </div>
</div>
@stop
