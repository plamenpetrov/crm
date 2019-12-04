<?php

namespace App\Services\Acl;

use Illuminate\Support\Facades\Auth as Auth;
use Permission;
use App\Models\Api\User as User;

class Acl {

    const route = 1;
    const add = 2;
    const edit = 3;
    const delete = 4;
    const copy = 5;
    const merge = 6;
    const change = 7;
    const module = 8;
    
    public function loadAcl() {
//        $user = \Auth::user();
        
        //ROLES PERMISSIONS
        foreach ($this->getPermissions() as $resource) {
            \Gate::define($resource->name, function($user) use ($resource) {
                return $user->hasRole($resource->roles);
            });
        }

        //ALLOWED PERMISSSIONS
        foreach ($this->getAllowedUserPermissions() as $allowedPermission) {
            if($allowedPermission->allowed->count()) {
                \Gate::define($allowedPermission->name, function($user) use ($allowedPermission) {
                    return $user->isAllowed($allowedPermission->allowed);
                });
            }
        }

        //DENIED PERMISSIONS
        foreach ($this->getDeniedUserPermissions() as $deniedPermission) {
            if(!empty($deniedPermission->denied->count())) {
                \Gate::define($deniedPermission->name, function($user) use ($deniedPermission) {
                    return $user->isDenied($deniedPermission->denied);
                });
            }
        }
        
        return true;
    }
    
    protected function getPermissions() {
        return Permission::with('roles')
                        ->get();
    }

    protected function getAllowedUserPermissions() {
        return Permission::with('allowed')
                        ->get();
    }

    protected function getDeniedUserPermissions() {
        return Permission::with('denied')
                        ->get();
    }
    
    public function chekcAccessAndTranslate($array) {
//        $acl = \Session::get('acl');
        $user = \Auth::user();
        
        foreach ($array as $key => $value) {
            //if user has not permissions and has resource (resource may be empty and not protected)
            if (!$user->can($value['resource']) && $value['resource']) {
                unset($array[$key]);
            } else {
                $array[$key]['label'] = \Translate::translate($value['label']);
            }
        }

        return $array;
    }
}
