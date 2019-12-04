<?php

namespace App\Models\Api\Repositories\Events\SubTypes;

use \App\Models\Api\Repositories\BaseRepository;
use App\Models\Api\Repositories\Events\SubTypes\EventSubTypeRepositoryInterface as EventSubTypeRepositoryInterface;
use EventSubType;
use DB;

class EventSubTypeRepository extends BaseRepository implements EventSubTypeRepositoryInterface {

    protected $model;
    
    public function __construct(EventSubType $eventType) {
        $this->model = $eventType;
        parent::__construct();
    }

    public function getEnentsSubTypes() {
        return DB::table('events_subtypes as et')
                ->select('et.id', 'ett.name as name', 'et.events_types_id as eventtypeid')
                ->join('events_subtypes_translation as ett', 'et.id', '=', 'ett.events_subtypes_id')
                ->where('ett.lang', $this->langId);
    }
    
}
