<?php

use App\Models\Api\User as User;

class Permission extends Eloquent
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'permissions';

    public function roles() {
        return $this->belongsToMany(Role::class);
    }
    
    public function allowed() {
        return $this->belongsToMany(User::class)
                ->where('allowed', 1);
    }
    
    public function denied() {
        return $this->belongsToMany(User::class)
                ->where('allowed', 0);
    }
}
