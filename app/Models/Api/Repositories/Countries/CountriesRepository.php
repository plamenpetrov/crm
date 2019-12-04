<?php

namespace App\Models\Api\Repositories\Countries;

use \App\Models\Api\Repositories\BaseRepository;
use App\Models\Api\Repositories\Countries\CountriesRepositoryInterface as CountriesRepositoryInterface;
use DB;

class CountriesRepository extends BaseRepository implements CountriesRepositoryInterface {

    public function __construct() {
        parent::__construct();
    }

     /**
     * Get Query Builder instance of all countries in DB
     * @return type
     */
    public function getCountries() {
        return DB::table('countries as c')
                ->select('c.id', 'ct.name as name')
                ->join('countries_translatable as ct', 'c.id', '=', 'ct.countries_id')
                ->where('c.status', self::ACTIVE)
                ->where('ct.lang', $this->langId)
                ->where('ct.state', self::CURRENT_STATE);
    }

}
