<?php

namespace dsa;

use Illuminate\Database\Eloquent\Model;

class Contactevent extends Model
{
  public function createdbyuser() {
    # Contactevent performed by a User
    return $this->belongsTo('\dsa\User');
  }

  public function volunteer() {
     return $this->belongsTo('\dsa\Volunteer');
  }

}
