<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    protected $fillable = ['user_id', 'employee_id', 'user_hasSigned', 'employee_hasSigned', 'nSemaine', 'etat'];

    /**
     * Get the User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the Employee
     */
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

}
