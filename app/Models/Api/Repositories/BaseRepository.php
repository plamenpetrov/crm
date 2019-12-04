<?php

namespace App\Models\Api\Repositories;

use Illuminate\Pagination\LengthAwarePaginator as LengthAwarePaginator;

abstract class BaseRepository {

    const HISTORY_STATE = 0;
    const CURRENT_STATE = 1;
    
    const ACTIVE = 1;
    const DELETED = 1;
    
    protected $langId;
    protected $now;


    public function __construct() {
        $this->langId = \SystemLanguage::getLanguage();
        $this->now = \Carbon\Carbon::now()->toDateTimeString();
    }
    
    public function paginateArray($data, $totalRows, $perPage, $page = null) {
        $paginator = new LengthAwarePaginator($data, $totalRows, $perPage);
        $rows = $paginator->toArray();

        $rows['per_page_options'] = 20; //\Config::get('pagination')['per_page_options'];

        return $rows;
    }
    
}
