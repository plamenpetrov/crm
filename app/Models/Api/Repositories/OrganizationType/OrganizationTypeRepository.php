<?php

namespace App\Models\Api\Repositories\OrganizationType;

use \App\Models\Api\Repositories\BaseRepository;
use App\Models\Api\Repositories\OrganizationType\OrganizationTypeRepositoryInterface as OrganizationTypeRepositoryInterface;
use DB;

class OrganizationTypeRepository extends BaseRepository implements OrganizationTypeRepositoryInterface {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get Query Builder instance of all organization types in DB
     * @return type
     */
    public function getOrganizationType() {
        return DB::table('company_organization_types as cot')
                ->select('cot.id', 'cott.name as name')
                ->join('company_organization_types_translation as cott', 'cot.id', '=', 'cott.company_organization_types_id')
                ->where('cot.status', self::ACTIVE)
                ->where('cott.lang', $this->langId);
    }

}
