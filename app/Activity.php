<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['comment', 'user_id', 'employee_id', 'method', 'route', 'ip_address', 'browser_name', 'platform_name', 'device_family', 'device_model'];

    /**
     * Get the User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the User
     */
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    /**
     * @param String $comment
     * @param User $user
     * @param Employee $employee
     * @param String $method
     * @param String $route
     * @param String $browser_name
     * @param String $platform_name
     * @param String $device_family
     * @param String $device_model
     */
    static function make($comment, $user, $employee, $method, $route, $browser_name, $platform_name, $device_family, $device_model) {
        $request = request();
        if(is_null($user) && !is_null($employee)) {
            $activity = new Activity();
            $activity->comment = $comment;
            $activity->user_id = null;
            $activity->employee()->associate($employee);
            $activity->method = $method;
            $activity->route = $route;
            $activity->ip_address = $request->ip();
            $activity->browser_name = $browser_name;
            $activity->platform_name = $platform_name;
            $activity->device_family = $device_family;
            $activity->device_model = $device_model;
            $activity->save();
        } elseif (is_null($user) && !is_null($employee)) {
            $activity = new Activity();
            $activity->comment = $comment;
            $activity->user()->associate($user);
            $activity->employee_id = null;
            $activity->method = $method;
            $activity->route = $route;
            $activity->ip_address = $request->ip();
            $activity->browser_name = $browser_name;
            $activity->platform_name = $platform_name;
            $activity->device_family = $device_family;
            $activity->device_model = $device_model;
            $activity->save();
        } else {
            $activity = new Activity();
            $activity->comment = $comment;
            $activity->user()->associate($user);
            $activity->employee()->associate($employee);
            $activity->method = $method;
            $activity->route = $route;
            $activity->ip_address = $request->ip();
            $activity->browser_name = $browser_name;
            $activity->platform_name = $platform_name;
            $activity->device_family = $device_family;
            $activity->device_model = $device_model;
            $activity->save();
        }
    }

}
