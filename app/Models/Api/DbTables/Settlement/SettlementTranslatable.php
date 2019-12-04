<?php

class SettlementTranslatable extends BaseSettlementModel {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'settlement_translation';
    protected $fillable = ['settlement_id', 'name', 'lang'];
    public $timestamps = false;

    protected static $recordEvents = [
        'updating'
    ];
    
    public $foreign_key = 'settlement_id';
    protected $hidden = ['id', 'settlement_id', 'lang'];

    public function contragenttype() {
        return $this->belongsTo('Settlement', 'settlement_id', 'id');
    }

    public function scopeLang($query, $langId) {
        return $query->where('lang', '=', $langId);
    }

}
