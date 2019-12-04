<?php

namespace App\Models\Api\Repositories\Activities;

use \App\Models\Api\Repositories\BaseRepository;
use App\Models\Api\Repositories\Activities\ActivitiesRepositoryInterface as ActivitiesRepositoryInterface;

class ActivitiesRepository extends BaseRepository implements ActivitiesRepositoryInterface {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get latest user activities include create, update or delete event, contragent, person
     * @return type
     */
    public function getActivity() {
        $user = \Auth::user();

        return $user->activity()->paginate();
    }

}
