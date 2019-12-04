<?php

namespace App\Services\Contragents;

use App\Models\Api\Repositories\Contragents\ContragentsRepositoryInterface as ContragentsRepositoryInterface;
use App\Models\Api\Repositories\Language\LanguageRepositoryInterface;
use App\Models\Api\Repositories\Countries\CountriesRepositoryInterface as CountriesRepositoryInterface;
use App\Models\Api\Repositories\Settlements\SettlementsRepositoryInterface as SettlementsRepositoryInterface;
use App\Models\Api\Repositories\OrganizationType\OrganizationTypeRepositoryInterface as OrganizationTypeRepositoryInterface;
use App\Models\Api\Repositories\ContragentType\ContragentTypeRepositoryInterface as ContragentTypeRepositoryInterface;
use App\Models\Api\Filters\Contragents\SearchContragent as SearchContragent;
use \DB;
use App\Http\Resources\Contragents\ContragentResource;

class Contragents implements ContragentsInterface {

    protected $contragentRepo;
    protected $settlementsRepo;
    protected $countriesRepo;
    protected $language;
    protected $contragentOrganizationTypeRepo;
    protected $contragentTypeRepo;

    public function __construct(ContragentsRepositoryInterface $contragentRepo, LanguageRepositoryInterface $language, CountriesRepositoryInterface $countriesRepo, SettlementsRepositoryInterface $settlementsRepo, OrganizationTypeRepositoryInterface $organizationTypeRepo, ContragentTypeRepositoryInterface $contragentTypeRepo) {
        $this->contragentRepo = $contragentRepo;
        $this->language = $language;
        $this->countriesRepo = $countriesRepo;
        $this->settlementsRepo = $settlementsRepo;
        $this->contragentOrganizationTypeRepo = $organizationTypeRepo;
        $this->contragentTypeRepo = $contragentTypeRepo;
    }

    /**
     * Get contragents, apply filers and paginate result
     * @param type $request
     * @return type
     */
    public function getContragents($request) {

        //get base query for companies
        $query = $this->contragentRepo->getContragents($request);

        //apply filters
        $filteredQuery = SearchContragent::apply($request, $query);

        if($request->has('exportType'))
            return $filteredQuery->get();
        
//        return $filteredQuery->get();
        //paginate result
        return $filteredQuery->paginate($request->input('per_page', \Config::get('pagination.pagination')));
    }

    /**
     * Get all data for given contragent ID
     * @param type $request
     * @return type
     */
    public function getContragent($request) {
        $contragent = \Contragent::find($request->id);

        $contragentRelations = $contragent->related()->get()->toArray();
        $contragentInverseRelations = $contragent->relatedinverse()->get()->toArray();

        $persons = $contragent->persons()->get()->toArray();

        return [
            'contragent' => new ContragentResource($this->contragentRepo->getContragent($request->id)), //$this->contragentRepo->getContragent($request->id),
            'contragents_relation' => array_merge($contragentRelations, $contragentInverseRelations),
            'persons' => $persons
        ];
    }

    public function formData() {
        return [
            'settlements' => $this->settlementsRepo->getSettlements($this->settlementsRepo->getCityConstant())->get(),
            'countries' => $this->countriesRepo->getCountries()->get(),
            'organizationtypes' => $this->contragentOrganizationTypeRepo->getOrganizationType()->get(),
            'contragenttype' => $this->contragentTypeRepo->getContragentTypes()->get()
        ];
    }

    public function formValues() {
        return $this->contragentRepo->createContragent();

//        //TO DO: Da izmislq default values!!!
//        return array_fill_keys(array_keys($this->contragentRepo->getCols()), null);
    }

    /**
     * Get contragent data by id
     * @param type $id
     * @return type
     */
    public function edit($id) {
        return $this->contragentRepo->getContragent($id);
    }

    /**
     * Update contragent data
     * @return type
     */
    public function update($id, $data) {
        try {
            DB::beginTransaction();
            $this->contragentRepo->setId($id);
            $this->contragentRepo->update($data);
            DB::commit();
            return $id;
        } catch (Exception $ex) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Store contragent data
     * @return type
     */
    public function store($data) {
        try {
            DB::beginTransaction();
//            $activeLanguages = $this->language->getActiveLanguages();
            $id = $this->contragentRepo->store($data);
            DB::commit();
            return $id;
        } catch (Exception $ex) {
            DB::rollBack();
            return false;
        }
    }

    public function getContragentHistory($request) {
        //get base query for companies
        return $this->contragentRepo->getContragentHistory($request->id);
    }

    public function search($request) {
        return $this->contragentRepo->search($request->contragent);
    }

    public function storeRelation($request) {
        return $this->contragentRepo->storeRelation($request);
    }

    public function storePerson($request) {
        return $this->contragentRepo->storePerson($request);
    }

    public function deleteRelation($request) {
        return $this->contragentRepo->deleteRelation($request);
//        return \ContragentsRelation::findOrFail($request->id)->delete();
    }

    public function deletePerson($request) {
        return $this->contragentRepo->deletePerson($request);
    }

}
