<?php

namespace App\Models\Api\Repositories\ContragentOrganizationType;

use \App\Models\Api\Repositories\BaseRepository;
use App\Models\Api\Repositories\ContragentOrganizationType\ContragentOrganizationTypeRepositoryInterface as ContragentOrganizationTypeRepositoryInterface;
use DB;
use ContragentOrganizationType;

class ContragentOrganizationTypeRepository extends BaseRepository implements ContragentOrganizationTypeRepositoryInterface {

    protected $model;
    
    public function __construct(ContragentOrganizationType $contragentType) {
        $this->model = $contragentType;
        parent::__construct();
    }

    /**
     * Get Query Builder instance of all contragent organization types in DB
     * @return type
     */
    public function getContragentOrganizationTypes() {
        return DB::table('company_organization_types as ct')
                ->select('ct.id', 'ctt.name as name')
                ->join('company_organization_types_translation as ctt', 'ct.id', '=', 'ctt.company_organization_types_id')
                ->where('ct.status', self::ACTIVE)
                ->where('ctt.lang', $this->langId);
    }
    
}
