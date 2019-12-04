<?php

namespace App\Services\Translation;

use \Illuminate\Support\Facades\Storage;
use Lang;

class Translate {

    const translation_separator = '=>';

    /**
     * Returns a translation according the input parameters. 
     * The first parameter is string. If there is no second parameter passed, the first one is considered as
     * delimited by '_' to name of language file and  translation key(e.g. greetings_hello). 
     * If there is second parameter set, the first one will be the language file name, and the second should be the key.
     * The translator then check the custom namespace(same as the user's database name, stored in the session), 
     * and find the requested translation in the files there.
     * @param type $file_key
     * @param type $key
     * @return type
     */
    public function translate($file_key, $key = null, $variables = null) {
        if (!$key) {
            if (!strpos($file_key, self::translation_separator)) {
                \Log::error('Error translate. No separator found');
                return 'Cannot be translated, check the logs';
            }
            $explode = explode(self::translation_separator, $file_key);
            $langFile = $explode[0];
            $key = $explode[1];
        } else {
            $langFile = $file_key;
        }

//        return Lang::get($langFile . '.' . $key);

        if ($variables)
            return Lang::get('languages::' . $langFile . '.' . $key, $variables);
        return Lang::get('languages::' . $langFile . '.' . $key);

//        if (!$key) {
//            if (!strpos($file_key, self::translation_separator)) {
//                \Log::error('Error translate. No separator found');
//                return 'Cannot be translated, check the logs';
//            }
//            $explode = explode(self::translation_separator, $file_key);
//            $langFile = $explode[0];
//            $key = $explode[1];
//        } else {
//            $langFile = $file_key;
//        }
//        if ($variables)
//            return Lang::get('languages::' . $langFile . '.' . $key, $variables);
//        return Lang::get('languages::' . $langFile . '.' . $key);
    }

    /**
     * Translates given row(most likely - header) of values. 
     * Each value needs to be delimited by translation separator.
     * @param type $row
     * @return type
     */
    public function translateRow($row) {
        foreach ($row as &$label) {
            $label = $this->translate($label);
        }
        return $row;
    }

    /**
     * Translates given array values with key label. 
     * Each value needs to be delimited by translation separator.
     * @param array $array
     * @return type
     */
    public function translateArray(array $array) {
        foreach ($array as $key => $value) {
            $array[$key]['label'] = $this->translate($value['label']);
        }

        return $array;
    }

    /**
     * Returns a translation of each array's element given
     * @param array $data
     * @return type
     */
    public function translateHeader($objectLabelType, array $data) {
        $header = array();

        foreach ($data as $key => $value) {
            $key = str_replace(self::translation_separator, '-', $key);
            $header[$key] = $this->translate($objectLabelType . self::translation_separator . $key);
        }

        return $header;
    }

    public function getTranslations() {
        $config = \Config::get('system.translations');
//        $translations = [];

        foreach ($config as $langFile) {
            $translations[$langFile] = Lang::get('languages::' . $langFile);
        }

        return $translations;
    }

}
