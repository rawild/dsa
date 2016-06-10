
@section('header')
<script type="text/javascript"> $(document).ready(function () {

  function exportTableToCSV($table, filename) {
      var $rows = $table.find('tr:has(td)'),


      // Temporary delimiter characters unlikely to be typed by keyboard
      // This is to avoid accidentally splitting the actual contents
      tmpColDelim = String.fromCharCode(11), // vertical tab character
      tmpRowDelim = String.fromCharCode(0), // null character

      // actual delimiter characters for CSV format
      colDelim = '","',
      rowDelim = '"\r\n"',

      // Grab text from table into CSV formatted string
      csv = '"' + $rows.map(function (i, row) {
          var $row = $(row),
              $cols = $row.find('td');

          return $cols.map(function (j, col) {
              var $col = $(col),
                  text = $col.text();

              return text.replace(/"/g, '""'); // escape double quotes

          }).get().join(tmpColDelim);

        }).get().join(tmpRowDelim)
              .split(tmpRowDelim).join(rowDelim)
              .split(tmpColDelim).join(colDelim) + '"',

          // Data URI
          csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

      $(this)
          .attr({
          'download': filename,
              'href': csvData,
              'target': '_blank'
      });
  }

  // This must be a hyperlink
  $(".export").on('click', function (event) {
      // CSV
      exportTableToCSV.apply(this, [$('#dvData>table'), 'attendees.csv']);

      // IF CSV, don't do event.preventDefault() or return false
      // We actually need this to be a typical hyperlink
  });
});
</script>
<a class="export" href="#" >Download CSV</a>
@stop
@section('sidebar')
  <div class ="col-md-6">
    <h4>{{$event->Name}} Attendees</h4>

    <div id=dvData>
    <table class="table table-bordered table-condensed">
    <tr class = 'header'>
      <td>Name</td><td>Email</td>
    </tr>
      @if($eventvolunteers != "")
      @foreach($eventvolunteers as $attendee)
      <tr>
        @if($attendee->volunteer != "")
          <td>{{$attendee->volunteer->FirstName}} {{$attendee->volunteer->LastName}} </td><td>{{$attendee->volunteer->Email}} </td>
          <td>
          <form method='GET' action='/editAttendance'>
            <button class="btn btn-link" id="editlink" type="submit">Edit</button>
            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
            <input type='hidden' name='attendance' value='{{$attendee->id}}'>
            <input type='hidden' name='event_id' value = '{{$event->id}}' >
          </form>
          </td>
       @endif
      </tr>
      @endforeach
      @endif
    </table>
  </div>
  </div>


@stop
