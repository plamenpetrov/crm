<?php

namespace App\Models\Api\Repositories\Persons;

use \App\Models\Api\Repositories\BaseRepository;
use App\Models\Api\Repositories\Persons\PersonsRepositoryInterface as PersonsRepositoryInterface;
use App\Events\Model\UpdatingEvent as UpdatingEvent;
use App\Events\Model\CreatingEvent as CreatingEvent;
use Person;
use PersonTranslatable;

class PersonsRepository extends BaseRepository implements PersonsRepositoryInterface {

    protected $id;
    protected $model;
    protected $modelTranslatable;

    public function __construct(Person $person, PersonTranslatable $personTranslatable) {
        parent::__construct();
        $this->model = $person;
        $this->modelTranslatable = $personTranslatable;
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
     * Return base query to get list of persons
     * @return type
     */
    public function getPersons() {
        return (new \Person)->newQuery();
    }

    /**
     * Create new object for Person
     * @return Person
     */
    public function createPerson() {
        return new \Person;
    }

    /**
     * Find person by given id
     * @param type $id
     * @return type
     */
    public function getPerson($id) {
        return \Person::find($id);
    }

    /**
     * Update contragent data, create event in activity and add hitory row
     * @param type $data
     * @return type
     */
    public function update($data) {
        $person = \Person::find($this->id);
        $this->setBaseColumns($person, $data);

        $person->updated_by = \Auth::user()->id;
        event(new UpdatingEvent($person));

        $person->save();

        return $this->id;
    }

    /**
     * Set base table columns
     * @param type $person
     * @param type $data
     * @return type
     */
    protected function setBaseColumns($person, $data) {
        $person->first_name = $data['personfirstname'];
        $person->family_name = $data['personfamilyname'];
        $person->mailing_address = $data['personmailingaddress'];
        $person->address_idcard = $data['personaddressidcard'];
        $person->identification_number = $data['personidentificationnumber'];
        $person->phone = $data['personphone'];
        $person->email = $data['personemail'];
        $person->idcard = $data['personidcard'];
        $person->idcard_date_of_expiry = $data['personidcarddateofexpiry'];
        $person->idcard_date_of_issue = $data['personidcarddateofissue'];
        $person->publishedby_id = $data['personpublishedby'];

        return $person;
    }

    /**
     * Create new contragent in DB
     * @param type $data
     * @return type
     */
    public function store($data) {
        //create new person
        $person = new \Person();

        $this->setBaseColumns($person, $data);
        $person->user_id = \Auth::user()->id;

        $person->save();

        event(new CreatingEvent($person));

        return $person->id;
    }

    /**
     * Save transaltion data for given contragent
     * @param type $data
     * @param type $id
     * @param type $lang
     * @return type
     */
    protected function saveTranslation($data, $person, $lang) {
        //add system columns 
        $personTranslatable = new \PersonTranslatable();

        $personTranslatable->persons_id = $person->id;
        $this->setTranslationColumns($personTranslatable, $data);

        //add system columns 
        $personTranslatable->lang = $lang['id'];

        return $personTranslatable->save();
    }

    /**
     * Get history for given person id
     * @param type $id
     * @return type
     */
    public function getPersonHistory($id) {
        $p = \Person::find($id);

        return $p->revision()
                        ->get()
                        ->groupBy(function($revision) {
                            return $revision->column;
//                            return $revision->created_at->format('Y-m-d');
                        })
        ;
    }

    /**
     * Perform person search
     * @param type $slug
     * @return type
     */
    public function search($slug) {
        return \Person::search($slug)->paginate();
    }

}
