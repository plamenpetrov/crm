<?php

namespace App\Services\Contragents;

use App\Models\Api\Repositories\Persons\PersonsRepositoryInterface as PersonsRepositoryInterface;
use App\Models\Api\Repositories\Language\LanguageRepositoryInterface;
use App\Models\Api\Repositories\Settlements\SettlementsRepositoryInterface as SettlementsRepositoryInterface;
use App\Models\Api\Filters\Persons\SearchPerson as SearchPerson;
use \DB;

class Persons implements PersonsInterface {

    protected $personRepo;
    protected $settlementsRepo;
    protected $language;

    public function __construct(PersonsRepositoryInterface $personRepo, LanguageRepositoryInterface $language, SettlementsRepositoryInterface $settlementsRepo) {
        $this->personRepo = $personRepo;
        $this->language = $language;
        $this->settlementsRepo = $settlementsRepo;
    }

    /**
     * Get persons, apply filers and paginate result
     * @param type $request
     * @return type
     */
    public function getPersons($request) {

        //get base query for companies
        $query = $this->personRepo->getPersons();

        //apply filters
        $filteredQuery = SearchPerson::apply($request, $query);

        //paginate result
        return $filteredQuery->paginate(\Config::get('pagination.pagination'));
    }

    /**
     * Get all data for given person ID
     * @param type $request
     * @return type
     */
    public function getPerson($request) {
        return [
            'person' => $this->personRepo->getPerson($request->id),
        ];
    }

    public function formData() {
        return [
            'settlements' => $this->settlementsRepo->getSettlements($this->settlementsRepo->getCityConstant())->get(),
        ];
    }

    public function formValues() {
        return $this->personRepo->createPerson();
    }

    /**
     * Get person data by id
     * @param type $id
     * @return type
     */
    public function edit($id) {
        return $this->personRepo->getPerson($id);
    }

    /**
     * Update person data
     * @return type
     */
    public function update($id, $data) {
        try {
            DB::beginTransaction();
            $this->personRepo->setId($id);
            $this->personRepo->update($data);
            DB::commit();
            return $id;
        } catch (Exception $ex) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Store person data
     * @return type
     */
    public function store($data) {
        try {
            DB::beginTransaction();
//            $activeLanguages = $this->language->getActiveLanguages();
            $id = $this->personRepo->store($data);
            DB::commit();
            return $id;
        } catch (Exception $ex) {
            DB::rollBack();
            return false;
        }
    }

    public function getPersonHistory($request) {
        //get base query for person
        return $this->personRepo->getPersonHistory($request->id);
    }

    public function search($request) {
        return $this->personRepo->search($request->person);
    }

}
