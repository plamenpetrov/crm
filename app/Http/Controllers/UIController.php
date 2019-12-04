<?php

use App\Models\Api\Repositories\Language\LanguageRepositoryInterface;
use App\Models\Api\Repositories\Navigation\NavigationRepositoryInterface;
use App\Models\Api\Repositories\Activities\ActivitiesRepositoryInterface;

/**
 * Description of UIController
 * 
 * UI controller is 
 */
class UIController extends ApiController {

    /**
     * The language repository
     * @var type 
     */
    protected $language;
    protected $navigation;
    protected $activity;

    public function __construct(LanguageRepositoryInterface $language, NavigationRepositoryInterface $navigation, ActivitiesRepositoryInterface $activity) {
        $this->language = $language;
        $this->navigation = $navigation;
        $this->activity = $activity;
    }

    /**
     * URL : /lang/{lang}
     * Method : GET
     * 
     * Setting the input language as current
     * @param type $lang
     * @return type
     */
    public function setLang($lang) {
        if ($this->language->setLang($lang)) {
            return $this->respond([
                        'status' => 'success',
                        'navigation' => $this->navigation->getNavigations(),
                        'translations' => \Translate::getTranslations(),
                            ], \Translate::translate('labels=>change-language-success'));
        }

        return $this->respondNotAceptable('Language is not acceptable');
    }

    /**
     * Return all active languages in the system
     * @return type
     */
    public function getActivLanguages() {
        $activeLanguages = $this->language->getActiveLanguages();
        return $this->respond($activeLanguages);
    }

    /*     * NAVIGATIONS */

    public function getNavigations($type = null) {
        return $this->respond($this->navigation->getNavigations($type));
    }

    /*     * Activities */

    public function getActivity() {
        return $this->respond($this->activity->getActivity());
    }

}
