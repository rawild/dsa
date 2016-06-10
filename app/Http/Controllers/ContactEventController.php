<?php

namespace dsa\Http\Controllers;

use dsa\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Config;

class ContactEventController extends Controller {


    public function __construct() {
        # Put anything here that should happen before any of the other actions
    }


    public function getProcess(Request $request){
      return view('contactevent.process')->with([
        'message' => ""
      ]);
    }
    public function postProcess(Request $request){
      //open the file
      ini_set('auto_detect_line_endings',TRUE);
      $file = fopen(Config::get('app.filepath').$request->FileName,"r");
      $x = 0;

      while (($data = fgetcsv($file)) !== FALSE){
        //Get the header info for the file
        if ($x == 0){
          $x = $x+1;
          $data = array_map('strtoupper',$data);
          $header['FirstName']= array_search('FIRST',$data);
          $header['LastName']= array_search('LAST',$data);
          $header['Zip']= array_search('ZIP',$data);
          $header['Phone']=array_search('PHONE',$data);
          $header['Neighborhood']=array_search('Neighborhood',$data);
          $header['County']=array_search('COUNTY',$data);
          $header['Email']=array_search('EMAIL',$data);
          $header['Caller']=array_search('CALLER',$data);
          $header['Called']=array_search('CALLED',$data);
          $header['PickedUp']=array_search('PICKEDUP',$data);
          $header['Texted']=array_search('TEXTED',$data);
          $header['VM']=array_search('VM',$data);
          $header['RSVP']=array_search('RSVP',$data);
          $header['Event']=array_search('EVENT',$data);
          $header['Date']=array_search('DATE',$data);
          $header['DNC']=array_search('DO NOT CONTACT',$data);
          $header['BadPhone']=array_search('BAD PHONE',$data);
          $header['Comments']=array_search('COMMENTS',$data);

          continue;
        }
          #; Find Volunteer or add if does not exist
          if($data[$header['Phone']] != FALSE){ // check first by phone number
            $volunteers = \dsa\Volunteer::where('Phone','=',$data[$header['Phone']])->get();
          } elseif($data[$header['Email']] != FALSE){ //then by email if it exists
              $volunteers = \dsa\Volunteer::where('Email', '=',$data[$header['Email']])->get();
          }
          if(sizeof($volunteers) == 0){

            $volunteer = new \dsa\Volunteer();
            $volunteer->FirstName = $data[$header['FirstName']];
            $volunteer->LastName = $data[$header['LastName']];
            $volunteer->Phone = $data[$header['Phone']];
            $volunteer->Zip = $data[$header['Zip']];
            $volunteer->Email = $data[$header['Email']];
            $volunteer->County = $data[$header['County']];
            if(($header['Neighborhood'] != FALSE) && ($header['County'] != FALSE)){
              $volunteer->neighborhood_id = $this->checkNeighborhood($data[$header['Neighborhood']],$data[$header['County']]);
            } else {
              $volunteer->neighborhood_id = "1";
            }
            if($request->CDistrict != ""){
              $volunteer->CDistrict = $request->CDistrict;
            }
            $volunteer->user_id = "1";
            $volunteer->save();
            $volunteer_id = $volunteer->id;
          } else {
            $volunteer_id = $volunteers[0]->id;
            $volunteer = $volunteers[0];
          }
          if($data[$header['DNC']] == "1"){
            $volunteer->DoNotContact = true;
          }
          if($data[$header['BadPhone']] == "1"){
            $volunteer->BadPhone = true;
          }
          #; Check to see if volunteer was Called or texted -- add contact event if so
          $data[$header['Called']] = strtoupper($data[$header['Called']]);
          $data[$header['Texted']] = strtoupper($data[$header['Texted']]);
          $data[$header['PickedUp']] = strtoupper($data[$header['PickedUp']]);
          $data[$header['VM']] = strtoupper($data[$header['VM']]);
          $data[$header['RSVP']] = strtoupper($data[$header['RSVP']]);

          if(($data[$header['Called']] == "Y")||($data[$header['Texted']] == "Y")||($data[$header['Called']] == "YES")||($data[$header['Texted']] == "YES")){

            if($data[$header['Event']] != ""){ //get event info if there is a name in the event column
              $events = \dsa\Event::where('Name','=',$data[$header['Event']])->get();
              if(sizeof($events) > 0){
                $event_id = $events[0]->id;
              } else { //add if event doesn't exist
               $event = new \dsa\Event();
               $event->Name = $data[$header['Event']];
               $event->neighborhood_id = "1";
               $event->Date = date('Y/m/d');
               $event->save();
               $event_id = $event->id;
             }
           } else {
             $event_id = null; //no event indicated
           }

           #; create contact event
          $contactevent = new \dsa\Contactevent();
          $contactevent->volunteer_id = $volunteer_id;
          $contactevent->event_id = $event_id;
          $contactevent->Purpose = "Invitation";
          // if RSVPed
          if(($data[$header['RSVP']] == "Y") || ($data[$header['RSVP']] == "SENT") || ($data[$header['RSVP']] == "YES")){
            $contactevent->RSVP = true;
          } else {
            $contactevent->RSVP = false;
          }
          // if Called
          if(($data[$header['Called']]=="Y") || ($data[$header['Called']]=="YES")){
            $contactevent->Call = true;
          } else {
            $contactevent->Call = false;
          }
          // if PickedUp
          if(($data[$header['PickedUp']]=="Y")||(($data[$header['PickedUp']]=="YES"))){
            $contactevent->PickedUp = true;
          }else{
            $contactevent->PickedUp = false;
          }
          // if Texted
          if(($data[$header['Texted']]=="Y")||($data[$header['Texted']]=="YES")){
            $contactevent->Text = true;
          }else{
            $contactevent->Text = false;
          }
          //if left a voicemail
          if(($data[$header['VM']]=="Y")||($data[$header['VM']]=="YES")){
            $contactevent->VoiceMail = true;
          }else{
            $contactevent->VoiceMail = false;
          }

          $contactevent->Date = date('Y-m-d',strtotime($data[$header['Date']]));
          $contactevent->Comment = $data[$header['Comments']];
          $contactevent->Caller = $data[$header['Caller']];
          $contactevent->Completed = true;
          $contactevent->user_id = null;
          $contactevent->save();

        }



      }

      fclose($file);


        return view('contactevent.process')->with([
          'message' => "File Processed"
        ]);;



    }

