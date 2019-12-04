<?php

class PersonHistory extends BaseModel {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'persons_history';
    protected $fillable = [
        'persons_id',
        'identification_number',
        'phone',
        'email',
        'idcard',
        'idcard_date_of_issue',
        'idcard_date_of_expiry',
        'published_by',
        'updated_by'
    ];

}
