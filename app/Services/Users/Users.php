<?php

namespace App\Services\Users;

use App\Models\Api\Repositories\Users\UsersRepositoryInterface as UsersRepositoryInterface;
use App\Models\Api\Repositories\Language\LanguageRepositoryInterface;
use App\Models\Api\Filters\Users\SearchUser as SearchUser;
use \DB;

class Users implements UsersInterface {

    protected $userRepo;
    protected $language;

    public function __construct(UsersRepositoryInterface $userRepo, LanguageRepositoryInterface $language) {
        $this->userRepo = $userRepo;
        $this->language = $language;
    }

    /**
     * Get users, apply filers and paginate result
     * @param type $request
     * @return type
     */
    public function getUsers($request) {

        //get base query for users
        $query = $this->userRepo->getUsers($request);

        //apply filters
        $filteredQuery = SearchUser::apply($request, $query);

        return $filteredQuery->get();
    }

    /**
     * Get all data for given user ID
     * @param type $request
     * @return type
     */
    public function getUser($request) {
//        $user = \Users::find($request->id);

        return [
            'user' => $this->userRepo->getUser($request->id),
        ];
    }

    public function formData() {
        return [
            'users' => $this->userRepo->active()->get()
        ];
    }

    public function formValues() {
        return $this->userRepo->createUser();
    }

    /**
     * Get user data by id
     * @param type $id
     * @return type
     */
    public function edit($id) {
        return $this->userRepo->getUser($id);
    }

    /**
     * Update user data
     * @return type
     */
    public function update($id, $data) {
        try {
            DB::beginTransaction();
            $this->userRepo->setId($id);
            $this->userRepo->update($data);
            DB::commit();
            return $id;
        } catch (Exception $ex) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Change user duration
     * @return type
     */
    public function changeDuration($id, $data) {
        try {
            DB::beginTransaction();
            $this->userRepo->setId($id);
            $this->userRepo->changeDuration($data);
            DB::commit();
            return $id;
        } catch (Exception $ex) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Store user data
     * @return type
     */
    public function store($data) {
        try {
            DB::beginTransaction();
//            $activeLanguages = $this->language->getActiveLanguages();
            $id = $this->userRepo->store($data);
            DB::commit();
            return $id;
        } catch (Exception $ex) {
            DB::rollBack();
            return false;
        }
    }

    public function search($request) {
        return $this->userRepo->search($request->user);
    }

}
