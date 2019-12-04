<?php

namespace App\Models\Api;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable implements JWTSubject {

    use Notifiable;

    const active = 1;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles() {
        return $this->belongsToMany(\Role::class);
    }

    /**
     * Check if current user has given role
     * @param type $role
     * @return type
     */
    public function hasRole($role) {
        if (is_string($role))
            return $this->roles->contains('name', $role);

        return !!$role->intersect($this->roles)->count();
    }

    /**
     * Set user parmission to allowed
     * @param type $user
     * @return boolean
     */
    public function isAllowed($user) {
        return true;
    }

    /**
     * Set user parmission to denied
     * @param type $user
     * @return boolean
     */
    public function isDenied($user) {
        return false;
    }

    public function isAdmin() {
        //TO DO: implamentaion if needed
    }

    /**
     * Define Eloquent relation hasMany to Activity Model
     * @return type
     */
    public function activity() {
        return $this->hasMany('Activity')->with(['user', 'content'])->latest();
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     * @return type
     */
    public function scopeActive($query) {
        return $query->where('active', '=', self::active);
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        //$this refer to User in client DB
        return [
//            'langId' => $this->prefered_lang,
            'clientKey' => \Session::get('clientKey')
        ];
    }

}
