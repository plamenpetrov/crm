<?php

class EventTypeTranslatable extends BaseEventTypeModel {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'events_types_translation';
    protected $fillable = ['events_types_id', 'name', 'lang'];
    public $timestamps = false;

    public $foreign_key = 'events_types_id';
    protected $hidden = ['id', 'events_types_id', 'lang'];

    public function contragenttype() {
        return $this->belongsTo('EventType', 'events_types_id', 'id');
    }

    public function scopeLang($query, $langId) {
        return $query->where('lang', '=', $langId);
    }

}
