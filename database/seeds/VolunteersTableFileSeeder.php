<?php

use Illuminate\Database\Seeder;
use DB;

class VolunteersTableFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $file = fopen("/uploads/20160113.csv","r");
       $line = fgets($file);
       ## Get the header line = Event(0),Date(1),FirstName(2),LastName(3),Gender(4),Phone(5),Zip(6),Neighborhood(7),Email(8),Street(9),City(10),State(11),HostEvent(12),AttendEvent(13),Comment(14)
       while (($line = fgets($handle)) !== false) {
         $data= explode(",",$line);
         if($data[0] != ""){
           //check for event
           $events = \teambernieny\Event::where('Name','=',$data[0])->get();
           if(sizeof($events) > 0){
             $event = $events[0];
           } else{ //add if doesn't exist
             $event = new \teambernieny\Event();
             $event->Name = $data[0];
             $event->neighborhood_id = "1";
             $event->Date = "2016-01-13";
             $event->save();
           }

         }else{ // add to migration if no event indicated
           $event = \teambernieny\Event::find('1');
         }
         if($data[8] != ""){ // if there is an email
           $volunteers = \teambernieny\Volunteer::where('Email','=',$data[8])->get();
         }elseif($data[5] != ""){
           $volunteers = \teambernieny\Volunteer::where('Phone','=',$data[5])->get();
         } else {
           continue;
         }
         if(sizeof($volunteers) == 0){

           $volunteer = new \teambernieny\Volunteer();
           $neighborhoods = \teambernieny\Neighborhood::select('id')->where('Name','=',$data[7])->get();
           if (sizeof($neighborhoods) > 0){
             $neighborhood = $neighborhoods->first();

           } else {
             $neighborhood = new \teambernieny\Neighborhood();
             $neighborhood->Name = $data[7];
             $neighborhood->Borough = $data[10];
             $neighborhood->save();

           }
           $volunteer->FirstName = $data[2];
           $volunteer->LastName = $data[3];
           $volunteer->Phone = $data[5];
           $volunteer->Zip = $data[6];
           $volunteer->neighborhood_id = $neighborhood->id;
           $volunteer->Email = $data[8];
           $volunteer->Street = $data[9];
           $volunteer->City = $data[10];
           $volunteer->State = $data[11];
         } else {
           $volunteer = $volunteers[0];
         }

         //Add attendance
         $attendance = new \teambernieny\EventVolunteers();
         $attendance->event_id = $event->id;
         $attendance->volunteer_id = $volunteer->id;
         $attendance->Relationship = "Attendee";
         $attendance->save();

         if($data[12] == "1"){
           $newcommitment = new \teambernieny\Commitment();
           $newcommitment->event_volunteers_id = $attendance->id;
           $newcommitment->Type = "Host";
           $newcommitment->save();
         }
         if($data[13] == "1"){
           $newcommitment = new \teambernieny\Commitment();
           $newcommitment->event_volunteers_id = $attendance->id;
           $newcommitment->Type = "Attend";
           $newcommitment->save();
         }


     }

     fclose($file);

  }
}
