<?php

namespace App\Models\Api\Repositories\Contragents;

use \App\Models\Api\Repositories\BaseRepository;
use App\Models\Api\Repositories\Contragents\ContragentsRepositoryInterface as ContragentsRepositoryInterface;
use App\Events\Model\UpdatingEvent as UpdatingEvent;
use App\Events\Model\CreatingEvent as CreatingEvent;
use Contragent;
use ContragentTranslatable;
use ContragentHistory;
use ContragentTranslatableHistory;

class ContragentsRepository extends BaseRepository implements ContragentsRepositoryInterface {

    protected $id;
    protected $model;
    protected $modelTranslatable;
    protected $modelHistory;
    protected $modelTranslatableHistory;

    public function __construct(Contragent $contragent, ContragentTranslatable $contragentTranslatable, ContragentHistory $contragentHistory, ContragentTranslatableHistory $contragentTranslatableHistory) {
        parent::__construct();
        $this->model = $contragent;
//        $this->modelTranslatable = $contragentTranslatable;
        $this->modelHistory = $contragentHistory;
        $this->modelTranslatableHistory = $contragentTranslatableHistory;
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
     * Return base query to get list of contragents
     * @return type
     */
    public function getContragents($request) {
        return (new \Contragent)->newQuery();
    }

    /**
     * 
     * @return type
     */
    public function createContragent() {
        $c = new \Contragent;
        $relations = ['type.translatable', 'organizationtype.translatable', 'type.color'];

        return $c->load($relations);
    }

    public function getContragent($id) {
        return \Contragent::with(['type.translatable', 'organizationtype.translatable', 'type.color'])
                        ->find($id);
    }

    /**
     * Update contragent data, create event in activity and add hitory row
     * @param type $data
     * @return type
     */
    public function update($data) {
        $contragent = \Contragent::find($this->id);

        $relations = ['type.translatable', 'organizationtype.translatable'];

        $contragent->load($relations);

        $this->setBaseColumns($contragent, $data);

        $contragent->updated_by = \Auth::user()->id;
        event(new UpdatingEvent($contragent));
        $contragent->save();

        return $this->id;
    }

    /**
     * Set base table columns
     * @param type $contragent
     * @param type $data
     * @return type
     */
    protected function setBaseColumns($contragent, $data) {
        $contragent->EIK = $data['contragentEIK'];
        $contragent->DanNom = $data['contragentDanNom'];
        $contragent->phone = $data['contragentphone'];
        $contragent->email = $data['contragentemail'];
        $contragent->settlements_id = $data['contragentsettlements'];
        $contragent->country_id = $data['contragentcountry'];
        $contragent->company_organization_types_id = $data['contragentorganizationtype'];
        $contragent->company_types_id = $data['contragenttype'];

        $contragent->name = $data['contragentname'];
        $contragent->contact_address = $data['contactaddress'];
        $contragent->registration_address = $data['registrationaddress'];

        return $contragent;
    }

    /**
     * Create new contragent in DB
     * @param type $data
     * @return type
     */
    public function store($data) {
        //create new company
        $contragent = new \Contragent();

        $this->setBaseColumns($contragent, $data);
        $contragent->user_id = \Auth::user()->id;

        $contragent->save();
        event(new CreatingEvent($contragent));

        return $contragent->id;
    }

    /**
     * Save transaltion data for given contragent
     * @param type $data
     * @param type $id
     * @param type $lang
     * @return type
     */
    protected function saveTranslation($data, $contragent, $lang) {
        //add system columns 
        $contragentTranslatable = new \ContragentTranslatable();

        $contragentTranslatable->contragents_id = $contragent->id;
        $this->setTranslationColumns($contragentTranslatable, $data);

        //add system columns 
        $contragentTranslatable->lang = $lang['id'];

        return $contragentTranslatable->save();
    }

    public function getContragentHistory($id) {
        $c = \Contragent::find($id);

        return $c->revision()
                        ->get()
                        ->groupBy(function($revision) {
                            return $revision->column;
//                            return $revision->created_at->format('Y-m-d');
                        });
    }

    /**
     * Perform search contragent
     * @param type $slug
     * @return type
     */
    public function search($slug) {
        return \Contragent::search($slug)->paginate();
    }

    /**
     * Create relation many to meny between contragents
     * @param type $request
     * @return type
     */
    public function storeRelation($request) {
        $c = \Contragent::findOrFail($request->contragentid);
        return $c->related()->sync([$request->relationid => ['updated_by' => auth()->user()->id]], false);
    }

    /**
     * Add person - contragent relation
     * @param type $request
     * @return type
     */
    public function storePerson($request) {
        $c = \Contragent::findOrFail($request->contragentid);
        return $c->persons()->sync([$request->personid => ['updated_by' => auth()->user()->id, 'comment' => $request->comment]], false);
    }

    /**
     * Delete contragent relation
     * @param type $request
     * @return type
     */
    public function deleteRelation($request) {
        $c = \Contragent::findOrFail($request->contragentid);
        return $c->related()->detach($request->relationid);
    }

    /**
     * Delete contragent - person relation
     * @param type $request
     * @return type
     */
    public function deletePerson($request) {
        $c = \Contragent::findOrFail($request->contragentid);
        return $c->persons()->detach($request->personid);
    }

}
