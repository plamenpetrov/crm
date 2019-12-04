<?php

class EventSubType extends BaseEventSubTypeModel {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'events_subtypes';
    protected $hidden = ['created_at', 'updated_at'];

    public function translatable() {
        return $this->hasOne('EventSubTypeTranslatable', 'events_subtypes_id', 'id');
    }
}
