<?php

namespace App\Services\Events;

use App\Models\Api\Repositories\Events\EventsRepositoryInterface as EventsRepositoryInterface;
use App\Models\Api\Repositories\Events\Types\EventTypeRepositoryInterface as EventTypeRepositoryInterface;
use \App\Models\Api\Repositories\Events\SubTypes\EventSubTypeRepositoryInterface as EventSubTypeRepositoryInterface;
use App\Models\Api\Repositories\Users\UsersRepositoryInterface as UsersRepositoryInterface;
use App\Models\Api\Repositories\Language\LanguageRepositoryInterface;
use App\Models\Api\Filters\Events\SearchEvent as SearchEvent;
use \DB;

class Events implements EventsInterface {

    protected $eventRepo;
    protected $eventTypeRepo;
    protected $eventSubTypeRepo;
    protected $userRepo;
    protected $language;

    public function __construct(EventsRepositoryInterface $eventRepo, EventTypeRepositoryInterface $eventTypeRepo, EventSubTypeRepositoryInterface $eventSubTypeRepo, UsersRepositoryInterface $userRepo, LanguageRepositoryInterface $language) {
        $this->eventRepo = $eventRepo;
        $this->eventTypeRepo = $eventTypeRepo;
        $this->eventSubTypeRepo = $eventSubTypeRepo;
        $this->userRepo = $userRepo;
        $this->language = $language;
    }

    /**
     * Get events, apply filers and paginate result
     * @param type $request
     * @return type
     */
    public function getEvents($request) {

        //get base query for events
        $query = $this->eventRepo->getEvents($request);

        //apply filters
        $filteredQuery = SearchEvent::apply($request, $query);

//        if ($request->has('exportType'))
            return $filteredQuery->get();
//
//        return $filteredQuery->get();
        //paginate result
//        return $filteredQuery->paginate($request->input('per_page', \Config::get('pagination.pagination')));
    }

    /**
     * Get all data for given event ID
     * @param type $request
     * @return type
     */
    public function getEvent($request) {
//        $event = \Events::find($request->id);

        return [
            'event' => $this->eventRepo->getEvent($request->id),
        ];
    }

    public function formData() {
        return [
//            'settlements' => $this->settlementsRepo->getSettlements($this->settlementsRepo->getCityConstant())->get(),
//            'countries' => $this->countriesRepo->getCountries()->get(),
            'eventsubtype' => $this->eventSubTypeRepo->getEnentsSubTypes()->get(),
            'eventtype' => $this->eventTypeRepo->getEnentsTypes()->get(),
            'users' => $this->userRepo->getUsers()->get()
        ];
    }

    public function formValues() {
        return $this->eventRepo->createEvent();

//        //TO DO: Da izmislq default values!!!
//        return array_fill_keys(array_keys($this->eventRepo->getCols()), null);
    }

    /**
     * Get event data by id
     * @param type $id
     * @return type
     */
    public function edit($id) {
        return $this->eventRepo->getEvent($id);
    }

    /**
     * Update event data
     * @return type
     */
    public function update($id, $data) {
        try {
            DB::beginTransaction();
            $this->eventRepo->setId($id);
            //update event
            $event = $this->eventRepo->update($data);
            
            //change executors
            $this->eventRepo->addExecutors($data['eventexecutors'], $event);
            
            //send email notifications
            $this->eventRepo->sendEmailUpdateEvent($event);
            DB::commit();
            return $id;
        } catch (Exception $ex) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Change event duration
     * @return type
     */
    public function changeDuration($id, $data) {
        try {
            DB::beginTransaction();
            $this->eventRepo->setId($id);
            
            //change event duration
            $this->eventRepo->changeDuration($data);
            
            $event = \Events::find($id);
            //send email notifications
            $this->eventRepo->sendEmailChangeEvent($event);
            DB::commit();
            return $id;
        } catch (Exception $ex) {
            DB::rollBack();
            return false;
        }
    }
    
    
    /**
     * Store event data
     * @return type
     */
    public function store($data) {
        try {
            DB::beginTransaction();
            //create new event
            $event = $this->eventRepo->store($data);
            
            //add executors
            $this->eventRepo->addExecutors($data['eventexecutors'], $event);
            
            //send email notifications
            $this->eventRepo->sendEmailCreateEvent($event);
            DB::commit();
            return $event->id;
        } catch (Exception $ex) {
            DB::rollBack();
            return false;
        }
    }

    public function search($request) {
        return $this->eventRepo->search($request->event);
    }

}
