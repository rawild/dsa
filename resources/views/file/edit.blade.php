@extends('layouts.sidebar')
@extends('file.base')

@section('contents')
  <h4>Edit File for {{$event->Name}}</h4>
  <div class="col-md-4 col-md-offset-1">
    <form method='POST' action="/editFile" id='form'>
      <div class = 'form-group'>
        <label for='FileName'>File Name:</label>
        <input type='text' class='form-control' id='FileName' name='FileName' value='{{$editfile->Name}}'> <br>
      </div>
      <div class = 'form-group'>
        <label for='TotalRows'>Total Number of Rows</label>
        <input type='text' class='form-control' id='TotalRows' name='TotalRows' value='{{$editfile->TotalRows}}'> <br>
      </div>
      <div class = 'form-group'>
        <label for='CompletedRows'>Number of Rows Completed (defaults to zero)</label>
        <input type='text' class='form-control' id='CompletedRows' name='CompletedRows' value='{{$editfile->CompletedRows}}'> <br>
      </div>
      <div class='form-group'>
          <?php if($editfile->Completed == "1"){
            $checked = 'checked';
          } else {
            $checked = '';
          } ?>
          <input type='checkbox' name='Completed' {{$checked}}>   Completed<br>
      </div>
      <button class="btn btn-success" type="submit"  >Edit</button>
      <input type='hidden' name='_token' value='{{ csrf_token() }}'>
      <input type='hidden' name='event_id' value='{{$event->id}}'>
      <input type='hidden' name='file_id' value='{{$editfile->id}}'>
    </form>
  </div>
</div>

@stop
