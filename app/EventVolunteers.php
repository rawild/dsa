<?php

namespace dsa;

use Illuminate\Database\Eloquent\Model;

class EventVolunteers extends Model
{
  public function volunteer() {

     return $this->belongsTo('\dsa\Volunteer');
  }

  public function event() {

     return $this->belongsTo('\dsa\Event');
  }
  public function commitments() {
    return $this->hasMany('\dsa\Commitment');
  }

}
