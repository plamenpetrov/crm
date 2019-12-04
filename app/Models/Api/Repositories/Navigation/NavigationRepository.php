<?php

namespace App\Models\Api\Repositories\Navigation;

use \App\Models\Api\Repositories\BaseRepository;
use App\Models\Api\Repositories\Navigation\NavigationRepositoryInterface as NavigationRepositoryInterface;
use Navigation;

class NavigationRepository extends BaseRepository implements NavigationRepositoryInterface {

    public $model;

    public function __construct(Navigation $model) {
        $this->model = $model;
        parent::__construct();
    }

    /**
     * Return all navigation elements filtered by ACL
     * @param type $type
     * @return array
     */
    public function getNavigations($type = null) {
        if ($type)
            $navigation = $this->model
                ->where('navigation_type_id', '=', $type)
                ->orderBy('position', 'asc')
                ->get()
                ->toArray();
        else
            $navigation = $this->model
                ->orderBy('position', 'asc')
                ->get()
                ->toArray();

        if ($navigation)
            $navigation = \Acl::chekcAccessAndTranslate($navigation);

        return $navigation;
    }

}
