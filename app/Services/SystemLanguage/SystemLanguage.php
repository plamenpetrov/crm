<?php

namespace App\Services\SystemLanguage;

//use Illuminate\Support\Facades\Session as Session;
//use Illuminate\Support\Facades\Lang as Lang;
//use Config;
use Language;

class SystemLanguage {

    protected $current_language_id;

    /**
     * Change default Laravel Language translation directory to 
     * /resources/lang/{databasename}
     */
    public function setLanguage($locale) {
        return $this->current_language_id = \Language::where('lang', '=', $locale)->first()->id;
    }

    public function getLanguage() {
        return $this->current_language_id;
    }

}
