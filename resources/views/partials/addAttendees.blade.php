
<form method='GET' action='/checkAttendee'>
  <button class="btn btn-link" id="editlink" type="submit">Add Attendees</button>
  <input type='hidden' name='_token' value='{{ csrf_token() }}'>
  <input type='hidden' name='event_id' value='{{$event->id}}'>
</form>
