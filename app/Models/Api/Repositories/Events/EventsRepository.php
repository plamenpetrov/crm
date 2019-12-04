<?php

namespace App\Models\Api\Repositories\Events;

use \App\Models\Api\Repositories\BaseRepository;
use App\Models\Api\Repositories\Events\EventsRepositoryInterface as EventsRepositoryInterface;
use App\Events\Model\UpdatingEvent as UpdatingEvent;
use App\Events\Model\CreatingEvent as CreatingEvent;
use Events;

class EventsRepository extends BaseRepository implements EventsRepositoryInterface {

    protected $id;
    protected $model;

    public function __construct(Events $event) {
        parent::__construct();
        $this->model = $event;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCols() {
        return $this->columns;
    }

    /**
     * Return base query to get list of events
     * @return type
     */
    public function getEvents($request) {
        return (new Events)->newQuery();
    }

    public function createEvent() {

        $e = new \Events;

        $relations = ['type.translatable', 'subtype.translatable', 'executor', 'executor.user'];
//
        return $e->load($relations);
    }

    public function getEvent($id) {
//        $langId = $this->langId;

        return \Events::find($id);
    }

    /**
     * Update contragent data, create event in activity and add hitory row
     * @param type $data
     * @return type
     */
    public function update($data) {
        $event = \Events::find($this->id);

        $this->setBaseColumns($event, $data);

        $event->updated_by = \Auth::user()->id;
        event(new UpdatingEvent($event));

        $event->save();

        return $event;
    }

    /**
     * Set base table columns
     * @param type $event
     * @param type $data
     * @return type
     */
    protected function setBaseColumns($event, $data) {
        $event->events_types_id = $data['eventtype'];
        $event->events_subtypes_id = $data['eventsubtype'];
        $event->name = $data['eventname'];

        if (isset($data['eventdescription']) && $data['eventdescription'])
            $event->description = $data['eventdescription'];

        if (isset($data['eventlocation']) && $data['eventlocation'])
            $event->location = $data['eventlocation'];
        $event->start_date = $data['eventstartdate'];
        $event->end_date = $data['eventenddate'];

        return $event;
    }

    /**
     * Create new contragent in DB
     * @param type $data
     * @return type
     */
    public function store($data) {
        //create new company
        $event = new \Events();

        $this->setBaseColumns($event, $data);
        $event->user_id = \Auth::user()->id;

        $event->save();

        event(new CreatingEvent($event));

        return $event;
    }

    public function search($slug) {
        return \Events::search($slug)->paginate();
    }

//    protected function executors($data) {
//        return array_pluck($data['eventexecutors'], 'id');
//    }

    public function changeDuration($data) {
        $event = \Events::find($this->id);

        $event->start_date = $data['start_date'];
        $event->end_date = $data['end_date'];

        $event->updated_by = \Auth::user()->id;
        event(new UpdatingEvent($event));

        $event->save();

        return $event;
    }

    public function addExecutors(array $executors, $event) {
        //first delete all executors 
        $event->deleteExecutor();
        
        foreach ($executors as $executor_id) {
            $event->addExecutor($executor_id);
        }

        return true;
    }

    public function sendEmailCreateEvent($event) {

        foreach ($event->executor as $executor) {
            if ($executor->id !== \Auth::user()->id) {
                $userName = $executor->user->name;
                $userEmail = $executor->user->email;

                \Mail::to($userEmail)
                        ->send(new \App\Mail\Events\EventCreated([
                            'id' => $event->id,
                            'name' => $event->name,
                            'description' => $event->description,
                            'location' => $event->location,
                            'startdate' => $event->start_date,
                            'enddate' => $event->end_date,
                            'userName' => $userName
                ]));
            }
        }

        return true;
    }
    
    public function sendEmailUpdateEvent($event) {

        foreach ($event->executor as $executor) {
            if ($executor->id !== \Auth::user()->id) {
                $userName = $executor->user->name;
                $userEmail = $executor->user->email;

                \Mail::to($userEmail)
                        ->send(new \App\Mail\Events\EventUpdated([
                            'id' => $event->id,
                            'name' => $event->name,
                            'description' => $event->description,
                            'location' => $event->location,
                            'startdate' => $event->start_date,
                            'enddate' => $event->end_date,
                            'userName' => $userName
                ]));
            }
        }

        return true;
    }
    
    public function sendEmailChangeEvent($event) {
        foreach ($event->executor as $executor) {
            
            if ($executor->id !== \Auth::user()->id) {
                $userName = $executor->user->name;
                $userEmail = $executor->user->email;
                
                \Mail::to($userEmail)
                        ->send(new \App\Mail\Events\EventChange([
                            'id' => $event->id,
                            'name' => $event->name,
                            'description' => $event->description,
                            'location' => $event->location,
                            'startdate' => $event->start_date,
                            'enddate' => $event->end_date,
                            'userName' => $userName
                ]));
            }
        }

        return true;
    }

}
