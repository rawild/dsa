<?php

namespace dsa;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
  public function createdbyuser() {
    # Contactevent performed by a User
    return $this->belongsTo('\dsa\User');
  }


}
