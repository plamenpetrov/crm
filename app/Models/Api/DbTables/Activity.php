<?php

class Activity extends BaseModel {

    protected $table = 'activities';
    
    protected $fillable = ['user_id', 'content_id', 'content_type', 'action', 'before', 'after'];
    
    public function user() {
        return $this->belongsTo('App\Models\Api\User');
    }
    
    public function content() {
        return $this->morphTo();
    }
}
