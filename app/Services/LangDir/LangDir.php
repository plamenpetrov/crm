<?php

namespace App\Services\LangDir;

use Illuminate\Support\Facades\Session as Session;
use Illuminate\Support\Facades\Lang as Lang;
use Config;

class LangDir {

    /**
     * Change default Laravel Language translation directory to 
     * /resources/lang/{databasename}
     */
    public function setLanguageNamespace($clientKey) {
        return Lang::addNamespace('languages', $this->basePath() . $clientKey);
    }

    public function basePath() {
        return app_path() . '/../resources/lang/';
    }

}
