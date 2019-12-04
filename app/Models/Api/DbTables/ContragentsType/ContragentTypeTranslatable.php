<?php

class ContragentTypeTranslatable extends BaseContragentTypeModel {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'company_types_translation';
    protected $fillable = ['company_types_id', 'name', 'lang'];
    public $timestamps = false;

    protected static $recordEvents = [
        'updating'
    ];
    
    public $foreign_key = 'company_types_id';
    protected $hidden = ['id', 'company_types_id', 'lang'];

    public function contragenttype() {
        return $this->belongsTo('ContragentType', 'company_types_id', 'id');
    }

    public function scopeLang($query, $langId) {
        return $query->where('lang', '=', $langId);
    }

}
