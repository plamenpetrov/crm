<?php

class ContragentRevision extends BaseModel {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'contragents_revision';
    protected $fillable = ['revisionable_id', 'user_id', 'column', 'old_value', 'new_value'
    ];
    
    protected $with = ['author'];
    
    /**
     * Define Eloquent relation belongsTo to User Model
     * @return type
     */
    public function author() {
        return $this->belongsTo(\App\Models\Api\User::class, 'user_id', 'id');
    }
}
