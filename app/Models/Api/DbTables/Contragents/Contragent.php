<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Api\History\HistoryTrait as HistoryTrait;
use Laravel\Scout\Searchable;
use App\Models\Api\User;

class Contragent extends BaseContragentModel {

    use SoftDeletes,
        HistoryTrait,
        Searchable;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'companies';
    protected $fillable = ['name', 'contact_address', 'registration_address', 'EIK', 'DanNom', 'settlements_id', 'country_id', 'phone', 'email', 'company_organization_types_id', 'company_types_id'];
    protected static $recordEvents = [
        'updating'
    ];
    public $foreign_key = 'id';
    public $foreign_keys = [
        'settlements_id' => null,
        'country_id' => null,
        'company_organization_types_id' => [
            'classname' => 'ContragentOrganizationType',
            'relations' => ['translatable'],
            'accessLogColumn' => 'translatable.name'
        ],
        'company_types_id' => [
            'classname' => 'ContragentType',
            'relations' => ['translatable'],
            'accessLogColumn' => 'translatable.name'
        ]
    ];
    protected $hidden = ['user_id', 'created_at', 'updated_at', 'updated_by', 'deleted_at'];
    protected $attributes = [
        'id' => null,
        'EIK' => null,
        'DanNom' => null,
        'settlements_id' => null,
        'country_id' => null,
        'phone' => null,
        'email' => null,
        'company_organization_types_id' => 1,
        'company_types_id' => 3,
        'name' => null,
        'contact_address' => null,
        'registration_address' => null,
//        'contragenttype' => null
    ];
//    protected $appends = ['contragenttype', 'contragentorganizationtype', 'contragentcolor']; // add custom attribute to JSON output

    protected $with = ['type.translatable', 'organizationtype.translatable', 'type.color', 'createdby', 'updatedby']; //, 'color'];

    /**
     * Implement elastic search on model
     * @return type
     */
    public function toSearchableArray() {

        return [
            'name' => null,
            'contact_address' => null,
            'registration_address' => null,
            'mailing_address' => null,
            'EIK' => null,
            'DDSNom' => null,
            'phone' => null,
            'email' => NULL
        ];
    }

    /**
     * Define accessor for contragent type
     * @return type
     */
    public function getContragentTypeAttribute() {
        return $this->type->translatable->name;
    }

    /**
     * Define accessor for organization type
     * @return type
     */
    public function getContragentOrganizationTypeAttribute() {
        return $this->organizationtype->translatable->name;
    }

    /**
     * Define accessor for contragent color used in calendar
     * @return type
     */
    public function getContragentColorAttribute() {
        if (!$this->relationLoaded('type'))
            $this->load('type');

        return $this->getRelation('type') ? $this->type->color->color : NULL;
    }

    /**
     * Define Eloquent relation hasOne to Contragent Type Model
     * @return type
     */
    public function type() {
        return $this->hasOne(ContragentType::class, 'id', 'company_types_id');
    }

    /**
     * Define Eloquent relation hasMany to Contragent Revision Model
     * @return type
     */
    public function revision() {
        return $this->hasMany(ContragentRevision::class, 'revisionable_id', 'id');
    }

    /**
     * Define Eloquent relation belongsToMany to Contragent Organization Type Model
     * @return type
     */
    public function organizationtype() {
        return $this->hasOne(ContragentOrganizationType::class, 'id', 'company_organization_types_id');
    }

    /**
     * Define Eloquent relation belongsToMany to Contragent Model
     * @return type
     */
    public function related() {
        return $this->belongsToMany(Contragent::class, 'contragents_relation', 'contragents_id', 'contragents_relation_id')->whereNull('contragents_relation.deleted_at');
    }

    /**
     * Define Eloquent relation belongsToMany to Contragent Model
     * @return type
     */
    public function relatedinverse() {
        return $this->belongsToMany(Contragent::class, 'contragents_relation', 'contragents_relation_id', 'contragents_id')->whereNull('contragents_relation.deleted_at');
    }

    /**
     * Define Eloquent relation belongsToMany to Person Model
     * @return type
     */
    public function persons() {
        return $this->belongsToMany(Person::class, 'contragents_persons', 'contragents_id', 'persons_id')->whereNull('contragents_persons.deleted_at');
    }

    /**
     * Define Eloquent relation hasOne to User Model
     * @return type
     */
    public function createdby() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Define Eloquent relation hasOne to User Model
     * @return type
     */
    public function updatedby() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

}
