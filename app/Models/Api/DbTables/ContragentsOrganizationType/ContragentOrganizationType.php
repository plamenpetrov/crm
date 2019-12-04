<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class ContragentOrganizationType extends BaseContragentTypeModel {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'company_organization_types';
    protected $fillable = [];
    public $foreign_key = 'id';
    protected $hidden = ['user_id', 'created_at', 'updated_at', 'updated_by', 'status'];

    public function translatable() {
        return $this->hasOne('ContragentOrganizationTypeTranslatable', 'company_organization_types_id', 'id');
    }

}
