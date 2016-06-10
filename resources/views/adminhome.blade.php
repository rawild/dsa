@extends('layouts.master')

@section('contents')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome to the Volunteer Hub Admin Dashboard</div>

                <div class="panel-body">
                  <h2>Recent/Upcoming Events</h2>
                  <div>
                  <table class="table table-bordered table-condensed">
                  <tr class = 'header'>
                    <td>Id</td><td>Name</td><td>Date</td><td>Neighborhood</td><td>Type</td><td>Attendees</td>
                  </tr>
                  @foreach($events as $event)
                  <tr>
                    <td>{{$event->id}}</td><td>{{$event->Name}} </td><td>{{$event->Date}} </td><td>{{$event->neighborhood->Name}} </td><td>{{$event->Type}} </td><td>{{sizeof($event->volunteers)}}</td>
                    <td>
                      <form method='GET' action='/editEvent'>
                        <button class="btn btn-link" id="editlink" type="submit">Edit</button>
                        <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                        <input type='hidden' name='event_id' value='{{$event->id}}'>
                      </form>
                    </td>
                    <td>
                      @include('partials.addAttendees')
                    </td>
                    <td>
                      <form method='GET' action='/addFile'>
                        <button class="btn btn-link" id="editlink" type="submit">Manage Files</button>
                        <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                        <input type='hidden' name='event_id' value='{{$event->id}}'>
                      </form>
                    </td>
                  </tr>
                  @endforeach
                  </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
