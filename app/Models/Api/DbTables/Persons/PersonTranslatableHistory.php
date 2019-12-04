<?php

use App\Models\Api\History\HistoryTrait as HistoryTrait;

class PersonTranslatableHistory extends BaseModel {

    use HistoryTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'persons_translatable_history';
    protected $fillable = ['persons_id', 'first_name', 'family_name', 'address_idcard', 'mailing_address', 'note', 'lang'];

}
