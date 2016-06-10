@extends('layouts.master')

@section('contents')

<input id="fileupload" type="file" name="files[]" data-url="Applications/MAMP/htdocs/teambernieny/vendor/blueimp/server/php/" multiple>
<script>
$(function () {
    $('#fileupload').fileupload({
        dataType: 'json',
        add: function (e, data) {
            data.context = $('<p/>').text('Uploading...').appendTo(document.body);
            data.submit();
        },
        done: function (e, data) {
            data.context.text('Upload finished.');
        }
    });
});
</script>
@stop
