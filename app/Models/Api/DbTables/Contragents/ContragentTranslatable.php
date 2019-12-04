<?php

use App\Models\Api\User as User;
use App\Models\Api\History\HistoryTrait as HistoryTrait;
use Laravel\Scout\Searchable;

class ContragentTranslatable extends BaseContragentModel {

    use HistoryTrait,
        Searchable;

    const active = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'contragents_translatable';
    protected $fillable = ['contragents_id', 'name', 'contact_address', 'registration_address', 'lang'];
    public $timestamps = false;
    protected static $recordEvents = [
        'updating'
    ];
    public $foreign_key = 'contragents_id';
    protected $hidden = ['id', 'contragents_id', 'lang'];
    protected $attributes = [
        'contragents_id' => null,
        'name' => null,
        'contact_address' => null,
        'registration_address' => null,
    ];

    public function toSearchableArray() {
        return $this->attributes;
    }

    /**
     * Define Eloquent relation belongsTo to Contragent Model
     * @return type
     */
    public function contragent() {
        return $this->belongsTo('Contragent', 'contragents_id', 'id');
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     * @return type
     */
    public function scopeState($query) {
        return $query->where('state', '=', self::active);
    }

    /**
     * Apply language scope to a given Eloquent query builder.
     * @return type
     */
    public function scopeLang($query, $langId) {
        return $query->where('lang', '=', $langId);
    }

    /**
     * Apply contragent scope to a given Eloquent query builder.
     * @return type
     */
    public function scopeContragent($query, $id) {
        return $query->where('contragents_id', '=', $id);
    }

    /**
     * Apply name scope to a given Eloquent query builder.
     * @return type
     */
    public function scopeName($query, $name) {
        return $query->where('name', $name);
    }

}
