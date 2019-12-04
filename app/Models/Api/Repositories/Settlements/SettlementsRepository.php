<?php

namespace App\Models\Api\Repositories\Settlements;

use \App\Models\Api\Repositories\BaseRepository;
use App\Models\Api\Repositories\Settlements\SettlementsRepositoryInterface as SettlementsRepositoryInterface;
use DB;

class SettlementsRepository extends BaseRepository implements SettlementsRepositoryInterface {

    const CITY = 1;
    const VILLAGE = 2;
    const MONASTERY = 3;
    const COMPLEX = 4;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getCityConstant() {
        return self::CITY;
    }

    public function getVillageConstant() {
        return self::VILLAGE;
    }
    
    /**
     * Get Query Builder instance of all settlements
     * @param type $id
     * @return type
     */
    public function getSettlements($id = self::CITY) {
        return DB::table('settlement_type_translation as astt')
                ->select('ads.id', DB::raw("concat(astt.name_short, ' ', adst.name) as name"))
                ->join('settlement as ads', 'ads.settlement_type_id', '=', 'astt.id')
                ->join('settlement_translation as adst', 'adst.settlement_id', '=', 'ads.id')
                ->where('astt.id', $id)
                ->where('adst.lang', $this->langId)
                ->where('ads.status', self::CURRENT_STATE);
    }

}
