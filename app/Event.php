<?php

namespace dsa;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  public function neighborhood() {
    return $this->belongsTo('\dsa\Neighborhood');
  }

  public function volunteers()
  {
    # With timetsamps() will ensure the pivot table has its created_at/updated_at fields automatically maintained
    return $this->belongsToMany('\dsa\Volunteer', 'event_volunteers')->withTimestamps();
  }
  public function files() {
    #uploaded files of sign-in sheets
     return $this->hasMany('\dsa\File');
  }

  public function commitments() {
    #commitments volunteers made at event
     return $this->hasMany('\dsa\Commitment');
  }

}