    public function postCDProcess(Request $request){

      ini_set('auto_detect_line_endings',TRUE);
      $file = fopen(Config::get('app.filepath').$request->FileName,"r");

      ## Get the header line = FirstName(0),LastName(1),Zip(2),Phone(3),County(4),Email(5),Caller(6),Called(7),PickedUP(8)
      ## Texted(9),VM(10),RSVP(11),Event(12),Date(13),DoNotContact(14),BadPhone(15),Comments(16)
      $x = 0;
      while (($data = fgetcsv($file)) !== FALSE){
        if ($x == 0){
          $x = $x+1;
          continue;
        }

        #; Find Volunteer or add if does not exist
        if($data[3] != ""){ // check first by phone number
          $volunteers = \dsa\Volunteer::where('Phone','=',$data[3])->get();
        }

        if(sizeof($volunteers) == 0){

          $volunteer = new \dsa\Volunteer();
          $volunteer->FirstName = $data[0];
          $volunteer->LastName = $data[1];
          $volunteer->Phone = $data[3];
          $volunteer->Zip = $data[2];
          $volunteer->Email = $data[5];
          $volunteer->County = $data[4];
          $volunteer->neighborhood_id = "1";
          if($request->CDistrict != ""){
            $volunteer->CDistrict = $request->CDistrict;
          }
          $volunteer->user_id = "1";
          $volunteer->save();
          $volunteer_id = $volunteer->id;
        } else {
          $volunteer_id = $volunteers[0]->id;
          $volunteer = $volunteers[0];
        }
        if($data[14] == "1"){
          $volunteer->DoNotContact = true;
        }
        if($data[15] == "1"){
          $volunteer->BadPhone = true;
        }
        #; Check to see if volunteer was Called or texted -- add contact event if so
        $data[7] = strtoupper($data[7]);
        $data[8] = strtoupper($data[8]);
        $data[9] = strtoupper($data[9]);
        $data[10] = strtoupper($data[10]);
        $data[11] = strtoupper($data[11]);

        if(($data[7] == "Y")||($data[9] == "Y")||($data[7] == "YES")||($data[9] == "YES")){

          if($data[12] != ""){ //get event info if there is a name in the event column
            $events = \dsa\Event::where('Name','=',$data[12])->get();
            if(sizeof($events) > 0){
              $event_id = $events[0]->id;
            } else { //add if event doesn't exist
             $event = new \dsa\Event();
             $event->Name = $data[12];
             $event->neighborhood_id = "1";
             $event->Date = date('Y/m/d');
             $event->save();
             $event_id = $event->id;
           }
         } else {
           $event_id = null; //no event indicated
         }

         #; create contact event
        $contactevent = new \dsa\Contactevent();
        $contactevent->volunteer_id = $volunteer_id;
        $contactevent->event_id = $event_id;
        $contactevent->Purpose = "Invitation";
        // if RSVPed
        if(($data[11] == "Y") || ($data[11] == "SENT") || ($data[11] == "YES")){
          $contactevent->RSVP = true;
        } else {
          $contactevent->RSVP = false;
        }
        // if Called
        if(($data[7]=="Y") || ($data[7]=="YES")){
          $contactevent->Call = true;
        } else {
          $contactevent->Call = false;
        }
        // if PickedUp
        if(($data[8]=="Y")||(($data[8]=="YES"))){
          $contactevent->PickedUp = true;
        }else{
          $contactevent->PickedUp = false;
        }
        // if Texted
        if(($data[9]=="Y")||($data[9]=="YES")){
          $contactevent->Text = true;
        }else{
          $contactevent->Text = false;
        }
        //if left a voicemail
        if(($data[10]=="Y")||($data[10]=="YES")){
          $contactevent->VoiceMail = true;
        }else{
          $contactevent->VoiceMail = false;
        }

        $contactevent->Date = date('Y-m-d',strtotime($data[13]));
        $contactevent->Comment = $data[16];
        $contactevent->Caller = $data[6];
        $contactevent->Completed = true;
        $contactevent->user_id = null;
        $contactevent->save();

      }



    }

    fclose($file);


      return view('contactevent.process')->with([
        'message' => "File Processed"
      ]);;
    }

