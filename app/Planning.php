<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'date'
    ];

    /**
     * Get the Employee
     */
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
