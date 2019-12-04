<?php

class ContragentOrganizationTypeTranslatable extends BaseContragentTypeModel {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'company_organization_types_translation';
    protected $fillable = ['company_organization_types_id', 'name', 'lang'];
    public $timestamps = false;
    protected static $recordEvents = [
        'updating'
    ];
    public $foreign_key = 'company_organization_types_id';
    protected $hidden = ['id', 'company_organization_types_id', 'lang'];

    /**
     * Define Eloquent relation belongsTo to Contragent Organization Type Model
     * @return type
     */
    public function contragenttype() {
        return $this->belongsTo('ContragentOrganizationType', 'company_organization_types_id', 'id');
    }

    /**
     * Apply language scope to a given Eloquent query builder.
     * @return type
     */
    public function scopeLang($query, $langId) {
        return $query->where('lang', '=', $langId);
    }

}
