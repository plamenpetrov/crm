<?php
//namespace App\Http\Controllers;

class BaseController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    public function __construct() {
//        $this->beforeFilter(function() {
//            start_measure('controller', 'Controller running');
//        });
//        $this->afterFilter(function() {
//            stop_measure('controller');
//        });
    }
    
    public function addTranslations($key) {
        return \Lang::get('languages::' . $key);
    }

}
