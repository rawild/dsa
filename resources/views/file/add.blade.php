@extends('layouts.sidebar')

@extends('file.base')

@section('contents')

  <h4>Add File for {{$event->Name}}</h4>
  <div class="col-md-4 col-md-offset-1">
    <form method='POST' action="/addFile" id='form'>
      <div class = 'form-group'>
        <label for='FileName'>File Name:</label>
        <input type='text' class='form-control' id='FileName' name='FileName' > <br>
      </div>
      <div class = 'form-group'>
        <label for='TotalRows'>Total Number of Rows</label>
        <input type='text' class='form-control' id='TotalRows' name='TotalRows'> <br>
      </div>
      <div class = 'form-group'>
        <label for='CompletedRows'>Number of Rows Completed (defaults to zero)</label>
        <input type='text' class='form-control' id='CompletedRows' name='CompletedRows'> <br>
      </div>
      <div class='form-group'>
          <input type='checkbox' name='Completed' value='true'>   Completed<br>
      </div>
      <button class="btn btn-success" type="submit"  >Add</button>
      <input type='hidden' name='_token' value='{{ csrf_token() }}'>
      <input type='hidden' name='event_id' value='{{$event->id}}'>
      <input type='hidden' name='user_id' value='{{Auth::user()->id}}'>
    </form>
  </div>
</div>

@stop
