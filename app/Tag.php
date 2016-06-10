<?php

namespace dsa;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  public function volunteers()
  {
    # With timetsamps() will ensure the pivot table has its created_at/updated_at fields automatically maintained
    return $this->belongsToMany('\dsa\Volunteer')->withTimestamps();
  }
}
