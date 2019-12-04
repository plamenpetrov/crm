<?php

use Illuminate\Http\Request as Request;
use App\Http\Requests\Contragents\StoreContragent as StoreContragent;
use App\Http\Requests\Contragents\StoreContragentRelation as StoreContragentRelation;
use App\Http\Requests\Contragents\StoreContragentPerson as StoreContragentPerson;
use App\Http\Resources\Contragents\ContragentResource;
use App\Http\Resources\Contragents\ContragentCollection;

/**
 * Description of ContragentsController
 * 
 */
class ContragentController extends ApiController {

    public function __construct() {
        //TO DO: Contragent facade inject in constructor
    }

    /**
     * URL : /contragents
     * Method : GET
     * 
     * Return list of paginated contragents
     * @return type
     */
    public function index(Request $request) {
        //TO DO: Need of reponse transformation
        return new ContragentCollection(\Contragents::getContragents($request));
    }

    /**
     * URL : /contragents
     * Method : GET
     * 
     * Return list of paginated contragents
     * @return type
     */
    public function show(Request $request) {
        return $this->respond(\Contragents::getContragent($request));
    }

    /**
     * URL : /contragent/create
     * Method : GET
     * 
     * Return company form data
     * @param Request $request
     * @return type
     */
    public function create() {
        $formData = \Contragents::formData();
        $contragent = \Contragents::formValues();

        return $this->respondForm(new ContragentResource($contragent), $formData);
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
        $formData = \Contragents::formData();
        $contragent = \Contragents::edit($id);

        return $this->respondForm(new ContragentResource($contragent), $formData);
    }

    /**
     * URL : /contragent/store
     * Method : PATCH
     * 
     * Update company data
     * @return type
     */
    public function update($id, StoreContragent $request) {
        return $this->respond(\Contragents::update($id, $request->all()), \Translate::translate('contragents=>create-update-success'));
    }

    /**
     * URL : /contragent/store
     * Method : POST
     * 
     * Store company data
     * @return type
     */
    public function store(StoreContragent $request) {
        return $this->respond(\Contragents::store($request->all()), \Translate::translate('contragents=>create-contragent-success'));
    }

    /**
     * URL : /contragent/history
     * Method : GET
     * 
     * Return all changes by given contragent
     * @return type
     */
    public function history(Request $request) {
        return $this->respond(\Contragents::getContragentHistory($request));
    }

    /**
     * URL : /contragent/search
     * Method : GET
     * 
     * Search in all contragents by slug
     * @return type
     */
    public function search(Request $request) {
        return $this->respond(\Contragents::search($request));
    }

    /**
     * URL : /contragent/relation/store
     * Method : POST
     * 
     * Create new releation between contragents
     * @return type
     */
    public function storeRelation(StoreContragentRelation $request) {
        return $this->respond(\Contragents::storeRelation($request), \Translate::translate('contragents=>create-contragent-reletion-success'));
    }
    
    /**
     * URL : /contragent/person/store
     * Method : POST
     * 
     * Create new releation between contragent and person
     * @return type
     */
    public function storePerson(StoreContragentPerson $request) {
        return $this->respond(\Contragents::storePerson($request), \Translate::translate('contragents=>create-contragent-person-reletion-success'));
    }
    
    /**
     * URL : /contragent/person/delete
     * Method : DELETE
     * 
     * Delete releation between contragent and person (soft delete)
     * @return type
     */
    public function deleteRelation(StoreContragentRelation $request) {
        return $this->respond(\Contragents::deleteRelation($request), \Translate::translate('contragents=>delete-contragent-reletion-success'));
    }
    
    /**
     * URL : /contragent/person/delete
     * Method : DELETE
     * 
     * Delete releation between contragent and person (soft delete)
     * @return type
     */
    public function deletePerson(StoreContragentPerson $request) {
        return $this->respond(\Contragents::deletePerson($request), \Translate::translate('contragents=>delete-contragent-person-reletion-success'));
    }
    
}
