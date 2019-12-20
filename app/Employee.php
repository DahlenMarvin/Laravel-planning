<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name', 'lastname'];

    /**
     * Get the User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the plannings
     */
    public function plannings()
    {
        return $this->hasMany('App\Planning');
    }

}
