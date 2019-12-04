<?php

use App\Models\Api\User as User;
use App\Models\Api\History\HistoryTrait as HistoryTrait;

class PersonTranslatable extends BasePersonModel {

    use HistoryTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'persons_translatable';
    protected $fillable = ['persons_id', 'first_name', 'family_name', 'address_idcard', 'mailing_address', 'note', 'lang'];
    public $timestamps = false;
    protected static $recordEvents = [
        'updating'
    ];
    
    public $foreign_key = 'persons_id';
    protected $hidden = ['id', 'persons_id', 'lang'];
    
    protected $attributes = [
        'first_name' => null,
        'family_name' => null,
        'address_idcard' => null,
        'mailing_address' => null,
        'note' => null,
    ];

    public function person() {
        return $this->belongsTo('Person', 'persons_id', 'id');
    }

    public function scopeLang($query, $langId) {
        return $query->where('lang', '=', $langId);
    }

    public function scopePerson($query, $id) {
        return $query->where('persons_id', '=', $id);
    }

}
