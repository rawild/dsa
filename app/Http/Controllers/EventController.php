<?php

namespace dsa\Http\Controllers;

use dsa\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class EventController extends Controller {


    public function __construct() {
        # Put anything here that should happen before any of the other actions
    }

####################################------------------INTERACTING WITH THE DATA --------------------------#################################
    public function getAdd(Request $request){

      $event_types = ['Canvassing','Flyering','Meeting','Petitioning','PhoneBanking','Other'];
      return view('event.add')->with('event_types',$event_types);
    }
    public function postAdd(Request $request){
      $neighborhood_id = $this->checkNeighborhood($request);

      $event = new \dsa\Event();
      $this->saveEvent($request, $event, $neighborhood_id);


      return view('home');
    }
    public function getEdit(Request $request){
      $event_types = ['Canvassing','Flyering','Meeting','Petitioning','PhoneBanking','Other'];
      $event = \dsa\Event::with('neighborhood')->find($request->event_id);

      return view('event.edit')->with([
        'event_types' => $event_types,
        'event'=> $event
      ]);

    }
    public function postEdit(Request $request){
      $neighborhood_id = $this->checkNeighborhood($request);
      $eventcol = \dsa\Event::with('neighborhood')->where('id','=',$request->event_id)->get();
      $event = $eventcol->first();
      $this->saveEvent($request, $event, $neighborhood_id);

      return view('adminhome');
    }


    private function checkNeighborhood(Request $request){
      $neighborhoods = \dsa\Neighborhood::select('id')->where('Name','=',$request->Neighborhood)->get();
      if (sizeof($neighborhoods) > 0){
        $neighborhood = $neighborhoods->first();
        $neighborhood_id = $neighborhood->id;
      } else {
        $neighborhood = new \dsa\Neighborhood();
        $neighborhood->Name = $request->Neighborhood;
        $neighborhood->Borough = $request->City;
        $neighborhood->save();
        $neighborhood_id = $neighborhood->id;
      }
      return $neighborhood_id;
    }
    private function saveEvent(Request $request, \dsa\Event $event, $neighborhood_id){
      $event->Name = $request->EventName;
      $event->Date = $request->EventDate;
      $event->neighborhood_id = $neighborhood_id;
      $event->Type = $request->EventType;
      $event->neighborhood->save();
      $event->save();
    }
####################################------------------VIEWING THE DATA --------------------------#################################

  public function getSearchNeighborhood(Request $request){
    $events = \dsa\Event::with('neighborhood')->get();
    $bronx = array();
    $brooklyn = array();
    $manhattan = array();
    $queens = array();
    $statenisland = array();
    $other = array();
    foreach ($events as $event) {
      if ($event->neighborhood->Borough == 'Bronx'){
        array_push($bronx, $event->neighborhood);
      } elseif ($event->neighborhood->Borough == 'Brooklyn'){
        array_push($brooklyn, $event->neighborhood);
      } elseif ($event->neighborhood->Borough == 'Manhattan'){
        array_push($manhattan, $event->neighborhood);
      } elseif ($event->neighborhood->Borough == 'Queens'){
          array_push($queens, $event->neighborhood);
      } elseif ($event->neighborhood->Borough == 'Staten Island'){
          array_push($statenisland, $event->neighborhood);
      } else {
        array_push($other, $event->neighborhood);
      }
    }
    return view('event.search.zip')->with([
      'bronx' => $bronx,
      'brooklyn' => $brooklyn,
      'manhattan' => $manhattan,
      'queens' => $queens,
      'statenisland' => $statenisland,
      'other' => $other
    ]);
  }
  public function postSearchNeighborhood(Request $request){
    $events = \dsa\Event::distinct('id')->with('neighborhood')->whereIn('neighborhood_id', $request->neighborhoods)->get();
    return view('event.search.searchresults')->with([
      'events' => $events
    ]);
  }
  public function getSearchDate(Request $request){

    return view('event.search.date');
  }
  public function postSearchDate(Request $request){
    $events = \dsa\Event::with('neighborhood')->where('Date', '>=', $request->FromDate)->where('Date','<=',$request->ToDate)->get();
    return view('event.search.searchresults')->with([
      'events' => $events
    ]);
  }
  public function getAll(Request $request){
    $events = \dsa\Event::with('neighborhood')->orderby('id', 'DESC')->get();
    return view('event.search.all')->with([
      'events' => $events
    ]);
  }


}
