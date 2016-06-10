<?php

namespace dsa\Http\Controllers;

use dsa\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Redirect;

class VolunteerController extends Controller {


    public function __construct() {
        # Put anything here that should happen before any of the other actions
    }
###################### --------------- INTERACTING WITH THE DATA -------------- #######################################
    public function getCheck(Request $request){

      return view('volunteer.check')->with('message','');
    }
    public function postCheck(Request $request){
      if ($request->Email != "") {
        $volunteers = \dsa\Volunteer::distinct('id')->with('neighborhood')->where('Email','=',$request->Email)->get();
        if(sizeof($volunteers) > 0){
        return $this->returnEdit($volunteers[0], $request->search_id);

        }
      }
      if ($request->Email == ""){
        $request->Email = " ";
      }
      return view('volunteer.add')->with('email', $request->Email );
    }
    public function getAdd(Request $request){
      return view('volunteer.add')->with('email', '' );
    }
    public function postAdd(Request $request){
      $volunteers = \dsa\Volunteer::where('Email','=',$request->Email)->get();
      if(sizeof($volunteers) > 0){
        return $this->returnEdit($volunteers[0],"");
      } else {

        $volunteer = new \dsa\Volunteer();
        $neighborhoods = \dsa\Neighborhood::select('id')->where('Name','=',$request->Neighborhood)->get();
        if (sizeof($neighborhoods) > 0){
          $neighborhood = $neighborhoods->first();

        } else {
          $neighborhood = new \dsa\Neighborhood();
          $neighborhood->Name = $request->Neighborhood;
          $neighborhood->Borough = $request->City;
          $neighborhood->save();

        }
        $neighborhood_id=$neighborhood->id;
        $volunteer->FirstName = $request->FirstName;
        $volunteer->LastName = $request->LastName;
        $volunteer->Email = $request->Email;
        $volunteer->Phone = $request->Phone;
        $volunteer->Zip = $request->Zip;
        $volunteer->neighborhood_id = $neighborhood_id;
        $volunteer->Street = $request->Street;
        $volunteer->neighborhood->Borough = $request->City;
        $volunteer->City = $request->City;
        $volunteer->save();

        return view('volunteer.check')->with('message','Volunteer Added');
      }
    }

    public function postEdit(Request $request){
      $volunteercol = \dsa\Volunteer::with('neighborhood')->where('id','=',$request->volunteer_id)->get();
      $volunteer = $volunteercol->first();
      $volunteer->FirstName = $request->FirstName;
      $volunteer->LastName = $request->LastName;
      $volunteer->Email = $request->Email;
      $volunteer->Phone = $request->Phone;
      $volunteer->Zip = $request->Zip;
      $volunteer->neighborhood->Name = $request->Neighborhood;
      $volunteer->Street = $request->Street;
      $volunteer->neighborhood->Borough = $request->City;
      $volunteer->City = $request->City;
      if($request->BadEmail == 'true'){
        $volunteer->BadEmail = "1";
      } else {
        $volunteer->BadEmail = "0";
      }
      if($request->BadPhone == 'true'){
        $volunteer->BadPhone = "1";
      } else {
        $volunteer->BadPhone = "0";
      }
      if($request->DoNotContact == 'true'){
        $volunteer->DoNotContact = "1";
      } else {
        $volunteer->DoNotContact = "0";
      }
      $volunteer->neighborhood->save();
      $volunteer->save();
      if($request->search_id == ""){
        return Redirect::back();
      } else {
        $search = \dsa\Search::find($request->search_id);
        $parameters = explode(",", $search->Parameters);
        if ($search->Type == "ZN"){
          $zips = array();
          $neighborhoods = array();
          foreach($parameters as $parameter){
            if ($parameter > 10000){
              array_push($zips, $parameter);
            } else{
              array_push($neighborhoods, $parameter);
            }
          }
        $request->zips = $zips;
        $request->neighborhoods = $neighborhoods;
        return $this->postSearchZip($request);
        }else{
        if($search->Type = "Name"){
          $request->FirstName = $parameters[0];
          $request->LastName = $parameters[1];
          $request->type = $search->Type;
        }elseif($search->Type == "Email"){
          $request->Email = $parameters[0];
          $request->type = $search->Type;
        }elseif($search->Phone == "Phone"){
          $request->Phone = $parameters[0];
          $request->type = $search->Type;
        }
        return $this->postSearchName($request);
      }
    }

  }

    private function returnEdit(\dsa\Volunteer $volunteer, $search_id){
      $volunteers = \dsa\Volunteer::with('contactevents')->with('neighborhood')->where('Email','=',$volunteer->Email)->get();
      $volunteer = $volunteers[0];

      return view('volunteer.edit')->with([
        'volunteer' => $volunteer,
        'search_id' => $search_id
      ]);
    }




    ################################## --------------- VIEWING THE DATA -------------- #######################################

