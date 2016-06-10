@extends('layouts.app')



@section('head')
  <h1>Volunteer Hub</h1>

@stop

@section('contents')
<div>
  <h2>Neighborhoods:</h2>
    <a class="btn btn-primary" role="button"  href='/addNeighborhood'>Add Neighborhood</a>
    <a class="btn btn-primary" role="button"  href='/editNeighborhood'>Edit Neighborhood</a>
    <a class="btn btn-primary" role="button" href='/mergeNeigborhood'>Merge Neigborhood</a>
  </div>
<div>
  <h2>Tags:</h2>
  <a class="btn btn-primary"  role="button" href='/addTag'>Add Tag</a>
  <a class="btn btn-primary"  role="button" href='/mergeTag'>Edit Tag</a>
  <a class="btn btn-primary"  role="button" href='/mergeTag'>Merge Tag</a>
</div>

@stop
