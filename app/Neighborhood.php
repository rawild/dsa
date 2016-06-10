<?php

namespace dsa;

use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
  public function volunteers() {
     # Neighborhood has many Volunteers
     # Define a one-to-many relationship.
     return $this->hasMany('\dsa\Volunteer');
  }
  public function events() {
     return $this->hasMany('\dsa\Event');
  }
}
