
@section('sidebar')


  <div class ="col-md-6">
    Files for {{$event->Name}}
    <table class="table table-bordered table-condensed">
    <tr class = 'header'>
      <td>Name</td><td>Total Rows</td><td>Rows Completed</td>
    </tr>
      @foreach($event->files as $file)
      <tr>
          <td>{{$file->Name}}</td><td>{{$file->TotalRows}} </td><td>{{$file->CompletedRows}}</td>
          <td>
          @if($file->Completed != "1")
          @include('partials.fileCompleted')
          @endif
          </td>
          <td>
          <form method='GET' action='/editFile'>
            <button class="btn btn-link" id="editlink" type="submit">Edit</button>
            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
            <input type='hidden' name='file_id' value='{{$file->id}}'>
            <input type='hidden' name='event_id' value='{{$event->id}}'>
          </form>
          </td>
      </tr>
      @endforeach
    </table>
  </div>


@stop
