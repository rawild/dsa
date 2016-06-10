@extends('layouts.master')


@section('contents')
  <h1>Search Results</h1>



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
        exportTableToCSV.apply(this, [$('#dvData>table'), 'SearchResults.csv']);

        // IF CSV, don't do event.preventDefault() or return false
        // We actually need this to be a typical hyperlink
    });
});
  </script>
@if(sizeof($volunteers) == '0')
<div>
  :( Sorry no volunteers match that result
</div>
@else

<a class="export" href="#" >Download CSV</a>

<div class ="row">
  <div id=dvData >
    <table class="table table-bordered table-condensed">
      <tr class = 'header'>
        <td>FirstName</td><td>LastName</td><td>Email</td><td>Phone</td><td>Zip</td><td>Neighborhood</td><td>BadPhone</td><td>BadEmail</td><td>DoNotContact</td><td>ContactEvents</td><td>RSVPs</td><td>Last Contacted</td>
      </tr>
      @foreach($volunteers as $volunteer)
      <tr>
        <td>{{$volunteer->FirstName}} </td><td>{{$volunteer->LastName}} </td><td>{{$volunteer->Email}} </td><td>{{$volunteer->Phone}} </td> <td>{{$volunteer->Zip}} </td><td>{{$volunteer->neighborhood->Name}} </td><td>{{$volunteer->BadPhone}} </td>
        <td>{{$volunteer->BadEmail}} </td><td>{{$volunteer->DoNotContact}} </td><td>{{sizeof($volunteer->contactevents)}}</td>
        <td>@if(sizeof($volunteer->contactevents) > 0)
            {{sizeof($volunteer->contactevents->where('RSVP',1))}}
            @endif
          </td>
          <td> @if(sizeof($volunteer->contactevents) > 0)
            {{$volunteer->contactevents->max('Date')}}
          @endif
        </td>
        <td>
        <form method='POST' action='/checkVolunteer'>
          <button class="btn btn-link" id="editlink" type="submit">Edit</button>
          <input type='hidden' name='_token' value='{{ csrf_token() }}'>
          <input type='hidden' name='Email' value='{{$volunteer->Email}}'>
          <input type='hidden' name='type' value='Check'>
          <input type='hidden' name='search_id' value='{{$search_id}}'>
        </form>
        </td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endif

@stop
