<form method='POST' action='/completeFileReg'>
  <button class="btn btn-link" id="completelink" type="submit">Mark Complete</button>
  <input type='hidden' name='_token' value='{{ csrf_token() }}'>
  <input type='hidden' name='event_id' value='{{$event->id}}'>
  <input type='hidden' name='file_id' value='{{$file->id}}'>
  <input type='hidden' name='user_id' value='{{Auth::user()->id}}'>
</form>
