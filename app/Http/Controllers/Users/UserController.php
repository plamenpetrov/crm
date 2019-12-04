<?php

use Illuminate\Http\Request as Request;
use App\Http\Requests\Users\StoreUser as StoreUser;
use App\Http\Requests\Users\ChangeUser as ChangeUser;

/**
 * Description of UserController
 * 
 */
class UserController extends ApiController {

    public function __construct() {
        //TO DO: User facade inject in constructor
    }

    /**
     * URL : /users
     * Method : GET
     * 
     * Return list of paginated users
     * @return type
     */
    public function index(Request $request) {
        return $this->respond(\Users::getUsers($request));
    }

    /**
     * URL : /users
     * Method : GET
     * 
     * Return list of paginated users
     * @return type
     */
    public function show(Request $request) {
        return $this->respond(\Users::getUser($request));
    }

    /**
     * URL : /user/create
     * Method : GET
     * 
     * Return user form data
     * @param Request $request
     * @return type
     */
    public function create() {
        $formData = \Users::formData();
        $formValues = \Users::formValues();

        return $this->respondForm($formValues, $formData);
    }

    /**
     * URL : /user/edit
     * Method : GET
     * 
     * Get user data by id
     * @param type $id
     * @return type
     */
    public function edit($id) {
        $formData = \Users::formData();
        $formValues = \Users::edit($id);

        return $this->respondForm($formValues, $formData);
    }

    /**
     * URL : /user/store
     * Method : PATCH
     * 
     * Update user data
     * @return type
     */
    public function update($id, StoreUser $request) {
        return $this->respond(\Users::update($id, $request->all()), \Translate::translate('users=>create-update-success'));
    }

    /**
     * URL : /user/change/duration/{id}
     * Method : PATCH
     * 
     * Update user data
     * @return type
     */
    public function changeDuration($id, ChangeUser $request) {
        return $this->respond(\Users::changeDuration($id, $request->all()), \Translate::translate('users=>change-user-duration-success'));
    }

    /**
     * URL : /user/store
     * Method : POST
     * 
     * Store user data
     * @return type
     */
    public function store(StoreUser $request) {
        return $this->respond(\Users::store($request->all()), \Translate::translate('users=>create-user-success'));
    }

    /**
     * URL : /user/search
     * Method : GET
     * 
     * Search in all users by slug
     * @return type
     */
    public function search(Request $request) {
        return $this->respond(\Users::search($request));
    }

}
