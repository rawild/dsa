<?php

use Illuminate\Database\Seeder;

class VolunteersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     function validate($volunteer){
       if ($volunteer->FirstName == "999"){
         $volunteer->FirstName = "";
       }
       if ($volunteer->LastName == "999"){
         $volunteer->LastName = "";
       }
       if ($volunteer->Phone1 == "999"){
         $volunteer->Phone1 = "";
         $volunteer->Phone1Broken = "1";
       }
       if ($volunteer->Phone1Broken == "999"){
         $volunteer->Phone1Broken = "0";
       }
       if ($volunteer->Neighborhood == "999"){
         $volunteer->Neighborhood = "";
       }
       if ($volunteer->Street == "999"){
         $volunteer->Street = "";
       }
       if ($volunteer->City == "999"){
         $volunteer->City = "";
       }
       if ($volunteer->Zip == "999"){
         $volunteer->Zip = "";
       }
       if ($volunteer->State == "999"){
         $volunteer->State = "";
       }
       if ($volunteer->EMail1 == "999"){
         $volunteer->EMail1 = "";
         $volunteer->Email1Broken = "1";
       }
       if ($volunteer->Email1Broken == "999"){
         $volunteer->Email1Broken = "0";
       }
       if ($volunteer->HostEvent == "999"){
         $volunteer->HostEvent = "0";
       }
       if ($volunteer->AttendEvent == "999"){
         $volunteer->AttendEvent = "0";
       }

       return $volunteer;

     }

    public function run()
    {
        $volunteers = \teambernieny\VDBVolunteer::all();
        //Top ten data conversion for now
        for ($x = 0; $x < sizeof($volunteers); $x++) {
          $volunteer = $volunteers[$x];

          //clean out the 999s
          $volunteer = $this->validate($volunteer);


          //add neighborhood if doesn't exist
          $neighborhoods = \teambernieny\Neighborhood::where('Name','=',$volunteer->Neighborhood)->get();

          if ((sizeof($neighborhoods) == 0) && ($volunteer->Neighborhood != "")) {
            DB::table('neighborhoods')->insert([
              'created_at' => Carbon\Carbon::now()->toDateTimeString(),
              'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
              'Name' => $volunteer->Neighborhood,
              'Borough' => $volunteer->City
            ]);
            $neighborhood_id = \teambernieny\Neighborhood::max('id');
          } else if ($volunteer->Neighborhood ==  "") {
            $neighborhood_id = "1";
          } else {
            $neighborhood_id = $neighborhoods[0]->id;
          }
          // add volunteer
          DB::table('volunteers')->insert([
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
            'FirstName' => $volunteer->FirstName,
            'LastName' => $volunteer->LastName,
            'Email' => $volunteer->EMail1,
            'Phone' => $volunteer->Phone1,
            'neighborhood_id' => $neighborhood_id,
            'Zip' => $volunteer->Zip,
            'Street' => $volunteer->Street,
            'City' => $volunteer->City,
            'State' => $volunteer->State,
            'user_id' => "1",
            'BadPhone' => $volunteer->Phone1Broken,
            'BadEmail' => $volunteer->Email1Broken,
            'DoNotContact' => $volunteer->DoNotContact
          ]);
          $volunteerid = \teambernieny\Volunteer::max('id');
          DB::table('event_volunteers')->insert([
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
            'event_id' => '1',
            'volunteer_id' => $volunteerid,
            'Relationship' => 'Attendee'
          ]);
          $eventvolunteers_id = \teambernieny\EventVolunteers::max('id');
          if($volunteer->AttendEvent == "1") {
            DB::table('commitments')->insert([
              'created_at' => Carbon\Carbon::now()->toDateTimeString(),
              'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
              'event_volunteers_id' => $eventvolunteers_id,
              'Type' => "Attend"
            ]);
          }
          if($volunteer->HostEvent == "1"){
            DB::table('commitments')->insert([
              'created_at' => Carbon\Carbon::now()->toDateTimeString(),
              'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
              'event_volunteers_id' => $eventvolunteers_id,
              'Type' => "Host"
            ]);
          }
        }
    }


}
