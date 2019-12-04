<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Events extends BaseEventModel {

    use SoftDeletes,
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
    protected $table = 'events';
    protected $fillable = [
        'events_types_id',
        'events_subtypes_id',
        'name',
        'description',
        'location',
        'start_date',
        'end_date',
        'contragents_id',
        'projects_id'
    ];
    protected $hidden = ['user_id', 'created_at', 'updated_at', 'updated_by', 'deleted_at'];
    protected $attributes = [
        'id' => null,
        'events_types_id' => 1,
        'events_subtypes_id' => 1,
        'name' => null,
        'description' => null,
        'location' => null,
        'start_date' => null,
        'end_date' => null,
        'contragents_id' => null,
        'projects_id' => null,
    ];
//    protected $appends = ['contragenttype', 'contragentorganizationtype', 'contragentcolor']; // add custom attribute to JSON output
    protected $with = ['type.translatable', 'subtype.translatable', 'executor.user']; //, 'color'];

    public function toSearchableArray() {

        return [
            'name' => null,
            'description' => null,
            'location' => null,
        ];
    }

    /**
     * Define Eloquent relation hasOne to EventType Model
     * @return type
     */
    public function type() {
        return $this->hasOne(EventType::class, 'id', 'events_types_id');
    }

    /**
     * Define Eloquent relation hasOne to EventSubType Model
     * @return type
     */
    public function subtype() {
        return $this->hasOne(EventSubType::class, 'id', 'events_subtypes_id');
    }

    /**
     * Define Eloquent relation hasMany to EventExecutor Model
     * @return type
     */
    public function executor() {
        return $this->hasMany(EventExecutor::class, 'events_id', 'id');
    }
    
    /**
     * Perform delete operation on executor Eloquent relation for this model
     * @return type
     */
    public function deleteExecutor() {
        return $this->executor()->where('events_id', $this->id)->delete();
    }
    
    /**
     * Perform create operation on executor Eloquent relation for this model
     * @return type
     */
    public function addExecutor($executor_id) {
        return $this->executor()->create(['events_id' => $this->id, 'executor_id' => $executor_id]);
    }

}
