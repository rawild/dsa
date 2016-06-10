<?php

namespace dsa;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function volunteers() {
       return $this->hasMany('\dsa\Volunteer');
    }

    public function files() {
       return $this->hasMany('\dsa\File');
    }

    public function searches() {
       return $this->hasMany('\dsa\Search');
    }
}
