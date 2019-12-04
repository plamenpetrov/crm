<?php

namespace App\Models\Api\Repositories\Users;

use \App\Models\Api\Repositories\BaseRepository;
use App\Models\Api\Repositories\Users\UsersRepositoryInterface as UsersRepositoryInterface;
use App\Models\Api\User;

class UsersRepository extends BaseRepository implements UsersRepositoryInterface {

    const active = 1;

    public $model;

    public function __construct(User $model) {
        $this->model = $model;
        parent::__construct();
    }

    /**
     * Getter. Return active state cons value
     * @return type
     */
    public function getActiveState() {
        return self::active;
    }
    
    /**
     * Get all active users
     * @return type
     */
    public function getUsers() {
        return $this->model->active();
    }

}
