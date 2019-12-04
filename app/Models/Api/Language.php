<?php

class Language extends Eloquent
{

    const active = 1;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'languages';

    public function getActiveState() {
        return self::active;
    }
}
