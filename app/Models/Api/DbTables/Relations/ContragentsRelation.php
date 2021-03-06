<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class ContragentsRelation extends BaseModel {

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'contragents_relation';
    protected $fillable = ['contragents_id', 'contragents_relation_id'];

}
