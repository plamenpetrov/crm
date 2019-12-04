<?php

use Illuminate\Http\Request as Request;
use App\Http\Requests\Events\StoreEvent as StoreEvent;
use App\Http\Requests\Events\ChangeEvent as ChangeEvent;
use App\Http\Resources\Events\EventResource;
use App\Http\Resources\Events\EventCollection;

/**
 * Description of EventController
 * 
 */
class EventController extends ApiController {

    public function __construct() {
        //TO DO: Event facade inject in constructor
    }

    /**
     * URL : /events
     * Method : GET
     * 
     * Return list of paginated events
     * @return type
     */
    public function index(Request $request) {
        $events = \MyEvents::getEvents($request);
        
        return $this->respond(EventResource::collection($events));
    }

    /**
     * URL : /events
     * Method : GET
     * 
     * Return list of paginated events
     * @return type
     */
    public function show(Request $request) {
        $event = \MyEvents::getEvent($request);
        
        event(new \App\Events\EventCreated($event));
        
        return $this->respond(new EventResource($event['event']));
    }

    /**
     * URL : /event/create
     * Method : GET
     * 
     * Return event form data
     * @param Request $request
     * @return type
     */
    public function create() {
        $formData = \MyEvents::formData();
        $event = \MyEvents::formValues();

        return $this->respondForm(new EventResource($event), $formData);
    }

    /**
     * URL : /event/edit
     * Method : GET
     * 
     * Get event data by id
     * @param type $id
     * @return type
     */
    public function edit($id, Request $request) {
        $formData = \MyEvents::formData();
        $event = \MyEvents::edit($id);

        return $this->respondForm(new EventResource($event), $formData);
    }

    /**
     * URL : /event/store
     * Method : PATCH
     * 
     * Update event data
     * @return type
     */
    public function update($id, StoreEvent $request) {
        return $this->respond(\MyEvents::update($id, $request->all()), \Translate::translate('events=>create-update-success'));
    }
    
    /**
     * URL : /event/change/duration/{id}
     * Method : PATCH
     * 
     * Update event data
     * @return type
     */
    public function changeDuration($id, ChangeEvent $request) {
        return $this->respond(\MyEvents::changeDuration($id, $request->all()), \Translate::translate('events=>change-event-duration-success'));
    }

    /**
     * URL : /event/store
     * Method : POST
     * 
     * Store event data
     * @return type
     */
    public function store(StoreEvent $request) {
        return $this->respond(\MyEvents::store($request->all()), \Translate::translate('events=>create-event-success'));
    }

    /**
     * URL : /event/search
     * Method : GET
     * 
     * Search in all events by slug
     * @return type
     */
    public function search(Request $request) {
        return $this->respond(\MyEvents::search($request));
    }

}
