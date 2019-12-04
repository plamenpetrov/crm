<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Api\History\HistoryTrait as HistoryTrait;
use Laravel\Scout\Searchable;

class Person extends BasePersonModel {

    use SoftDeletes,
        HistoryTrait,
        Searchable;

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
    protected $table = 'persons';
    
    protected $fillable = [
        'first_name', 
        'family_name', 
        'address_idcard', 
        'mailing_address', 
        'identification_number', 
        'phone', 
        'email', 
        'idcard', 
        'idcard_date_of_issue', 
        'idcard_date_of_expiry', 
        'publishedby_id',
        'note'
    ];
    
    protected static $recordEvents = [
        'updating'
    ];
    
    public $foreign_key = 'id';
    
    public $foreign_keys = [
        'publishedby_id' => [
            'classname' => 'Settlement',
            'relations' => ['translatable'],
            'accessLogColumn' => 'translatable.name'
        ]
    ];
    
    protected $hidden = ['user_id', 'created_at', 'updated_at', 'updated_by', 'deleted_at', 'translatable'];
    protected $attributes = [
        'id' => null,
        'first_name' => null,
        'family_name' => null,
        'address_idcard' => null,
        'mailing_address' => null,
        'identification_number' => null,
        'phone' => null,
        'email' => null,
        'idcard' => null,
        'idcard_date_of_issue' => null,
        'idcard_date_of_expiry' => null,
        'publishedby_id' => null,
        'note' => null,
    ];
    
    protected $appends = []; // add custom attribute to JSON output

    public function getForeigKey($model) {
        return $model->foreign_key;
    }

    public function revision() {
        return $this->hasMany(PersonRevision::class, 'revisionable_id', 'id');
    }
    
//    public function translatable() {
//        return $this->hasOne(PersonTranslatable::class, 'persons_id', 'id')->withDefault([
//                    'first_name' => '',
//        ]);
//    }

//    public function scopeTranslated($id, $langId) {
//        return $this->translatable()
//                        ->where('persons_id', '=', $id)
//                        ->where('lang', '=', $langId);
//    }

}