    public function getSearchZip(Request $request){
      //get the zips for the columns
      $zips =  \dsa\Volunteer::select('Zip')->distinct('Zip')->orderby('Zip')->get();
      $collength = sizeof($zips)/12;
      for($y =0; $y< 12; $y++){
        for($x=0;$x < $collength;$x++){
            $zipcol[$x]=$zips[$x+$collength*$y];
        }
        $zipcols[$y]=$zipcol;
      }

      $neighborhoods = \dsa\Neighborhood::distinct('Name')->orderby('Borough')->get();
      $bronx = $neighborhoods->whereLoose('Borough','Bronx')->sortBy('Name');
      $brooklyn = $neighborhoods->whereLoose('Borough','Brooklyn')->sortBy('Name');
      $manhattan = $neighborhoods->whereLoose('Borough','Manhattan')->sortBy('Name');
      $queens =$neighborhoods->whereLoose('Borough','Queens')->sortBy('Name');
      $statenisland = $neighborhoods->whereLoose('Borough','Staten Island')->sortBy('Name');
      $other = \dsa\Neighborhood::distinct('Name')->whereNotIn('Borough', ['Bronx','Brooklyn','Manhattan','Queens','Staten Island'])->orderby('Name')->get();


      return view('volunteer.search.zip')->with([
        'zipcols' => $zipcols,
        'bronx' => $bronx,
        'brooklyn' => $brooklyn,
        'manhattan' => $manhattan,
        'queens' => $queens,
        'statenisland' => $statenisland,
        'other' => $other
      ]);
    }
    public function postSearchZip(Request $request){
    if (($request->zips != "") && ($request->neighborhoods != "")){
      $volunteers = \dsa\Volunteer::distinct('id')->with('neighborhood')->with('contactevents')->whereIn('neighborhood_id', $request->neighborhoods)->orwhereIn('Zip',$request->zips)->get();
    } else if ($request->neighborhoods != ""){
      $volunteers = \dsa\Volunteer::distinct('id')->with('neighborhood')->with('contactevents')->whereIn('neighborhood_id', $request->neighborhoods)->get();
    } else {
      $volunteers = \dsa\Volunteer::distinct('id')->with('neighborhood')->with('contactevents')->whereIn('Zip',$request->zips)->get();
    }
    if($request->search_id == ""){
      $search=$this->saveSearch($request, "ZN");
    } else {
      $search = \dsa\Search::find($request->search_id);
      $search->save();
    }

    return $this->returnSearchResults($volunteers, $search->id);
  }

    public function getSearchName(Request $request){

      return view('volunteer.search.name');
    }
    public function postSearchName(Request $request){
      if($request->type == 'Name'){
        if(($request->FirstName != "") && ($request->LastName != "")){
          $volunteers = \dsa\Volunteer::distinct('id')->with('neighborhood')->with('contactevents')->where('FirstName','=',$request->FirstName)->where('LastName','=',$request->LastName)->get();
        } elseif($request->FirstName != ""){
          $volunteers = \dsa\Volunteer::distinct('id')->with('neighborhood')->with('contactevents')->where('FirstName','=',$request->FirstName)->get();

        } elseif($request->LastName != ""){
          $volunteers = \dsa\Volunteer::distinct('id')->with('neighborhood')->with('contactevents')->where('LastName','=',$request->LastName)->get();

        } else {
          $volunteers = \dsa\Volunteer::distinct('id')->with('neighborhood')->with('contactevents')->where('FirstName','=',$request->FirstName)->where('LastName','=',$request->LastName)->get();

        }
        if($request->search_id == ""){
          $search = $this->saveSearch($request,"Name");
        } else {
          $search = \dsa\Search::find($request->search_id);
          $search->save();
        }
      } else {
        if ($request->type == 'Email'){
            $volunteers = \dsa\Volunteer::distinct('id')->with('neighborhood')->with('contactevents')->where('Email','=',$request->Email)->get();
        } elseif ($request->type == 'Phone'){
          $volunteers = \dsa\Volunteer::distinct('id')->with('neighborhood')->with('contactevents')->where('Phone','=',$request->Phone)->get();
        }

     }
     if($request->search_id == ""){
          $search = $this->saveSearch($request,$request->type);
        }else{
          $search = \dsa\Search::find($request->search_id);
          $search->save();
        }


      return $this->returnSearchResults($volunteers,$search->id);
    }

    public function getAll(Request $request){
      $volunteers = \dsa\Volunteer::with('neighborhood')->with('contactevents')->orderby('FirstName')->get();

      return view('volunteer.search.all')->with(['volunteers' => $volunteers]);
    }
    private function returnSearchResults(\Illuminate\Database\Eloquent\Collection $volunteers, $search_id){

      $volunteers->sortBy(sizeof('contactevents'));

      return view('volunteer.search.searchresults')->with([
        'volunteers' => $volunteers,
        'search_id' => $search_id
      ]);
    }
    private function saveSearch(Request $request, $type){
      $search = new \dsa\Search();
      $search->Type = $type;
      if($type == "Name"){
        if(($request->FirstName != "") && ($request->LastName != "")){
          $parameters=$request->FirstName.",".$request->LastName;
        } elseif($request->FirstName != ""){
          $parameters=$request->FirstName;

        } elseif($request->LastName != ""){
          $parameters=$request->LastName;

        } else {
          $parameters=" ".","." ";
        }

      }
      if($type == "Email"){
        $parameters=$request->Email;
      }
      if($type == "Phone"){
        $parameters=$request->Phone;
      }
      if($type == "ZN"){
        if(($request->zips != "")&&($request->neighborhoods != "")){
          $parameters=implode(",",$request->zips).",".implode(",",$request->neighborhoods);
        } elseif($request->zips != ""){
          $parameters=implode(",",$request->zips);
        } elseif($request->neighborhoods != ""){
          $parameters=implode(",",$request->neighborhoods);
        }
      }
      $search->Parameters = $parameters;
      $search->user_id = $request->user_id;
      $search->save();
      return $search;
    }

}
