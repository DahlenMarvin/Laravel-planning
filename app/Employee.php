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

}
