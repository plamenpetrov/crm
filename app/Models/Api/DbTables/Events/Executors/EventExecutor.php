<?php

use App\Models\Api\User;

class EventExecutor extends BaseEventModel {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'events_executors';
    public $timestamps = false;
    protected $fillable = ['events_id', 'executor_id'];

    protected $attributes = [
        'events_id' => null,
        'executor_id' => 1,
    ];
    
    public function event() {
        return $this->belongsTo('Events', 'events_id', 'id');
    }
    
    public function user() {
        return $this->hasOne(User::class, 'id', 'executor_id');
    }
    
}
