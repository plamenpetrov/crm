<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Settlement extends BaseSettlementModel {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'settlement';
    protected $fillable = [];
    public $foreign_key = 'id';
    protected $hidden = ['user_id', 'created_at', 'updated_at', 'updated_by', 'status'];

    public function translatable() {
        return $this->hasOne('SettlementTranslatable', 'settlement_id', 'id');
    }

}
