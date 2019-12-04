<?php

class EventType extends BaseEventTypeModel {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'events_types';
    protected $hidden = ['created_at', 'updated_at'];

    public function translatable() {
        return $this->hasOne('EventTypeTranslatable', 'events_types_id', 'id');
    }
}
