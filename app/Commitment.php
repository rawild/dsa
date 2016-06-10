<?php

namespace dsa;

use Illuminate\Database\Eloquent\Model;

class Commitment extends Model
{
  public function eventvolunteer() {
    # Volunteer who made commitment
    return $this->belongsTo('\dsa\EventVolunteer');
  }



}
