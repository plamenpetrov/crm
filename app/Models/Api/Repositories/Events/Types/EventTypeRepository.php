<?php

namespace App\Models\Api\Repositories\Events\Types;

use \App\Models\Api\Repositories\BaseRepository;
use App\Models\Api\Repositories\Events\Types\EventTypeRepositoryInterface as EventTypeRepositoryInterface;
use EventType;
use DB;

class EventTypeRepository extends BaseRepository implements EventTypeRepositoryInterface {

    protected $model;
    
    public function __construct(EventType $eventType) {
        $this->model = $eventType;
        parent::__construct();
    }
    
    public function getEnentsTypes() {
        return DB::table('events_types as et')
                ->select('et.id', 'ett.name as name')
                ->join('events_types_translation as ett', 'et.id', '=', 'ett.events_types_id')
                ->where('ett.lang', $this->langId);
    }

}