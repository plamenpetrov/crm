<?php

namespace App\Models\Api\Repositories\ContragentType;

use \App\Models\Api\Repositories\BaseRepository;
use App\Models\Api\Repositories\ContragentType\ContragentTypeRepositoryInterface as ContragentTypeRepositoryInterface;
use DB;
use ContragentType;

class ContragentTypeRepository extends BaseRepository implements ContragentTypeRepositoryInterface {

    protected $model;

    public function __construct(ContragentType $contragentType) {
        $this->model = $contragentType;
        parent::__construct();
    }

    /**
     * Get Query Builder instance of all contragent types in DB
     * @return type
     */
    public function getContragentTypes() {
        return DB::table('company_types as ct')
                        ->select('ct.id', 'ctt.name as name')
                        ->join('company_types_translation as ctt', 'ct.id', '=', 'ctt.company_types_id')
                        ->where('ct.status', self::ACTIVE)
                        ->where('ctt.lang', $this->langId);
    }

}
