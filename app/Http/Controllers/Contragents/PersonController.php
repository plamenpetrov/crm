<?php

use Illuminate\Http\Request as Request;
use App\Http\Requests\StorePerson as StorePerson;

/**
 * Description of PersonsController
 * 
 */
class PersonController extends ApiController {

    public function __construct() {
        
    }

    /**
     * URL : /persons
     * Method : GET
     * 
     * Return list of paginated persons
     * @return type
     */
    public function index(Request $request) {
        return $this->respond(\Persons::getPersons($request));
    }

    /**
     * URL : /persons/{id}
     * Method : GET
     * 
     * Return list of paginated persons
     * @return type
     */
    public function show(Request $request) {
        return $this->respond(\Persons::getPerson($request));
    }

    /**
     * URL : /persons/create
     * Method : GET
     * 
     * Return person form data
     * @param Request $request
     * @return type
     */
    public function create() {
        $formData = \Persons::formData();
        $formValues = \Persons::formValues();

        return $this->respondForm($formValues, $formData);
    }

    /**
     * URL : /contragent/edit
     * Method : GET
     * 
     * Get company data by id
     * @param type $id
     * @return type
     */
    public function edit($id) {
        $formData = \Persons::formData();
        $formValues = \Persons::edit($id);

        return $this->respondForm($formValues, $formData);
    }

    /**
     * URL : /persons/store
     * Method : PATCH
     * 
     * Update person data
     * @return type
     */
    public function update($id, StorePerson $request) {
        return $this->respond(\Persons::update($id, $request->all()));
    }

    /**
     * URL : /persons/store
     * Method : POST
     * 
     * Store person data
     * @return type
     */
    public function store(StorePerson $request) {
        return $this->respond(\Persons::store($request->all()));
    }

    /**
     * URL : /contragent/history
     * Method : GET
     * 
     * Return all changes by given contragent
     * @return type
     */
    public function history(Request $request) {
        return $this->respond(\Persons::getPersonHistory($request));
    }
    
     /**
     * URL : /persons/search
     * Method : GET
     * 
     * Search in all persons by slug
     * @return type
     */
    public function search(Request $request) {
        return $this->respond(\Persons::search($request));
    }
}