    public function postCityProcess(Request $request){

      ini_set('auto_detect_line_endings',TRUE);
      $file = fopen(Config::get('app.filepath').$request->FileName,"r");

      ## Get the header line = FirstName(0),LastName(1),Phone(2),Neighborhood(3),Borough(4),Caller(5),Called(6),
      ## VM(7),Texted(8),RSVP(9),Event(10),Date(11),DoNotContact(12),BadPhone(13),Comments(14)
      $x = 0;
      while (($data = fgetcsv($file)) !== FALSE){
        if ($x == 0){
          $x = $x+1;
          continue;
        }

        #; Find Volunteer or add if does not exist
        if($data[2] != ""){ // check first by phone number
          $volunteers = \dsa\Volunteer::where('Phone','=',$data[2])->get();
        }

        if(sizeof($volunteers) == 0){

          $volunteer = new \dsa\Volunteer();
          $volunteer->FirstName = $data[0];
          $volunteer->LastName = $data[1];
          $volunteer->Phone = $data[2];
          $volunteer->County = $data[4];
          $volunteer->neighborhood_id = $this->checkNeighborhood($data[3],$data[4]);
          if($request->CDistrict != ""){
            $volunteer->CDistrict = $request->CDistrict;
          }
          $volunteer->user_id = "1";
          $volunteer->save();
          $volunteer_id = $volunteer->id;
        } else {
          $volunteer_id = $volunteers[0]->id;
          $volunteer = $volunteers[0];
        }
        if($data[12] == "1"){
          $volunteer->DoNotContact = true;
        }
        if($data[13] == "1"){
          $volunteer->BadPhone = true;
        }
        #; Check to see if volunteer was Called or texted -- add contact event if so
        $data[6] = strtoupper($data[6]);
        $data[7] = strtoupper($data[7]);
        $data[8] = strtoupper($data[8]);
        $data[9] = strtoupper($data[9]);


        if(($data[6] == "Y")||($data[8] == "Y")||($data[6] == "YES")||($data[8] == "YES")){

          if($data[10] != ""){ //get event info if there is a name in the event column
            $events = \dsa\Event::where('Name','=',$data[10])->get();
            if(sizeof($events) > 0){
              $event_id = $events[0]->id;
            } else { //add if event doesn't exist
             $event = new \dsa\Event();
             $event->Name = $data[12];
             $event->neighborhood_id = "1";
             $event->Date = date('Y/m/d');
             $event->save();
             $event_id = $event->id;
           }
         } else {
           $event_id = null; //no event indicated
         }

         #; create contact event
        $contactevent = new \dsa\Contactevent();
        $contactevent->volunteer_id = $volunteer_id;
        $contactevent->event_id = $event_id;
        $contactevent->Purpose = "Invitation";
        // if RSVPed
        if(($data[9] == "Y") || ($data[9] == "SENT") || ($data[9] == "YES")){
          $contactevent->RSVP = true;
        } else {
          $contactevent->RSVP = false;
        }
        // if Called
        if(($data[6]=="Y") || ($data[6]=="YES")){
          $contactevent->Call = true;
        } else {
          $contactevent->Call = false;
        }

        // if Texted
        if(($data[8]=="Y")||($data[8]=="YES")){
          $contactevent->Text = true;
        }else{
          $contactevent->Text = false;
        }
        //if left a voicemail
        if(($data[7]=="Y")||($data[7]=="YES")){
          $contactevent->VoiceMail = true;
        }else{
          $contactevent->VoiceMail = false;
        }

        $contactevent->Date = date('Y-m-d',strtotime($data[11]));
        $contactevent->Comment = $data[14];
        $contactevent->Caller = $data[5];
        $contactevent->Completed = true;
        $contactevent->user_id = null;
        $contactevent->save();

      }



    }

    fclose($file);


      return view('contactevent.process')->with([
        'message' => "File Processed"
      ]);;
    }

    private function checkNeighborhood($name, $city){
      $neighborhoods = \dsa\Neighborhood::select('id')->where('Name','=',$name)->get();
      if (sizeof($neighborhoods) > 0){
        $neighborhood = $neighborhoods->first();
      } else {
        $neighborhood = new \dsa\Neighborhood();
        $neighborhood->Name = $name;
        $neighborhood->Borough = $city;
        $neighborhood->save();
      }
      return $neighborhood->id;
    }
}
