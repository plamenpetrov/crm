<?php

class EventSubTypeTranslatable extends BaseEventSubTypeModel {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'events_subtypes_translation';
    protected $fillable = ['events_subtypes_id', 'name', 'lang'];
    public $timestamps = false;

    public $foreign_key = 'events_subtypes_id';
    protected $hidden = ['id', 'events_subtypes_id', 'lang'];

    public function contragenttype() {
        return $this->belongsTo('EventSubType', 'events_subtypes_id', 'id');
    }

    public function scopeLang($query, $langId) {
        return $query->where('lang', '=', $langId);
    }

}
