<?php

namespace App\Models\Api\Repositories\Language;

use \App\Models\Api\Repositories\BaseRepository;
use App\Models\Api\Repositories\Language\LanguageRepositoryInterface as LanguageRepositoryInterface;
use Language;

class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface {

    public $model;

    public function __construct(Language $model) {
        $this->model = $model;
        parent::__construct();
    }

    /**
     * Get current language ID
     * @return boolean
     */
    public function getLangId() {
        if (isset($this->lang->id))
            return $this->lang->id;

        return false;
    }

    /**
     * Return all active languages
     * @param type $type
     * @return array
     */
    public function getActiveLanguages() {
        return $this->model
                        ->where('active', '=', $this->model->getActiveState())
                        ->get()
                        ->toArray();
    }

    /**
     * Return true if language is existing and active
     * @param type $lang
     * @return boolean
     */
    public function existsAndActive($lang) {
        $this->lang = $this->model
                ->where('lang', '=', $lang)
                ->where('active', '=', $this->model->getActiveState())
                ->first();

        if (isset($this->lang->id)) {
            return true;
        }

        return false;
    }

    /**
     * Set a language
     * @param type $lang
     * @return boolean
     */
    public function setLang($lang) {

        if ($this->existsAndActive($lang)) {
            \App::setLocale($lang);
            $user = \Auth::user();
            $user->prefered_lang = $this->getLangId();
            $user->save();
            
            return true;
        }

        return false;
    }

}
