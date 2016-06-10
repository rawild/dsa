<?php

namespace dsa;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
  public function neighborhood() {
     # Volunteer belongs to neighborhood
     # Define an inverse one-to-many relationship.
     return $this->belongsTo('\dsa\Neighborhood');
  }
  public function createdbyuser() {
    # Volunteer created by a User
    # Define an inverse one-to-many relationship.
    return $this->belongsTo('\dsa\User');
  }

  public function tags()
  {
    # With timetsamps() will ensure the pivot table has its created_at/updated_at fields automatically maintained
    return $this->belongsToMany('\dsa\Tag')->withTimestamps();
  }

  public function events()
  {
    # With timetsamps() will ensure the pivot table has its created_at/updated_at fields automatically maintained
    return $this->belongsToMany('\dsa\Event', 'event_volunteers')->withTimestamps();

  }
  public function contactevents() {
     return $this->hasMany('\dsa\Contactevent');
  }

  public function commitments() {
     return $this->hasManyThrough('\dsa\Commitment', 'dsa\EventVolunteers');
  }
}
