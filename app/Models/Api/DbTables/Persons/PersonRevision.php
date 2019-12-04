<?php

class PersonRevision extends BaseModel {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'persons_revision';
    protected $fillable = ['revisionable_id', 'user_id', 'column', 'old_value', 'new_value'
    ];
    
    protected $with = ['author'];
    
    public function author() {
        return $this->belongsTo(\App\Models\Api\User::class, 'user_id', 'id');
    }
}
