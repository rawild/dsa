<?php

use Illuminate\Database\Seeder;
/*use Illuminate\Database\Eloquent\Model;*/

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      ini_set('auto_detect_line_endings',TRUE);
      $file = fopen("","r");

      ## Get the header line = Event(0),Date(1),FirstName(2),LastName(3),Gender(4),Phone(5),Zip(6),Neighborhood(7),Email(8),Street(9),City(10),State(11),HostEvent(12),AttendEvent(13),Comment(14)
      $x = 0;
      while (($data = fgetcsv($file)) !== FALSE){
        if ($x == 0){
          $x = $x+1;
          continue;
        }

        echo("inwhile");
        if($data[0] != ""){

          //check for event
          $events = DB::table('events')->where('Name','=',$data[0])->get();
          if(sizeof($events) > 0){
            $event_id = $events[0]->id;
          } else{ //add if doesn't exist
           DB::table('events')->insert([
              'Name' => $data[0],
              'neighborhood_id' => "1",
              'Date' => "2016-01-13"
            ]);
            $event_id = DB::table('events')->max('id');
        }

        }else{ // add to migration if no event indicated
          $event_id = DB::table('events')->min('id');
        }
        if($data[8] != ""){ // if there is an email
          $volunteers = DB::table('volunteers')->where('Email','=',$data[8])->get();
        }elseif($data[5] != ""){
          $volunteers = DB::table('volunteers')->where('Phone','=',$data[5])->get();
        } else {
          continue;
        }
        if(sizeof($volunteers) == 0){

          $neighborhoods = DB::table('neighborhoods')->select('id')->where('Name','=',$data[7])->get();
          if (sizeof($neighborhoods) > 0){
            $neighborhood_id = $neighborhoods[0]->id;

          } else {
          DB::table('neighborhoods')->insert([
              'Name' => $data[7],
              'Borough' => $data[10]
            ]);
            $neighborhood_id = DB::table('neighborhoods')->max('id');


          }
          DB::table('volunteers')->insert([

            'FirstName' => $data[2],
            'LastName' => $data[3],
            'Phone' => $data[5],
            'Zip' => $data[6],
            'neighborhood_id' => $neighborhood_id,
            'Email' => $data[8],
            'Street' => $data[9],
            'City' => $data[10],
            'State' => $data[11],
            'user_id' => "1"
            ]);
            $volunteer_id = DB::table('volunteers')->max('id');
        } else {
          $volunteer_id = $volunteers[0]->id;
        }

        //Add attendance
      DB::table('event_volunteers')->insert([
          'event_id' => $event_id,
          'volunteer_id' => $volunteer_id,
          'Relationship' => "Attendee"
        ]);
        $attendance_id = DB::table('volunteers')->max('id');

        if($data[12] == "1"){
          DB::table('commitments')->insert([
            'event_volunteers_id' => $attendance_id,
            'Type' => "Host"
          ]);
        }
        if($data[13] == "1"){
          DB::table('commitments')->insert([
            'event_volunteers_id' => $attendance_id,
            'Type' => "Attend"
          ]);
        }


    }

    fclose($file);


    }
}
