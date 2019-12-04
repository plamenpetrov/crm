<?php

class Role extends Eloquent
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'roles';

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }
//    
//    public function givePermissionTo(Permission $permission) {
//        return $this->permissions()->save($permission);
//    }
}
