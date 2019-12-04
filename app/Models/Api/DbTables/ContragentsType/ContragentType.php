<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class ContragentType extends BaseContragentTypeModel {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'company_types';
    protected $fillable = ['user_id'];
    public $foreign_key = 'id';
    protected $hidden = ['user_id', 'created_at', 'updated_at', 'updated_by', 'status'];

    public function translatable() {
        return $this->hasOne('ContragentTypeTranslatable', 'company_types_id', 'id');
    }
    
    public function color() {
        return $this->hasOne(\SystemColors::class, 'id', 'system_color_id');
    }
}
